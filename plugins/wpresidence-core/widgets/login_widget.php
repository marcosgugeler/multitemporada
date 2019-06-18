<?php
class Login_widget extends WP_Widget {
	function __construct(){
	//function Login_widget(){
		$widget_ops = array('classname' => 'loginwd_sidebar boxed_widget', 'description' => 'Put the login & register form on sidebar');
		$control_ops = array('id_base' => 'login_widget');
		//$this->WP_Widget('login_widget', 'Wp Estate: Login & Register', $widget_ops, $control_ops);
                parent::__construct('login_widget', 'Wp Estate: Login & Register', $widget_ops, $control_ops);
	}
	
	function form($instance){
		$defaults = array();
		$instance = wp_parse_args((array) $instance, $defaults);
		$display='';
		print $display;
	}


	function update($new_instance, $old_instance){
		$instance = $old_instance;
		return $instance;
	}



	function widget($args, $instance){
		extract($args);
                $display='';
		global $post;
              
		print $before_widget;
                $facebook_status    =   esc_html( wpresidence_get_option('wp_estate_facebook_login','') );
                $google_status      =   esc_html( wpresidence_get_option('wp_estate_google_login','') );
                $yahoo_status       =   esc_html( wpresidence_get_option('wp_estate_yahoo_login','') );
		$mess='';
		$display.='
                <div class="login_sidebar">
                    <h3 class="widget-title-sidebar"  id="login-div-title">'.esc_html__('Login','wpresidence-core').'</h3>
                    <div class="login_form" id="login-div">
                        <div class="loginalert" id="login_message_area_wd" >'.$mess.'</div>
                            
                        <input type="text" class="form-control" name="log" id="login_user_wd" placeholder="'.esc_html__('Username','wpresidence-core').'"/>
                        <input type="password" class="form-control" name="pwd" id="login_pwd_wd" placeholder="'.esc_html__('Password','wpresidence-core').'"/>                       
                        <input type="hidden" name="loginpop" id="loginpop_wd" value="0">
                      
                        <input type="hidden" id="security-login" name="security-login" value="'. estate_create_onetime_nonce( 'login_ajax_nonce' ).'">
       
                   
                        <button class="wpresidence_button" id="wp-login-but-wd" >'.esc_html__('Login','wpresidence-core').'</button>
                        
                        <div class="login-links">
                            <a href="#" id="widget_register_sw">'.esc_html__('Need an account? Register here!','wpresidence-core').'</a>
                            <a href="#" id="forgot_pass_widget">'.esc_html__('Forgot Password?','wpresidence-core').'</a>';
                       
                            global $wpestate_social_login;
                            if(class_exists('Wpestate_Social_Login')){
                                $display.=   $wpestate_social_login->display_form('',1);
                            }
                    $display.='
                        </div>    
                    </div>
                
              <h3 class="widget-title-sidebar"  id="register-div-title">'.esc_html__('Register','wpresidence-core').'</h3>
                <div class="login_form" id="register-div">
                    <div class="loginalert" id="register_message_area_wd" ></div>
                    <input type="text" name="user_login_register" id="user_login_register_wd" class="form-control" placeholder="'.esc_html__('Username','wpresidence-core').'"/>
                    <input type="text" name="user_email_register" id="user_email_register_wd" class="form-control" placeholder="'.esc_html__('Email','wpresidence-core').'"  />';
                    
                    $enable_user_pass_status= esc_html ( wpresidence_get_option('wp_estate_enable_user_pass','') );
                    if($enable_user_pass_status == 'yes'){
                        $display.= ' <input type="password" name="user_password_wd" id="user_password_wd" class="form-control" placeholder="'.esc_html__('Password','wpresidence-core').'"/>
                        <input type="password" name="user_password_retype_wd" id="user_password_wd_retype" class="form-control" placeholder="'.esc_html__('Retype Password','wpresidence-core').'"  />
                        ';
                    }
                    
                    if(1==1){
                    $user_types = array(
                        esc_html__('Select User Type','wpresidence-core'),
                        esc_html__('User','wpresidence-core'),
                        esc_html__('Single Agent','wpresidence-core'),
                        esc_html__('Agency','wpresidence-core'),
                        esc_html__('Developer','wpresidence-core'),
                    );
                    $permited_roles             = wpresidence_get_option('wp_estate_visible_user_role','');
                    $visible_user_role_dropdown = wpresidence_get_option('wp_estate_visible_user_role_dropdown','');
                    
                    
                      if($visible_user_role_dropdown=='yes'){
                            $display.= '<select id="new_user_type_wd" name="new_user_type_wd" class="form-control" >';
                            $display.= '<option value="0">'.esc_html__('Select User Type','wpresidence-core').'</option>';
                            foreach($user_types as $key=>$name){
                                if(in_array($name, $permited_roles)){
                                    $display.= '<option value="'.$key.'">'.$name.'</option>';
                                }
                            }
                            $display.= '</select>';
                        }
                              
                        
                    }

                    $display.='<input type="checkbox" name="terms" id="user_terms_register_wd"><label id="user_terms_register_wd_label" for="user_terms_register_wd">'.esc_html__('I agree with ','wpresidence-core').'<a href="'.wpestate_get_template_link('terms_conditions.php').'" target="_blank" id="user_terms_register_topbar_link">'.esc_html__('terms & conditions','wpresidence-core').'</a> </label>';
                    
                    if(wpresidence_get_option('wp_estate_use_captcha','')=='yes'){
                        $display.= '<div id="widget_register_menu"  style="float:left;transform:scale(0.75);-webkit-transform:scale(0.75);transform-origin:0 0;-webkit-transform-origin:0 0;"></div>';
                    }
                                
                    
                    if($enable_user_pass_status != 'yes'){ 
                        $display.='<p id="reg_passmail">'.esc_html__('A password will be e-mailed to you','wpresidence-core').'</p>';
                    }
                    
                    //wp_nonce_field( 'register_ajax_nonce', 'security-register',false,false ).'
                    $display.= '  
                    <input type="hidden" id="security-register" name="security-register" value="'.estate_create_onetime_nonce( 'register_ajax_nonce' ).'">
           
                    <button class="wpresidence_button" id="wp-submit-register_wd">'.esc_html__('Register','wpresidence-core').'</button>

                    <div class="login-links">
                        <a href="#" id="widget_login_sw">'.esc_html__('Back to Login','wpresidence-core').'</a>                       
                    </div>   
                 </div>
                </div>
                <h3 class="widget-title-sidebar"  id="forgot-div-title_shortcode">'. esc_html__('Reset Password','wpresidence-core').'</h3>
                <div class="login_form" id="forgot-pass-div_shortcode">
                    <div class="loginalert" id="forgot_pass_area_shortcode"></div>
                    <div class="loginrow">
                            <input type="text" class="form-control" name="forgot_email" id="forgot_email_shortcode" placeholder="'.esc_html__('Enter Your Email Address','wpresidence-core').'" size="20" />
                    </div>
                    '. wp_nonce_field( 'login_ajax_nonce_forgot_wd', 'security-login-forgot_wd',true).'  
                    <input type="hidden" id="postid" value="0">    
                    <button class="wpresidence_button" id="wp-forgot-but_shortcode" name="forgot" >'.esc_html__('Reset Password','wpresidence-core').'</button>
                    <div class="login-links shortlog">
                    <a href="#" id="return_login_shortcode">'.esc_html__('Return to Login','wpresidence-core').'</a>
                    </div>
                </div>
            ';
                
                
                $current_user = wp_get_current_user();
                $userID                 =   $current_user->ID;
                $user_login             =   $current_user->user_login;
                $user_email             =   get_the_author_meta( 'user_email' , $userID );
                $activeprofile          =   $activedash = $activeadd = $activefav ='';
                $activeaddagent         =   wpestate_get_template_link('user_dashboard_add_agent.php');
                $activeagentlist        =   wpestate_get_template_link('user_dashboard_agent_list.php');
                $user_role              =   get_user_meta( $current_user->ID, 'user_estate_role', true) ; 
                $add_link               =   wpestate_get_template_link('user_dashboard_add.php');
                $dash_profile           =   wpestate_get_template_link('user_dashboard_profile.php');
                $dash_link              =   wpestate_get_template_link('user_dashboard.php');
                $dash_favorite          =   wpestate_get_template_link('user_dashboard_favorite.php');
                $dash_searches          =   wpestate_get_template_link('user_dashboard_searches.php');
                $home_url               =   esc_url( home_url('/') );
                $dash_invoices          =   wpestate_get_template_link('user_dashboard_invoices.php');
                $dash_inbox             =   wpestate_get_template_link('user_dashboard_inbox.php');
                $no_unread              =   intval(get_user_meta($current_user->ID,'unread_mess',true));
                $no_unread_wd           =   '';
                if( $no_unread>0 ){
                    $no_unread_wd ='<div class="unread_mess">'.$no_unread.'</div>';
                }
                
                $user_agent_id          =   intval( get_user_meta($current_user->ID,'user_agent_id',true));
                
                $logged_display='
                    <h3 class="widget-title-sidebar" >'.esc_html__('Hello ','wpresidence-core'). ' '. $user_login .'  </h3>
                    
                    <ul class="wd_user_menu">';
                    if($home_url!=$dash_profile){
                        $logged_display.='<li> <a href="'.$dash_profile.'"  class="'.$activeprofile.'"><i class="fa fa-cogs"></i>'.esc_html__('My Profile','wpresidence-core').'</a> </li>';
                    }
                    
                    if($home_url!=$dash_link){
                        if($user_agent_id==0 || ( $user_agent_id!=0 && get_post_status($user_agent_id)!='pending' && get_post_status($user_agent_id)!='disabled') ){
                            $logged_display.=' <li> <a href="'.$dash_link.'"     class="'.$activedash.'"><i class="fa fa-map-marker"></i>'.esc_html__('My Properties List','wpresidence-core').'</a> </li>';
                        }
                    }
                    if($home_url!=$add_link){
                        if($user_agent_id==0 || ( $user_agent_id!=0 && get_post_status($user_agent_id)!='pending' && get_post_status($user_agent_id)!='disabled') ){
                            $logged_display.=' <li> <a href="'.$add_link.'"      class="'.$activeadd.'"><i class="fa fa-plus"></i>'. esc_html__('Add New Property','wpresidence-core').'</a> </li>';
                        }      
                    }
                    
                    if($user_role==3 || $user_role ==4){
                        if( $user_agent_id!=0 && get_post_status($user_agent_id)!='pending'){
                            $logged_display.=' <li> <a href="'.$activeaddagent.'"      class="'.$activeadd.'"><i class="fa fa-user-plus"></i>'. esc_html__('Add New Agent','wpresidence-core').'</a> </li>';
                            $logged_display.=' <li> <a href="'.$activeagentlist.'"      class="'.$activeadd.'"><i class="fa fa-user"></i>'. esc_html__('Agent list','wpresidence-core').'</a> </li>';
                        }
                        
                    }

                    if($home_url!=$dash_favorite){
                        $logged_display.=' <li> <a href="'.$dash_favorite.'" class="'.$activefav.'"><i class="fa fa-heart"></i>'.esc_html__('Favorites','wpresidence-core').'</a> </li>';
                    }
                    if($home_url!=$dash_searches){
                        $logged_display.=' <li> <a href="'.$dash_searches.'" class="'.$activefav.'"><i class="fa fa-search"></i>'.esc_html__('Saved Searches','wpresidence-core').'</a> </li>';
                    } 
                    if($home_url!=$dash_invoices){
                        $logged_display.=' <li> <a href="'.$dash_invoices.'" class="'.$activefav.'"><i class="fa fa-file-text-o"></i>'.esc_html__('My Invoices','wpresidence-core').'</a> </li>';
                    }
                    if($home_url!=$dash_inbox){
                        $logged_display.=' <li> <a href="'.$dash_inbox.'" class="'.$activefav.'"><i class="fa fa-envelope-o"></i>'.esc_html__('Inbox','wpresidence-core').'</a>'.$no_unread_wd.'</li>';  
                    }
                       
                        $logged_display.=' <li> <a href="'.wp_logout_url( esc_url( home_url('/') )).'" title="Logout"><i class="fa fa-power-off"></i>'.esc_html__('Log Out','wpresidence-core').'</a> </li>   
                    </ul>
                ';
                
               if ( is_user_logged_in() ) {                   
                  print $logged_display;
               }else{
                  print $display; 
               }
               print $after_widget;
	}

}

?>