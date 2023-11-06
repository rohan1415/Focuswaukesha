<?php
/**
 * Custom functions added to all projects
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package BaseTheme Package
 * @since 1.0.0
 */

/**
 * Excerpt Function
 *
 * Function used to create custom excerpt.
 */
add_action('init', 'cyb_start_session', 1);


function cyb_start_session()
{
	if (!session_id()) {
		session_start();
	}
}
function custom_excerpt($count)
{
	global $post;
	$permalink = get_permalink($post->ID);
	$excerpt = get_the_excerpt();
	$excerpt = strip_tags($excerpt);
	$excerpt = substr($excerpt, 0, $count);
	$excerpt = substr($excerpt, 0, strripos($excerpt, ' '));
	$excerpt = $excerpt . ' ...';
	$excerpt = $excerpt;
	return $excerpt;
}


/**
 * Excerpt with no read more option
 *
 * Function used to create custom excerpt.
 */
function custom_excerpt_nomore($count)
{
	global $post;
	$permalink = get_permalink($post->ID);
	$excerpt = get_the_excerpt();
	$excerpt = strip_tags($excerpt);
	$excerpt = substr($excerpt, 0, $count);
	$excerpt = substr($excerpt, 0, strripos($excerpt, ' '));
	$excerpt = $excerpt;
	return $excerpt;
}


/**
 * Pagination Function
 *
 * The pagination function to display pagination on any archive page
 */
function custom_pagination($pages = '', $range = 4)
{
	$showitems = ($range * 2) + 1;

	global $paged;
	if (empty($paged)) {
		$paged = 1;
	}

	if ($pages == '') {
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if (!$pages) {
			$pages = 1;
		}
	}

	if (1 != $pages) {
		echo '<div class="pagination"><span>Page ' . $paged . ' of ' . $pages . '</span>';
		if ($paged > 2 && $paged > $range + 1 && $showitems < $pages) {
			echo "<a href='" . get_pagenum_link(1) . "'>&laquo; First</a>";
		}
		if ($paged > 1 && $showitems < $pages) {
			echo "<a href='" . get_pagenum_link($paged - 1) . "'>&lsaquo; Previous</a>";
		}

		for ($i = 1; $i <= $pages; $i++) {
			if (1 != $pages && (!($i >= $paged + $range + 1 || $i <= $paged - $range - 1) || $pages <= $showitems)) {
				echo ($paged == $i) ? '<span class="current">' . $i . '</span>' : "<a href='" . get_pagenum_link($i) . "' class=\"inactive\">" . $i . '</a>';
			}
		}

		if ($paged < $pages && $showitems < $pages) {
			echo '<a href="' . get_pagenum_link($paged + 1) . '">Next &rsaquo;</a>';
		}
		if ($paged < $pages - 1 && $paged + $range - 1 < $pages && $showitems < $pages) {
			echo "<a href='" . get_pagenum_link($pages) . "'>Last &raquo;</a>";
		}
		echo "<div class='clear'></div></div>\n";
	}
}


/**
 * Allow SVG files upload in WordPress Media panel - Default restricted
 */
function custom_svg_upload_support($mimes)
{
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}

add_filter('upload_mimes', 'custom_svg_upload_support');


/**
 * Remove default WordPress login logo link & set it to homepage of site
 */
function custom_login_logo_url($url)
{
	return '"' . home_url() . '"';
}

add_filter('login_headerurl', 'custom_login_logo_url');


/**
 * Add viewport meta tag in head
 */
function custom_viewport()
{
	echo '
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	';
}

add_action('wp_head', 'custom_viewport');


/**
 * Gravity forms filters
 */
add_filter('gform_confirmation_anchor', '__return_true');
add_filter('gform_init_scripts_footer', '__return_true');

// Set Tabindex For Gravity Form
add_filter('gform_tabindex', 'change_tabindex', 10, 2);
function change_tabindex($tabindex, $form)
{
	return 10;
}

/**
 * First and last menu item classes
 */
function first_last_menu_classes($items)
{
	if ($items) {
		$items[1]->classes[] = 'first-menu-item';
		$items[count($items)]->classes[] = 'last-menu-item';
		return $items;
	}
	return $items;
}
add_filter('wp_nav_menu_objects', 'first_last_menu_classes');

/**
 * Gravity Forms
 *
 * Disable the tab-index
 */

add_filter('gform_tabindex', '__return_false');



/**
 * Set favicon of dashboard
 */

function mwd_theme_favicon()
{
	$favicon_path = get_template_directory_uri() . '/assets/img/pwa/favicon.ico';

	echo '<link rel="shortcut icon" href="' . esc_url($favicon_path) . '" />';
}

add_action('admin_head', 'mwd_theme_favicon');

/**
 * Function to remove the starting words from the_archive_title()
 *
 * E.g. from Category : Dallas Neighborhoods => Dallas Neighborhoods
 */

function mwd_theme_archive_title($title)
{
	if (is_category()) {
		$title = single_cat_title('', false);
	} elseif (is_tag()) {
		$title = single_tag_title('', false);
	} elseif (is_author()) {
		$title = get_the_author_meta('display_name');
	} elseif (is_post_type_archive()) {
		$title = post_type_archive_title('', false);
	} elseif (is_tax()) {
		$title = single_term_title('', false);
	}

	return $title;
}

add_filter('get_the_archive_title', 'mwd_theme_archive_title');



/**
 * Custom logo for WordPress login screen
 *
 * This function replaces the default WordPress logo on the login with website logo.
 */
function mwd_login_logo()
{
	echo '
		<style type="text/css">
			.login h1 a {
				background-image: url(' . get_stylesheet_directory_uri() . '/assets/img/logo.jpg) !important;
				background-position: center center;
				color:rgba(0, 0, 0, 0);
				background-size: contain;
				height: 80px;
				width: 80%;
				outline: 0;
			}
		</style>
	';
}

add_action('login_head', 'mwd_login_logo');

// removing parmalink from team cpt
add_action('admin_head', 'wpds_custom_admin_post_css');
function wpds_custom_admin_post_css()
{

	global $post_type;

	if ($post_type == 'team') {
		echo '<style>#edit-slug-box {display:none;}</style>';
	}
}


add_action('init', 'register_new_item_endpoint');

/**
 * Register New Endpoint.
 *
 * @return void.
 */
function register_new_item_endpoint()
{
	add_rewrite_endpoint('add-business-listing', EP_ROOT | EP_PAGES);
	add_rewrite_endpoint('business-listing', EP_ROOT | EP_PAGES);
	add_rewrite_endpoint('event-listing', EP_ROOT | EP_PAGES);
	add_rewrite_endpoint('ads-listing', EP_ROOT | EP_PAGES);
	add_rewrite_endpoint('claim-business', EP_ROOT | EP_PAGES);
	add_rewrite_endpoint('account-details', EP_ROOT | EP_PAGES);
	add_rewrite_endpoint('web-ads-listing', EP_ROOT | EP_PAGES);
	add_rewrite_endpoint('add-web-ads', EP_ROOT | EP_PAGES);
	add_rewrite_endpoint('add-newsletter-ads', EP_ROOT | EP_PAGES);
	add_rewrite_endpoint('add-video-ads', EP_ROOT | EP_PAGES);
	add_rewrite_endpoint('add-sponsored-content', EP_ROOT | EP_PAGES);
	add_rewrite_endpoint('video-ads-listing', EP_ROOT | EP_PAGES);
	add_rewrite_endpoint('newsletter-ads-listing', EP_ROOT | EP_PAGES);
	add_rewrite_endpoint('ads-packages', EP_ROOT | EP_PAGES);
	//add_rewrite_endpoint('claim-business-status', EP_ROOT | EP_PAGES);
}

add_filter('query_vars', 'new_item_query_vars');

/**
 * Add new query var.
 *
 * @param array $vars vars.
 *
 * @return array An array of items.
 */
function new_item_query_vars($vars)
{

	$vars[] = 'business-listing';
	$vars[] = 'add-business';
	$vars[] = 'event-listing';
	$vars[] = 'ads-listing';
	$vars[] = 'newsletter-ads-listing';
	$vars[] = 'ads-packages';
	$vars[] = 'claim-business';
	$vars[] = 'account-details';
	$vars[] = 'web-ads-listing';
	$vars[] = 'add-web-ads';
	$vars[] = 'add-newsletter-ads';
	$vars[] = 'video-ads-listing';
	$vars[] = 'add-video-ads';
	$vars[] = 'add-sponsored-content';
	//$vars[] = 'claim-business-status';
	return $vars;
}

add_filter('woocommerce_account_menu_items', 'add_new_item_tab');

/**
 * Add New tab in my account page.
 *
 * @param array $items myaccount Items.
 *
 * @return array Items including New tab.
 */
function add_new_item_tab($items)
{
	$logout = $items['customer-logout'];
	$is_active_business_listing = false;
	unset($items['customer-logout']);
	unset($items['edit-account']);
	unset($items['payment-methods']);
	unset($items['edit-address']);

	$items['account-details'] = 'Account Details';
	$items['business-listing'] = 'My Business Directory';
	$items['event-listing'] = 'My Events';
	$items['ads-listing'] = 'Display Advertising';
	$items['newsletter-ads-listing'] = 'eNewsletter Advertising';
	$items['ads-packages'] = 'Advertising Packages';
	
	//$results = get_claimed_business_listing();
	// if (is_array($results) && count($results) > 0) {
    //    $items['claim-business-status'] = 'Claimed Business Status';
    // }
	//$items['claim-business'] = 'Claim Business';


	$items['customer-logout'] = $logout;

	return $items;
}


add_action('woocommerce_account_newsletter-ads-listing_endpoint', 'display_newsletter_ads_listing_item_content');

/**
 * Add content to the new tab.
 *
 * @return  string.
 */
function display_newsletter_ads_listing_item_content()
{
	get_template_part('templates/my-newsletter-ads-listing');
}
add_action('woocommerce_account_ads-packages_endpoint', 'display_ads_packages_item_content');

/**
 * Add content to the new tab.
 *
 * @return  string.
 */
function display_ads_packages_item_content()
{

	get_template_part('templates/my-ads-packages');


}
add_action('woocommerce_account_business-listing_endpoint', 'display_business_listing_item_content');

/**
 * Add content to the new tab.
 *
 * @return  string.
 */
function display_business_listing_item_content()
{

	get_template_part('templates/my-business-listing');


}
add_action('woocommerce_account_add-business-listing_endpoint', 'add_business_listing_item_content');

/**
 * Add content to the new tab.
 *
 * @return  string.
 */
function add_business_listing_item_content()
{

	get_template_part('templates/add-business-listing');


}


add_action('woocommerce_account_claim-business_endpoint', 'add_claim_business_item_content');
function add_claim_business_item_content()
{

	get_template_part('templates/claim-business');


}




add_action('woocommerce_account_event-listing_endpoint', 'add_event_listing_item_content');

/**
 * Add content to the new tab.
 *
 * @return  string.
 */
function add_event_listing_item_content()
{
	
		get_template_part('templates/my-event-listing');
	
}

add_action('woocommerce_account_add-web-ads_endpoint', 'add_web_ads_item_content');

/**
 * Add content to the new tab.
 *
 * @return  string.
 */
function add_web_ads_item_content()
{
	
		get_template_part('templates/add-web-ads');
	
}

add_action('woocommerce_account_add-newsletter-ads_endpoint', 'add_newsletter_ads_item_content');

/**
 * Add content to the new tab.
 *
 * @return  string.
 */
function add_newsletter_ads_item_content()
{
	
		get_template_part('templates/add-newsletter-ads');
	
}


add_action('woocommerce_account_ads-listing_endpoint', 'add_ads_listing_item_content');

/**
 * Add content to the new tab.
 *
 * @return  string.
 */
function add_ads_listing_item_content()
{
	
		get_template_part('templates/my-ads-listing');
	
}
add_action('woocommerce_account_web-ads-listing_endpoint', 'web_ads_listing_item_content');

