<?php

class ContactController extends Zend_Controller_Action
{


    public function init()
    {
    	$this->_helper->layout()->setLayout("index");
    	
    	$auth = new Zend_Session_Namespace('Zend_Auth');
    	if(isset($auth->id))
    	{
    		$this->view->auth = $auth;
    	}
    }


    public function indexAction()
    {
    	
    }


}
