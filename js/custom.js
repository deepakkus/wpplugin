jQuery(document).ready(function(){
jQuery("#start_date").datepicker({ dateFormat: 'yy-mm-dd',  minDate: 0 });
jQuery("#end_date").datepicker({ dateFormat: 'yy-mm-dd',minDate: 0 });
});
	
function redirect(url){
window.location.href = url;
}
function redirectUrl(){
var sdate=jQuery("#start_date").val();
var edate=jQuery("#end_date").val();
var urlred="?start_date="+sdate+"&end_date="+edate;
window.location.href = urlred;		
}  	


	
	
jQuery(function(){  
	var dateToday = new Date(); 
	 jQuery('.alt_start_date').datepicker({ dateFormat: 'yy-m-d',minDate: dateToday });
	 jQuery('.alt_start_date').datepicker({ dateFormat: 'yy-m-d',minDate: dateToday });
	 
	 
});
function displayImg(path,title,id){
	var clsp='photo-title-'+id;
	var cls='item-photo-'+id;
	if(title!=''){
		jQuery("."+clsp+"").html(title);
	}
	jQuery("."+cls+"").css("background-image", "none"); 
	jQuery("."+cls+"").css("background-image", "url('"+path+"')");  
}
function calPrice(price,id){ 
	var priceid='cf-param_perpersontour-'+id;
	var cnt=document.getElementById(priceid).value;
	var item_price=price;
	 var pprice = item_price.replace(",","");
	var price=pprice*cnt;
	var chprice='changePrice-'+id;
	document.getElementById(chprice).innerHTML='<b>$'+price+'</b>';
}

//code to dispaly detials
function dispaydetails(id){
	jQuery("#cf-item-summary-"+id+"").addClass('active');
	jQuery("#cf-item-book-"+id+"").removeClass('active');
	jQuery("#cf-item-cal-"+id+"").removeClass('active');
	jQuery("#cf-item-photo-"+id+"").removeClass('active');
	jQuery("#cf-item-video-"+id+"").removeClass('active');
	var detailid='details-'+id;
	jQuery("."+detailid+"").css("display","block");
	var bookingid='booking-'+id;
	jQuery("."+bookingid+"").css("display","none");
	var phto='cf-item-photo-'+id;
	jQuery("."+phto+"").css("display","none");
	
	var video='cf-item-video-'+id;
	jQuery("."+video+"").css("display","none");
	var picgal='picgal-'+id;
	jQuery("."+picgal+"").css("display","none");
	
	var avail='cf-item-cal-'+id;
	jQuery("."+avail+"").css("display","none");
	jQuery(".footer_dis").css("display","none");
	var img="showimg-"+id;
	jQuery("#"+img+"").css("display","none");
	
}
//code to display availability
function dispayavail(id){
	jQuery("#cf-item-summary-"+id+"").removeClass('active');
	jQuery("#cf-item-book-"+id+"").removeClass('active');
	jQuery("#cf-item-cal-"+id+"").addClass('active');
	jQuery("#cf-item-photo-"+id+"").removeClass('active');
	jQuery("#cf-item-video-"+id+"").removeClass('active');
	var detailid='details-'+id;
	jQuery("."+detailid+"").css("display","none");
	var bookingid='booking-'+id;
	jQuery("."+bookingid+"").css("display","none");
	var phto='cf-item-photo-'+id;
	jQuery("."+phto+"").css("display","none");
	
	var video='cf-item-video-'+id;
	jQuery("."+video+"").css("display","none");
	
	var picgal='picgal-'+id;
	jQuery("."+picgal+"").css("display","none");
	var avail='cf-item-cal-'+id;
	jQuery("."+avail+"").css("display","block");
	jQuery(".footer_dis").css("display","block");
	var img="showimg-"+id;
	jQuery("#"+img+"").css("display","none");
	
}
//code to display photos
function dispayphotos(id){
	jQuery("#cf-item-summary-"+id+"").removeClass('active');
	jQuery("#cf-item-book-"+id+"").removeClass('active');
	jQuery("#cf-item-cal-"+id+"").removeClass('active');
	jQuery("#cf-item-photo-"+id+"").addClass('active');
	jQuery("#cf-item-video-"+id+"").removeClass('active');
	var detailid='details-'+id;
	jQuery("."+detailid+"").css("display","none");
	var bookingid='booking-'+id;
	jQuery("."+bookingid+"").css("display","none");
	var phto='cf-item-photo-'+id;
	jQuery("."+phto+"").css("display","block");
	var picgal='picgal-'+id;
	jQuery("."+picgal+"").css("display","block");
	var video='cf-item-video-'+id;
	jQuery("."+video+"").css("display","none");
	
	
	var avail='cf-item-cal-'+id;
	jQuery("."+avail+"").css("display","none");
	jQuery(".footer_dis").css("display","none");
	var img="showimg-"+id;
	jQuery("#"+img+"").css("display","block");
	
}
//code to display booking
function dispaybooking(id){
	jQuery("#cf-item-summary-"+id+"").removeClass('active');
	jQuery("#cf-item-book-"+id+"").addClass('active');
	jQuery("#cf-item-cal-"+id+"").removeClass('active');
	jQuery("#cf-item-photo-"+id+"").removeClass('active');
	jQuery("#cf-item-video-"+id+"").removeClass('active');
	var bookingid='booking-'+id;
	jQuery("."+bookingid+"").css("display","block");
	var detailid='details-'+id;
	jQuery("."+detailid+"").css("display","none");
	var phto='cf-item-photo-'+id;
	jQuery("."+phto+"").css("display","none");
	
	var video='cf-item-video-'+id;
	jQuery("."+video+"").css("display","none");
	var picgal='picgal-'+id;
	jQuery("."+picgal+"").css("display","none");
	
	var avail='cf-item-cal-'+id;
	jQuery("."+avail+"").css("display","none");
	jQuery("#"+img+"").css("display","none");
	modal.style.display = 'block';
	
}

