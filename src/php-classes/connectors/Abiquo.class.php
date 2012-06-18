<?php
/** 
  * Abiquo Class
  * PHP Requirements 
  * - PHP-CURL (for requesting API HTTP)
  * - PHP-PCRE (for preg_match)
  * - PHP-SIMPLEXML (for decoding XML responses)
  * @copyright Anthony Shaw, 2012
  * @license LGPL
  * @license http://www.gnu.org/licenses/lgpl.txt GNU Lesser General Public License
  * @package auto-scaler
  **/

/**
 * Class for talking to the Abiquo API, added support for Abiquo v2 as well, combined to the same class.
 * Usage :
 * $a= new Abiquo('http://example.com/api','user','password');
 * $a->GetVirtualDatacenters();
 * @package auto-scaler
 */
class Abiquo implements Connector{ 
	/**
	 * URL of the API to abiquo, must point to the root (/api/)
	 * @var string
	 * @access private
	 */
	private $url; 
	
	/** 
	 * Version number of Abiquo
	 * @var int
	 * @access private
	 **/
	private $abiquo_version;
	
	/**
	 * Abiquo username (normally in email format)
	 * @var string
	 * @access private
	 */
	private $username;
	
	/**
	 * Abiquo password
	 * @var string
	 * @access private
	 */
	private $password;
	
	/**
	 * Basic authentication token returned in response cookie
	 * @var string
	 * @access private
	 */
	private $token;
	
	/**
	 * JSESSION ID returned from abiquo API server after successful,
	 * authenticated request
	 * @var string
	 * @access private
	 */
	private $sessionid;

	/** 
	 * The Abiquo Enterprise ID of this user
	 * @var int
	 * @access private
	 **/
	private $enterpriseId;
	
	/** 
	 * Debug mode prints the requests and responses to the screen (in HTML)
	 * @var bool
	 * @access private
	 **/
	private $debugMode;
	
	/**
	 * Create an instance of the Abiquo API object
	 * @param string $url URL of the Abiquo Server
	 * @param string $username Username for Abiquo
	 * @param string $password Password for Abiquo
	 * @param bool $debugMode Print the API calls to stdout
	 * @return bool Success or failure on finding server and establishing a login 
	 * @throws ConnectorException
	 * @access public
	 */
	public function Abiquo ( $url, $username, $password, $debugMode = false ) {
		$this->debugMode = $debugMode;
		// Format the server URL correctly
		if (substr($url,-1,1) != '/') $url.='/';
		$this->url = $url;
		$this->username = $username;
		$this->password = $password; 
		
		// Login to the server
		$this->Authenticate();
		
		// Get the virtual data centers page and establish the Enterprise ID
		$vdcs = $this->GetAbiquoVirtualDatacenters();
		if (is_array($vdcs)){
			if (is_array($vdcs['virtualDatacenter'][0]['link'])){
				$link = $this->FindRel($vdcs['virtualDatacenter'][0]['link'],'enterprise');
				$parts = explode('/',$link['href']);
				$this->enterpriseId = $parts[count($parts)-1];
			} else {
				throw new ConnectorException( $this, "Could not establish Enterprise ID from API response.",CEX_INVALID_API_RESPONSE);
			}
		} else { 
			throw new ConnectorException( $this, "Could not establish Enterprise ID from API response.",CEX_INVALID_API_RESPONSE);
		}
		// Return success or failure
		return ($this->token);
	}
	
	/**
	 * Login to the abiquo server, get the auth token and session (jsession) id
	 * Store these in the class for later API calls.
	 * @return bool Success or failure on finding server and establishing a login 
	 * @access private
	 */
	private function Authenticate (){
		$opt = array( 
			CURLOPT_FAILONERROR => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HEADER => true,
			CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
			CURLOPT_HTTPHEADER => array('Accept: application/vnd.abiquo.virtualdatacenters+xml; version=2.0'),
			CURLOPT_USERPWD => $this->username.':'.$this->password
			);

		$res = $this->HttpRequest( $this->url.'cloud/virtualdatacenters/' , $opt ) ;
		
		// TODO: Read headers to establish version.
		$this->abiquo_version = 2; 
		
		// There's probably an easier way of doing this!
		$pattern  = "/Set-Cookie:(?P<name>.*?)=(?P<value>.*?); .*/";
		preg_match_all($pattern,$res,$matches);
		$i=0;
		foreach($matches['name'] as $cookie_name)
		{
			$cookie_name = trim($cookie_name);
			if ($cookie_name == 'auth')
				$this->token = $matches['value'][$i];
			if ($cookie_name == 'JSESSIONID') 
				$this->sessionid = $matches['value'][$i];
			$i++;
		}
		return ($this->token && $this->sessionid);
	}
	