/**
 * Add content to the new tab.
 *
 * @return  string.
 */
function web_ads_listing_item_content()
{
	
		get_template_part('templates/web-ads-listing');
	
}
add_action('woocommerce_account_claim-business-status_endpoint', 'add_claim_business_listing');

/**
 * Add content to the new tab.
 *
 * @return  string.
 */
// function add_claim_business_listing()
// {
// 	$results = get_claimed_business_listing();
// 	if (is_array($results) && count($results) > 0) {
// 		get_template_part('templates/claim-business-status');
//     }

// }

add_action('woocommerce_account_account-details_endpoint', 'add_account_detailss_item_content');
function add_account_detailss_item_content()
{
get_template_part('templates/account-details');

}

/**
 * Add content to the new tab.
 *
 * @return  string.
 */
function video_ads_listing_item_content()
{
	
		get_template_part('templates/video-ads-listing');
	
}
add_action('woocommerce_account_video-ads-listing_endpoint', 'video_ads_listing_item_content');

add_action('woocommerce_account_add-video-ads_endpoint', 'add_video_ads_item_content');

/**
 * Add content to the new tab.
 *
 * @return  string.
 */
function add_video_ads_item_content()
{
	
		get_template_part('templates/add-video-ads');
	
}
add_action('woocommerce_account_add-sponsored-content_endpoint', 'add_sponsored_content_item_content');

/**
 * Add content to the new tab.
 *
 * @return  string.
 */
function add_sponsored_content_item_content()
{
	
		get_template_part('templates/add-sponsored-content');
	
}

function get_users_active_subscription()
{
	//Get current user's active subscription detail
	$user_id = get_current_user_id();
	$users_subscriptions = wcs_get_users_subscriptions($user_id);

	//echo "<PRE>";print_r($users_subscriptions);
	$subscription_arr = array();
	foreach ($users_subscriptions as $subscription) {

		if ($subscription->has_status(array('active'))) {
			//echo "<PRE>"; print_r($subscription);
			$prod_items = $subscription->get_items();


			foreach ($prod_items as $prod_item) {

				$terms = get_the_terms($prod_item['product_id'], 'product_cat');


				foreach ($terms as $term) {
					$subscription_arr[] = $term->slug;
				}

				//$product = $prod_item->get_product();
				//$subscription_arr[] =$product->get_title();
				//$product_id = $product->get_id();
				// if($product->get_title() == "Basic Listing"):
				// 	$is_active_business_listing=true;
				// endif;
			}

		}
	}
	//echo "<PRE>"; print_r($prod_items);
	return $subscription_arr;
}

function wpse121723_register_footer_widget()
{
	register_sidebar(
		array(
			'name' => 'Footer',
			'id' => 'footer',
			'before_widget' => '<div>',
			'after_widget' => '</div>',
			'before_title' => '<h2 class="">',
			'after_title' => '</h2>',
		));
}
add_action('widgets_init', 'wpse121723_register_footer_widget');


function custom_shortcodes()
{

	add_shortcode('mailchimp_shortcode', 'mailchimp_shortcode_function');
	function mailchimp_shortcode_function()
	{ ?>

		<!-- Begin Mailchimp Signup Form -->
		<!-- <link href="//cdn-images.mailchimp.com/embedcode/classic-071822.css" rel="stylesheet" type="text/css"> -->
		<style type="text/css">
			#mc_embed_signup {
				background: #fff;
				clear: left;
				font: 14px Helvetica, Arial, sans-serif;
				width: 600px;
			}

			/* Add your own Mailchimp form style overrides in your site stylesheet or in this style block.
						We recommend moving this block and the preceding CSS link to the HEAD of your HTML file. */
		</style>
		<div id="mc_embed_signup">
			<form
				action="https://focuswaukesha.us21.list-manage.com/subscribe/post?u=f7ac33ae34ce7a4a32906c1a7&amp;id=b1cf776565&amp;f_id=0047bfe1f0"
				method="post" id="mc-embedded-subscribe-form" name="mc-embedded-subscribe-form" class="validate" target="_blank"
				novalidate>
				<div id="mc_embed_signup_scroll">
					<h2>Subscribe</h2>
					<div class="indicates-required"><span class="asterisk">*</span> indicates required</div>
					<div class="mc-field-group">
						<label for="mce-FNAME">First Name <span class="asterisk">*</span></label>
						<input type="text" value="" name="FNAME" class="required" id="mce-FNAME" required>
						<span id="mce-FNAME-HELPERTEXT" class="helper_text"></span>
					</div>
					<div class="mc-field-group">
						<label for="mce-MMERGE5">Last Name <span class="asterisk">*</span></label>
						<input type="text" value="" name="MMERGE5" class="required" id="mce-MMERGE5" required>
						<span id="mce-MMERGE5-HELPERTEXT" class="helper_text"></span>
					</div>
					<div class="mc-field-group">
						<label for="mce-EMAIL">Email Address <span class="asterisk">*</span>
						</label>
						<input type="email" value="" name="EMAIL" class="required email" id="mce-EMAIL" required>
						<span id="mce-EMAIL-HELPERTEXT" class="helper_text"></span>
					</div>
					<div hidden=""><input type="hidden" name="tags" value="648868"></div>
					<div id="mce-responses" class="clear">
						<div class="response" id="mce-error-response" style="display:none"></div>
						<div class="response" id="mce-success-response" style="display:none"></div>
					</div>
					<!-- real people should not fill this in and expect good things - do not remove this or risk form bot signups-->
					<div style="position: absolute; left: -5000px;" aria-hidden="true"><input type="text"
							name="b_f7ac33ae34ce7a4a32906c1a7_b1cf776565" tabindex="-1" value=""></div>
					<div class="clear"><input type="submit" value="Subscribe" name="subscribe" id="mc-embedded-subscribe"
							class="button"></div>

			</form>
		</div>
		<script type='text/javascript' src='https://focuswaukesha.com/wp-content/themes/focus-waukesha/assets/js/mc-validate.js'></script>
		<script
			type='text/javascript'>(function ($) { window.fnames = new Array(); window.ftypes = new Array(); fnames[0] = 'EMAIL'; ftypes[0] = 'email'; fnames[1] = 'FNAME'; ftypes[1] = 'text'; fnames[2] = 'LNAME'; ftypes[2] = 'text'; fnames[3] = 'ADDRESS'; ftypes[3] = 'address'; fnames[4] = 'PHONE'; ftypes[4] = 'phone'; fnames[5] = 'BIRTHDAY'; ftypes[5] = 'birthday'; }(jQuery)); var $mcj = jQuery.noConflict(true);</script>
		<!--End mc_embed_signup-->

	<?php }
}


add_action('init', 'custom_shortcodes');

function wooc_extra_register_fields()
{ ?>
	<p class="form-row form-row-first">
		<label for="reg_billing_first_name">
		<?php _e('First Name', 'woocommerce'); ?><span class="required">*</span>
	</label>
	<input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name"
		value="<?php if (!empty($_POST['billing_first_name']))
			esc_attr_e($_POST['billing_first_name']); ?>" />
	</p>
	<p class="form-row form-row-last">
		<label for="reg_billing_last_name">
		<?php _e('Last Name', 'woocommerce'); ?><span class="required">*</span>
	</label>
	<input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name"
		value="<?php if (!empty($_POST['billing_last_name']))
			esc_attr_e($_POST['billing_last_name']); ?>" />
	</p>

	<div class="clear"></div>
<?php
}
add_action('woocommerce_register_form_start', 'wooc_extra_register_fields');

function wooc_validate_extra_register_fields($username, $email, $validation_errors)
{

	if (isset($_POST['billing_first_name']) && empty($_POST['billing_first_name'])) {

		$validation_errors->add('billing_first_name_error', __('<strong>Error</strong>: First name is required!', 'woocommerce'));

	}

	if (isset($_POST['billing_last_name']) && empty($_POST['billing_last_name'])) {

		$validation_errors->add('billing_last_name_error', __('<strong>Error</strong>: Last name is required!.', 'woocommerce'));

	}
	return $validation_errors;
}

add_action('woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3);

function wooc_save_extra_register_fields($customer_id)
{

	if (isset($_POST['billing_first_name'])) {
		//First name field which is by default
		update_user_meta($customer_id, 'first_name', sanitize_text_field($_POST['billing_first_name']));
		// First name field which is used in WooCommerce
		update_user_meta($customer_id, 'billing_first_name', sanitize_text_field($_POST['billing_first_name']));
	}
	if (isset($_POST['billing_last_name'])) {
		// Last name field which is by default
		update_user_meta($customer_id, 'last_name', sanitize_text_field($_POST['billing_last_name']));
		// Last name field which is used in WooCommerce
		update_user_meta($customer_id, 'billing_last_name', sanitize_text_field($_POST['billing_last_name']));
	}

}
add_action('woocommerce_created_customer', 'wooc_save_extra_register_fields');

add_action('init', 'verify_user_code');
function verify_user_code()
{
	if (isset($_GET['act'])) {
		$data = unserialize(base64_decode($_GET['act']));
		$code = get_user_meta($data['uid'], 'activation_code', true);
		// verify whether the code given is the same as ours
		if ($code == $data['code']) {
			// update the user meta
			update_user_meta($data['uid'], 'is_activated', 1);
			//add_user_meta( $data['uid'], 'has_business_listing', true);
			add_user_meta($data['uid'], 'business_listing_id', $data['bid']);
			add_post_meta($data['bid'], 'user_id', $data['uid'], true);
			update_field( 'mfw_bd_verified_business_badge', true, $data['bid'] );

			$arg = array(
				'ID' => $data['bid'],
				'post_author' => $data['uid'],
			);
			wp_update_post($arg);
			wc_clear_notices();
			wc_add_notice(__('<strong>Success:</strong> Business has been claimed successfully! ', 'focus-waukesha'));
			if (isset($_GET['iat'])) {
				$html = '';
				$html .= '<br/><br/>Dear <strong>User</strong><br/><br/>';

				$html .= 'The business claim request has been approved by the administrator<br/><br/> Thanks & Regards,<br/>Team Focus Waukesha<br/><br/>';

				$headers = array('Content-Type: text/html; charset=UTF-8');
				$body = get_email_template($html);


				wp_mail($data['uemail'], __('Request to claim the business has been approved', 'focus-waukesha'), $body, $headers);
			}
			global $wpdb;
			$table_name = $wpdb->prefix . 'claim_business'; 
			$where = array(
				'business_id' =>  $data['bid'],
				'user_id' => $data['uid'] 
			);
			$change = array('approval_status' => 'approved', 'approval_date' => current_time('mysql', 1));
			$wpdb->update($table_name,$change, $where);

		}
	}
}

function wpb_set_post_views($postID)
{
	$count_key = 'wpb_post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if ($count == '') {
		$count = 0;
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
	} else {
		$count++;
		update_post_meta($postID, $count_key, $count);
	}
}
//To keep the count accurate, lets get rid of prefetching
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);

function wpb_track_post_views($post_id)
{
	if (!is_single())
		return;
	if (empty($post_id)) {
		global $post;
		$post_id = $post->ID;
	}
	wpb_set_post_views($post_id);
}
add_action('wp_head', 'wpb_track_post_views');

function wpb_get_post_views($postID)
{
	$count_key = 'wpb_post_views_count';
	$count = get_post_meta($postID, $count_key, true);
	if ($count == '') {
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');
		return "0 View";
	}
	return $count . ' Views';
}

