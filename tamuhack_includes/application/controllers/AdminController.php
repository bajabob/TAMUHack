<?php

class AdminController extends Zend_Controller_Action
{
    public function init()
    {
    	$this->_helper->layout()->setLayout("org");
    	
    	$auth = new Zend_Session_Namespace('Zend_Auth');
    	if(!isset($auth->id))
    	{
    		return $this->_forward('/logout');
    	}else if($auth->account_type < 90)
    	{
    		return $this->_redirect('/portal/invalidcreds');
    	}
    	else{
    		$this->view->auth = $auth;
    	}
    }


    public function indexAction()
    {
    
    }
    
    public function mailoutAction()
    {
    	$this->view->tinymceHeight = 600;
    	$this->view->tinymceCharLimit = 1500;
    	
    	$request = $this->getRequest();
    	
    	/**
    	 * a post action has occured, validate data
    	*/
    	if($request->isPost())
    	{
    		$members = new Application_Model_TH_Members();
    		$people = $members->getAll();
    		
    		$emailTo = $request->getPost("email_to");
    		
    		$mail = new Zend_Mail('utf-8');
    		$mail->setBodyHtml($request->getPost("body"));
    		$mail->setFrom('noreply@tamuhack.com', 'No-Reply: TAMUHack');
    		$mail->addTo("support@tamuhack.com");
    		
    		$test = array();
    		foreach($people as $person)
    		{
    			if($person->account_type == $emailTo || $emailTo == -1 || $person->account_type >= 90)
    			{
    				$mail->addBcc($person->email);
    			}
    		}
    		$mail->setSubject($request->getPost("subject"));
    		$mail->send();
    		$this->view->sent = true;	
    	}
    }
    

	public function membersAction()
	{
		$members = new Application_Model_TH_Members();
		$this->view->members = $members->getAll();
	} 
 
	public function eventsAction()
	{
		$events = new Application_Model_TH_Events();
		$this->view->events = $events->getAll();
	}
	
	
	public function neweventAction()
	{
		$events = new Application_Model_TH_Events();
		return $this->_redirect('/admin/editevent/id/'.$events->createNewEvent());
	}
	
	public function editeventAction()
	{
		$request = $this->getRequest();
		$eid = $request->getParam('id', "");
		
		$events = new Application_Model_TH_Events();
		
		if($request->isPost())
		{
			$title = $request->getPost("title");
			$date = strtotime($request->getPost("date"));
			$location = $request->getPost("location");
			$link = $request->getPost("link");
			$publish = $request->getPost("publish");
			
			if (strpos($link,'http://') === false) {
				$link = "http://".$link;
			}
			
			$update = array(
				'title' 	=> $title,
				'date'		=> $date,
				'location'	=> $location,
				'link'		=> $link,
				'publish'	=> $publish	
			);
			
			/**
			 *	Image uploading
			 */
			if($_FILES['file']['tmp_name'] != ""){
				$destination = APPLICATION_PATH.'/../../public_html/images/org/events/headers/';
				move_uploaded_file($_FILES['file']['tmp_name'], $destination.$eid.'.png');
			}
			
			$events->editEvent($eid, $update);
			$this->view->updated = true;
		
		}
		$this->view->event = $events->getEvent($eid);
	}
	
	public function howtoAction(){}
	
	public function applicationsAction()
	{
		$applications = new Application_Model_TH_Applications();
		
		$this->view->applications  = $applications->getAllWithMembers();
	}
	
}
