<?php

class Tracr_Service_Trac_Search extends Tracr_Service_Trac
{
	protected $_supportedMethods = array(
		'getSearchFilters',
		'performSearch'
	);
	
	public function __construct($username, $password, $instance)
	{
		parent::__construct($username, $password, $instance);
	}
	
	/**
	 * Retrieve a list of search filters with each element in the form (name, description).
	 * @return array
	 */
	protected function _getSearchFilters()
	{
		return $this->call("search.getSearchFilters");
	}
	
	/**
	 * Perform a search using the given filters. Defaults to all if not provided. 
	 * Results are returned as a list of tuples in the form 
	 * (href, title, date, author, excerpt).
	 * 
	 * @param string $query
	 * @param array $filter
	 */
	protected function _performSearch($query, array $filter = array())
	{
		return $this->call("search.performSearch",
			array(
				$query,
				$filter
			)
		);
	}
}