	/** 
	 * Execute a HTTP request using CURL
	 * @param string $url HTTP URI
	 * @param array $opt List of CURL options <link>http://uk3.php.net/manual/en/function.curl-setopt.php</link>
	 * @return string|bool Response of the CURL request, false on failure, string on success
	 * @access private
	 */
	private function HttpRequest ( $url, $opt ) { 
		if ($this->debugMode){
			echo "<table border=1>";
			echo "<tr><td colspan=2><h2>Abiquo API Request</h2></td></tr>";
			echo "<tr><td>URI</td><td>".$url."</td></tr>";
			echo "<tr><td>HTTP Parameters</td><td>".var_export($opt,true)."</td></tr>";
		}
		$ch = curl_init($url);
		curl_setopt_array($ch, $opt);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		if ($result===false)
			throw new ConnectorException( $this, "Failure from cURL speaking to backend, curl error-".curl_errno($ch)." (".curl_error($ch).") on URL '$url' with options - ".var_export($opt,true)."\n Got result: ".$result,CEX_INVALID_API_RESPONSE);
		if ($this->debugMode){
			echo "<tr><td>Result</td><td><pre>".htmlspecialchars($result)."</pre></td></tr>";
			echo "</table>";
		}
		curl_close($ch);
		return $result;
	}
	
	/**
	 * Sanitise a string for XML input (remove < and > characters)
	 * @param string $s Input string
	 * @return string The sanitised string.
	 * @access private
	 */
	private function SanitiseForXML ( $s ) {
		return str_replace (str_replace($s,'>','&gt;'), '<','&lt;');
	}
	
	/**
	 * In an array of 'links' from a REST API response, find the link with the specified rel 
	 * @param array $link_list the array of links
	 * @param string $rel the rel
	 * @return array The link
	 * @access private
	 **/
	private function FindRel( $link_list, $rel ) {
		foreach ($link_list as $link){
			if ($link['rel']==$rel) 
				return $link; 
		}
		return false;
	}
	
	/** 
	 * Request to the API, expect XML back and format into assoc array and return 
	 * @param string $url URI to request (will be appended to the address of the API)
	 * @param string $accept The ACCEPT: header for HTTP request
	 * @param array $extraOpt Additional options for CURL
	 * @return Array of the returned data
	 * @access private
	 */	 
	private function ApiRequest( $url, $accept, $extraOpt = false ) {
		$opt = array( 
			CURLOPT_FAILONERROR => false,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HEADER => false,
			CURLOPT_HTTPHEADER => array('Accept:'.$accept),
			CURLOPT_COOKIE => 'auth='.$this->token.'; JSESSIONID='.$this->sessionid 
			);
		if ($extraOpt)
			$opt = $extraOpt;
		$res = $this->HttpRequest ($this->url.$url, $opt);
		if ($res){
			$array = $this->xml2array($res);
			if (!is_array($array)){
				throw new ConnectorException( $this, "Backend did not return valid XML (".var_export($xml, true).")",CEX_INVALID_API_RESPONSE);
			}
			if ( isset($array['error']) ) {
				throw new ConnectorException( $this, "Abiquo returned an error message : '".$array['error'][0]['message'][0]."'",CEX_INVALID_API_RESPONSE);
			}
			return $array;
		} else {
			throw new ConnectorException( $this, "Backend did not return valid result (".var_export(true).")",CEX_INVALID_API_RESPONSE);
		}
	}
	