//code to display video
function displayvideo(id){
	jQuery("#cf-item-summary-"+id+"").removeClass('active');
	jQuery("#cf-item-book-"+id+"").removeClass('active');
	jQuery("#cf-item-cal-"+id+"").removeClass('active');
	jQuery("#cf-item-photo-"+id+"").removeClass('active');
	jQuery("#cf-item-video-"+id+"").addClass('active');
	
	var bookingid='booking-'+id;
	jQuery("."+bookingid+"").css("display","none");
	var detailid='details-'+id;
	jQuery("."+detailid+"").css("display","none");
	var phto='cf-item-photo-'+id;
	jQuery("."+phto+"").css("display","none");
	
	var video='cf-item-video-'+id;
	jQuery("."+video+"").css("display","block");

       var picgal='picgal-'+id;
	jQuery("."+picgal+"").css("display","none");
	

	var avail='cf-item-cal-'+id;
	jQuery("."+avail+"").css("display","none");
	jQuery("#"+img+"").css("display","none");
	modal.style.display = 'block';
	
}





//here is code to display details popup 
function displayrec(id){
	
	jQuery("#cf-item-summary-"+id+"").addClass('active');
	jQuery("#cf-item-book-"+id+"").removeClass('active');
       jQuery("#cf-item-video-"+id+"").removeClass('active');
	var detailid='details-'+id;
	jQuery("."+detailid+"").css("display","block");
	var bookingid='booking-'+id;
	jQuery("."+bookingid+"").css("display","none");
var video='cf-item-video-'+id;
	jQuery("."+video+"").css("display","none");
	var modal_id='addtocart-'+id;
	var modal = document.getElementById(modal_id);
	var myBtn_id='add_to_cart-'+id;
	var btn = document.getElementById(myBtn_id);
	var span = document.getElementsByClassName('close')[0];
	modal.style.display = 'block';
}


jQuery(function(){  
	var dateToday = new Date(); 
	 jQuery('#start_date').datepicker({ dateFormat: 'yy-m-d',minDate: dateToday  });
	 jQuery('#end_date').datepicker({ dateFormat: 'yy-m-d',minDate: dateToday });
	 jQuery('#alt_start_date').datepicker({ dateFormat: 'yy-m-d' });
	 jQuery('#alt_end_date').datepicker({ dateFormat: 'yy-m-d' });
	 	 
});

function add_to_cart(id){ 
	jQuery("#cf-item-summary-"+id+"").removeClass('active');
	jQuery("#cf-item-book-"+id+"").addClass('active');
jQuery("#cf-item-video-"+id+"").removeClass('active');
	var detailid='details-'+id;
	jQuery("."+detailid+"").css("display","none");
	var bookingid='booking-'+id;
	jQuery("."+bookingid+"").css("display","block");
var video='cf-item-video-'+id;
	jQuery("."+video+"").css("display","none");
	var modal_id='addtocart-'+id;
	var modal = document.getElementById(modal_id);
	var myBtn_id='add_to_cart-'+id;
	var btn = document.getElementById(myBtn_id);
	var span = document.getElementsByClassName('tutorial-btn-close-modal')[0];
	modal.style.display = 'block';
 };

function showPrice(price,id){
		var sdate=jQuery("#alt_start_date-"+id+"").val();
		var edate=jQuery("#alt_end_date-"+id+"").val();
		var priceid='cf-param_perpersontour-'+id;
		var cnt=document.getElementById(priceid).value;
		var price=price*cnt;
		
	}