<?php
/*
Plugin Name: HSMPlugin settings & options
Plugin URI: http://localhost/
Description: This is plugin demonstrates some how to save plugin settings and options into the database - browse the wp_options table.
Author: Samson Wianohu
Version: 1.1
*/

/*-------------------------------------------------------------------------------------------
 * Plugin options  - http://codex.wordpress.org/Options_API
 				   - http://codex.wordpress.org/Settings_API
 -------------------------------------------------------------------------------------------*/
 
//simple variable debug function
if (!function_exists('pr')) {
  function pr($var) { echo '<pre>'; var_dump($var); echo '</pre>';}
}
 
 /*
This function creates the options submenu and options page to the Settings menu
 */
 add_action('admin_menu', 'HSMoptionspage');
function HSMoptionspage() {
	add_options_page('HSM options Page', 'OptionsFormPage', 'manage_options', 'WADpluginoptions', 'HSMpluginoptionsform');
}

// display the form on the options page
function HSMpluginoptionsform() {
		echo '<form action="options.php" method="post">';		
		settings_fields('HSMplugin_options'); //Output action, and option_page fields for a settings page.
		do_settings_sections('HSMplugin5'); //Prints out all settings sections within the settings page.
		echo '<input name="Submit" type="submit" value="Save Changes" /></form>'; //Save Changes button
}

//This is a special action thats specific to this plugin_action_links_
// Add settings link on options page
add_action('plugin_action_links_'.plugin_basename(__FILE__), 'HSMsettingslink' );  
function HSMsettingslink($links) { 
//link the options-general.php file to the options page
//insert the URL at the beginning of the list
  array_unshift($links, '<a href="'.admin_url('options-general.php?page=WADpluginoptions').'">Settings</a>'); 
  pr($links);
  return $links; 
}

//
add_action( 'admin_init', 'HSMdefaultValues' );
function HSMdefaultValues($title_content) {

  //register_setting( $option_group, $option_name, $sanitize_callback - validate function )
	register_setting( 'HSMplugin_options', 'HSMplugin_options','HSMoptionsvalidate');

  //add_settings_section( the id, the title, the callback, the page )
	add_settings_section('HSMplugin_main', 'Settings - Options Form', 'HSMpluginsectiontext', 'HSMplugin5');

  //add_settings_field( the id, the title, The callback, The page, The section, i.d given for identifying where to save it within an array ) 	
	add_settings_field('HSMplugintextone', 'FirstName',   'HSMpluginsettings', 'HSMplugin5', 'HSMplugin_main',array('id'=>'one'));
	add_settings_field('HSMplugintexttwo', 'LastName',   'HSMpluginsettings', 'HSMplugin5', 'HSMplugin_main',array('id'=>'two'));
	add_settings_field('HSMplugintextthree', 'Email', 'HSMpluginsettings', 'HSMplugin5', 'HSMplugin_main',array('id'=>'three'));
	add_settings_field('HSMplugintextfour', 'Checkbox', 'HSMpluginsettings', 'HSMplugin5', 'HSMplugin_main',array('id'=>'four'));
	add_settings_field('HSMplugintextfive', 'Radio Button', 'HSMpluginsettings', 'HSMplugin5', 'HSMplugin_main',array('id'=>'five'));
}

//this is just a simple echo function displaying text
 function HSMpluginsectiontext() {
	echo '<p>Display text for the Options Form</p>';
} 

//display the content of the options form for each of the options within the form
function HSMpluginsettings($args) {
	
	$options = get_option('HSMplugin_options');

	switch($args['id']) {
		//Display the first user input textbox for the Firstname section and save the value within $options variable
		case 'one': echo "<input id='HSMplugintextone' name='HSMplugin_options[text_one]' size='30' type='text' value='{$options['text_one']}' />";
				break;
		//Display the second user input textbox for the Lastname section and save the value within $options variable
		case 'two': echo "<input id='HSMplugintexttwo' name='HSMplugin_options[text_two]' size='30' type='text' value='{$options['text_two']}' />";
				break;
		//Display the third user input textbox for the Email section and save the value within $options variable
		case 'three': echo "<input id='HSMplugintextthree' name='HSMplugin_options[text_three]' size='50' type='text' value='{$options['text_three']}' />";
				break;
		//Display a checkbox and save the value within $options variable
		case 'four':$chk = $options['text_four']?'checked="checked"':'';
					echo "<input id='HSMplugintextfour' name='HSMplugin_options[text_four]' type='checkbox' value='{$options['text_four']}' $chk />";
				break;
		//Display a radio button and save the value within $options variable
		case 'five':$chk = $options['text_five']?'checked="checked"':'';
					echo '<p><label for="HSMplugintextfiveA">';
					echo '<input type="radio" id="HSMplugintextfiveA" name="HSMplugin_options[text_five]" value="0" '.$chk.'/>Off</label>';
					echo '<p><label for="HSMplugintextfiveB">';				   
					echo '<input type="radio" id="HSMplugintextfiveB" name="HSMplugin_options[text_five]" value="1" '.$chk.'/>On</label></p>';
				break;
	}	
}

//this function iterates through the options an performs some minor testing/error checking before saving any options.
//you need to add your own data validation code here
function HSMoptionsvalidate($input) {
	$newinput = array(); //empty array
	
//using a foreach to iterate through an array	
	foreach ($input as $k => $ni) {
		$ni = trim($ni); //remove whitespace
		if (empty($ni)) $ni = '-'; //set a default if it is empty
		$newinput[$k] = $ni; //store the new value into a new array using the original key from the original array	
	}
/*
// This commented code is the same as the foreach but it is using a while loop to iterate through the array
	while ($ni = current($input)) { //get the current array element and loop until end of the array
		$ni = trim($ni); //remove whitespace
		if (empty($ni)) $ni = '-'; //set a default if it is empty
		$k = key($input); //get the key for the element
		$newinput[$k] = $ni; //store the new value into a new array using the original key from the original array
		next($input); //step to the next element in the array
	}
*/	
	return $newinput; //return the new options list
}

//clean up and remove any settings that may be left in the wp_options table from the plugin
//Need to add code to remove the database tables created by the plugin or else that values will be saved there. 
register_deactivation_hook( plugin_basename(__FILE__), 'HSM5deactivate' );
function HSM5deactivate() {
//this function is used to delete the values within the array but needs more code added
	$options = array('text_one','text_two','text_three','text_four','text_five');	
	foreach ($options as $option)
		delete_option($option);

	unregister_setting( 'HSMplugin_options', 'HSMplugin_options');
}
?>

