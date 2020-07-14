<?php
error_reporting(0);
session_start(); 
?>
<html class="js no-touch" lang="en">
<head>
<!--<link href="<?php echo plugins_url(); ?>/checkfront-4geek/css/bootstrap.css" rel="stylesheet">-->
<link href="<?php echo plugins_url(); ?>/checkfront-4geek/css/hero-reserve.css" rel="stylesheet">
<link href="<?php echo plugins_url(); ?>/checkfront-4geek/css/default.css" rel="stylesheet">
<link href="<?php echo plugins_url(); ?>/checkfront-4geek/css/reserve_css.css" rel="stylesheet">
<script src="<?php echo plugins_url(); ?>/checkfront-4geek/js/reserve_js.js"></script>
<link href="<?php echo plugins_url(); ?>/checkfront-4geek/css/style.css" rel="stylesheet">	
<script src="<?php echo plugins_url(); ?>/checkfront-4geek/js/custom.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
jQuery(document).ready(function() {
 var parent_width = jQuery("#main_checkfront_div").parent().width();
 if(parent_width < 550)
 { jQuery(".auto_width_setting").removeClass("col-lg-4 col-lg-5 col-lg-7").addClass('col-lg-12');
}
});
</script>
</head>
<body>
<?php 
global $post,$wpdb;
require_once(dirname(dirname(__FILE__)) . '/lib/manage4geeksClass.php');
include (plugin_dir_path( __DIR__ )."lib/Cart.php");
if(isset($_SERVER['REDIRECT_URL']) && $_SERVER['REDIRECT_URL']!='')
{  $url_for_redirect = $_SERVER['REDIRECT_URL']; }
else { $url_for_redirect = $_SERVER['PHP_SELF']; }
$booking_obj= new Booking();
$cart_id = session_id();
/*get host information*/
$get_chkfrnt_obj= new manage4geeksClass();
$get_config = $get_chkfrnt_obj->get_chk_info();
foreach($get_config as $rw) {
 $chk_id = $rw->id;	
 $host_url = $rw->chk_host_url;
 $api = $rw->api_key;
 $secret = $rw->secret_key;
}
/*end host info*/
/*Get checkfront setting*/
$get_setting_obj= new manage4geeksClass();
$get_setting_config = $get_setting_obj->get_setting_function();
foreach($get_setting_config as $sc) {
 $hide_search = $sc->hide_search;
 $cat_hide = explode(",",$sc->category);
}

    $start_date=date("Y-m-d");
	$end_date=date("Y-m-d");	
	$url='?start_date='.$start_date.'&end_date='.$end_date.'&cat_id=';
	$specific_cat_ids='';
    if(isset($cat['cat_id']) && !isset($_GET['cat_id']))
   {
	   $specific_cat_ids =  explode(",",$cat['cat_id']);  //get cat_id from shotcode
    }
	if(isset($_GET['cat']) && $_GET['cat_id']==10){
		$url_cart='?start_date='.$start_date.'&end_date='.$end_date.'&cart=10';
		$url_cartclear='?start_date='.$start_date.'&end_date='.$end_date.'&cartc=10';
	}else{
		$url_cart='?start_date='.$start_date.'&end_date='.$end_date.'&cart=1';
		$url_cartclear='?start_date='.$start_date.'&end_date='.$end_date.'&cartc=1';
	}
	if(isset($_GET['start_date'])){
		 $start_date1=$_GET['start_date'];
		 $start_date=date("Y-m-d",strtotime($_GET['start_date']));
		 $url='?start_date='.$start_date.'cat_id=';
	}
	if(isset($_GET['end_date'])){
		$end_date1=$_GET['end_date'];
		$end_date=date("Y-m-d",strtotime($_GET['end_date']));
		$url='?start_date='.$start_date.'&end_date='.$end_date.'&cat_id=';
	}
	$items_cat = $booking_obj->query_inventory_category( array(
			'start_date'=>$start_date,
			'end_date'=>$end_date,
			'category_id'=>$specific_cat_ids,
			'param'=>array( 'guests' => 1 )
		)
  	);

	if(isset($_POST['cancel']) && $_POST['cancel']=="cancel"){
		 $booking_obj->clear();
		 echo '<script>window.location="'.$url_for_redirect.'"</script>';
	}
	if(isset($_GET['cartc']) && $_GET['cartc']==1){
		 $booking_obj->clear();
		 echo '<script>window.location="'.$url_for_redirect.'"</script>';
	}
	
?>

