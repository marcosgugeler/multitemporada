<?php
// Template Name: Contact Page 
// Wp Estate Pack

if(!function_exists('wpestate_residence_functionality')){
    esc_html_e('This page will not work without WpResidence Core Plugin, Please activate it from the plugins menu!','wpresidence');
    exit();
}

get_header();
$wpestate_options   =   wpestate_page_details($post->ID);
$company_name       =   esc_html( stripslashes( wpresidence_get_option('wp_estate_company_name', '') ) );
$company_picture    =   esc_html( stripslashes( wpresidence_get_option('wp_estate_company_contact_image', 'url') ) );
$company_email      =   esc_html( stripslashes( wpresidence_get_option('wp_estate_email_adr', '') ) );
$mobile_no          =   esc_html( stripslashes( wpresidence_get_option('wp_estate_mobile_no','') ) );
$telephone_no       =   esc_html( stripslashes( wpresidence_get_option('wp_estate_telephone_no', '') ) );
$fax_ac             =   esc_html( stripslashes( wpresidence_get_option('wp_estate_fax_ac', '') ) );
$skype_ac           =   esc_html( stripslashes( wpresidence_get_option('wp_estate_skype_ac', '') ) );

if (function_exists('icl_translate') ){
    $co_address      =  esc_html( icl_translate('wpestate','wp_estate_co_address_text', ( wpresidence_get_option('wp_estate_co_address') ) ) );
}else{
    $co_address      = esc_html( stripslashes ( wpresidence_get_option('wp_estate_co_address', '') ) );
}

$facebook_link      =   esc_html( wpresidence_get_option('wp_estate_facebook_link', '') );
$twitter_link       =   esc_html( wpresidence_get_option('wp_estate_twitter_link', '') );
$google_link        =   esc_html( wpresidence_get_option('wp_estate_google_link', '') );
$linkedin_link      =   esc_html ( wpresidence_get_option('wp_estate_linkedin_link','') );
$pinterest_link     =   esc_html ( wpresidence_get_option('wp_estate_pinterest_link','') );
$instagram_link     =   esc_html ( wpresidence_get_option('wp_estate_instagram_link','') );  
$agent_email        =   $company_email;
?>


<div class="row">
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class="<?php print esc_html($wpestate_options['content_class']);?>">
        

        <?php get_template_part('templates/ajax_container'); ?>
        
        <?php while (have_posts()) : the_post(); ?>
            <?php if (esc_html( get_post_meta($post->ID, 'page_show_title', true) ) != 'no') { ?>
                <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php } ?>
         
            <div class="contact-wrapper row">    
            <div class="col-md-4 contact_page_company_picture">
                <?php print '<img src="'.esc_url($company_picture).'"  class="contact-comapany-logo img-responsive" alt="'.esc_html__('company logo','wpresidence').'"/> '; ?>    
            </div>
            
            <div class="col-md-8 contact_page_company_details">
                <div class="company_headline ">   
                    <h3><?php print esc_html($company_name);?></h3>
                    <div class="header_social">
                        <?php
                        if($facebook_link!=''){
                            print ' <a href="'.esc_url($facebook_link).'"><i class="fa fa-facebook"></i></a>';
                        }

                        if($twitter_link!=''){
                           print ' <a href="'.esc_url($twitter_link).'"><i class="fa fa-twitter"></i></a>';
                        }
                        
                        if($google_link!=''){
                            print ' <a href="'.esc_url($google_link).'"><i class="fa fa-google-plus"></i></a>';
                        }

                        if($linkedin_link!=''){
                            print ' <a href="'.esc_url($linkedin_link).'"><i class="fa fa-linkedin"></i></a>';
                        }

                        if($pinterest_link!=''){
                             print ' <a href="'.esc_url($pinterest_link).'"><i class="fa fa-pinterest"></i></a>';
                        }
                        if($instagram_link!=''){
                             print ' <a href="'.esc_url($instagram_link).'"><i class="fa fa-instagram"></i></a>';
                        }
                        
                       
                        ?>
                    </div>     
                </div>   
         
                <?php      
                    if ($telephone_no) {
                        print '<div class="agent_detail contact_detail"><i class="fa fa-phone"></i><a href="tel:' . esc_url($telephone_no) . '">'; print esc_html( $telephone_no ). '</a></div>';
                    }

                     if ($mobile_no) {
                        print '<div class="agent_detail contact_detail"><i class="fa fa-mobile"></i><a href="tel:' . esc_url( $mobile_no ) . '">'; print  esc_html ($mobile_no) . '</a></div>';
                    }

                    if ($company_email) {
                        print '<div class="agent_detail contact_detail"><i class="fa fa-envelope-o"></i>'; print '<a href="mailto:'.esc_url($company_email).'">' .esc_html( $company_email ). '</a></div>';
                    }
                    
                    if ($fax_ac) {
                        print '<div class="agent_detail contact_detail"><i class="fa fa-print"></i>';print  esc_html( $fax_ac ). '</div>';
                    }
                    
                    if ($skype_ac) {
                        print '<div class="agent_detail contact_detail"><i class="fa fa-skype"></i>';print  esc_html( $skype_ac ). '</div>';
                    }

                    if ($co_address) {
                        print '<div class="agent_detail contact_detail"><i class="fa fa-home"></i>';print  esc_html( $co_address ). '</div>';
                    }
                ?>
                
            </div>
                
                 <?php the_content(); ?>
            </div>    
           
                
            <div class="single-content contact-content">    
               <?php  include( locate_template( 'templates/agent_contact.php') );   ?>
           </div><!-- single content-->
           
        <?php endwhile; // end of the loop. ?>
    </div>
  
    
<?php  include get_theme_file_path('sidebar.php'); ?>
</div>   
<?php get_footer(); ?>