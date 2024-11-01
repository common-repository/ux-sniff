<?php  
if( !defined( 'ABSPATH' ) ) exit;
function uxsniff_get_option_footer_script()
{
	return $footer_script=  wp_unslash(get_option('uxsniff_info'));
}

function uxsniff_get_option_footer_domain()
{
	return $footer_domain=  wp_unslash(get_option('uxsniff_domain'));
}

function  uxsniff_failure_option_msg($msg)
{
	
	echo  '<div class="notice notice-error ishf-error-msg is-dismissible"><p>' . $msg . '</p></div>';	
	
}
function  uxsniff_success_option_msg($msg)
{
	
	
	echo ' <div class="notice notice-success ishf-success-msg is-dismissible"><p>'. $msg . '</p></div>';			
	
}

function uxsniff_output(){
	
	if ( apply_filters( 'disable_insert', false ) || apply_filters( 'disable_insert_footer', false ) ) {
		return;
	}

	$meta = get_option( 'uxsniff_info' );
	if ( empty( $meta ) || trim( $meta ) == '' ) {
		return;
	}

	echo "<script>
    (function(u,x,s,n,i,f){
        u.ux=u.ux||function(){(u.ux.q=u.ux.q||[]).push(arguments)};
        i=x.getElementsByTagName('head')[0]; f=x.createElement('script');f.async=1; f.src=s+n;
        i.appendChild(f);
    })(window,document,'https://api.uxsniff.com/cdn/js/uxsnf_track','.js');
	</script>";
	
}


?>
