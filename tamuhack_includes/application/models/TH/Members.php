<?php

class Application_Model_TH_Members extends Zend_Db_Table_Abstract{

	
	protected $_name = 'th_members';	

    
	/**
	* start the register process for a new user account
	*/
	public function createNewUser($first, $last, $email, $pass, $accountType){
	
		$arr = array(
				'account_type'	=> $accountType,
				'email_verified'=> 0,
				'rep'			=> 0,
			    'name_first'   	=> ucfirst($first),
				'name_last'     => ucfirst($last),
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
	 * @param string $email
	 * @param array $arr
	 * 
	 */
	public function editUser($email, $arr){
		$where = $this->getAdapter()->quoteInto('email = ?', strtolower($email));
		return $this->update($arr, $where);
	}
	

	
	
	/**
	* Is the user activated?
	* @param string $username
	* @return bool
	*/
	public function hasVerifiedEmail($email){
		$row = $this->fetchRow(
		$this->select()
		->where('email = ?', strtolower($email))
		);
		if($row->email_verified === '1'){
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
	public function checkCredentails($email, $password){
		 
		$row = $this->fetchRow(
		$this->select()
			->where('email = ?', strtolower($email))
		);
		 
		if($row === false){
			return false;
		}
		 
		// check password
    	$sha = new Application_Model_TH_NanoSha256();
    	$pass = $sha->getSaltedHash($email, $password);
		 
		if($pass === $row->pass){
			return true;
		}else{
			return false;
		}
	}
	
	
	/**
	 * get the user's data row
	 * @param string $user
	 */
	public function getMember($email){
		$row = $this->fetchRow(
		$this->select()
			->where('email = ?', strtolower($email))
		);
		return $row;
	}
	
	
	public function getAll()
	{
		$rows = $this->fetchAll(
				$this->select()
		);
		return $rows;
	}
	
}