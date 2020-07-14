<?php
ob_start();
class CheckfrontAdmin
{
  public function __construct()
  {
	  add_action('admin_menu' , array($this, 'create_admin_menu'));  
  }	
  
  public function create_admin_menu() { 

	    $checkfront_caps =  current_user_can('manage_options') ? 'manage_options' : '';
	 /*  add_menu_page('Checkfront 4greeks Payment','Checkfront 4greeks Payment','manage_options','manage-settings', array($this, 'manage_menu'));
	   */
	     add_menu_page( _n( 'Checkfront 4greeks Payment', 'Checkfront 4greeks Payment', 1, 'Checkfront 4greeks Payment' ), _n( 'Checkfront 4greeks Payment', 'Checkfront 4greeks Payment', 1, 'Checkfront 4greeks Payment' ), 'Checkfront 4greeks Payment', 'Checkfront 4greeks Payment' );
		add_submenu_page('Checkfront 4greeks Payment', 'Manage Checkfront', 'Manage Checkfront', 1,'manage_menu', array($this,'manage_menu'));
	/*	add_submenu_page('Checkfront 4greeks Payment', 'Manage Itineraries', 'Manage Itineraries', 1,'manage_itineraries', array($this,'manage_itineraries'));
		
	 add_submenu_page(
      null, 
      'Checkfront 4greeks Payment',
      'Checkfront 4greeks Payment', 
      'manage_options', 
      'manage_trip', 
       array($this,'manage_trips')
     ); */
	 
	 
  }
  public function manage_menu()
  {
	  include(dirname(__FILE__)."/manage4geeks.php");
  }	
  
  public function manage_itineraries()
  {
	  include(dirname(__FILE__)."/manageinteneraries.php");
  }
  public function manage_trips() {
	  include(dirname(__FILE__)."/managetrip.php");
	  
  }
  

}
?>