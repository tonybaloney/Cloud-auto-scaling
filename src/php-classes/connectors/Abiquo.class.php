<?php
/**
 * Abiquo Class
 * PHP Requirements 
 * - PHP-CURL (for requesting API HTTP)
 * - PHP-PCRE (for preg_match)
 * - PHP-SIMPLEXML (for decoding XML responses)
 * @package auto-scaler
 */
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
	 * Create an instance of the Abiquo API object
	 * @param string $url URL of the Abiquo Server
	 * @param string $username Username for Abiquo
	 * @param string $password Password for Abiquo
	 * @return bool Success or failure on finding server and establishing a login 
	 * @access public
	 */
	public function Abiquo ( $url, $username, $password ) {
		// Format the server URL correctly
		if (substr($url,-1,1) != '/') $url.='/';
		$this->url = $url;
		$this->username = $username;
		$this->password = $password; 
		
		// Login to the server
		$this->Authenticate();
		
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
		$res = $this->HttpRequest( $this->url.'cloud/' , $opt ) ;
		
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
		$ch = curl_init($url);
		curl_setopt_array($ch, $opt);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec($ch);
		if ($result===false)
			throw new ConnectorException( $this, "Failure from cURL speaking to backend (".curl_error($ch).") on URL '$url' with options - ".var_export($opt,true),CEX_INVALID_API_RESPONSE);
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
	 * @return SimpleXML XML Object of the returned data
	 * @access private
	 */	 
	private function ApiRequest( $url, $accept ) {
		$opt = array( 
			CURLOPT_FAILONERROR => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HEADER => false,
			CURLOPT_HTTPHEADER => array('Accept:'.$accept),
			CURLOPT_COOKIE => 'auth='.$this->token.'; JSESSIONID='.$this->sessionid 
			);
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
		  $a[$sxi->key()][] = strval($sxi->current());
		}
	  }
	  return $a;
	}
	
	/**
	 * Get a list of VDCs in logged in Enterprise
	 * @return Object SimpleXML Object tree of the result
	 * @access public
	 */
	public function GetAbiquoVirtualDatacenters () {
		return $this->ApiRequest('cloud/virtualdatacenters','application/vnd.abiquo.datacenters+xml');
	}
	
	/**
	 * Get a VDC in logged in Enterprise	 
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @return Object SimpleXML Object tree of the result
	 * @access public
	 */
	public function GetAbiquoVirtualDatacenter ($id){
		return $this->ApiRequest("cloud/virtualdatacenters/$id/",'application/vnd.abiquo.virtualdatacenter+xml');
	}
	
	/**
	 * Get a list of Private Networks (VLANs) in this Enterprise
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @return Object SimpleXML Object tree of the result
	 * @access public
	 */
	public function GetAbiquoPrivateNetworks ($vdc_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/privatenetworks",'application/vnd.abiquo.vlans+xml');
	}
	
	/**
	 * Get a specific private network in this enterprise
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @param int $pn_id ID of the Private Network
	 * @return Object SimpleXML Object tree of the result
	 * @access public
	 */
	public function GetAbiquoPrivateNetwork ($vdc_id, $pn_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/privatenetworks/$pn_id",'application/vnd.abiquo.vlan+xml');
	}
	
	public function CreateAbiquoVirtualAppliance ($vdc_id, $vapp_name){
		"<virtualAppliance><name>$vapp_name</name></virtualAppliance>";
	}
	
	/**
	 * Get a list of Virtual Appliances in this Enterprise
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @return Object SimpleXML Object tree of the result
	 * @access public
	 */
	public function GetAbiquoVirtualAppliances ($vdc_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances",'application/vnd.abiquo.virtualappliances+xml');
	}
	
	/**
	 * Get a Virtual Appliance in this Enterprise
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @param int $vapp_id ID of the Virtual Appliance
	 * @return Object SimpleXML Object tree of the result
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
				$results[] = array ('networkId'=>$vdc['id'][0], 'networkName' => $vdc['name'][0]);
			}
		}
		return $results;
	}
}
