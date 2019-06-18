<?php
global $wpestate_options;

$thumb_id           = get_post_thumbnail_id($post->ID);
$preview            = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
$agent_skype        = esc_html( get_post_meta($post->ID, 'agent_skype', true) );
$agent_phone        = esc_html( get_post_meta($post->ID, 'agent_phone', true) );
$agent_mobile       = esc_html( get_post_meta($post->ID, 'agent_mobile', true) );
$agent_email        = esc_html( get_post_meta($post->ID, 'agent_email', true) );
$agent_posit        = esc_html( get_post_meta($post->ID, 'agent_position', true) );
$agent_facebook     = esc_html( get_post_meta($post->ID, 'agent_facebook', true) );
$agent_twitter      = esc_html( get_post_meta($post->ID, 'agent_twitter', true) );
$agent_linkedin     = esc_html( get_post_meta($post->ID, 'agent_linkedin', true) );
$agent_pinterest    = esc_html( get_post_meta($post->ID, 'agent_pinterest', true) );
$agent_instagram    = esc_html( get_post_meta($post->ID, 'agent_instagram', true) );
$name               = get_the_title();
$link               =  esc_url( get_permalink() );
$counter            = '';


$user_for_id = intval(get_post_meta($post->ID,'user_meda_id',true));
if($user_for_id!=0){
$counter            =   count_user_posts($user_for_id,'estate_property',true);
}


$extra= array(
        'data-original'=>$preview[0],
        'class'	=> 'lazyload img-responsive',    
        );
$thumb_prop    = get_the_post_thumbnail($post->ID, 'property_listings',$extra);

if($thumb_prop==''){
    $thumb_prop = '<img src="'.get_theme_file_uri('/img/default_user.png').'" alt="'.esc_html__('user image','wpresidence').'">';
}
          
?>
    <div class="agent_unit" data-link="<?php print esc_attr($link);?>">
        <div class="agent-unit-img-wrapper">
            <?php if($user_for_id!=0){ ?>
            <div class="agent_card_my_listings">
                <?php print intval($counter).' '; 
                    if($counter!=1){
                        esc_html_e('listings','wpresidence');
                    }else{
                        esc_html_e('listing','wpresidence');
                    }
                ?>
            </div>
            <?php } ?>
            
            
            <div class="prop_new_details_back"></div>
            <?php 
                print trim($thumb_prop); 
            ?>
        </div>    
            
        <div class="">
            <?php
            print '<h4> <a href="'.esc_url($link).'">'.esc_html($name).'</a></h4>
            <div class="agent_position">'.esc_html($agent_posit).'</div>';
           
            if ($agent_phone) {
                print '<div class="agent_detail"><i class="fa fa-phone"></i><a href="tel:'.esc_url( $agent_phone).'">'. esc_html($agent_phone ).'</a></div>';
            }
            if ($agent_mobile) {
                print '<div class="agent_detail"><i class="fa fa-mobile"></i><a href="tel:'.esc_url($agent_mobile).'">'.esc_html($agent_mobile).'</a></div>';
            }

            if ($agent_email) {
                print '<div class="agent_detail"><i class="fa fa-envelope-o"></i><a href="mailto:'.esc_url($agent_email).'">'.esc_html($agent_email).'</a></div>';
            }

            if ($agent_skype) {
                print '<div class="agent_detail"><i class="fa fa-skype"></i>'.esc_html($agent_skype). '</div>';
            }
            ?>

        </div> 
          
        <a href="<?php print esc_url($link); ?>"  class=" agent_unit_button agent_unit_contact_me" ><?php esc_html_e('Contact me','wpresidence');?></a>
        
        <div class="agent_unit_social agent_list">
            <div class="social-wrapper"> 
               
               <?php
               
                if($agent_facebook!=''){
                    print ' <a href="'. esc_url($agent_facebook).'"><i class="fa fa-facebook"></i></a>';
                }

                if($agent_twitter!=''){
                    print ' <a href="'.esc_url($agent_twitter).'"><i class="fa fa-twitter"></i></a>';
                }
                
                if($agent_linkedin!=''){
                    print ' <a href="'.esc_url($agent_linkedin).'"><i class="fa fa-linkedin"></i></a>';
                }
                
                if($agent_pinterest!=''){
                    print ' <a href="'. esc_url($agent_pinterest).'"><i class="fa fa-pinterest"></i></a>';
                }
                
                if($agent_instagram!=''){
                    print ' <a href="'. esc_url($agent_instagram).'"><i class="fa fa-instagram"></i></a>';
                }
                ?>
            </div>
        </div>
    </div>
<!-- </div>    -->