<?php
/*
 *  Plugin Name: Wpresidence -Theme Core Functionality
 *  Plugin URI:  https://themeforest.net/user/annapx
 *  Description: Adds functionality to WpResidence
 *  Version:     1.70.1
 *  Author:      wpestate
 *  Author URI:  https://wpestate.org
 *  License:     GPL2
 *  Text Domain: wpresidence-core
 *  Domain Path: /languages
 * 
*/

define('WPESTATE_PLUGIN_URL',  plugins_url() );
define('WPESTATE_PLUGIN_DIR_URL',  plugin_dir_url(__FILE__) );
define('WPESTATE_PLUGIN_PATH',  plugin_dir_path(__FILE__) );
define('WPESTATE_PLUGIN_BASE',  plugin_basename(__FILE__) );

add_action( 'wp_enqueue_scripts', 'wpestate_residence_enqueue_styles' );
add_action( 'admin_enqueue_scripts', 'wpestate_residence_enqueue_styles_admin'); 
add_action( 'plugins_loaded', 'wpestate_residence_functionality_loaded' ); 
register_activation_hook( __FILE__, 'wpestate_residence_functionality' );
register_deactivation_hook( __FILE__, 'wpestate_residence_deactivate' );




function wpestate_residence_functionality_loaded(){
    $my_theme = wp_get_theme();
    $version = floatval( $my_theme->get( 'Version' ));

    if($version< 1.4 && $version!=1){
        deactivate_plugins( plugin_basename( __FILE__ ) );
        wp_die( 'This plugin requires  WpResidence 1.40 or higher.','wpresidence' ); 
    }

    
    
    load_plugin_textdomain( 'wpresidence-core', false, dirname( WPESTATE_PLUGIN_BASE ) . '/languages' );
    wpestate_shortcodes();
   
    add_action('widgets_init', 'register_wpestate_widgets' );
    add_action('wp_footer', 'wpestate_core_add_to_footer');
    
}



function wpestate_residence_functionality(){
    wpresidence_create_helper_content();   
}

function wpestate_residence_deactivate(){
}


function wpestate_residence_enqueue_styles() {
}


function wpestate_residence_enqueue_styles_admin(){
}


require_once(WPESTATE_PLUGIN_PATH . 'misc/metaboxes.php');
require_once(WPESTATE_PLUGIN_PATH . 'misc/plugin_help_functions.php');
require_once(WPESTATE_PLUGIN_PATH . 'misc/redux_help_functions.php');
require_once(WPESTATE_PLUGIN_PATH . 'misc/emailfunctions.php');
require_once(WPESTATE_PLUGIN_PATH . 'misc/3rd_party_code.php');
require_once(WPESTATE_PLUGIN_PATH . 'misc/agent_functions.php');

require_once(WPESTATE_PLUGIN_PATH . 'widgets.php');
require_once(WPESTATE_PLUGIN_PATH . 'shortcodes/shortcodes_install.php');
require_once(WPESTATE_PLUGIN_PATH . 'shortcodes/shortcodes.php');
require_once(WPESTATE_PLUGIN_PATH . 'shortcodes/property_page_shortcodes.php');

require_once(WPESTATE_PLUGIN_PATH . 'post-types/agents.php');
require_once(WPESTATE_PLUGIN_PATH . 'post-types/agency.php');
require_once(WPESTATE_PLUGIN_PATH . 'post-types/developers.php');
require_once(WPESTATE_PLUGIN_PATH . 'post-types/invoices.php');
require_once(WPESTATE_PLUGIN_PATH . 'post-types/searches.php');
require_once(WPESTATE_PLUGIN_PATH . 'post-types/membership.php');
require_once(WPESTATE_PLUGIN_PATH . 'post-types/property.php');
require_once(WPESTATE_PLUGIN_PATH . 'post-types/messages.php');


add_action('init','wpresidence_init_redux',30);