<div id="page" style="min-height:10px !important; padding-top:0px !important; font-family: 'Amatic SC',sans-serif;" class="ui-helper-clearfix inline	provider-wordpress	">
	<!--here conditions for checkout-->
	<?php if(!isset($_POST['alt_start_date'])) { ?>
    <!--start search by date -->
    <?php if($hide_search =='') { ?>
      <div class="row">
		 <?php if(!isset($_GET['cart'])){ ?>
          <form method="get" action="" id="cf-query" class="search-area full form-inline" role="form">
          <div class="col-sm-7 colum-center">
          <div class="dt_style">
         <label class="lable-style">Check-in</label>
         <input type="text" class="form-control" id="start_date" placeholder="Select Date" onChange="redirectUrl()" value="<?php echo $start_date; ?>">
          </div>
         <div class="dt_style">
         <label class="lable-style">Check-out</label>
         <input type="text" class="form-control" id="end_date" placeholder="Select Date" onChange="redirectUrl()" value="<?php echo $end_date; ?>">
         </div>
         </div>
      </form>
         <?php } ?>
      </div>
  <?php } ?>
    <!--end search by date -->  
     <?php if(!isset($_GET['item_id'])){ ?>
      <div class="row">   
        <div class="col-sm-12 text-center widget-mode">
        <p class="clearfix back-to-categories-btn" style="display: block;"> <?php if(isset($_GET['cat_id'])){ ?> <a id="cf-show-category123" href="<?php echo $url_for_redirect;?>" class="btn btn-sm btn-primary bktocat_btn" style="display: inline-block; background-color: #2c97de;">Back to Categories</a><?php } ?> </p>
      </div>
      </div>
      <?php } ?>
       <?php if(!isset($_GET['cart'])){ ?>
    	  <input id="is_new_booking" value="1" type="hidden">
		   <?php  if(count($booking_obj->cart)) { ?>
          <div class="col-sm-12 text-center widget-mode" style="font-size: 16px;font-family: Merriweather, Georgia, serif; margin: 0px 0px 20px 0px;">
              <span class="ct">You have a booking in progress</span>
              <a href="<?php echo $url_cart;?>" style="margin:0px 2px; color:#093; text-decoration: none;">View</a>
              <a href="<?php echo $url_cartclear;?>" style="margin:0px 2px; color:#C30; text-decoration: none;">Clear</a>
          </div>
            <?php } }  ?>
  <?php } ?>
  <!--condition for redirect if get category_id and item_id from shortcode-->
  <?php  if(isset($cat['category_id']) && isset($cat['item_id']) && !isset($_GET['cat_id']) && !isset($_GET['item_id']) && !isset($_GET['cart']))
 {
	  require_once(dirname(dirname(__FILE__)) . '/frontend/items.php');
      $cat_url='?start_date='.date("Y-m-d").'&end_date='.date("Y-m-d").'&cat_id='.$cat['category_id'].'&item_id='.$cat['item_id'].'';
      echo "<script type='text/javascript'> window.location='".$cat_url."';  </script>";
	  exit;
  }  ?>
  <!--here conditions end for checkout-->
  <?php if(!isset($_GET['cat_id']) && !isset($_GET['cart'])){ 
		if(count($items_cat)>0) { 
			if(isset($items_cat['category']) && count($items_cat['category'])>0){ ?>
                <!--show all category-->
                <div class="row">
  				<div id="cf-category-grid" class="cf-grid-max container-fluid" style="display: block;">
					<?php foreach($items_cat['category'] as $key=>$val){ 
							 if($val['category_id']!=13){ ?>
					  <div class="auto_width_setting col-sm-12 col-xs-12 col-md-12 col-lg-4 grid-pad grid hover-style">
                      <a href="javascript:void();return false;" style="text-decoration:none;">
						<figure style="display:block;">
						  <div class="category-wrapper cf-grid" style="background: #ddd url('<?php echo 'https://'.$host_url.$val['image'];?>') no-repeat center center;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
							<h3><?php echo $val['name']; ?></h3>
						  </div>
						  <figcaption style="display:block;">
							<div class="placement">
							  <div class="child-placement"> <span></span>
								<p><a class="btn btn-lg btn-primary set_category_id  list_btn " href="<?php echo $url.$val['category_id']; ?>">See Listings</a> </p>
							  </div>
							</div>
						  </figcaption>
						</figure></a>
					  </div>
					  		<?php }
						} ?>
					</div>
                </div> 
                 <!--end all category-->
  <?php } 
	} 
}else if(!isset($_POST['alt_start_date'])){
	require_once(dirname(dirname(__FILE__)) . '/frontend/items.php');
} ?>
<?php
	if(isset($_POST['alt_start_date'])){
		require_once(dirname(dirname(__FILE__)) . '/frontend/cartForm.php');
	}
	if(isset($_GET['cart']) && $_GET['cart']==1 ){
		require_once(dirname(dirname(__FILE__)) . '/frontend/cartForm.php');
	}
	if(isset($_GET['cart']) && $_GET['cart']==10){
		require_once(dirname(dirname(__FILE__)) . '/frontend/pay4geeks.php');
	}
	if(isset($_POST['customer_name']) && $_POST['customer_name']!=''){
		require_once(dirname(dirname(__FILE__)) . '/frontend/pay4geeks.php');
	}
	if(isset($_GET['cart']) && $_GET['cart']==15){
		require_once(dirname(dirname(__FILE__)) . '/frontend/thankyou.php');
	}
	if(isset($_POST['card_no']) && $_POST['card_no']!=''){
		require_once(dirname(dirname(__FILE__)) . '/frontend/thankyou.php');
	}
?>
</div>
<?php if (isset($_GET['start_date']) || isset($_GET['end_date'])) { ?>
<script type="text/javascript">
jQuery('html, body').animate({
scrollTop: jQuery("#main_checkfront_div").offset().top-200}, 'slow');
</script>
<?php } ?>
</html>
</body>