function set_user_interest($s_keyword)
{
	$cat = array();
	$tag = array();

	if(isset($_COOKIE['user_interest_cat'])){

		$cat = $_COOKIE['user_interest_cat'];
		$cat = stripslashes($cat);    // string is stored with escape double quotes 
		$cat = json_decode($cat, true);
	}
	if (isset($_COOKIE['user_interest_tag'])) {

		$tag = $_COOKIE['user_interest_tag'];
		$tag = stripslashes($tag); // string is stored with escape double quotes 
		$tag = json_decode($tag, true);

	}


	// usort($tag,'DescSort');
	// echo "<PRE>";print_r($tag);
	// usort($cat,'DescSort');
	// echo "<PRE>";print_r($cat);
	// usort($keyword,'DescSort');
	//echo "<PRE>";print_r($keyword);
	$args = array(
		'hide_empty' => 0,
	);
	$categories = get_categories( $args );

		foreach($categories as $c){
			if ( strtolower($c->name) == strtolower($s_keyword)){ 			
				$kew_exists = true;	
				if(!empty($cat)){
					$m = false;
					foreach($cat as $key => $catarr){
						if($catarr['cat_id'] == $c->term_id){
							$cat[$key]['count'] = $cat[$key]['count']+1;
							$m = true; 
						}
					}
					if(!$m){
						$cat[] = array("cat_id"=>$c->term_id,"count" => 1);
					}
				}else{				
					$cat[] = array("cat_id"=>$c->term_id,"count" => 1);

				}  			
			} 		
		}

	$tags = get_tags($args);

	foreach ($tags as $t) {
		if (strtolower($t->name) == strtolower($s_keyword)) {
			$kew_exists = true;
			if (!empty($tag)) {
				$y = false;
				foreach ($tag as $key => $tagarr) {
					if ($tagarr['tag_id'] == $t->term_id) {
						$tag[$key]['count'] = $tag[$key]['count'] + 1;
						$y = true;
					}
				}
				if (!$y) {
					$tag[] = array("tag_id" => $t->term_id, "count" => 1);
				}
			} else {
				$tag[] = array("tag_id" => $t->term_id, "count" => 1);

			}

		}
	}

	$tag = json_encode($tag, true);
	$cat = json_encode($cat,true);


	setcookie('user_interest_cat', $cat, time() + (86400 * 15), "/");
	setcookie('user_interest_tag', $tag, time() + (86400 * 15), "/");



}

function set_more_stories_arr()
{
	global $ms;
}
add_action('init', 'set_more_stories_arr');


function DescSort($val1, $val2)
{
	#check if both the values are equal
	if ($val1['count'] == $val2['count'])
		return 0;
	#check if not equal, then compare values
	return ($val1['count'] < $val2['count']) ? 1 : -1;
}

/* Load posts which has specific acf value [ is featured event ] [ block - featured events ]
 ** Date: 29-06-2023
 */
add_filter('acf/fields/relationship/query/name=mwf_fe_select_manual_events', 'load_posts_from_specific_acf_value', 12, 1);
function load_posts_from_specific_acf_value($args)
{

	$args['meta_query'] = array(
		array(
			'key' => 'mfw_ep_is_featured_event',
			'value' => "yes",
			'compare' => '='
		)
	);
	return $args;
}


/*
 * Init function
 * 1. Apply coupon code from URL
 * 2. Add to cart: Multiple products add via URL
 */
function nd_template_redirect()
{
	if (!isset(WC()->session) || (isset(WC()->session) && !WC()->session->has_session())) {
		WC()->session->set_customer_session_cookie(true);
	}

	$product_ids = array();
	$quantities = array();

	if (isset($_GET['add-to-cart'])) {
		if (false !== strpos($_GET['add-to-cart'], ',')) {
			$product_ids = explode(',', $_GET['add-to-cart']);
		}
	}

	if (isset($_GET['quantity'])) {
		if (false !== strpos($_GET['quantity'], ',')) {
			$quantities = explode(',', $_GET['quantity']);
		}
	}

	if (!empty($product_ids)) {
		$products = array();

		for ($i = 0; $i < count($product_ids); $i++) {
			if (isset($product_ids[$i])) {
				$products[$product_ids[$i]] = isset($quantities[$i]) ? $quantities[$i] : 1;
			}
		}

		if (!empty($products)) {
			foreach ($products as $key => $value) {
				WC()->cart->add_to_cart($key, $value);
			}
		}
	}

	if (isset($_GET['coupon_code']) && empty(WC()->session->get('added_coupon_code'))) {
		$coupon_code = esc_attr($_GET['coupon_code']);

		if (!empty($coupon_code) && !WC()->cart->has_discount($coupon_code)) {
			WC()->cart->add_discount($coupon_code);

			WC()->session->set('added_coupon_code', true);
		}
	}
}
add_action('template_redirect', 'nd_template_redirect');

/*
 * Clear session variables on thank you page.
 */
function nd_woocommerce_thankyou($order_id)
{
	WC()->session->__unset('added_coupon_code');
	WC()->session->__unset('added_products_to_cart');
  
   $res = '';
   if(get_post_meta( $order_id, '_premium_business_ids', true ) != ""){
	$bussinesses = get_post_meta( $order_id, '_premium_business_ids', true );
	$bussiness = explode(',',$bussinesses);
	$user_id = get_current_user_id();
	$subscription_id = $order_id + 1; 
	
	$res .= '<header class="shrink">
		<h2>Your Premium Business</h2>
	</header>';
	$res.='<table class="shop_table shop_table_responsive my_account_orders woocommerce-orders-table woocommerce-MyAccount-subscriptions woocommerce-orders-table--subscriptions">
	<thead>
		<tr>
			<th class="subscription-id order-number woocommerce-orders-table__header woocommerce-orders-table__header-order-number woocommerce-orders-table__header-subscription-id"><span class="nobr">Business Name</span></th>
			<th class="subscription-actions order-actions woocommerce-orders-table__header woocommerce-orders-table__header-order-actions woocommerce-orders-table__header-subscription-actions">&nbsp;</th>
		</tr>
	</thead><tbody>';
	foreach ($bussiness as $buss) {
		
		$args = array(
			'post_type' => 'business_directory',
			'p' => $buss,
			'author'  =>  $user_id, 
		 );
		 
		 $my_business = new WP_Query($args);
			if ($my_business->have_posts()) { 

				while ($my_business->have_posts()) { $my_business->the_post(); 
				
					$slug = get_post_field( 'post_name', $buss ); 
					update_field( 'mfw_bd_business_listing', 'paid', $buss );
					add_post_meta( $subscription_id, 'pre_business_id', $buss );
				
					$res.='<tr class="order woocommerce-orders-table__row woocommerce-orders-table__row--status-active">
								<td class="subscription-id order-number woocommerce-orders-table__cell woocommerce-orders-table__cell-subscription-id woocommerce-orders-table__cell-order-number" data-title="ID">
									<a href="/business-directory/'.$slug.'">
										'.get_the_title().'					</a>
								</td>
								
								<td class="subscription-actions order-actions woocommerce-orders-table__cell woocommerce-orders-table__cell-subscription-actions woocommerce-orders-table__cell-order-actions">
									<a href="/my-account/add-business-listing/?bid='.get_the_ID().'" class="woocommerce-button button view">Edit</a>
									<a href="/my-account/" class="woocommerce-button button view">Go to My Account</a>
								</td>
							</tr>';
				}
		 }
		}
		$res .= '</tbody>
				</table>';
   }
  
   //Send email to customer for enhenced directory coupon
    # Get an instance of WC_Order object
    $order = wc_get_order( $order_id );
	$is_package_in_cart = false;
	    # Iterating through each order items (WC_Order_Item_Product objects in WC 3+)
		foreach ( $order->get_items() as $item_id => $item_values ) {

			// Product_id
			$product_id = $item_values->get_product_id(); 
	
			// OR the Product id from the item data
			$item_data = $item_values->get_data();
			$product_id = $item_data['product_id'];
	
			# Targeting a defined product ID
			if ( $product_id == 176 || $product_id == 178 || $product_id == 179) {
				$is_package_in_cart = true;
				
			}
		}
		if($is_package_in_cart){
				$html = '';
				$html .= '<br/>Dear <strong>'.$order->get_billing_first_name().' '. $order->get_billing_last_name().'</strong><br/>';
				$html .= '<br/><p>As part of your advertising package with Focus Waukesha, you are entitled to a free enhanced directory listing on our site. Please use the following coupon code to complete the purchase of your directory listing, free of charge, and place it in your account so you can create the listing.</p><br/>';
				$html .='<br/><strong><p>Discount Code:</strong> NGQKH55D</p><br/>';
				$html .='<br/><p>If you have any questions about this process, please contact us at <a href="mailto:sales@focuswaukesha.com">sales@focuswaukesha.com</a> or <a href="tel:2624422060">262-442-2060</a>.</p><br/>';
				$html .='<br/><p>Thank you!</p><br/>';
				$headers = array('Content-Type: text/html; charset=UTF-8');
				$user_email = $order->get_billing_email();
				$body = get_email_template($html);
				wp_mail($user_email, __('Complete Purchase of Free Directory Listing', 'focus-waukesha'), $body, $headers);
		}

   echo $res;
}
add_action('woocommerce_thankyou', 'nd_woocommerce_thankyou');



// Remove image from product pages
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_images', 20);
// Remove sale badge from product page
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
// Remove product thumbnail from the cart page
add_filter('woocommerce_cart_item_thumbnail', '__return_false');
// Remove product images from the shop loop
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10);
// Remove sale badges from the shop loop
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
//Remove product link from cart and mini cart
add_filter('woocommerce_cart_item_permalink', '__return_null');
add_filter('woocommerce_mini_cart_item_name_permalink', '__return_null', 99);



add_action('woocommerce_add_cart_item_data', 'save_custom_data_hidden_fields', 10, 2);
function save_custom_data_hidden_fields($cart_item_data, $product_id)
{

	$data = array();
	//print_r($_REQUEST);exit;
	$body = "<table class='order-list'>";
	$clear_body = false;
	foreach ($_REQUEST['prod_id_arr'] as $prod) {

		if ($prod['prod_id'] == $product_id) {
			$product = wc_get_product($product_id);
			if (class_exists('WC_Subscriptions_Product') && WC_Subscriptions_Product::is_subscription($product)) {
				$body .= "<tr><td>$" . $product->get_regular_price() . " For one year</td></tr>";
			}
			if($prod['prod_id'] == 173 || $prod['prod_id'] == 171){
				$body .= "<tr><td>$" . $product->get_regular_price() . "</td></tr>";
			}
			if (isset($prod['start_date']) && $prod['start_date'] != "na") {
				// $cart_item_data['custom_data']['start_dt'] = $prod['start_date'];
				// $data['start_dt'] = $prod['start_date'];

				$body .= "<tr><td> Start Date:&nbsp;" . $prod['start_date'] . "</td></tr>";

			} else {
				//$clear_body = true;
			}
			if (isset($prod['no_of_month']) && $prod['no_of_month'] != "na") {
				// $cart_item_data['custom_data']['n_o_month'] = $prod['no_of_month'];
				// $data['n_o_month'] = $prod['no_of_month'];

				$body .= "<tr><td> Number Of Month" . ($prod['no_of_month'] > 1 ? 's' : '') . ": " . $prod['no_of_month'] . "</td></tr>";
				$body .= "<tr><td> Base Price: $" . number_format($prod['base_price'], 2, '.', '') . "</td></tr>";
				if (isset($prod['prd_tot'])) {
					$cart_item_data['custom_data']['p_tot'] = $prod['prd_tot'];
					//$data['p_tot'] = $prod['prd_tot'];
					// $body .= "<tr><td>Product Total: $".$prod['prd_tot'] . "</td></tr>";
	
				}
			}

			// below statement make sure every add to cart action as unique line item
			$cart_item_data['custom_data']['unique_key'] = md5(microtime() . rand());


		}

	}
	$body .= "</table>";

	$new_value = array('wdm_user_custom_data_value' => $body);




	//WC()->session->set( 'wdm_user_custom_data_value', $body );
	if ($clear_body) {
		return $cart_item_data;
	} else {
		return array_merge($cart_item_data, $new_value);
	}
}

add_action('woocommerce_before_calculate_totals', 'add_custom_item_price', 10);