function wpresidence_init_redux(){
    

    require_once WPESTATE_PLUGIN_PATH . 'admin/admin-init.php';
    Redux::init("wpresidence_admin");
    
    
    $walkscore_api= esc_html ( wpresidence_get_option('wp_estate_walkscore_api','') );
    if($walkscore_api!=''){
        require_once(WPESTATE_PLUGIN_PATH.'resources/WalkScore.php');
    }

    
    $facebook_status    =   esc_html( wpresidence_get_option('wp_estate_facebook_login','') );
    if($facebook_status=='yes'){
        require_once WPESTATE_PLUGIN_PATH.'resources/facebook_sdk5/Facebook/autoload.php';
    }
    
    $enable_stripe_status   =   esc_html ( wpresidence_get_option('wp_estate_enable_stripe','') );

    if($enable_stripe_status==='yes'){
        require_once(WPESTATE_PLUGIN_PATH.'resources/stripe/lib/Stripe.php');
    }

    $yelp_client_id             =   wpresidence_get_option('wp_estate_yelp_client_id','');
    $yelp_client_secret         =   wpresidence_get_option('wp_estate_yelp_client_secret','');
    $yelp_client_api_key_2018   =   wpresidence_get_option('wp_estate_yelp_client_api_key_2018','');
    
    if($yelp_client_api_key_2018!=='' && $yelp_client_id!==''  ){
        require_once(WPESTATE_PLUGIN_PATH.'resources/yelp_fusion.php');
    }
    
    $yahoo_status       =   esc_html( wpresidence_get_option('wp_estate_yahoo_login','') );
    if($yahoo_status=='yes'){
        require_once(WPESTATE_PLUGIN_PATH.'resources/openid.php');
    }
    $google_status              = esc_html( wpresidence_get_option('wp_estate_google_login','') );
    
    $twiter_status       =   esc_html( wpresidence_get_option('wp_estate_twiter_login','') );
    if($twiter_status=='yes'){
        require_once WPESTATE_PLUGIN_PATH.'resources/twitteroauth/autoload.php';
    }
    
    if($facebook_status=='yes' ||$twiter_status=='yes' ||  $google_status =='yes'){
        require_once WPESTATE_PLUGIN_PATH.'classes/wpestate_social_login.php';
        global $wpestate_social_login;
        $wpestate_social_login =new Wpestate_Social_Login();
        
    }
    
    

}

add_action('init', 'residence_redux_setup');
function residence_redux_setup() {
     
   
    if(class_exists('ReduxFramework')){
        remove_action( 'admin_notices', array( get_redux_instance('theme_options'), '_admin_notices' ), 99);
    }
    
    if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
        remove_filter( 'plugin_row_meta', array(
            ReduxFrameworkPlugin::instance(),
            'plugin_metalinks'
        ), null, 2 );

        // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
        remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
    }
}



if ( ! function_exists( 'wpresidence_get_option' ) ):
    function wpresidence_get_option( $theme_option,  $option = false ,$in_case_not = false) {

        global $wpresidence_admin;
        $theme_option=trim($theme_option);
 
        if($theme_option=='wpestate_currency' || $theme_option=='wp_estate_multi_curr'){
            $return = wpestate_reverse_convert_redux_wp_estate_multi_curr();
            return $return;
        }else if($theme_option=='wpestate_custom_fields_list' || $theme_option=='wp_estate_custom_fields'){
            $return = wpestate_reverse_convert_redux_wp_estate_custom_fields();
            return $return;
        }
        
       
        if( isset( $wpresidence_admin[$theme_option]) && $wpresidence_admin[$theme_option]!='' ){
            $return=$wpresidence_admin[$theme_option];
            if($option && isset($wpresidence_admin[$theme_option][$option])){
                $return = $wpresidence_admin[$theme_option][$option];
            }
        }else{
            $return=$in_case_not;
        }

        return $return;

    }
endif;

if(!class_exists('Google_Client')){
    require_once WPESTATE_PLUGIN_PATH.'resources/src/Google_Client.php';
    require_once WPESTATE_PLUGIN_PATH.'resources/src/contrib/Google_Oauth2Service.php';
}


        



function wpestate_return_imported_data(){
    return  @unserialize(base64_decode( trim($_POST['import_theme_options']) ) );
}

function wpestate_return_imported_data_encoded($return_exported_data){
    return base64_encode( serialize( $return_exported_data) );
}



add_action( 'plugins_loaded', 'wpestate_check_current_user' );
function wpestate_check_current_user() {
    $current_user = wp_get_current_user();
    if (!current_user_can('manage_options') ) { 
        show_admin_bar(false); 
    }
}


