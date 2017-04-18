<?php
/*
Plugin Name: Hooks
Plugin URI: http://localhost/
Description: This is plugin demonstrates some common wordpress hooks and actions.
Author: Samson Wainohu
Version: 1.1.1
*/

/*-------------------------------------------------------------------------
 * Action hooks - http://codex.wordpress.org/Function_Reference/add_action
 *				- http://codex.wordpress.org/Plugin_API/Action_Reference
 -------------------------------------------------------------------------*/
 
 
//used to debug functions
if (!function_exists('pr')) {
  function pr($var) { echo '<pre>'; var_dump($var); echo '</pre>';}
}

//----------------------------------------------------------------------------- 
 /* This function adds a submenu to the Settings Menu for admin use.
*/
add_action('admin_menu', 'WADadminmenuhook');
function WADadminmenuhook() {
	add_options_page('WAD menu hook', 'WAD menu hook', 'manage_options', 'wadmenu', 'SettingsSubMenu');
}

// This function is the name of the submenu and the content within it.
function SettingsSubMenu() {
	echo '<h1>Content</h1>';
}


//This function is a restriction hook that is used to create admin only menus
add_action('admin_init','AdminOnly', 1 );
function AdminOnly(){
	//if the user is not the admin then kill wordpress and prompt user with message
	if (!current_user_can('manage_options')) {
		wp_die('You are not allowed to access this part of the site');
	}
}

/*This function will add this H1 header to all pages*/
add_action('wp_head','headerhook');
function headerhook() {
	echo '<h1>Header Hook to all pages</h1>';
}

/*This function will add this H1 header to all pages but is admin for viewing only*/
add_action( 'admin_head', 'adminheadhook' );
function adminheadhook() {
	echo '<h1 align=centre>Header Hook for admin eyes only</h1>';
}

/*This function is similar to the previous function but it is for code that is not a within the header and admin only*/
add_action('admin_notices','adminnoticeshook');
function adminnoticeshook() {
	echo '<h1>Content for admin eyes only</h1>';
}
?>