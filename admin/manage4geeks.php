<?php
require_once(dirname(dirname(__FILE__)) . '/lib/manage4geeksClass.php');
include (plugin_dir_path( __DIR__ )."lib/Cart.php");
global $post, $wpdb;
$str_response='';
$str_error='';
if(isset($_REQUEST['mode']) && ($_REQUEST['mode']=='ADD_UPDATE_CHK_CONFIG'))
{
	add_update_checkform_config();
}
else if(isset($_REQUEST['mode1']) && ($_REQUEST['mode1']=='ADD_UPDATE_PAYMENT_CONFIG'))
{
	add_update_payment_config();
}
else if(isset($_REQUEST['modeset']) && ($_REQUEST['modeset']=='ADD_UPDATE_SETTING'))
{
  add_update_settings();
}
else
{
checkfront_main();	
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Checkfront 4geeks Settings </title>
    <link href="<?php echo plugins_url(); ?>/checkfront-4geek/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo plugins_url(); ?>/checkfront-4geek/css/style.css" rel="stylesheet">
   <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/css/bootstrap-select.css">
 <style>
       .highlight { color: red;}
    </style>
   </head>
<body>
<?php
function checkfront_main()
{  
$get_chkfrnt_obj= new manage4geeksClass();
$get_config = $get_chkfrnt_obj->get_chk_info();
foreach($get_config as $rw) {
 $chk_id = $rw->id;	
 $hst = $rw->chk_host_url;
 $api = $rw->api_key;
 $secret = $rw->secret_key;
}

$get_pay4g_obj= new manage4geeksClass();
$get_p_config = $get_pay4g_obj->get_pay4geeks_info();
foreach($get_p_config as $pc) {
 $pay_id = $pc->id;	
 $c_id = $pc->client_id;
 $secret_id = $pc->client_secret_key;
}

$get_setting_obj= new manage4geeksClass();
$get_setting_config = $get_setting_obj->get_setting_function();
foreach($get_setting_config as $sc) {
 $setting_id = $sc->id; 
 $hide_search = $sc->hide_search;
$cat_hide = explode(",",$sc->category);
}
$booking_obj= new Booking();
$items_cat = $booking_obj->query_inventory_category( array(
			'start_date'=>date("Y-m-d"),
			'end_date'=>date("Y-m-d"),
			'category_id'=>0,
			'param'=>array( 'guests' => 1 )
		)
);

?>
<div class="container checkfront_main_style">
<div class="row">
   <h3><center><b>Checkfront 4geeks Config Setting</b></center></h3>
</div> 
<hr/>
<div class="row" style="margin-bottom: 20px;">
		<div class="error-notice">
         <?php if(isset( $GLOBALS['str_response'])){ ?>
         <div class="oaerror success"><?php echo $GLOBALS['str_response']; ?></div>
         <?php } ?>
         <?php if(isset( $GLOBALS['str_error'])){ ?>
          <div class="oaerror danger"><?php echo $GLOBALS['str_error']; ?></div>
         <?php } ?> 
        </div>
</div>

<div class="row">
<div class="col-md-6">
<form role="form" name="chkfnt_frm" id="chkfnt_frm" method="post" action="">
	<input type="hidden" name="mode">
    <input type="hidden" name="chk_id" value="<?php if(isset($chk_id)) { echo  $chk_id; } ?>">
    <div class="panel panel-primary">
    <div class="panel-heading"><h4 class="panel-title"><strong>Checkfront Config Settings </strong></h4></div>
    <div class="panel-body">

      <div class="form-group">
        <label for="exampleInputEmail1">Checkfront Host Url</label>
        <input type="url" class="form-control radius_zero" name="host_url" id="host_url" value="<?php if(isset($hst)) { echo $hst; } ?>" placeholder="demo.checkfront.com">
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Api Key</label>
        <input type="text" class="form-control radius_zero" name="api_key" id="api_key" value="<?php if(isset($api)) { echo  $api; } ?>" >
      </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Api Secret Key</label>
        <input type="text" class="form-control radius_zero" name="secret_key" id="secret_key" value="<?php if(isset($secret)) { echo  $secret; } ?>">
      </div>
    <p class="help-block error" id="err"></p>
    <button type="button" class="btn btn-sm btn-success"  onclick="chkValidation()">SAVE</button>

  </div>
 </div>
</form>
</div>
<div class="col-md-6">
<form role="form" name="payment_from" id="payment_from" method="post" action="">
    <input type="hidden" name="mode1">
    <input type="hidden" name="pay_id" value="<?php if(isset($pay_id)) { echo  $pay_id; } ?>">
    <div class="panel panel-primary">
  <div class="panel-heading"><h4 class="panel-title"><strong>4Geeks Config Settings</strong></h4></div>
  <div class="panel-body">
  <div class="form-group">
    <label for="exampleInputEmail1">Client Id</label>
    <input type="text" class="form-control radius_zero" name="client_id" id="client_id" value="<?php if(isset($c_id)) { echo  $c_id; } ?>">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Client Secret Key</label>
    <input type="text" class="form-control radius_zero" name="client_secret_key" id="client_secret_key" value="<?php if(isset($secret_id)) { echo  $secret_id; } ?>" >
  </div>
  <p class="help-block error" id="err1"></p>
  <button type="button" class="btn btn-sm btn-success" onClick="payconfig()">SAVE</button>
  </div>
</div>
</form>
</div>
</div>
<div class="row">
<div class="panel panel-primary">
  <div class="panel-heading">Settings</div>
  <div class="panel-body">
  <div class="col-sm-7">
  <form role="form" name="plugin_setting" id="plugin_setting" method="post" action="">
    <input type="hidden" name="modeset" value="ADD_UPDATE_SETTING">
    <input type="hidden" name="setting_id" id="setting_id" value="<?php if(isset($setting_id)) { echo  $setting_id; } ?>">
    <div class="form-group ">
    <label>Hide Checkin and Checkout: &nbsp;&nbsp;
      <input type="checkbox" id="hide_search" class="round-check" name="hide_search" value="<?php echo $hide_search; ?>" <?php if($hide_search =='1') { echo 'checked'; } ?> style="margin: 0px !important;"></label>
    </div>
  
    <div class="form-group">
      <label>Remove Date search on selected category item page :</label>
      <select id="cat_hide" name="cat_hide[]" data-style="btn-info" class="selectpicker form-control" multiple >
      <?php if(count($items_cat)>0) {  
	        foreach($items_cat['category'] as $key=>$val){  ?>
            <option value="<?php echo $val['category_id']; ?>" <?php if(count($cat_hide) > 0) { if (in_array($val['category_id'], $cat_hide)) {  echo 'selected';} }?>><?php echo $val['name']; ?></option>
      <?php }  } ?>   
         </select>
    </div>
     <button type="button" class="btn btn-sm black" onClick="addedit_func()">SAVE SETTING</button>
</form>
  </div>  <!--end col-sm-7-->
</div>
</div>
</div>
<div class="row">
<div class="table-responsive">
<table class="table table-bordered" style="font-size: 15px;">
    <thead>
      <tr>
        <th>Title</th>
        <th>Shortcode</th>
        <th>Comment</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Checkfornt</td>
        <td>[checkfront_cat]</td>
        <td>Get All Ctegory Items From Checkfront</td>
      </tr>
       <tr>
        <td>Checkfornt Single Category</td>
        <td>[checkfront_cat&nbsp;cat_id={cat_id}]</td>
        <td>For single category add cat_id='category_id'.<br/>
         Ex shortcode:  <span class="highlight"><code>[checkfront_cat cat_id=2]</code></td>
      </tr>
       <tr>
        <td>Checkfornt Show Specific Categories</td>
        <td>[checkfront_cat&nbsp;cat_id={cat_id1,cat_id2}]</td>
        <td>For multiple categories add cat_id='category_id1,category_id2'.<br/> Ex shortcode: <span class="highlight"><code>[checkfront_cat cat_id=2,4,10]</code></span><br/><b> Note: Enter category ids with a comma seperator.</b></td>
      </tr>
      <tr>
        <td>Checkfornt Show Specific Items From a Specific Category</td>
        <td>[checkfront_cat&nbsp;category_id={cat_id}&nbsp;item_id={item_id1,item_id2}]</td>
        <td>Get Single or Multiple Items From a category.<br/>Ex shortcode:  <br/>
          <span class="highlight"><code>[checkfront_cat category_id=2 item_id=21,25]</code></span><br/>
        <b> Note: Enter multiple items ids with a comma seperator</b>
        </td>
      </tr>
       <tr>
        <td>Checkfornt Show All Items From a Specific Category</td>
        <td>[checkfront_cat&nbsp;category_id={cat_id}&nbsp;item_id=0]</td>
        <td>Get all  the items From a specific category, set item_id as 0 (ZERO).<br/>Ex shortcode:  <br/>
          <span class="highlight"><code>[checkfront_cat category_id=2 item_id=0]</code></span><br/>
       
        </td>
      </tr>
    </tbody>
  </table>
</div>
</div>	
</div>
<?php } ?>
<?php
function add_update_checkform_config(){
   $addmng_obj= new manage4geeksClass();
	$str_response = $addmng_obj->addedit_chk_config();
	if($str_response == 'insert')
	 { $GLOBALS['str_response']= 'Checkfront setting saved'; }
	else if ($str_response == 'update')
	 { $GLOBALS['str_response']= 'Checkfront setting updated'; }
	else
	 { $GLOBALS['str_error']= 'Sorry something wrong! please try again'; }
     checkfront_main();		
}
function add_update_payment_config(){
	$pay_obj= new manage4geeksClass();
	$str_response1 = $pay_obj->addedit_pay4eeks_config();
	if($str_response1 == 'insert')
	 { $GLOBALS['str_response']= '4Geeks setting saved'; }
	else if ($str_response1 == 'update')
	 { $GLOBALS['str_response']= '4Geeks setting updated'; }
	else
	 { $GLOBALS['str_error']= 'Sorry something wrong! please try again'; }
     checkfront_main();	
}
function add_update_settings()
{
  $seeting_obj= new manage4geeksClass();
   $str_response2 = $seeting_obj->addedit_setting();
  if ($str_response2 == 'update')
 {
   $GLOBALS['str_response']= 'Setting has been updated successfully'; 
 }
 else if($str_response2 == 'insert')
   { $GLOBALS['str_response']= 'Setting has been updated successfully'; }
checkfront_main();
}
?>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.7.5/js/bootstrap-select.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="<?php echo plugins_url(); ?>/checkfront-4geek/js/bootstrap.min.js"></script>
<script type="text/javascript">
function chkValidation(){
if( jQuery("#host_url").val() == '')
{ jQuery("#err").html('Enter Checkfront Host url');
  return false;
}
else if( jQuery("#api_key").val() == '')
{ jQuery("#err").html('Enter Api key');
  return false;
}
else if( jQuery("#secret_key").val() == '')
{ jQuery("#err").html('Enter secret Key');
  return false;
}	
else
{
document.chkfnt_frm.mode.value='ADD_UPDATE_CHK_CONFIG';
document.chkfnt_frm.submit();
}   
}


function payconfig(){
if( jQuery("#client_id").val() == '')
{ jQuery("#err1").html('Enter 4geeks Client Id');
  return false;
}
else if( jQuery("#client_secret_key").val() == '')
{ jQuery("#err1").html('Enter Client Secret Key');
  return false;
}	
else
{
document.payment_from.mode1.value='ADD_UPDATE_PAYMENT_CONFIG';
document.payment_from.submit();
}   	
}

jQuery('#hide_search').on('click', function () {
    jQuery(this).val(this.checked ? 1 : 0);
    //document.plugin_setting.modeset.value='ADD_UPDATE_SETTING';
   // document.plugin_setting.submit();
    //console.log($(this).val());
});
function addedit_func() {
	document.plugin_setting.modeset.value='ADD_UPDATE_SETTING';
	document.plugin_setting.submit();
}
jQuery('select').selectpicker();
</script>
</body>
</html>