<?php

class AdminController extends Zend_Controller_Action
{
    public function init()
    {
    	$this->_helper->layout()->setLayout("index");
    	
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
    	$members = new Application_Model_TH_Members();
    	$this->view->members = $members->getAll();
    }

 
}
