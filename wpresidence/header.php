<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1,user-scalable=no">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
 
<?php 
if(is_singular('wpestate_invoice') || is_singular('wpestate_message')){
    print '<meta name="robots" content="noindex">';
}
        
if( !has_site_icon() ){
    print '<link rel="shortcut icon" href="'.get_theme_file_uri('/img/favicon.gif').'" type="image/x-icon" />';
}


wp_head();?>    
</head>



<?php 

$wide_class      =   ' is_boxed ';
$wide_status     =   esc_html(wpresidence_get_option('wp_estate_wide_status',''));
if($wide_status==''){
    $wide_status=1;
}
if($wide_status==1 ||   is_page_template( 'splash_page.php' ) ){
    $wide_class=" wide ";
}

if( isset($post->ID) && wpestate_half_map_conditions ($post->ID) ){
    $wide_class="wide fixed_header ";
}


$halfmap_body_class='';
if( isset($post->ID) && wpestate_half_map_conditions ($post->ID) ){
    $halfmap_body_class=" half_map_body ";
}

if(esc_html ( wpresidence_get_option('wp_estate_show_top_bar_user_menu','') )=="yes"){
    $halfmap_body_class.=" has_top_bar ";
}

$logo_header_type            =   wpresidence_get_option('wp_estate_logo_header_type','');
if($logo_header_type==''){
    $logo_header_type='type1';
}
$wpestate_logo_header_align  =   wpresidence_get_option('wp_estate_logo_header_align','');
$wide_header                 =   wpresidence_get_option('wp_estate_wide_header','');
$wide_header_class           =  '';
if($wide_header=='yes' ||   is_page_template( 'splash_page.php' ) ){
    $wide_header_class=" full_width_header ";
}

$top_menu_hover_type        =   wpresidence_get_option('wp_estate_top_menu_hover_type','');  
$header_transparent_class   =   '';
$header_transparent         =   wpresidence_get_option('wp_estate_header_transparent','');


if(isset($post->ID) && !is_tax() && !is_category() ){
        $header_transparent_page    =   get_post_meta ( $post->ID, 'header_transparent', true);
        if($header_transparent_page=="global" || $header_transparent_page==""){
            if ($header_transparent=='yes'){
                $header_transparent_class=' header_transparent ';
            }
        }else if($header_transparent_page=="yes"){
            $header_transparent_class=' header_transparent ';
        }
}else{
    if ($header_transparent=='yes'){
            $header_transparent_class=' header_transparent ';
    }
}

$logo                       =   wpresidence_get_option('wp_estate_logo_image','url');  
$stikcy_logo_image          =   wpresidence_get_option('wp_estate_stikcy_logo_image','url');
$logo_margin                =   intval( wpresidence_get_option('wp_estate_logo_margin','') );
$transparent_logo           =   esc_html( wpresidence_get_option('wp_estate_transparent_logo_image','url') );
$show_top_bar_user_login    =   esc_html ( wpresidence_get_option('wp_estate_show_top_bar_user_login','') );

if($show_top_bar_user_login==''){
    $show_top_bar_user_login='yes';
}

if( ( trim($header_transparent_class) == 'header_transparent' || is_page_template( 'splash_page.php' ) ) && $transparent_logo!='' ){
    $logo  = $transparent_logo;
}

$text_header_align_select   =  wpresidence_get_option('wp_estate_text_header_align','');
$show_header_dashboard      =  wpresidence_get_option('wp_estate_show_header_dashboard','');

if( wpestate_is_user_dashboard() && $show_header_dashboard=='no'){
    $halfmap_body_class.=" dash_no_header ";
    $logo_header_type='';
}

if(wpestate_is_user_dashboard() && $show_header_dashboard=='yes'){
    $wide_class=" wide ";
    $logo_header_type = "type1  ";
    $wide_header_class=" full_width_header ";
    $header_transparent_class   =   '';
}

$show_top_bar_user_login_class='';
if($show_top_bar_user_login != 'yes'){
    $show_top_bar_user_login_class=" no_user_submit ";
}
$show_submit_symbol    =   esc_html ( wpresidence_get_option('wp_estate_show_submit','') );

