<?php

class NewsController extends Zend_Controller_Action
{


    public function init()
    {
    	$this->_helper->layout()->setLayout("org");
    	
    	$auth = new Zend_Session_Namespace('Zend_Auth');
    	if(isset($auth->id))
    	{
    		$this->view->auth = $auth;
    	}
    }


    public function indexAction()
    {
    	$channel = new Zend_Feed_Rss('http://tamuhack.blogspot.com/feeds/posts/default?alt=rss');
    	$this->view->channel = $channel;
    }

}
