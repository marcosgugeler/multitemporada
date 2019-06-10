<?php 
$current_user           =   wp_get_current_user();
$userID                 =   $current_user->ID;
$user_login             =   $current_user->user_login;  
$user_agent_id          =   intval( get_user_meta($userID,'user_agent_id',true));
$add_link               =   wpestate_get_template_link('user_dashboard_add.php');
$add_agent              =   wpestate_get_template_link('user_dashboard_add_agent.php');
$dash_profile           =   wpestate_get_template_link('user_dashboard_profile.php');
$dash_favorite          =   wpestate_get_template_link('user_dashboard_favorite.php');
$dash_link              =   wpestate_get_template_link('user_dashboard.php');
$agent_list_link        =   wpestate_get_template_link('user_dashboard_agent_list.php');
$dash_searches          =   wpestate_get_template_link('user_dashboard_searches.php');
$dash_showing           =   wpestate_get_template_link('user_dashboard_showing.php');
$activeprofile          =   '';
$activedash             =   '';
$activeadd              =   '';
$activefav              =   '';
$activesearch           =   '';
$activeinvoices         =   '';
$user_pack              =   get_the_author_meta( 'package_id' , $userID );    
$clientId               =   esc_html( wpresidence_get_option('wp_estate_paypal_client_id','') );
$clientSecret           =   esc_html( wpresidence_get_option('wp_estate_paypal_client_secret','') );  
$user_registered        =   get_the_author_meta( 'user_registered' , $userID );
$user_package_activation=   get_the_author_meta( 'package_activation' , $userID );
$home_url               =   esc_url(home_url('/'));
$dash_invoices          =   wpestate_get_template_link('user_dashboard_invoices.php');
$dash_inbox             =   wpestate_get_template_link('user_dashboard_inbox.php');
$activeinbox            =   '';
$activeshowing          =   '';
$activeaddagent         =   '';
$activeagentlist        =   '';

if ( basename( get_page_template() ) == 'user_dashboard.php' ){
    $activedash  =   'user_tab_active';    
}else if ( basename( get_page_template() ) == 'user_dashboard_add.php' ){
    $activeadd   =   'user_tab_active';
}else if ( basename( get_page_template() ) == 'user_dashboard_profile.php' ){
    $activeprofile   =   'user_tab_active';
}else if ( basename( get_page_template() ) == 'user_dashboard_favorite.php' ){
    $activefav   =   'user_tab_active';
}else if( basename( get_page_template() ) == 'user_dashboard_searches.php' ){
    $activesearch  =   'user_tab_active';
}else if( basename( get_page_template() ) == 'user_dashboard_invoices.php' ){
    $activeinvoices  =   'user_tab_active';
}else if( basename( get_page_template() ) == 'user_dashboard_add_agent.php' ){
    $activeaddagent =   'user_tab_active';
}else if( basename( get_page_template() ) == 'user_dashboard_agent_list.php' ){
    $activeagentlist =   'user_tab_active';
}else if( basename( get_page_template() ) == 'user_dashboard_inbox.php' ){
    $activeinbox =   'user_tab_active';
}else if( basename( get_page_template() ) == 'user_dashboard_showing.php' ){
    $activeshowing =   'user_tab_active';
} 
$no_unread  =  intval(get_user_meta($userID,'unread_mess',true));   
$user_role  = get_user_meta( $current_user->ID, 'user_estate_role', true) ;

if ( $user_agent_id!=0 && get_post_status($user_agent_id)=='pending'  ){
    echo '<div class="user_dashboard_app">'.esc_html__('Your account is pending approval. Please wait for admin to approve it. ','wpresidence').'</div>';
}
if ( $user_agent_id!=0 && get_post_status($user_agent_id)=='disabled' ){
    echo '<div class="user_dashboard_app">'.esc_html__('Your account is disabled.','wpresidence').'</div>';
}
?>