	/** 
	 * Request to the API, expect XML back and format into assoc array and return 
	 * @param string $url URI to request (will be appended to the address of the API)
	 * @param string $accept The ACCEPT: header for HTTP request
	 * @param string $message The XML message for the API
	 * @return Array Object of the returned data
	 * @access private
	 */	 
	private function ApiPOSTRequest( $url, $accept, $message, $content_type ) {
		$opt = array(
			CURLOPT_FAILONERROR => false,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_COOKIE => 'auth='.$this->token.'; JSESSIONID='.$this->sessionid,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => "$message",
			CURLOPT_HTTPHEADER => array('Accept: '.$accept,'Content-Type: '.$content_type)
		);
		return $this->ApiRequest($url, $accept, $opt);
	}
	
	/** 
	 * Request to the API, expect XML back and format into assoc array and return 
	 * @param string $url URI to request (will be appended to the address of the API)
	 * @param string $accept The ACCEPT: header for HTTP request
	 * @param string $message The XML message for the API
	 * @param string $content_type the Content-Type header in the HTTP request
	 * @return Array Object of the returned data
	 * @access private
	 */	 
	private function ApiSpecialRequest( $url, $accept, $message, $content_type, $http_method ) {
		$opt = array( 
			CURLOPT_FAILONERROR => false,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_COOKIE => 'auth='.$this->token.'; JSESSIONID='.$this->sessionid,
			CURLOPT_CUSTOMREQUEST => $http_method,
			CURLOPT_POSTFIELDS => "$message",
			CURLOPT_HTTPHEADER => array('Accept:'.$accept,'Content-Type:'.$content_type)
		);
		return $this->ApiRequest($url, $accept, $opt);
	}
	
	/** 
	 * Convert an XML string into an associative array
	 * @param string $xml XML String
	 * @return Array
	 * @access private
	 **/
	private function xml2array($xml){
	  $sxi = new SimpleXmlIterator($xml);
	  return $this->sxiToArray($sxi);
	}
	
	/**
	 * Convert a SimpleXMLIterator to an associative array
	 * TODO: Carry XML element attributes into the structure
	 * @param SimpleXMLIterator Object
	 * @return Array
	 * @access private
	 **/
	private function sxiToArray($sxi){
	  $a = array();
	  for( $sxi->rewind(); $sxi->valid(); $sxi->next() ) {
		if(!array_key_exists($sxi->key(), $a)){
		  $a[$sxi->key()] = array();
		}
		if($sxi->hasChildren()){
		  $a[$sxi->key()][] = $this->sxiToArray($sxi->current());
		}
		else{
			$attr=array();
			foreach($sxi->current()->attributes() as $key => $val) {
				$attr[$key]=strval($val);
			}
			if (count($attr)>0)
				$a[$sxi->key()][] = array_merge($attr,array('value'=>strval($sxi->current())));
			else
				$a[$sxi->key()][] = strval($sxi->current());
		}
	  }
	  return $a;
	}
	
	/**
	 * Get a list of VDCs in logged in Enterprise
	 * @return Array Object tree of the result
	 * @access private
	 */
	private function GetAbiquoVirtualDatacenters () {
		return $this->ApiRequest('cloud/virtualdatacenters','application/vnd.abiquo.virtualdatacenters+xml');
	}
	
	/**
	 * Get a VDC in logged in Enterprise	 
	 * @param int $id ID of the Virtual Data Center
	 * @return Array Object tree of the result
	 * @access private
	 */
	private function GetAbiquoVirtualDatacenter ($id){
		return $this->ApiRequest("cloud/virtualdatacenters/$id/",'application/vnd.abiquo.virtualdatacenter+xml');
	}
	
	/**
	 * Get a list of Private Networks (VLANs) in this Enterprise
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @return Array Object tree of the result
	 * @access private
	 */
	private function GetAbiquoPrivateNetworks ($vdc_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/privatenetworks",'application/vnd.abiquo.vlans+xml');
	}
	
