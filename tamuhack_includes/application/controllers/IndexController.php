<?php

class IndexController extends Zend_Controller_Action
{


    public function init()
    {
    	$this->_helper->layout()->setLayout("index");
    }


    public function indexAction(){
    	$channel = new Zend_Feed_Rss('http://tamuhack.blogspot.com/feeds/posts/default?alt=rss');
    	$this->view->channel = $channel;
    }

    public function aboutAction(){}

    public function newsAction(){
    	$channel = new Zend_Feed_Rss('http://tamuhack.blogspot.com/feeds/posts/default?alt=rss');
    	$this->view->channel = $channel;
    }

    public function contactAction(){}

}
