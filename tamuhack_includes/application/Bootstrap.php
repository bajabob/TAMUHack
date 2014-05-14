<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	
	
	
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
    }
    
 	protected function _initTitle()
    {
        $this->bootstrap('view');
        $this->getResource('view')
            ->headTitle('tamuHack')
            ->setSeparator(' - ');
    }
    
    protected function _initTime(){
    	//date_default_timezone_set("UTC-6");
    }
    
    
 	protected function _initMeta()
    {
        $this->bootstrap('view');
        $this->getResource('view')
        	 ->headMeta()
        	 ->setName('keywords', '');
       	$this->getResource('view')
        	 ->headMeta()
        	 ->setName('description', '');
       	
       	$this->getResource('view')
        	 ->headMeta()
        	 ->setName('robots', 'none');   
    }
    

}