	/**
	 * Get the IP's of a Private Network
	 * @param int $vdc_id The ID of the Virtual Data Center
	 * @param int $network_id The ID of the Private Network
	 * @param bool $free Only search for available IPs
	 * @access private
	 * @return Array array of IPs ('id','ip','name','mac','link')
	 **/
	public function GetAbiquoPrivateNetworkIps ($vdc_id,$network_id,$free=false){
		$free = ($free?'true':'false'); // bool->string
		$result = $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/privatenetworks/$network_id/ips?free=$free",'application/vnd.abiquo.ips+xml;version=2.0');
		$results=array();
		if (is_array($result)){
			foreach ($result['ip'] as $ip) {
				$results[] = array (
					'id'=>$ip['id'][0], 
					'ip'=>$ip['mac'][0],
					'name'=>$ip['name'][0],
					'mac'=>$ip['mac'][0],
					'type'=>'privateip',
					'link'=>$this->url."cloud/virtualdatacenters/$vdc_id/privatenetworks/$network_id/ips/".$ip['id'][0]
					);
			}
		} else {
			throw new ConnectorException($this, "IP listing was not a valid response.",CEX_INVALID_API_RESPONSE);
		}
		return $results;
	}
	
	/**
	 * Set the IPs for a Virtual Machine
	 * http://wiki.abiquo.com/display/ABI20/VirtualMachineNetworkConfiguration#VirtualMachineNetworkConfiguration-ChangetheassociatedIPs
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @param int $vapp_id ID of the Virtual Appliance
	 * @param int $vm_id ID of the Virtual Machine
	 * @param array $ips The Array of IPs from GetAbiquoPrivateNetworkIps
	 * @return Array assoc array of the response
	 * @access private
	 **/
	private function SetVMIPs ( $vdc_id, $vapp_id, $vm_id, $ips ) {
       $request = '<links>';
	   foreach ($ips as $ip)
               $request .= "<link rel=\"$ip[type]\" href=\"$ip[link]\"/>";
       $request .= '</links>';
	   return $this->ApiSpecialRequest ("cloud/virtualdatacenters/$vdc_id/virtualappliances/$vapp_id/virtualmachines/$vm_id/network/nics",'application/vnd.abiquo.acceptedrequest+xml; version=2.0;',$request,'application/vnd.abiquo.links+xml; version=2.0;','PUT');
	}
	
	/**
	 * Get a specific private network in this enterprise
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @param int $pn_id ID of the Private Network
	 * @return Array Object tree of the result
	 * @access private
	 */
	private function GetAbiquoPrivateNetwork ($vdc_id, $pn_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/privatenetworks/$pn_id",'application/vnd.abiquo.vlan+xml');
	}
	
	/**
	 * Get a list of Virtual Appliances in this Enterprise
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @return Array Object tree of the result
	 * @access private
	 */
	private function GetAbiquoVirtualAppliances ($vdc_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances",'application/vnd.abiquo.virtualappliances+xml');
	}
	
	/**
	 * Get a Virtual Appliance in this Enterprise
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @param int $vapp_id ID of the Virtual Appliance
	 * @return Array Object tree of the result
	 * @access private
	 */
	private function GetAbiquoVirtualAppliance ($vdc_id,$vapp_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances/$vapp_id",'application/vnd.abiquo.virtualappliance+xml');
	}

	/**
	 * Get a list of IPs used in a specified Virtual Appliance
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @param int $vapp_id ID of the Virtual Appliance
	 * @return Array Object tree of the result
	 * @access private
	 */
	private function GetAbiquoIPsUsedInVirtualAppliance ($vdc_id, $vapp_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances/$vapp_id/action/ips",'application/vnd.abiquo.ip+xml');
	}
	
	/**
	 * Get a list of Virtual Machines in a specified Virtual Appliance
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @param int $vapp_id ID of the Virtual Appliance
	 * @return Array Object tree of the result
	 * @access private
	 */
	private function GetAbiquoVirtualMachines($vdc_id,$vapp_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances/$vapp_id/virtualmachines",'application/vnd.abiquo.virtualmachines+xml');
	}
	
	/**
	 * Get a Virtual Machine in this VDC/VAPP
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @param int $vapp_id ID of the Virtual Appliance
	 * @param int $vm_id ID of the Virtual Machine
	 * @return Array Object tree of the result
	 * @access private
	 */
	private function GetAbiquoVirtualMachine($vdc_id,$vapp_id,$vm_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances/$vapp_id/virtualmachines/$vm_id",'application/vnd.abiquo.virtualmachine+xml');
	}
	