function add_custom_item_price($cart_object)
{

	foreach ($cart_object->get_cart() as $item_values) {

		##  Get cart item data
		$item_id = $item_values['data']->id; // Product ID
		if(isset($item_values['custom_data']['p_tot'])){
## Get your custom fields values
		// $start_dt = $item_values['custom_data']['start_dt'];
		// $n_o_month = $item_values['custom_data']['n_o_month'];
		$price1 = $item_values['custom_data']['p_tot'];

		// CALCULATION FOR EACH ITEM:
		## Make HERE your own calculation 
		$new_price = $price1;

		## Set the new item price in cart
		$item_values['data']->set_price($new_price);
		}else{
		$original_price = $item_values['data']->price; // Product original price
		}
		
	}
}

add_filter('woocommerce_get_cart_item_from_session', 'wdm_get_cart_items_from_session', 1, 3);
if (!function_exists('wdm_get_cart_items_from_session')) {
	function wdm_get_cart_items_from_session($item, $values, $key)
	{
		if (array_key_exists('wdm_user_custom_data_value', $values)) {
			$item['wdm_user_custom_data_value'] = $values['wdm_user_custom_data_value'];
		}
		return $item;
	}
}

//add_filter('woocommerce_checkout_cart_item_quantity','wdm_add_user_custom_option_from_session_into_cart',1,3);  
//add_filter('woocommerce_cart_item_price','wdm_add_user_custom_option_from_session_into_cart',1,3);
if (!function_exists('wdm_add_user_custom_option_from_session_into_cart')) {
	function wdm_add_user_custom_option_from_session_into_cart($product_name, $values, $cart_item_key)
	{
		/*code to add custom data on Cart & checkout Page*/
		if ($values['wdm_user_custom_data_value'] != '') {
			$return_string = $product_name . "</a><dl class='variation'>";
			$return_string .= "<table class='wdm_options_table' id='" . $values['product_id'] . "'>";
			$return_string .= "<tr><td>" . $values['wdm_user_custom_data_value'] . "</td></tr>";
			$return_string .= "</table></dl>";
			return $return_string;
		} else {
			return $product_name;
		}
	}
}

function focus_waukesha_get_item_data($item_data, $cart_item_data)
{
	if (isset($cart_item_data['wdm_user_custom_data_value'])) {
		$item_data[] = array(
			'key' => __('Details', ''),
			'value' => $cart_item_data['wdm_user_custom_data_value']
		);
	}
	return $item_data;
}
add_filter('woocommerce_get_item_data', 'focus_waukesha_get_item_data', 10, 2);

/**
 * Add custom meta to order
 */
function focus_waukesha_checkout_create_order_line_item($item, $cart_item_key, $values, $order)
{
	if (isset($values['wdm_user_custom_data_value'])) {
		$item->add_meta_data(
			__('Details', ''),
			$values['wdm_user_custom_data_value'],
			true
		);
	}
}
add_action('woocommerce_checkout_create_order_line_item', 'focus_waukesha_checkout_create_order_line_item', 10, 4);

/**
 * Add custom cart item data to emails
 */
function focus_waukesha_order_item_name($product_name, $item)
{
	if (isset($item['wdm_user_custom_data_value'])) {
		$product_name .= sprintf(
			'<ul><li>%s: %s</li></ul>',
			__('Details', ''),
			esc_html($item['wdm_user_custom_data_value'])
		);
	}
	return $product_name;
}

add_filter('woocommerce_order_item_name', 'focus_waukesha_order_item_name', 10, 2);


// Outputting the hidden field in checkout page
add_action('woocommerce_after_order_notes', 'add_custom_checkout_hidden_field');
function add_custom_checkout_hidden_field($checkout)
{

	// Output the hidden field
	echo '<div id="user_link_hidden_checkout_field">
            <input type="hidden" class="input-hidden" name="billing_opt_for_provide_content" id="billing_opt_for_provide_content" value="">
    </div>';
	// Output the hidden field
	echo '<div id="user_link_hidden_checkout_field">
            <input type="hidden" class="input-hidden" name="billing_opt_for_need_assistance" id="billing_opt_for_need_assistance" value="">
    </div>';
}

add_filter( 'woocommerce_after_order_notes' , 'custom_checkout_fields', 30, 1 );
function custom_checkout_fields ( $fields ) {
	if(!has_subscription_product_in_cart()){
		?>
		<script>
			localStorage.removeItem('bid');
		</script>
		<?php
	}
	if(has_subscription_product_in_cart() && is_user_logged_in() ){
	$user_id = get_current_user_id();
	$user_businesses = get_user_business($user_id);
	$business = array();
	foreach ( WC()->cart->get_cart() as $cart_item ) { 
		$product_id = $cart_item['product_id'];
		$product = wc_get_product($product_id);
		// Check if the product is a subscription product
		if (class_exists('WC_Subscriptions_Product') && WC_Subscriptions_Product::is_subscription($product)) {
			$quantity =  $cart_item['quantity'];
		}
	}
	echo '<div class="purchase-listing"><h4 class="info_bus_msg">Enhanced Directory Listing</h4><p class="list-text-highlight">You are purchasing '.$quantity.' Enhanced Directory Listing subscriptions!</p>';
	if($user_businesses->post_count >0){
		while ($user_businesses->have_posts()) { $user_businesses->the_post(); 
			$business_lis = get_field('mfw_bd_business_listing' ,get_the_ID());
			if($business_lis == 'free'){
				$business[get_the_ID()] =  __( get_the_title(), '' );
			}
		}
		
		echo '<p class="sel_bus_msg"> Kindly select '.$quantity.' relevant businesses that you want to upgrade to an Enhanced Listing. You can skip this step and manage it later under <a href="/my-account/business-listing/">My Account</a>.</p>';
		?>
		<?php
		woocommerce_form_field( 'select_business', array(
			'type'          => 'multiselect',
			'class'         => array('my-field-class form-row-wide'),
			'label'         => __('Select Business', 'woocommerce'),
			'placeholder'   => __('Select Business', 'woocommerce'),
			'options'       =>$business,
			//'default' => (!empty($_GET['bid']) ? $_GET['bid'] : '' ),
			), $fields->get_value( 'select_business' ));
			echo '<span class="small-instruct"><em>Ctrl+click to select multiple values.(Mac users: command+click.)<br/>Shift+click to select a range.</em></span>';
		echo '<p class="presel_note info_bus_note" style="display:none;">
		<strong>NOTE:</strong> The above businesses are pre-selected as you have already chosen them in <a href="/my-account/business-listing/">My Account</a>.</p>';
		
    // $fields['billing']['select_business'] = array(
    //     'label'        => __('Select Business', 'woocommerce'),
    //     'required'     => true,
    //     'class'        => array('form-row-wide'),
    //     'clear'        => true,
    //     'autocomplete' => false,
    //     'type'         => 'select',
	// 	'default' => (!empty($_GET['bid']) ? $_GET['bid'] : '' ),
    //     'options'      => $business,
    // );
    ?>
    <input type="hidden"  name="hid_select_business" id="hid_select_business" value="">
	

    <?php
		}
		echo "</div>";
	}
	$b_eflag = false;
	$f_eflag = false;
	$is_package = false;
	$user_id = get_current_user_id();
	$user_event = get_user_event($user_id);
	$user_web_ads = get_user_web_ads($user_id);
	$event = array();
	
	$b_event_quantity = 0;
	$f_event_quantity = 0;
	
	$is_event_active = '';
	
	if($user_event->post_count >0) {
		while ($user_event->have_posts()) { $user_event->the_post(); 
			$is_event_active = get_field('mfw_ep_is_active_event', get_the_ID());
			if($is_event_active != 'yes') {
				$event[get_the_ID()] =  __( get_the_title(), '' );
			}
			
		}
	}
	


	foreach ( WC()->cart->get_cart() as $cart_item ) { 
		$product_id = $cart_item['product_id'];
		$event_product = wc_get_product($product_id);
		
		if($product_id == 173){
			$b_event_quantity =  $cart_item['quantity'];
			$b_eflag = true;
		}
		if($product_id == 171){
			$f_event_quantity =  $cart_item['quantity'];
			$f_eflag = true;
		}
		
		if($product_id == 176 || $product_id == 178 || $product_id == 179)
		{
			$is_package = true;
		}

	} 
	?>

		<?php 
		if($b_eflag) {
			echo '<div class="purchase-listing"><h4 class="info_bus_msg">Basic Event Listing</h4><p class="list-text-highlight">Event listings you are purchasing: '.$b_event_quantity.'</p>';
		
			if(!empty($event)) {
			echo '<p class="sel_ev_msg">Select the event(s) you would like to upgrade to Basic Event(s) from your events listed below. You can also skip this step and manage it later under <a href="/my-account/event-listing/">My Account</a>.</p>';
			
				woocommerce_form_field( 'select_event', array(
				'type'          => 'multiselect',
				'class'         => array('my-field-class form-row-wide'),
				'label'         => __('Select Event', 'woocommerce'),
				'placeholder'   => __('Select Event', 'woocommerce'),
				'options'       =>$event,
				//'default' => (!empty($_GET['bid']) ? $_GET['bid'] : '' ),
				), $fields->get_value( 'select_event' ));
				echo '<span class="small-instruct"><em>Ctrl+click to select multiple values.(Mac users: command+click.)<br/>Shift+click to select a range.</em></span>';
			echo '<p class="presel_event_note info_event_note" style="display:none;">
			<strong>NOTE:</strong> The above events are pre-selected as you have already chosen them in My Account.</p>';
			?>
			<input type="hidden"  name="hid_select_event" id="hid_select_event" value="">
			<input type="hidden"  name="hid_select_event_prod" id="hid_select_event_prod" value="">
			<?php } 
		echo '</div>';	
		} else { ?>
			<script>
			localStorage.removeItem('eid');
			localStorage.removeItem('eval');
		</script>
		<?php }
		
		if($f_eflag) {
		echo '<div class="purchase-listing"><h4 class="info_bus_msg">Featured Event Listing</h4><p class="list-text-highlight">Event listings you are purchasing: '.$f_event_quantity.'</p>';

			if(!empty($event)) {
			echo '<p class="sel_ev_msg">Select the basic (free) event(s) you would like to upgrade to Featured Event(s) from your events listed below. You can also skip this step and manage it later under <a href="/my-account/event-listing/">My Account</a>.</p>';
			
				woocommerce_form_field( 'select_event_featured', array(
				'type'          => 'multiselect',
				'class'         => array('my-field-class form-row-wide'),
				'label'         => __('Select Event', 'woocommerce'),
				'placeholder'   => __('Select Event', 'woocommerce'),
				'options'       =>$event,
				//'default' => (!empty($_GET['bid']) ? $_GET['bid'] : '' ),
				), $fields->get_value( 'select_event' ));
				echo '<span class="small-instruct"><em>Ctrl+click to select multiple values.(Mac users: command+click.)<br/>Shift+click to select a range.</em></span>';
			echo '<p class="presel_event_note info_event_note" style="display:none;">
			<strong>NOTE:</strong> The above event are pre-selected as you have already chosen them in My Account.</p>';
			?>
			<input type="hidden"  name="hid_select_event_featured" id="hid_select_event_featured" value="">
			<input type="hidden"  name="hid_select_event_prod_featured" id="hid_select_event_prod_featured" value="">
			<?php } 
			echo '</div>';
		} else { ?>
				<script>
				localStorage.removeItem('f_eid');
				localStorage.removeItem('f_eval');
			</script>
			<?php }
		
//    return $fields;
if($is_package){
	echo '<div class="purchase-listing"><h4>Ad Packages</h4>';
	echo '<p class="list-text-highlight">As part of your advertising package purchase, you are entitled to a free enhanced directory listing, which requires another purchase step. You will receive an email with an additional discount code that you can use to purchase the enhanced directory listing free of charge. It will then appear in your account so you can add the directory content for your company. We apologize for the 2-step purchase process and thank you for your patience.</p>';
	echo '</div>';
}


}
add_filter( 'woocommerce_form_field_multiselect', 'custom_multiselect_handler', 10, 4 );

