<?php
/*
Plugin Name: HSM Booking System
Plugin URI: http://localhost/
Description: 
Author: Samson Wainohu, Hugh Symons & Mandy Otter
Version: 1.0
Author URI: 
Last update: 20/04/2017
*/


if (!function_exists('pr')) {
  function pr($var) { echo '<pre>'; var_dump($var); echo '</pre>';}
}

add_action('admin_menu', 'adminmenus');

function adminmenus() {

	add_menu_page('adminMenu', 'HSM Booking', 'manage_options','adminmenu', 'HSMBooking','dashicons-calendar-alt');

	add_submenu_page('adminmenu','submenu one', 'Manage Members', 'manage_options' , 'ManageMembers', 'ManageMembers');
	
    add_submenu_page('adminmenu','submenu two', 'Manage Bookings', 'manage_options' , 'ManageBookings', 'ManageBookings');

	add_submenu_page('adminmenu','submenu three', 'Manage Reviews', 'manage_options' , 'ManageReviews', 'ManageReviews');
}

function HSMBooking() {
	echo '<h1>Main page</h1>';
}
function ManageMembers() {
	echo '<h1>Manage Members page</h1>';
}
function ManageBookings() {
	echo '<h1>bookings page</h1>';
}
function ManageReviews() {
	echo '<h1>Reviews page</h1>';
}
?>