if ( ! function_exists( 'wpestate_reverse_convert_redux_wp_estate_multi_curr' ) ):
function wpestate_reverse_convert_redux_wp_estate_multi_curr(){
    global $wpresidence_admin;
    $final_array = array();
    if(isset($wpresidence_admin['wpestate_currency']['add_curr_name'])){
        foreach ( $wpresidence_admin['wpestate_currency']['add_curr_name'] as $key=>$value ){
            $temp_array=array();
            $temp_array[0]= $wpresidence_admin['wpestate_currency']['add_curr_name'][$key];
            $temp_array[1]= $wpresidence_admin['wpestate_currency']['add_curr_label'][$key];
            $temp_array[2]= $wpresidence_admin['wpestate_currency']['add_curr_value'][$key];
            $temp_array[3]= $wpresidence_admin['wpestate_currency']['add_curr_order'][$key];

            $final_array[]=$temp_array;
        }
    }
    return $final_array;


}
endif;

if ( ! function_exists( 'wpestate_reverse_convert_redux_wp_estate_custom_fields' ) ):
function wpestate_reverse_convert_redux_wp_estate_custom_fields(){
    global $wpresidence_admin;
    $final_array=array();
   
    if(isset($wpresidence_admin['wpestate_custom_fields_list']['add_field_name'])){
        foreach( $wpresidence_admin['wpestate_custom_fields_list']['add_field_name'] as $key=>$value){
            $temp_array=array();
            $temp_array[0]= $wpresidence_admin['wpestate_custom_fields_list']['add_field_name'][$key];
            $temp_array[1]= $wpresidence_admin['wpestate_custom_fields_list']['add_field_label'][$key];
            $temp_array[3]= $wpresidence_admin['wpestate_custom_fields_list']['add_field_order'][$key];
            $temp_array[2]= $wpresidence_admin['wpestate_custom_fields_list']['add_field_type'][$key];
            if( isset(  $wpresidence_admin['wpestate_custom_fields_list']['add_dropdown_order'][$key] ) ){
                $temp_array[4]= $wpresidence_admin['wpestate_custom_fields_list']['add_dropdown_order'][$key];
            }
            $final_array[]=$temp_array;
        }
    }
    
     
   
    usort($final_array,"wpestate_sorting_function_plugin");
    
    
    return $final_array;
}
endif;


if ( ! function_exists( 'wpestate_sorting_function_plugin' ) ):
function wpestate_sorting_function_plugin($a, $b) {
    return intval($a[3]) - intval($b[3]);
};
endif;



