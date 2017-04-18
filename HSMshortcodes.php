<?php
/*
Plugin Name: HSMShortcodes
Plugin URI: http://localhost/
Description: This is plugin demonstrates some common wordpress hooks and actions.
Author: Samson Wainohu
Version: 1.1
*/
/*-------------------------------------------------------------------------
 * Shortcode hooks - http://codex.wordpress.org/Shortcode_API
 *				   - http://codex.wordpress.org/Function_Reference/add_shortcode
 * 				   - http://codex.wordpress.org/Function_Reference/shortcode_atts
 -------------------------------------------------------------------------*/
 
 //simple debug function - important
if (!function_exists('pr')) {
  function pr($var) { echo '<pre>'; var_dump($var); echo '</pre>';}
}

 /*
  A shortcode adding the date within a post
 Insert [datetoday] into a post.
 */
add_shortcode('datetoday','HSMdatesc');
function HSMdatesc() {
	$today = date("F j, Y, g:i a");
	echo "<H1>$today</H1><br /><br />";
}

 /*
  A shortcode that adds content within a post Param1 and Param2 are variable strings.
 Insert [scparamtest param1=slot1 param2=slot2] into a post.
 */
add_shortcode('scparamtest','HSMscparamtest');
function HSMscparamtest($shortcodeattributes) {
//This is the default values of the parameters that are stored within the shorcodeattributes array
//it extracts those values when no values are inputed
	extract(shortcode_atts(array('param1' => 'defaultvalue1', 'param2' => 'defaultvalue2'), $shortcodeattributes));	
//This will print a list containing these parameters
	echo '<h1>This is a list</h1>';
	echo '<ul><li> Parameter 1 = '.$param1.'</li>';
	echo '<li> Parameter 2 = '.$param2.'</li></ul>';		
}

 /*
   This shortcode withdraws data from another plugin's shortcode (Nice PayPal Button Lite) and adds it to a post
  Insert [sctestother] into a post.
 */
add_shortcode('sctestother','HSMsctestother');
function HSMsctestother() {
//This functions checks if the 3rd party plugin does exist or not
//if the plugin(Nice PayPal Button Lite) or class exists then echo the shortcode from that plugin
//else if it has not been activated or installed into wordpress echo the warning message.
	if (function_exists('NicePayPalButtonLite') or class_exists('NicePayPalButtonLite')) {
		echo do_shortcode('[nicepaypallite name="Random donation" amount="1.00"]');
	} else {
	  echo 'WARNING: Activate "Nice PayPal Button Lite" wordpress plugin before trying to use this shortcode';
	}
}
?>