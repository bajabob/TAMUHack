<?php

class Application_Model_TH_EventsRsvp extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'th_events_rsvp';	

	/**
	 * start the register process for a new user account
	 */
	public function addRsvp($member_name, $member_id, $event_id){
	
		$arr = array(
				'event_id'			=> $event_id,
				'member_id'			=> $member_id,
				'member_name'		=> $member_name
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