if(!function_exists('wpestate_return_all_fields') ):
function wpestate_return_all_fields($is_mandatory=0){
    
    $submission_page_fields     =   ( get_option('wp_estate_submission_page_fields','') );
   
   
    
    $all_submission_fields=$all_mandatory_fields=array(
        'wpestate_description'          =>  esc_html__('Description','wpresidence'),
        'property_price'                =>  esc_html__('Property Price','wpresidence'),
        'property_label'                =>  esc_html__('Property Price Label','wpresidence'),
        'property_label_before'         =>  esc_html__('Property Price Label Before','wpresidence'),
        'prop_category'                 =>  esc_html__('Property Category Submit','wpresidence'),
        'prop_action_category'          =>  esc_html__('Property Action Category','wpresidence'),
        'attachid'                      =>  esc_html__('Property Media','wpresidence'),
        'property_address'              =>  esc_html__('Property Address','wpresidence'),
        'property_city'                 =>  esc_html__('Property City','wpresidence'),
        'property_area'                 =>  esc_html__('Property Area','wpresidence'),
        'property_zip'                  =>  esc_html__('Property Zip','wpresidence'),
        'property_county'               =>  esc_html__('Property County','wpresidence'),
        'property_country'              =>  esc_html__('Property Country','wpresidence'),
        'property_map'                  =>  esc_html__('Property Map','wpresidence'),
        'property_latitude'             =>  esc_html__('Property Latitude','wpresidence'),
        'property_longitude'            =>  esc_html__('Property Longitude','wpresidence'),
        'google_camera_angle'           =>  esc_html__('Google Camera Angle','wpresidence'),
        'property_google_view'          =>  esc_html__('Property Google View','wpresidence'),    
        'property_size'                 =>  esc_html__('property Size','wpresidence'),
        'property_lot_size'             =>  esc_html__('Property Lot Size','wpresidence'),
        'property_rooms'                =>  esc_html__('Property Rooms','wpresidence'),
        'property_bedrooms'             =>  esc_html__('Property Bedrooms','wpresidence'),
        'property_bathrooms'            =>  esc_html__('Property Bathrooms','wpresidence'),
        'owner_notes'                   =>  esc_html__('Owner Notes','wpresidence'),
        'property_status'               =>  esc_html__('property status','wpresidence'),
        'embed_video_id'                =>  esc_html__('Embed Video Id','wpresidence'),
        'embed_video_type'              =>  esc_html__('Embed Video Type','wpresidence'),
        'embed_virtual_tour'            =>  esc_html__('Embed Virtual Tour','wpresidence'),
        'property_subunits_list'        =>  esc_html__('Property Subunits','wpresidence'),
	'energy_class'                  =>  esc_html__('Energy Class','wpresidence'),
        'energy_index'                  =>  esc_html__('Energy Index','wpresidence'),
    );
    
    $i=0;

    $custom_fields = wpresidence_get_option( 'wp_estate_custom_fields', ''); 
    if( !empty($custom_fields)){  
        while($i< count($custom_fields) ){
            $name               =   stripslashes($custom_fields[$i][0]);
            $slug               =   str_replace(' ','_',$name);
            if($is_mandatory==1){
                $slug           =   str_replace(' ','-',$name);
                unset($all_submission_fields['property_map']);
            }          
            $label              =  stripslashes( $custom_fields[$i][1] );
           
            $slug = htmlspecialchars ( $slug ,ENT_QUOTES);
            
            $all_submission_fields[$slug]=$label;
            $i++;
       }
    }

    $feature_list       =   esc_html( get_option('wp_estate_feature_list') );
    $feature_list_array =   explode( ',',$feature_list);
       
    foreach ($feature_list_array as $key=>$checker) {
        $checker            =   stripslashes($checker);
        $post_var_name      =  ( str_replace(' ','_', trim($checker)) );
        $all_submission_fields[$post_var_name]=trim($checker);     
    }
    return $all_submission_fields;
}
endif;

function wpestate_show_license_form_plugin(){
    
    $theme_activated    =   get_option('is_theme_activated','');
    $ajax_nonce         =   wp_create_nonce( "my-check_ajax_license-string" );
    
    
    $return =1;
    
    
    if($theme_activated!='is_active'){
        
        $theme_active_time = get_option('activation_time','');
        if($theme_active_time==''){
            update_option('activation_time',time());
        }
        
        print '<div class="license_check_wrapper">';
            echo' <div class="activate_notice notice_here">'.esc_html__('Please activate the theme in the next 24h to validate the purchase and continue to have access to all theme options! See this ','wpresidence') .'<a href="http://help.wpresidence.net/article/how-to-get-your-buyer-license-code/" target="_blank">link</a> '.esc_html__('if you don\'t know how to get your license key. Thank you!','wpresidence').'</div>';
           print '<div class="license_form">
                <input type="text" id="wpestate_license_key" name="wpestate_license_key">
                <input type="submit" name="submit" id="check_ajax_license" class="new_admin_submit" value="Check License">
                <input type="hidden" id="license_ajax_nonce" name="license_ajax_nonce" value="'.$ajax_nonce.'">
            </div>';
            
            if( $theme_active_time +24*60*60 < time() ){
                print '<div class="activate_notice"> You cannot use the theme options until you activate the theme. </div>';
               // exit();
               $return=0;
            
            }
        print '</div>';

    }
    return $return;
          
}