function custom_multiselect_handler( $field, $key, $args, $value ) {

    $options = '';

    if ( ! empty( $args['options'] ) ) {
        foreach ( $args['options'] as $option_key => $option_text ) {
            $options .= '<option value="' . $option_key . '" '. selected( $value, $option_key, false ) . '>' . $option_text .'</option>';
        }

        if ($args['required']) {
            $args['class'][] = 'validate-required';
            $required = '&nbsp;<abbr class="required" title="' . esc_attr__('required', 'woocommerce') . '">*</abbr>';
        }
        else {
            $required = '&nbsp;<span class="optional">(' . esc_html__('optional', 'woocommerce') . ')</span>';
        }

        $field = '<p class="form-row ' . implode( ' ', $args['class'] ) .'" id="' . $key . '_field">
            <label for="' . $key . '" class="' . implode( ' ', $args['label_class'] ) .'">' . $args['label']. $required . '</label>
            <select name="' . $key . '" id="' . $key . '" class="select" multiple="multiple">
                ' . $options . '
            </select>
        </p>' ;
    }

    return $field;
}
/**
 * Process the checkout
 */
add_action('woocommerce_checkout_process', 'custom_checkout_field_process');

function custom_checkout_field_process() {
    // Check if set, if its not set add an error.
	// Get the cart instance
// $cart = WC()->cart;

// // Initialize the subscription quantity variable
// $subscriptionQuantity = 0;
// $sel_business = 0;
// $user_id = get_current_user_id();
// // Iterate through each cart item
// foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
//     // Check if the product is a subscription-type product
	
// 	$product = wc_get_product($cart_item['product_id']);
// 			if (class_exists('WC_Subscriptions_Product') && WC_Subscriptions_Product::is_subscription($product)) {
//         // Increment the subscription quantity by the cart item quantity
//         $subscriptionQuantity += $cart_item['quantity'];
// 		$sel_business = explode(',',$_POST['hid_select_business']);
		
//     }
// }
//     if ( has_subscription_product_in_cart() && ($_POST['hid_select_business'] == "" || count($sel_business) != $subscriptionQuantity)){
//         wc_add_notice( __( 'Please select business same as quantity or <a href="/my-account/add-business-listing/">add new business</a>.' ), 'error' );
// 	}

}
// Saving the hidden field value in the order metadata
add_action('woocommerce_checkout_update_order_meta', 'save_custom_checkout_hidden_field');
function save_custom_checkout_hidden_field($order_id)
{
	if (!empty($_POST['billing_opt_for_provide_content'])) {
		update_post_meta($order_id, '_opt_for_provide_content', sanitize_text_field($_POST['billing_opt_for_provide_content']));
	}
	if (!empty($_POST['billing_opt_for_need_assistance'])) {
		update_post_meta($order_id, '_opt_for_need_assistance', sanitize_text_field($_POST['billing_opt_for_need_assistance']));
	}
	if(!empty($_POST['hid_select_business']) && isset($_POST['hid_select_business'])){
		$sel_business = explode(',',$_POST['hid_select_business']);
		foreach ($sel_business as $bid) {
			update_field( 'mfw_bd_business_listing', 'paid', $bid );
		}
		update_post_meta($order_id, '_premium_business_ids', sanitize_text_field($_POST['hid_select_business']));

					
	}
	
	if(!empty($_POST['hid_select_event']) && isset($_POST['hid_select_event'])){
		$sel_event_prod = $_POST['hid_select_event_prod'];
		$sel_event = explode(',',$_POST['hid_select_event']);
		foreach ($sel_event as $eid) {
			update_field( 'mfw_ep_is_featured_event', 'no', $eid );
    		update_field( 'mfw_ep_is_active_event', 'yes', $eid );
		}					
	}

	if(!empty($_POST['hid_select_event_featured']) && isset($_POST['hid_select_event_featured'])){
		$sel_event_prod_featured = $_POST['hid_select_event_prod_featured'];
		$sel_event_featured = explode(',',$_POST['hid_select_event_featured']);
		foreach ($sel_event_featured as $f_eid) {
			update_field( 'mfw_ep_is_featured_event', 'yes', $f_eid );
    		update_field( 'mfw_ep_is_active_event', 'yes', $f_eid );
		}					
	}

}

// Displaying "Verification ID" in customer order
add_action('woocommerce_order_details_after_customer_details', 'display_verification_id_in_customer_order', 10);
function display_verification_id_in_customer_order($order)
{
	// compatibility with WC +3
	$order_id = method_exists($order, 'get_id') ? $order->get_id() : $order->id;

	if (get_post_meta($order_id, '_opt_for_provide_content', true)) {
		//echo '<p class="verification-id"><strong>'.__('I will provide content at least 10 business days', 'woocommerce') . ':</strong> ' . get_post_meta( $order_id, '_opt_for_provide_content', true ) .'</p>';
	}
	if (get_post_meta($order_id, '_opt_for_need_assistance', true)) {
		//echo '<p class="verification-id"><strong>'.__('I need assistance with ad', 'woocommerce') . ':</strong> ' . get_post_meta( $order_id, '_opt_for_need_assistance', true ) .'</p>';
	}
}

// Display "Verification ID" on Admin order edit page
add_action('woocommerce_admin_order_data_after_billing_address', 'display_verification_id_in_admin_order_meta', 10, 1);
function display_verification_id_in_admin_order_meta($order)
{
	// compatibility with WC +3
	$order_id = method_exists($order, 'get_id') ? $order->get_id() : $order->id;
	if (get_post_meta($order_id, '_opt_for_provide_content', true)) {
		echo '<p><strong>' . __('I will provide content at least 10 business days', 'woocommerce') . ':</strong> ' . get_post_meta($order_id, '_opt_for_provide_content', true) . '</p>';
	}
	if (get_post_meta($order_id, '_opt_for_need_assistance', true)) {
		echo '<p><strong>' . __('I need assistance with ad', 'woocommerce') . ':</strong> ' . get_post_meta($order_id, '_opt_for_need_assistance', true) . '</p>';
	}
}

// Displaying "Verification ID" on email notifications
add_action('woocommerce_email_customer_details', 'add_verification_id_to_emails_notifications', 15, 4);
function add_verification_id_to_emails_notifications($order, $sent_to_admin, $plain_text, $email)
{
	// compatibility with WC +3
	$order_id = method_exists($order, 'get_id') ? $order->get_id() : $order->id;

	$output = '';
	$_opt_for_provide_content = get_post_meta($order_id, '_opt_for_provide_content', true);
	$_opt_for_need_assistance = get_post_meta($order_id, '_opt_for_need_assistance', true);

	if (!empty($_opt_for_provide_content)) {
		$output .= '<div><strong>' . __("I will provide content at least 10 business days:", "woocommerce") . '</strong> <span class="text">' . $_opt_for_provide_content . '</span></div>';
	}

	if (!empty($_opt_for_need_assistance)) {
		$output .= '<div><strong>' . __("I need assistance with ad:", "woocommerce") . '</strong> <span class="text">' . $_opt_for_need_assistance . '</span></div>';
	}

	echo $output;
}

function include_category_tags_in_search($query)
{
	if ($query->is_search && !is_admin()) {


		if (isset($_GET['type']) && $_GET['type'] != '') {

			$query->set('post_type', array($_GET['type']));

		} else {

			$query->set('post_type', array('post', 'event', 'business_directory'));
		}
		$tax_query = array();
		if (isset($_GET['tag']) && $_GET['tag'] != '' && isset($_GET['cat']) && $_GET['cat'] != '') {
			$tax_query = array('relation' => 'AND');
		}
		if (isset($_GET['tag']) && $_GET['tag'] != '') {
			$tax_query = array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'post_tag',
					'field' => 'slug',
					'terms' => $_GET['tag'],
				),
				array(
					'taxonomy' => 'business-tags',
					'field' => 'slug',
					'terms' => $_GET['tag'],
				),
				array(
					'taxonomy' => 'event-tags',
					'field' => 'slug',
					'terms' => $_GET['tag'],
				),
			);

		}

		if (isset($_GET['cat']) && $_GET['cat'] != '') {
			

			$tax_query = array(
				'relation' => 'OR',
				array(
					'taxonomy' => 'category',
					'field' => 'slug',
					'terms' => $_GET['cat'],
				),
				array(
					'taxonomy' => 'events',
					'field' => 'slug',
					'terms' => $_GET['cat'],
				),
				array(
					'taxonomy' => 'business-category',
					'field' => 'slug',
					'terms' => $_GET['cat'],
				),
				
				// 'relation' => 'OR',
				// array(
				// 	'taxonomy' => 'category',
				// 	'field' => 'name',
				// 	'terms' => $_GET['cat'],
				// ),
				// array(
				// 	'taxonomy' => 'events',
				// 	'field' => 'name',
				// 	'terms' => $_GET['cat'],
				// ),
				// array(
				// 	'taxonomy' => 'business-category',
				// 	'field' => 'name',
				// 	'terms' => $_GET['cat'],
				// ),
				
			);

		}

		if (count($tax_query) > 0) {
			$query->set('tax_query', $tax_query);
		}
	}
}

add_action('pre_get_posts', 'include_category_tags_in_search');
//Remove per year text from cart Items pricing
add_filter('woocommerce_subscriptions_product_price_string', 'filter_wc_subscriptions_product_price_string', 10, 3);
function filter_wc_subscriptions_product_price_string($price_string, $product, $args)
{
	if (is_cart() || (is_checkout() && !is_wc_endpoint_url())) {
		return $args['price'];
	}
	return $price_string;
}

//Remove per year text from cart  Total lines
add_filter('woocommerce_subscription_price_string', 'filter_wc_subscription_price_string', 10, 2);
function filter_wc_subscription_price_string($subscription_string, $subscription_details)
{
	if (is_cart() || (is_checkout() && !is_wc_endpoint_url())) {
		$recurring_amount = $subscription_details['recurring_amount'];

		if (is_numeric($recurring_amount)) {
			return strip_tags(wc_price($recurring_amount)); // For shipping methods
		} else {
			return $recurring_amount;
		}
	}
	return $subscription_string;
}

function get_claimed_business_listing(){
	$current_user = wp_get_current_user();
	global $wpdb;

    $table_name = $wpdb->prefix . 'claim_business';

    $results = $wpdb->get_results('SELECT * FROM ' . $table_name . ' WHERE `user_id`="' . $current_user->id . '" AND `approval_status`="pending"');
   	return $results;
	
}

//Change url of return to shop button
add_filter( 'woocommerce_return_to_shop_redirect', 'bbloomer_change_return_shop_url' );
 
function bbloomer_change_return_shop_url() {
   return site_url().'/purchase';
}

// Function to check if the cart has any subscription product
function has_subscription_product_in_cart() {
    // Get the cart contents
    $cart = WC()->cart->get_cart();
    // Loop through each cart item
    foreach ($cart as $item) {
        // Get the product ID
        $product_id = $item['product_id'];
		$product = wc_get_product($product_id);
        // Check if the product is a subscription product
        if (class_exists('WC_Subscriptions_Product') && WC_Subscriptions_Product::is_subscription($product)) {
            return true;
        }
    }

    return false;
}

function  get_user_business($user_id){
    
	$args = array(
		'post_type' => 'business_directory',
		'post_status' => 'publish',      
		'post_per_page' 	 => -1,  
		'author'        =>  $user_id,
	 );
	 
	  $my_business = new WP_Query($args);
	  return $my_business;
	}
function  get_user_web_ads($user_id){
    
	$args = array(
		'post_type' => 'website_ad',
		'post_status' => 'publish',      
		'post_per_page' 	 => -1,  
		'author'        =>  $user_id,
	 );
	 
	  $my_web_ads = new WP_Query($args);
	  return $my_web_ads;
	}

	function  get_user_video_ads($user_id){
    
		$video_args = array(
			'post_type' => 'video_ad',
			'post_status' => 'publish',      
			'post_per_page' 	 => -1,  
			'author'        =>  $user_id,
		 );
		 
		  $my_video_ads = new WP_Query($video_args);
		  return $my_video_ads;
		}