<div class="user_tab_menu">

    <div class="user_dashboard_links">
        <?php if( $dash_profile!=$home_url && $dash_profile!=''){ ?>
            <a href="<?php print esc_url($dash_profile);?>"  class="<?php print esc_attr($activeprofile); ?>"><i class="fa fa-cog"></i> <?php esc_html_e('My Profile','wpresidence');?></a>
        <?php } ?>
        <?php 
        if( $dash_link!=$home_url && $dash_link!=''){
            if($user_agent_id==0 || ( $user_agent_id!=0 && get_post_status($user_agent_id)!='pending' && get_post_status($user_agent_id)!='disabled') ){?>
            <a href="<?php print esc_url($dash_link);?>"     class="<?php print esc_attr($activedash); ?>"> <i class="fa fa-map-marker"></i> <?php esc_html_e('My Properties List','wpresidence');?></a>
        <?php } 
        }?>
        <?php if( $add_link!=$home_url && $add_link!=''){
            if($user_agent_id==0 || ( $user_agent_id!=0 && get_post_status($user_agent_id)!='pending' && get_post_status($user_agent_id)!='disabled') ){?>
            <a href="<?php print esc_url ($add_link);?>"      class="<?php print esc_attr($activeadd); ?>"> <i class="fa fa-plus"></i><?php esc_html_e('Add New Property','wpresidence');?></a>  
        <?php }
            } 
      
        if($user_role==3 || $user_role ==4){
            if( $user_agent_id!=0 && get_post_status($user_agent_id)!='pending'){
            ?>
            <a href="<?php print esc_url ($add_agent);?>"            class="<?php print esc_attr($activeaddagent); ?>"> <i class="fa fa-user-plus"></i><?php esc_html_e('Add New Agent','wpresidence');?></a>  
            <a href="<?php print esc_url ($agent_list_link);?>"      class="<?php print esc_attr($activeagentlist); ?>"> <i class="fa fa-user"></i><?php esc_html_e('Agent list','wpresidence');?></a>  
            
        <?php
            }
        }
        ?>
        <?php if( $dash_favorite!=$home_url && $dash_favorite!=''){ ?>
            <a href="<?php print esc_url($dash_favorite);?>" class="<?php print esc_attr($activefav); ?>"><i class="fa fa-heart"></i> <?php esc_html_e('Favorites','wpresidence');?></a>
        <?php } ?>
        <?php if( $dash_searches!=$home_url && $dash_searches!=''){ ?>
            <a href="<?php print esc_url($dash_searches);?>" class="<?php print esc_attr($activesearch); ?>"><i class="fa fa-search"></i> <?php esc_html_e('Saved Searches','wpresidence');?></a>
        <?php } 
        if( $dash_invoices!=$home_url && $dash_invoices!=''){ ?>
            <a href="<?php print esc_url($dash_invoices);?>" class="<?php print esc_attr($activeinvoices); ?>"><i class="fa fa-file-text-o"></i> <?php esc_html_e('My Invoices','wpresidence');?></a>
        <?php } 
        if($dash_inbox!=$home_url && $dash_inbox!=''){ ?>
            <a href="<?php print esc_url($dash_inbox);?>" class="<?php print esc_attr($activeinbox); ?>"><i class="fa fa-envelope-o"></i> 
                <?php esc_html_e('Inbox','wpresidence'); 
                    if  ($no_unread>0){
                        echo '<div class="unread_mess">'.intval($no_unread).'</div>';
                    }
                ?>
            </a>
        <?php }
        if( $dash_showing!=$home_url && $dash_showing!=''){ ?>
            <a href="<?php print esc_url($dash_showing);?>" class="<?php print esc_attr($activeshowing); ?>"><i class="fa fa-file-text-o"></i> <?php esc_html_e('Calendar','wpresidence');?></a>
        <?php } ?>
            
        <a href="<?php echo wp_logout_url( esc_url(home_url('/') ) );?>" title="Logout"><i class="fa fa-power-off"></i> <?php esc_html_e('Log Out','wpresidence');?></a>
    </div>
</div>