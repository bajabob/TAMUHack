<?php

class LogoutController extends Zend_Controller_Action
{
    public function indexAction()
    {
    	$auth = new Zend_Session_Namespace('Zend_Auth');
    	$auth->unsetAll();
    }
}
