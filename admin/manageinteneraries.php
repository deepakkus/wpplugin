<?php
global $post, $wpdb;
$str_response='';
$str_error='';
inter_main();	
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Itineraries</title>
    <link href="<?php echo plugins_url(); ?>/checkfront-4geek/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo plugins_url(); ?>/checkfront-4geek/css/style.css" rel="stylesheet">
    <style>
       .highlight { color: red;}
    </style>
   </head>
<body>
<?php
function inter_main()
{  

?>
<div class="container checkfront_Itineraries">
<div class="row">
   <h3><center><b>Manage Itineraries</b></center></h3>
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

<!--create trip-->
    <div class="row popup_modal">
    <button type="button" class="btn btn-info btn-lg" style="border-radius: 0px; margin: 10px 0px;" onClick="open_modal()"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Create New Itineraries</button>
    <div id="trip-popup" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
         <form class="form-horizontal" id="trip_frm" name="trip_frm" action="" method="post" enctype="multipart/form-data">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title"><B>TRIP DETAILS</B></h4>
          </div>
         
          <div class="modal-body">
              <!--trip form-->
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="email">Name:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control radius_zero" id="tp_name" name="tp_name" placeholder="Your Itinerary">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="pwd">Start Date:</label>
                    <div class="col-sm-9"> 
                      <input type="date" class="form-control radius_zero" id="tp_name" name="tp_name" placeholder="Set the start Date">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="pwd">Price:</label>
                    <div class="col-sm-9"> 
                      <input type="text" class="form-control radius_zero" id="tp_price" name="tp_price" placeholder="$10000">
                    </div>
                  </div>
                   <div class="form-group">
                    <label class="control-label col-sm-3" for="pwd">Description:</label>
                    <div class="col-sm-9"> 
                       <textarea class="form-control radius_zero" rows="5" id="tp_desc" name="tp_desc" placeholder="Add Notes"></textarea>
                    </div>
                  </div>
                  
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="pwd"></label>
                    <div class="col-sm-9"> 
                      <label class="radio-inline"><input type="radio" name="tp_st" checked>Published</label>
                      <label class="radio-inline"><input type="radio" name="tp_st">Unpublished</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="pwd">Upload Image: </label>
                    <div class="col-sm-9"> 
                      <input type="file" class="form-contro radius_zerol" id="tp_file" name="tp_file">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-3" for="pwd">Conatact Email: </label>
                    <div class="col-sm-9"> 
                      <input type="email" class="form-control radius_zero" id="tp_email" name="tp_email" placeholder="Contact Email">
                    </div>
                  </div>
            <!--end trip form-->
      </div>
         
       <div class="modal-footer">
         <button type="submit" class="btn btn-info">Save Changes</button>
        <button type="button" class="btn btn-warning" data-dismiss="modal">Cancel</button>
       </div>
       </form>
    </div>
  </div>
</div>
</div>
<!--end create trip-->
<!--TripList-->
<div class="row">
    <div class="col-sm-8 no-padding">
    <div class="table-responsive" style="height:400px">
    <table class="table table-bordered">
        <thead>
          <tr class="black">
            <th>Trip Name</th>
            <th>Date</th>
            <th>Status</th>
            <th>Shortcode</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><img src="<?php echo plugins_url(). '/checkfront-4geek/images/inten.jpg' ?>" class="img-responsive " width="80" style="display: inline-block;">&nbsp;&nbsp;<strong>Weekend In New york</strong></td>
            <td>Oct 11 - Oct 12 , 2018</td>
            <td>Active</td>
            <td>[checkfront_itiner]</td>
          </tr>
          <tr>
            <td><img src="<?php echo plugins_url(). '/checkfront-4geek/images/inten.jpg' ?>" class="img-responsive" width="80" style="display: inline-block;">&nbsp;&nbsp;<strong>Weekend In New york</strong></td>
            <td>Oct 11 - Oct 12 , 2018</td>
            <td>Active</td>
            <td>[checkfront_itiner]</td>
          </tr>
          <tr>
            <td><img src="<?php echo plugins_url(). '/checkfront-4geek/images/inten.jpg' ?>" class="img-responsive" width="80" style="display: inline-block;">&nbsp;&nbsp;<strong>Weekend In New york</strong></td>
            <td>Oct 11 - Oct 12 , 2018</td>
            <td>Deactive</td>
            <td>[checkfront_itiner]</td>
          </tr>
          <tr>
            <td><img src="<?php echo plugins_url(). '/checkfront-4geek/images/inten.jpg' ?>" class="img-responsive" width="80" style="display: inline-block;">&nbsp;&nbsp;<strong>Weekend In New york</strong></td>
            <td>Oct 11 - Oct 12 , 2018</td>
            <td>Active</td>
            <td>[checkfront_itiner]</td>
          </tr>
          <tr>
            <td><img src="<?php echo plugins_url(). '/checkfront-4geek/images/inten.jpg' ?>" class="img-responsive" width="80" style="display: inline-block;">&nbsp;&nbsp;<strong>Weekend In New york</strong></td>
            <td>Oct 11 - Oct 12 , 2018</td>
            <td>Deactive</td>
            <td>[checkfront_itiner]</td>
          </tr>
          <tr>
            <td><img src="<?php echo plugins_url(). '/checkfront-4geek/images/inten.jpg' ?>" class="img-responsive" width="80" style="display: inline-block;">&nbsp;&nbsp;<strong>Weekend In New york</strong></td>
            <td>Oct 11 - Oct 12 , 2018</td>
            <td>Active</td>
            <td>[checkfront_itiner]</td>
          </tr>
          <tr>
            <td><img src="<?php echo plugins_url(). '/checkfront-4geek/images/inten.jpg' ?>" class="img-responsive" width="80" style="display: inline-block;">&nbsp;&nbsp;<strong>Weekend In New york</strong></td>
            <td>Oct 11 - Oct 12 , 2018</td>
            <td>Active</td>
            <td>[checkfront_itiner]</td>
          </tr>
        </tbody>
      </table>
    </div>
    </div>
    <div class="col-sm-4 no-padding">
    <div class="trip-img">
    <img src="<?php echo plugins_url(). '/checkfront-4geek/images/inten.jpg' ?>" class="img-responsive img-custom" >
    <div class="button-left">Your Itineraries</div>
    </div>
    <div class="actions">
           <a href="#" class="btn btn-primary a-btn-slide-text">
                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                <span><strong>Edit</strong></span>            
            </a>
       
            <a href="#" class="btn btn-danger a-btn-slide-text">
               <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
                <span><strong>Delete</strong></span>            
            </a>
            
            <ul class="list-group">
              <li class="list-group-item d-flex justify-content-between align-items-center">
                Date
                <span class="float-right">Oct 18 - Oct 22, 2018</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                Status
                <span class="float-right">Active</span>
              </li>
              
            </ul>
            
    </div>
    </div>
</div>
<!--End TripList-->
</div>
<?php } ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="<?php echo plugins_url(); ?>/checkfront-4geek/js/bootstrap.min.js"></script>
<script type="text/javascript">
function open_modal(){
jQuery('#trip_frm')[0].reset();
	 jQuery("input[type=hidden]").val('');
	 jQuery('#trip-popup').modal('show');
}
</script>
</body>
</html>