function  get_user_event($user_id){
    
	$args = array(
		'post_type' => 'event',
		'post_status' => 'publish',      
		'post_per_page' 	 => -1,  
		'author'        =>  $user_id,	
		);
		
		$my_event = new WP_Query($args);
		return $my_event;
}
	
	function get_prim_web_ads_count($user_id){
		
		$args = array(
			'post_type' => 'website_ad',
			'post_status' => 'publish',  
			'author'      =>  $user_id,      
			'meta_query' => array(
			'relation'      => 'AND',
			array(
				'key' => 'mfw_bd_business_listing',
				'value' => 'paid',
				'compare' => '=',
			),
		));
		$prim_business = new WP_Query($args);
	  return $prim_business->post_count;
	}
	function get_prim_business_count($user_id){
		
		$args = array(
			'post_type' => 'business_directory',
			'post_status' => 'publish',  
			'author'      =>  $user_id,      
			'meta_query' => array(
			'relation'      => 'AND',
			array(
				'key' => 'mfw_bd_business_listing',
				'value' => 'paid',
				'compare' => '=',
			),
		));
		$prim_business = new WP_Query($args);
	  return $prim_business->post_count;
	}

	/**
	 * Additional notes placeholder
	 */
	add_filter( 'woocommerce_checkout_fields' , 'change_order_notes_placeholder' );
function change_order_notes_placeholder( $fields ) {
     $fields['order']['order_comments']['placeholder'] = _x('Additional notes...', 'placeholder', 'woocommerce');

     return $fields;
}

add_filter( 'woocommerce_order_item_permalink', '__return_false' );


if(!is_admin()){
add_action('acf/save_post', 'save_acf_taxonomy_data', 20); }

function save_acf_taxonomy_data($post_id) {
	$post_type = get_post_type($post_id);
	$admin_email = 'sales@focuswaukesha.com' ;//'sales@focuswaukesha.com'; //get_bloginfo('admin_email');
	if ($post_type === 'business_directory') {
		
		$current_user = wp_get_current_user();
		$mfw_bd_business_listing = get_field('mfw_bd_business_listing', $post_id);
		$user_id = $current_user->id;

		if (isset($_POST['cat'])){
			$categories = array_map('intval', $_POST['cat']);
			wp_set_object_terms($post_id ,$categories, 'business-category', false);
		}
		if (isset($_POST['tag'])){
			$tags = array_map('intval', $_POST['tag']);
			wp_set_object_terms($post_id ,$tags, 'business-tags', true);
		}
		
		add_user_meta( $user_id, 'business_listing_id', $post_id);
		add_post_meta( $post_id, 'user_id', $user_id, true );	
		update_field( 'mfw_bd_verified_business_badge', true, $post_id );
		if($mfw_bd_business_listing == ''){
			update_field( 'mfw_bd_business_listing', 'free', $post_id );
		}
		//Set Logo As Featured Image
		// $mfw_bd_business_logo = get_field('mfw_bd_business_logo', $post_id);
		// update_post_meta($post_id, '_thumbnail_id', $mfw_bd_business_logo);
	}

	if ($post_type === 'website_ad') {
		
		 // Get newly saved values.
		 $web_ads_values = get_fields( $post_id );
		 $w_ads_title = get_the_title($post_id);
		 $what_is_your_advertising_objective = get_field('mfw_wa_what_is_your_advertising_objective',$post_id);
		 $what_would_you_like_the_headline_to_say = get_field('mfw_wa_what_would_you_like_the_headline_to_say',$post_id);
		 $what_else_would_you_like_to_include = get_field('mfw_wa_what_else_would_you_like_to_include',$post_id);
		 $what_is_the_website_address = get_field('mfw_wa_what_is_the_website_address',$post_id);
		 $is_there_anything_else = get_field('mfw_wa_is_there_anything_else',$post_id);
		 $current_user = wp_get_current_user();
		 if($_POST['type_of_ad'] != ''){
			update_field( 'mfw_wa_type_of_ad', $_POST['type_of_ad'], $post_id );
		}
		 if($_POST['expire_date'] != ''){
			update_field( 'mfw_wa_expire_date', $_POST['expire_date'], $post_id );
		}

		 $web_attachments = array();
		 
		 if (!empty($web_ads_values)) {
			$html = '';
			$html .= '<br/><br/><p>New website Ads submitted <strong>By User '.$current_user->user_login.'</strong></p><br/><br/>';

			//$html .= '<h2>Title: '.$w_ads_title.'</h2><br/>';
			$html .= '<strong>What is your advertising objective?</strong><br/>';
			$html .= $what_is_your_advertising_objective.'<br/><br/>';
			$html .= '<strong>What would you like the headline to say?</strong><br/>';
			$html .= $what_would_you_like_the_headline_to_say.'<br/><br/>';
			$html .= '<strong>What else would you like to include?</strong><br/>';
			$html .= $what_else_would_you_like_to_include.'<br/><br/>';
			$html .= '<strong>What is the website address where you would like our readers to be sent when they click on your ad?</strong><br/>';
			$html .= $what_is_the_website_address.'<br/><br/>';
			$html .= '<strong>Is there anything else you would like us to know?</strong><br/>';
			$html .= $is_there_anything_else.'<br/><br/>';
			$html .= '<p>Find the Ads Images in the attachment:</p> <br/><br/>';
			foreach($web_ads_values['mfw_wa_images'] as $web_ads_image ) {
				//$html .= '<img src="'.$web_ads_image['ads_images']['url'].'" alt="'.$web_ads_image['ads_images']['title'].'" /><br/>';
				$upload_url = str_replace(get_site_url().'/wp-content/', '', $web_ads_image['ads_images']['url']);
				$web_attachments[] = WP_CONTENT_DIR.'/'.$upload_url;
			}
			
			$headers = array('Content-Type: text/html; charset=UTF-8');
			$body = get_email_template($html);
			
			wp_mail('sales@focuswaukesha.com', __('New website Ads submitted', 'focus-waukesha'), $body, $headers, $web_attachments);
		}
		
	}

	if ($post_type === 'newsletter_ad') {

		// Get newly saved values.
		$news_ads_values = get_fields( $post_id );
		$news_ads_title = get_the_title($post_id);
		$current_user = wp_get_current_user();
		$news_attachments = array();
		$what_is_your_advertising_objective = get_field('mfw_na_what_is_your_advertising_objective',$post_id);
		$what_would_you_like_the_headline_to_say = get_field('mfw_na_what_would_you_like_the_headline_to_say',$post_id);
		$what_else_would_you_like_to_include = get_field('mfw_na_what_else_would_you_like_to_include',$post_id);
		$what_is_the_website_address = get_field('mfw_na_what_is_the_website_address',$post_id);
		$is_there_anything_else = get_field('mfw_na_is_there_anything_else',$post_id);
		if($_POST['type_of_ad'] != ''){
			update_field( 'mfw_na_type_of_ad', $_POST['type_of_ad'], $post_id );
		}
		if($_POST['expire_date'] != ''){
			update_field( 'mfw_wa_expire_date', $_POST['expire_date'], $post_id );
		}
		if (!empty($news_ads_values)) {
		   $html = '';
		   $html .= '<br/><br/><p>New Newsletter Ad submitted By User <strong>'.$current_user->user_login.'</strong></p><br/><br/>';
		   $html .= '<strong>What is your advertising objective?</strong><br/>';
		   $html .= $what_is_your_advertising_objective.'<br/><br/>';
		   $html .= '<strong>What would you like the headline to say?</strong><br/>';
		   $html .= $what_would_you_like_the_headline_to_say.'<br/><br/>';
		   $html .= '<strong>What else would you like to include?</strong><br/>';
		   $html .= $what_else_would_you_like_to_include.'<br/><br/>';
		   $html .= '<strong>What is the website address where you would like our readers to be sent when they click on your ad?</strong>:<br/>';
		   $html .= $what_is_the_website_address.'<br/><br/>';
		   $html .= '<strong>Is there anything else you would like us to know?</strong><br/>';
		   $html .= $is_there_anything_else.'<br/><br/>';
		   
		   $html .= '<p>Find the Ads Images in the attachment:</p> <br/>';
		   foreach($news_ads_values['mfw_na_images'] as $news_ads_image ) {
			   //$html .= '<img src="'.$news_ads_image['ads_images']['url'].'" alt="'.$news_ads_image['ads_images']['title'].'" /><br/>';
			   $news_upload_url = str_replace(get_site_url().'/wp-content/', '', $news_ads_image['ads_images']['url']);
			   $news_attachments[] = WP_CONTENT_DIR.'/'.$news_upload_url;
		   }
		   $headers = array('Content-Type: text/html; charset=UTF-8');
		   $body = get_email_template($html);


		   wp_mail($admin_email, __('New Newsletter Ads submitted', 'focus-waukesha'), $body, $headers, $news_attachments);

	   }
	   
   }

   if ($post_type === 'video_ad') {

		// Get newly saved values.
		$video_ads_values = get_fields( $post_id );
		$video_ads_title = get_the_title($post_id);
		$current_user = wp_get_current_user();
		$video_attachments = array();
		// echo "get <pre>"; print_r($video_ads_values);
		// exit;
		if (!empty($video_ads_values)) {
			$html = '';
			$html .= '<br/><br/><p>New video Ads submitted <strong>By User '.$current_user->user_login.'</strong></p><br/><br/>';

			$html .= '<h2>Title: '.$video_ads_title.'</h2><br/><br/>';
			$html .= '<p>Find the Ads Images in the attachment:</p> <br/><br/>';
			foreach($video_ads_values['mfw_vd_images'] as $video_ads_image ) {
				//$html .= '<img src="'.$video_ads_image['ads_images']['url'].'" alt="'.$video_ads_image['ads_images']['title'].'" /><br/>';
				$video_upload_url = str_replace(get_site_url().'/wp-content/', '', $video_ads_image['ads_images']['url']);
				$video_attachments[] = WP_CONTENT_DIR.'/'.$video_upload_url;
				
			}
			$headers = array('Content-Type: text/html; charset=UTF-8');
			$body = get_email_template($html);


			wp_mail($admin_email, __('New video Ads submitted', 'focus-waukesha'), $body, $headers, $video_attachments);
		}
   
	}
	if ($post_type === 'sponsored_content') {

		// Get newly saved values.
		$sponsored_content_values = get_fields( $post_id );
		$sponsored_content_title = get_the_title($post_id);
		$current_user = wp_get_current_user();
		$sponsored_content_attachments = array();
		// echo "get <pre>"; print_r($sponsored_content_values);
		// exit;
		if (!empty($sponsored_content_values)) {
			$html = '';
			$html .= '<br/><br/><p>New Sponsored Content submitted <strong>By User '.$current_user->user_login.'</strong></p><br/><br/>';

			$html .= '<h2>Title: '.$sponsored_content_title.'</h2><br/><br/>';
			$html .= '<p>Find the sponsored content files in the attachment:</p> <br/><br/>';
			foreach($sponsored_content_values['mfw_sc_sponsored_content_files'] as $sponsored_content_files ) {
				$sponsored_content_upload_url = str_replace(get_site_url().'/wp-content/', '', $sponsored_content_files['files']['url']);
				$sponsored_content_attachments[] = WP_CONTENT_DIR.'/'.$sponsored_content_upload_url;
				
			}
			$headers = array('Content-Type: text/html; charset=UTF-8');
			$body = get_email_template($html);


			wp_mail($admin_email, __('New Sponsored Content submitted', 'focus-waukesha'), $body, $headers, $video_attachments);
		}
   
	}

}



// function prefill_email_for_current_user($field) {
	
//     if (is_user_logged_in() && $field['key'] === 'field_64492a9ca1b78') {
//         $current_user = wp_get_current_user();
//         $current_user_email = $current_user->user_email;
//         $field['value'] = $current_user_email;
//     }

