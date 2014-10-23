<?php

class Application_Model_TH_GuestWifiCodes extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'th_guestwificodes';	

	
	
	public function getNextCode()
	{
		$row = $this->fetchRow(
				$this->select()
				->where('is_taken = 0')
		);
		return $row;	
	}
	
	
	/**
	 * Edit event
	 * @param string $event_id
	 * @param array $arr
	 *
	 */
	public function takeCode($id){
		$arr = array(
				"is_taken" 	=> 1
		);
		
		$where = $this->getAdapter()->quoteInto('id = ?', $id);
		return $this->update($arr, $where);
	}
	
}