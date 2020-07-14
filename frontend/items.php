<?php
$specific_items_by_specific_cat='';
if(isset($_GET['item_id']))
{
 $specific_items_by_specific_cat =  explode(",",$_GET['item_id']);
}
$booking_obj1= new Booking();
$items_cat_prod = $booking_obj1->query_inventory(
			array(
				'start_date'=>$start_date,
			    'end_date'=>$end_date,
				'category_id'=>$_GET['cat_id'],
				'item_id'=>$specific_items_by_specific_cat,
				'param'=>array( 'guests' => 1 )
			)
		  );
?>
<div id="cf-items" style="display: block; font-family: sans-serif!important;">
    <div class="cf-grid-list container-fluid">
      <div class="col-sm-12 margin-top"></div>
      <?php foreach($items_cat_prod['items'] as $cat_id_prod){
		  if($cat_id_prod['category_id']==$_GET['cat_id']){
				$price_per_person='';
				if($cat_id_prod['rate']['summary']['price']['total']=="$0.00"){
					$price_per_person="$".$cat_id_prod['meta']['item_package_display_price'];
				}else{
					$price_per_person=$cat_id_prod['rate']['summary']['price']['total'];
				} 
			if($cat_id_prod['rate']['status']=="AVAILABLE"){
		?>
     	<div class="auto_width_setting cf-item-data grid itm_grid  col-sm-12 col-xs-12 col-md-12 col-lg-4" style="min-height: 612px;">
        <div class="row">
          <div class="col-sm-12">
          <?php 
		    $isfirst = true;
			 for($imgct=0;$imgct <10; $imgct++)
			  {  if($isfirst)
		       	 {  $getimage =  $cat_id_prod['image'][$imgct]['url'];
				    if($getimage !='')
				     {
					    $product_img = $cat_id_prod['image'][$imgct]['url'];
					    $isfirst=false;
				     }
			     }
			 } 
		  ?>
            <div class="cf-grid-image cf-item-action" style="background: #ddd url('<?php echo  $product_img; ?>') no-repeat center center;-webkit-background-size: cover;-moz-background-size: cover;-o-background-size: cover;background-size: cover;">
              <div class="price-overlay priceoverlay">
                <div class="cf-grid-price ct"> <strong> <?php echo $price_per_person;?><span class="cf-currency">USD</span></strong> <em class="cc-parent">From</em><em></em> </div>
                <a onclick="add_to_cart('<?php echo $cat_id_prod['item_id']; ?>')" id="<?php echo 'add_to_cart-'.$cat_id_prod['item_id']; ?>" class="cf-item-status AVAILABLE">Available</a> </div>
            </div>
          </div>
          <div class="cf-item-info col-xs-12">
            <ul class="cf-item-action clearfix">
              <li><a onclick="add_to_cart('<?php echo $cat_id_prod['item_id']; ?>')" id="<?php echo 'add_to_cart-'.$cat_id_prod['item_id']; ?>" class="btn btn-grid cf-btn-book ct bknow_btn"><i class="fa fa-check-square"></i> Book Now</a></li>
              <li><a onclick="displayrec('<?php echo $cat_id_prod['item_id'] ?>')" id="<?php echo 'myBtn-'.$cat_id_prod['item_id']; ?>" class="btn cf-btn-details ct bknow_btn "><i class="fa fa-file-o"></i> Details</a></li>
            </ul>
          </div>
        </div>
		<!-- The Modal to add item to cart -->
		<div id="<?php echo 'addtocart-'.$cat_id_prod['item_id']; ?>" class="addtocart">
		  	<div class="modal-dialog" style="width:55%;margin: 0px auto;">
				<div id="dialog-data" class="modal-content" style="border-radius:0px;">
					<meta charset="UTF-8">
					<div id="item_details_modal" class="modal-header clearfix" style="padding:0">
						<ul class="ntab cf-tab nav nav-tabs col-md-12">
							<li id="cf-item-summary-<?php echo $cat_id_prod['item_id'];?>">
								<a onclick="dispaydetails('<?php echo $cat_id_prod['item_id']; ?>')">
								<i class="fa fa-file-o"></i>
								Details
								</a>
							</li>
							<li id="cf-item-photo-<?php echo $cat_id_prod['item_id'];?>">
								<a onclick="dispayphotos('<?php echo $cat_id_prod['item_id']; ?>')">
								<i class="fa fa-picture-o"></i>
								Images
								</a>
							</li>
                            <?php if($cat_id_prod['video']['id']!='')  { ?>
                            <li id="cf-item-video-<?php echo $cat_id_prod['item_id'];?>">
								<a onclick="displayvideo('<?php echo $cat_id_prod['item_id']; ?>')">
								<i class="fa fa-youtube-play"></i>
								Video
								</a>
							</li>
                            <?php } ?>
							<li id="cf-item-book-<?php echo $cat_id_prod['item_id'];?>" class="active">
								<a onclick="dispaybooking('<?php echo $cat_id_prod['item_id']; ?>')">
								<i class="fa fa-check"></i>
								Book Now
								</a>
							</li>
						</ul>
					</div>


					<form id="cf-item-set" class="cf-item-form form-horizontal cal " method="post" accept-charset="utf-8">
                    <input type="hidden" name="slip" value="<?php  echo $cat_id_prod['rate']['slip']; ?>" id="<?php echo 'tem_'.$cat_id_prod['item_id'];?>">
						<div class="modal-body" style="padding:0px;">
							<div class="overscroll" style="overflow-x:hidden !important;">
								<div class="cf-item clearfix" style="background: #fff;padding-bottom:0px;margin-bottom:0px;">
									<h2 class="col-sm-12" style="padding-left:15px;text-align: left;"><?php echo $cat_id_prod['name']; ?></h2>
									<h4 id="event_span" class="col-sm-12"> </h4>
								</div>
							<div class="cf-item-summary cf-item-panel panel-box details-<?php echo $cat_id_prod['item_id'];?>" style="display: none;">
								<?php echo $cat_id_prod['summary']; ?>
								<?php echo $cat_id_prod['details']; ?>
							</div>
							<div class="cf-item-photo-<?php echo $cat_id_prod['item_id'];?> cf-item-panel" style="margin: 0px auto; display: none;">
								<div class="item-photo-<?php echo $cat_id_prod['item_id'];?>" id="item-photo" style="background-image: url('<?php echo $cat_id_prod['image'][1]['url'];?>');">
									<?php if($cat_id_prod['image'][1]['title']!='') { ?>
									<p id="photo-title" class="photo-title-<?php echo $cat_id_prod['item_id'];?>" style="display: block"><?php echo $cat_id_prod['image'][1]['title'];?></p>
									<?php } ?>
								</div>
							</div>
                   <?php if($cat_id_prod['video']['id'] !='')  { ?>
                   <div class="cf-item-video-<?php echo $cat_id_prod['item_id'];?> cf-item-panel " style="margin: 0px auto; display: none;">
                        <iframe id="vplay" type="text/html" src="//www.youtube-nocookie.com/embed/<?php echo $cat_id_prod['video']['id']; ?>" frameborder="0"></iframe></div>
                     <?php } ?>
							<div class="cf-item-book cf-item-panel booking-<?php echo $cat_id_prod['item_id'];?>" style="display: block;">
								<div class="cf-item-available">
									<span class="AVAILABLE">
									<i class="fa fa-check"></i>
									Available
									</span>
								</div>
                               <?php  
							   if(count($cat_hide) > 0) {
	                            if (!in_array($_GET['cat_id'], $cat_hide)) { 
	                            if($_GET['cat_id']!=15){
	                            ?>
                                 <div id="cf-ui-date">
							<div class="form-group">
								<label class="control-label col-xs-12 col-sm-4" for="start_date">Start</label>
								<div class="col-xs-12 col-sm-4">
									<div class="input-group ">
										<input id="alt_start_date-<?php echo $cat_id_prod["item_id"];?>" name="alt_start_date" class="alt_start_date" value="<?php echo $start_date;?>" type="text" >
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-xs-12 col-sm-4" for="end_date">End</label>
								<div class="col-xs-12 col-sm-4">
									<div class="input-group ">
										<input id="alt_end_date-<?php echo $cat_id_prod["item_id"];?>" name="alt_end_date" class="alt_start_date" value="<?php echo $end_date;?>" type="text" >
									</div>
								</div>
							</div>
							</div>
                              <?php }
                              else
                              {?>
                                 <div class="form-group">
								<!--<label class="control-label col-xs-12 col-sm-4" for="start_date">Start</label>-->
								<div class="col-xs-12 col-sm-4">
									<div class="input-group ">
										<input id="alt_start_date-<?php echo $cat_id_prod["item_id"];?>" name="alt_start_date" class="alt_start_date" value="<?php echo $start_date;?>" type="hidden" >
									</div>
								</div>
							</div>
							<div class="form-group">
								<!--<label class="control-label col-xs-12 col-sm-4" for="end_date">End</label>-->
								<div class="col-xs-12 col-sm-4">
									<div class="input-group ">
										<input id="alt_end_date-<?php echo $cat_id_prod["item_id"];?>" name="alt_end_date" class="alt_start_date" value="<?php echo $end_date;?>" type="hidden" >
									</div>
								</div>
							</div> 
                             <?php }
                              } } ?>
							
							
							<div id="cf-ui-param">
								<div class="form-group">
									<?php if($cat_id_prod['unlimited']!=0){ ?>
									<label class="control-label col-xs-12 col-sm-4" title="Per Person (Tour)"><?php if($cat_id_prod['param']['pernightperper']['lbl']!=''){ echo $cat_id_prod['param']['pernightperper']['lbl']; }else{ echo "Per Person (Tour)"; } ?></label>
									<?php if($_GET['cat_id']==10){ ?>
					    <div class="col-sm-7 quantity" style="display:block;">
										<input id="<?php echo 'cf-param_perpersontour-'.$cat_id_prod['item_id']; ?>" class="cf-param pull-left" min="1" name="perpersontour"  value="1" autocomplete="off" type="number">
								     </div>
									<?php }else{ ?>
									<div class="control-label col-xs-12 col-sm-4">
										<input id="<?php echo 'cf-param_perpersontour-'.$cat_id_prod['item_id']; ?>" class="cf-param pull-left" min="1" name="perpersontour" onChange="calPrice('<?php echo str_replace("$","",$price_per_person); ?>','<?php echo $cat_id_prod["item_id"];?>')" value="1" autocomplete="off" type="number">
										<span id="cf-param-price_perpersontour" class="cf-param-price pull-left"  style="
    margin: 5px;
"> x <?php echo $price_per_person;?></span>
										<span class="hidden validation-error-msg">Required.</span>
								</div><?php } } ?>
							</div>
							</div>
								<div id="promo" class="form-group" style="display: none;margin-bottom:15px;margin-right:0;margin-left:-15px;">
									<label class="control-label col-sm-4" for="discount_code">Promo / Voucher</label>
									<div class="input col-sm-8" style="margin-left:19px !important; margin-right:19px !important; max-width: 196px;">
										<input id="discount_code" list="codes" name="discount_code" value="" style="width: 140px; height:34px" autocorrect="off" type="text">
										<span class="fa fa-tag" style="height:34px;padding-top:11px"></span>
									</div>
									<div class="sm" style="line-height: 2.7em; padding-left: 1em">
										<b id="discount_status_flat" class="discount_status"> Applied to final balance. </b>
										<button id="discount_apply" class="btn btn-primary btn-sm cf-item-update update" type="submit"> Apply </button>
										<b id="discount_status_error" class="discount_status">  Invalid!  </b>
									</div>
								</div>
								<div class="cf-rate-info" style="margin-bottom: 10px;">
								<?php if($_GET['cat_id']==10){ ?>
									<?php echo date("D F d, Y",strtotime($start_date))." - ".date("D F d, Y",strtotime($end_date));?>
									<input type="hidden" id="price_per_person" name="price_per_person" value="0.00" />
									<input type="hidden" id="tour_package" name="tour_package" value="<?php echo $cat_id_prod['param']['pernightperper']['lbl']; ?>" />
									
								<?php }else{ ?>
								<?php echo date("D F d, Y",strtotime($start_date));?>:
								<span id="<?php echo 'changePrice-'.$cat_id_prod["item_id"]; ?>"><b><?php echo $price_per_person; ?></b></span>
								<input type="hidden" id="price_per_person" name="price_per_person" value="<?php echo str_replace("$","",$price_per_person); ?>" />
								<input type="hidden" id="tour_package" name="tour_package" value="Per Person (Tour)" />
								<?php } ?>
								<input type="hidden" id="package_id" name="package_id" value="<?php echo $cat_id_prod['item_id'] ?>" />
								<input type="hidden" id="description" name="package_name" value="<?php echo $cat_id_prod['name']; ?>" />
							</div>
                            <strong title="title-style" style="font-size:11px; text-align:center; display:none;"><?php echo  $cat_id_prod['rate']['summary']['details']; ?></strong>
							</div>
							</div>
						
						</div>
						<div class="modal-footer" style="margin-top:0">
							<div id="showimg-<?php echo $cat_id_prod["item_id"];?>" class="picgal-<?php echo $cat_id_prod["item_id"];?>" style="display:none;">
							<?php if(count($cat_id_prod['image'])>1){ foreach($cat_id_prod['image'] as $image){ ?>
							<div class="cf-item-photo-action panel-action" style="height: auto; padding: 0px; display: block;">
								<a class="sel" href="#<?php echo $image['src'];?>" title="<?php echo $image['title'];?>">
									<img class="cf-item-photo-thumb" onclick="displayImg('<?php echo 'https://'.$host_url.$image['path'];?>','<?php echo $image['title'];?>','<?php echo $cat_id_prod['item_id'] ?>')" src="<?php echo 'https://'.$host_url.  $image['path'];?>">
								</a>
							</div>
								<?php } } ?></div>
							<div class="pull-left panel-action cf-item-summary-action" style="display: none;"> </div>
							<div class="panel-action cf-item-book-action footer_dis" style="float: left; max-width: 45%; text-align: left; display: none;">
								<a class="cf-add-discount" href="#voucher" style="color: #666; font-weight: bold; position:relative; top:7px">
									<i class="fa fa-tag"></i>
									Apply Promo or Voucher
								</a>
							</div>
							<button class="btn btn-default tutorial-btn-close-modal" type="reset" data-dismiss="modal" style="background: transparent !important;
color: #333 !important; border: 1px solid #ccc;">Close</button>
							<button id="sub_btn" class="btn btn-primary" onclick="showPrice('<?php echo str_replace("$","",$price_per_person); ?>','<?php echo $cat_id_prod["item_id"]; ?>')" data-text-continue="Continue" data-text-add="Add to Booking" data-text-update="Update" type="submit">Continue</button>
						</div>

					</form>
				</div>
			</div>
		</div>
		<!--end of code-->
          <div class="cf-title" style="text-align:left; margin-left:15px;">
            <h2 class="grid-h2 ct"><?php echo $cat_id_prod['name'];?></h2>
        </div>
      </div>
      <?php } 
		}
	}?>
	  </div>
</div>
<script type="text/javascript">
jQuery('.close').click(function() {
		jQuery('.modal').css('display','none');
});
jQuery('.tutorial-btn-close-modal').click(function() {
		jQuery('.addtocart').css('display','none');
});
jQuery(document).ready(function(){
    jQuery('[data-toggle="tooltip"]').tooltip(); 
});
</script>