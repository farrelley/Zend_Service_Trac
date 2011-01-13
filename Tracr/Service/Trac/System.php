<?php

class Tracr_Service_Trac_System extends Tracr_Service_Trac
{
	protected $_supportedMethods = array(
		'multicall',
		'listMethods',
		'methodHelp',
		'methodSignature',
		'getAPIVersion'
	);
	
	public function __construct($username, $password, $instance)
	{
		parent::__construct($username, $password, $instance);
	}
	
	/**
	 * system.multicall
	 * 
	 * Takes an array of RPC calls encoded as structs of the form (in a Pythonish notation here): 
	 * {'methodName': string, 'params': array}. For JSON-RPC multicall, signatures 
	 * is an array of regular method call structs, and result is an array of return structures.	
	 * 
	 * @param array $signatures
	 * @return array
	 */
	protected function _multiCall(array $signatures)
	{
		return $this->call("system.multicall", array($signatures));
	}
	
	/**
	 * system.listMethods
	 * 
	 * This method returns a list of strings, one for each (non-system) method 
	 * supported by the RPC server.
	 * 
	 * @return array	
	 */
	protected function _listMethods()
	{
		return $this->call("system.listMethods");
	}
	
	/**
	 * system.methodHelp
	 * 
	 * This method takes one parameter, the name of a method implemented by the RPC server. 
	 * It returns a documentation string describing the use of that method. If no such string 
	 * is available, an empty string is returned. The documentation string may contain 
	 * HTML markup.
	 * 	
	 * @param string $method Method Name
	 * @return string
	 */
	protected function _methodHelp($method)
	{
		// check to see if the method is a string and is set
		// do i need to check to see if the method is in the list?
		
		return $this->call("system.methodHelp", array('method' => $method));
	}
	
	/**
	 * system.methodSignature
	 * 
	 * This method takes one parameter, the name of a method implemented by the RPC server. 
	 * It returns an array of possible signatures for this method. A signature is an array 
	 * of types. The first of these types is the return type of the method, the rest are 
	 * parameters.
	 * 
	 * @param string $method
	 * @return array
	 */
	protected function _methodSignature($method) 
	{
		return $this->call("system.methodSignature", array('method' => $method));
	}
	
	/**
	 * system.getAPIVersion
	 * 
	 * Returns a list with three elements. First element is the epoch (0=Trac 0.10, 
	 * 1=Trac 0.11 or higher). Second element is the major version number, third is the 
	 * minor. Changes to the major version indicate API breaking changes, while minor 
	 * version changes are simple additions, bug fixes, etc.	
	 * 
	 * @return array
	 */
	protected function _getAPIVersion()
	{
		return $this->call("system.getAPIVersion");
	}	
}