<?php

class Application_Model_Accounts extends Zend_Db_Table_Abstract{

	
	protected $_name = 'client_accounts';	

    
	/**
	* start the register process for a new user account
	* 
	* @param $user string - username
	* @param $email string - email address
	* @param $startupCost - the startup cost
	* @param $monthlyFee - clients monthly fee
	*/
	public function generateNewUser($user, $email, $startupCost, $monthlyFee){
	
		$arr = array(
			    'user'      	=> $user,
				'email'      	=> $email,
				'startup_cost'  => $startupCost,
				'monthly_fee'	=> $monthlyFee
		);
	
		return $this->insert($arr);
	}
    
	
	/**
	 * Edit user's account
	 * @param string $username
	 * @param array $arr
	 * 
	 */
	public function editUser($username, $arr){
		$where = $this->getAdapter()->quoteInto('user = ?', strtolower($username));
		return $this->update($arr, $where);
	}
	
	
 
	/**
	*
	* @param string $username
	* @return bool
	*/
	public function exists($username){
		$row = $this->fetchRow(
		$this->select()
			->where('user = ?', strtolower($username))
		);
		if($row !== null){
			return true;
		}
		return false;
	}
	
	
	/**
	* Is the user activated?
	* @param string $username
	* @return bool
	*/
	public function isActivated($username){
		$row = $this->fetchRow(
		$this->select()
		->where('user = ?', strtolower($username))
		);
		if($row->is_activated === '1'){
			return true;
		}
		return false;
	}
	
	
	/**
	* Is the user enabled?
	* @param string $username
	* @return bool
	*/
	public function isEnabled($username){
		$row = $this->fetchRow(
		$this->select()
		->where('user = ?', strtolower($username))
		);
		if($row->is_enabled === '1'){
			return true;
		}
		return false;
	}
	
	
	/**
	*
	* check user's password
	* @param $username string
	* @param $password string
	*/
	public function checkCredentails($username, $password){
		 
		$row = $this->fetchRow(
		$this->select()
			->where('user = ?', strtolower($username))
		);
		 
		if($row === false){
			return false;
		}
		 
		$sha = new Application_Model_NanoSha256();
		 
		$hash = $sha->getSaltedHash(strtolower($username), $password);
		 
		if($hash === $row->password){
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
	 * get the user's data row
	 * @param string $user
	 */
	public function getAll($user){
		$row = $this->fetchRow(
		$this->select()
			->where('user = ?', strtolower($user))
		);
		return $row;
	}
	
}