<?php

class Tracr_Service_Trac_Ticket_Version extends Tracr_Service_Trac
{
	protected $_supportedMethods = array(
		'getAll',
		'get',
		'delete',
		'create',
		'update'
	);
	
	public function __construct($username, $password, $instance)
	{
		parent::__construct($username, $password, $instance);
	}

	/**
	 * Get a list of all ticket version names.
	 * @return array
	 */
	protected function _getAll()
	{
		return $this->call("ticket.version.getAll");
	}
	
	/**
	 * Get a ticket version.		
	 * @param string $name
	 * @return array
	 */
	protected function _get($name)
	{
		return $this->call("ticket.version.get", array($name));
	}
	
	/**
	 * Delete a ticket version	
	 * @param string $name
	 * @return int
	 */
	protected function _delete($name)
	{
		return $this->call("ticket.version.delete", array($name));
	}
	
	/**
	 * Create a new ticket version with the given attributes.		
	 * @param string $name
	 * @param array $attr
	 * @return int
	 */
	protected function _create($name, array $attr = array())
	{
		return $this->call("ticket.version.create",
			array(
				$name,
				new Zend_XmlRpc_Value_Struct($attr)
			)
		);
	}
	
	/**
	 * Update ticket severity with the given value.	
	 * @param string $name
	 * @param array $attr
	 * @return int
	 */
	protected function _update($name,  array $attr = array())
	{
		return $this->call("ticket.version.update",
			array(
				$name,
				new Zend_XmlRpc_Value_Struct($attr)
			)
		);
	}
}