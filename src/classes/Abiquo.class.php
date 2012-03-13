<?php
/*
 * Class for talking to the Abiquo API
 * Usage :
 * $a= new Abiquo('http://example.com/api','user','password');
 * $a->GetVirtualDatacenters();
 */
class Abiquo { 
	private $url; // Always ends in "/"
	private $username;
	private $password;
	private $token;
	private $sessionid;

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
	 * Curl wrapper
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
	 */	 
	private function ApiRequest( $url ) {
		$opt = array( 
			CURLOPT_FAILONERROR => true,
			CURLOPT_FOLLOWLOCATION => true,
			CURLOPT_HEADER => false,
			CURLOPT_COOKIE => 'auth='.$this->token.'; JSESSIONID='.$this->sessionid 
			);
		$res = $this->HttpRequest ($url, $opt);
		if ($res){
			$xml = simplexml_load_string($res);
			return $xml;
		} else return false;
	}
	
	/*
	 * Get a list of VDCs in logged in Enterprise
	 */
	public function GetVirtualDatacenters () {
		return $this->ApiRequest('cloud/virtualdatacenters');
	}
	public function GetVirtualDatacenter ($id){
		return $this->ApiRequest("cloud/virtualdatacenters/$id/");
	}
	
	/* 
	 * Get a list of the private networks (VLAN) in this VDC
	 */
	public function GetPrivateNetworks ($vdc_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/privatenetworks");
	}
	public function GetPrivateNetwork ($vdc_id, $pn_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/privatenetworks/$pn_id");
	}
	
	/* 
	 * Get a list of virtual appliances in this VDC
	 */
	public function GetVirtualAppliances ($vdc_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances");
	}
	public function GetVirtualAppliance ($vdc_id,$vapp_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances/$vapp_id");
	}

	public function GetIPsUsedInVirtualAppliance ($vdc_id, $vapp_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances/$vapp_id/action/ips");
	}
	
	public function GetVirtualMachines($vdc_id,$vapp_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances/$vapp_id/virtualmachines");
	}
	public function GetVirtualMachine($vdc_id,$vapp_id,$vm_id){
		return $this->ApiRequest("cloud/virtualdatacenters/$vdc_id/virtualappliances/$vapp_id/virtualmachines/$vm_id");
	}
}
