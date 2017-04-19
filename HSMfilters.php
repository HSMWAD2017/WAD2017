<?php
/*
Plugin Name: HSMFilter hooks
Plugin URI: http://localhost/
Description: This is plugin demonstrates some filtering hooks.
Author: Samson Wainohu
Version: 1.1.1
*/
/*-------------------------------------------------------------------------------------------
 * Filter hooks - http://codex.wordpress.org/Function_Reference/add_filter
 * 				- http://codex.wordpress.org/Plugin_API/Filter_Reference
 *				- http://codex.wordpress.org/Plugin_API#Create_a_Filter_Function
 -------------------------------------------------------------------------------------------*/
 
//simple variable debug function
if (!function_exists('pr')) {
  function pr($var) { echo '<pre>'; var_dump($var); echo '</pre>';}
}

//This function changes all titles including posts that are within the website to h1 tags
add_filter( 'the_title', "HSMfilterposttitle");
function HSMfilterposttitle($title_content) {
	$newtitle = '<h1>'.$title_content.'</h1>';
	return $newtitle;
}

//This function only works for a post but it replaces all occurances of the strings that are stored within the
//$badlist array 
//add a badword to test
add_filter( 'the_content', "HSMfiltercontent");
function HSMfiltercontent($post_content) {
	//array of some bad words
	$badlist= array("badword", "crap","poop");
	//replace all occurances of the badwords in the content of a post
	//NOTE: this is a simple search and replace. A more efficient algortihm should be used
	$newpost = str_replace($badlist, "****", $post_content);
	return $newpost;
}

/*
This function only works for a post but it replaces the [text] with the text that is within the <strong> tags
similar to the precious function but it doesnt draw from an array
	try adding [[replace this text]] into a post to test
 */ 
add_filter( 'the_content', "HSMfiltermarkup");
function HSMfiltermarkup($post_content) {

	//test for the occurance of our custom markup
    if (strpos($post_content, "[[replace this text]]") !== FALSE)
    {
		$mymarkup = '<strong>I have just replaced the text</strong>';
		//replace the markup with some of our own text
        $newpost = str_replace('[[replace this text]]', $mymarkup, $post_content);
    }
    return $newpost;
}
?>