//     return $field;
// }
// if(!is_admin()){
// add_filter('acf/prepare_field', 'prefill_email_for_current_user');}
function get_active_web_ads_count($user_id){
	$adsargs = array(
        'post_type' => 'website_ad',
        'post_status' => 'publish',  
		'author'      =>  $user_id,       
        'meta_query' => array(
            'relation' => 'AND',
        
        array(
            'key' => 'mfw_wa_is_active_ad',
            'value' => true,
            'compare' => '=',
        ),

        )
    );
    $ads_event = new WP_Query($adsargs);
  return $ads_event->post_count;
}

function get_active_video_ads_count($user_id){
	$video_adsargs = array(
        'post_type' => 'video_ad',
        'post_status' => 'publish',  
		'author'      =>  $user_id,       
        'meta_query' => array(
            'relation' => 'AND',
        
        array(
            'key' => 'mfw_wa_is_active_ad',
            'value' => true,
            'compare' => '=',
        ),

        )
    );
    $video_ads_event = new WP_Query($video_adsargs);
  return $video_ads_event->post_count;
}
function get_featured_event_count($user_id, $featured){
		
    $featureargs = array(
        'post_type' => 'event',
        'post_status' => 'publish', 
		'author'      =>  $user_id,       
        'meta_query' => array(
            'relation' => 'AND',
        array(
            'key' => 'mfw_ep_is_featured_event',
            'value' => $featured,
            'compare' => '=',
        ),

        array(
            'key' => 'mfw_ep_is_active_event',
            'value' => 'yes',
            'compare' => '=',
        ),

        )
    );
    $featured_event = new WP_Query($featureargs);
  return $featured_event->post_count;
}


add_filter('woocommerce_order_button_text', 'subscriptions_custom_checkout_submit_button_text' );
function subscriptions_custom_checkout_submit_button_text( $order_button_text ) {
    if ( WC_Subscriptions_Cart::cart_contains_subscription() ) {
        $order_button_text =  __( 'Make Payment', 'woocommerce-subscriptions'  );
    }
    return $order_button_text;
}

add_filter( 'wp_dropdown_cats', 'dropdown_filter', 10, 2);

function dropdown_filter( $output, $r ) {
    $output = preg_replace( '/<select (.*?) >/', '<select $1 size="5" multiple>', $output);
    return $output;
}

add_filter( 'woocommerce_new_customer_data', 'woocommerce_new_customer_data_set_role' );
function woocommerce_new_customer_data_set_role( $customer_data ){
	$customer_data['role'] = 'author';
	return $customer_data;
}

//Hide media library from authors
add_filter( 'ajax_query_attachments_args', 'wpb_show_current_user_attachments' );
 
function wpb_show_current_user_attachments( $query ) {
    $user_id = get_current_user_id();
    if ( $user_id && !current_user_can('activate_plugins') && !current_user_can('edit_others_posts
') ) {
        $query['author'] = $user_id;
    }
    return $query;
} 

function get_user_subscription($user_id){
	$active_subscriptions = get_posts( array(
		'numberposts' => -1, // Only one is enough
		'meta_key'    => '_customer_user',
		'meta_value'  => $user_id,
		'post_type'   => 'shop_subscription', // Subscription post type
		'post_status' => 'wc-active', // Active subscription
		'fields'      => 'ids', // return only IDs (instead of complete post objects)
	) );
return $active_subscriptions;
}

add_filter( 'gettext', 'bt_rename_coupon_field_on_cart', 10, 3 );
add_filter( 'woocommerce_coupon_error', 'bt_rename_coupon_label', 10, 3 );
add_filter( 'woocommerce_coupon_message', 'bt_rename_coupon_label', 10, 3 );
add_filter( 'woocommerce_cart_totals_coupon_label', 'bt_rename_coupon_label',10, 1 );
add_filter( 'woocommerce_checkout_coupon_message', 'bt_rename_coupon_message_on_checkout' );
/**
 * WooCommerce
 * Change Coupon Text
 * @param string $text
 * @return string
 * @link https://gist.github.com/maxrice/8551024
 */

function bt_rename_coupon_field_on_cart( $translated_text, $text, $text_domain ) {
	// bail if not modifying frontend woocommerce text
	if ( is_admin() || 'woocommerce' !== $text_domain ) {
		return $translated_text;
	}
	if ( 'Coupon:' === $text ) {
		$translated_text = 'Discount Code:';
	}

	if ('Coupon has been removed.' === $text){
		$translated_text = 'Discount code has been removed.';
	}

	if ( 'Apply coupon' === $text ) {
		$translated_text = 'Apply Discount';
	}

	if ( 'Coupon code' === $text ) {
		$translated_text = 'Discount Code';
	
	} 
	if ( 'If you have a coupon code, please apply it below.' === $text ) {
		$translated_text = 'If you have a discount code, please apply it below.';
	}

	return $translated_text;
}


// Rename the "Have a Coupon?" message on the checkout page
function bt_rename_coupon_message_on_checkout() {
	return 'Have a Discount code?' . ' ' . __( '<a href="#" class="showcoupon">Click here to enter your code</a>', 'woocommerce' ) . '';
}


function bt_rename_coupon_label( $err, $err_code=null, $something=null ){
	$err = str_ireplace("Coupon","Discount Code ",$err);
	return $err;
}


add_filter( 'acf/get_valid_field', 'change_post_content_type');
function change_post_content_type( $field ) { 
    if($field['type'] == 'wysiwyg') {
        $field['tabs'] = 'visual';
        $field['toolbar'] = 'basic';
        $field['media_upload'] = 0;
    }
    return $field;
}


function user_cancelled_subscription( $subscription ) {
    //print_r($subscription);exit;
    $order_id = $subscription->get_parent_id();
	$subscription = $order_id +1;

	global $wpdb;
	$results = $wpdb->get_results("SELECT * FROM `wp_postmeta` WHERE meta_key = 'pre_business_id' AND post_id = $subscription"   );
	if (is_array($results) && count($results) > 0) {
		foreach ($results as $result) {
			update_field( 'mfw_bd_business_listing', 'free', $result->meta_value );
			delete_post_meta( $subscription, 'pre_business_id', $result->meta_value );	
	}
}
    
}

add_action( 'woocommerce_subscription_status_failed', 'user_cancelled_subscription', 10, 1 );
add_action( 'woocommerce_subscription_status_on-hold', 'user_cancelled_subscription', 10, 1 );
add_action( 'woocommerce_subscription_status_cancelled', 'user_cancelled_subscription', 10, 1 );
add_action( 'woocommerce_subscription_status_switched', 'user_cancelled_subscription', 10, 1 );
add_action( 'woocommerce_subscription_status_expired', 'user_cancelled_subscription', 10, 1 );


add_filter( 'woocommerce_order_button_text', 'misha_custom_button_text' );
 
function misha_custom_button_text( $button_text ) {
	return 'Make Payment'; // new text is here 
}


add_action('after_setup_theme', 'remove_admin_bar');
function remove_admin_bar() {
if (!current_user_can('administrator') && !is_admin()) {
  show_admin_bar(false);
}
}

function my_pre_save_post( $post_id )
	{
	    $listing_type = $GLOBALS['acf_form']['bh_post_type'];

        $query_args = array(
            'pid' => $post_id,
            'ptype' => $listing_type,
            'msg' => 'success'
        );
	    // update $GLOBALS['return']
    	 $GLOBALS['acf_form']['return'] = add_query_arg( $query_args,  $GLOBALS['acf_form']['return'] );
	    return $post_id;
	}
 
add_filter('acf/pre_save_post' , 'my_pre_save_post', 10, 1 );


function get_email_template($content)
{
    $res =
        '<!DOCTYPE html>
		<html lang="en">
		
		<head>
			<meta charset="utf-8"> <!-- utf-8 works for most cases -->
			<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, user-scalable=no">
			<meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
			<title></title>
			<style type="text/css">
				* {
					box-sizing: border-box;
					margin: 0;
					padding: 0;
				}
		
				body,
				#bodyTable {
					height: 100% !important;
					width: 100% !important;
					margin: 0;
					padding: 0;
				}
		
				body,
				table,
				td,
				p,
				a,
				li,
				blockquote {
					-ms-text-size-adjust: 100%;
					-webkit-text-size-adjust: 100%;
				}
		
				table {
					border-spacing: 0;
				}
		
				table,
				td {
					border-collapse: collapse;
					mso-table-lspace: 0pt !important;
					mso-table-rspace: 0pt !important;
				}
		
				img {
					-ms-interpolation-mode: bicubic;
				}
		
				img,
				a img {
					border: 0;
					outline: none;
					text-decoration: none;
				}
		
				@media screen and (max-device-width: 600px),
				screen and (max-width: 600px) {
		
					table[class="email-container"] {
						width: 100% !important;
					}
		
					table[class="fluid"] {
						width: 100% !important;
					}
		
					.fluid,
					.email-container {
						width: 100% !important;
						max-width: 100% !important;
						height: auto !important;
						margin-left: auto !important;
						margin-right: auto !important;
					}
		
					img[class="fluid"],
					img[class="force-col-center"] {
						width: 100% !important;
						max-width: 100% !important;
						height: auto !important;
					}
		
					img[class="force-col-center"] {
						margin: auto !important;
					}
		
					td[class="force-col"],
					td[class="force-col-center"] {
						display: block !important;
						width: 100% !important;
						clear: both;
					}
		
					td[class="force-col-center"] {
						text-align: center !important;
					}
		
					img[class="col-3-img-l"] {
						float: left;
						margin: 0 15px 15px 0;
					}
		
					img[class="col-3-img-r"] {
						float: right;
						margin: 0 0 15px 15px;
					}
		
					table[class="button"] {
						width: 100% !important;
					}
		
					.footer-icons {
						width: 100% !important;
						display: block;
					}
				}
		
				@media screen and (max-device-width: 425px),
				screen and (max-width: 425px) {
		
					div[class="hh-visible"] {
						display: block !important;
					}
		
					div[class="hh-center"] {
						text-align: center;
						width: 100% !important;
					}
		
					table[class="hh-fluid"] {
						width: 100% !important;
					}
		
					img[class="hh-fluid"],
					img[class="hh-force-col-center"] {
						width: 100% !important;
						max-width: 100% !important;
						height: auto !important;
					}
		
					img[class="hh-force-col-center"] {
						margin: auto !important;
					}
		
					td[class="hh-force-col"],
					td[class="hh-force-col-center"] {
						display: block !important;
						width: 100% !important;
						clear: both;
					}
		
					td[class="hh-force-col-center"] {
						text-align: center !important;
					}
		
					img[class="col-3-img-l"],
					img[class="col-3-img-r"] {
						float: none !important;
						margin: 15px auto !important;
						text-align: center !important;
					}
		
				}
		
			</style>
		</head>
		
		<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" bgcolor="#f4f4f4"
			style="margin:0; padding:0; -webkit-text-size-adjust:none; -ms-text-size-adjust:none;">
			<table cellpadding="0" cellspacing="0" border="0" height="100%" width="100%" bgcolor="#f4f4f4" id="bodyTable"
				style="border-collapse: collapse;table-layout: fixed;margin:0 auto;">
				<tr>
					<td>
						<table border="0" width="100%" cellspacing="0"
							cellpadding="0" class="email-container">
							<tr>
								<td align="center">
									<table style="background-color: #7981b9;" bgcolor="#7981b9" border="0" width="600"
										cellspacing="0" cellpadding="0" class="email-container">
										<tr>
											<td style="padding: 15px 35px" class="logo-col">
												<img src="https://focuswaukesha.com/wp-content/uploads/2023/07/white-logo.png"
													alt="" width="260" height="109" border="0" /></td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
		
					</td>
				</tr>
				<tr>
					<td>
						<table style="background-color: #f4f4f4;" border="0" width="100%" cellspacing="0" cellpadding="0"
							bgcolor="#f4f4f4" class="email-container">
							<tr>
								<td align="center" valign="top">
									<table class="email-container" border="0" width="600" cellspacing="0" cellpadding="0" bgcolor="#ffffff">
										<tr>
											<td
												style="color: #000; font-family: Lato, Arial ,sans-serif; font-size: 16px; line-height: 24px; text-align: left; padding: 30px 35px; background-color: #ffffff;" bgcolor="#ffffff">
                                                '.$content.'
                                            </td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
		
					</td>
				</tr>        
				<tr>
					<td>
						<table border="0" width="100%" cellspacing="0" cellpadding="0" class="email-container">
							<tr>
								<td align="center" valign="top">
									<table border="0" width="600" cellspacing="0" cellpadding="0" bgcolor="#7981b9" style="background-color: #7981b9;" class="email-container">
										<tr>    
											<td align="center" valign="top" style="padding: 25px 35px;">
												<table border="0" width="100%" cellspacing="0" cellpadding="0" class="email-container">
													<tr>
														<td style="padding-bottom:20px; font-size: 20px; text-align: center;color: #f5f5f5;font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;">
															Get in Touch
														</td>                                                                                     
													</tr>
												</table>
												<table border="0" width="100%" cellspacing="0" cellpadding="0" class="email-container">
													<tr>
														<td style="padding-top: 6px; color: #f5f5f5; text-align: center; font-size: 12px;font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;">
														For any questions, please contact us at&nbsp;
															<a href="mailto:info@focuswaukesha.com" style="text-decoration: none; color: #fff;">info@focuswaukesha.com</a> or 
															<a href="tel:262-442-0700" style="text-decoration: none; color: #fff;">262-442-0700</a>
														</td>
													</tr>
												</table>
												<table border="0" width="100%" cellspacing="0" cellpadding="0" class="email-container">
													<tr>
														<td style="padding-top: 20px; text-align: center; font-size: 12px; padding-bottom: 10px;font-family: verdana,geneva,sans-serif;">
															<p style="color: #f5f5f5;">To manage your account, please go to <a href="https://focuswaukesha.com/" style="color: #f5f5f5;">focuswaukesha.com</a> and select Login or Register at the top of the home page.</p>
														</td> 
													</tr>
												</table>
												<table border="0" width="100%" cellspacing="0" cellpadding="0" class="email-container">
													<tr>
														<td style="text-align: center; font-size: 12px; font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;">
															<p style="color: #f5f5f5;">
																<a href="/privacy-policy/" style="color: #f5f5f5; text-decoration: none;">Privacy Policy</a>
															</p>
														</td> 
													</tr>
												</table>
                                                <table border="0" width="100%" cellspacing="0" cellpadding="0" class="email-container">
													<tr>
														<td style="padding-bottom:20px;padding-top:20px; font-size: 18px; text-align: center;color: #f5f5f5;font-family: Roboto,RobotoDraft,Helvetica,Arial,sans-serif;">
															Follow us on social media:
														</td>                                                                                     
													</tr>
												</table>
												<table align="center" border="0" width="25%" cellspacing="0" cellpadding="0">
												<tr> 
                                                    <td width="32" align="center">
														<a href="https://www.facebook.com/focus.waukesha">
															<img src="https://focuswaukesha.com/wp-content/uploads/2023/08/facebook.png" width="32" height="32" alt="">
														</a>
													</td>
													<td width="32" align="center">
														<a href="https://twitter.com/FocusWaukesha">
															<img src="https://focuswaukesha.com/wp-content/uploads/2023/08/twitter.png" width="32" height="32" alt="">
														</a>
													</td>
													<td width="32" align="center">
														<a href="https://www.instagram.com/focuswaukesha">
															<img src="https://focuswaukesha.com/wp-content/uploads/2023/08/instagram.png" width="32" height="32" alt="">
														</a>
													</td>
													<td width="32" align="center">
														<a href="https://www.linkedin.com/company/focus-waukesha/about">
															<img src="https://focuswaukesha.com/wp-content/uploads/2023/08/linkedin.png" width="32" height="32" alt="">
														</a>
													</td>
												</tr>
											</table>
											</td>                                                       
										</tr>                                                                                                                                
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</body>
		
		</html>';
    return $res;

}

