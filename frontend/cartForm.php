<?php
include(dirname(dirname(__FILE__)) . '/lib/Form.php');
$book_cart= new Booking();
if(isset($_POST['slip'])) {
    $slp=$_POST['slip'];
	    $ex = explode("-",$slp);
		$first= $ex[0];
		if (strpos($ex[1], ".") !== false) {
				 $ex1 = explode(".",$ex[1]);
				 $ex11 = $ex1[0];
				 $ex12 = $_POST['perpersontour'];
				 $second= $ex11.'.'.$ex12;
               }
			   else
			   {
				 $second=$_POST['perpersontour'];
				 }
       $slips= $first.'-'.$second;
	$book_cart->set($slips);
	header('Content-type: text/html; charset=utf-8');	
}
 if(count($book_cart->cart)) {
?>
<div id="cf-items" style="display: inline;">
	<div class="cf-grid-list container-fluid" style="margin: 0px 20px;">
		<div class="row cart_frm_page">
         <div class="auto_width_setting col-sm-12 col-xs-12 col-md-12 col-lg-7">
         <h1 style="font-size:30px; font-weight: bold;">Create Booking</h1>
         <p class="cart_title">When you are ready to proceed please fill out your details below to confirm your booking.</p>
		<div>
		<div class="action">
		<button class="add ico btn btn-primary add_book_btn" onclick="redirect('<?php echo $_SERVER['REDIRECT_URL'];?>')" style=" color: green !important; border: 1px solid #ccc;"><i class="fa fa-plus"></i>&nbsp;Add To Booking</button>
			<form style="display: inline;" action="" method="post" target="_top" >
		<button class="add ico btn btn-danger add_book_btn" type="submit" style="color: firebrick !important;  border: 1px solid #ccc;"><i class="fa fa-minus-circle"></i>&nbsp;Clear All</button>
								<input type="hidden" name="cancel" value="cancel" /> 
							</form>
						</div>
					</div>
					<div id="cf-tally" class="ct cart_table">
                    <table class="table table-bordered">
                        <thead>
                          <tr>
                            <th>Item</th>
                            <th>Rate</th>
                            <th>Amount</th>
                          </tr>
                        </thead>
                        <tbody>
                       <?php 
					     foreach($book_cart->cart as $line_id => $item) {
					   ?>
                          <tr>
                            <td><b><?php echo $item['name']; ?></b><br/><?php echo $item['date']['summary']; ?></td>
                            <td><b><?php echo $item['rate']['summary']; ?> </b></td>
                            <td><b><?php echo $item['rate']['total']; ?></b></td>
                          </tr>
                      <?php 
						 }
					   ?>  
                      <tr>
                       <td colspan="2" class="text-right"><strong>Sub Total</strong></td>
                       <td><b><?php echo "$".$_SESSION['sub_total']; ?></b></td>
                      </tr>
                      <tr>
                       <td colspan="2" class="text-right"><strong>Tax</strong></td>
                       <td><b><?php echo "$".$_SESSION['tax_total']; ?></b></td>
                      </tr>
                      <tr>
                       <td colspan="2" class="text-right"><strong> Total</strong></td>
                       <td><b><?php echo "$".$_SESSION['total']; ?></b></td>
                      </tr>  
                        </tbody>
                     </table>
					</div>
				</div>
                <div class=" auto_width_setting col-sm-12 col-xs-12 col-md-12 col-lg-5">
                      <div class="panel panel-primary payment">
              		<div class="panel-heading pay_title">CREATE BOOKING</div>
                  <div class="panel-body">
                  <?php $pay_url="?start_date=".$_GET['start_date']."&end_date=".$_GET['end_date']."&cart=10" ?>
                 <form action="<?php echo $pay_url; ?>" method="post">
                    <fieldset>
                    <?php
                     $i=1;
					 $Form = new Form($book_cart->form());
					  echo $Form->msg();
					if(!count($Form->fields)) {
							echo '<p>ERROR: Cannot fetch fields.</p>';
						} else {
							foreach($Form->fields as $field_id => $data) {
								if(!in_array($field_id, array('msg','errors','mode'))) {
									if(!empty($data['define']['layout']['lbl'])) {
										echo "<span class='req_field' id='req-$i'>*</span><label for='{$field_id}'>" . $data['define']['layout']['lbl'] . ':</label>';
									}
									echo $Form->render($field_id);
									echo '<br />';
								}
						$i++;	}
							?>
							<input type="hidden" name="cart_id" value="<?php echo $cart_id; ?>" />
<div class="cf-policy"><p>Liability;  Costa Rica Vacationing (CRVacationing) is solely a Travel Agency. We do not personally operate any of the Hotels, Villas, Transport or Tours and can accept no liability based on negligence. We have hand selected our partners with a great amount of care so that you have the best experience in a safe environment. In the event of extreme weather, road conditions, cancelled flights etc. CRVacationing reserves the right to make substitutions to tours and hotels. In the event that CRVacationing should be found liable for any loss or damage that is connected to any wrong doing on our part we will never exceed the total amount paid by the client for the services sold or the amount of $500 – whichever is the greater amount.  CRVacationing highly recommends the purchase of travel insurance for your stay to cover unforeseen circumstances and to protect your investment.  We are happy to make recommendations and assist with those quotes.   </p><p>Cancellations; Most tour operators vary but a minimum of 3 days is advised.</p><p>This price does not include departure taxes, visas, customary end of trip gratuities for your tour manager, driver, local guides, hotel housekeepers, cruise ship, wait staff, and any incidental charges. <br></p></div>
 <div class="form-group">
            <div class="checkbox">
                <span class="req_field">*</span><label>
                    <input type="checkbox" name="agree" value="agree"  required/> I have read and agreed to the Terms of Service
                </label>
            </div>
    </div>
							<?php
							echo '<button type="submit" class="btn btn-primary bktocat_btn" style="background-color: #2c97de !important"> Continue &nbsp;<i class="fa fa-chevron-right"></i></button>';
						}  
                       ?>

                   </fieldset>
              </form>
              </div><!--end panel body-->
              </div><!--end panel-->
               </div>
		</div>
	</div>
</div>
<?php  }  else { ?>
<div style="text-align:center;">
  <h1><b><center>Cart is Currently Empty</center></b></h3>
  <button class="add ico btn btn-warning" onclick="redirect('<?php echo $url_for_redirect;?>')">Back To Booking</button>
</div>  
<?php } ?>