	/**
	 * deploy a Virtual Machine in this VDC/VAPP
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @param int $vapp_id ID of the Virtual Appliance
	 * @param int $vm_id ID of the Virtual Machine
	 * @return Array
	 * @access private
	 */
	private function DeployAbiquoVirtualMachine($vdc_id,$vapp_id,$vm_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances/$vapp_id/virtualmachines/$vm_id/deploy",'application/vnd.abiquo.acceptedrequest+xml');
	}
	
	/**
	 * Undeploy a Virtual Machine in this VDC/VAPP
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @param int $vapp_id ID of the Virtual Appliance
	 * @param int $vm_id ID of the Virtual Machine
	 * @return Array
	 * @access private
	 */
	private function UndeployAbiquoVirtualMachine($vdc_id,$vapp_id,$vm_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances/$vapp_id/virtualmachines/$vm_id/undeploy",'application/vnd.abiquo.acceptedrequest+xml');
	}
	
	/**
	 * Get a Virtual Machine Networks in this VDC/VAPP
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @param int $vapp_id ID of the Virtual Appliance
	 * @param int $vm_id ID of the Virtual Machine
	 * @return Array Object tree of the result
	 * @access private
	 */
	private function GetAbiquoVirtualMachineNetworks($vdc_id,$vapp_id,$vm_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances/$vapp_id/virtualmachines/$vm_id/network/nics",'application/vnd.abiquo.nics+xml');
	}
	
	/**
	 * Get a list of templates from Abiquo for this enterprise
	 * @access private
	 * @return array of response
	 **/
	private function GetAbiquoEnterpriseTemplates () {
		return $this->ApiRequest("admin/enterprises/$this->enterpriseId/appslib/templateDefinitions",'application/vnd.abiquo.templatedefinitions+xml');
	}
	
	/**
	 * Get a list of templates from the datacenter repository for this enterprise 
	 * @access private
	 * @return array of response
	 **/
	private function GetAbiquoDatacenterTemplates($dc_id){
		return $this->ApiRequest("admin/enterprises/$this->enterpriseId/datacenterrepositories/$dc_id/virtualmachinetemplates",'application/vnd.abiquo.virtualmachinetemplates+xml');
	}
	
	/**
	 * Get the datacenter ID for the given VDC ID
	 * @param int $vdc_id Virtual Data center ID
	 * @return int datacenter ID
	 * @access private
	 **/
	private function GetVirtualDatacenterDatacenterID($vdc_id){
		$vdc = $this->GetAbiquoVirtualDatacenter($vdc_id);
		$link = $this->FindRel($vdc['link'],'datacenter');
		$parts = explode('/',$link['href']);
		return $parts[count($parts)-1];
	}
	
	/**
	 * Create an instance (snapshot) of a vm
	 * @param int $vdc_id the ID of the virtual data center
	 * @param int $vapp_id the Id of the virtual appliance
	 * @param int $vm_id The ID of the VM
	 * @param string $snapshot_name the name of the snapshot
	 * @access public
	 **/
	public function AbiquoSnapshotVm($vdc_id, $vapp_id, $vm_id, $snapshot_name ) {
		$accept = "application/vnd.abiquo.acceptedrequest+xml; version=2.0;";
		$type = "application/vnd.abiquo.virtualmachineinstance+xml; version=2.0;";
		$message = "<virtualmachineinstance><instanceName>".$this->SanitiseForXML($snapshot_name)."</instanceName></virtualmachineinstance>";
		return $this->ApiPOSTRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances/$vapp_id/virtualmachines/$vm_id/action/instance",$accept,$message,$type ) ;
	}
	
	/** 
	 * delete a template
	 * @param int $repo_id the id of the datacenter repository
	 * @param int $template_id the id of the template
	 **/
	public function AbiquoDeleteTemplate($repo_id,$template_id){
		$url = "admin/enterprises/$this->enterpriseId/datacenterrepositories/$repo_id/virtualmachinetemplates/$template_id";
		$this->ApiSpecialRequest($url,"","","","DELETE");
	}
	
	/**
	 ** Section: Interface implementations
	 **/
	 
	 /** 
	 * Test connection to the cloud provider
	 * @return bool Connection successful
	 * @access public
	 **/
	public function TestConnection() { 
		return ($this->ApiRequest('cloud/','application/xml')!=false);
	}
	
