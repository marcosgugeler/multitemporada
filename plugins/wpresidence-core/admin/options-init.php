<?php
    /**
     * ReduxFramework Sample Config File
     * For full documentation, please visit: http://docs.reduxframework.com/
     */

    if ( ! class_exists( 'Redux' ) ) {
        return;
    }


    // This is your option name where all the Redux data is stored.
    $opt_name = "wpresidence_admin";
  
    // This line is only for altering the demo. Can be easily removed.
    $opt_name = apply_filters( 'redux_demo/opt_name', $opt_name );
    $path = dirname( __FILE__ ) . '/extensions/';
 
    Redux::setExtensions($opt_name, $path);
 
    /*
     *
     * --> Used within different fields. Simply examples. Search for ACTUAL DECLARATION for field examples
     *
     */

    $sampleHTML = '';
    if ( file_exists( dirname( __FILE__ ) . '/info-html.html' ) ) {
        Redux_Functions::initWpFilesystem();

        global $wp_filesystem;

        $sampleHTML = $wp_filesystem->get_contents( dirname( __FILE__ ) . '/info-html.html' );
    }

    // Background Patterns Reader
    $sample_patterns_path = ReduxFramework::$_dir . '../sample/patterns/';
    $sample_patterns_url  = ReduxFramework::$_url . '../sample/patterns/';
    $sample_patterns      = array();
    
    if ( is_dir( $sample_patterns_path ) ) {

        if ( $sample_patterns_dir = opendir( $sample_patterns_path ) ) {
            $sample_patterns = array();

            while ( ( $sample_patterns_file = readdir( $sample_patterns_dir ) ) !== false ) {

                if ( stristr( $sample_patterns_file, '.png' ) !== false || stristr( $sample_patterns_file, '.jpg' ) !== false ) {
                    $name              = explode( '.', $sample_patterns_file );
                    $name              = str_replace( '.' . end( $name ), '', $sample_patterns_file );
                    $sample_patterns[] = array(
                        'alt' => $name,
                        'img' => $sample_patterns_url . $sample_patterns_file
                    );
                }
            }
        }
    }

    /**
     * ---> SET ARGUMENTS
     * All the possible arguments for Redux.
     * For full documentation on arguments, please refer to: https://github.com/ReduxFramework/ReduxFramework/wiki/Arguments
     * */

    $theme = wp_get_theme(); // For use with some settings. Not necessary.

    $args = array(
        // TYPICAL -> Change these values as you need/desire
        'opt_name'             => $opt_name,
        // This is where your data is stored in the database and also becomes your global variable name.
        'display_name'         => $theme->get( 'Name' ),
        // Name that appears at the top of your panel
        'display_version'      => $theme->get( 'Version' ),
        // Version that appears at the top of your panel
        'menu_type'            => 'menu',
        //Specify if the admin menu should appear or not. Options: menu or submenu (Under appearance only)
        'allow_sub_menu'       => true,
        // Show the sections below the admin menu item or not
        'menu_title'           => __( 'WpResidence Options', 'redux-framework-demo' ),
        'page_title'           => __( 'WpResidence Options', 'redux-framework-demo' ),
        // You will need to generate a Google API key to use this feature.
        // Please visit: https://developers.google.com/fonts/docs/developer_api#Auth
        'google_api_key'       => '',
        // Set it you want google fonts to update weekly. A google_api_key value is required.
        'google_update_weekly' => false,
        // Must be defined to add google fonts to the typography module
        'async_typography'     => false,
        // Use a asynchronous font on the front end or font string
        //'disable_google_fonts_link' => true,                    // Disable this in case you want to create your own google fonts loader
        'admin_bar'            => true,
        // Show the panel pages on the admin bar
        'admin_bar_icon'       => '',
        // Choose an icon for the admin bar menu
        'admin_bar_priority'   => 50,
        // Choose an priority for the admin bar menu
        'global_variable'      => '',
        // Set a different name for your global variable other than the opt_name
        'dev_mode'             => false,
         'show_options_object' => false,
         'forced_dev_mode_off' => false,
        // Show the time the page took to load, etc
        'update_notice'        => false,
        // If dev_mode is enabled, will notify developer of updated versions available in the GitHub Repo
        'customizer'           => true,
        // Enable basic customizer support
        'open_expanded'     => false,                    // Allow you to start the panel in an expanded way initially.
        'disable_save_warn' => true,                    // Disable the save warning when a user changes a field

        // OPTIONAL -> Give you extra features
        'page_priority'        => 1,
        // Order where the menu appears in the admin area. If there is any conflict, something will not show. Warning.
        'page_parent'          => 'themes.php',
        // For a full list of options, visit: http://codex.wordpress.org/Function_Reference/add_submenu_page#Parameters
        'page_permissions'     => 'manage_options',
        // Permissions needed to access the options panel.
        'menu_icon'            => WPESTATE_PLUGIN_DIR_URL. '/img/residence_icon.png',
        // Specify a custom URL to an icon
        'last_tab'             => '',
        // Force your panel to always open to a specific tab (by id)
        'page_icon'            => 'icon-themes',
        // Icon displayed in the admin panel next to your menu_title
        'page_slug'            => '',
        // Page slug used to denote the panel, will be based off page title then menu title then opt_name if not provided
        'save_defaults'        => true, 
        // On load save the defaults to DB before user clicks save or not
        'default_show'         => false, 
        // If true, shows the default value next to each field that is not the default value.
        'default_mark'         => '',
        // What to print by the field's title if the value shown is default. Suggested: *
       // 'show_import_export'   => false,
        // Shows the Import/Export panel when not used as a field.

        // CAREFUL -> These options are for advanced use only
        'transient_time'       => 60 * MINUTE_IN_SECONDS,
        'output'               => true,
        // Global shut-off for dynamic CSS output by the framework. Will also disable google fonts output
        'output_tag'           => true,
        // Allows dynamic CSS to be generated for customizer and google fonts, but stops the dynamic CSS from going to the head
        // 'footer_credit'     => '',                   // Disable the footer credit of Redux. Please leave if you can help it.

        // FUTURE -> Not in use yet, but reserved or partially implemented. Use at your own risk.
        'database'             => '',
        // possible: options, theme_mods, theme_mods_expanded, transient. Not fully functional, warning!
        'use_cdn'              => true,
        // If you prefer not to use the CDN for Select2, Ace Editor, and others, you may download the Redux Vendor Support plugin yourself and run locally or embed it in your code.
        'options_object'  => false, 
        // HINTS
        'hints'                => array(
            'icon'          => 'el el-question-sign',
            'icon_position' => 'right',
            'icon_color'    => 'lightgray',
            'icon_size'     => 'normal',
            'tip_style'     => array(
                'color'   => 'red',
                'shadow'  => true,
                'rounded' => false,
                'style'   => '',
            ),
            'tip_position'  => array(
                'my' => 'top left',
                'at' => 'bottom right',
            ),
            'tip_effect'    => array(
                'show' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'mouseover',
                ),
                'hide' => array(
                    'effect'   => 'slide',
                    'duration' => '500',
                    'event'    => 'click mouseleave',
                ),
            ),
        )
    );

   

    // SOCIAL ICONS -> Setup custom links in the footer for quick links in your panel footer icons.
    $args['share_icons'][] = array(
        'url'   => 'https://www.facebook.com/wpestate/',
        'title' => 'Like us on Facebook',
        'icon'  => 'el el-facebook'
    );
    $args['share_icons'][] = array(
        'url'   => 'https://twitter.com/wpestate',
        'title' => 'Follow us on Twitter',
        'icon'  => 'el el-twitter'
    );
    $args['share_icons'][] = array(
        'url'   => 'https://www.youtube.com/channel/UC4OAel8_RSDjNgAibtBEDsg',
        'title' => 'Find us on Youtube',
        'icon'  => 'el el-youtube'
    );



    Redux::setArgs( $opt_name, $args );

    /*
     * ---> END ARGUMENTS
     */


     /*
     *
     * ---> START SECTIONS
     *
     */

    /*

        As of Redux 3.5+, there is an extensive API. This API can be used in a mix/match mode allowing for


     */

    // -> START General Section
    
  
    
    $measure_array = array( 
        esc_html__('ft','wpresidence-core'  )   =>  esc_html__('square feet - ft2','wpresidence-core' ),
        esc_html__('m','wpresidence-core'  )    =>  esc_html__('square meters - m2','wpresidence-core' ),
        esc_html__('ac','wpresidence-core'  )   =>  esc_html__('acres - ac','wpresidence-core' ),
        esc_html__('yd','wpresidence-core'  )   =>  esc_html__('square yards - yd2','wpresidence-core' ),
        esc_html__('ha','wpresidence-core'  )   =>  esc_html__('hectares - ha','wpresidence-core' ),
    );
    
    
    Redux::setSection( $opt_name, array(
        'title' => __( 'General', 'wpresidence-core' ),
        'id'    => 'general_settings_sidebar',
        'icon'  => 'el el-adjust-alt'
    ) );
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'General Settings', 'wpresidence-core' ),
        'id'         => 'global_settings_tab',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wp_estate_general_country',
                'type'     => 'select',
                'title'    => __( 'Country', 'wpresidence-core' ),
                'subtitle' => __( 'Select default country', 'wpresidence-core' ),
                'options'  => wpestate_country_list_redux(),
                'default'  => esc_html__("United States",'wpresidence-core') 
            ),
            array(
                'id'       => 'wp_estate_measure_sys',
                'type'     => 'select',
                'title'    => __( 'Measurement Unit', 'wpresidence-core' ),
                'subtitle' => __( 'Select the measurement unit you will use on the website', 'wpresidence-core' ),
                'options'  => $measure_array,
                'default'  => 'ft'
            ),

            array(
                'id'       => 'wp_estate_date_lang',
                'type'     => 'select',
                'title'    => __( 'Language for datepicker', 'wpresidence-core' ),
                'subtitle' => __( 'This applies for the calendar field type available for properties.', 'wpresidence-core' ),
                'options'  => array(  
                            'xx'=> 'default',
                            'af'=>'Afrikaans',
                            'ar'=>'Arabic',
                            'ar-DZ' =>'Algerian',
                            'az'=>'Azerbaijani',
                            'be'=>'Belarusian',
                            'bg'=>'Bulgarian',
                            'bs'=>'Bosnian',
                            'ca'=>'Catalan',
                            'cs'=>'Czech',
                            'cy-GB'=>'Welsh/UK',
                            'da'=>'Danish',
                            'de'=>'German',
                            'el'=>'Greek',
                            'en-AU'=>'English/Australia',
                            'en-GB'=>'English/UK',
                            'en-NZ'=>'English/New Zealand',
                            'eo'=>'Esperanto',
                            'es'=>'Spanish',
                            'et'=>'Estonian',
                            'eu'=>'Karrikas-ek',
                            'fa'=>'Persian',
                            'fi'=>'Finnish',
                            'fo'=>'Faroese',
                            'fr'=>'French',
                            'fr-CA'=>'Canadian-French',
                            'fr-CH'=>'Swiss-French',
                            'gl'=>'Galician',
                            'he'=>'Hebrew',
                            'hi'=>'Hindi',
                            'hr'=>'Croatian',
                            'hu'=>'Hungarian',
                            'hy'=>'Armenian',
                            'id'=>'Indonesian',
                            'ic'=>'Icelandic',
                            'it'=>'Italian',
                            'it-CH'=>'Italian-CH',
                            'ja'=>'Japanese',
                            'ka'=>'Georgian',
                            'kk'=>'Kazakh',
                            'km'=>'Khmer',
                            'ko'=>'Korean',
                            'ky'=>'Kyrgyz',
                            'lb'=>'Luxembourgish',
                            'lt'=>'Lithuanian',
                            'lv'=>'Latvian',
                            'mk'=>'Macedonian',
                            'ml'=>'Malayalam',
                            'ms'=>'Malaysian',
                            'nb'=>'Norwegian',
                            'nl'=>'Dutch',
                            'nl-BE'=>'Dutch-Belgium',
                            'nn'=>'Norwegian-Nynorsk',
                            'no'=>'Norwegian',
                            'pl'=>'Polish',
                            'pt'=>'Portuguese',
                            'pt-BR'=>'Brazilian',
                            'rm'=>'Romansh',
                            'ro'=>'Romanian',
                            'ru'=>'Russian',
                            'sk'=>'Slovak',
                            'sl'=>'Slovenian',
                            'sq'=>'Albanian',
                            'sr'=>'Serbian',
                            'sr-SR'=>'Serbian-i18n',
                            'sv'=>'Swedish',
                            'ta'=>'Tamil',
                            'th'=>'Thai',
                            'tj'=>'Tajiki',
                            'tr'=>'Turkish',
                            'uk'=>'Ukrainian',
                            'vi'=>'Vietnamese',
                            'zh-CN'=>'Chinese',
                            'zh-HK'=>'Chinese-Hong-Kong',
                            'zh-TW'=>'Chinese Taiwan',
                ),
                 'default'   => 'en-GB'
            ),
           array(
                'id'       => 'wp_estate_google_analytics_code',
                'type'     => 'text',
                'title'    => __( 'Google Analytics Tracking id', 'wpresidence-core' ),
                'subtitle' => __( 'Google Analytics Tracking id (ex UA-41924406-1)', 'wpresidence-core' ),
            ), 
            
            
        ),
    ) );
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'User Role Settings', 'wpresidence-core' ),
        'id'         => 'user_role_options_tab',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wp_estate_visible_user_role_dropdown',
                'type'     => 'button_set',
                'title'    => __( 'Display user roles dropdown in register forms', 'wpresidence-core' ),
                'subtitle' => __( 'This applies for for all register forms.', 'wpresidence-core' ),
                'options'  => array(
                    'yes' => 'yes',
                    'no'  => 'no'
                    ),
                'default'  => 'no',
            ),
            array(
                'id'       => 'wp_estate_visible_user_role',
                'type'     => 'select',
                'multi'    => true,
                'required' => array('wp_estate_visible_user_role_dropdown', '=', 'yes'),
                'class'    => 'class_visible_user_role',
                'title'    => __( 'Select user roles to display in register forms.', 'wpresidence-core' ),
                'subtitle' => __( 'This applies for all register forms. *Hold CTRL for multiple selection.', 'wpresidence-core' ),
                'options'  => array(
                    esc_html__('User','wpresidence-core')         => esc_html__('User','wpresidence-core'),
                    esc_html__('Single Agent','wpresidence-core') => esc_html__('Single Agent','wpresidence-core'),
                    esc_html__('Agency','wpresidence-core')       => esc_html__('Agency','wpresidence-core'),
                    esc_html__('Developer','wpresidence-core')    => esc_html__('Developer','wpresidence-core')
                ),
                'default'  => '',
            ),
            
              array(
                'id'       => 'wp_estate_admin_submission_user_role',
                'type'     => 'select',
                'multi'    => true,
                'class'    => 'class_visible_user_role',
                'required' => array('wp_estate_visible_user_role_dropdown', '=', 'yes'),
                'title'    => __( 'Select wich user role the admin should approve?', 'wpresidence-core' ),
                'subtitle' => __( 'Users will be automatically approved. *Hold CTRL for multiple selection.', 'wpresidence-core' ),
                'options'  => array(
                    'Agent'         => __('Agent','wpresidence-core'),
                    'Agency'        => __('Agency','wpresidence-core'),
                    'Developer'     => __('Developer','wpresidence-core')
                ),
                'default'  => '',
            ),
            
            
            array(
                'id'       => 'wp_estate_show_reviews_block',
                'type'     => 'select',
                'multi'    => true,
                'class'    => 'class_visible_user_role',
                'title'    => __( 'Select Taxonomies, where you want to show review block', 'wpresidence-core' ),
                'subtitle' => __( '*Hold CTRL for multiple selection.', 'wpresidence-core' ),
                'options'  => array(
                    'agent'         => __('Agent','wpresidence-core'),
                    'agency'        => __('Agency','wpresidence-core'),
                    'developer'     => __('Developer','wpresidence-core')
                ),
                'default'  => '',
            ),
            
            array(
                'id'       => 'wp_estate_admin_approves_reviews',
                'type'     => 'button_set',
                'title'    => __( 'Admin Should approve the reviews', 'wpresidence-core' ),
                'subtitle' => __( 'If yes, the reviews can be found in comments section', 'wpresidence-core' ),
                'options'  => array(
                    'yes' => 'yes',
                    'no'  => 'no'
                    ),
                'default'  => 'yes',
            ),
            
          
            array(
                'id'       => 'wp_estate_enable_user_pass',
                'type'     => 'button_set',
                'title'    => __( 'Users can type the password on registration form', 'wpresidence-core' ),
                'subtitle' => __( 'If no, users will get the auto generated password via email', 'wpresidence-core' ),
                'options'  => array(
                    'yes' => 'yes',
                    'no'  => 'no'
                    ),
                'default'  => 'no',
            ),
            
        ),
    ) );
    
  Redux::setSection( $opt_name, array(
    'title'      => __( 'Appearance', 'wpresidence-core' ),
    'id'         => 'appearance_options_tab',
    'subsection' => true,
    'fields'     => array(
            array(
                'id'       => 'wp_estate_wide_status',
                'type'     => 'button_set',
                'title'    => __( 'Wide or Boxed?', 'wpresidence-core' ),
                'subtitle' => __( 'Choose the theme layout: wide or boxed.', 'wpresidence-core' ),
                'options'  => array(
                    '1' =>  __( 'wide','wpresidence-core'),
                    '2' =>  __( 'boxed','wpresidence-core')
                ),
                'default'  => '1'
            ),
        
            array(
                    'id'       => 'wp_estate_prop_no',
                    'type'     => 'text',
                    'title'    => __( 'Properties List - Properties number per page', 'wpresidence-core' ),
                    'subtitle' => __( 'Set how many properties to show per page in lists.', 'wpresidence-core' ),
                    'default'  => '12'
            ),
        
            array(
                'id'       => 'wp_estate_prop_list_slider',
                'type'     => 'button_set',
                'title'    => __( 'Use Slider in Property Unit', 'wpresidence-core' ),
                'subtitle' => __( 'Enable / Disable the image slider in property unit (used in lists).', 'wpresidence-core' ),
                'options'  => array(
                    '0' =>  __( 'no','wpresidence-core'),
                    '1' =>  __( 'yes','wpresidence-core')
                    ),
                'default'  => '0',
            ),
        
            array(
                'id'       => 'wp_estate_property_list_type',
                'type'     => 'button_set',
                'title'    => __( 'Property List Type for Taxonomy pages', 'wpresidence-core' ),
                'subtitle' => __( 'Select standard or half map style for property taxonomies pages.', 'wpresidence-core' ),
                'options'  => array(
                    '1' =>  __( 'standard','wpresidence-core'),
                    '2' =>  __( 'half map','wpresidence-core')
                    ),
                'default'  => '1',
            ),
        
            array(
                'id'       => 'wp_estate_property_list_type_adv',
                'type'     => 'button_set',
                'title'    => __( 'Property List Type for Advanced Search', 'wpresidence-core' ),
                'subtitle' => __( 'Select standard or half map style for advanced search results page.', 'wpresidence-core' ),
                'options'  => array(
                    '1' =>  __( 'standard','wpresidence-core'),
                    '2' =>  __( 'half map','wpresidence-core')
                    ),
                'default'  => '2',
            ),
        
            array(
                'id'       => 'wp_estate_prop_unit',
                'type'     => 'button_set',
                'title'    => __( 'Property List display (*global option)', 'wpresidence-core' ),
                'subtitle' => __( 'Select grid or list style for properties list pages.', 'wpresidence-core' ),
                'options'  => array(
                    'grid' =>  __( 'grid','wpresidence-core'),
                    'list' =>  __( 'list','wpresidence-core')
                    ),
                'default'  => 'grid',
            ),
        
            array(
                'id'       => 'wp_estate_agent_sidebar',
                'type'     => 'button_set',
                'title'    => __( 'Agent Sidebar Position', 'wpresidence-core' ),
                'subtitle' => __( 'Where to show the sidebar in agent page.', 'wpresidence-core' ),
                'options'  => array(
                    'no sidebar' =>  __( 'no sidebar','wpresidence-core'),
                    'right'      =>  __( 'right','wpresidence-core'),
                    'left'       =>  __( 'left','wpresidence-core')
                    ),
                'default'  => 'right',
            ),
        
            array(
                'id'       => 'wp_estate_agent_sidebar_name',
                'type'     => 'select',
                'title'    => __( 'Agent page Sidebar', 'wpresidence-core' ),
                'subtitle' => __( 'What sidebar to show in agent page.', 'wpresidence-core' ),
                'data'  =>  'sidebars',
                'default'  => 'primary-widget-area'   
            ),
        
            array(
                'id'       => 'wp_estate_blog_sidebar',
                'type'     => 'button_set',
                'title'    => __( 'Property Taxonomy and Blog Category/Archive Sidebar Position', 'wpresidence-core' ),
                'subtitle' => __( 'Where to show the sidebar for blog category/archive list.', 'wpresidence-core' ),
                'options'  => array(
                    'no sidebar' =>  __( 'no sidebar','wpresidence-core'),
                    'right'      =>  __( 'right','wpresidence-core'),
                    'left'       =>  __( 'left','wpresidence-core')
                    ),
                'default'  => 'right',
            ),
        
            array(
                'id'       =>   'wp_estate_blog_sidebar_name',
                'type'     =>   'select',
                'title'    =>   __( 'Property Taxonomy and Blog Category/Archive Sidebar', 'wpresidence-core' ),
                'subtitle' =>   __( 'What sidebar to show for blog category/archive list.', 'wpresidence-core' ),
                'data'     =>   'sidebars',
                'default'  =>   'primary-widget-area'
                
            ),
        
            array(
                'id'       => 'wp_estate_blog_unit',
                'type'     => 'button_set',
                'title'    => __( 'Blog Category/Archive List type', 'wpresidence-core' ),
                'subtitle' => __( 'Select list or grid style for Blog Category/Archive list type.', 'wpresidence-core' ),
                'options'  => array(
                    'grid' =>  __( 'grid','wpresidence-core'),
                    'list' =>  __( 'list','wpresidence-core')
                    ),
                'default'  => 'grid',
            ),
        ),
    ) );
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Logos & Favicon', 'wpresidence-core' ),
        'id'         => 'logos_favicon_tab',
        'class'    => 'logos_fav_class',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wp_estate_favicon_image',
                'type'     => 'media',
                'url'      => true,
                'title'    => __( 'Your Favicon', 'wpresidence-core' ),
                'subtitle' => __( 'Upload site favicon in .ico, .png, .jpg or .gif format', 'wpresidence-core' ),         
            ),
            
            array(
                'id'     => 'opt-info_retina',
                'type'   => 'info',
                'notice' => false,
                'title'   => __( 'For RETINA version create first retina logo. Add _2x at the end of name of the original file (for ex logo_2x.jpg for retina and logo.jpg for non retina). Upload the retina logo from Media - Add New. Help - ', 'wpresidence-core' ).'<a href="http://help.wpresidence.net/article/how-to-add-retina-logos/">http://help.wpresidence.net/article/how-to-add-retina-logos/</a>'
            ),
            
            array(
                'id'       => 'wp_estate_logo_image',
                'type'     => 'media',
                'url'      => true,
                'title'    => __( 'Your Logo', 'wpresidence-core' ),
                'subtitle' => __( 'Use the "Upload" button and "Insert into Post" button from the pop up window.', 'wpresidence-core' ),         
            ),
            
            array(
                'id'       => 'wp_estate_stikcy_logo_image',
                'type'     => 'media',
                'url'      => true,
                'title'    => __( 'Your Sticky Logo', 'wpresidence-core' ),
                'subtitle' => __( 'Use the "Upload" button and "Insert into Post" button from the pop up window.', 'wpresidence-core' ),         
            ),
            
            array(
                'id'       => 'wp_estate_transparent_logo_image',
                'type'     => 'media',
                'url'      => true,
                'title'    => __( 'Your Transparent Header Logo', 'wpresidence-core' ),
                'subtitle' => __( 'Use the "Upload" button and "Insert into Post" button from the pop up window.', 'wpresidence-core' ),         
            ),
            
            array(
                    'id'       => 'wp_estate_logo_margin',
                    'type'     => 'text',
                    'title'    => __( 'Margin Top for logo', 'wpresidence-core' ),
                    'subtitle' => __( 'Add logo margin top as a number (ex: 10)', 'wpresidence-core' ),
                    'default'  => '0'
            ),
            
            array(
                'id'       => 'wp_estate_mobile_logo_image',
                'type'     => 'media',
                'url'      => true,
                'title'    => __( 'Mobile/Tablets Logo', 'wpresidence-core' ),
                'subtitle' => __( 'Upload mobile logo in jpg or png format.', 'wpresidence-core' ),         
            ),
            
        ),
    ) );
    
    
    Redux::setSection($opt_name, array(
        'title' => __('Header', 'wpresidence-core'),
        'id' => 'header_settings_tab',
        'subsection' => true,
        'fields' => array(
            array(
                'id'       => 'wp_estate_show_top_bar_user_menu',
                'type'     => 'button_set',
                'title'    => __( 'Show top bar widget menu ?', 'wpresidence-core' ),
                'subtitle' => __( 'Enable or disable top bar widget area. If enabled, see this help article to add widgets: ', 'wpresidence-core' ).'<a href="http://help.wpresidence.net/article/widgets-2/#a_wpestate_id" target = "_blank"> http://help.wpresidence.net/article/widgets-2/ </a>',
                'options'  => array(
                    'yes' => 'yes',
                    'no'  => 'no'
                    ),
                'default'  => 'no',
            ),
            
            array(              
                'id'       => 'wp_estate_show_top_bar_user_menu_mobile',
                'type'     => 'button_set',
                'required' => array('wp_estate_show_top_bar_user_menu','=','yes'),
                'title'    => __( 'Show top bar on mobile devices?', 'wpresidence-core' ),
                'subtitle' => __( 'Enable or disable top bar on mobile devices', 'wpresidence-core' ),
                'options'  => array(
                    'yes' => 'yes',
                    'no'  => 'no'
                    ),
                'default'  => 'yes',
            ),
            
            array(
                'id'       => 'wp_estate_show_top_bar_user_login',
                'type'     => 'button_set',
                'title'    => __( 'Show user login menu in header ?', 'wpresidence-core' ),
                'subtitle' => __( 'Enable or disable user login menu in header.', 'wpresidence-core' ),
                'options'  => array(
                    'yes' => 'yes',
                    'no'  => 'no'
                    ),
                'default'  => 'no',
            ),
            array(
                    'id'       => 'wp_estate_login_redirect',
                    'type'     => 'text',
                    'title'    => __( 'Url where the user will be redirected after login.', 'wpresidence-core' ),
                    'subtitle' => __( 'If left blank we will redirect to the dashboard profile page .', 'wpresidence-core' ),
                    'default'  =>''
            ),
            
            array(
                'id'       => 'wp_estate_show_submit',
                'type'     => 'button_set',
                'title'    => __( 'Show submit property button in header?', 'wpresidence-core' ),
                'subtitle' => __( 'Submit property will only work with theme register/login.', 'wpresidence-core' ),
                'options'  => array(
                    'yes' => 'yes',
                    'no'  => 'no'
                    ),
                'default'  => 'yes',
            ),
            
            array(
                'id'       => 'wp_estate_header_transparent',
                'type'     => 'button_set',
                'title'    => __( 'Global transparent header?', 'wpresidence-core' ),
                'subtitle' => __( 'Enable or disable the use of transparent header globally.', 'wpresidence-core' ),
                'options'  => array(
                    'no' => 'no',
                    'yes'  => 'yes'
                    ),
                'default'  => 'no',
            ),
            
            array(
                'id'       => 'wp_estate_logo_header_type',
                'type'     => 'button_set',
                'title'    => __( 'Header Type?', 'wpresidence-core' ),
                'subtitle' => __( 'Select header type.Header type 4 will NOT work with half map property list template.', 'wpresidence-core' ),
                'options'  => array(
                    'type1' => 'type1',
                    'type2' => 'type2',
                    'type3' => 'type3',
                    'type4' => 'type4',
                    'type5' => 'type5'
                    ),
                'default'  => 'type1',
            ),
            
            array(
                'id'       => 'wp_estate_logo_header_align',
                'type'     => 'button_set',
                'title'    => __( 'Header Align(Logo Position)?', 'wpresidence-core' ),
                'subtitle' => __( 'Select header alignment.Please note that there is no "center" align for type 3 and 4.', 'wpresidence-core' ),
                'options'  => array(
                    'left'   => 'left',
                    'center' => 'center',
                    'right'  => 'right'
                    ),
                'default'  => 'left',
            ),
            
            array(
                'id'       => 'wp_estate_text_header_align',
                'type'     => 'button_set',
                'title'    => __( 'Header 3&4 Text Align?', 'wpresidence-core' ),
                'subtitle' => __( 'Select a text alignment for header 3&4.', 'wpresidence-core' ),
                'options'  => array(
                    'left'   => 'left',
                    'center' => 'center',
                    'right'  => 'right'
                    ),
                'default'  => 'left',
            ),
            
            array(
                'id'       => 'wp_estate_wide_header',
                'type'     => 'button_set',
                'title'    => __( 'Wide Header ?', 'wpresidence-core' ),
                'subtitle' => __( 'make the header 100%.', 'wpresidence-core' ),
                'options'  => array(
                    'no'  => 'no',
                    'yes' => 'yes',
                    ),
                'default'  => 'no',
            ),
            
            array(
                'id'       => 'wp_estate_header_type',
                'type'     => 'button_set',
                'title'    => __( 'Media Header Type?', 'wpresidence-core' ),
                'subtitle' => __( 'Select what media header to use globally.', 'wpresidence-core' ),
                'options'  => array(
                    'none',
                    'image',
                    'theme slider',
                    'revolution slider',
                    'google map'
                    ),
                'default'  => 4,
            ),
            
            array(
                    'id'       => 'wp_estate_global_revolution_slider',
                    'type'     => 'text',
                    'required'  => array('wp_estate_header_type','=','3'),
                    'title'    => __( 'Global Revolution Slider', 'wpresidence-core' ),
                    'subtitle' => __( 'If media header is set to Revolution Slider, type the slider name and save.', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_global_header',
                'type'     => 'media',
                'url'      => true,
                'required'  => array('wp_estate_header_type','=','1'),
                'title'    => __( 'Global Header Static Image', 'wpresidence-core' ),
                'subtitle' => __( 'If media header is set to image, add the image below.', 'wpresidence-core' ),         
            ),
            
            array(
                'id'       => 'wp_estate_paralax_header',
                'type'     => 'button_set',
                'title'    => __( 'Parallax efect for image/video header media ?', 'wpresidence-core' ),
                'subtitle' => __( 'Enable parallax efect for image/video media header.', 'wpresidence-core' ),
                'options'  => array(
                    'yes'  => 'yes',
                    'no'   => 'no',
                    ),
                'default'  => 'no',
            ),
            
            array(
                    'id'       => 'wp_estate_header5_info_widget1_icon',
                    'required'  => array('wp_estate_logo_header_type','=','type5'),
                    'type'     => 'text',
                    'title'    => __( 'Header 5 - Info widget1 - icon', 'wpresidence-core' ),
                    'subtitle' => __( 'Header 5 - Info widget1 - icon. Ex: fa fa-phone', 'wpresidence-core' ),
            ),
            
            array(
                    'id'       => 'wp_estate_header5_info_widget1_text1',
                    'type'     => 'text',
                    'required'  => array('wp_estate_logo_header_type','=','type5'),
                    'title'    => __( 'Header 5 - Info widget2 - First line of text', 'wpresidence-core' ),
                    'subtitle' => __( 'Header 5 - Info widget2 - First line of text', 'wpresidence-core' ),
            ),
            
            array(
                    'id'       => 'wp_estate_header5_info_widget1_text2',
                    'type'     => 'text',
                    'required'  => array('wp_estate_logo_header_type','=','type5'),
                    'title'    => __( 'Header 5 - Info widget2 - Second line of text', 'wpresidence-core' ),
                    'subtitle' => __( 'Header 5 - Info widget2 - Second line of text', 'wpresidence-core' ),
            ),
            
            array(
                    'id'       => 'wp_estate_header5_info_widget2_icon',
                    'type'     => 'text',
                    'required'  => array('wp_estate_logo_header_type','=','type5'),
                    'title'    => __( 'Header 5 - Info widget2 - icon', 'wpresidence-core' ),
                    'subtitle' => __( 'Header 5 - Info widget2 - icon. Ex: fa fa-phone', 'wpresidence-core' ),
            ),
            
            array(
                    'id'       => 'wp_estate_header5_info_widget2_text1',
                    'type'     => 'text',
                    'required'  => array('wp_estate_logo_header_type','=','type5'),
                    'title'    => __( 'Header 5 - Info widget 2 - First line of text', 'wpresidence-core' ),
                    'subtitle' => __( 'Header 5 - Info widget 2 - First line of text', 'wpresidence-core' ),
            ),
            
            array(
                    'id'       => 'wp_estate_header5_info_widget2_text2',
                    'type'     => 'text',
                    'required'  => array('wp_estate_logo_header_type','=','type5'),
                    'title'    => __( 'Header 5 - Info widget 2 - Second line of text', 'wpresidence-core' ),
                    'subtitle' => __( 'Header 5 - Info widget 2 - Second line of text', 'wpresidence-core' ),
            ),
            
            array(
                    'id'       => 'wp_estate_header5_info_widget3_icon',
                    'type'     => 'text',
                    'required'  => array('wp_estate_logo_header_type','=','type5'),
                    'title'    => __( 'Header 5 - Info widget 3 - icon', 'wpresidence-core' ),
                    'subtitle' => __( 'Header 5 - Info widget 3 - icon. Ex: fa fa-phone', 'wpresidence-core' ),
            ),
            
            array(
                    'id'       => 'wp_estate_header5_info_widget3_text1',
                    'type'     => 'text',
                    'required'  => array('wp_estate_logo_header_type','=','type5'),
                    'title'    => __( 'Header 5 - Info widget 3 - First line of text', 'wpresidence-core' ),
                    'subtitle' => __( 'Header 5 - Info widget 3 - First line of text', 'wpresidence-core' ),
            ),
            
            array(
                    'id'       => 'wp_estate_header5_info_widget3_text2',
                    'type'     => 'text',
                    'required'  => array('wp_estate_logo_header_type','=','type5'),
                    'title'    => __( 'Header 5 - Info widget 3 - Second line of text', 'wpresidence-core' ),
                    'subtitle' => __( 'Header 5 - Info widget 3 - Second line of text', 'wpresidence-core' ),
            ),
           
        ),
    ));
    
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Footer', 'wpresidence-core' ),
        'id'         => 'footer_settings_tab',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wp_estate_show_footer',
                'type'     => 'button_set',
                'title'    => __( 'Show Footer ?', 'wpresidence-core' ),
                'subtitle' => __( 'Show Footer ?', 'wpresidence-core' ),
                'options'  => array(
                    'yes'  => 'yes',
                    'no'   => 'no',
                    ),
                'default'  => 'yes',
            ),
            
            array(
                'id'       => 'wp_estate_show_footer_copy',
                'type'     => 'button_set',
                'title'    => __( 'Show Footer Copyright Area?', 'wpresidence-core' ),
                'subtitle' => __( 'Show Footer Copyright Area?', 'wpresidence-core' ),
                'options'  => array(
                    'yes'  => 'yes',
                    'no'   => 'no',
                    ),
                'default'  => 'yes',
            ),          
                        
            array(
                'id'       => 'wp_estate_copyright_message',
                'type'     => 'textarea',
                'required' => array('wp_estate_show_footer_copy','=','yes'),
                'title'    => __( 'Copyright Message', 'wpresidence-core' ),
                'subtitle' => __('Type here the copyright message that will appear in footer. Add only text.', 'wpresidence-core'),
                'default'  => 'Copyright All Rights Reserved 2019',
            ),
            
            array(
                'id'       => 'wp_estate_show_sticky_footer',
                'type'     => 'button_set',
                'title'    => __( 'Use Sticky Footer?', 'wpresidence-core' ),
                'subtitle' => __( 'Use Sticky Footer?', 'wpresidence-core' ),
                'options'  => array(
                    'no'   => 'no',
                    'yes'  => 'yes'
                    ),
                'default'  => 'no',
            ),

            
            array(
                'id'       => 'wp_estate_footer_background',
                'type'     => 'media',
                'url'      => true,
                'title'    => __( 'Background for Footer', 'wpresidence-core' ),
                'subtitle' => __( 'Insert background footer image.', 'wpresidence-core' ),         
            ),
            
            array(
                'id'       => 'wp_estate_repeat_footer_back',
                'type'     => 'button_set',
                'title'    => __( 'Repeat Footer background ?', 'wpresidence-core' ),
                'subtitle' => __( 'Set repeat options for background footer image.', 'wpresidence-core' ),
                'options'  => array(
                    'repeat'    => 'repeat',
                    'repeat x'  => 'repeat x',
                    'repeat y'  => 'repeat y',
                    'no repeat' => 'no repeat'
                    ),
                'default'  => 'repeat',
            ),
            
            array(
                'id'       => 'wp_estate_wide_footer',
                'type'     => 'button_set',
                'title'    => __( 'Wide Footer ?', 'wpresidence-core' ),
                'subtitle' => __( 'make the footer 100%.', 'wpresidence-core' ),
                'options'  => array(
                    'no'    => 'no',
                    'yes'   => 'yes'
                    ),
                'default'  => 'no',
            ),
            
            array(
                'id'       => 'wp_estate_footer_type',
                'type'     => 'button_set',
                'title'    => __( 'Footer Type', 'wpresidence-core' ),
                'subtitle' => __( 'Footer Type', 'wpresidence-core' ),
                'options'  => array(
                    '1'  =>  __('4 equal columns','wpresidence-core'),
                    '2'  =>  __('3 equal columns','wpresidence-core'),
                    '3'  =>  __('2 equal columns','wpresidence-core'),
                    '4'  =>  __('100% width column','wpresidence-core'),
                    '5'  =>  __('3 columns: 1/2 + 1/4 + 1/4','wpresidence-core'),
                    '6'  =>  __('3 columns: 1/4 + 1/2 + 1/4','wpresidence-core'),
                    '7'  =>  __('3 columns: 1/4 + 1/4 + 1/2','wpresidence-core'),
                    '8'  =>  __('2 columns: 2/3 + 1/3','wpresidence-core'),
                    '9'  =>  __('2 columns: 1/3 + 2/3','wpresidence-core'),
                    ),
                'default'  => '1',
            ),

        ),
    ) );
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Price & Currency', 'wpresidence-core' ),
        'id'         => 'price_curency_tab',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wp_estate_prices_th_separator',
                'type'     => 'text',
                'title'    => __( 'Price - thousands separator', 'wpresidence-core' ),
                'subtitle' => __( 'Set the thousand separator for price numbers.', 'wpresidence-core' ),
                'default'  => '.',
            ),
            
            array(
                'id'       => 'wp_estate_currency_symbol',
                'type'     => 'text',
                'title'    => __( 'Currency symbol', 'wpresidence-core' ),
                'subtitle' => __( 'Set currency symbol for property price.', 'wpresidence-core' ),
                'default'  => '$',
            ),
            
            array(
                'id'       => 'wp_estate_currency_label_main',
                'type'     => 'text',
                'title'    => __( 'Currency label - will appear on front end', 'wpresidence-core' ),
                'subtitle' => __( 'Set the currency label for multi-currency widget dropdown.', 'wpresidence-core' ),
                'default'  => 'USD',
            ),
            
            array(
                'id'       => 'wp_estate_where_currency_symbol',
                'type'     => 'button_set',
                'title'    => __( 'Where to show the currency symbol?', 'wpresidence-core' ),
                'subtitle' => __( 'Set the position for the currency symbol.', 'wpresidence-core' ),
                'options'  => array(
                    'before'  => 'before',
                    'after'   => 'after'
                    ),
                'default'  => 'before',
            ),
            
            array(
                'id'       => 'wp_estate_auto_curency',
                'type'     => 'button_set',
                'title'    => __( 'Enable auto loading of exchange rates from free.currencyconverterapi.com (1 time per day)?', 'wpresidence-core' ),
                'subtitle' => __( 'Symbol must be set according to international standards. Complete list is here http://www.xe.com/iso4217.php.', 'wpresidence-core' ),
                'options'  => array(
                    'yes'  => 'yes',
                    'no'   => 'no'
                    ),
                'default'  => 'no',
            ),
            array(
                'id'       => 'wp_estate_currencyconverterapi_api',
                'type'     => 'text',
                'title'    => __( 'Currencyconverterapi.com Api Key', 'wpresidence-core' ),
                'subtitle' => __( 'Get the free api key from here https://free.currencyconverterapi.com/free-api-key', 'wpresidence-core' ),
                'default'  => '',
            ),
            array(
               'id'       => 'wpestate_currency',
               'type'     => 'wpestate_currency',
               'title'    => __( 'Add Currencies for Multi Currency Widget.', 'wpresidence-core' ),
               'class'    => 'class_wpestate_currency',
               'full_width' => true,
             
           ),
    
        ),
    ) );

        
    $default_custom_field       =   array();
    $def_add_field_name         =   array('property year','property garage','property garage size','property date','property basement','property external construction','property roofing');
    $def_add_field_label        =   array('Year Built','Garages','Garage Size','Available from','Basement','external construction','short text');
    $def_add_field_order        =   array(1,2,3,4,5,6,7);
    $def_add_field_type         =   array('date','short text','short text','short text','short text','short text','short text');
    
    $default_custom_field['add_field_name']     =$def_add_field_name;
    $default_custom_field['add_field_label']    =$def_add_field_label;
    $default_custom_field['add_field_order']    =$def_add_field_order;
    $default_custom_field['add_field_type']     =$def_add_field_type;
    
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Custom Fields', 'wpresidence-core' ),
        'id'         => 'custom_fields_tab',
        'subsection' => true,
        'fields'     => array(
            array(
               'id'       => 'wpestate_custom_fields_list',
               'type'     => 'wpestate_custom_fields_list',
               'full_width' => true,
               'title'    => __( 'Add, edit or delete property custom fields.', 'wpresidence-core' ),
              // 'default'  => $default_custom_field
           ),
        ),
    ) );
    
    
    
    $default_feature_list='attic, gas heat, ocean view, wine cellar, basketball court, gym,pound, fireplace, lake view, pool, back yard, front yard, fenced yard, sprinklers, washer and dryer, deck, balcony, laundry, concierge, doorman, private space, storage, recreation, roof deck';
       
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Features & Amenities', 'wpresidence-core' ),
        'id'         => 'ammenities_features_tab',
        'subsection' => true,
        'fields'     => array(
            array(
               'id'       => 'wp_estate_feature_list',
               'type'     => 'wpestate_features',
               'title'    => __( 'Features and Amenities list', 'wpresidence-core' ),
               'default'  => $default_feature_list
           ),
            array(
                'id'       => 'wp_estate_show_no_features',
                'type'     => 'button_set',
                'title'    => __( 'Show the Features and Amenities that are not available', 'wpresidence-core' ),
                'subtitle' => __( 'Show on property page the features and amenities that are not selected?', 'wpresidence-core' ),
                'options'  => array(
                            'yes'  => 'yes',
                            'no'   => 'no'
                    ),
                'default'  => 'yes',
            ),
          
        ),
    ) );
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Listings Labels', 'wpresidence-core' ),
        'id'         => 'listing_labels_tab',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wp_estate_property_multi_text',
                'type'     => 'text',
                'title'    => __( 'Multi Unit Label', 'wpresidence-core' ),
                'subtitle' => __( 'Custom title instead of Multi Unit label.', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_property_multi_child_text',
                'type'     => 'text',
                'title'    => __( 'Multi Unit Label (*for sub unit)', 'wpresidence-core' ),
                'subtitle' => __( 'Custom title instead of Multi Unit label(*for sub unit).', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_property_adr_text',
                'type'     => 'text',
                'title'    => __( 'Property Address Label', 'wpresidence-core' ),
                'subtitle' => __( 'Custom title instead of Property Address label.', 'wpresidence-core' ),
                'default'  => 'Property Address'
            ),
            
            array(
                'id'       => 'wp_estate_property_features_text',
                'type'     => 'text',
                'title'    => __( 'Property Features Label', 'wpresidence-core' ),
                'subtitle' => __( 'Update; Custom title instead of Features and Amenities label.', 'wpresidence-core' ),
                'default'  => 'Property Features'
            ),
 
            array(
                'id'       => 'wp_estate_property_description_text',
                'type'     => 'text',
                'title'    => __( 'Property Description Label', 'wpresidence-core' ),
                'subtitle' => __( 'Custom title instead of Description label.', 'wpresidence-core' ),
                'default'  => 'Property Description'
            ),
            
            array(
                'id'       => 'wp_estate_property_details_text',
                'type'     => 'text',
                'title'    => __( 'Property Details Label', 'wpresidence-core' ),
                'subtitle' => __( 'Custom title instead of Property Details label.', 'wpresidence-core' ),
                'default'  => 'Property Details'
            ),
            
            array(
                'id'       => 'wp_estate_status_list',
                'type'     => 'wpestate_status',
                'title'    => __( 'Property Status', 'wpresidence-core' ),
            ),
             array(
                'id'       => 'wp_estate_property_video_text',
                'type'     => 'text',
                'title'    => __( 'Property Video Label', 'wpresidence-core' ),
                'subtitle' => __( 'The label for video section.', 'wpresidence-core' ),
                'default'  => 'Video'
            ),
 

        ),
    ) );
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Theme Slider', 'wpresidence-core' ),
        'id'         => 'theme_slider_tab',
        'subsection' => true,
        'fields'     => array(
             array(
                'id'       => 'wp_estate_theme_slider',
                'type'     => 'select',
                'multi'    => true,
                'data'  => 'posts',
                            'args'  => array(
                                           'post_type'         =>  'estate_property',
                                            'post_status'       =>  'publish',
                                            'posts_per_page'    =>  50,
                             
                            ),
                'title'    => __( 'Select Properties ', 'wpresidence-core' ),
                'subtitle' => __( 'Select properties for slider - *hold CTRL for multiple select
Due to speed reason we only show here the first 50 listings. If you want to add other listings into the theme slider please go and edit the property (in wordpress admin) and select "Property in theme Slider" in Property Details tab.', 'wpresidence-core' ),
               //'options'  => wpresidence_return_theme_slider_list(),
            ),

            array(
                'id'       => 'wp_estate_slider_cycle',
                'type'     => 'text',
                'title'    => __( 'Number of milisecons before auto cycling an item', 'wpresidence-core' ),
                'subtitle' => __( 'Number of milisecons before auto cycling an item (5000=5sec).Put 0 if you don\'t want to autoslide.', 'wpresidence-core' ),
                'default'  => '5000'
            ),
            
            array(
                'id'       => 'wp_estate_theme_slider_type',
                'type'     => 'button_set',
                'title'    => __( 'Design Type?', 'wpresidence-core' ),
                'subtitle' => __( 'Select the design type.', 'wpresidence-core' ),
                'options'  => array(
                             'type1' => 'type1', 
                             'type2' => 'type2',
                             'type3' => 'type3'
                    ),
                'default'  => 'type1',
            ),
             array(
                'id'       => 'wp_estate_theme_slider_height',
                'type'     => 'text',
                'title'    => __( 'Height in px (put 0 for full screen)', 'wpresidence-core' ),
                'subtitle' => __( 'Height in px(put 0 for full screen, Default :580px)', 'wpresidence-core' ),
                'default'  => '580'
            ),
        ),
    ) );
    
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Property and Agent Links', 'wpresidence-core' ),
        'id'         => 'property_rewrite_page_tab',
        'subsection' => true,
        'fields'     => array(  
            array(
                'id'     => 'opt-info_links',
                'type'   => 'info',
                'notice' => false,
                'title'   => __( 'You cannot use special characters like "&". After changing the url you may need to wait for a few minutes until WordPress changes all the urls. In case your new names do not update automatically, go to Settings - Permalinks and Save again the "Permalinks Settings" - option "Post name"', 'wpresidence-core' )
            ),
            array(
                'id'     => 'wp_estate_url_rewrites',
                'type'   => 'wpestate_custom_url_rewrite',
                'notice' => false,
                'full_width'    => true,
               
            ),
            
        ),
    ) );
    
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Splash Page', 'wpresidence-core' ),
        'id'         => 'splash_page_page_tab',
        'subsection' => true,
        'fields'     => array(  
            array(
                'id'       => 'wp_estate_spash_header_type',
                'type'     => 'select',
                'title'    => __( 'Select the splash page type.', 'wpresidence-core' ),
                'subtitle' => __( 'Important: Create also a page with template "Splash Page" to see how your splash settings apply', 'wpresidence-core' ),
                'options'  => array(
                        'image'       => 'image' , 
                        'video'       => 'video',
                        'image slider' => 'image slider'
                    ),
                'default' =>  'image'
                
            ),
  
            array(
                'id'       => 'wp_estate_splash_slider_gallery',
                'type'     => 'gallery',
                'class'    => 'slider_splash',
                'required' => array('wp_estate_spash_header_type', '=', 'image slider'),
                'title'    => __( 'Slider Images', 'wpresidence-core' ),
                'subtitle' => __( 'Slider Images, .png, .jpg or .gif format', 'wpresidence-core' ),
                
            ), 
            
            array(
                'id'       => 'wp_estate_splash_slider_transition',
                'type'     => 'text',
                'class'    => 'slider_splash',
                'required' => array('wp_estate_spash_header_type', '=', 'image slider'),
                'title'    => __( 'Slider Transition', 'wpresidence-core' ),
                'subtitle' => __( 'Number of milisecons before auto cycling an item (5000=5sec).Put 0 if you don\'t want to autoslide.', 'wpresidence-core' ),
                
            ),

            array(
                'id'       => 'wp_estate_splash_image',
                'type'     => 'media',
                'class'    => 'image_splash',
                'required' => array('wp_estate_spash_header_type', '=', 'image'),
                'title'    => __( 'Splash Image', 'wpresidence-core' ),
                'subtitle' => __( 'Splash Image, .png, .jpg or .gif format', 'wpresidence-core' ),
                
            ),
            
            array(
                'id'       => 'wp_estate_splash_video_mp4',
                'type'     => 'media',
                'class'    => 'video_splash',
                'url'      => true,
                'preview'  => false,
                'mode'     => false,
                'required' => array('wp_estate_spash_header_type', '=', 'video'),
                'title'    => __( 'Splash Video in mp4 format', 'wpresidence-core' ),
                'subtitle' => __( 'Splash Video in mp4 format', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_splash_video_webm',
                'type'     => 'media',
                'class'    => 'video_splash',
                'url'      => true,
                'preview'  => false,
                'mode'     => false,
                'required' => array('wp_estate_spash_header_type', '=', 'video'),
                'title'    => __( 'Splash Video in webm format', 'wpresidence-core' ),
                'subtitle' => __( 'Splash Video in webm format', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_splash_video_ogv',
                'type'     => 'media',
                'class'    => 'video_splash',
                'url'      => true,
                'preview'  => false,
                'mode'     => false,
                'required' => array('wp_estate_spash_header_type', '=', 'video'),
                'title'    => __( 'Splash Video in ogv format', 'wpresidence-core' ),
                'subtitle' => __( 'Splash Video in ogv format', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_splash_video_cover_img',
                'type'     => 'media',
                'class'    => 'video_splash',
                'required' => array('wp_estate_spash_header_type', '=', 'video'),
                'title'    => __( 'Cover Image for video', 'wpresidence-core' ),
                'subtitle' => __( 'Cover Image for videot', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_splash_overlay_image',
                'preview'   =>true,
                'type'     => 'media',
                'title'    => __( 'Overlay Image', 'wpresidence-core' ),
                'subtitle' => __( 'Overlay Image, .png, .jpg or .gif format', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_splash_overlay_color',
                'type'     => 'color',
                'title'    => __( 'Overlay Color', 'wpresidence-core' ),
                'subtitle' => __( 'Overlay Color', 'wpresidence-core' ),
                'transparent' => false,
                
            ),
            
            array(
                'id'       => 'wp_estate_splash_overlay_opacity',
                'type'     => 'text',
                'title'    => __( 'Overlay Opacity', 'wpresidence-core' ),
                'subtitle' => __( 'Overlay Opacity- values from 0 to 1 , Ex: 0.4', 'wpresidence-core' ),
                
            ),
            
            array(
                'id'       => 'wp_estate_splash_page_title',
                'type'     => 'text',
                'title'    => __( 'Splash Page Title', 'wpresidence-core' ),
                'subtitle' => __( 'Splash Page Title', 'wpresidence-core' ),
                
            ),
            
            array(
                'id'       => 'wp_estate_splash_page_subtitle',
                'type'     => 'text',
                'title'    => __( 'Splash Page Subtitle', 'wpresidence-core' ),
                'subtitle' => __( 'Splash Page Subtitle', 'wpresidence-core' ),
                
            ),
            
            array(
                'id'       => 'wp_estate_splash_page_logo_link',
                'type'     => 'text',
                 'preview'  => false,
                'title'    => __( 'Logo Link', 'wpresidence-core' ),
                'subtitle' => __( 'In case you want to send users to another page', 'wpresidence-core' ),
            ),
            
        ),
    ) );
    
    
    //->STRAT Social & Contact
    Redux::setSection( $opt_name, array(
        'title' => __( 'Social & Contact', 'wpresidence-core' ),
        'id'    => 'social_contact_sidebar',
        'icon'  => 'el el-address-book'
    ) );
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Contact Page Details', 'wpresidence-core' ),
        'id'         => 'social_contact_sidebar_tab',
        'subsection' => true,
        'fields'     => array(  
            array(
                'id'       => 'wp_estate_company_contact_image',
                'type'     => 'media',
                'title'    => __( 'Image for Contact Page', 'wpresidence-core' ),
                'subtitle' => __( 'Add the image for the contact page contact area. Minim 350px wide for a nice design.', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_company_name',
                'type'     => 'text',
                 'preview'  => false,
                'title'    => __( 'Company Name', 'wpresidence-core' ),
                'subtitle' => __( 'Company name for contact page', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_email_adr',
                'type'     => 'text',
                 'preview'  => false,
                'title'    => __( 'Email', 'wpresidence-core' ),
                'subtitle' => __( 'Company email', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_duplicate_email_adr',
                'type'     => 'text',
                 'preview'  => false,
                'title'    => __( 'Duplicate Email', 'wpresidence-core' ),
                'subtitle' => __( 'Send all contact emails to', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_telephone_no',
                'type'     => 'text',
                 'preview'  => false,
                'title'    => __( 'Telephone', 'wpresidence-core' ),
                'subtitle' => __( 'Company phone number.', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_mobile_no',
                'type'     => 'text',
                 'preview'  => false,
                'title'    => __( 'Mobile', 'wpresidence-core' ),
                'subtitle' => __( 'Company mobile', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_fax_ac',
                'type'     => 'text',
                 'preview'  => false,
                'title'    => __( 'Fax', 'wpresidence-core' ),
                'subtitle' => __( 'Company fax', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_skype_ac',
                'type'     => 'text',
                 'preview'  => false,
                'title'    => __( 'Skype', 'wpresidence-core' ),
                'subtitle' => __( 'Company skype', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_co_address',
                'type'     => 'text',
                'preview'  => false,
                'title'    => __( 'Company Address', 'wpresidence-core' ),
                'subtitle' => __( 'Type company address', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_hq_latitude',
                'type'     => 'text',
                'preview'  => false,
                'title'    => __( 'Contact Page - Company HQ Latitude', 'wpresidence-core' ),
                'subtitle' => __( 'Set company pin location for contact page template. Latitude must be a number (ex: 40.577906).', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_hq_longitude',
                'type'     => 'text',
                'preview'  => false,
                'title'    => __( 'Contact Page - Company HQ Longitude', 'wpresidence-core' ),
                'subtitle' => __( 'Set company pin location for contact page template. Longitude must be a number (ex: -74.155058).', 'wpresidence-core' ),
            ),
            
        ),
    ) );
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Social Accounts', 'wpresidence-core' ),
        'id'         => 'social_accounts_tab',
        'subsection' => true,
        'fields'     => array(  
            array(
                'id'       => 'wp_estate_facebook_link',
                'type'     => 'text',
                'preview'  => false,
                'title'    => __( 'Facebook Link', 'wpresidence-core' ),
                'subtitle' => __( 'Facebook page url, with https://', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_twitter_link',
                'type'     => 'text',
                'preview'  => false,
                'title'    => __( 'Twitter page link', 'wpresidence-core' ),
                'subtitle' => __( 'Twitter page link, with https://', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_google_link',
                'type'     => 'text',
                'preview'  => false,
                'title'    => __( 'Google+ Link', 'wpresidence-core' ),
                'subtitle' => __( 'Google+ page link, with https://', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_linkedin_link',
                'type'     => 'text',
                'preview'  => false,
                'title'    => __( 'Linkedin Link', 'wpresidence-core' ),
                'subtitle' => __( 'Linkedin Link', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_pinterest_link',
                'type'     => 'text',
                'preview'  => false,
                'title'    => __( 'Pinterest Link', 'wpresidence-core' ),
                'subtitle' => __( 'Pinterest page link, with https://', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_instagram_link',
                'type'     => 'text',
                'preview'  => false,
                'title'    => __( 'Instagram Link', 'wpresidence-core' ),
                'subtitle' => __( 'Instagram page link, with https://', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_zillow_api_key',
                'type'     => 'text',
                'preview'  => false,
                'title'    => __( 'Zillow api key', 'wpresidence-core' ),
                'subtitle' => __( 'Zillow api key is required for Zillow Widget.', 'wpresidence-core' ),
            ),
            
        ),
    ) );
    
    
   Redux::setSection( $opt_name, array(
        'title'      => __( 'Social Login', 'wpresidence-core' ),
        'id'         => 'social_login_tab',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wp_estate_facebook_login',
                'type'     => 'button_set',
                'title'    => __( 'Allow login via Facebook ?', 'wpresidence-core' ),
                'subtitle' => __( 'Allow login via Facebook ?', 'wpresidence-core' ),
                'options'  => array(
                             'no'  => 'no',
                             'yes' => 'yes'
                            ),
                'default'  => 'no',
            ),
            array(
                'id'       => 'wp_estate_facebook_api',
                'required' => array('wp_estate_facebook_login','=','yes'),
                'type'     => 'text',
                'title'    => __( 'Facebook Api key', 'wpresidence-core' ),
                'subtitle' => __( 'Facebook Api key is required for Facebook login. See this help article before: ', 'wpresidence-core' ).'<a href="http://help.wpresidence.net/article/facebook-login/" target="_blank">http://help.wpresidence.net/article/facebook-login/</a>',
            ),
            array(
                'id'       => 'wp_estate_facebook_secret',
                'required' => array('wp_estate_facebook_login','=','yes'),
                'type'     => 'text',
                'title'    => __( 'Facebook Secret', 'wpresidence-core' ),
                'subtitle' => __( 'Facebook Secret is required for Facebook login.', 'wpresidence-core' ),
            ),
            array(
                'id'       => 'wp_estate_google_login',
                'type'     => 'button_set',
                'title'    => __( 'Allow login via Google ?', 'wpresidence-core' ),
                'subtitle' => __( 'Enable or disable Google login.', 'wpresidence-core' ),
                'options'  => array(
                             'no'  => 'no',
                             'yes' => 'yes'
                            ),
                'default'  => 'no',
            ),
            array(
                'id'       => 'wp_estate_google_oauth_api',
                'required' => array('wp_estate_google_login','=','yes'),
                'type'     => 'text',
                'title'    => __( 'Google Oauth Api', 'wpresidence-core' ),
                'subtitle' => __( 'Google Oauth Api is required for Google Login. See this help article before: ', 'wpresidence-core' ).'<a href="http://help.wpresidence.net/article/enable-gmail-google-login/" target="_blank">http://help.wpresidence.net/article/enable-gmail-google-login/</a>',
            ),
            array(
                'id'       => 'wp_estate_google_oauth_client_secret',
                'required' => array('wp_estate_google_login','=','yes'),
                'type'     => 'text',
                'title'    => __( 'Google Oauth Client Secret', 'wpresidence-core' ),
                'subtitle' => __( 'Google Oauth Client Secret is required for Google Login.', 'wpresidence-core' ),
            ),
            array(
                'id'       => 'wp_estate_google_api_key',
                'required' => array('wp_estate_google_login','=','yes'),
                'type'     => 'text',
                'title'    => __( 'Google api key', 'wpresidence-core' ),
                'subtitle' => __( 'Google api key is required for Google Login.', 'wpresidence-core' ),
            ),
           
        ),
    ) );
   
   Redux::setSection( $opt_name, array(
        'title'      => __( 'Contact Form Settings', 'wpresidence-core' ),
        'id'         => 'contact_form_tab',
        'subsection' => true,
        'fields'     => array(  
            array(
                'id'       => 'wp_estate_use_gdpr',
                'type'     => 'button_set',
                'title'    => __( 'Use GDPR Checkbox ?', 'wpresidence-core' ),
                'subtitle' => __( 'Help: ', 'wpresidence-core' ).'<a href ="http://help.wpresidence.net/article/contact-form-settings/">http://help.wpresidence.net/article/contact-form-settings/</a>',
                'options'  => array(
                             'no'  => 'no',
                             'yes' => 'yes'
                            ),
                'default'  => 'no',
            ),
            
        ),
    ) );
    
   
   Redux::setSection( $opt_name, array(
        'title'      => __( 'Contact 7 Settings', 'wpresidence-core' ),
        'id'         => 'contact7_tab',
        'subsection' => true,
        'fields'     => array(  
            array(
                'id'       => 'wp_estate_contact_form_7_agent',
                'type'     => 'text',
                'title'    => __( 'Contact form 7 code for agent', 'wpresidence-core' ),
                'subtitle' => __( 'Contact form 7 code for agent (ex: [contact-form-7 id="2725" title="contact me"])', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_contact_form_7_contact',
                'type'     => 'text',
                'title'    => __( 'Contact form 7 code for contact page', 'wpresidence-core' ),
                'subtitle' => __( 'Contact form 7 code for contact page template (ex: [contact-form-7 id="2725" title="contact me"])', 'wpresidence-core' ),
            ),
            
        ),
    ) );
   
   
   Redux::setSection( $opt_name, array(
        'title'      => __( 'Twitter Login & Widget', 'wpresidence-core' ),
        'id'         => 'twitter_widget_tab',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wp_estate_twiter_login',
                'type'     => 'button_set',
              
                'title'    => __( 'Allow login via Twitter ?', 'wprentals-core' ),
                'subtitle' => __( 'Allow login via Twitter ?(works only over https)', 'wprentals-core' ),
                'options'  => array(
                             'no'  => 'no',
                             'yes' => 'yes'
                            ),
                'default'  => 'no',
            ),
            array(
                'id'       => 'wp_estate_twitter_consumer_key',
                'type'     => 'text',
                'title'    => __( 'Twitter consumer_key.', 'wpresidence-core' ),
                'subtitle' => __( 'Twitter consumer_key is required for theme Twitter widget. See this help article before: ', 'wpresidence-core' ).'<a href="http://help.wpresidence.net/article/wp-estate-twitter-widget/" target="_blank">http://help.wpresidence.net/article/wp-estate-twitter-widget/</a>',
            ),
            array(
                'id'       => 'wp_estate_twitter_consumer_secret',
                'type'     => 'text',
                'title'    => __( 'Twitter Consumer Secret', 'wpresidence-core' ),
                'subtitle' => __( 'Twitter Consumer Secret is required for theme Twitter widget.', 'wpresidence-core' ),
            ),
            array(
                'id'       => 'wp_estate_twitter_access_token',
                'type'     => 'text',
                'title'    => __( 'Twitter Access Token', 'wpresidence-core' ),
                'subtitle' => __( 'Twitter Access Token is required for theme Twitter widget.', 'wpresidence-core' ),
            ),
            array(
                'id'       => 'wp_estate_twitter_access_secret',
                'type'     => 'text',
                'title'    => __( 'Twitter Access Token Secret', 'wpresidence-core' ),
                'subtitle' => __( 'Twitter Access Token Secret is required for theme Twitter widget.', 'wpresidence-core' ),
            ),
            array(
                'id'       => 'wp_estate_twitter_cache_time',
                'type'     => 'text',
                'title'    => __( 'Twitter Cache Time', 'wpresidence-core' ),
                'subtitle' => __( 'Twitter Cache Time', 'wpresidence-core' ),
            ),
            
        ),
    ) );
    
   
    // -> START Map options
    Redux::setSection( $opt_name, array(
        'title' => __( 'Map', 'wpresidence-core' ),
        'id'    => 'map_settings_sidebar',
        'icon'  => 'el el-map-marker'
    ) );
    
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Map Settings', 'wpresidence-core' ),
        'id'         => 'general_map_tab',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wp_estate_kind_of_map',
                'type'     => 'button_set',
                'title'    => __( 'What Map System you want to use?', 'wprentals-core' ),
                'subtitle' => __( 'What map system you want to use', 'wprentals-core' ),
                'options'  => array(
                            2 => 'open street',
                            1  => 'google maps' 
                            ),
                'default'  => 1,
            ),
           array(
                'id'       => 'wp_estate_readsys',
                'type'     => 'button_set',
                'title'    => __( 'Use file reading for pins?', 'wpresidence-core' ),
                'subtitle' => __( 'Use file reading for pins? (*recommended for over 200 listings. Read the manual for diffrences between file and mysql reading)', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes',
                            'no'  => 'no' 
                            ),
                'default'  => 'no',
            ),
            
            array(
                'id'       => 'wp_estate_map_max_pins',
                'type'     => 'text',
                'title'    => __( 'Maximum number of pins to show on the map.', 'wpresidence-core' ),
                'subtitle' => __( 'A high number will increase the response time and server load. Use a number that works for your current hosting situation. Put -1 for all pins.', 'wpresidence-core' ),
                'default'  => '100'
            ),
            
//            array(
//                'id'       => 'wp_estate_ssl_map',
//                'type'     => 'button_set',
//                'title'    => __( 'Use Google maps with SSL ?', 'wpresidence-core' ),
//                'subtitle' => __( 'Set to Yes if you use SSL.', 'wpresidence-core' ),
//                'options'  => array(
//                            'yes' => 'yes',
//                            'no'  => 'no' 
//                            ),
//                'default'  => 'no',
//            ),
//            
            array(
                'id'       => 'wp_estate_api_key',
                'type'     => 'text',
                'title'    => __( 'Google Maps API KEY', 'wpresidence-core' ),
                'subtitle' => __( 'The Google Maps JavaScript API v3 REQUIRES an API key to work. Login in your Google Account, and follow Google Instructions to get the API key from this url: https://developers.google.com/maps/documentation/javascript/tutorial#api_key', 'wpresidence-core' ).'<br>'.__( 'Help: ', 'wpresidence-core' ).'<a href="http://help.wpresidence.net/article/google-api-key/">http://help.wpresidence.net/article/google-api-key/<a/>',
            ),
                 
//             array(
//                'id'       => 'wp_estate_reverse_geolocation',
//                'type'     => 'button_set',
//                'title'    => __( 'What system do you want to use for geolocation?', 'wpresidence-core' ),
//                'subtitle' => __( 'Your option is considered if you activate the option "Enable Autocomplete in Front End Submission Form" from Membership & submit Settings. Google Places is a paid system while Open Street is free. ', 'wpresidence-core' ),
//                'options'  => array(
//                            '1' => 'google places',
//                            '2'  => 'open street' 
//                            ),
//                'default'  => '1',
//            ),
            
            array(
                'id'       => 'wp_estate_mapbox_api_key',
                'type'     => 'text',
                'title'    => __( 'MapBox API KEY -  used for tile server', 'wprentals-core' ),
                'subtitle' => __( 'You can get it from here: https://www.mapbox.com/. If you leave it blank we will use the default openstreet server which can be slow', 'wprentals-core' ),
            ),
            
            
            array(
                'id'       => 'wp_estate_general_latitude',
                'type'     => 'text',
                'title'    => __( 'Starting Point Latitude', 'wpresidence-core' ),
                'subtitle' => __( 'Applies for global header media with google maps. Add only numbers (ex: 40.577906).', 'wpresidence-core' ),
                'default'  => '40.781711'
            ),
            
            array(
                'id'       => 'wp_estate_general_longitude',
                'type'     => 'text',
                'title'    => __( 'Starting Point Longitude', 'wpresidence-core' ),
                'subtitle' => __( 'Applies for global header media with google maps. Add only numbers (ex: -74.155058).', 'wpresidence-core' ),
                'default'  => '-73.955927'
            ),
            
            
            array(
                'id'       => 'wp_estate_default_map_zoom',
                'type'     => 'text',
                'title'    => __( 'Default Map zoom (1 to 20)', 'wpresidence-core' ),
                'subtitle' => __( 'Applies for global header media with google maps, except advanced search results, properties list and taxonomies pages.', 'wpresidence-core' ),
                'default'  => '15'
            ),
            
            array(
                'id'       => 'wp_estate_default_map_type',
                'type'     => 'button_set',
                'title'    => __( 'Map Type', 'wpresidence-core' ),
                'subtitle' => __( 'The type selected applies for Google Maps header. ', 'wpresidence-core' ),
                'options'  => array(
                            'SATELLITE' => 'SATELLITE',
                            'HYBRID'    => 'HYBRID',
                            'TERRAIN'   => 'TERRAIN',
                            'ROADMAP'   => 'ROADMAP'
                            ),
                'default'  => 'ROADMAP',
            ),
            
            array(
                'id'       => 'wp_estate_cache',
                'type'     => 'button_set',
                'title'    => __( 'Use Cache for Google maps ?(*cache will renew itself every 3h)', 'wpresidence-core' ),
                'subtitle' => __( 'If set to yes, new property pins will update on the map every 3 hours.', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes',
                            'no'  => 'no' 
                            ),
                'default'  => 'no',
            ),

            array(
                'id'       => 'wp_estate_pin_cluster',
                'type'     => 'button_set',
                'title'    => __( 'Use Pin Cluster on map', 'wpresidence-core' ),
                'subtitle' => __( 'If yes, it groups nearby pins in cluster.', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes',
                            'no'  => 'no' 
                            ),
                'default'  => 'yes',
            ),
            
            array(
                'id'       => 'wp_estate_zoom_cluster',
                'type'     => 'text',
                'required' => array('wp_estate_pin_cluster', '=', 'yes'),
                'title'    => __( 'Maximum zoom level for Cloud Cluster to appear', 'wpresidence-core' ),
                'subtitle' => __( 'Pin cluster disappears when map zoom is less than the value set in here.', 'wpresidence-core' ),
                'default'  => '10'
            ),
            
            array(
                'id'       => 'wp_estate_idx_enable',
                'type'     => 'button_set',
                'title'    => __( 'Enable dsIDXpress to use the map', 'wpresidence-core' ),
                'subtitle' => __( 'Enable only if you activate the dsIDXpres optional plugin. Works ONLY with Google Maps enabled (not Open Street Map)', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes',
                            'no'  => 'no' 
                            ),
                'default'  => 'no',
            ),
            
            array(
                'id'       => 'wp_estate_geolocation_radius',
                'type'     => 'text',
                'title'    => __( 'Geolocation Circle over map (in meters)', 'wpresidence-core' ),
                'subtitle' => __( 'Controls circle radius value for user geolocation pin. Type only numbers (ex: 400).', 'wpresidence-core' ),
                'default'  => '1000'
            ),
            
            array(
                'id'       => 'wp_estate_min_height',
                'type'     => 'text',
                'title'    => __( 'Height of the Google Map when closed', 'wpresidence-core' ),
                'subtitle' => __( 'Applies for header google maps when set as global header media type.', 'wpresidence-core' ),
                'default'  => '300'
            ),
            
            array(
                'id'       => 'wp_estate_max_height',
                'type'     => 'text',
                'title'    => __( 'Height of Google Map when open', 'wpresidence-core' ),
                'subtitle' => __( 'Applies for header google maps when set as global header media type.', 'wpresidence-core' ),
                'default'  => '450'
            ),  
            
            array(
                'id'       => 'wp_estate_keep_min',
                'type'     => 'button_set',
                'title'    => __( 'Force Google Map at the "closed" size ?', 'wpresidence-core' ),
                'subtitle' => __( 'Applies for header google maps when set as global header media type, except property page.', 'wpresidence-core' ),
                'options'  => array(
                            'no'  => 'no', 
                            'yes' => 'yes'
                            ),
                'default'  => 'no',
            ),
            
            array(
                'id'       => 'wp_estate_keep_max',
                'type'     => 'button_set',
                'title'    => __( 'Force Google Map at the full screen size ?', 'wpresidence-core' ),
                'subtitle' => __( 'Applies for header google maps when set as global header media type, except property page.', 'wpresidence-core' ),
                'options'  => array(
                            'no'  => 'no', 
                            'yes' => 'yes'
                            ),
                'default'  => 'no',
            ),         
            
            array(
                'id'       => 'wp_estate_show_g_search',
                'type'     => 'button_set',
                'title'    => __( 'Show Google Search over Map?', 'wpresidence-core' ),
                'subtitle' => __( 'Enable or disable the Google Maps search bar.', 'wpresidence-core' ),
                'options'  => array(
                            'no'  => 'no', 
                            'yes' => 'yes'
                            ),
                'default'  => 'no',
            ),

            array(
                'id'       => 'wp_estate_map_style',
                'type'     => 'textarea',
                'title'    => __( 'Style for Google Map. Use <strong> https://snazzymaps.com/ </strong> to create styles', 'wpresidence-core' ),
                'subtitle' => __( 'Copy/paste below the custom map style code.', 'wpresidence-core' ),
                'full_width' => true,
            ),
        ),
    ) );
    
    
    $pin_fields=array(); 
     
    $pin_fields[]=array(
                'id'       => 'wp_estate_use_price_pins',
                'type'     => 'button_set',
                'title'    => __( 'Use price Pins ?', 'wpresidence-core' ),
                'subtitle' => __( 'Use price Pins ?(The css class for price pins is "wpestate_marker" . Each pin has also receive a class with the name of the category or action: For example "wpestate_marker apartments sales")', 'wpresidence-core' ),
                'options'  => array(
                            'no'  => 'no', 
                            'yes' => 'yes'
                            ),
                'default'  => 'no',
            );
    
    $pin_fields[]=array(
                'id'       => 'wp_estate_use_price_pins_full_price',
                'type'     => 'button_set',
                'title'    => __( 'Use Full Price Pins ?', 'wpresidence-core' ),
                'subtitle' => __( 'If not we will show prices without before and after label and in this format : 5,23m or 6.83k', 'wpresidence-core' ),
                'options'  =>  array(
                            'no'  => 'no', 
                            'yes' => 'yes'
                            ),
                'default'  => 'no',
            );
    
    $pin_fields[]=array(
                'id'       => 'wp_estate_use_single_image_pin',
                'type'     => 'button_set',
                'title'    => __( 'Use single Image Pin ?', 'wpresidence-core' ),
                'subtitle' => __( 'We will use 1 single pins for all markers. This option will decrease the loading time on you maps.', 'wpresidence-core' ),
                'options'  =>  array(
                            'no'  => 'no', 
                            'yes' => 'yes'
                            ),
                'default'  => 'no',
            );
    
     
     $pin_fields = wpresidence_core_add_pins_icons(  $pin_fields );
   
    
    Redux::setSection( $opt_name, array(
        'title'      =>     __( 'Pin Management', 'wpresidence-core' ),
        'id'         =>     'pin_management_tab',
        'class'      =>     'wpresidence-core_pin_fields',
        'desc'       =>     __( 'Add new Google Maps pins for single actions / single categories.'
                . '</br>For speed reason, you MUST add pins if you change categories and actions names. '
                . '</br>The Pins retina version must be uploaded at the same time (same folder) as the original pin, and with the same name and an additional _2x at the end. Help here: ', 'wpresidence-core' ) . '<a href="http://help.wpresidence.net/article/wpresidence-options-pin-management/" target="_blank">http://help.wpresidence.net/article/wpresidence-options-pin-management/</a>',
        'subsection' => true,
        'fields'     => $pin_fields,
    ) );
    
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Generate Data & Pins', 'wpresidence-core' ),
        'id'         => 'generare_pins_tab',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wp_estate_generate_pins',
                'type'     => 'wpestate_generate_pins',    
                'full_width'    => true,
                'title'    => __( 'Generate Pins and Autocomplete data', 'wpresidence-core' ),
                //'subtitle' => __( 'Click "Save Changes" to generate file with map pins for the read from file map option set to YES.', 'wpresidence-core' ),
            ), 
        ),
    ) );
   
    // -> START Design Selection
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Design', 'wpresidence-core' ),
        'id'         => 'design_settings_sidebar',
        'icon'  => 'el el-brush'
    ) );
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'General Design Settings', 'wpresidence-core' ),
        'id'         => 'general_design_settings_tab',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wp_estate_main_grid_content_width',
                'type'     => 'text',
                'title'    => __( 'Main Grid Width in px', 'wpresidence-core' ),
                'subtitle' => __( 'This option defines the main content width. Default value is 1200px', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_main_content_width',
                'type'     => 'text',
                'title'    => __( 'Content Width (In Percent)', 'wpresidence-core' ),
                'subtitle' => __( 'Using this option you can define the width of the content in percent.Sidebar will occupy the rest of the main content space.', 'wpresidence-core' ),
            ), 
            
            array(
                'id'       => 'wp_estate_contentarea_internal_padding_top',
                'type'     => 'text',
                'title'    => __( 'Content Area Internal Padding Top', 'wpresidence-core' ),
                'subtitle' => __( 'Content Area Internal Padding Top', 'wpresidence-core' ),
            ), 
            
            array(
                'id'       => 'wp_estate_contentarea_internal_padding_left',
                'type'     => 'text',
                'title'    => __( 'Content Area Internal Padding Left', 'wpresidence-core' ),
                'subtitle' => __( 'Content Area Internal Padding Left', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_contentarea_internal_padding_bottom',
                'type'     => 'text',
                'title'    => __( 'Content Area Internal Padding Bottom', 'wpresidence-core' ),
                'subtitle' => __( 'Content Area Internal Padding Bottom', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_contentarea_internal_padding_right',
                'type'     => 'text',
                'title'    => __( 'Content Area Internal Padding Right', 'wpresidence-core' ),
                'subtitle' => __( 'Content Area Internal Padding Right', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_content_area_back_color',
                'type'     => 'color',
                'title'    => __( 'Content Area Background Color', 'wpresidence-core' ),
                'subtitle' => __( 'Content Area Background Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
            
            array(
                'id'       => 'wp_estate_show_breadcrumbs',
                'type'     => 'button_set',
                'title'    => __( 'Show Breadcrumbs', 'wpresidence-core' ),
                'subtitle' => __( 'Show Breadcrumbs', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes', 
                            'no'  => 'no'
                            ),
                'default'  => 'yes',
            ),
            
            array(
                'id'       => 'wp_estate_border_radius_corner',
                'type'     => 'text',
                'title'    => __( 'Border Corner Radius', 'wpresidence-core' ),
                'subtitle' => __( 'Border Corner Radius for unit elements, like property unit, agent unit or blog unit etc', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_cssbox_shadow',
                'type'     => 'text',
                'title'    => __( 'Box Shadow on elements like property unit', 'wpresidence-core' ),
                'subtitle' => __( 'Box Shadow on elements like property unit. Type none for no shadow or put the css values like  0px 2px 0px 0px rgba(227, 228, 231, 1).', 'wpresidence-core' ),
            ),
                        
        ),
    ) );
    
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Property Page Settings', 'wpresidence-core' ),
        'id'         => 'property_page_tab',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wp_estate_global_property_page_template',
                'type'     => 'select',
                'title'    => __( 'Use a custom property page template', 'wpresidence-core' ),
                'subtitle' => __( 'Pick a custom property page template you made.', 'wpresidence-core' ),
                'options'  => wpestate_property_page_template_function()
            ),
            array(
                'id'       => 'wp_estate_elementor_id',
                'type'     => 'text',
                'title'    => __( 'Elementor Only -  ID for sample property', 'wpresidence-core' ),
                'subtitle' => __( 'We will use this property data as sample info for Eliminator Preview for all properties. If blank we will use the data from the last property published.', 'wpresidence-core' ),
              
               
            ),
            array(
                'id'       => 'wp_estate_property_sidebar',
                'type'     => 'button_set',
                'title'    => __( 'Property Sidebar Position', 'wpresidence-core' ),
                'subtitle' => __( 'Where to show the sidebar in property page.', 'wpresidence-core' ),
                'options'  => array(
                    'no sidebar' =>  __( 'no sidebar','wpresidence-core'),
                    'right'      =>  __( 'right','wpresidence-core'),
                    'left'       =>  __( 'left','wpresidence-core')
                    ),
                'default'  => 'right',
            ),

            array(
                'id'       => 'wp_estate_property_sidebar_name',
                'type'     => 'select',
                'title'    => __( 'Property page Sidebar', 'wpresidence-core' ),
                'subtitle' => __( 'What sidebar to show in property page.', 'wpresidence-core' ),
                'data'  =>  'sidebars',
                'default'  => 'primary-widget-area'   
            ),
            
            array(
                'id'       => 'wp_estate_global_property_page_agent_sidebar',
                'type'     => 'button_set',
                'title'    => __( 'Add Agent on Sidebar', 'wpresidence-core' ),
                'subtitle' => __( 'Show agent and contact form on sidebar.', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes', 
                            'no'  => 'no'
                            ),
                'default'  => 'no',
            ),
            
            array(
                'id'       => 'wp_estate_global_prpg_slider_type',
                'type'     => 'button_set',
                'title'    => __( 'Slider Type', 'wpresidence-core' ),
                'subtitle' => __( 'What property slider type to show on property page.', 'wpresidence-core' ),
                'options'  => array(
                            'vertical'           => 'vertical', 
                            'horizontal'         => 'horizontal',
                            'full width header'  => 'full width header', 
                            'gallery'            => 'gallery',
                            'multi image slider' => 'multi image slider'
                            ),
                'default'  => 'horizontal',
            ),
            
            array(
                'id'       => 'wp_estate_global_prpg_content_type',
                'type'     => 'button_set',
                'title'    => __( 'Show Content as', 'wpresidence-core' ),
                'subtitle' => __( 'Select tabs or accordion style for property info.', 'wpresidence-core' ),
                'options'  => array(
                            'accordion' => 'accordion', 
                            'tabs'      => 'tabs'
                            ),
                'default'  => 'accordion',
            ),
            
            array(
                'id'       => 'wp_estate_walkscore_api',
                'type'     => 'text',
                'title'    => __( 'Walkscore APi Key', 'wpresidence-core' ),
                'subtitle' => __( 'Walkscore info doesn\'t show if you don\'t add the API.', 'wpresidence-core' ),
            ),
                  
            array(
                'id'       => 'wp_estate_show_graph_prop_page',
                'type'     => 'button_set',
                'title'    => __( 'Show Graph on Property Page', 'wpresidence-core' ),
                'subtitle' => __( 'Enable or disable the display of number of view by day graphic.', 'wpresidence-core' ),
                'options'  => array(
                            'no'  => 'no', 
                            'yes' => 'yes'
                            ),
                'default'  => 'no',
            ),
            
            array(
                'id'       => 'wp_estate_show_reviews_prop',
                'type'     => 'button_set',
                'title'    => __( 'Show Reviews on Property Page', 'wpresidence-core' ),
                'subtitle' => __( 'Show Reviews on Property Page.', 'wpresidence-core' ),
                'options'  => array(
                            'no'  => 'no', 
                            'yes' => 'yes'
                            ),
                'default'  => 'yes',
            ),
            
            array(
                'id'       => 'wp_estate_enable_direct_mess',
                'type'     => 'button_set',
                'title'    => __( 'Enable Direct Message', 'wpresidence-core' ),
                'subtitle' => __( 'If set to no you will need to delete Inbox page template.', 'wpresidence-core' ),
                'options'  => array(
                            'no'  => 'no', 
                            'yes' => 'yes'
                            ),
                'default'  => 'no',
            ),
            
            array(
                'id'       => 'wp_estate_show_lightbox_contact',
                'type'     => 'button_set',
                'title'    => __( 'Show Contact Form on lightbox', 'wpresidence-core' ),
                'subtitle' => __( 'Enable or disable the contact form on lightbox.', 'wpresidence-core' ),
                'options'  => array(
                            'no'  => 'no', 
                            'yes' => 'yes'
                            ),
                'default'  => 'no',
            ),
            
            array(
                'id'       => 'wp_estate_crop_images_lightbox',
                'type'     => 'button_set',
                'title'    => __( 'Crop Images on lightbox', 'wpresidence-core' ),
                'subtitle' => __( 'Images will have the same size. If set to no you will need to make sure that images are about the same size', 'wpresidence-core' ),
                'options'  => array(
                            'no'  => 'no', 
                            'yes' => 'yes'
                            ),
                'default'  => 'no',
            ),   
        ),
    ) );
    
    
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Print Page Design', 'wpresidence-core' ),
        'id'         => 'print_page_tab',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wp_estate_print_show_subunits',
                'type'     => 'button_set',
                'title'    => __( 'Show subunits section', 'wpresidence-core' ),
                'subtitle' => __( 'Show subunits section in print page?', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes', 
                            'no'  => 'no'
                            ),
                'default'  => 'yes',
            ),
            
            array(
                'id'       => 'wp_estate_print_show_agent',
                'type'     => 'button_set',
                'title'    => __( 'Show agent details section', 'wpresidence-core' ),
                'subtitle' => __( 'Show agent details section in print page?', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes', 
                            'no'  => 'no'
                            ),
                'default'  => 'yes',
            ),
            
            array(
                'id'       => 'wp_estate_print_show_description',
                'type'     => 'button_set',
                'title'    => __( 'Show description section', 'wpresidence-core' ),
                'subtitle' => __( 'Show description section in print page?', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes', 
                            'no'  => 'no'
                            ),
                'default'  => 'yes',
            ),
            
            array(
                'id'       => 'wp_estate_print_show_adress',
                'type'     => 'button_set',
                'title'    => __( 'Show address section', 'wpresidence-core' ),
                'subtitle' => __( 'Show address section in print page?', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes', 
                            'no'  => 'no'
                            ),
                'default'  => 'yes',
            ),
   
            array(
                'id'       => 'wp_estate_print_show_details',
                'type'     => 'button_set',
                'title'    => __( 'Show details section', 'wpresidence-core' ),
                'subtitle' => __( 'Show details section in print page?', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes', 
                            'no'  => 'no'
                            ),
                'default'  => 'yes',
            ),
            
            array(
                'id'       => 'wp_estate_print_show_features',
                'type'     => 'button_set',
                'title'    => __( 'Show features & amenities section', 'wpresidence-core' ),
                'subtitle' => __( 'Show features & amenities section in print page?', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes', 
                            'no'  => 'no'
                            ),
                'default'  => 'yes',
            ),
            
            array(
                'id'       => 'wp_estate_print_show_floor_plans',
                'type'     => 'button_set',
                'title'    => __( 'Show floor plans section', 'wpresidence-core' ),
                'subtitle' => __( 'Show floor plans section in print page?', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes', 
                            'no'  => 'no'
                            ),
                'default'  => 'yes',
            ),
            
            array(
                'id'       => 'wp_estate_print_show_images',
                'type'     => 'button_set',
                'title'    => __( 'Show gallery section', 'wpresidence-core' ),
                'subtitle' => __( 'Show gallery section in print page?', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes', 
                            'no'  => 'no'
                            ),
                'default'  => 'yes',
            ),
            
        ),
    ) );
    
    
    Redux::setSection( $opt_name, array(
    'title'      => __( 'Custom Colors Settings', 'wpresidence-core' ),
    'id'         => 'custom_colors_tab',
    'desc'       => __( '***Please understand that we cannot add here color controls for all theme elements & details. Doing that will result in a overcrowded and useless interface. These small details need to be addressed via custom css code', 'wpresidence-core' ),
    'subsection' => true,
    'fields'     => array(
            array(
                'id'       => 'wp_estate_main_color',
                'type'     => 'color',
                'title'    => __( 'Main Color', 'wpresidence-core' ),
                'subtitle' => __( 'Main Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_second_color',
                'type'     => 'color',
                'title'    => __( 'Second Color', 'wpresidence-core' ),
                'subtitle' => __( 'Second Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_background_color',
                'type'     => 'color',
                'title'    => __( 'Background Color', 'wpresidence-core' ),
                'subtitle' => __( 'Background Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_content_back_color',
                'type'     => 'color',
                'title'    => __( 'Content Background Color', 'wpresidence-core' ),
                'subtitle' => __( 'Content Background Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_breadcrumbs_font_color',
                'type'     => 'color',
                'title'    => __( 'Breadcrumbs, Meta and Second Line Font Color', 'wpresidence-core' ),
                'subtitle' => __( 'Breadcrumbs, Meta and Second Line Font Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_font_color',
                'type'     => 'color',
                'title'    => __( 'Font Color', 'wpresidence-core' ),
                'subtitle' => __( 'Font Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_link_color',
                'type'     => 'color',
                'title'    => __( 'Link Color', 'wpresidence-core' ),
                'subtitle' => __( 'Link Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_headings_color',
                'type'     => 'color',
                'title'    => __( 'Headings Color', 'wpresidence-core' ),
                'subtitle' => __( 'Headings Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
            
            array(
                'id'       => 'wp_estate_footer_back_color',
                'type'     => 'color',
                'title'    => __( 'Footer Background Color', 'wpresidence-core' ),
                'subtitle' => __( 'Footer Background Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_footer_font_color',
                'type'     => 'color',
                'title'    => __( 'Footer Font Color', 'wpresidence-core' ),
                'subtitle' => __( 'Footer Font Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
            
            array(
                'id'       => 'wp_estate_footer_heading_color',
                'type'     => 'color',
                'title'    => __( 'Footer Heading Font Color', 'wpresidence-core' ),
                'subtitle' => __( 'Footer Heading Font Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
            
        array(
                'id'       => 'wp_estate_footer_copy_color',
                'type'     => 'color',
                'title'    => __( 'Footer Copyright Font Color', 'wpresidence-core' ),
                'subtitle' => __( 'Footer Copyright Font Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_footer_copy_back_color',
                'type'     => 'color',
                'title'    => __( 'Footer Copyright Area Background Font Color', 'wpresidence-core' ),
                'subtitle' => __( 'Footer Copyright Area Background Font Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_box_content_back_color',
                'type'     => 'color',
                'title'    => __( 'Boxed Content Background Color', 'wpresidence-core' ),
                'subtitle' => __( 'Boxed Content Background Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_box_content_border_color',
                'type'     => 'color',
                'title'    => __( 'Border Color', 'wpresidence-core' ),
                'subtitle' => __( 'Border Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_hover_button_color',
                'type'     => 'color',
                'title'    => __( 'Hover Button Color', 'wpresidence-core' ),
                'subtitle' => __( 'Hover Button Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_map_controls_back',
                'type'     => 'color',
                'title'    => __( 'Map Controls Background Color', 'wpresidence-core' ),
                'subtitle' => __( 'Map Controls Background Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_map_controls_font_color',
                'type'     => 'color',
                'title'    => __( 'Map Controls Font Color', 'wpresidence-core' ),
                'subtitle' => __( 'Map Controls Font Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),

        ),
    ) );
    
    
    Redux::setSection( $opt_name, array(
    'title'      => __( 'Header Design & Colors', 'wpresidence-core' ),
    'id'         => 'mainmenu_design_elements_tab',
    'subsection' => true,
    'fields'     => array(    
            array(
                'id'       => 'wp_estate_header_height',
                'type'     => 'text',
                'title'    => __( 'Header Height', 'wpresidence-core' ),
                'subtitle' => __( 'Header Height in px', 'wpresidence-core' ),
            ),
        
            array(
                'id'       => 'wp_estate_sticky_header_height',
                'type'     => 'text',
                'title'    => __( 'Sticky Header Height', 'wpresidence-core' ),
                'subtitle' => __( 'Sticky Header Height in px', 'wpresidence-core' ),
            ),
        
            array(
                'id'       => 'wp_estate_top_menu_font_size',
                'type'     => 'text',
                'title'    => __( 'Top Menu Font Size', 'wpresidence-core' ),
                'subtitle' => __( 'Top Menu Font Size', 'wpresidence-core' ),
            ),
        
            array(
                'id'       => 'wp_estate_menu_item_font_size',
                'type'     => 'text',
                'title'    => __( 'Menu Item Font Size', 'wpresidence-core' ),
                'subtitle' => __( 'Menu Item Font Size', 'wpresidence-core' ),
            ),
        
            array(
                'id'       => 'wp_estate_border_bottom_header',
                'type'     => 'text',
                'title'    => __( 'Border Bottom Header Height', 'wpresidence-core' ),
                'subtitle' => __( 'Border Bottom Header Height in px', 'wpresidence-core' ),
            ),
        
            array(
                'id'       => 'wp_estate_sticky_border_bottom_header',
                'type'     => 'text',
                'title'    => __( 'Border Bottom Sticky Header Height', 'wpresidence-core' ),
                'subtitle' => __( 'Border Bottom Sticky Header Height in px', 'wpresidence-core' ),
            ),
        
            array(
                'id'       => 'wp_estate_border_bottom_header_color',
                'type'     => 'color',
                'title'    => __( 'Header Border Bottom Color', 'wpresidence-core' ),
                'subtitle' => __( 'Header Border Bottom Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_border_bottom_header_sticky_color',
                'type'     => 'color',
                'title'    => __( 'Sticky Header Border Bottom Color', 'wpresidence-core' ),
                'subtitle' => __( 'Sticky Header Border Bottom Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_top_bar_back',
                'type'     => 'color',
                'title'    => __( 'Top Bar Background Color (Header Widget Menu)', 'wpresidence-core' ),
                'subtitle' => __( 'Top Bar Background Color (Header Widget Menu)', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_top_bar_font',
                'type'     => 'color',
                'title'    => __( 'Top Bar Font Color (Header Widget Menu)', 'wpresidence-core' ),
                'subtitle' => __( 'Top Bar Font Color (Header Widget Menu)', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_header_color',
                'type'     => 'color',
                'title'    => __( 'Top Menu & Sticky Menu Background Color', 'wpresidence-core' ),
                'subtitle' => __( 'For Menu Area when Header type 5 applies main color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_sticky_menu_font_color',
                'type'     => 'color',
                'title'    => __( 'Sticky Menu Font Color', 'wpresidence-core' ),
                'subtitle' => __( 'Sticky Menu Font Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_menu_font_color',
                'type'     => 'color',
                'title'    => __( 'Top Menu Font Color', 'wpresidence-core' ),
                'subtitle' => __( 'Top Menu Font Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_top_menu_hover_font_color',
                'type'     => 'color',
                'title'    => __( 'Top Menu Hover Font Color', 'wpresidence-core' ),
                'subtitle' => __( 'Top Menu Hover Font Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_active_menu_font_color',
                'type'     => 'color',
                'title'    => __( 'Active Menu Font Color', 'wpresidence-core' ),
                'subtitle' => __( 'Active Menu Font Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
            
            array(
                'id'       => 'wp_estate_top_menu_hover_back_font_color',
                'type'     => 'color',
                'title'    => __( 'Top Menu Hover Background Color', 'wpresidence-core' ),
                'subtitle' => __( 'Top Menu Hover Background Color (*applies on some hover types)', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'     => 'opt-info_hover_type',
                'type'   => 'media',
                'class'  => 'header_design',
                'url'    => false,
                'title'     => '',
                'compiler'  => 'false',
                'subtitle'  => '',
                'full_width'    => true,
                'default'   => array('url' => WPESTATE_PLUGIN_DIR_URL.'img/menu_types.png'),
//             /   'desc'   => ' <img  style="border:1px solid #FFE7E7;margin-bottom:10px;" src="'.WPESTATE_PLUGIN_DIR_URL.'img/menu_types.png" alt="logo"/>'
            ),
        
            array(
                'id'       => 'wp_estate_top_menu_hover_type',
                'type'     => 'button_set',
                'title'    => __( 'Top Menu Hover Type', 'wpresidence-core' ),
                'subtitle' => __( 'For Hover Type 1, 2, 5, 6 - setup Top Menu Hover Font Color option', 'wpresidence-core' ).'</br>'.__('For Hover Type 3, 4 - setup Top Menu Hover Background Color option','wpresidence-core'),
                'options'  =>   array(
                            '1'=>'1',
                            '2'=>'2',
                            '3'=>'3',
                            '4'=>'4',
                            '5'=>'5',
                            '6'=>'6'),
                'default'  => '1',
            ),
        
            array(
                'id'       => 'wp_estate_transparent_menu_font_color',
                'type'     => 'color',
                'title'    => __( 'Transparent Header - Top Menu Font Color', 'wpresidence-core' ),
                'subtitle' => __( 'Transparent Header - Top Menu Font Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_transparent_menu_hover_font_color',
                'type'     => 'color',
                'title'    => __( 'Transparent Header - Top Menu Hover Font Color', 'wpresidence-core' ),
                'subtitle' => __( 'Transparent Header - Top Menu Hover Font Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_menu_items_color',
                'type'     => 'color',
                'title'    => __( 'Menu Item Color', 'wpresidence-core' ),
                'subtitle' => __( 'Menu Item Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_menu_hover_font_color',
                'type'     => 'color',
                'title'    => __( 'Menu Item hover font color', 'wpresidence-core' ),
                'subtitle' => __( 'Menu Item hover font color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_menu_item_back_color',
                'type'     => 'color',
                'title'    => __( 'Menu Item Back Color', 'wpresidence-core' ),
                'subtitle' => __( 'Menu Item Back Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_menu_hover_back_color',
                'type'     => 'color',
                'title'    => __( 'Menu Item Hover Back Color', 'wpresidence-core' ),
                'subtitle' => __( 'Menu Item Hover Back Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_menu_border_color',
                'type'     => 'color',
                'title'    => __( 'Menu border color', 'wpresidence-core' ),
                'subtitle' => __( 'Menu border color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        ),
    ) );
    
    
    Redux::setSection( $opt_name, array(
    'title'      => __( 'Mobile Menu Colors', 'wpresidence-core' ),
    'id'         => 'mobile_design_elements_tab',
    'subsection' => true,
    'fields'     => array(    
            array(
                'id'       => 'wp_estate_mobile_header_background_color',
                'type'     => 'color',
                'title'    => __( 'Mobile header background color', 'wpresidence-core' ),
                'subtitle' => __( 'Mobile header background color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_mobile_header_icon_color',
                'type'     => 'color',
                'title'    => __( 'Mobile header icon color', 'wpresidence-core' ),
                'subtitle' => __( 'Mobile header icon color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_mobile_menu_font_color',
                'type'     => 'color',
                'title'    => __( 'Mobile menu font color', 'wpresidence-core' ),
                'subtitle' => __( 'Mobile menu font color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_mobile_menu_hover_font_color',
                'type'     => 'color',
                'title'    => __( 'Mobile menu hover font color', 'wpresidence-core' ),
                'subtitle' => __( 'Mobile menu hover font color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_mobile_item_hover_back_color',
                'type'     => 'color',
                'title'    => __( 'Mobile menu item hover background color', 'wpresidence-core' ),
                'subtitle' => __( 'Mobile menu item hover background color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_mobile_menu_backgound_color',
                'type'     => 'color',
                'title'    => __( 'Mobile menu background color', 'wpresidence-core' ),
                'subtitle' => __( 'Mobile menu background color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_mobile_menu_border_color',
                'type'     => 'color',
                'title'    => __( 'Mobile menu item border color', 'wpresidence-core' ),
                'subtitle' => __( 'Mobile menu item border color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
           ),
    ) );
    
    
    Redux::setSection( $opt_name, array(
    'title'      => __( 'Property, Agent, Blog Lists Design', 'wpresidence-core' ),
    'id'         => 'property_list_design_tab',
    'subsection' => true,
    'fields'     => array(    
            array(
                'id'       => 'wp_estate_unit_card_type',
                'type'     => 'button_set',
                'title'    => __( 'Unit Card Type', 'wpresidence-core' ),
                'subtitle' => __( 'Unit Card Type', 'wpresidence-core' ),
                'options'  => array(
                                '0' =>__('default','wpresidence-core'),
                                '1' =>__('type 1','wpresidence-core'), 
                                '2' =>__('type 2','wpresidence-core'),
                                '3' =>__('type 3','wpresidence-core'), 
                                '4' =>__('type 4','wpresidence-core'),
                            ),
                'default'  => '0',
            ),
        
            array(
                'id'       => 'wp_estate_listings_per_row',
                'type'     => 'button_set',
                'title'    => __( 'No of property listings per row when the page is without sidebar', 'wpresidence-core' ),
                'subtitle' => __( 'When the page is with sidebar the no of listings per row will be 2 or 3 - depending on your selection', 'wpresidence-core' ),
                'options'  => array(
                                '3' => '3',
                                '4' => '4'                 
                            ),
                'default'  => '4',
            ),
        
            array(
                'id'       => 'wp_estate_agent_listings_per_row',
                'type'     => 'button_set',
                'title'    => __( 'No of agent listings per row when the page is without sidebar', 'wpresidence-core' ),
                'subtitle' => __( 'When the page is with sidebar the no of listings per row will be 2 or 3 - depending on your selection', 'wpresidence-core' ),
                'options'  => array(
                                '3' => '3',
                                '4' => '4'                 
                            ),
                'default'  => '4',
            ),
            
            array(
                'id'       => 'wp_estate_blog_listings_per_row',
                'type'     => 'button_set',
                'title'    => __( 'No of blog listings per row when the page is without sidebar', 'wpresidence-core' ),
                'subtitle' => __( 'When the page is with sidebar the no of listings per row will be 2 or 3 - depending on your selection', 'wpresidence-core' ),
                'options'  => array(
                                '3' => '3',
                                '4' => '4'                 
                            ),
                'default'  => '4',
            ),
        
            array(
                'id'       => 'wp_estate_prop_unit_min_height',
                'type'     => 'text',
                'title'    => __( 'Property Unit/Card min height', 'wpresidence-core' ),
                'subtitle' => __( 'Property Unit/Card min height', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_agent_unit_min_height',
                'type'     => 'text',
                'title'    => __( 'Agent Unit/Card min height', 'wpresidence-core' ),
                'subtitle' => __( 'Agent Unit/Card min height(works on agent lists and agent taxonomy)', 'wpresidence-core' ),
            ),
        
            array(
                'id'       => 'wp_estate_blog_unit_min_height',
                'type'     => 'text',
                'title'    => __( 'Blog Unit/Card min height', 'wpresidence-core' ),
                'subtitle' => __( 'Blog Unit/Card min height', 'wpresidence-core' ),
            ),
        
            array(
                'id'       => 'wp_estate_propertyunit_internal_padding_top',
                'type'     => 'text',
                'title'    => __( 'Property,Agent and Blog Unit/Card Internal Padding Top', 'wpresidence-core' ),
                'subtitle' => __( 'Property,Agent and Blog Unit/Card Internal Padding Top', 'wpresidence-core' ),
            ),
        
            array(
                'id'       => 'wp_estate_propertyunit_internal_padding_left',
                'type'     => 'text',
                'title'    => __( 'Property,Agent and Blog Unit/Card Internal Padding Left', 'wpresidence-core' ),
                'subtitle' => __( 'Property,Agent and Blog Unit/Card Internal Padding Left', 'wpresidence-core' ),
            ),
        
            array(
                'id'       => 'wp_estate_propertyunit_internal_padding_bottom',
                'type'     => 'text',
                'title'    => __( 'Property,Agent and Blog Unit/Card Internal Padding Bottom', 'wpresidence-core' ),
                'subtitle' => __( 'Property,Agent and Blog Unit/Card Internal Padding Bottom', 'wpresidence-core' ),
            ),
        
            array(
                'id'       => 'wp_estate_propertyunit_internal_padding_right',
                'type'     => 'text',
                'title'    => __( 'Property,Agent and Blog Unit/Card Internal Padding Right', 'wpresidence-core' ),
                'subtitle' => __( 'Property,Agent and Blog Unit/Card Internal Padding Right', 'wpresidence-core' ),
            ),
        
            array(
                'id'       => 'wp_estate_property_unit_color',
                'type'     => 'color',
                'title'    => __( 'Property,Agent and Blog Unit/Card Backgrond Color', 'wpresidence-core' ),
                'subtitle' => __( 'Property,Agent and Blog Unit/Card Backgrond Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
            
            array(
                'id'       => 'wp_estate_unit_border_size',
                'type'     => 'text',
                'title'    => __( 'Unit border size', 'wpresidence-core' ),
                'subtitle' => __( 'Unit border size', 'wpresidence-core' ),
            ),
        
            array(
                'id'       => 'wp_estate_unit_border_color',
                'type'     => 'color',
                'title'    => __( 'Unit/Card border color', 'wpresidence-core' ),
                'subtitle' => __( 'Unit/Card border color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            ),
    ) );
    
    Redux::setSection( $opt_name, array(
    'title'      => __( 'Sidebar Widget Design', 'wpresidence-core' ),
    'id'         => 'widget_design_elements_tab',
    'subsection' => true,
    'fields'     => array( 
            array(
                'id'       => 'wp_estate_sidebarwidget_internal_padding_top',
                'type'     => 'text',
                'title'    => __( 'Widget Internal Padding - Top', 'wpresidence-core' ),
                'subtitle' => __( 'Widget Internal Padding - Top', 'wpresidence-core' ),
            ),
        
            array(
                'id'       => 'wp_estate_sidebarwidget_internal_padding_left',
                'type'     => 'text',
                'title'    => __( 'Widget Internal Padding - Left', 'wpresidence-core' ),
                'subtitle' => __( 'Widget Internal Padding - Left', 'wpresidence-core' ),
            ),
        
            array(
                'id'       => 'wp_estate_sidebarwidget_internal_padding_bottom',
                'type'     => 'text',
                'title'    => __( 'Widget Internal Padding - Bottom', 'wpresidence-core' ),
                'subtitle' => __( 'Widget Internal Padding - Bottom', 'wpresidence-core' ),
            ),
        
            array(
                'id'       => 'wp_estate_sidebarwidget_internal_padding_right',
                'type'     => 'text',
                'title'    => __( 'Widget Internal Padding - Right', 'wpresidence-core' ),
                'subtitle' => __( 'Widget Internal Padding - Right', 'wpresidence-core' ),
            ),
        
            array(
                'id'       => 'wp_estate_sidebar_widget_color',
                'type'     => 'color',
                'title'    => __( 'Sidebar Widget Background Color', 'wpresidence-core' ),
                'subtitle' => __( 'Sidebar Widget Background Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_sidebar_heading_boxed_color',
                'type'     => 'color',
                'title'    => __( 'Sidebar Heading Color', 'wpresidence-core' ),
                'subtitle' => __( 'Sidebar Heading Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
            
            array(
                'id'       => 'wp_estate_sidebar_heading_background_color',
                'type'     => 'color',
                'title'    => __( 'Sidebar Heading Background Color', 'wpresidence-core' ),
                'subtitle' => __( 'Sidebar Heading Background Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_sidebar_boxed_font_color',
                'type'     => 'color',
                'title'    => __( 'Widget Font color', 'wpresidence-core' ),
                'subtitle' => __( 'Widget Font color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_widget_sidebar_border_size',
                'type'     => 'text',
                'title'    => __( 'Widget Border Size', 'wpresidence-core' ),
                'subtitle' => __( 'Widget Border Size', 'wpresidence-core' ),  
            ),
        
            array(
                'id'       => 'wp_estate_widget_sidebar_border_color',
                'type'     => 'color',
                'title'    => __( 'Widget Border Color', 'wpresidence-core' ),
                'subtitle' => __( 'Widget Border Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            ),
    ) );
    
    
    Redux::setSection( $opt_name, array(
    'title'      => __( 'User Dashboard Design', 'wpresidence-core' ),
    'id'         => 'wpestate_user_dashboard_design_tab',
    'subsection' => true,
    'fields'     => array( 
            array(
                'id'       => 'wp_estate_show_header_dashboard',
                'type'     => 'button_set',
                'title'    => __( 'Show Header in Dashboard ?', 'wpresidence-core' ),
                'subtitle' => __( 'Enable or disable header in dashboard. The header will always be wide & type1 !', 'wpresidence-core' ),
                'options'  => array(
                                'yes' => 'yes',
                                'no'  => 'no'                 
                            ),
                'default'  => 'yes',
            ),
        
            array(
                'id'       => 'wp_estate_user_dashboard_menu_color',
                'type'     => 'color',
                'title'    => __( 'User Dashboard Menu Color', 'wpresidence-core' ),
                'subtitle' => __( 'User Dashboard Menu Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_user_dashboard_menu_hover_color',
                'type'     => 'color',
                'title'    => __( 'User Dashboard Menu Hover Color', 'wpresidence-core' ),
                'subtitle' => __( 'User Dashboard Menu Hover Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_user_dashboard_menu_color_hover',
                'type'     => 'color',
                'title'    => __( 'User Dashboard Menu Item Background Color', 'wpresidence-core' ),
                'subtitle' => __( 'User Dashboard Menu Item Background Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_user_dashboard_menu_back',
                'type'     => 'color',
                'title'    => __( 'User Dashboard Menu Background', 'wpresidence-core' ),
                'subtitle' => __( 'User Dashboard Menu Background', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_user_dashboard_package_back',
                'type'     => 'color',
                'title'    => __( 'User Dashboard Package Background', 'wpresidence-core' ),
                'subtitle' => __( 'User Dashboard Package Background', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_user_dashboard_package_color',
                'type'     => 'color',
                'title'    => __( 'User Dashboard Package Color', 'wpresidence-core' ),
                'subtitle' => __( 'User Dashboard Package Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_user_dashboard_buy_package',
                'type'     => 'color',
                'title'    => __( 'Dashboard Buy Package Select Background', 'wpresidence-core' ),
                'subtitle' => __( 'Dashboard Package Selected', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_user_dashboard_package_select',
                'type'     => 'color',
                'title'    => __( 'Dashboard Package Select', 'wpresidence-core' ),
                'subtitle' => __( 'Dashboard Package Select', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_user_dashboard_content_back',
                'type'     => 'color',
                'title'    => __( 'Content Background Color', 'wpresidence-core' ),
                'subtitle' => __( 'Content Background Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_user_dashboard_content_button_back',
                'type'     => 'color',
                'title'    => __( 'Content Button Background', 'wpresidence-core' ),
                'subtitle' => __( 'Content Button Background', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
            array(
                'id'       => 'wp_estate_user_dashboard_content_color',
                'type'     => 'color',
                'title'    => __( 'Content Text Color', 'wpresidence-core' ),
                'subtitle' => __( 'Content Text Color', 'wpresidence-core' ),
                'transparent' => false,    
            ),
        
        
            ),
    ) );
    
    Redux::setSection( $opt_name, array(
     'title'      => __( 'Fonts', 'wpresidence-core' ),
     'id'         => 'custom_fonts_tab',
     'subsection' => true,
     'class'  => 'custom_fonts_tab',
     'fields'     => array(
        array(
               'id'          => 'h1_typo',
               'type'        => 'typography',
               'title'       => esc_html__('H1 Font', 'wpresidence-core'),
              
               'google'      => true,
               'font-family' => true,
               'subsets'     => true,
               'line-height'=> true,
               'font-weight'=> true,
               'font-backup' => false,
               'text-align'  => false,
               'text-transform' => false,
               'font-style' => false,
               'color'      => false,
               'units'       =>'px',
               'subtitle'    => esc_html__('Select your custom font options.', 'wpresidence-core'),
               'all_styles'  => true
           ),
         
        array(
                'id'          => 'h2_typo',
                'type'        => 'typography',
                'title'       => esc_html__('H2 Font', 'wpresidence-core'),
                'google'      => true,
                'font-family' => true,
                'subsets'     => true,
                'line-height'=> true,
                'font-weight'=> true,
                'font-backup' => false,
                'text-align'  => false,
                'text-transform' => false,
                'font-style' => false,
                'color'      => false,
                'units'       =>'px',
                'subtitle'    => esc_html__('Select your custom font options.', 'wpresidence-core'),
                'all_styles'  => true
            ),
         
        array(
                'id'          => 'h3_typo',
                'type'        => 'typography',
                'title'       => esc_html__('H3 Font', 'wpresidence-core'),
                'google'      => true,
                'font-family' => true,
                'subsets'     => true,
                'line-height'=> true,
                'font-weight'=> true,
                'font-backup' => false,
                'text-align'  => false,
                'text-transform' => false,
                'font-style' => false,
                'color'      => false,
                'units'       =>'px',
                'subtitle'    => esc_html__('Select your custom font options.', 'wpresidence-core'),
                'all_styles'  => true
            ),
         
        array(
               'id'          => 'h4_typo',
               'type'        => 'typography',
               'title'       => esc_html__('H4 Font', 'wpresidence-core'),
               'google'      => true,
               'font-family' => true,
               'subsets'     => true,
               'line-height'=> true,
               'font-weight'=> true,
               'font-backup' => false,
               'text-align'  => false,
               'text-transform' => false,
               'font-style' => false,
               'color'      => false,
               'units'       =>'px',
               'subtitle'    => esc_html__('Select your custom font options.', 'wpresidence-core'),
               'all_styles'  => true
           ),
         
        array(
                'id'          => 'h5_typo',
                'type'        => 'typography',
                'title'       => esc_html__('H5 Font', 'wpresidence-core'),
                'google'      => true,
                'font-family' => true,
                'subsets'     => true,
                'line-height'=> true,
                'font-weight'=> true,
                'font-backup' => false,
                'text-align'  => false,
                'text-transform' => false,
                'font-style' => false,
                'color'      => false,
                'units'       =>'px',
                'subtitle'    => esc_html__('Select your custom font options.', 'wpresidence-core'),
                'all_styles'  => true
            ),
         
         array(
                'id'          => 'h6_typo',
                'type'        => 'typography',
                'title'       => esc_html__('H6 Font', 'wpresidence-core'),
                'google'      => true,
                'font-family' => true,
                'subsets'     => true,
                'line-height'=> true,
                'font-weight'=> true,
                'font-backup' => false,
                'text-align'  => false,
                'text-transform' => false,
                'font-style' => false,
                'color'      => false,
                'units'       =>'px',
                'subtitle'    => esc_html__('Select your custom font options.', 'wpresidence-core'),
                'all_styles'  => true
            ),
         
         array(
                'id'          => 'paragraph_typo',
                'type'        => 'typography',
                'title'       => esc_html__('Paragraph Font', 'wpresidence-core'),
                'google'      => true,
                'font-family' => true,
                'subsets'     => true,
                'line-height'=> true,
                'font-weight'=> true,
                'font-backup' => false,
                'text-align'  => false,
                'text-transform' => false,
                'font-style' => false,
                'color'      => false,
                'units'       =>'px',
                'subtitle'    => esc_html__('Select your custom font options.', 'wpresidence-core'),
                'all_styles'  => true
            ),
         
         array(
                'id'          => 'menu_typo',
                'type'        => 'typography',
                'title'       => esc_html__('Menu Font', 'wpresidence-core'),
                'google'      => true,
                'font-family' => true,
                'subsets'     => true,
                'line-height' => true,
                'font-weight' => true,
                'font-backup' => false,
                'text-align'  => false,
                'text-transform' => false,
                'font-style' => false,
                'color'      => false,
                'units'       =>'px',
                'subtitle'    => esc_html__('Select your custom font options.', 'wpresidence-core'),
                'all_styles'  => true
            ),
          
        ),
    ) );
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Custom CSS', 'wpresidence-core' ),
        'id'         => 'custom_css_tab',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wp_estate_custom_css',
                'type'     => 'ace_editor',
                'title'    => __( 'Custom Css', 'wpresidence-core' ),
                'subtitle' => __( 'Overwrite theme css using custom css.', 'wpresidence-core' ),
                'mode'     => 'css',
                'theme'    => 'monokai',
                ),    
        ),
    ) );
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Property Card Design - Please use the "Save Design" button in order to save your design', 'wpresidence-core' ),
        'id'         => 'property_page__design_tab',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wpestate_uset_unit',
                'type'     =>  'button_set',
                'title'    => __( 'Use this unit/card?', 'wpresidence-core' ),
                'options'  => array(
                                '1' => 'yes',
                                '0'  => 'no'                 
                            ),
                'default'  => '0'// 1 = on | 0 = off
            ),
            array(
                'id'       => 'wpestate_property_page_content1',
                'type'     => 'wpestate_custom_unit_design',
                'title'    => __( 'Card Designer', 'wpresidence-core' ),
                'subtitle' => __( 'This property unit builder is a very complex feature, with a lot of options, and because of that it may not work for all design idees. We will continue to improve it, but please be aware that css problems may appear and those will have to be solved by manually adding css rules in the code.', 'wpresidence-core' ),
                'full_width'=> true
            ),
        ),
    ) );
    
    
    // -> START Advanced Selection
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Advanced', 'wpresidence-core' ),
        'id'         => 'advanced_settings_sidebar',
        'icon'  => 'el el-cog'
    ) );
    
      
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Email Management', 'wpresidence-core' ),
        'id'         => 'email_management_tab',
        'desc'       => __( 'Global variables: %website_url as website url,%website_name as website name, %user_email as user_email, %username as username', 'wpresidence-core' ),
        'subsection' => true,
        'class'      =>'email_management_class',
        'fields'     => array(  
            array(
                'id'       => 'wp_estate_subject_new_user',
                'type'     => 'text',
                'title'    => __( 'Subject for New user notification', 'wpresidence-core' ),
                'subtitle' => __( 'Email subject for New user notification', 'wpresidence-core' ),
                'default'  => __( 'Your username and password on %website_url', 'wpresidence-core' )
            ),    
            array(
                'id'       => 'wp_estate_new_user',
                'type'     => 'editor',
                'title'    => __( 'Content for New user notification', 'wpresidence-core' ),
                'subtitle' => __( 'Email content for New user notification', 'wpresidence-core' ),
                'default'  => __('Hi there,
Welcome to %website_url! You can login now using the below credentials:
Username:%user_login_register
Password: %user_pass_register
If you have any problems, please contact me.
Thank you!', 'wpresidence-core'),
                'desc'     => esc_html__('%user_login_register as new username, %user_pass_register as user password, %user_email_register as new user email, use text mode and <br> tag for new line', 'wpresidence-core'),
            ),
            
            array(
                'id'       => 'wp_estate_subject_admin_new_user',
                'type'     => 'text',
                'title'    => __( 'Subject for New user admin notification', 'wpresidence-core' ),
                'subtitle' => __( 'Email subject for New user admin notification', 'wpresidence-core' ),
                'default'  => __( 'New User Registration', 'wpresidence-core' )
            ),    
            array(
                'id'       => 'wp_estate_admin_new_user',
                'type'     => 'editor',
                'title'    => __( 'Content for New user admin notification', 'wpresidence-core' ),
                'subtitle' => __( 'Email content for New user admin notification', 'wpresidence-core' ),
                'default'  => __('New user registration on %website_url.
Username: %user_login_register, 
E-mail: %user_email_register', 'wpresidence-core'),
                'desc'     => esc_html__('%user_login_register as new username and %user_email_register as new user email, use text mode and <br> tag for new line', 'wpresidence-core'),
            ),
            
            
            array(
                'id'       => 'wp_estate_subject_purchase_activated',
                'type'     => 'text',
                'title'    => __( 'Subject for Purchase Activated', 'wpresidence-core' ),
                'subtitle' => __( 'Email subject for Purchase Activated', 'wpresidence-core' ),
                'default'  => __( 'Your purchase was activated', 'wpresidence-core' )
            ),    
            array(
                'id'       => 'wp_estate_purchase_activated',
                'type'     => 'editor',
                'title'    => __( 'Content for Purchase Activated', 'wpresidence-core' ),
                'subtitle' => __( 'Email content for Purchase Activated', 'wpresidence-core' ),
                'default'  => __('Hi there,
Your purchase on  %website_url is activated! You should go check it out.', 'wpresidence-core'),
                'desc'     => esc_html__('%user_login_register as new username and %user_email_register as new user email, use text mode and <br> tag for new line', 'wpresidence-core'),
            ),
            
            
            array(
                'id'       => 'wp_estate_subject_password_reset_request',
                'type'     => 'text',
                'title'    => __( 'Subject for Password Reset Request', 'wpresidence-core' ),
                'subtitle' => __( 'Email subject for Password Reset Request', 'wpresidence-core' ),
                'default'  => __( 'Password Reset Request', 'wpresidence-core' )
            ),    
            array(
                'id'       => 'wp_estate_password_reset_request',
                'type'     => 'editor',
                'title'    => __( 'Content for Password Reset Request', 'wpresidence-core' ),
                'subtitle' => __( 'Email content for Password Reset Request', 'wpresidence-core' ),
                'default'  => __('Someone requested that the password be reset for the following account:
%website_url 
Username: %username.
If this was a mistake, just ignore this email and nothing will happen. To reset your password, visit the following address:%reset_link,
Thank You!', 'wpresidence-core'),
                'desc'     => esc_html__('%reset_link as reset link, use text mode and <br> tag for new line', 'wpresidence-core'),
            ),
            
            array(
                'id'       => 'wp_estate_subject_password_reseted',
                'type'     => 'text',
                'title'    => __( 'Subject for Password Reseted', 'wpresidence-core' ),
                'subtitle' => __( 'Email subject for Password Reset Request', 'wpresidence-core' ),
                'default'  => __( 'Your Password was Reset', 'wpresidence-core' )
            ),    
            array(
                'id'       => 'wp_estate_password_reseted',
                'type'     => 'editor',
                'title'    => __( 'Content for Password Reseted', 'wpresidence-core' ),
                'subtitle' => __( 'Email content for Password Reseted', 'wpresidence-core' ),
                'default'  => __('Your new password for the account at: %website_url: 
Username:%username, 
Password:%user_pass.
You can now login with your new password at: %website_url', 'wpresidence-core'),
                'desc'     => esc_html__('%user_pass as user password, use text mode and <br> tag for new line', 'wpresidence-core'),
            ),
            
            
            array(
                'id'       => 'wp_estate_subject_purchase_activated',
                'type'     => 'text',
                'title'    => __( 'Subject for Purchase Activated', 'wpresidence-core' ),
                'subtitle' => __( 'Email subject for Purchase Activated', 'wpresidence-core' ),
                'default'  => __( 'Your purchase was activated', 'wpresidence-core' )
            ),    
            array(
                'id'       => 'wp_estate_purchase_activated',
                'type'     => 'editor',
                'title'    => __( 'Content for Purchase Activated', 'wpresidence-core' ),
                'subtitle' => __( 'Email content for Purchase Activated', 'wpresidence-core' ),
                'default'  => __('Hi there,
Your purchase on  %website_url is activated! You should go check it out.', 'wpresidence-core'),
                'desc'     => esc_html__('use text mode and <br> tag for new line', 'wpresidence-core'),
            ),
            
            
            array(
                'id'       => 'wp_estate_subject_approved_listing',
                'type'     => 'text',
                'title'    => __( 'Subject for Approved Listings', 'wpresidence-core' ),
                'subtitle' => __( 'Email subject for Approved Listings', 'wpresidence-core' ),
                'default'  => __( 'Your listing was approved', 'wpresidence-core' )
            ),    
            array(
                'id'       => 'wp_estate_approved_listing',
                'type'     => 'editor',
                'title'    => __( 'Content for Approved Listings', 'wpresidence-core' ),
                'subtitle' => __( 'Email content for Approved Listings', 'wpresidence-core' ),
                'default'  => __('Hi there,
Your listing, %property_title was approved on  %website_url! The listing is: %property_url.
You should go check it out.', 'wpresidence-core'),
                'desc'     => esc_html__('* you can use %post_id as listing id, %property_url as property url and %property_title as property name, use text mode and <br> tag for new line', 'wpresidence-core'),
            ),
            
            
            array(
                'id'       => 'wp_estate_subject_new_wire_transfer',
                'type'     => 'text',
                'title'    => __( 'Subject for New wire Transfer', 'wpresidence-core' ),
                'subtitle' => __( 'Email subject for New wire Transfer', 'wpresidence-core' ),
                'default'  => __( 'You ordered a new Wire Transfer', 'wpresidence-core' )
            ),    
            array(
                'id'       => 'wp_estate_new_wire_transfer',
                'type'     => 'editor',
                'title'    => __( 'Content for New wire Transfer', 'wpresidence-core' ),
                'subtitle' => __( 'Email content for New wire Transfer', 'wpresidence-core' ),
                'default'  => __('We received your Wire Transfer payment request on  %website_url !
Please follow the instructions below in order to start submitting properties as soon as possible.
The invoice number is: %invoice_no, Amount: %total_price. 
Instructions:  %payment_details.', 'wpresidence-core'),
                'desc'     => esc_html__('* you can use %invoice_no as invoice number, %total_price as $totalprice and %payment_details as $payment_details, use text mode and <br> tag for new line', 'wpresidence-core'),
            ),
            
            
            array(
                'id'       => 'wp_estate_subject_admin_new_wire_transfer',
                'type'     => 'text',
                'title'    => __( 'Subject for Admin - New wire Transfer', 'wpresidence-core' ),
                'subtitle' => __( 'Email subject for Admin - New wire Transfer', 'wpresidence-core' ),
                'default'  => __( 'Somebody ordered a new Wire Transfer', 'wpresidence-core' )
            ),    
            array(
                'id'       => 'wp_estate_admin_new_wire_transfer',
                'type'     => 'editor',
                'title'    => __( 'Content for Admin - New wire Transfer', 'wpresidence-core' ),
                'subtitle' => __( 'Email content for Admin - New wire Transfer', 'wpresidence-core' ),
                'default'  => __('Hi there,
You received a new Wire Transfer payment request on %website_url.
The invoice number is:  %invoice_no,  Amount: %total_price.
Please wait until the payment is made to activate the user purchase.', 'wpresidence-core'),
                'desc'     => esc_html__('* you can use %invoice_no as invoice number, %total_price as $totalprice and %payment_details as $payment_details, use text mode and <br> tag for new line', 'wpresidence-core'),
            ),
            
            
            array(
                'id'       => 'wp_estate_subject_admin_expired_listing',
                'type'     => 'text',
                'title'    => __( 'Subject for Admin - Expired Listing', 'wpresidence-core' ),
                'subtitle' => __( 'Email subject for Admin - Expired Listing', 'wpresidence-core' ),
                'default'  => __( 'Expired Listing sent for approval on %website_url', 'wpresidence-core' )
            ),    
            array(
                'id'       => 'wp_estate_admin_expired_listing',
                'type'     => 'editor',
                'title'    => __( 'Content for Admin - Expired Listing', 'wpresidence-core' ),
                'subtitle' => __( 'Email content for Admin - Expired Listing', 'wpresidence-core' ),
                'default'  => __('Hi there,
A user has re-submited a new property on %website_url! You should go check it out.
This is the property title: %submission_title.', 'wpresidence-core'),
                'desc'     => esc_html__('* you can use %submission_title as property title number, %submission_url as property submission url, use text mode and <br> tag for new line', 'wpresidence-core'),
            ),
            
            array(
                'id'       => 'wp_estate_subject_matching_submissions',
                'type'     => 'text',
                'title'    => __( 'Subject for Matching Submissions', 'wpresidence-core' ),
                'subtitle' => __( 'Email subject for Matching Submissions', 'wpresidence-core' ),
                'default'  => __( 'Matching Submissions on %website_url', 'wpresidence-core' )
            ),    
            array(
                'id'       => 'wp_estate_matching_submissions',
                'type'     => 'editor',
                'title'    => __( 'Content for Matching Submissions', 'wpresidence-core' ),
                'subtitle' => __( 'Email content for Matching Submissions', 'wpresidence-core' ),
                'default'  => __('Hi there,
A new submission matching your chosen criteria has been published at %website_url.
These are the new submissions: 
%matching_submissions
If you do not wish to be notified anymore please enter your account and delete the saved search.Thank you!', 'wpresidence-core'),
                'desc'     => esc_html__('* you can use %matching_submissions as matching submissions list, use text mode and <br> tag for new line', 'wpresidence-core'),
            ),
           
            
            array(
                'id'       => 'wp_estate_subject_paid_submissions',
                'type'     => 'text',
                'title'    => __( 'Subject for Paid Submission', 'wpresidence-core' ),
                'subtitle' => __( 'Email subject for Paid Submission', 'wpresidence-core' ),
                'default'  => __( 'New Paid Submission on %website_url', 'wpresidence-core' ),
            ),    
            array(
                'id'       => 'wp_estate_paid_submissions',
                'type'     => 'editor',
                'title'    => __( 'Content for Paid Submission', 'wpresidence-core' ),
                'subtitle' => __( 'Email content for Paid Submission', 'wpresidence-core' ),
                'default'  => __('Hi there,
You have a new paid submission on  %website_url! You should go check it out.', 'wpresidence-core'),
                'desc'     => esc_html__('use text mode and <br> tag for new line', 'wpresidence-core'),
            ),
            
            
            
            
            array(
                'id'       => 'wp_estate_subject_featured_submission',
                'type'     => 'text',
                'title'    => __( 'Subject for Featured Submission', 'wpresidence-core' ),
                'subtitle' => __( 'Email subject for Featured Submission', 'wpresidence-core' ),
                'default'  => __( 'New Feature Upgrade on  %website_url', 'wpresidence-core' )
            ),    
            array(
                'id'       => 'wp_estate_featured_submission',
                'type'     => 'editor',
                'title'    => __( 'Content for Featured Submission', 'wpresidence-core' ),
                'subtitle' => __( 'Email content for Featured Submission', 'wpresidence-core' ),
                'default'  => __('Hi there,
You have a new featured submission on  %website_url! You should go check it out.', 'wpresidence-core'),
                'desc'     => esc_html__('use text mode and <br> tag for new line', 'wpresidence-core'),
            ),
            
            
            array(
                'id'       => 'wp_estate_subject_account_downgraded',
                'type'     => 'text',
                'title'    => __( 'Subject for Account Downgraded', 'wpresidence-core' ),
                'subtitle' => __( 'Email subject for Account Downgraded', 'wpresidence-core' ),
                'default'  => __( 'Account Downgraded on %website_url', 'wpresidence-core' )
            ),    
            array(
                'id'       => 'wp_estate_account_downgraded',
                'type'     => 'editor',
                'title'    => __( 'Content for Account Downgraded', 'wpresidence-core' ),
                'subtitle' => __( 'Email content for Account Downgraded', 'wpresidence-core' ),
                'default'  => __('Hi there,
You downgraded your subscription on %website_url. Because your listings number was greater than what the actual package offers, we set the status of all your listings to "expired". You will need to choose which listings you want live and send them again for approval.
Thank you!', 'wpresidence-core'),
                'desc'     => esc_html__('use text mode and <br> tag for new line', 'wpresidence-core'),
            ),
            
            
            
            array(
                'id'       => 'wp_estate_subject_membership_cancelled',
                'type'     => 'text',
                'title'    => __( 'Subject for Membership Cancelled', 'wpresidence-core' ),
                'subtitle' => __( 'Email subject for Membership Cancelled', 'wpresidence-core' ),
                'default'  => __( 'Membership Cancelled on %website_url', 'wpresidence-core' )
            ),    
            array(
                'id'       => 'wp_estate_membership_cancelled',
                'type'     => 'editor',
                'title'    => __( 'Content for Membership Cancelled', 'wpresidence-core' ),
                'subtitle' => __( 'Email content for Membership Cancelled', 'wpresidence-core' ),
                'default'  => __('Hi there,
Your subscription on %website_url was cancelled because it expired or the recurring payment from the merchant was not processed. All your listings are no longer visible for our visitors but remain in your account.
Thank you.', 'wpresidence-core'),
                'desc'     => esc_html__('use text mode and <br> tag for new line', 'wpresidence-core'),
            ),
            
            
            array(
                'id'       => 'wp_estate_subject_downgrade_warning',
                'type'     => 'text',
                'title'    => __( 'Subject for Membership Expiration Warning', 'wpresidence-core' ),
                'subtitle' => __( 'Email subject for Membership Expiration Warning', 'wpresidence-core' ),
                'default'  => __( 'Membership Expiration Warning on %website_url', 'wpresidence-core' )
            ),    
            array(
                'id'       => 'wp_estate_downgrade_warning',
                'type'     => 'editor',
                'title'    => __( 'Content for Membership Expiration Warning', 'wpresidence-core' ),
                'subtitle' => __( 'Email content for Membership Expiration Warning', 'wpresidence-core' ),
                'default'  => __('Hi there,
Your subscription on %website_url will expire in 3 days.Please make sure you renew your subscription or you have enough funds for an auto renew.', 'wpresidence-core'),
            'desc'     => esc_html__('use text mode and <br> tag for new line', 'wpresidence-core'),
                ),
            
            
            array(
                'id'       => 'wp_estate_subject_free_listing_expired',
                'type'     => 'text',
                'title'    => __( 'Subject for Free Listing Expired', 'wpresidence-core' ),
                'subtitle' => __( 'Email subject for Free Listing Expired', 'wpresidence-core' ),
                'default'  => __( 'Free Listing expired on %website_url', 'wpresidence-core' )
            ),    
            array(
                'id'       => 'wp_estate_free_listing_expired',
                'type'     => 'editor',
                'title'    => __( 'Content for Free Listing Expired', 'wpresidence-core' ),
                'subtitle' => __( 'Email content for Free Listing Expired', 'wpresidence-core' ),
                'default'  => __('Hi there,
One of your free listings on  %website_url has "expired". The listing is %expired_listing_url.
Thank you!', 'wpresidence-core'),
                'desc'     => esc_html__('* you can use %expired_listing_url as expired listing url and %expired_listing_name as expired listing name, use text mode and <br> tag for new line', 'wpresidence-core'),
            ),
            
            
            array(
                'id'       => 'wp_estate_subject_new_listing_submission',
                'type'     => 'text',
                'title'    => __( 'Subject for New Listing Submission', 'wpresidence-core' ),
                'subtitle' => __( 'Email subject for New Listing Submission', 'wpresidence-core' ),
                'default'  => __( 'New Listing Submission on %website_url', 'wpresidence-core' )
            ),    
            array(
                'id'       => 'wp_estate_new_listing_submission',
                'type'     => 'editor',
                'title'    => __( 'Content for New Listing Submission', 'wpresidence-core' ),
                'subtitle' => __( 'Email content for New Listing Submission', 'wpresidence-core' ),
                'default'  => __('Hi there,
A user has submited a new property on %website_url! You should go check it out.This is the property title %new_listing_title!', 'wpresidence-core'),
            'desc'     => esc_html__('* you can use %new_listing_title as new listing title and %new_listing_url as new listing url, use text mode and <br> tag for new line', 'wpresidence-core'),
            ),
            
            
            
            array(
                'id'       => 'wp_estate_subject_listing_edit',
                'type'     => 'text',
                'title'    => __( 'Subject for Listing Edit', 'wpresidence-core' ),
                'subtitle' => __( 'Email subject for Listing Edit', 'wpresidence-core' ),
                'default'  => __( 'Listing Edited on %website_url', 'wpresidence-core' )
            ),    
            array(
                'id'       => 'wp_estate_listing_edit',
                'type'     => 'editor',
                'title'    => __( 'Content for Listing Edit', 'wpresidence-core' ),
                'subtitle' => __( 'Email content for Listing Edit', 'wpresidence-core' ),
                'default'  => __('Hi there,
A user has edited one of his listings  on %website_url ! You should go check it out. The property name is : %editing_listing_title!', 'wpresidence-core'),
            'desc'     => esc_html__('* you can use %editing_listing_title as editing listing title and %editing_listing_url as editing listing url, use text mode and <br> tag for new line', 'wpresidence-core'),
            ),
            
            
            array(
                'id'       => 'wp_estate_subject_recurring_payment',
                'type'     => 'text',
                'title'    => __( 'Subject for Recurring Payment', 'wpresidence-core' ),
                'subtitle' => __( 'Email subject for Recurring Payment', 'wpresidence-core' ),
                'default'  => __( 'Recurring Payment on %website_url', 'wpresidence-core' )
            ),    
            array(
                'id'       => 'wp_estate_recurring_payment',
                'type'     => 'editor',
                'title'    => __( 'Content for Recurring Payment', 'wpresidence-core' ),
                'subtitle' => __( 'Email content for Recurring Payment', 'wpresidence-core' ),
                'default'  => __('Hi there,
We charged your account on %merchant for a subscription on %website_url ! You should go check it out.', 'wpresidence-core'),
            'desc'     => esc_html__('* you can use %recurring_pack_name as recurring packacge name and %merchant as merchant name, use text mode and <br> tag for new line', 'wpresidence-core'),
            ),
            
            
            array(
                'id'       => 'wp_estate_subject_membership_activated',
                'type'     => 'text',
                'title'    => __( 'Subject for Membership Activated', 'wpresidence-core' ),
                'subtitle' => __( 'Email subject for Membership Activated', 'wpresidence-core' ),
                'default'  => __( 'Membership Activated on %website_url', 'wpresidence-core' )
            ),    
            array(
                'id'       => 'wp_estate_membership_activated',
                'type'     => 'editor',
                'title'    => __( 'Content for Membership Activated', 'wpresidence-core' ),
                'subtitle' => __( 'Email content for Membership Activated', 'wpresidence-core' ),
                'default'  => __('Hi there,
Your new membership on %website_url is activated! You should go check it out.', 'wpresidence-core'),
                'desc'     => esc_html__('use text mode and <br> tag for new line', 'wpresidence-core'),
            
            ),
            
            array(
                'id'       => 'wp_estate_subject_agent_update_profile',
                'type'     => 'text',
                'title'    => __( 'Subject for Update Profil', 'wpresidence-core' ),
                'subtitle' => __( 'Email subject for Update Profile', 'wpresidence-core' ),
                'default'  => __( 'Profile Update', 'wpresidence-core' )
            ),    
            array(
                'id'       => 'wp_estate_agent_update_profile',
                'type'     => 'editor',
                'title'    => __( 'Content for Update Profile', 'wpresidence-core' ),
                'subtitle' => __( 'Email content for Update Profile', 'wpresidence-core' ),
                'default'  => __('A user updated his profile on %website_url.
Username: %user_profile', 'wpresidence-core'),
                'desc'     => esc_html__('use text mode and <br> tag for new line', 'wpresidence-core'),
                
                
                
                array(
                'id'       => 'wp_estate_subject_agent_added',
                'type'     => 'text',
                'title'    => __( 'Subject for New Agent', 'wpresidence-core' ),
                'subtitle' => __( 'Email subject for New Agent', 'wpresidence-core' ),
                'default'  => __( 'New Agent Added', 'wpresidence-core' )
            ),    
            array(
                'id'       => 'wp_estate_agent_added',
                'type'     => 'editor',
                'title'    => __( 'Content for New Agent', 'wpresidence-core' ),
                'subtitle' => __( 'Email content for New Agent', 'wpresidence-core' ),
                'default'  => __('A new agent was added on %website_url.
Username: %user_profile', 'wpresidence-core'),
                'desc'     => esc_html__('use text mode and <br> tag for new line', 'wpresidence-core'),
            )
            
            
            
          ),  
        ),
    ) );
                $value_httaces='<IfModule mod_deflate.c>
# Insert filters
AddOutputFilterByType DEFLATE text/plain
AddOutputFilterByType DEFLATE text/html
AddOutputFilterByType DEFLATE text/xml
AddOutputFilterByType DEFLATE text/css
AddOutputFilterByType DEFLATE application/xml
AddOutputFilterByType DEFLATE application/xhtml+xml
AddOutputFilterByType DEFLATE application/rss+xml
AddOutputFilterByType DEFLATE application/javascript
AddOutputFilterByType DEFLATE application/x-javascript
AddOutputFilterByType DEFLATE application/x-httpd-php
AddOutputFilterByType DEFLATE application/x-httpd-fastphp
AddOutputFilterByType DEFLATE image/svg+xml
# Drop problematic browsers
BrowserMatch ^Mozilla/4 gzip-only-text/html
BrowserMatch ^Mozilla/4\.0[678] no-gzip
BrowserMatch \bMSI[E] !no-gzip !gzip-only-text/html
# Make sure proxies dont deliver the wrong content
Header append Vary User-Agent env=!dont-vary
</IfModule>
## EXPIRES CACHING ##
<IfModule mod_expires.c>
ExpiresActive On
ExpiresByType image/jpg "access 1 year"
ExpiresByType image/jpeg "access 1 year"
ExpiresByType image/gif "access 1 year"
ExpiresByType image/png "access 1 year"
ExpiresByType text/css "access 1 month"
ExpiresByType text/html "access 1 month"
ExpiresByType application/pdf "access 1 month"
ExpiresByType text/x-javascript "access 1 month"
ExpiresByType application/x-shockwave-flash "access 1 month"
ExpiresByType image/x-icon "access 1 year"
ExpiresDefault "access 1 month"
</IfModule>
## EXPIRES CACHING ##';
                
                
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Site Speed', 'wpresidence-core' ),
        'id'         => 'speed_management_tab',
        'desc'       =>    '<strong>'.__( 'Speed Advices'
                . '</strong></br>1. If you are NOT using "Ultimate Addons for Visual Composer" please disable it or just disable the modules you don\'t use. It will reduce the size of javascript files you are loading and increase the site speed!.'
                . '</br>2. Use the EWWW Image Optimizer (or WP Smush IT) plugin to optimise images- optimised images increase the site speed.'
                . '</br>3. Create a free account on Cloudflare (https://www.cloudflare.com/) and use this CDN.'
                . '</br>4. If you are using custom categories make sure you are adding the custom pins images on Theme Options -> Map -> Pin Management. The site will get slow if it needs to look for images that don\'t exist. ', 'wpresidence-core' ),
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wp_estate_disable_theme_cache',
                'type'     => 'button_set',
                'title'    => __( 'Disable Theme Cache (Keep theme cache on when your site is in production)', 'wpresidence-core' ),
                'subtitle' => __( 'Theme Cache will cache only the heavy database queries. Use this feature along classic cache plugins like WpRocket!', 'wpresidence-core' ),
                'options'  => array(
                                'no' => 'no',
                                'yes'  => 'yes'                 
                            ),
                'default'  => 'no',
            ),
            array(
                'id'       => 'wp_estate_use_mimify',
                'type'     => 'button_set',
                'title'    => __( 'Minify css and js files', 'wpresidence-core' ),
                'subtitle' => __( 'The system will use the minified versions of the css and js files', 'wpresidence-core' ),
                'options'  => array(
                                'no' => 'no',
                                'yes'  => 'yes'                 
                            ),
                'default'  => 'no',
            ),
            
            array(
                'id'       => 'wp_estate_remove_script_version',
                'type'     => 'button_set',
                'title'    => __( 'Remove script version - Following Envato guidelines we removed this feature.Please use a cache plugin in order to remove the script version.', 'wpresidence-core' ),
                'subtitle' => __( 'The system will remove the script version when it is included. This doest not actually improve speed, but improves test score on speed tools pages.', 'wpresidence-core' ),
                'options'  => array(
                                'no' => 'no',
                                'yes'  => 'yes'                 
                            ),
                'default'  => 'no',
            ),
            
            

            array(
                'id'       => 'info_warning_enable_browser',
                'type'     => 'textarea',
               // 'style' => 'warning',
                'title'    => __( 'Enable Browser Cache', 'wpresidence-core' ),
                'subtitle' => __('Add this code in your .httaces file(copy paste at the end). It will activate the browser cache and speed up your site.', 'wpresidence-core'),
              //  'desc'   => $value_httaces,
                'default'   => $value_httaces,
            
            ),
    ) ));
    
     Redux::setSection( $opt_name, array(
        'title'      => __( 'Import & Export', 'wpresidence-core' ),
        'id'         => 'import_export_ab',
        'subsection' => true,
        'fields'     => array(
            array(
                  'id'            => 'opt-import-export',
                  'type'          => 'import_export',
                  'title'         => 'Import & Export',
                //  'subtitle'      => '',
                  'full_width'    => false,
              ),
        ),
    ) );
    
     
    Redux::setSection( $opt_name, array(
        'title'      => __( 'reCaptcha settings', 'wpresidence-core' ),
        'id'         => 'recaptcha_tab',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wp_estate_use_captcha',
                'type'     => 'button_set',
                'title'    => __( 'Use reCaptcha on register ?', 'wpresidence-core' ),
                'subtitle' => __( 'This helps preventing registration spam.', 'wpresidence-core' ),
                'options'  => array(
                            'no'  => 'no', 
                            'yes' => 'yes'
                            ),
                'default'  => 'no',
            ),
            array(
                'id'       => 'wp_estate_recaptha_sitekey',
                'type'     => 'text',
                'required' =>   array('wp_estate_use_captcha','=','yes'),
                'title'    => __( 'reCaptha site key' , 'wpresidence-core' ),
                'subtitle' => __( 'Get this detail after you signup here: ', 'wpresidence-core' ).'<a href="https://www.google.com/recaptcha/intro/index.html" target="_blank">https://www.google.com/recaptcha/intro/index.html</a>',
            ),
            array(
                'id'       => 'wp_estate_recaptha_secretkey',
                'type'     => 'text',
                'required' =>   array('wp_estate_use_captcha','=','yes'),
                'title'    => __( 'reCaptha secret key', 'wpresidence-core' ),
                'subtitle' => __( 'Get this detail after you signup here: ', 'wpresidence-core' ).'<a href="https://www.google.com/recaptcha/intro/index.html" target="_blank">https://www.google.com/recaptcha/intro/index.html</a>',
            ),
        ),
    ) );
     
     
     Redux::setSection( $opt_name, array(
        'title'      => __( 'Yelp settings', 'wpresidence-core' ),
        'id'         => 'yelp_tab',
        'desc'       => __( 'Please note that Yelp is not working for all countries. See here https://www.yelp.com/factsheet the list of countries where Yelp is available.', 'wpresidence-core' ),
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wp_estate_yelp_client_id',
                'type'     => 'text',
                'title'    => __( 'Yelp Api Client ID' , 'wpresidence-core'),
                'subtitle' => __( 'Get this detail after you signup here: ', 'wpresidence-core' ).'<a href="https://www.yelp.com/developers/v3/manage_app" target="_blank">https://www.yelp.com/developers/v3/manage_app</a>',
            ),
            
            array(
                'id'       => 'wp_estate_yelp_client_api_key_2018',
                'type'     => 'text',
                'title'    => __( 'Yelp Api Key' , 'wpresidence-core'),
                'subtitle' => __( 'Get this detail after you signup here: ', 'wpresidence-core' ).'<a href="https://www.yelp.com/developers/v3/manage_app" target="_blank">https://www.yelp.com/developers/v3/manage_app</a>',
            ),
            
            array(
                'id'       => 'wp_estate_yelp_categories',
                'type'     => 'select',
                'multi'    =>   true,
                'title'    => __( 'Yelp Categories', 'wpresidence-core' ),
                'subtitle' => __( 'Yelp Categories to show on front page', 'wpresidence-core' ),
                'options'  => wpresidence_core_redux_yelp(),
            ),
            
            array(
                'id'       => 'wp_estate_yelp_results_no',
                'type'     => 'text',
                'title'    => __( 'Yelp - no of results', 'wpresidence-core' ),
                'subtitle' => __( '*Numeric field. Type no of results wish to show on listing page for each category.', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_yelp_dist_measure',
                'type'     => 'button_set',
                'title'    => __( 'Yelp Distance Measurement Unit', 'wpresidence-core' ),
                'subtitle' => __( 'Yelp Distance Measurement Unit', 'wpresidence-core' ),
                'options'  => array('miles'=>'miles','kilometers'=>'kilometers'),
                'default'  => 'miles',
            ),
        ),
    ) );
     
     
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Optima Express settings', 'wpresidence-core' ),
        'id'         => 'optima_express_tab',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wp_estate_use_optima',
                'type'     => 'button_set',
                'title'    => __( 'Use Optima Express plugin (idx plugin by ihomefinder) - you will need to enable the plugin ?', 'wpresidence-core' ),
                'subtitle' => __( 'Enable compatibility mode with Optima Express plugin', 'wpresidence-core' ),
                'options'  => array(
                            'no'  => 'no', 
                            'yes' => 'yes'
                            ),
                'default'  => 'no',
            ),
        ),
    ) );
    
    // -> START Membership Selection
    Redux::setSection( $opt_name, array(
        'title' => __( 'Membership', 'wpresidence-core' ),
        'id'    => 'membership_settings_sidebar',
        'icon'  => 'el el-group'
    ) ); 
    
     
    
    $list_currency= array(
                    'USD' => 'USD',
                    'EUR' => 'EUR',
                    'AUD' => 'AUD',
                    'BRL' => 'BRL',
                    'CAD' => 'CAD',
                    'CZK' => 'CZK',
                    'DKK' => 'DKK',
                    'HKD' => 'HKD',
                    'HUF' => 'HUF',
                    'ILS' => 'ILS',
                    'INR' => 'INR',
                    'JPY' => 'JPY',
                    'MYR' => 'MYR',
                    'MXN' => 'MXN',
                    'NOK' => 'NOK',
                    'NZD' => 'NZD',
                    'PHP' => 'PHP',
                    'PLN' => 'PLN',
                    'GBP' => 'GBP',
                    'SGD' => 'SGD',
                    'SEK' => 'SEK',
                    'CHF' => 'CHF',
                    'TWD' => 'TWD',
                    'THB' => 'THB',
                    'TRY' => 'TRY',
            );
    $custom_field= Redux::getOption( $opt_name,'wp_estate_submission_curency_custom');
    if($custom_field!=''){      
        $list_currency[$custom_field]=$custom_field;
    }
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Membership Settings', 'wpresidence-core' ),
        'id'         => 'membership_settings_tab',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wp_estate_paid_submission',
                'type'     => 'button_set',
                'title'    => __( 'Enable Paid Submission ?', 'wpresidence-core' ),
                'subtitle' => __( 'No = submission is free. Paid listing = submission requires user to pay a fee for each listing. Membership = submission is based on user membership package.', 'wpresidence-core' ),
                'options'  => array(
                            'no'         => 'no', 
                            'per listing'=> 'per listing',
                            'membership' => 'membership'
                        ),
                'default'  => 'no',
            ),
            
            array(
                'id'       => 'wp_estate_free_mem_list',
                'type'     => 'text',
                'required'  => array('wp_estate_paid_submission','=','membership'),
                'title'    => __( ' Free Membership - no of free listings for new users', 'wpresidence-core' ),
                'subtitle' => __( 'If you change this value, the new value applies for new registered users. Old value applies for older registered accounts.', 'wpresidence-core' ),
                'default'  => '0'
             ),
           
            
            array(
                'id'       => 'wp_estate_free_mem_list_unl',
                'required'  => array('wp_estate_paid_submission','=','membership'),
                'type'     => 'checkbox',
                'title'    => __( 'Free Membership - Offer unlimited listings for new users', 'wpresidence-core' ),
                'default'  => '1'// 1 = on | 0 = off
            ),
            array(
                'id'       => 'wp_estate_free_feat_list',
                'required'  => array('wp_estate_paid_submission','=','membership'),
                'type'     => 'text',
                'title'    => __( 'Free Membership - no of featured listings (for "membership" mode)', 'wpresidence-core' ),
                'subtitle' => __( 'If you change this value, the new value applies for new registered users. Old value applies for older registered accounts.', 'wpresidence-core' ),
                'default'  => '0'
            ),
            array(
                'id'       => 'wp_estate_free_feat_list_expiration',
                'required'  => array('wp_estate_paid_submission','=','membership'),
                'type'     => 'text',
                'title'    => __( 'Free Days for Each Free Listing - no of days until a free listing will expire. *Starts from the moment the listing is published on the website. (for "membership" mode only)', 'wpresidence-core' ),
                'subtitle' => __( 'Option applies for each free published listing.', 'wpresidence-core' ),
                'default'  => '0'
            ),
            
            array(
                'id'       => 'wp_estate_free_pack_image_included',
                'required'  => array('wp_estate_paid_submission','=','membership'),
                'type'     => 'text',
                'title'    => __( 'Free Membership Images - no of images per listing', 'wpresidence-core' ),
                'subtitle' => __( 'Option applies for each free published listing.', 'wpresidence-core' ),
                'default'  => '0'
            ),

            array(
                'id'       => 'wp_estate_price_submission',
                'type'     => 'text',
                'required'  => array('wp_estate_paid_submission','=','per listing'),
                'title'    => __( 'Price Per Submission (for "per listing" mode)', 'wpresidence-core' ),
                'subtitle' => __( 'Use .00 format for decimals (ex: 5.50). Do not set price as 0!', 'wpresidence-core' ),
                'default'  => '0'
            ),
            array(
                'id'       => 'wp_estate_price_featured_submission',
                'type'     => 'text',
                'required'  => array('wp_estate_paid_submission','=','per listing'),
                'title'    => __( 'Price to make the listing featured (for "per listing" mode)', 'wpresidence-core' ),
                'subtitle' => __( 'Use .00 format for decimals (ex: 1.50). Do not set price as 0!', 'wpresidence-core' ),
                'default'  => '0'
            ),
             
            array(
                'id'       => 'wp_estate_admin_submission',
                'type'     => 'button_set',
                'title'    => __( 'Submited Listings should be approved by admin?', 'wpresidence-core' ),
                'subtitle' => __( 'If yes, admin publishes each property submitted in front end manually.', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes', 
                            'no'  => 'no',
                        ),
                'default'  => 'yes',
            ),
            
            array(
                'id'       => 'wp_estate_prop_image_number',
                'type'     => 'text',
                'required'  => array('wp_estate_paid_submission','!=','membership'),
                'title'    => __( 'Maximum no of images per property (only front-end upload). Works when submission is free or requires user to pay a fee for each listing', 'wpresidence-core' ),
                'subtitle' => __( 'The maximum no of images a user can upload with the front end submit form. Use 0 for unlimited. This value is NOT used in case of membership mode (each package will have its own max image no set)', 'wpresidence-core' ),
                'default' => '12'
            ),
            
            array(
                'id'       => 'wp_estate_paypal_api',
                'type'     => 'button_set',
                'required'  => array('wp_estate_paid_submission','!=','no'),
                'title'    => __( 'Paypal & Stripe Api', 'wpresidence-core' ),
                'subtitle' => __( 'Sandbox = test API. LIVE = real payments API. Update PayPal and Stripe settings according to API type selection.', 'wpresidence-core' ),
                'options'  => array(
                            'sandbox' => 'sandbox', 
                            'live'  => 'live',
                        ),
                'default'  => 'sandbox',
            ),
            
            
            array(
                'id'       => 'wp_estate_submission_curency',
                'type'     => 'button_set',
                'required'  => array('wp_estate_paid_submission','!=','no'),
                'title'    => __( 'Currency For Paid Submission', 'wpresidence-core' ),
                'subtitle' => __( 'The currency in which payments are processed.', 'wpresidence-core' ),
                'options'  => $list_currency,
                'default'  => 'USD',
            ),
            
            array(
                'id'       => 'wp_estate_enable_direct_pay',
                'type'     => 'button_set',
                'required'  => array('wp_estate_paid_submission','!=','no'),
                'title'    => __( 'Enable Direct Payment / Wire Payment?', 'wpresidence-core' ),
                'subtitle' => __( 'Enable or disable the wire payment option.', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes', 
                            'no'  => 'no',
                        ),
                'default'  => 'no',
            ),
            
            array(
                'id'       => 'wp_estate_submission_curency_custom',
                'type'     => 'text',
                'required'=>array('wp_estate_enable_direct_pay','=','yes'),
                'title'    => __( 'Custom Currency Symbol - *select it from the list above after you add it.', 'wpresidence-core' ),
                'subtitle' => __( 'Add your own currency for Wire payments.', 'wpresidence-core' ),
            ),
            
            array(
                'id' => 'wp_estate_direct_payment_details',
                'type' => 'textarea',
                'required'=>array('wp_estate_enable_direct_pay','=','yes'),
                'title' => __('Wire instructions for direct payment', 'wpresidence-core'),
                'subtitle' => __('If wire payment is enabled, type the instructions below.', 'wpresidence-core'),
                'validate' => 'html_custom',
                'allowed_html' => array(
                    'a' => array(
                        'href' => array(),
                        'title' => array()
                    ),
                    'br' => array(),
                    'em' => array(),
                    'strong' => array()
                )
            ),
            
        ),
    ) );
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Property Submission Page', 'wpresidence-core' ),
        'id'         => 'property_submission_page_tab',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wp_estate_enable_autocomplete',
                'type'     => 'button_set',
                'title'    => __( 'Enable Autocomplete in Front End Submission Form', 'wpresidence-core' ),
                'subtitle' => __( 'If yes, the address field in front end submission form uses Google Places or Open Street autocomplete, a choice you make in Map Settings. ', 'wpresidence-core' ),
                'options'  => array(
                    'yes' => 'yes',
                    'no'  => 'no'
                    ),
                'default'  => 'no',
            ),
            array(
                'id'       => 'wp_estate_submission_page_fields',
                'type'     => 'wpestate_select',
                'multi'     =>  true,   
                'title'    =>   __( 'Select the Fields for listing submission.', 'wpresidence-core' ),
                'subtitle' =>   __( 'Use CTRL to select multiple fields for listing submission page.', 'wpresidence-core' ),
                'options'   =>   wpestate_return_all_fields(),
                'default'   =>   wpestate_return_all_fields(),
            ),
            array(
                'id'       => 'wp_estate_mandatory_page_fields',
                'type'     => 'wpestate_select',
                'multi'     =>  true,
                'title'    =>   __( 'Select the Mandatory Fields for listing submission.', 'wpresidence-core' ),
                'subtitle' =>   __( 'Make sure the mandatory fields for listing submission page are part of submit form (managed from the above setting). Use CTRL for multiple fields select.', 'wpresidence-core' ),
                'options'   =>  array(),
            ),
        ),
    ) );
    
    
      Redux::setSection( $opt_name, array(
        'title'      => __( 'PayPal Settings', 'wpresidence-core' ),
        'id'         => 'paypal_settings_tab',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wp_estate_enable_paypal',
                'type'     => 'button_set',
                'title'    => __( 'Enable Paypal', 'wpresidence-core' ),
                'subtitle' => __( 'You can enable or disable PayPal buttons.', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes',
                            'no'  => 'no'
                    ),
                'default' => 'no'
            ),
            
            array(
                'id'       => 'wp_estate_paypal_client_id',
                'type'     => 'text',
                'required' => array('wp_estate_enable_paypal','=','yes'),
                'title'    => __( 'Paypal Client id', 'wpresidence-core' ),
                'subtitle' => __( 'PayPal business account is required. Info is taken from https://developer.paypal.com/. See help: ', 'wpresidence-core' ).'<a href="http://help.wpresidence.net/article/paypal-set-up/" target="_blank">http://help.wpresidence.net/article/paypal-set-up/</a>',
            ),
            
            array(
                'id'       => 'wp_estate_paypal_client_secret',
                'type'     => 'text',
                'required' => array('wp_estate_enable_paypal','=','yes'),
                'title'    => __( 'Paypal Client Secret Key', 'wpresidence-core' ),
                'subtitle' => __( 'Info is taken from https://developer.paypal.com/', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_paypal_rec_email',
                'type'     => 'text',
                'required' => array('wp_estate_enable_paypal','=','yes'),
                'title'    => __( 'Paypal receiving email', 'wpresidence-core' ),
                'subtitle' => __( 'Info is taken from https://www.paypal.com/ or http://sandbox.paypal.com/', 'wpresidence-core' ),
            ),
            
        ),
    ) );
      
      
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Stripe Settings', 'wpresidence-core' ),
        'id'         => 'stripe_settings_tab',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wp_estate_enable_stripe',
                'type'     => 'button_set',
                'title'    => __( 'Enable Stripe', 'wpresidence-core' ),
                'subtitle' => __( 'You can enable or disable Stripe buttons.', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes',
                            'no'  => 'no'
                    ),
                'default' => 'no'
            ),
            
            array(
                'id'       => 'wp_estate_stripe_secret_key',
                'required' => array('wp_estate_enable_stripe','=','yes'),
                'type'     => 'text',
                'title'    => __( 'Stripe Secret Key', 'wpresidence-core' ),
                'subtitle' => __( 'Info is taken from your account at https://dashboard.stripe.com/login See help: ', 'wpresidence-core' ).'<a href="http://help.wpresidence.net/article/stripe-set-up/" target="_blank">http://help.wpresidence.net/article/stripe-set-up/</a>',
            ),
            
            array(
                'id'       => 'wp_estate_stripe_publishable_key',
                'required' => array('wp_estate_enable_stripe','=','yes'),
                'type'     => 'text',
                'title'    => __( 'Stripe Publishable Key', 'wpresidence-core' ),
                'subtitle' => __( 'Info is taken from your account at https://dashboard.stripe.com/login See help: ', 'wpresidence-core' ).'<a href="http://help.wpresidence.net/article/stripe-set-up/" target="_blank">http://help.wpresidence.net/article/stripe-set-up/</a>',
            ),
        ),
    ) );
    
     // -> START Search Selection
    Redux::setSection( $opt_name, array(
        'title' => __( 'Search', 'wpresidence-core' ),
        'id'    => 'advanced_search_settings_sidebar',
        'icon'  => 'el el-search'
    ) ); 
    
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Advanced Search Settings', 'wpresidence-core' ),
        'id'         => 'advanced_search_settings_tab',
        'subsection' => true,
        'fields'     => array(
            array(
                'id'       => 'wp_estate_adv_search_type',
                'type'     => 'button_set',
                'title'    => __( 'Advanced Search Type ?', 'wpresidence-core' ),
                'subtitle' => __( 'This applies for the search over header type. IMPORTANT! Enable Advanced Search Custom Fields - YES, for Type 5, Type 6, Type 8, Type 10 and Type 11. Types 7 & 9 look can be obtained with type 6 and 8 with float form set to yes.', 'wpresidence-core' ),
                'options'  => array(
                            '1' => 'Type 1',
                            '2' => 'Type 2',
                            '3' => 'Type 3',
                            '4' => 'Type 4',
                            '5' => 'Type 5',
                            '6' => 'Type 6',
                            '7-obsolete' => 'Type 7-obsolete',
                            '8' => 'Type 8',
                            '9-obsolete' => 'Type 9-obsolete',
                            '10' => 'Type 10',
                            '11' => 'Type 11'
                    ),
                'default' => '1'
            ),
            
            array(
                'id'       => 'wp_estate_show_adv_search_general',
                'type'     => 'button_set',
                'title'    => __( 'Show Advanced Search ?', 'wpresidence-core' ),
                'subtitle' => __( 'Disables or enables the display of advanced search', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes',
                            'no'  => 'no'
                    ),
                'default' => 'yes'
            ),
            
            array(
                'id'       => 'wp_estate_show_empty_city',
                'type'     => 'button_set',
                'title'    => __( 'Show Property Categories with 0 properties in advanced search and properties list filters.', 'wpresidence-core' ),
                'subtitle' => __( 'Applies for Categories, Types, States, Cities and Areas dropdowns.', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes',
                            'no'  => 'no'
                    ),
                'default' => 'no'
            ),
            
            array(
                'id'       => 'wp_estate_show_adv_search_tax',
                'type'     => 'button_set',
                'title'    => __( 'Show Advanced Search in Taxonomies, Categories or Archives', 'wpresidence-core' ),
                'subtitle' => __( 'Disables or enables the display of advanced search in taxonomies, categories and archives', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes',
                            'no'  => 'no'
                    ),
                'default' => 'yes'
            ),
            
            array(
                'id'       => 'wp_estate_show_adv_search_visible',
                'type'     => 'button_set',
                'title'    => __( 'Keep Advanced Search visible? (*only for Type 1,3 and 4)', 'wpresidence-core' ),
                'subtitle' => __( 'If no, advanced search over header will display in closed position by default.', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes',
                            'no'  => 'no'
                    ),
                'default' => 'yes'
            ),
            
            array(
                'id'       => 'wp_estate_show_adv_search_extended',
                'type'     => 'button_set',
                'title'    => __( 'Show Amenities and Features fields?', 'wpresidence-core' ),
                'subtitle' => __( 'Select what features from Advanced Search Form. *for speed reasons, the "features checkboxes" will not filter the pins on the map', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes',
                            'no'  => 'no'
                    ),
                'default' => 'no'
            ),
            
            array(
                'id'       => 'wp_estate_advanced_exteded',
                'type'     => 'wpestate_select',
                'required' => array('wp_estate_show_adv_search_extended','=','yes'),
                'multi'    => true,
                'title'    => __( 'Amenities and Features for Advanced Search', 'wpresidence-core' ),
                'subtitle' => __( 'Select which features and amenities show in search.', 'wpresidence-core' ),   
                'options'  =>   wpresidence_redux_advanced_exteded(),
            ),
            
            array(
                'id'       => 'wp_estate_show_dropdowns',
                'type'     => 'button_set',
                'title'    => __( 'Show Dropdowns for beds, bathrooms or rooms?(*only works with Custom Fields - YES)', 'wpresidence-core' ),
                'subtitle' => __( 'Custom Fields are enabled and set from Advanced Search Form.', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes',
                            'no'  => 'no'
                    ),
                'default' => 'yes'
            ),
            
            array(
                'id'       => 'wp_estate_show_slider_price',
                'type'     => 'button_set',
                'title'    => __( 'Show Slider for Price?', 'wpresidence-core' ),
                'subtitle' => __( 'If no, price field can still be used in search and it will be input type.', 'wpresidence-core' ),
                'options'  => array(
                            'yes' => 'yes',
                            'no'  => 'no'
                    ),
                'default' => 'yes'
            ),
            
            array(
                'id'       => 'wp_estate_show_slider_min_price',
                'type'     => 'text',
                'title'    => __( 'Minimum value for Price Slider', 'wpresidence-core' ),
                'subtitle' => __( 'Type only numbers!', 'wpresidence-core' ),
                'default'  => '0'
            ),
            array(
                'id'       => 'wp_estate_show_slider_max_price',
                'type'     => 'text',
                'title'    => __( 'Maximum value for Price Slider', 'wpresidence-core' ),
                'subtitle' => __( 'Type only numbers!', 'wpresidence-core' ),
                'default'  => '1500000'
            ),
            
        ),
    ) );
    
    $tax_array      =array( 'none'                      =>esc_html__('none','wpresidence-core'),
                            'property_category'         =>esc_html__('Categories','wpresidence-core'),
                            'property_action_category'  =>esc_html__('Action Categories','wpresidence-core'),
                            'property_city'             =>esc_html__('City','wpresidence-core'),
                            'property_area'             =>esc_html__('Area','wpresidence-core'),
                            'property_county_state'     =>esc_html__('County State','wpresidence-core'),
                            );
      
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Advanced Search Form', 'wpresidence-core' ),
        'id'         => 'advanced_search_form_tab',
        'subsection' => true,
        'fields'     => array(
             array(
                'id'       => 'wp_estate_custom_advanced_search',
                'type'     => 'button_set',
                'title'    => __( 'Use Custom Fields For Advanced Search ?', 'wpresidence-core' ),
                'subtitle' => __( 'If yes, you can set your own custom fields in the spots available. See this help for correct setup: ', 'wpresidence-core' ).'<a href="http://help.wpresidence.net/article/adv-search-custom-fields-setup/" target=_blank>http://help.wpresidence.net/article/adv-search-custom-fields-setup/</a>',
                'options'  => array(
                            'no'  => 'no',
                            'yes' => 'yes'
                    ),
                'default' => 'no'
            ),
            
            array(
                'id'       => 'wp_estate_search_on_start',
                'type'     => 'button_set',
                'title'    => __( 'Put Search form before the header media ?', 'wpresidence-core' ),
                'subtitle' => __( 'Works with "Use FLoat Form" options set to no ! Doesn\'t apply to search type 3.', 'wpresidence-core' ),
                'options'  => array(
                            'no'  => 'no',
                            'yes' => 'yes'
                    ),
                'default' => 'no'
            ),
            
            array(
                'id'       => 'wp_estate_sticky_search',
                'type'     => 'button_set',
                'title'    => __( 'Use sticky search ?', 'wpresidence-core' ),
                'subtitle' => __( 'This will replace the sticky header. Doesn\'t apply to search type 3', 'wpresidence-core' ),
                'options'  => array(
                            'no'  => 'no',
                            'yes' => 'yes'
                    ),
                'default' => 'no'
            ),
            
            array(
                'id'       => 'wp_estate_use_float_search_form',
                'type'     => 'button_set',
                'title'    => __( 'Use Float Search Form ?', 'wpresidence-core' ),
                'subtitle' => __( 'The search form is "floating" over the media header and you set the position.', 'wpresidence-core' ),
                'options'  => array(
                            'no'  => 'no',
                            'yes' => 'yes'
                    ),
                'default' => 'no'
            ),
            
            array(
                'id'       => 'wp_estate_float_form_top',
                'required' => array('wp_estate_use_float_search_form','=','yes'),
                'type'     => 'text',
                'title'    => __( 'Distance betwen search form and the top margin of the browser: Ex 200px or 20%', 'wpresidence-core' ),
                'subtitle' => __( 'Distance betwen search form and the top margin of the browser: Ex 200px or 20%.', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_float_form_top_tax',
                'required' => array('wp_estate_use_float_search_form','=','yes'),
                'type'     => 'text',
                'title'    => __( 'Distance betwen search form and the top margin of the browser in px Ex 200px or 20% - for taxonomy, category and archives pages', 'wpresidence-core' ),
                'subtitle' => __( 'Distance betwen search form and the top margin of the browser in px Ex 200px or 20% - for taxonomy, category and archives pages.', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_adv_search_fields_no',
                'type'     => 'text',
                'title'    => __( 'No of Search fields', 'wpresidence-core' ),
                'subtitle' => __( 'No of Search fields.', 'wpresidence-core' ),
                'default'  => '8'
            ),
            
            array(
                'id'       => 'wp_estate_search_fields_no_per_row',
                'type'     => 'text',
                'title'    => __( 'No of Search fields per row', 'wpresidence-core' ),
                'subtitle' => __( 'No of Search fields per row (Possible values: 1,2,3,4).', 'wpresidence-core' ),
                'default'  => '4'
            ),
            
            array(
                'id'       => 'wp_estate_adv6_taxonomy',
                'type'     => 'select',
                'title'    => __( 'Select Taxonomy for tabs options in Advanced Search Type 6, Type 7, Type 8, Type 9', 'wpresidence-core' ),
                'subtitle' => __( 'No of Search fields per row (Possible values: 1,2,3,4).', 'wpresidence-core' ),
                'options'  => $tax_array   
            ),
            array(
                'id'       => 'wp_estate_adv6_taxonomy_terms',
                'type'     => 'wpestate_taxonomy_tabs',
                'title'    => __( 'Select Taxonomy Terms for tabs options in Advanced Search Type 6, Type 7, Type 8, Type 9', 'wpresidence-core' ),
                'subtitle' => __( 'This applies for  the search over media header', 'wpresidence-core' ),
             
            ),
            array(
                'id'       => 'wp_estate_adv6_min_price',
                'type'     => 'wpestate_taxonomy_tabs_price',
                'full_width' => true,
                'title'    => __( 'Price Slider Minimum values for advanced search with tabs', 'wpresidence-core' ),
            ),
            array(
                'id'       => 'wp_estate_adv6_max_price',
                'type'     => 'wpestate_taxonomy_tabs_price',
                'full_width' => true,
                'title'    => __( 'Price Slider Maximum values for advanced search with tabs', 'wpresidence-core' ),
            ),
            
            array(
               'id'       => 'wpestate_set_search',
               'type'     => 'wpestate_set_search',
               'title'    => __( 'Search Custom Fields Setup', 'wpresidence-core' ),
               'full_width' => true,
            ),
            
        ),
    ) );
    
     
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Geo Location Search', 'wpresidence-core' ),
        'id'         => 'geo_location_search_tab',
        'subsection' => true,
        'fields'     => array(
           array(
                'id'       => 'wp_estate_use_geo_location',
                'type'     => 'button_set',
                'title'    => __( 'Use Geo Location Search', 'wpresidence-core'),
                'subtitle' => __( 'If YES, the geo location search will appear above half map search fields', 'wpresidence-core' ),
                'default'  => 'no',
                'options'  =>array( 
                            'no'   => 'no',
                            'yes'   => 'yes',
                            ),
            ),
            
            array(
                'id'       => 'wp_estate_initial_radius',
                'type'     => 'text',
                'title'    => __( 'Initial area radius', 'wpresidence-core' ),
                'subtitle' => __( 'Initial area radius. Use only numbers.', 'wpresidence-core' ),
                'default' => '12'
            ),
            
            array(
                'id'       => 'wp_estate_min_geo_radius',
                'type'     => 'text',
                'title'    => __( 'Minimum radius value', 'wpresidence-core' ),
                'subtitle' => __( 'Minimum radius value. Use only numbers.', 'wpresidence-core' ),
                'default' => '1'
            ),
            
            array(
                'id'       => 'wp_estate_max_geo_radius',
                'type'     => 'text',
                'title'    => __( 'Maximum radius value', 'wpresidence-core' ),
                'subtitle' => __( 'Maximum radius value. Use only numbers.', 'wpresidence-core' ),
                'default' => '50'
            ),
            
            array(
                'id'       => 'wp_estate_geo_radius_measure',
                'type'     => 'button_set',
                'title'    => __( 'Show Geo Location Search in:', 'wpresidence-core' ),
                'subtitle' => __( 'Select between miles and kilometers.', 'wpresidence-core' ),
                'default'  => 'miles',
                'options'  =>array ( 
                           'miles' =>  __('miles','wpresidence-core'),
                           'km'    =>  __('km','wpresidence-core') 
                            ),
            ),
  
        ),
    ) ); 
    
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Save Search Settings', 'wpresidence-core' ),
        'id'         => 'save_search_tab',
        'subsection' => true,
        'fields'     => array(        
            array(
                'id'       => 'wp_estate_show_save_search',
                'type'     => 'button_set',
                'title'    => __( 'Use Saved Search Feature ?', 'wpresidence-core' ),
                'subtitle' => __( 'If YES, user can save his searchs from Advanced Search Results, if he is logged in with a registered account.', 'wpresidence-core' ),
                'options'  =>array ( 
                           'yes' => 'yes',
                           'no'  => 'no' 
                            ),
                'default'  => 'no',
            ),
            
            array(
                'id'       => 'wp_estate_search_alert',
                'type'     => 'button_set',
                'title'    => __( 'Send emails', 'wpresidence-core' ),
                'subtitle' => __( 'Send weekly or daily an email alert with new published properties matching user saved search', 'wpresidence-core' ),
                'options'  =>array ( 
                           0 => 'daily',
                           1 => 'weekly' 
                            ),
                'default'  => 1,
            ),           
        ),
    ) ); 
    
    Redux::setSection( $opt_name, array(
        'title'      => __( 'Advanced Search Colors', 'wpresidence-core' ),
        'id'         => 'advanced_search_colors_tab',
        'subsection' => true,
        'fields'     => array(         
            array(
                'id'       => 'wp_estate_adv_back_color',
                'type'     => 'color',
                'title'    => __( 'Advanced Search Background Color', 'wpresidence-core' ),
                'subtitle' => __( 'Advanced Search Background Color', 'wpresidence-core' ),
                'transparent'  => false,
            ),
            
            array(
                'id'       => 'wp_estate_adv_back_color_opacity',
                'type'     => 'text',
                'title'    => __( 'Advanced Search Background color Opacity', 'wpresidence-core' ),
                'subtitle' => __( 'Values between 0 -invisible and 1 - fully visible', 'wpresidence-core' ),
            ),
            
            array(
                'id'       => 'wp_estate_adv_font_color',
                'type'     => 'color',
                'title'    => __( 'Advanced Search Font Color', 'wpresidence-core' ),
                'subtitle' => __( 'Advanced Search Font Color', 'wpresidence-core' ),
                'transparent'  => false,
            ),
            
            array(
                'id'       => 'wp_estate_adv_search_back_color',
                'type'     => 'color',
                'title'    => __( 'Map Advanced Search Button Background Color', 'wpresidence-core' ),
                'subtitle' => __( 'Map Advanced Search Button Background Color', 'wpresidence-core' ),
                'transparent'  => false,
            ),
            
            array(
                'id'       => 'wp_estate_adv_search_font_color',
                'type'     => 'color',
                'title'    => __( 'Advanced Search Fields Font Color', 'wpresidence-core' ),
                'subtitle' => __( 'Advanced Search Fields Font Color', 'wpresidence-core' ),
                'transparent'  => false,
            ),
            
        ),
    ) ); 
    
    
    // -> START help Selection
    Redux::setSection( $opt_name, array(
        'title' => __( 'Help & Custom', 'wpresidence-core' ),
        'id'    => 'help_custom_sidebar',
        'icon'  => 'el el-question',
        'fields'     => array(
            array(
                'id'     => 'opt-info-normal',
                'type'   => 'info',
                'notice' => false,
                'desc'   => __( 'For support please go to ', 'wpresidence-core' ).'< a href="http://support.wpestate.org/" target="_blank"> http://support.wpestate.org/ </a>'.__( 'create an account and post a ticket. The registration is simple and as soon as you post we are notified. We usually answer in the next 24h (except weekends). Please use this system and not the email. It will help us answer much faster. Thank you! ', 'wpresidence-core' )
                .'<br /><br />'.__( 'For custom work on this theme please go to ', 'wpresidence-core' ) .'< a href="http://support.wpestate.org/" target="_blank"> http://support.wpestate.org/ </a>'.__( ', create a ticket with your request and we will offer a free quote. ', 'wpresidence-core' )
                .'<br /><br />'.__( 'For help files please go to ', 'wpresidence-core' ) .'< a href="http://help.wpresidence.net/" target="_blank"> http://help.wpresidence.net/</a>'
                .'<br /><br />'.__( 'Subscribe to our mailing list in order to receive news about new features and theme upgrades ', 'wpresidence-core' ) .'< a href="http://eepurl.com/CP5U5" target="_blank"> Subscribe Here!</a>'
            ),
        ),
    ) );  
    
   
    
    
    
    /*
     * <--- END SECTIONS
     */

    
  
    /*
     *
     * YOU MUST PREFIX THE FUNCTIONS BELOW AND ACTION FUNCTION CALLS OR ANY OTHER CONFIG MAY OVERRIDE YOUR CODE.
     *
     */

    /*
    *
    * --> Action hook examples
    *
    */

    // If Redux is running as a plugin, this will remove the demo notice and links
    //add_action( 'redux/loaded', 'remove_demo' );

    // Function to test the compiler hook and demo CSS output.
    // Above 10 is a priority, but 2 in necessary to include the dynamically generated CSS to be sent to the function.
    //add_filter('redux/options/' . $opt_name . '/compiler', 'compiler_action', 10, 3);

    // Change the arguments after they've been declared, but before the panel is created
    //add_filter('redux/options/' . $opt_name . '/args', 'change_arguments' );

    // Change the default value of a field after it's been set, but before it's been useds
    //add_filter('redux/options/' . $opt_name . '/defaults', 'change_defaults' );

    // Dynamically add a section. Can be also used to modify sections/fields
    //add_filter('redux/options/' . $opt_name . '/sections', 'dynamic_section');

    /**
     * This is a test function that will let you see when the compiler hook occurs.
     * It only runs if a field    set with compiler=>true is changed.
     * */
    if ( ! function_exists( 'compiler_action' ) ) {
        function compiler_action( $options, $css, $changed_values ) {
            echo '<h1>The compiler hook has run!</h1>';
            echo "<pre>";
            print_r( $changed_values ); // Values that have changed since the last save
            echo "</pre>";
            //print_r($options); //Option values
            //print_r($css); // Compiler selector CSS values  compiler => array( CSS SELECTORS )
        }
    }

    /**
     * Custom function for the callback validation referenced above
     * */
    if ( ! function_exists( 'redux_validate_callback_function' ) ) {
        function redux_validate_callback_function( $field, $value, $existing_value ) {
            $error   = false;
            $warning = false;

            //do your validation
            if ( $value == 1 ) {
                $error = true;
                $value = $existing_value;
            } elseif ( $value == 2 ) {
                $warning = true;
                $value   = $existing_value;
            }

            $return['value'] = $value;

            if ( $error == true ) {
                $field['msg']    = 'your custom error message';
                $return['error'] = $field;
            }

            if ( $warning == true ) {
                $field['msg']      = 'your custom warning message';
                $return['warning'] = $field;
            }

            return $return;
        }
    }

    /**
     * Custom function for the callback referenced above
     */
    if ( ! function_exists( 'redux_my_custom_field' ) ) {
        function redux_my_custom_field( $field, $value ) {
            print_r( $field );
            echo '<br/>';
            print_r( $value );
        }
    }

    /**
     * Custom function for filtering the sections array. Good for child themes to override or add to the sections.
     * Simply include this function in the child themes functions.php file.
     * NOTE: the defined constants for URLs, and directories will NOT be available at this point in a child theme,
     * so you must use get_template_directory_uri() if you want to use any of the built in icons
     * */
    if ( ! function_exists( 'dynamic_section' ) ) {
        function dynamic_section( $sections ) {
            //$sections = array();
            $sections[] = array(
                'title'  => __( 'Section via hook', 'redux-framework-demo' ),
                'desc'   => __( '<p class="description">This is a section created by adding a filter to the sections array. Can be used by child themes to add/remove sections from the options.</p>', 'redux-framework-demo' ),
                'icon'   => 'el el-paper-clip',
                // Leave this as a blank section, no options just some intro text set above.
                'fields' => array()
            );

            return $sections;
        }
    }

    /**
     * Filter hook for filtering the args. Good for child themes to override or add to the args array. Can also be used in other functions.
     * */
    if ( ! function_exists( 'change_arguments' ) ) {
        function change_arguments( $args ) {
            //$args['dev_mode'] = true;

            return $args;
        }
    }

    /**
     * Filter hook for filtering the default value of any given field. Very useful in development mode.
     * */
    if ( ! function_exists( 'change_defaults' ) ) {
        function change_defaults( $defaults ) {
            $defaults['str_replace'] = 'Testing filter hook!';

            return $defaults;
        }
    }

    /**
     * Removes the demo link and the notice of integrated demo from the redux-framework plugin
     */
    if ( ! function_exists( 'remove_demo' ) ) {
        function remove_demo() {
            // Used to hide the demo mode link from the plugin page. Only used when Redux is a plugin.
            if ( class_exists( 'ReduxFrameworkPlugin' ) ) {
                remove_filter( 'plugin_row_meta', array(
                    ReduxFrameworkPlugin::instance(),
                    'plugin_metalinks'
                ), null, 2 );

                // Used to hide the activation notice informing users of the demo panel. Only used when Redux is a plugin.
                remove_action( 'admin_notices', array( ReduxFrameworkPlugin::instance(), 'admin_notices' ) );
            }
        }
    }

