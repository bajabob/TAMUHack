<?php

class Application_Model_TH_GuestWifiUsers extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'th_guestwifiusers';	

	/**
	 * start the register process for a new user account
	 */
	public function addUser($name, $email, $code){
	
		$arr = array(
				'name'			=> $name,
				'email'			=> $email,
				'code'			=> $code
		);
	
		return $this->insert($arr);
	}
	
	
	/**
	 *
	 * @param string $email
	 * @return bool
	 */
	public function exists($event_id, $member_id){
		$row = $this->fetchRow(
				$this->select()
				->where('event_id = ?', $event_id)
				->where('member_id = ?', $member_id)
		);
		if($row !== null){
			return true;
		}
		return false;
	}
	

	public function getAllForEvent($event_id){
		$rows = $this->fetchAll(
				$this->select()
				->where('event_id = ?', $event_id)
		);
		return $rows;
	}
	
}