	/**
	 * Get a list of locations, for multi-regional cloud platforms.
	 * @return array List of locations (Key-Value pair array)
	 * @access public
	 **/
	public function GetLocations () { 
		$vdcs = $this->GetAbiquoVirtualDatacenters();
		$results=array();
		if (is_array($vdcs)){
			foreach ($vdcs['virtualDatacenter'] as $vdc) {
				$results[] = array ('clusterLocation'=>$vdc['id'][0], 'locationName' => $vdc['name'][0]);
			}
		}
		return $results;
	}
	
	/**
	 * Get a list of private networks
	 * @param int $location Location ID
	 * @return array List of private networks 
	 * @access public
	 **/
	public function GetPrivateNetworks ($location) { 
		$vdcs = $this->GetAbiquoPrivateNetworks($location);
		$results=array();
		if (is_array($vdcs)){
			foreach ($vdcs['network'] as $vdc) {
				$results[] = array (
					'networkId'=>$vdc['id'][0], 
					'networkName' => $vdc['name'][0], 
					'networkAddress' => $vdc['address'][0], 
					'networkMask' => $vdc['mask'][0], 
					'networkGateway' => $vdc['gateway'][0],
					'networkDescription' => $vdc['name'][0]." (".$vdc['address'][0]."/".$vdc['mask'][0].")"
				);
			}
		}
		return $results;
	}
	
	/**
	 * Get a list of VM Groups/Appliances
	 * @param int $location Location ID
	 * @return array List of appliances 
	 * @access public
	 **/
	public function GetAppliances ($location) { 
		$vdcs = $this->GetAbiquoVirtualAppliances($location);
		$results=array();
		if (is_array($vdcs)){
			foreach ($vdcs['virtualAppliance'] as $vdc) {
				$results[] = array (
					'applianceId'=>$vdc['id'][0],
					'applianceName'=>$vdc['name'][0],
					'applianceState'=>$vdc['state'][0]
				);
			}
		}
		return $results;
	}
	
	/**
	 * Get a list of private networks
	 * @param int $location Location ID
	 * @param int $networkId Private Network ID
	 * @return array List of private networks 
	 * @access public
	 **/
	public function GetPrivateNetwork ($location, $networkId) {
		$vdcs = $this->GetAbiquoPrivateNetwork($location,$networkId);
		$results=array();
		if (is_array($vdcs)){
			foreach ($vdcs['network'] as $vdc) {
				$results[] = array (
					'networkId'=>$vdc['id'][0], 
					'networkName' => $vdc['name'][0], 
					'networkAddress' => $vdc['address'][0], 
					'networkMask' => $vdc['mask'][0], 
					'networkGateway' => $vdc['gateway'][0],
					'networkDescription' => $vdc['name'][0]." (".$vdc['address'][0]."/".$vdc['mask'][0].")"
				);
			}
		}
		return $results;
	}
	
	/**
	 * Get a list of VM s
	 * @param int $location Location ID
	 * @param int $appliance Appliance ID
	 * @return array List of virtual machines.
	 * @access public
	 **/
	public function GetVirtualMachines ($location, $appliance) {
		$vdcs = $this->GetAbiquoVirtualMachines($location,$appliance);
		$results=array();
		if (is_array($vdcs)){
			foreach ($vdcs['virtualMachine'] as $vdc) {
				$results[] = array (
					'vmId'=>$vdc['id'][0],
					'vmName'=>$vdc['name'][0],
					'vmState'=>$vdc['state'][0]
				);
			}
		}
		return $results;
	}
	
	/**
	 * Get a list of VM s
	 * @param int $location Location ID
	 * @param int $appliance Appliance ID
	 * @param int $virtualMachine VM ID
	 * @return array List of NICS.
	 * @access public
	 **/
	public function GetVirtualMachineNetworks ($location, $appliance, $virtualMachine){
		$vdcs = $this->GetAbiquoVirtualMachineNetworks($location,$appliance,$virtualMachine);
		$results=array();
		if (is_array($vdcs)){
			foreach ($vdcs['nic'] as $vdc) {
				$results[] = array (
					'nicId'=>$vdc['id'][0],
					'nicIP'=>$vdc['ip'][0],
					'nicMac'=>$vdc['mac'][0]
				);
			}
		}
		return $results;
	}
	
