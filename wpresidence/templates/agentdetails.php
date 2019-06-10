<?php
global $wpestate_options;
global $prop_id;
global $post;
global $agent_url;
global $agent_urlc;
global $link;
global $agent_facebook;
global $agent_posit;
global $agent_twitter; 
global $agent_linkedin; 
global $agent_instagram;
global $agent_pinterest; 
global $agent_member;
global $preview_img;

$pict_size=5;
$content_size=7;

if ($wpestate_options['content_class']=='col-md-12'){
   $pict_size=5; 
   $content_size=7; 
}

if ( get_post_type($prop_id) == 'estate_property' ){
    $pict_size=5;
    $content_size=7;
    if ($wpestate_options['content_class']=='col-md-12'){
       $pict_size=3; 
       $content_size=9;
    }   
}

if($preview_img==''){
    $preview_img    =   get_theme_file_uri('/img/default_user_agent.gif');
}

?>
<div class="wpestate_agent_details_wrapper">
    <div class="col-md-<?php print esc_attr($pict_size);?> agentpic-wrapper">
            <div class="agent-listing-img-wrapper" data-link="<?php print esc_attr($link); ?>">
                <?php
                if ( 'estate_agent' != get_post_type($prop_id)) { ?>
                    <a href="<?php print esc_url($link);?>">
                        <img src="<?php print esc_url($preview_img);?>"  alt="<?php esc_html_e('user image','wpresidence'); ?>" class="img-responsive agentpict"/>
                    </a>
                <?php
                }else{ ?>
                    <img src="<?php print esc_url($preview_img);?>"  alt="<?php esc_html_e('user image','wpresidence');?>" class="img-responsive agentpict"/>
                <?php }?>

                <div class="listing-cover"></div>
                <div class="listing-cover-title"><a href="<?php print esc_url($link);?>"><?php print esc_html($name);?></a></div>

            </div>

            <div class="agent_unit_social_single">
                <div class="social-wrapper"> 

                    <?php

                    if($agent_facebook!=''){
                        print ' <a href="'. esc_url($agent_facebook).'" target="_blank"><i class="fa fa-facebook"></i></a>';
                    }

                    if($agent_twitter!=''){
                        print ' <a href="'.esc_url($agent_twitter).'" target="_blank"><i class="fa fa-twitter"></i></a>';
                    }
                    if($agent_linkedin!=''){
                        print ' <a href="'.esc_url($agent_linkedin).'" target="_blank"><i class="fa fa-linkedin"></i></a>';
                    }
                    if($agent_pinterest!=''){
                        print ' <a href="'. esc_url($agent_pinterest).'" target="_blank"><i class="fa fa-pinterest"></i></a>';
                    }
                    if($agent_instagram!=''){
                        print ' <a href="'. esc_url($agent_instagram).'" target="_blank"><i class="fa fa-instagram"></i></a>';
                    }
                    ?>

                 </div>
            </div>
    </div>  

    <div class="col-md-<?php print esc_html($content_size);?> agent_details">    
            <div class="mydetails">
                <?php esc_html_e('My details ','wpresidence');?>
            </div>
            <?php   
            
            $author         = get_post_field( 'post_author', $post->ID) ;
            $agency_post    = get_the_author_meta('user_agent_id',$author);
             
            print '<h3><a href="'.esc_url($link).'">'.esc_html($name).'</a></h3>
            <div class="agent_position">'.esc_html($agent_posit);
            if(is_singular('estate_agent') && $agency_post!=''){
                print ',<a href="'.esc_url(get_permalink($agency_post)).'"> '.get_the_title($agency_post).'</a>';
            }
            print'</div>';
            
            
            if ($agent_phone) {
                print '<div class="agent_detail agent_phone_class"><i class="fa fa-phone"></i><a href="tel:'.esc_url($agent_phone).'">'.esc_html($agent_phone).'</a></div>';
            }
            if ($agent_mobile) {
                print '<div class="agent_detail agent_mobile_class"><i class="fa fa-mobile"></i><a href="tel:'.esc_url($agent_mobile). '">'.esc_html($agent_mobile).'</a></div>';
            }

            if ($agent_email) {
                print '<div class="agent_detail agent_email_class"><i class="fa fa-envelope-o"></i><a href="mailto:' .esc_url( $agent_email) . '">' . esc_html($agent_email).'</a></div>';
            }

            if ($agent_skype) {
                print '<div class="agent_detail agent_skype_class"><i class="fa fa-skype"></i>' . esc_html($agent_skype ). '</div>';
            }

            if ($agent_urlc) {
                print '<div class="agent_detail agent_web_class"><i class="fa fa-desktop"></i><a href="http://'.esc_url($agent_urlc).'" target="_blank">'.esc_html($agent_urlc).'</a></div>';
            }
            
            if($agent_member){
                print '<div class="agent_detail agent_web_class"><strong>'.esc_html__('Member of:','wpresidence').'</strong> '.esc_html($agent_member).'</div>';
          
            }
            ?>

    </div>
    
    <div class="row custom_details_container">
     
        <div class="developer_taxonomy agent_taxonomy">
            <?php
           
            print  get_the_term_list($post->ID, 'property_county_state_agent', '', '', '') ;
            print  get_the_term_list($post->ID, 'property_city_agent', '', '', '') ;
            print  get_the_term_list($post->ID, 'property_area_agent', '', '', '');
            print  get_the_term_list($post->ID, 'property_category_agent', '', '', '') ;
            print  get_the_term_list($post->ID, 'property_action_category_agent', '', '', '');  
            ?>
        </div>    
        
        
    <?php 
    
    $agent_custom_data = get_post_meta( $post->ID, 'agent_custom_data', true );
    
    if( is_array( $agent_custom_data) ){
        if( count( $agent_custom_data )  > 0 ){
            print '<div class="custom_parameter_wrapper">';
            for( $i=0; $i<count( $agent_custom_data ); $i++ ){
                ?>  
                <div class="col-md-4">
                    <span class="custom_parameter_label">
                        <?php print esc_html($agent_custom_data[$i]['label']); ?>
                    </span>
                    <span class="custom_parameter_value">
                        <?php print esc_html($agent_custom_data[$i]['value']); ?>
                    </span>
                </div>
                <?php
            }
            print '</div>';
        }
    }
    ?> 
  
    </div>

</div>


<?php 
if ( 'estate_agent' == get_post_type($prop_id)) { ?>
        <div class="agent_content col-md-12">
            <h4><?php esc_html_e('About Me ','wpresidence'); ?></h4>    
            <?php the_content();?>
        </div>
<?php }
?>