function wpresidence_create_helper_content() {    
    
     if ( get_option('wpresidence_theme_setup')!=='yes') {
        $page_creation=array(
                array(  
                    'name'      =>'Advanced Search',
                    'template'  =>'advanced_search_results.php',
                ),
                array(  
                    'name'      =>'Compare Listings',
                    'template'  =>'compare_listings.php',
                ),

                array(  
                    'name'      =>'Dashboard - Property List',
                    'template'  =>'user_dashboard.php',
                ),
                array(  
                    'name'      =>'Dashboard - Add Property',
                    'template'  =>'user_dashboard_add.php',
                ),
                array(  
                    'name'      =>'Dashboard - Add Agent',
                    'template'  =>'user_dashboard_add_agent.php',
                ),
                array(  
                    'name'      =>'Dashboard - Agent List',
                    'template'  =>'user_dashboard_agent_list.php',
                ),
                array(  
                    'name'      =>'Dashboard - Favorite Properties',
                    'template'  =>'user_dashboard_favorite.php',
                ),
                array(  
                    'name'      =>'Dashboard - Add Floor Plans',
                    'template'  =>'user_dashboard_floor.php',
                ),
                array(  
                    'name'      =>'Dashboard - Inbox',
                    'template'  =>'user_dashboard_inbox.php',
                ),
                array(  
                    'name'      =>'Dashboard - Invoices',
                    'template'  =>'user_dashboard_invoices.php',
                ),
                array(  
                    'name'      =>'Dashboard - Profile Page',
                    'template'  =>'user_dashboard_profile.php',
                ),
                array(  
                    'name'      =>'Dashboard - Search Results',
                    'template'  =>'user_dashboard_search_result.php',
                ),
                array(  
                    'name'      =>'Dashboard - Saved Searches',
                    'template'  =>'user_dashboard_searches.php',
                ),
        
        );
   
        
        foreach($page_creation as $key=>$template){
            if ( wpestate_get_template_link($template['template'],1 )==home_url('/') ){
             
                $my_post = array(
                    'post_title'    => $template['name'],
                    'post_type'     => 'page',
                    'post_status'   => 'publish',
                );
                $new_id = wp_insert_post($my_post);
                update_post_meta($new_id, '_wp_page_template', $template['template'] );
            }
        }
        
        
          
        ////////////////////  insert sales and rental categories 
        $actions = array(   'Rentals',
                            'Sales'
                        );

        foreach ($actions as $key) {
            $my_cat = array(
                'description' => $key,
                'slug' => $key
            );

            if(!term_exists($key, 'property_action_category') ){
                wp_insert_term($key, 'property_action_category', $my_cat);
            }
        }

        ////////////////////  insert listings type categories 
        $actions = array(   'Apartments', 
                            'Houses', 
                            'Land', 
                            'Industrial',
                            'Offices',
                            'Retail',
                            'Condos',
                            'Duplexes',
                            'Villas'
                        );

        foreach ($actions as $key) {
            $my_cat = array(
                'description' => $key,
                'slug' => str_replace(' ', '-', $key)
            );
        
            if(!term_exists($key, 'property_category') ){
                wp_insert_term($key, 'property_category', $my_cat);
            }
        }      
 
      
    
        add_option('wp_estate_cron_run', time());
        $default_feature_list='attic, gas heat, ocean view, wine cellar, basketball court, gym,pound, fireplace, lake view, pool, back yard, front yard, fenced yard, sprinklers, washer and dryer, deck, balcony, laundry, concierge, doorman, private space, storage, recreation, roof deck';
        add_option('wp_estate_feature_list', $default_feature_list);
     
        $default_status_list='open house, sold';
        add_option('wp_estate_status_list', $default_status_list);
        
        $all_rewrites=array('properties','listings','action','city','area','state','agents','agent_listings','agent-action','agent-city','agent-area','agent-state','agency-category','agency-action-category','agency-city','agency-area','agency-county','developer-category','developer-action-category', 'developer-city','developer-area','developer-county','agency','developer');
        add_option('wp_estate_url_rewrites',$all_rewrites);
       
        add_option('activation_time',time());
        update_option('wpresidence_theme_setup','yes');
    }
}


add_action('wp_head', 'wpestate_add_custom_meta_to_header');

function wpestate_add_custom_meta_to_header(){
    global $post;
    if( is_tax() ) {
        print '<meta name="description" content="'.strip_tags( term_description('', get_query_var( 'taxonomy' ) )).'" >';
    }
   
  
    if ( is_singular('estate_property') ){
        $image_id       =   get_post_thumbnail_id();
        $share_img      =   wp_get_attachment_image_src( $image_id, 'full'); 
        $the_post       =   get_post($post->ID); ?>
  
        <meta property="og:image" content="<?php print esc_url($share_img[0]); ?>"/>
        <meta property="og:image:secure_url" content="<?php print esc_url($share_img[0]); ?>" />
        <meta property="og:description"  content=" <?php print wp_strip_all_tags( $the_post->post_content);?>" />
    <?php }   
    
    if(is_singular('wpestate_search') || is_singular('wpestate_invoice')){
        print '<meta name="robots" content="noindex">';
    }
        
}