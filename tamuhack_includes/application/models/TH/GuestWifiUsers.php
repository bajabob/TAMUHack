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

	public function codeExists($code)
	{
		$row = $this->fetchRow(
				$this->select()
				->where('code = ?', $code)
		);
		if($row !== null){
			return true;
		}
		return false;
	}
	
	
	public function hasSeenCode($code)
	{
		$row = $this->fetchRow(
				$this->select()
				->where('code = ?', $code)
				->where('showncode = ?', 1)
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
	public function shownCode($code, $wifiCodeId){
		$arr = array(
				"wifi_code_id" 	=> $wifiCodeId,
				"showncode"		=> 1
		);
		
		$where = $this->getAdapter()->quoteInto('code = ?', $code);
		return $this->update($arr, $where);
	}
	
}