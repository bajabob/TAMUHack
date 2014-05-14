<?php
/**
 * Texas A&M University — Mobile
 * 
 * @category    TAMU
 * @package     Views
 * @license     http://www.opensource.org/licenses/bsd-license.php  New BSD License
 * @version     SVN $Id$
 */

/**
 * Format String View Helper
 * 
 * This view helper is used to transform a photoset name or photo title into a clean hmtl string, it will also delimit a string and return trailing '...' when over run
 * 
 *
 * @author Bob Timm <bobtimm@tamu.edu>
 */
class Zend_View_Helper_StripTagsAndDelimit extends Zend_View_Helper_Abstract
{
	
	
	/*
	 * @param string $str     	the string to strip
	 * @param integer $length 	the length to return, defaults to 500 chars
	 * @return string         	the clean string
	 */
	public function stripTagsAndDelimit( $str, $length = 500 ){
		
		
		$find 		= array("_", "-", "=", "/");
		
		$replace 	= array(" ", " ", " ", "");
		
		$s = str_replace($find , $replace, $str);
		
		
		if( strlen($s) > $length) {
			return htmlentities((substr($s, 0, $length) . '...'), ENT_QUOTES); 
		}else{
			return htmlentities($s, ENT_QUOTES);
		}

	}
}
