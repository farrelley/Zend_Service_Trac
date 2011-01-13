<?php

class Tracr_Service_Trac_Ticket_Component extends Tracr_Service_Trac
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
	 * Get a list of all ticket component names.
	 * @return array
	 */
	protected function _getAll()
	{
		return $this->call("ticket.component.getAll");
	}
	
	/**
	 * Get a ticket component.
	 * @param string $name
	 * @return struct
	 */
	protected function _get($name)
	{
		return $this->call("ticket.component.get", array($name));
	}
	
	/**
	 * Delete a ticket component.
	 * @param string $name
	 * @return int
	 */
	protected function _delete($name)
	{
		return $this->call("ticket.component.delete", array($name));
	}

	/**
	 * Create a new ticket component with the given attributes.	
	 * @param string $name
	 * @param array $attr
	 * @return int
	 */
	protected function _create($name, array $attr = array())
	{
		return $this->call("ticket.component.create", 
			array(
				$name,
				new Zend_XmlRpc_Value_Struct($attr)
			)
		);
	}
	
	/**
	 * Update ticket component with the given attributes.
	 * @param string $name
	 * @param array $attr
	 * @return int
	 */
	protected function _update($name, array $attr = array())
	{
		return $this->call("ticket.component.update", 
			array(
				$name,
				new Zend_XmlRpc_Value_Struct($attr)
			)
		);
	}
}