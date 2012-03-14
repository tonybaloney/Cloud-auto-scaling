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
 * Class for talking to the Abiquo API
 * Usage :
 * $a= new Abiquo('http://example.com/api','user','password');
 * $a->GetVirtualDatacenters();
 * @package auto-scaler
 */
class Abiquo { 
	/**
	 * URL of the API to abiquo, must point to the root (/api/)
	 * @var string
	 * @access private
	 */
	private $url; 
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
		
		// Login to the server
		$this->Authenticate();
		
		// Return success or failure
		return ($this->token);
	}
	
	/* 
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
		$res = $this->HttpRequest( $this->url , $opt ) ;
		
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
	
	/* 
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
		curl_close($ch);
		return $result;
	}
	
	/* 
	 * Request to the API, expect XML back and format into assoc array and return 
	 * @param string $url URI to request (will be appended to the address of the API)
	 * @return SimpleXML XML Object of the returned data
	 * @access private
	 */	 
	private function ApiRequest( $url ) {
		$opt = array( 
			CURLOPT_FAILONERROR => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HEADER => false,
			CURLOPT_COOKIE => 'auth='.$this->token.'; JSESSIONID='.$this->sessionid 
			);
		$res = $this->HttpRequest ($this->url.$url, $opt);
		if ($res){
			$xml = simplexml_load_string($res);
			return $xml;
		} else return false;
	}
	
	/*
	 * Get a list of VDCs in logged in Enterprise
	 * @return Object SimpleXML Object tree of the result
	 * @access public
	 */
	public function GetVirtualDatacenters () {
		return $this->ApiRequest('cloud/virtualdatacenters');
	}
	
	/*
	 * Get a VDC in logged in Enterprise	 
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @return Object SimpleXML Object tree of the result
	 * @access public
	 */
	public function GetVirtualDatacenter ($id){
		return $this->ApiRequest("cloud/virtualdatacenters/$id/");
	}
	
	/*
	 * Get a list of Private Networks (VLANs) in this Enterprise
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @return Object SimpleXML Object tree of the result
	 * @access public
	 */
	public function GetPrivateNetworks ($vdc_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/privatenetworks");
	}
	
	/*
	 * Get a specific private network in this enterprise
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @param int $pn_id ID of the Private Network
	 * @return Object SimpleXML Object tree of the result
	 * @access public
	 */
	public function GetPrivateNetwork ($vdc_id, $pn_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/privatenetworks/$pn_id");
	}
	
	/*
	 * Get a list of Virtual Appliances in this Enterprise
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @return Object SimpleXML Object tree of the result
	 * @access public
	 */
	public function GetVirtualAppliances ($vdc_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances");
	}
	
	/*
	 * Get a Virtual Appliance in this Enterprise
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @param int $vapp_id ID of the Virtual Appliance
	 * @return Object SimpleXML Object tree of the result
	 * @access public
	 */
	public function GetVirtualAppliance ($vdc_id,$vapp_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances/$vapp_id");
	}

	/*
	 * Get a list of IPs used in a specified Virtual Appliance
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @param int $vapp_id ID of the Virtual Appliance
	 * @return Object SimpleXML Object tree of the result
	 * @access public
	 */
	public function GetIPsUsedInVirtualAppliance ($vdc_id, $vapp_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances/$vapp_id/action/ips");
	}
	
	/*
	 * Get a list of Virtual Machines in a specified Virtual Appliance
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @param int $vapp_id ID of the Virtual Appliance
	 * @return Object SimpleXML Object tree of the result
	 * @access public
	 */
	public function GetVirtualMachines($vdc_id,$vapp_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances/$vapp_id/virtualmachines");
	}
	
	/*
	 * Get a Virtual Machine in this VDC/VAPP
	 * @param int $vdc_id ID of the Virtual Data Center
	 * @param int $vapp_id ID of the Virtual Appliance
	 * @param int $vm_id ID of the Virtual Machine
	 * @return Object SimpleXML Object tree of the result
	 * @access public
	 */
	public function GetVirtualMachine($vdc_id,$vapp_id,$vm_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances/$vapp_id/virtualmachines/$vm_id");
	}
}
