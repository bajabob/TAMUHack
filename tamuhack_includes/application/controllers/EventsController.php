<?php

class EventsController extends Zend_Controller_Action
{
    public function init()
    {
    	$this->_helper->layout()->setLayout("org");
    	
    	$auth = new Zend_Session_Namespace('Zend_Auth');
    	if(!isset($auth->id))
    	{
    		return $this->_redirect('/portal/logout');
    	}else{
    		$this->view->auth = $auth;
    	}
    }


    public function indexAction()
    {
    	$events = new Application_Model_TH_Events();
		$this->view->events = $events->getAll();
    }

    
    public function eventAction()
    {
    	$request = $this->getRequest();
    	$eid = $request->getParam('id', "");
    	
    	$events = new Application_Model_TH_Events();
    	$this->view->event = $events->getEvent($eid);
    	
    	$auth = new Zend_Session_Namespace('Zend_Auth');
    	$rsvp = new Application_Model_TH_EventsRsvp();
    	if($rsvp->exists($eid, $auth->id)){
    		$this->view->signedup = true;
    	}
    	$this->view->attendees = $rsvp->getAllForEvent($eid);
    }
    
    
    public function signupAction()
    {
    	$request = $this->getRequest();
    	$eid = $request->getParam('eid', "");
    	
    	$rsvp = new Application_Model_TH_EventsRsvp();
    	$events = new Application_Model_TH_Events();
    	$auth = new Zend_Session_Namespace('Zend_Auth');
    	
    	if($events->exists($eid)){
    		if($rsvp->exists($eid, $auth->id)){
    			$this->view->error = "You are already signed up for this event!";
    		}else{
    			$rsvp->addRsvp($auth->name, $auth->id, $eid);
    		}
    	}else{
    		$this->view->error = "Event does not exist.";
    	}
    }
}
