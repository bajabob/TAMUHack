<?php

class Application_Model_FailedLogins
	extends Zend_Db_Table_Abstract
{
	protected $_name = 'client_failed_logins';	

	
	
	/**
	 * 
	 * @param string $username
	 * @return mixed null/array
	 */
	public function getFailedLogins($username){
		$row = $this->fetchRow(
	   		$this->select()
			      ->where('user = ?', strtolower($username))
		);
		if($row != null){
			return $row;
		}
		return null;
	}
	
	/**
	 * 
	 * @param string $username
	 * @return bool
	 */
	public function setFailedLogins($username, $count){
		//Zend_Debug::dump($this->userExists($username)); die;
		if($this->userExists($username)){
		
			$data = array(
				'count'			=> $count,
				'timeout'		=> time()
			);
			
			$where = $this->getAdapter()->quoteInto('user = ?', $username);			
			
			$this->update($data, $where);
			
			return true;
			
		}else{

			$data = array(
				'user' 	=> $username,				
				'count'			=> $count,
				'timeout'		=> time()

			);

			$this->insert($data);
			return 1;
		}
		
	}
	
	
	/*
	 * @return flickr_user_id
	 * @param (db) id
	 */
	public function clearFailedLogins($username){
		$this->delete($this->getAdapter()->quoteInto('user = ?', $username));
	}
	

	/**
	 * 
	 * @param string $username
	 * @return bool
	 */
	public function userExists($username){

		$row = $this->fetchRow(
	   		$this->select()
			      ->where('user = ?', strtolower($username))
		);
		if($row != null){
			return true;
		}
		return false;
	}
	
}