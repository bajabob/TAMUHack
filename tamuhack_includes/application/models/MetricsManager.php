<?php

class Application_Model_MetricsManager
	extends Zend_Db_Table_Abstract
{
	protected $_name = 'metrics';	

	
	
	/**
	 * add a metric to the database
	 * @param string $key - the name of the campaign
	 */
	public function add($key){
		$data = array(
			'key' 			=> trim(strtoupper($key)),				
			'timestamp'		=> time()
		);

		$this->insert($data);
	}
	
	/**
	 * get the total number of clicks for the specified campaign
	 * @param String $key
	 * @return int
	 */
	public function getTotalImpressions($key){
		$row = $this->fetchRow(
				$this->select()
				->from($this, 'COUNT(*) as total')
				->where('key = ?', $key)
		);
		return $row->total;
	}
	
	
	
	/**
	 * get the total number of impressions for the specified campaign
	 * over the past 24 hours
	 * @param String $key
	 * @return int
	 */
	public function getTotalImpressionsPast24Hours($key){
		$row = $this->fetchRow(
				$this->select()
				->from($this, 'COUNT(*) as total')
				->where('key = ?', $key)
				->where('timestamp >= ?', (time()+86400000))
		);
		return $row->total;
	}
	
	
	
	

	
	
	public function getAllLikesForFbid($fbid){
		$rows = $this->fetchAll(
				$this->select()
				->where('fbid = ?', $fbid)
		);
		return $rows;
	}
	
	
}