	/**
	 * Create a VM
	 * @access public
	 * @param int $clusterLocation The ID of the cluster location
	 * @param int $targetApplianceId The ID of the target virtual appliance
	 * @param int $targetVlanId The ID of the target VLAN
	 * @param int $targetSecondaryVlanId The ID of the target secondary VLAN
	 * @param string $templateUrl The REST URL to create the VM from
	 * @param string $vmname The name of the new VM.
	 **/
	public function CreateVM ( $clusterLocation, $targetApplianceId, $targetVlanId, $targetSecondaryVlanId, $templateUrl, $vmname ) {
		// Get the Virtual Data Center
		$request = "<virtualMachine><link href=\"".$templateUrl."\" rel=\"virtualmachinetemplate\" title=\"$vmname\"/></virtualMachine>";
		echo $request;
		$vm = $this->ApiPOSTRequest("cloud/virtualdatacenters/$clusterLocation/virtualappliances/$targetApplianceId/virtualmachines",'application/vnd.abiquo.virtualmachine+xml',$request,'application/vnd.abiquo.virtualmachine+xml;version=2.0');
		if (!$vm) throw new ConnectorException($this, 'Failed to create VM', CEX_INVALID_API_RESPONSE);
		$vmId = $vm['id'][0];
		// Add NICS
		$ips = array();
		if ($targetVlanId){
			$primary_ips = $this->GetAbiquoPrivateNetworkIPs($clusterLocation,$targetVlanId,true);
			if (count($primary_ips) == 0) 
				throw new ConnectorException( $this, "VLAN is out of available IPs ($targetVlanId)",CEX_INVALID_API_RESPONSE);
			$ips[] = $primary_ips[0];
		}
		if ($targetSecondaryVlanId){
			$secondary_ips = $this->GetAbiquoPrivateNetworkIPs($clusterLocation,$targetSecondaryVlanId,true);
			if (count($secondary_ips) == 0) 
				throw new ConnectorException( $this, "Secondary VLAN is out of available IPs ($targetSecondaryVlanId)",CEX_INVALID_API_RESPONSE);
			$ips[] = $secondary_ips[0];
		}
		$this->SetVMIPs ( $clusterLocation, $targetApplianceId, $vmId, $ips ) ; 
		// Deploy machine
		$this->DeployAbiquoVirtualMachine($clusterLocation,$targetApplianceId,$vmId);
	}
	
	/**
	 * Destroy the next VM in a cluster
	 * @access public
	 * @param int $clusterLocation The ID of the cluster location
	 * @param int $targetApplianceId The ID of the target virtual appliance
	 * @param string $vmPrefix The prefix for Virtual Machines.
	 **/
	public function DestroyNextVM ( $clusterLocation, $targetApplianceId, $vmPrefix ) {
		$vms = $this->GetVirtualMachines($clusterLocation,$targetApplianceId);
		$undeploy=false;
		foreach ($vms as $vm){
			// TODO: Check time stamp of VM is >55mins
			if ((substr($vm['vmName'],0,strlen($vmPrefix))==$vmPrefix) && !$undeploy) { 
				$this->UndeployAbiquoVirtualMachine($clusterLocation,$targetApplianceId,$vm['vmId'][0]);
				$undeploy=true;
			}
		}
		if(!$undeploy)
			throw new ConnectorException($this,'Could not find any target VM\'s to undeploy.',CEX_NO_TARGET_VM);
	}
	
	/**
	 * Get the templates for this enterprise
	 * @access public 
	 **/
	public function GetTemplates ( $location_id	){
		$dc_id = $this->GetVirtualDatacenterDatacenterID($location_id);
		$templ = $this->GetAbiquoDatacenterTemplates($dc_id);
		$results=array();
		if (is_array($templ)){
			foreach ($templ['virtualMachineTemplate'] as $template) {
				$url_link = $this->FindRel($template['link'],'edit');
				$results[] = array (
					'id' => $template['id'][0],
					'repoId' => $dc_id,
					'name' => $template['name'][0],
					'creationDate' => $template['creationDate'][0],
					'description' => $template['description'][0],
					'url' => $url_link['href'],
					'icon' => $template['iconUrl'][0]
					);
			}
		}
		return $results;
	}
}
