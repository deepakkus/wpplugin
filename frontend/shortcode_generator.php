<?php
add_shortcode('checkfront_cat', 'checkfront_on_process_func');
function checkfront_on_process_func($cat='') { 
	ob_start();
   	echo '<div id="main_checkfront_div">';
  include 'wp-content/plugins/checkfront-4geek/frontend/checkfront_shortcode.php';
    echo "</div>";
    return ob_get_clean();

}
?>