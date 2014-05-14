<?php

class Application_Model_TH_MembersActivate extends Zend_Db_Table_Abstract{

	
	protected $_name = 'th_members_activate';	

    
	/**
	* add registration hash to table
	*/
	public function createNewActivation($email, $activation){
	
		$arr = array(
				'email' 		=> strtolower($email),
				'activation'	=> $activation
		);
	
		return $this->insert($arr);
	}
    
	
	/**
	 *
	 * @param string $email
	 * @return bool
	 */
	public function exists($email){
		$row = $this->fetchRow(
				$this->select()
				->where('email = ?', strtolower($email))
		);
		if($row !== null){
			return true;
		}
		return false;
	}	
	
}