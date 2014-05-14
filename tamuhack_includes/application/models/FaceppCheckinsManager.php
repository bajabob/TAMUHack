<?php

class Application_Model_FaceppCheckinsManager
	extends Zend_Db_Table_Abstract
{
	protected $_name = 'facepp_checkins';	

	
	
	/**
	 * 
	 * @param string $username
	 * @return mixed null/array
	 */
	public function add($name, $time){
		
		if(!$this->exists($name)){
			$data = array(
				'name' 	=> $name,				
				'timestamp'	=> $time
			);
			$this->insert($data);
		}
	}
	
	/**
	 *
	 * @param string $username
	 * @return bool
	 */
	public function exists($name){
	
		$row = $this->fetchRow(
				$this->select()
				->where('name = ?', strtolower($name))
		);
		if($row != null){
			return true;
		}
		return false;
	}
	
	
	/**
	 *
	 * @param string $username
	 * @return bool
	 */
	public function findCheckins(){
		
		$row = $this->fetchRow(
				$this->select()
				->where('timestamp > 0')
		);
		

		if($row != null){
			$name = "";
			if($row->name == "walt-p"){
				$name = "Walter P.";
			}else{
				$name = "Eleni M.";
			}
			
			$this->delete($this->getAdapter()->quoteInto('name = ?', $row->name));
			return array('message' => 'found', 'name' => $row->name, 'fullname' => $name, 'timestamp' => $row->timestamp);
		}
		return array('message' => 'null');
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