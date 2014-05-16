<?php

class Application_Model_TH_Events extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'th_events';	

    
	public function getAll()
	{
		$rows = $this->fetchAll(
				$this->select()
		);
		return $rows;
	}
	
	public function getEvent($id)
	{
		$row = $this->fetchRow(
				$this->select()
				->where('id = ?', $id)
		);
		return $row;
	}
	
	/**
	 *
	 * @param string $email
	 * @return bool
	 */
	public function exists($id){
		$row = $this->fetchRow(
				$this->select()
				->where('id = ?', $id)
		);
		if($row !== null){
			return true;
		}
		return false;
	}
	
}