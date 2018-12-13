<?php
/**
 * Plugin Name:       Contact Form 7 Image Captcha
 * Plugin URI:        https://wordpress.org/plugins/contact-form-7-image-captcha/
 * Description:       Add a simple image captcha and Honeypot to contact form 7
 * Version:           2.4.1
 * Author:            KC Computing
 * Author URI:        https://profiles.wordpress.org/ktc_88
 * License:           GNU General Public License v2
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       contact-form-7-image-captcha
 */

/*
 * RESOURCE HELP
 * http://stackoverflow.com/questions/17541614/use-thumbnail-image-instead-of-radio-button
 * http://jsbin.com/pafifi/1/edit?html,css,output
 * http://jsbin.com/nenarugiwe/1/edit?html,css,output
 */

/**
 * Add "Go Pro" action link to plugins table
 */
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'cf7ic_plugin_action_links' );
function cf7ic_plugin_action_links( $links ) {
    return array_merge(
        array(
            'go-pro' => '<a href="http://kccomputing.net/downloads/contact-form-7-image-captcha-pro/">' . __( 'Go Pro', 'contact-form-7-image-captcha' ) . '</a>'
        ),
        $links
    );
}

/**
 * Load Textdomains
 */
add_action('plugins_loaded', 'cf7ic_load_textdomain');
function cf7ic_load_textdomain() {
    load_plugin_textdomain( 'contact-form-7-image-captcha', false, dirname( plugin_basename(__FILE__) ) . '/lang' );
}

/**
 * Register/Enqueue CSS on initialization
 */
add_action('init', 'cf7ic_register_style');
function cf7ic_register_style() {
    wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
    wp_register_style( 'cf7ic_style', plugins_url('/style.css', __FILE__), false, '1.1.0', 'all');
}

/**
 * Add custom shortcode to Contact Form 7
 */
add_action( 'wpcf7_init', 'add_shortcode_cf7ic' );
function add_shortcode_cf7ic() {
    wpcf7_add_form_tag( 'cf7ic', 'call_cf7ic', true );
}

/**
 * cf7ic shortcode
 */
function call_cf7ic( $tag ) {  
    $tag = new WPCF7_FormTag( $tag );
    $toggle = '';
    if($tag['raw_values']) {
        $toggle = $tag['raw_values'][0];
    }

    wp_enqueue_style( 'cf7ic_style' ); // enqueue css

    // Create an array to hold the image library
    $captchas = array(
        __( 'Heart', 'contact-form-7-image-captcha') => "fa-heart",
        __( 'House', 'contact-form-7-image-captcha') => "fa-home",
        __( 'Star', 'contact-form-7-image-captcha')  => "fa-star",
        __( 'Car', 'contact-form-7-image-captcha')   => "fa-car",
        __( 'Cup', 'contact-form-7-image-captcha')   => "fa-coffee",
        __( 'Flag', 'contact-form-7-image-captcha')  => "fa-flag",
        __( 'Key', 'contact-form-7-image-captcha')   => "fa-key",
        __( 'Truck', 'contact-form-7-image-captcha') => "fa-truck",
        __( 'Tree', 'contact-form-7-image-captcha')  => "fa-tree",
        __( 'Plane', 'contact-form-7-image-captcha') => "fa-plane"
    );

    $choice = array_rand( $captchas, 3);
    foreach($choice as $key) {
        $choices[$key] = $captchas[$key];
    }

    // Pick a number between 0-2 and use it to determine which array item will be used as the answer
    $human = rand(0,2);

    if($toggle == 'toggle') {
        $style = 'style="display: none;"';
        $script = ' <script>
                        jQuery(document).ready(function(){
                        jQuery("body").on("focus", "form.wpcf7-form", function(){ 
                                jQuery(".captcha-image").show();
                                console.log("focused");
                            });
                        })
                    </script>';
    } else { 
        $style = '';
        $script = '';
    }

    $output = $script.' 
    <span class="captcha-image" '.$style.'>
        <span class="cf7ic_instructions">';
            $output .= __('Please prove you are human by selecting the ', 'contact-form-7-image-captcha');
            $output .= '<span>'.$choice[$human].'</span>';
            $output .= __('.', 'contact-form-7-image-captcha').'</span>';
        $i = -1;
        foreach($choices as $title => $image) {
            $i++;
            if($i == $human) { $value = "kc_human"; } else { $value = "bot"; };
            $output .= '<label><input type="radio" name="kc_captcha" value="'. $value .'" /><i class="fa '. $image .'"></i></label>';
        }
    $output .= '
    </span>
    <span style="display:none">
        <input type="text" name="kc_honeypot">
    </span>';

    return '<span class="wpcf7-form-control-wrap kc_captcha"><span class="wpcf7-form-control wpcf7-radio">'.$output.'</span></span>';
}

/**
 * Custom validator
 */
 add_filter('wpcf7_validate_cf7ic*','cf7ic_check_if_spam', 10, 2);
 add_filter('wpcf7_validate_cf7ic','cf7ic_check_if_spam', 10, 2);
function cf7ic_check_if_spam( $result, $tag ) {
    $tag = new WPCF7_Shortcode( $tag );
    $kc_val1 = isset( $_POST['kc_captcha'] ) ? trim( $_POST['kc_captcha'] ) : '';   // Get selected icon value
    $kc_val2 = isset( $_POST['kc_honeypot'] ) ? trim( $_POST['kc_honeypot'] ) : ''; // Get honeypot value

    if(!empty($kc_val1) && $kc_val1 != 'kc_human' ) {
        $tag->name = "kc_captcha";
        $result->invalidate( $tag, __('Please select the correct icon.', 'contact-form-7-image-captcha') );
    }
    if(empty($kc_val1) ) {
        $tag->name = "kc_captcha";
        $result->invalidate( $tag, __('Please select an icon.', 'contact-form-7-image-captcha') );
    }
    if(!empty($kc_val2) ) {
        $tag->name = "kc_captcha";
        $result->invalidate( $tag, wpcf7_get_message( 'spam' ) );
    }
    return $result;
}


// Add Contact Form Tag Generator Button
add_action( 'wpcf7_admin_init', 'cf7ic_add_tag_generator', 55 );

function cf7ic_add_tag_generator() {
	$tag_generator = WPCF7_TagGenerator::get_instance();
	$tag_generator->add( 'cf7ic', __( 'Image Captcha', 'contact-form-7-image-captcha' ),
		'cf7ic_tag_generator', array( 'nameless' => 1 ) );
}

function cf7ic_tag_generator( $contact_form, $args = '' ) {
	$args = wp_parse_args( $args, array() ); ?>
	<div class="control-box">
    	<fieldset>
    	    <legend>Coming soon to <a href="http://kccomputing.net/downloads/contact-form-7-image-captcha-pro/" target="_blank">Contact Form 7 Image Captcha Pro</a>, edit the styling directly from this box.</legend>
    	</fieldset>
	</div>
	<div class="insert-box">
		<input type="text" name="cf7ic" class="tag code" readonly="readonly" onfocus="this.select()" />
		<div class="submitbox">
		    <input type="button" class="button button-primary insert-tag" value="<?php echo esc_attr( __( 'Insert Tag', 'contact-form-7' ) ); ?>" />
		</div>
	</div>
<?php
}