$show_submit_symbol_class='';
if($show_submit_symbol!= 'yes'){
    $show_submit_symbol_class=" no_property_submit";
}
?>


<body <?php body_class(); ?>>  
   

<?php get_template_part('templates/mobile_menu' ); ?> 
    
<div class="website-wrapper" id="all_wrapper" >
<div class="container main_wrapper <?php print esc_attr($wide_class); print 'has_header_'.esc_attr($logo_header_type).' '.esc_attr($header_transparent_class); print  'contentheader_'.esc_attr($wpestate_logo_header_align); print ' cheader_'.esc_attr($wpestate_logo_header_align);?> ">

    <div class="master_header <?php print esc_attr($wide_class).' '.esc_attr($header_transparent_class); print ' '.esc_attr($wide_header_class);?>">
        
        <?php   
            if(esc_html ( wpresidence_get_option('wp_estate_show_top_bar_user_menu','') )=="yes" && !is_page_template( 'splash_page.php' ) ){
                get_template_part( 'templates/top_bar' ); 
            } 
            get_template_part('templates/mobile_menu_header' );
 
        ?>
       
        
        <div class="header_wrapper <?php print esc_attr( $show_top_bar_user_login_class).' header_'.esc_attr($logo_header_type).' header_'.esc_attr($wpestate_logo_header_align); print ' hover_type_'.esc_attr($top_menu_hover_type).' header_alignment_text_'.esc_attr($text_header_align_select ); print esc_attr($show_submit_symbol_class);?> ">
            <?php 
            if($logo_header_type  =='type5'){
                include( locate_template('templates/header5.php') );
            }else{
            ?>
            
            <div class="header_wrapper_inside <?php print esc_attr($wide_header_class); ?>" data-logo="<?php print esc_attr($logo);?>" data-sticky-logo="<?php print esc_attr($stikcy_logo_image); ?>">
                
                <div class="logo" >
                    <a href="<?php 
                    
                        $splash_page_logo_link   =   wpresidence_get_option('wp_estate_splash_page_logo_link','');  
                        if( is_page_template( 'splash_page.php' ) && $splash_page_logo_link!='' ){
                            print esc_url($splash_page_logo_link);
                        }else{
                            print esc_url(home_url('','login'));
                        }
                        ?>">
                        
                       <?php  
                        if ( $logo!='' ){
                           print '<img id="logo_image" style="margin-top:'.intval($logo_margin).'px;" src="'.esc_url($logo).'" class="img-responsive retina_ready" alt="'.esc_html__('company logo','wpresidence').'"/>';	
                        } else {
                           print '<img id="logo_image" class="img-responsive retina_ready" src="'. get_theme_file_uri('/img/logo.png').'" alt="'.esc_html__('company logo','wpresidence').'"/>';
                        }
                        ?>
                    </a>
                </div>   

              
                <?php 
        
                    if( $show_top_bar_user_login == "yes" && $logo_header_type!='type3'){
                        get_template_part('templates/top_user_menu');  
                    }
                ?>    
                
                <?php 
                    if($logo_header_type!='type3'){
                ?>
                    <nav id="access">
                        <?php 
                            wp_nav_menu( 
                                array(  'theme_location'    => 'primary' ,
                                        'walker'            => new wpestate_custom_walker
                                    ) 
                            ); 
                        ?>
                    </nav><!-- #access -->
                <?php }else{ ?>
                    <a class="navicon-button header_type3_navicon" id="header_type3_trigger">
                        <div class="navicon"></div>
                    </a>
                <?php } ?>
                    
                <?php 
                if($logo_header_type=='type4'){
                    if ( is_active_sidebar( 'header4-widget-area' ) ) {
                        print '<div id="header4_footer"><ul class="xoxo">';
                            dynamic_sidebar('header4-widget-area');
                        print'</ul></div>';
                    }
                }
                ?>    
                    
            </div>
            <?php } ?>
        </div>

     </div> 
    
    <?php get_template_part( 'header_media' ); ?>   
    
  <div class="container content_wrapper">