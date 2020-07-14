<?php
class manage4geeksClass
{
	function __construct()
	{
		global $wpdb;
	}
	function __destruct()
	{
		return false;
	}
	function addedit_chk_config()
	{
	   global $wpdb;
	   $chk_id = trim($_REQUEST['chk_id']);
	   $host_url =trim( $_REQUEST['host_url']);
	   $api_key = trim($_REQUEST['api_key']);
	   $secret_key =trim($_REQUEST['secret_key']);
	   if($chk_id > 0)
	   {
		   $res1= $wpdb->update($wpdb->prefix.'chkfront_settings',array(
		        "chk_host_url"=>$host_url,
		        "api_key"=>$api_key,
		        "secret_key"=>$secret_key
		        ), array('id'=>$chk_id));
		         return 'update';
		   }
		  else
		  {
			$res= $wpdb->insert($wpdb->prefix.'chkfront_settings',array(
		         "chk_host_url"=>$host_url,
		        "api_key"=>$api_key,
		        "secret_key"=>$secret_key,		
		        ));
		       $user_last_insert_id = $wpdb->insert_id;
		       return 'insert';  
		 } 
	   
	} 
	
	function addedit_pay4eeks_config(){
		
	   global $wpdb;
	   $pay_id = trim($_REQUEST['pay_id']);
	   $client_id =trim( $_REQUEST['client_id']);
	   $client_secret_key = trim($_REQUEST['client_secret_key']);
	   if($pay_id > 0)
	   {
		   $res1= $wpdb->update($wpdb->prefix.'4geeks_settings',array(
		        "client_id"=>$client_id,
		        "client_secret_key"=>$client_secret_key
		        ), array('id'=>$pay_id));
		         return 'update';
		   }
		  else
		  {
			$res= $wpdb->insert($wpdb->prefix.'4geeks_settings',array(
		         "client_id"=>$client_id,
		         "client_secret_key"=>$client_secret_key,	
		        ));
		       $user_last_insert_id = $wpdb->insert_id;
		       return 'insert';  
		 } 	
	}
	
   function get_chk_info()
	{
	      global $wpdb;
		  $sql = " select * from ".$wpdb->prefix."chkfront_settings";
		  $result = $wpdb->get_results($sql);
		  return  $result;
	}
	
	function get_pay4geeks_info()
	{
	      global $wpdb;
		  $sql = " select * from ".$wpdb->prefix."4geeks_settings";
		  $result = $wpdb->get_results($sql);
		  return  $result;
	}
	function update_cart_by_id($cart_id,$book_id){
		 global $wpdb;
		 $res_update= $wpdb->update($wpdb->prefix.'chkfront_cart',array(
		    "status"=>'y',
			 "booking_id"=>$book_id
		  ), array('cart_id'=>$cart_id));
		  
   }
    function get_setting_function(){
      global $wpdb;
		  $sql = " select * from ".$wpdb->prefix."checkfront_plugin_setting";
		  $result = $wpdb->get_results($sql);
		  return  $result;
   }

   function addedit_setting(){
		global $wpdb;
		$select_cats = '';
		$cat_hide = $_REQUEST['cat_hide'];
		if($cat_hide !=''){
		foreach ($cat_hide as $selectedOption){
			$select_cats .=  $selectedOption.',';
		}
        }
		 $setting_id =trim( $_REQUEST['setting_id']);
		 $hide_search = trim($_REQUEST['hide_search']);
        if($setting_id !=='')
	     {
	     $setting_update= $wpdb->update($wpdb->prefix.'checkfront_plugin_setting',array(
		        "hide_search"=>$hide_search,
				"category" =>$select_cats
		        ), array('id'=>$setting_id));
	     return 'update';
		  }
		  else {
          $res= $wpdb->insert($wpdb->prefix.'checkfront_plugin_setting',array(
		        "hide_search"=>$hide_search,	
				"category" =>$select_cats,
		        ));
		       $user_last_insert_id = $wpdb->insert_id;
		       return 'insert';  
		  } 
      }
	
	
	
		
}
?>