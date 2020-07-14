<?php
/*
Plugin Name: Checkfront 4geeks Payment
Version: 1.0
Plugin URI: 
Description: This plugin help to booking checkfront items through 4geeks payment
Author: Kus developers
Author URI:  
License: GPLv2 or later
*/
if(preg_match('#' . basename(__FILE__). '#', $_SERVER['PHP_SELF']))
{
	die('you are not allowed to call this page directly');
	}
	
class Checkfront4geeks
{
	var $lcount;
	function Checkfront4geeks()
	{
		$this->define_tables();
		$this->load_dependencies();
		$this->plugin_name=basename(dirname(__FILE__)).'/'.BASENAME(__FILE__);
		
		register_activation_hook( $this->plugin_name, array(&$this, 'activate'));
		register_deactivation_hook( $this->plugin_name, array(&$this, 'deactivate'));
		register_uninstall_hook(__FILE__, array(__CLASS__, 'uninstall'));
		add_action('plugins_loaded', array(&$this, 'start_plugin'));
		
		
	}
	
	function define_tables()
	{
		global $wbdb;	
	}
	
	function deactivate()
	{
    }
	
	function uninstall()
	{
		include_once(dirname(__FILE__) . '/admin/install.php');
		config_uninstall();
	}
	
	function activate()
	{
	    include_once(dirname(__FILE__) . '/admin/install.php');
		config_install();
    }
	
	function start_plugin()
	{    	
	
	}
	function load_dependencies()
	{
	    if(is_admin())
		{
			include_once(dirname(__FILE__) . '/admin/admin.php');
			$this->CheckfrontAdmin = new CheckfrontAdmin();
		}	
	}	
		
}	

global $profile;
if(is_admin())
{
	$profile = new Checkfront4geeks();
}
else
{
//include_once(dirname(__FILE__) . '/frontend/checkfront_shortcode.php');
include_once(dirname(__FILE__) . '/frontend/shortcode_generator.php');
}
?>