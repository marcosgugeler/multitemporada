<?php
// this is the slider for the blog post
// embed_video_id embed_video_type
global $slider_size;
$video_id       =   '';
$video_thumb    =   '';
$video_alone    =   0;
$full_img       =   '';
$arguments      = array(
                    'numberposts' => -1,
                    'post_type' => 'attachment',
                    'post_mime_type' => 'image',
                    'post_parent' => $post->ID,
                    'post_status' => null,
                    'exclude' => get_post_thumbnail_id(),
                    'orderby' => 'menu_order',
                    'order' => 'ASC'
                );

$post_attachments   = get_posts($arguments);

$video_id           = esc_html( get_post_meta($post->ID, 'embed_video_id', true) );
$video_type         = esc_html( get_post_meta($post->ID, 'embed_video_type', true) );
      
$prop_stat = stripslashes ( esc_html( get_post_meta($post->ID, 'property_status', true) ) );    
if (function_exists('icl_translate') ){
    $prop_stat     =   icl_translate('wpestate','wp_estate_property_status_'.$prop_stat, $prop_stat ) ;                                      
}
$ribbon_class       = str_replace(' ', '-', $prop_stat);    
        
        
if ($post_attachments || has_post_thumbnail() || get_post_meta($post->ID, 'embed_video_id', true)) {  ?>   
    <div id="carousel-listing" class="carousel slide post-carusel" data-ride="carousel" data-interval="false">
        <?php 
        if($prop_stat!='normal'){
            print '<div class="slider-property-status ribbon-wrapper-'.esc_attr($ribbon_class).' '.esc_attr($ribbon_class).'">'.esc_html($prop_stat).'</div>';
        }
        ?>
        
        <?php  
        $indicators='';
        $round_indicators='';
        $slides ='';
        $captions='';
        $counter=0;
        $counter_lightbox=0;
        $has_video=0;
        if($video_id!=''){
            $has_video  =   1; 
            $counter    =   1;
            $videoitem  =   'videoitem';
            if ($slider_size    ==  'full'){
                $videoitem  =  'videoitem_full';
            }
          
            
            $indicators.='<li data-target="#carousel-listing"  data-video_data="'.esc_attr($video_type).'" data-video_id="'.esc_attr($video_id).'"  data-slide-to="0" class="active video_thumb_force">
                         <img src= "'.wpestate_get_video_thumb($post->ID).'" alt="'.esc_html__('video image','wpresidence').'" class="img-responsive"/>
                         <span class="estate_video_control"><i class="fa fa-play"></i> </span>
                         </li>'; 

            $round_indicators   .=  ' <li data-target="#carousel-listing" data-slide-to="0" class="active"></li>';

            $slides .= '<div class="item active '.esc_attr($videoitem).'">';

             if($video_type=='vimeo'){
                 $slides .= wpestate_custom_vimdeo_video($video_id);
             }else{
                  $slides.= wpestate_custom_youtube_video($video_id);
             }

             $slides   .= '</div>';
             $captions .= '<span data-slide-to="0" class="active" >'.esc_html__('Video','wpresidence').'</span>';
        }

        if( has_post_thumbnail() ){
              $counter++;
              $counter_lightbox++;
            $active='';
            if($counter==1 && $has_video!=1){
                $active=" active ";
            }else{
                $active=" ";
            }

            $post_thumbnail_id  = get_post_thumbnail_id( $post->ID );
            $preview            = wp_get_attachment_image_src($post_thumbnail_id, 'slider_thumb');
            
            if ($slider_size=='full'){
                $full_img           = wp_get_attachment_image_src($post_thumbnail_id, 'listing_full_slider_1');
            }else{
                $full_img           = wp_get_attachment_image_src($post_thumbnail_id, 'listing_full_slider');
            }
          
            $full_prty          = wp_get_attachment_image_src($post_thumbnail_id, 'full');
            $attachment_meta    = wp_get_attachment($post_thumbnail_id);

            $indicators.= '<li data-target="#carousel-listing" data-slide-to="'.($counter-1).'" class="'. $active.'">
                                <img  src="'.esc_url($preview[0]).'"   alt="'.esc_html__('image','wpresidence').'" />
                           </li>';

            $round_indicators   .=  ' <li data-target="#carousel-listing" data-slide-to="'.esc_attr($counter-1).'" class="'. $active.'" ></li>';
            $slides .= '<div class="item '.esc_attr($active).' ">
                           <a href="'.esc_url($full_prty[0]).'"  title="'.get_post($post_thumbnail_id)->post_excerpt.'" rel="prettyPhoto" class="prettygalery"> 
                                <img  src="'.esc_url($full_img[0]).'" data-slider-no="'.esc_attr($counter_lightbox).'"  alt="'.esc_attr($attachment_meta['alt']).'" class="img-responsive lightbox_trigger" />
                           </a>
                        </div>';

            $captions .= '<span data-slide-to="'.esc_attr($counter-1).'" class="'.esc_attr($active).'" >'. $attachment_meta['caption'].'</span>';

        }



        foreach ($post_attachments as $attachment) {
            $counter++;
            $counter_lightbox++;
            $active='';
            if($counter==1 && $has_video!=1){
                $active=" active ";
            }else{
                $active=" ";
            }

            $preview            = wp_get_attachment_image_src($attachment->ID, 'slider_thumb');
            if ($slider_size=='full'){
                $full_img           = wp_get_attachment_image_src($attachment->ID, 'listing_full_slider_1');
            }else{
                $full_img           = wp_get_attachment_image_src($attachment->ID, 'listing_full_slider');
            }
            $full_prty          = wp_get_attachment_image_src($attachment->ID, 'full');
            $attachment_meta    = wp_get_attachment($attachment->ID);
         
            $indicators.= ' <li data-target="#carousel-listing" data-slide-to="'.esc_attr($counter-1).'" class="'. esc_attr($active).'">
                                <img  src="'.esc_url($preview[0]).'"  alt="'.esc_html__('image','wpresidence').'" />
                            </li>';
            $round_indicators   .=  ' <li data-target="#carousel-listing" data-slide-to="'.esc_attr($counter-1).'" class="'. $active.'"></li>';

            $slides .= '<div class="item '.esc_attr($active).'" >
                        <a href="'.esc_url($full_prty[0]).'" title="'.esc_attr($attachment_meta['caption']).'" rel="prettyPhoto" class="prettygalery" > 
                            <img  src="'.esc_url($full_img[0]).'" data-slider-no="'.esc_attr($counter_lightbox).'"  alt="'.esc_attr($attachment_meta['alt']).'" class="img-responsive lightbox_trigger" />
                         </a>
                        </div>';

            $captions .= '<span data-slide-to="'.esc_attr($counter-1).'" class="'.esc_attr($active).'"> '. $attachment_meta['caption'].'</span>';                    
        }// end foreach
        ?>

    <?php 
    $header_type                =   get_post_meta ( $post->ID, 'header_type', true);
    $global_header_type         =   wpresidence_get_option('wp_estate_header_type','');

  
  
    if ( $header_type == 0 ){ // global
        if ($global_header_type != 4){
                $gmap_lat                   =   esc_html( get_post_meta($post->ID, 'property_latitude', true));
                $gmap_long                  =   esc_html( get_post_meta($post->ID, 'property_longitude', true));
                $property_add_on            =   ' data-post_id="'.esc_attr($post->ID).'" data-cur_lat="'.esc_attr($gmap_lat).'" data-cur_long="'.esc_attr($gmap_long).'" ';
                ?>
                <div id="slider_enable_map" data-placement="bottom" data-original-title="<?php esc_attr_e('Map','wpresidence');?>">    <i class="fa fa-map-marker"></i>        </div>
                <?php 
                $no_street=' no_stret ';
                if ( get_post_meta($post->ID, 'property_google_view', true) ==1){
                    print '  <div id="slider_enable_street"  class="'.wpresidence_return_class_leaflet().'" data-placement="bottom" data-original-title="'.esc_attr__('Street View','wpresidence').'"> <i class="fa fa-location-arrow"></i>    </div>';
                      $no_street='';
                }
                ?>
              
                <div id="slider_enable_slider" data-placement="bottom" data-original-title="<?php esc_attr_e('Image Gallery','wpresidence');?>" class="slideron <?php echo  esc_attr($no_street); ?>"> <i class="fa fa-picture-o"></i>         </div>
                
                <div id="gmapzoomplus"  class="smallslidecontrol"><i class="fa fa-plus"></i> </div>
                <div id="gmapzoomminus" class="smallslidecontrol"><i class="fa fa-minus"></i></div>
                <?php echo wpestate_show_poi_onmap();?>
                <div id="googleMapSlider" <?php print trim($property_add_on); ?> >              
                </div> 
        <?php       
        }
    }else{
        if($header_type!=5){
                $gmap_lat                   =   esc_html( get_post_meta($post->ID, 'property_latitude', true));
                $gmap_long                  =   esc_html( get_post_meta($post->ID, 'property_longitude', true));
                $property_add_on            =   ' data-post_id="'.esc_attr($post->ID).'" data-cur_lat="'.esc_attr($gmap_lat).'" data-cur_long="'.esc_attr($gmap_long).'" ';
                ?>
                <div id="slider_enable_map" data-placement="bottom" data-original-title="<?php esc_attr_e('Map','wpresidence');?>">    <i class="fa fa-map-marker"></i>        </div>
                <?php 
                $no_street=' no_stret ';
                if ( get_post_meta($post->ID, 'property_google_view', true) ==1){
                    print '  <div id="slider_enable_street" class="'.wpresidence_return_class_leaflet().'" data-placement="bottom" data-original-title="'.esc_attr__('Street View','wpresidence').'"> <i class="fa fa-location-arrow"></i>    </div>';
                      $no_street='';
                }
                ?>
                <div id="slider_enable_slider" data-placement="bottom" data-original-title="<?php esc_attr_e('Image Gallery','wpresidence');?>" class="slideron <?php echo   esc_attr($no_street); ?>"> <i class="fa fa-picture-o"></i>         </div>
                
                <div id="gmapzoomplus"  class="smallslidecontrol" ><i class="fa fa-plus"></i> </div>
                <div id="gmapzoomminus" class="smallslidecontrol" ><i class="fa fa-minus"></i></div>
                <?php echo wpestate_show_poi_onmap();?>
                <div id="googleMapSlider" <?php print trim($property_add_on); ?> >   
                </div>
        <?php        
        }
    }
       
   
    ?>    

    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <?php print trim($slides);?>
    </div>

    <!-- Indicators -->    
    <div class="carusel-back"></div>  
    <ol class="carousel-indicators">
      <?php print trim($indicators); ?>
    </ol>

    <ol class="carousel-round-indicators">
        <?php print trim($round_indicators);?>
    </ol> 

    <div class="caption-wrapper">   
      <?php print trim($captions);?>
        <div class="caption_control"></div>
    </div>  

    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-listing" data-slide="prev">
       <i class="demo-icon icon-left-open-big"></i>
    </a>
    <a class="right carousel-control" href="#carousel-listing" data-slide="next">
        <i class="demo-icon icon-right-open-big"></i>
    </a>
    </div>

<?php
} // end if post_attachments
?>