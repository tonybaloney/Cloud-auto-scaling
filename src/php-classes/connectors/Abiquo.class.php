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
				foreach ($vdcs['virtualDatacenter'][0]['link'] as $link){
					if ($link['rel'] == 'enterprise') {
						$parts = explode('/',$link['href']);
						$enterpriseId = $parts[count($parts)-1];
						$this->enterpriseId;
					}
				}
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
			CURLOPT_USERPWD => $this->username.':'.$this->password
			);

		$res = $this->HttpRequest( $this->url.'cloud/virtualdatacenters' , $opt ) ;
		
		// TODO: Read headers to establish version.
		$this->abiquo_version = 2; 
		
		// There's probably an easier way of doing this!
		$pattern  = "/Set-Cookie:(?P<name>.*?)=(?P<value>.*?); expires=(?P<expiry_dayname>\w+), (?P<expiry_day>\d+)-(?P<expiry_month>\w+)-(?P<expiry_year>\d+) (?P<expiry_hour>\d+):(?P<expiry_minute>\d+):(?P<expiry_second>\d+) (?P<expiry_zone>\w+)/";
		preg_match_all($pattern,$res,$matches);
		$i=0;
		foreach($matches['name'] as $cookie_name)
		{
			if ($cookie_name == 'auth')
				$this->token = $matches['values'][$i];
			if ($cookie_name == 'JSESSIONID')
				$this->sessionid = $matches['values'][$i];
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
			throw new ConnectorException( $this, "Failure from cURL speaking to backend, curl error-".curl_errno()." (".curl_error($ch).") on URL '$url' with options - ".var_export($opt,true),CEX_INVALID_API_RESPONSE);
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
	 * Request to the API, expect XML back and format into assoc array and return 
	 * @param string $url URI to request (will be appended to the address of the API)
	 * @param string $accept The ACCEPT: header for HTTP request
	 * @param array $extraOpt Additional options for CURL
	 * @return Array of the returned data
	 * @access private
	 */	 
	private function ApiRequest( $url, $accept, $extraOpt = false ) {
		$opt = array( 
			CURLOPT_FAILONERROR => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HEADER => false,
			CURLOPT_HTTPHEADER => array('Accept:'.$accept),
			CURLOPT_COOKIE => 'auth='.$this->token.'; JSESSIONID='.$this->sessionid 
			);
		if ($extraOpt)
			$opt = array_merge($opt,$extraOpt);
		$res = $this->HttpRequest ($this->url.$url, $opt);
		if ($res){
			$array = $this->xml2array($res);
			if (!is_array($array)){
				throw new ConnectorException( $this, "Backend did not return valid XML (".var_export($xml, true).")",CEX_INVALID_API_RESPONSE);
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
	private function ApiPOSTRequest( $url, $accept, $message ) {
		$opt = array( 
			CURLOPT_CUSTOMREQUEST => 'POST',
			CURLOPT_POSTFIELDS => $message
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
	 * @access public
	 */
	public function GetAbiquoVirtualDatacenters () {
		return $this->ApiRequest('cloud/virtualdatacenters','application/vnd.abiquo.datacenters+xml');
	}
	
	/**
	 * Get a VDC in logged in Enterprise	 
	 * @param int $id ID of the Virtual Data Center
	 * @return Array Object tree of the result
	 * @access public
	 */
	public function GetAbiquoVirtualDatacenter ($id){
		return $this->ApiRequest("cloud/virtualdatacenters/$id/",'application/vnd.abiquo.virtualdatacenter+xml');
	}
	
	/**
	 * Get a list of Private Networks (VLANs) in this Enterprise
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @return Array Object tree of the result
	 * @access public
	 */
	public function GetAbiquoPrivateNetworks ($vdc_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/privatenetworks",'application/vnd.abiquo.vlans+xml');
	}
	
	/**
	 * Get a specific private network in this enterprise
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @param int $pn_id ID of the Private Network
	 * @return Array Object tree of the result
	 * @access public
	 */
	public function GetAbiquoPrivateNetwork ($vdc_id, $pn_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/privatenetworks/$pn_id",'application/vnd.abiquo.vlan+xml');
	}
	
	/**
	 * Get a list of Virtual Appliances in this Enterprise
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @return Array Object tree of the result
	 * @access public
	 */
	public function GetAbiquoVirtualAppliances ($vdc_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances",'application/vnd.abiquo.virtualappliances+xml');
	}
	
	/**
	 * Get a Virtual Appliance in this Enterprise
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @param int $vapp_id ID of the Virtual Appliance
	 * @return Array Object tree of the result
	 * @access public
	 */
	public function GetAbiquoVirtualAppliance ($vdc_id,$vapp_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances/$vapp_id",'application/vnd.abiquo.virtualappliance+xml');
	}

	/**
	 * Get a list of IPs used in a specified Virtual Appliance
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @param int $vapp_id ID of the Virtual Appliance
	 * @return Object SimpleXML Object tree of the result
	 * @access public
	 */
	public function GetAbiquoIPsUsedInVirtualAppliance ($vdc_id, $vapp_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances/$vapp_id/action/ips",'application/vnd.abiquo.ip+xml');
	}
	
	/**
	 * Get a list of Virtual Machines in a specified Virtual Appliance
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @param int $vapp_id ID of the Virtual Appliance
	 * @return Object SimpleXML Object tree of the result
	 * @access public
	 */
	public function GetAbiquoVirtualMachines($vdc_id,$vapp_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances/$vapp_id/virtualmachines",'application/vnd.abiquo.virtualmachines+xml');
	}
	
	/**
	 * Get a Virtual Machine in this VDC/VAPP
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @param int $vapp_id ID of the Virtual Appliance
	 * @param int $vm_id ID of the Virtual Machine
	 * @return Object SimpleXML Object tree of the result
	 * @access public
	 */
	public function GetAbiquoVirtualMachine($vdc_id,$vapp_id,$vm_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances/$vapp_id/virtualmachines/$vm_id",'application/vnd.abiquo.virtualmachine+xml');
	}
	
	/**
	 * Get a Virtual Machine Networks in this VDC/VAPP
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @param int $vapp_id ID of the Virtual Appliance
	 * @param int $vm_id ID of the Virtual Machine
	 * @return Object SimpleXML Object tree of the result
	 * @access public
	 */
	public function GetAbiquoVirtualMachineNetworks($vdc_id,$vapp_id,$vm_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances/$vapp_id/virtualmachines/$vm_id/network/configurations",'application/vnd.abiquo.nics+xml');
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
		return ($this->ApiRequest('cloud/')!=false);
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
			print_r($vdcs);
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
	 * @param string $templateUrl The REST URL to create the VM from
	 **/
	public function CreateVM ( $clusterLocation, $targetApplianceId, $targetVlanId, $templateUrl ) {
		// Get the Virtual Data Center
		$request = "<virtualMachine><link href=\"".$templateUrl."\" rel=\"virtualmachinetemplate\" title=\"Nostalgia\"/></virtualMachine>";
		$vm = $this->ApiPOSTRequest("cloud/virtualdatacenters/$clusterLocation/virtualappliances/$targetApplianceId/virtualmachines",'application/vnd.abiquo.virtualmachine+xml',$request);
		print_r($vm);
		// @todo establish VM ID
		$vm = 1;
		$this->ApiRequest("cloud/virtualdatacenters/$clusterLocation/virtualappliances/$targetApplianceId/virtualmachines/$vmId/action/deploy",'application/vnd.abiquo.acceptedrequest+xml');
	}
	
	/**
	 * Destroy the next VM in a cluster
	 * @access public
	 * @param int $clusterLocation The ID of the cluster location
	 * @param int $targetApplianceId The ID of the target virtual appliance
	 * @param string $vmPrefix The prefix for Virtual Machines.
	 **/
	public function DestroyNextVM ( $clusterLocation, $targetApplianceId, $vmPrefix ) {
	
	}
}
