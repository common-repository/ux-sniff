<?php 
if( !defined( 'ABSPATH' ) ) exit;

function parse_json_from_url($url) {
    // Use wp_remote_get to fetch the data
    $response = wp_remote_get($url);

    // Check if the request was successful
    if (is_wp_error($response)) {
        // Handle error gracefully
        return null;
    }

    $body = wp_remote_retrieve_body($response); // Retrieves the response body.
    if (!empty($body)) {
        return json_decode($body);
    }

    // If there was no response body or json could not be parsed, return null
    return null;
}
    
if(isset($_POST['submit_option'])){
	
	$footer_script = sanitize_text_field($_POST['footer_script']);



		$nonce=$_POST['insert_script_wpnonce'];
		if(wp_verify_nonce( $nonce, 'insert_script_option_nonce' ))
		{

			$domain = sanitize_text_field($_POST['domain']);
			$json = parse_json_from_url('https://uxsniff.com/user/api?domain='.$domain);
			$obj = $json;

			if(!is_null($obj)) {


			$key = md5($obj->id);

			if($key == $footer_script) {
				update_option('uxsniff_info',$footer_script);
				update_option('uxsniff_domain',$domain);
				$successmsg= uxsniff_success_option_msg('Settings Saved.');
			} else {
				$errormsg= uxsniff_failure_option_msg('Invalid API key for domain '.$domain.' using key: '.$footer_script.', id: '.$obj->id);
			}
		} else {
			$errormsg= uxsniff_failure_option_msg('Verification of API key failed. PHP function: file_get_contents is disabled on your server. Please enable "allow_url_fopen" on your server.');
		}
			
		}
		else
		{
			if(!ini_get('allow_url_fopen') ) $errormsg= uxsniff_failure_option_msg('Verification of API key failed. PHP function: file_get_contents is disabled on your server. Please enable "allow_url_fopen" on your server.');
	        else $errormsg= uxsniff_failure_option_msg('Unable to save data!');
	    }
	
}


$footer_script = uxsniff_get_option_footer_script();
$footer_domain = uxsniff_get_option_footer_domain();
?>


<div class="uxsniff_header">
<div class="logo"></div>
<h2>Settings</h2>
<div class="uxsniff_clear"></div>
</div>
<div class="uxsniff_clear"></div>
    <?php
    if ( isset( $successmsg ) ) {
        ?>
        <div class="ishf_updated fade"><p><?php echo $successmsg; ?></p></div>
        <?php
    }
    if ( isset( $errormsg ) ) {
        ?>
        <div class="error fade"><p><?php echo $errormsg; ?></p></div>
        <?php
    }
    ?>
		
	<div class='ishf_inner'>

<?php
            if(isset($footer_domain) && $footer_domain!='') $domain = $footer_domain;
            else {
				$protocol = isset($_SERVER['HTTPS'])? 'https://' : 'http://';
				$domain = $protocol.$_SERVER['SERVER_NAME'];
			}
			$json = parse_json_from_url('https://uxsniff.com/user/api?domain='.$domain);
			$obj = $json;
			$key = md5($obj->id);
			$plan = $obj->plan;
			$active = ($footer_script==$key)?true:false;

?>


<?php if(!$active) { ?>

<p>Thank you for using UX Sniff. Please paste your UX Sniff API key here to activate your tracking. </p>
<p>
Don't have an API key?
<br/><a class="button button-primary " target="_blank" href="https://app.uxsniff.com/wordpress-setup?utm_source=wpplugin">Sign-up an account and get your API key for free</a></p>


		<h4 class="heading-h4">Paste your API key below</h4>

<?php }  else { ?>

      <p>Your tracking is active. Thank you for using UX Sniff. <br/><a href="https://app.uxsniff.com/login?utm_source=wpplugin" target="_blank">Log in</a> to UXsniff for more features such as recordings, users journey and engagement reports.</p>

      <h4 class="heading-h4">Your Plan</h4>


<style>
table.uxs-protocols {
  border-top: 1px solid #DDDDDE;
  border-right: 1px solid #DDDDDE;
  margin: 10px 0px 10px 0px;
  width: 80%;
}
table.uxs-protocols td.bold {
	font-weight: bold;
}
table.uxs-protocols td {
  font-size: 14px;
  line-height: 24px;
  width: 70%;
  padding: 6px 12px;
  border-bottom: 1px solid #DDDDDE;
  border-left: 1px solid #DDDDDE;
}
</style>
      <table class="uxs-protocols" cellspacing="0" cellpadding="0"><tbody>
      	<tr><td class="bold">Plan</td><td><?php echo $obj->plan==0?'Free':($obj->plan==1?'Poodle':($obj->plan==2?'Hound':($obj->plan==3?'K-9':($obj->plan==4?'Wolf pack':''))));?> </td></tr>
      	<tr><td class="bold">Daily pageviews remaining</td><td><?php echo $obj->pageviews;?> </td></tr>
      	<tr><td class="bold">Daily recordings remaining</td><td><?php echo $obj->recordings;?> </td></tr>
      </tbody></table>

<a class="button button-primary " href="https://uxsniff.com/pricing?utm_source=wpplugin" target="_blank">Upgrade</a>


      <h4 class="heading-h4">Your API key</h4>

<?php }  ?>
		<form method="post">
			
			
			<p><label>Your API key:</label><br/>
				<input type="text" name="footer_script" value="<?php  echo esc_html($footer_script); ?>" style="width:280px;">
				<div class="uxsniff_clear"></div>
				<!--The uxsniff tracking script will be printed before the end of the <code>&lt;body&gt;</code> tag.-->
			</p>
			<input type="hidden" name="insert_script_wpnonce" value="<?php echo $nonce= wp_create_nonce('insert_script_option_nonce'); ?>">


			
			<p><label>Your domain name registered on UXsniff:</label><br/>
			<input type="text" name="domain" value="<?php echo $domain; ?>">
			</p>
			<input type="submit" class="button button-primary " name="submit_option" value="Save">
			
		</form>
		
		
	</div>
	

