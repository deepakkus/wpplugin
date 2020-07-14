<?php
$return_url='?start_date='.$start_date.'&end_date='.$end_date.'&cart=10';
$get_4gpay= new manage4geeksClass();
$book_obj = new Booking();
$pay4g_config = $get_4gpay->get_pay4geeks_info();
$row_count = count($pay4g_config);
if($row_count < 1) {
	echo "<script type='text/javascript'>  alert('4Geek Config Not setup correctly');  window.location='".$return_url."'; </script>";
}
else
{
	foreach($pay4g_config as $r) {
	 $client_id = $r->client_id;	
	 $client_secret_key = $r->client_secret_key	;
	}
	if($client_id =='')
	{
		echo "<script type='text/javascript'>  alert('Empty Clent ID');  window.location='".$return_url."'; </script>";
	}
	else if($client_secret_key == '')
	{
		echo "<script type='text/javascript'>  alert('Empty Client Secret Key');  window.location='".$return_url."'; </script>";
	}
}
$api_auth_url = 'https://api.payments.4geeks.io/authentication/token/';
$api_url = 'https://api.payments.4geeks.io/v1/charges/simple/create/';
$customer_url = 'https://api.payments.4geeks.io/v1/accounts/customers/';
$c_id = $client_id;
$c_secret = $client_secret_key;
$data_to_send = array("grant_type" => "client_credentials",
								"client_id" => $c_id,
								"client_secret" => $c_secret );
$response_token = wp_remote_post( $api_auth_url, array(
				'method' => 'POST',
				'timeout' => 90,
				'blocking' => true,
				'headers' => array('content-type' => 'application/json'),
				'body' => json_encode($data_to_send, true)
			) );

//$api_token = json_decode( wp_remote_retrieve_body($response_token), true)['access_token'];
$res = json_decode( wp_remote_retrieve_body($response_token), true);
$api_token = $res['access_token'];
$err = $res['error'];
if($err =='invalid_client')
{
	echo "<script type='text/javascript'>  alert('Invalid Clent ID or Secret Key');  window.location='".$return_url."'; </script>";
}
else
{	
$exp_dt = $_POST['exp'];
$exp_info = (explode("/",$exp_dt));
$exp_month = $exp_info[0];
$exp_year = $exp_info[1];

$payload = array(
				"amount"             	=> $_POST['total_pay'],
				"description"           => 'Pay By '.$_POST['CardType'],
				"entity_description"    => 'Costa Rica Vacationing',
				"currency"           	=> 'USD',
				"credit_card_number"    => $_POST['card_no'],
				"credit_card_security_code_number" => $_POST['cvc'],
				"exp_month" 			=> $exp_month,
				"exp_year" 				=> $exp_year,

    );
// Send this payload to 4GP for processing
	$response = wp_remote_post( $api_url, array(
			'method'    => 'POST',
			'body'      => json_encode($payload, true),
			'timeout'   => 90,
			'blocking' => true,
			'headers' => array('authorization' => 'bearer ' . $api_token, 'content-type' => 'application/json'),
	) );
	  $pay_return = json_decode( wp_remote_retrieve_body($response), true);
	  //var_dump($pay_return);
      $pay_id = $pay_return['charge_id'];
      $responde_code = wp_remote_retrieve_response_code( $response );
	 if($responde_code == '201') 
	 {
// success code goes here
?>			  

<div class="row pay-4gthank">
  <p style="margin: 15px;font-size: 16px;color:  black;" class="ct"><i class="fa fa-envelope"></i> A copy of this receipt has been e-mailed to you .</p>
 <p style=" margin: 25px 15px; font-size: 17px;color: black;">
 <a href="/reserve/passbook/?id=VZYG-250717&amp;CFX=86079bd4943de1a04a46b214364e271cc13ef6e17074d29c9b1eeb453f3df47c">
   <img src="https://crvacationing.checkfront.com/images/extend/Add_to_Apple_Wallet.svg" width="126">
 </a>
 </p>
 <div class="auto_width_setting col-sm-12 col-xs-12 col-md-12 col-lg-7">
<?php
$book_id = $_POST['book_id'];
$pay_status = $book_obj->payment_status(
			array(
				'book_id'=>$book_id,
			     'set_paid' => 1,
				 'notify'=>'true',
			)
		  );
		  
$invoice_paid = $book_obj->invoice($book_id);
echo $invoice_paid['booking']['invoice']['html'];  // get paid invoice html format by booking id
?>          
</div>

 <div class="auto_width_setting col-sm-12 col-xs-12 col-md-12 col-sm-4" style="padding: 10px;">
 <h2 style="color:black; font-size:20px; padding: 0px; text-align:left; margin: 0px;">Thank You For Your Payment</h2> <br/>
 <p style="color:#000; font-size:16px; text-align: left; margin: 15px 5px; line-height: 1.5em;">payment ID: # <strong><?php echo $pay_id; ?></strong></p>
 <p style="margin: 15px 5px;"> <a href="?start_date=<?php echo $_GET['start_date']; ?>&end_date=<?php echo $_GET['end_date']; ?>"><i class="fa fa-globe"></i> Return to costaricavacationing.com</a> </p>
 <p style="margin: 15px 5px;"><a href="?start_date=<?php echo $_GET['start_date']; ?>&end_date=<?php echo $_GET['end_date']; ?>"><i class="fa fa-plus-circle"></i> Create another booking</a> </p>
 
 <p style="margin: 30px 5px;text-align: center;display: block !important;"><a href="https://www.checkfront.com" style="display: block !important;background: url(https://crvacationing.checkfront.com/images/logo/Checkfront-Icon-32.png)  no-repeat;background-size: 16px 16px;color: #46515d;font-weight: bold;font-size: 12px;padding: 2px 5px 5px 22px;text-align: left;" id="promo_link">Online Bookings by  Checkfront</a></p>
 
 </div><!--end col-4-->
</div>
		  			  
<?php			  
}
else
{ 

?>

	 <h2 class="payerrormsg">Something wrong here !!</h2>
	 <center><a href="<?php echo $_SERVER['SCRIPT_URI']; ?>" class="btn btn-primary">Back To Home</a></center>
<?php 
    
} 
}   
?>
<style type="text/css">
.pay-4gthank{
    font: 11pt "Helvetica Neue",Helvetica,Arial,sans-serif;
}
.payerrormsg { 
line-height: 1.3em;
color: rgba(0,83,135,0.93) !important;
font-family: Josefin Sans, sans-serif;
font-weight: 700 !important;
text-align:center;
font-size: 28px !important;
}
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
				padding: 8px;
				font-size:13px;
			}
			.invoice_details td {
				text-align: right;
    				padding: 5px;
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