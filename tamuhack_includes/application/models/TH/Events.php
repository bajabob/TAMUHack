<?php

class Application_Model_TH_Events extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'th_events';	

	
	/**
	 * create new event
	 */
	public function createNewEvent(){
	
		$arr = array(
				'title' => "New Event",
				'date'	=> time()
		);
	
		return $this->insert($arr);
	}
    
	public function getAll()
	{
		$rows = $this->fetchAll(
				$this->select()
				->order("date ASC")
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
	
	/**
	 * Edit event
	 * @param string $event_id
	 * @param array $arr
	 *
	 */
	public function editEvent($event_id, $arr){
		$where = $this->getAdapter()->quoteInto('id = ?', $event_id);
		return $this->update($arr, $where);
	}
	
}