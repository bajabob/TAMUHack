<?php

class Application_Model_Transactions extends Zend_Db_Table_Abstract{

	
	protected $_name = 'client_transactions';	

	public $_PAYMENT_TYPE_STARTUP = 1;
	public $_PAYMENT_TYPE_MONTHLY = 2;
    
	/**
	* add a transaction to the system
	*/
	public function add($user, $payment, $type){
	
		$arr = array(
			    'user'      	=> $user,
				'payment'      	=> $payment,
				'type'  		=> $type,
				'time_made'		=> time()
		);
	
		return $this->insert($arr);
	}
    
	
	/**
	 * Edit user's account
	 * @param string $username
	 * @param array $arr
	 * 
	 */
	public function getAllByType($user, $type){
		return $this->fetchRow(
		$this->select()
			->where('user = ?', strtolower($user))
			->where('type = ?', $type)
		);
	}
	
	
 
	/**
	*	has this user paid the startup fee?
	*/
	public function hasPaidStartup($user){
		$row = $this->fetchRow(
		$this->select()
			->where('user = ?', strtolower($user))
			->where('type = ?', $this->_PAYMENT_TYPE_STARTUP)
		);
		if($row !== null){
			return true;
		}
		return false;
	}
	

	
}