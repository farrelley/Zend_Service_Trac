<?php

class Tracr_Service_Trac extends Zend_XmlRpc_Client
{
	protected $_username;
	protected $_password;
	protected $_tracInstance = "DEFAULT_INSTANCE";
	protected $_uri;
	protected $_xmlRpcPath = "/login/xmlrpc";
	
	protected $_currentApiComponent;
	protected $_currentApiType;
	
	protected $_possibleSubApiType = array(
		'ticket/component',
		'ticket/milestone',
		'ticket/priority',
		'ticket/resolution',
		'ticket/severity',
		'ticket/type',
		'ticket/version'	
	);
	
	protected $_supportedApiTypes = array(
		'search',
		'system', 
		'ticket', 
		'wiki'
    );
	
	CONST TRAC_URL = "YOUR_URL_TO_TRAC";
	
	public function __construct($username, $password, $instance) 
	{
		$this->setUsername($username)
			->setPassword($password)
			->setTracInstance($instance);
			
		$this->setUri(self::TRAC_URL);
		parent::__construct($this->_uri->getUri());
	}
	
	public function getUsername()
	{
		return $this->_username;
	}
	
	public function setUsername($username)
	{
		$this->_username = (string) $username;
		return $this;		
	}
	
	public function getPassword()
	{
		return $this->_password;		
	}
	
	public function setPassword($password)
	{
		$this->_password = (string) $password;
		return $this;
	}
	
	public function getTracInstance()
	{
		return $this->_tracInstance;
	}
	
	public function setTracInstance($instance)
	{
		$this->_tracInstance = (string) $instance;
		return $this;
	}
	
	protected function setUri($uri)
	{
		if (is_string($uri)) {
			$this->_uri = Zend_Uri_Http::factory($uri);
			$this->_uri->setUsername($this->getUsername());
			$this->_uri->setPassword($this->getPassword());
			
			$path = $this->_uri->getPath();
			$this->_uri->setPath($path . $this->getTracInstance() . $this->_xmlRpcPath);
		} else {
			throw new Exception('Unable to Make a valid URI');
		}
	}
	
	public function __get($type) 
	{
		if (!in_array($type, $this->_supportedApiTypes)) {
            require_once 'Tracr/Service/Trac/Exception.php';
            $exceptionMessage  = "Unsupported API part '%s' used";
            $exceptionMessage = sprintf($exceptionMessage, $type);
            throw new Tracr_Service_Trac_Exception($exceptionMessage);
        }
        
		if ($this->_currentApiComponent !== null) {		
			$possibleSubApiType = sprintf('%s/%s', 
				$this->_currentApiType, 
				$type
			);			
			if (in_array($possibleSubApiType, $this->_possibleSubApiType)) {
            	$apiComponent = sprintf('%s_%s', get_class($this->_currentApiComponent), ucfirst($type));
            } else {
				$apiComponent = sprintf('%s_%s', __CLASS__, ucfirst($type));
            }
        } else {           
        	$apiComponent = sprintf('%s_%s', __CLASS__, ucfirst($type));
        }
        
    	require_once str_replace('_', '/', $apiComponent. '.php');
    	
    	if (!class_exists($apiComponent)) {
			require_once 'Tracr/Service/Trac/Exception.php';
            $exceptionMessage  = "Nonexisting API component '%s' used";
            $exceptionMessage = sprintf($exceptionMessage, $apiComponent);
            throw new Tracr_Service_Trac_Exception($exceptionMessage);
        }
        
        $this->_currentApiType = $type;
        $this->_currentApiComponent = new $apiComponent(
        	$this->getUsername(),
        	$this->getPassword(),
        	$this->getTracInstance()
        );
        return $this;
	}
	
	public function __call($method, $params) 
	{
		if ($this->_currentApiComponent === null) {
			require_once 'Tracr/Service/Trac/Exception.php';
			throw new Tracr_Service_Trac_Exception('No Trac API component set');
        }
        
        $methodOriginal = $method;
        $method = sprintf("_%s", strtolower($method));
        
        if (!method_exists($this->_currentApiComponent, $method)) {
			require_once 'Tracr/Service/Trac/Exception.php';
            $exceptionMessage  = "Nonexisting API method '%s' used";
            $exceptionMessage = sprintf($exceptionMessage, $method);
            throw new Tracr_Service_Trac_Exception($exceptionMessage);
        }
        
		if (!in_array($methodOriginal, $this->_currentApiComponent->_supportedMethods)) {
			require_once 'Tracr/Service/Trac/Exception.php';
			$exceptionMessage  = "Unsupported API method '%s' used";
			$exceptionMessage = sprintf($exceptionMessage, $methodOriginal);
			throw new Tracr_Service_Trac_Exception($exceptionMessage);
        }
        
        return call_user_func_array(
        	array(
            	$this->_currentApiComponent, 
            	$method
            ), 
            $params
		);
	}
}