// Function to handle the thumbnail request
function mfw_get_the_post_thumbnail_src($img)
{
  return (preg_match('~\bsrc="([^"]++)"~', $img, $matches)) ? $matches[1] : '';
}
function mfw_social_buttons($content) {
    global $post;
    if(is_singular( array( 'post', 'event', 'business_directory' ))){
    
        // Get current page URL 
        $sb_url = urlencode(get_permalink());
 
        // Get current page title
        $sb_title = str_replace( ' ', '%20', get_the_title());
		
        $email_body =  str_replace( ' ', '%20', get_the_content());

		// Get Post Thumbnail for pinterest
        //$sb_thumb = mfw_get_the_post_thumbnail_src(get_the_post_thumbnail());
        // Construct sharing URL without using any script
        $twitterURL = 'https://twitter.com/intent/tweet?text='.$sb_title.'&amp;url='.$sb_url;
        $facebookURL = 'https://www.facebook.com/sharer/sharer.php?u='.$sb_url;
 
        $linkedInURL = 'https://www.linkedin.com/shareArticle?mini=true&url='.$sb_url.'&amp;title='.$sb_title;

 
        // Add sharing button at the end of page/page content
        $content .= '<div class="social-box"><div class="social-btn"><ul class="social-icons">';
        $content .= '<li><a href="'. $twitterURL .'" target="_blank" rel="nofollow"><i class="fa-brands fa-x-twitter"></i></a></li>';
        $content .= '<li><a href="'.$facebookURL.'" target="_blank" rel="nofollow"><i class="fa-brands fa-facebook-f"></i></a></li>';
        $content .= '<li><a href="'.$linkedInURL.'" target="_blank" rel="nofollow"><i class="fa-brands fa-linkedin-in"></i></a></li>';
		$content .= '<li><a href="mailto:?subject='.$sb_title.'&body='.$sb_url.'"><i class="fa-solid fa-envelope"></i></a></li>';
		$content .= '</ul><button onclick="window.print();"><i class="fa-solid fa-print"></i><span class="tooltiptext">Print
		</span></button></div></div>';
        
        return $content;
    } else {
        // if not a post/page then don't include sharing button
        return $content;
    }
};
// Enable the_content if you want to automatically show social buttons below your post.

 //add_filter( 'the_content', 'mfw_social_buttons');

// This will create a wordpress shortcode [mfw_social_btns].
// Please it in any widget and social buttons appear their.
// You will need to enabled shortcode execution in widgets.
add_shortcode('mfw_social_btns','mfw_social_buttons');

function ads_prod_ids($id){
	$prod_ids = array(1033,1027 ,1028,1029, 176, 178, 179,175,1032,1034,3260);
	if(in_array($id,$prod_ids)){return true;}else{return false;}
}
//Remove coupon field from checkout
//remove_action( 'woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10 ); 

function my_acf_prepare_field( $field ) {
	global $wp;
    $request = explode( '/', $wp->request );

	if( ( end($request) == 'add-business-listing' && is_account_page() ) ){ 
    
       $field['label'] = "Business or Organization Name";
    }
    
    if ( $field ) {
        return $field;   
    } else {
        exit;
    }
}
add_filter('acf/prepare_field/name=_post_title', 'my_acf_prepare_field');
function my_acf_prepare_field_description( $field ) {
	global $wp;
    $request = explode( '/', $wp->request );

	if( ( end($request) == 'add-business-listing' && is_account_page() ) ){ 
    
       $field['label'] = "Description";
    }
    
    if ( $field ) {
        return $field;   
    } else {
        exit;
    }
}
add_filter('acf/prepare_field/name=_post_content', 'my_acf_prepare_field_description');

/*
 * Add columns to Website Ad post list
 */
function address_custom_column( $column, $post_id ) {
    switch ( $column ) {
      case 'ad_type':
        $ad_type = get_field('mfw_wa_type_of_ad', $post_id);
		if($ad_type == 'full_banner_ad'){echo 'Full Banner Ad';}
		if($ad_type == 'partial_banner_ad'){echo 'Partial Banner Ad';}
		if($ad_type == 'rectangle_ad'){echo 'Rectangle Ad';}
		if($ad_type == 'video_ad'){echo 'Video Ad';}
		if($ad_type == 'sponsored_content'){echo 'Sponsored Content';}
        break;
    }
  }
  add_action ( 'manage_website_ad_posts_custom_column', 'address_custom_column', 10, 2 );

  
add_filter( 'manage_website_ad_posts_columns', 'smashing_realestate_columns' );
function smashing_realestate_columns( $columns ) {
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Title' ),
		'ad_type' => __( 'Ad Type', 'smashing' ),
		'author' => __( 'Author','' ),
		'date' => __( 'Date', 'smashing' ),
	  );
	
	
	return $columns;
  }

  add_action('admin_menu', 'remove_by_caps_admin_menu');

function remove_by_caps_admin_menu(){
    if( !current_user_can( 'administrator' ) ){
        remove_menu_page( 'edit.php?post_type=popup' );
        remove_menu_page('cart66_admin');
        remove_menu_page('popup_theme');
		remove_menu_page('themes.php'); // Appearance
		remove_menu_page('edit-comments.php'); // Comments
		remove_menu_page('edit.php?post_type=page'); // Pages
		remove_menu_page('acf-options');
		


    }
}



add_action( 'template_redirect', 'my_redirect_if_user_not_logged_in' );
 
function my_redirect_if_user_not_logged_in() {
	$maintenance_mode = get_field('sp_maintenance_mode', 'option');
	if ($maintenance_mode && !is_user_logged_in() && !is_page('coming-soon') && !is_front_page() && !is_page('my-account')) {
	
	wp_redirect( site_url() );
	
	exit;
 
	}
}

// Change the From name.
add_filter( 'wp_mail_from_name', function ( $original_email_from ) {
    return 'Focus Waukesha';
} );
   /**
     * Featured image to RSS Feed.
     */
    function dn_add_rss_image() {
        global $post;
    
        $output = '';
        if ( has_post_thumbnail( $post->ID ) ) {
            $thumbnail_ID = get_post_thumbnail_id( $post->ID );
            $thumbnail = wp_get_attachment_image_src( $thumbnail_ID, 'medium' ); /** 'full' can be changed to 'medium' or 'thumbnail' */
    
            $output .= '<media:content xmlns:media="http://search.yahoo.com/mrss/" medium="image" type="image/jpeg"';
            $output .= ' url="'. $thumbnail[0] .'"';
            $output .= ' width="100%"'; /** here you can add styles */
            $output .= ' object-fit="cover"';
            $output .= ' />';
        }
        echo $output;
    }
add_action( 'rss2_item', 'dn_add_rss_image' );

function rss_post_thumbnail($text) {
    // Get the first 25 words from the text
    $words = preg_split('/\s+/', $text);
    $short_text = implode(' ', array_slice($words, 0, 28));
	$short_text .= '...';

    return $short_text;
	}
	add_filter('the_excerpt_rss', 'rss_post_thumbnail');
	//add_filter('the_content_feed', 'rss_post_thumbnail');

	add_filter( 'woocommerce_cart_calculate_fees', 'add_recurring_postage_fees', 10, 1 );

function add_recurring_postage_fees( $cart ) {
	//$cart_total = WC()->cart->get_cart_total();

    if ( ! empty( $cart->recurring_cart_key )) {
        remove_action( 'woocommerce_cart_totals_after_order_total', array( 'WC_Subscriptions_Cart', 'display_recurring_totals' ), 10 );
        remove_action( 'woocommerce_review_order_after_order_total', array( 'WC_Subscriptions_Cart', 'display_recurring_totals' ), 10 );
    }
}

function my_custom_mime_types( $mimes ) {
 
	// New allowed mime types.
	
	$mimes['doc'] = 'application/msword';
	$mimes['docx'] = 'application/vnd.openxmlformats-officedocument.wordprocessingml.document';
	 
	// Optional. Remove a mime type.
	//unset( $mimes['exe'] );
	 
	return $mimes;
	}
	add_filter( 'mime_types', 'my_custom_mime_types' );