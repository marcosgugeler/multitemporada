<?php
$link           =   esc_url ( get_permalink($prop_id) );
$preview        =   wp_get_attachment_image_src(get_post_thumbnail_id($prop_id), 'full');
?>

<div class="featured_article_type2 featured_prop_type4">
    <div class="featured_img_type2" style="background-image:url(<?php echo esc_attr($preview[0]);?>)">

         <div class="featured_gradient"></div>
         <div class="featured_article_type2_title_wrapper">
             <div class="featured_article_label"><?php esc_html_e('Featured Property','wpresidence');?></div>
             <a href="<?php echo esc_url($link);?>"><h2><?php echo get_the_title($prop_id);?></h2></a>
             <div class="featured_read_more">
                <a href="<?php echo esc_url ( get_permalink($prop_id) );?>">
                    <?php esc_html_e('discover more','wpresidence');?>
                </a> 
                <i class="fa fa-angle-right"></i></div>    
         </div>        
     </div>
 </div>