<?php
function config_install()
{   ob_start();
	global $wpdb , $wp_roles, $wp_version;
	$chkfront= $wpdb->prefix . 'chkfront_settings';
	$payment= $wpdb->prefix . '4geeks_settings';
	$plug_setting= $wpdb->prefix . 'checkfront_plugin_setting';

	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	// $charset_collate = '';
	/* if ( version_compare(mysql_get_server_info(), '4.1.0', '>=') ) {
		if ( ! empty($wpdb->charset) )
			$charset_collate = "DEFAULT CHARACTER SET $wpdb->charset";
		if ( ! empty($wpdb->collate) )
			$charset_collate .= " COLLATE $wpdb->collate";
	} */
	
	$charset_collate = $wpdb->get_charset_collate();
	
$sql = "CREATE TABLE IF NOT EXISTS ".$chkfront." (
    `id` int(11) NOT NULL AUTO_INCREMENT,
   `chk_host_url` varchar(255) NOT NULL,
   `api_key` varchar(255) NOT NULL,
   `secret_key` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
)".$charset_collate."";
dbDelta($sql);

$sql = "CREATE TABLE IF NOT EXISTS ".$payment." (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `client_id` varchar(255) NOT NULL,
   `client_secret_key` varchar(255) NOT NULL,   
    PRIMARY KEY (`id`)
)".$charset_collate."";
dbDelta($sql);

$sql = "CREATE TABLE IF NOT EXISTS ".$plug_setting." (
   `id` int(11) NOT NULL AUTO_INCREMENT,
   `hide_search` varchar(255) NOT NULL,
   `category` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
)".$charset_collate."";
dbDelta($sql);
}

function config_uninstall()
{
 global $wpdb;
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}chkfront_settings" );
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}4geeks_settings" );
$wpdb->query( "DROP TABLE IF EXISTS {$wpdb->prefix}checkfront_plugin_setting" );
}