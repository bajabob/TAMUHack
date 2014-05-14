<?php

class Application_Model_TH_Members extends Zend_Db_Table_Abstract{

	
	protected $_name = 'th_members';	

    
	/**
	* start the register process for a new user account
	*/
	public function createNewUser($first, $last, $email, $pass){
	
		$arr = array(
				'account_type'	=> 0,
				'email_verified'=> 0,
				'rep'			=> 0,
			    'name_first'   	=> $first,
				'name_last'     => $last,
				'email' 		=> strtolower($email),
				'pass'			=> $pass
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