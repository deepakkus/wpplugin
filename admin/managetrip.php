<?php
include (plugin_dir_path( __DIR__ )."lib/Cart.php");
global $post, $wpdb;
$str_response='';
$str_error='';
trip_main();	
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trips</title>
    <link href="<?php echo plugins_url(); ?>/checkfront-4geek/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo plugins_url(); ?>/checkfront-4geek/css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
   </head>
<body>
<?php
function trip_main()
{  
$booking_obj= new Booking();
$items_cat_prod = $booking_obj->query_inventory(
	array(
		'start_date'=>date("Y-m-d"),
		'end_date'=>date("Y-m-d"),
		/*'item_id'=>array( 108,105,104),*/
		'param'=>array( 'guests' => 1 )
	)
);	




?>
<div class="container checkfront_trip">
<div class="row">
   <h3><center><b>Manage Trips</b></center></h3>
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

  <div class="row trip_setting">
                <button id="btn-add-tab" type="button" class="btn  pull-right black"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> &nbsp;New Day</button>
            <!-- Nav tabs -->
            <ul id="tab-list" class="nav nav-pills nav-stacked col-md-3" role="tablist">
                <li class="active"><a href="#tab1" role="tab" data-toggle="tab">Day 1</a></li>
            </ul>

            <!-- Tab panes -->
			<form method="post" name="trip_frm" id="trip_frm" action="" enctype="multipart/form-data">
            <div id="tab-content" class="tab-content col-md-9">
                <div class="tab-pane fade in active" id="tab1">
                <h3 class="trip_title">Day 1</h3><hr>
				  <!--start form-->
                  <div class="form-group">
					  <label for="exampleInputPassword1">Select Date</label>
					   <input type="text" class="form-control radius_zero custom-height datepicker" id="trip_dt" name="trip_dt[]" placeholder="Select Date" value="<?php echo date("Y-m-d"); ?>" >
				   </div>
				   
				   <div class="form-group">
					  <label for="exampleInputPassword1">Day Title</label>
					   <input type="text" class="form-control radius_zero custom-height" id="day_title" name="day_title[]" placeholder="Day Title" >
				   </div>
				   
				   <div class="form-group">
					  <label for="exampleInputPassword1">Select An Item</label>
					     <select class="form-control radius_zero custom-height" id="items" name="items[]">
						 <?php if(count($items_cat_prod)> 0 ) { 
						       foreach($items_cat_prod['items'] as $cat_id_prod){
						 ?>
							<option value="<?php echo $cat_id_prod['item_id']; ?>"><?php echo $cat_id_prod['name']; ?></option>
						<?php } } ?>	
						  </select>				
				   </div>
                  <!--end  form-->  
                </div>
            </div>
			<button id="save" type="submit" class="btn btn-primary "><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> &nbsp; DONE</button>
			 
		</form>
    </div>


</div>
<?php } ?>
<style type="text/css">
#tab-list .close { margin-left: 7px;}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="<?php echo plugins_url(); ?>/checkfront-4geek/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
var button='<button class="close" type="button" title="Remove this page">×</button>';
var tabID = 1;
function resetTab(){
	var tabs=$("#tab-list li:not(:first)");
	var len=1
	$(tabs).each(function(k,v){
		len++;
		$(this).find('a').html('Day ' + len + button);
	})
	tabID--;
}

$(document).ready(function() {
    $('#btn-add-tab').click(function() {
        tabID++;
        $('#tab-list').append($('<li><a href="#tab' + tabID + '" role="tab" data-toggle="tab">Day ' + tabID + '<button class="close" type="button" title="Remove this page">×</button></a></li>'));
		$(".datepicker").datepicker({ dateFormat: 'yy-mm-dd',  minDate: 0 });
        $('#tab-content').append($('<div class="tab-pane fade" id="tab' + tabID + '"> <h3 class="trip_title">Day ' + tabID + '</h3><hr/><div class="form-group"><label for="exampleInputPassword1">Select Date</label><input type="text" class="form-control radius_zero custom-height datepicker"  name="trip_dt[]" placeholder="Select Date" ></div><div class="form-group"><label for="exampleInputPassword1">Day Title</label><input type="text" class="form-control radius_zero custom-height" name="day_title[]" placeholder="Day Title" ></div><div class="form-group"> <label for="exampleInputPassword1">Select An Item</label><select class="form-control radius_zero custom-height" name="items"><option>item1</option><option>item2</option><option>item3</option><option>item4</option> </select></div></div>'));
    });
    $('#tab-list').on('click', '.close', function() {
        var tabID = $(this).parents('a').attr('href');
        $(this).parents('li').remove();
        $(tabID).remove();
        //display first tab
        var tabFirst = $('#tab-list a:first');
        resetTab();
        tabFirst.tab('show');
    });
    var list = document.getElementById("tab-list");
});

jQuery('body').on('focus',".datepicker", function(){
    jQuery(this).datepicker({ dateFormat: 'yy-mm-dd',  minDate: 0 });
});
</script>
</body>
</html>