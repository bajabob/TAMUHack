<?php

class PortalController extends Zend_Controller_Action
{
    public function init()
    {
    	$this->_helper->layout()->setLayout("index");
    	
    	$auth = new Zend_Session_Namespace('Zend_Auth');
    	if(!isset($auth->id))
    	{
    		return $this->_forward('logout');
    	}else{
    		$this->view->auth = $auth;
    	}
    }


    public function indexAction()
    {

    }

    public function logoutAction()
    {
    	$auth = new Zend_Session_Namespace('Zend_Auth');
    	$auth->unsetAll();
    }

}
