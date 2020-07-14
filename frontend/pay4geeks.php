<?php
include(dirname(dirname(__FILE__)) . '/lib/Form.php');
$Booking = new Booking();


if(isset($_POST['customer_name'])) {
	$Form1 = new Form($Booking->form(),$_POST);
	$response = $Booking->create($_POST);
	//echo '<pre>'; print_r($response); echo '</pre><br/>';die();
	$book_id = $response['booking']['id']; // booking id
	$pay_total = $response['booking']['total']; // pay total amount
	if($response['request']['status'] == 'OK') {
	 $invoice_res = $Booking->invoice($book_id);
	// echo '<pre>'; print_r($invoice_res); echo '</pre><br/>';
?>

<div class="row">
 <div class="auto_width_setting col-sm-12 col-xs-12 col-md-12 col-lg-4">
        <?php $pay_4g="?start_date=".$_GET['start_date']."&end_date=".$_GET['end_date']."&cart=15" ?>
      <form action="<?php echo $pay_4g; ?>" method="post" target="_top" name="pay4g_frm" id="pay4g_frm"  >
       <input type="hidden" name="total_pay" value="<?php echo $pay_total; ?>" />
       <input type="hidden" name="book_id" value="<?php echo $book_id; ?>" />
        <input type="hidden" name="status_id" value="PAID" /> 
        <input type="hidden" name="cust_info" value="<?php echo $_POST['customer_name'].','.$_POST['customer_email'] ?>">
       <div class="panel panel-primary  payment" style="border-color: #87ceeb;">
       <div class="panel-heading pay_title" style="background-color: #337ab7; color: #FFF; text-align:center;">Payment Required</div>
       <div class="panel-body">
                          <div class="form-group">
                       <label for="ct">Card Type : <span class="req_field">*</span></label>
                          <select tabindex="11" id="CardType" name="CardType" class="form-control" style="height: 45px; font-size: 1.2em;">
                              <option value="AmEx">American Express</option>
                              <option value="MasterCard">MasterCard</option>
                              <option value="Visa">Visa</option>
                              <option value="DinersClub">Diners Club</option>
                              <option value="Discover">Discover</option>
                              <option value="JCB">JCB</option>
                              
                         </select>
                         </div>
                          <div class="form-group">
                            <label for="co">Card Number : <span class="req_field">*</span></label>
                            <input type="text" class="form-control" id="card_no" name="card_no" placeholder="Enter Card Number">
                          </div>
                          <div class="form-group">
                            <label for="pwd">Expiry (MM/YYYY): <small>Example: 01/2020</small> <span class="req_field">*</span></label>
                            <input type="text" class="form-control" id="exp" name="exp" placeholder="MM/YYYY">
                          </div>
                          <div class="form-group">
                            <label for="pwd">Card code : <span class="req_field">*</span></label>
                            <input type="text" class="form-control" id="cvc" name="cvc" placeholder="CVV">
                          </div>
                          <span class="help-block" id="valid_frm"></span>
                          <div style="text-align:center">
                          <button type="button" class="btn btn-success  pay_btn" onclick="pay_frm_submit()">BOOK NOW</button></div>
      </div> 
      </div>
     </form>
</div><!--end col-6-->
 <div class="auto_width_setting col-sm-12 col-xs-12 col-md-12 col-lg-7">
   <?php  echo $invoice_res['booking']['invoice']['html']; ?>   <!--get invoice html format by booking od -->      
</div><!--end col-6-->
</div>

<?php
} else {
		$Form1->msg($response['request']['error']['details'],$response['request']['status']);
	}
} 
?>
<script src="https://www.braemoor.co.uk/software/_private/creditcard.js"></script>  
<script>
function pay_frm_submit (){
 var  myCardNo = document.getElementById('card_no').value;
 var myCardType =  document.getElementById('CardType').value;	
 var expire = document.getElementById("exp").value;
 var pattern = /(0|1)[0-9]\/(19|20)[0-9]{2}/;
  var cvcval = document.getElementById("cvc").value;
  //var cvvpattern = /^[0-9]{3,4}$/;
   if (!checkCreditCard(myCardNo, myCardType)) {
	   jQuery("#valid_frm").html('invalid Credit Card or type');
	   return false;
    } 
	else if (!pattern.test(expire))
    {
       jQuery("#valid_frm").html('Invalid Date');
	   return false;
    }
	else if (cvcval =='')
     {
       jQuery("#valid_frm").html('Invalid cvc');
	   return false;
     }
	 else
	 { document.pay4g_frm.submit(); 
	  }
}
</script>
<style type="text/css">
			#checkfront-invoice {
				background: #fff;
				margin-bottom: 1em;
				font: 11pt "Helvetica Neue",Helvetica,Arial,sans-serif;
			}
			table {
				border-collapse: collapse;
				border-spacing: 0;
				border:none !important;
			}
			.cf-customer-addr strong { line-height:16px;}
			.item_table { table-layout: auto !important; }
			.item_table tbody {word-break: break-word; hyphens: auto;}
			.item_table tr {page-break-inside: avoid;}
			.item_table td,
			.item_table th {
				vertical-align: top;
				padding: 5px;
				text-align: left;
			}
			.item_table thead tr {
				background:#e1e1e1;
			}
			.item_table thead th {
				border-bottom: solid 1px #aaa;
				font-size:13px;
			}
			.item_table tr.sum-row td,
			.item_table tr.sum-row th {
				text-align: right;
				white-space: nowrap;
				font-size:13px;
			}
			.item_table tr.border-top {
				border-top: solid 1px #111;
			}
			.invoice_header td,
			.invoice_header th {
				vertical-align: top;
				text-align: left;
				padding:0;
				border:0;
			   font-size: 9pt !important;
			}
			.invoice_details {
				max-width: 300px;
				float: right;
				border: 1px solid #aaa !important;;
				font-size: 9pt;
				text-align: right;
			}
			.invoice_details th {
				background: #e1e1e1;
				padding: 4px;
				font-size:13px;
			}
			.invoice_details td {
				text-align: right;
				padding: 5px 0px;
			}
			.btn-invoice {
				background-color: #fff;
				color: #777;
				font-weight: bold;
				text-decoration: none;
				padding: 3px 10px;
				border: solid 1px #ccc;
				margin-right: 5px;
			}
			address {
				font-size: 9pt;
				color: #777;
			}
			#checkfront_status {
				display: inline-block;
				padding: .5em 1em .5em 1em;
				margin-top: 1em;
				width: 8em;
				border-radius: 5px;
				color: #fff;
				font-size: 13pt;
				font-weight: bold;
				text-align: center;
				text-transform: uppercase;
			}
			.show-cell-webkit {
				display: none;
			}
			.show-cell-webkit:not(*:root) {
				display: table-cell;
			}
			.xprint{ display: none !important; }
</style>