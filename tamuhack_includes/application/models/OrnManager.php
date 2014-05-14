<?php

class Application_Model_OrnManager
	extends Zend_Db_Table_Abstract
{
	protected $_name = 'orn_likes';	

	
	
	/**
	 * 
	 * @param string $username
	 * @return mixed null/array
	 */
	public function add($fbid){
		$data = array(
			'fbid' 	=> $fbid,				
			'timestamp'		=> time()
		);

		$this->insert($data);
	}
	
	/**
	 * get the total number of likes the system has accumulated over time
	 * @param String $fbid
	 * @return int
	 */
	public function getTotalLikesForFbid($fbid){
		$row = $this->fetchRow(
				$this->select()
				->from($this, 'COUNT(*) as total')
				->where('fbid = ?', $fbid)
		);
		return $row->total;
	}
	
	/**
	 * get the total number of likes the system has accumulated over time
	 * @return int
	 */
	public function getTotalLikes(){
		$row = $this->fetchRow(
				$this->select()
				->from($this, 'COUNT(*) as total')
		);
		return $row->total;
	}
	
	
	/**
	 * get the total number of times a logo has been viewed in game
	 * @param String $fbid
	 * @return int
	 */
	public function getTotalLogoViews(){
		$row = $this->fetchRow(
				$this->select()
				->from($this, 'COUNT(*) as total')
		);
		return $row->total*99;
	}
	
	
	public function getAllLikesForFbid($fbid){
		$rows = $this->fetchAll(
				$this->select()
				->where('fbid = ?', $fbid)
		);
		return $rows;
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