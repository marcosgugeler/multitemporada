<?php

if( !function_exists('wpestate_present_theme_slider') ):
    function wpestate_present_theme_slider(){
    
        
        $theme_slider   =   wpresidence_get_option( 'wp_estate_theme_slider_type'); 
    
        if($theme_slider=='type2'){
            wpestate_present_theme_slider_type2();
            return;
        }
        
        if($theme_slider=='type3'){
            wpestate_present_theme_slider_type3();
            return;
        }
        
        $attr=array(
            'class'	=>'img-responsive'
        );

        $theme_slider   =   wpresidence_get_option( 'wp_estate_theme_slider', ''); 

        if(empty($theme_slider)){
            return; // no listings in slider - just return
        }
        $wpestate_currency       =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
        $where_currency =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );

        $counter    =   0;
        $slides     =   '';
        $indicators =   '';
        $args = array(  
                    'post_type'        =>   'estate_property',
                    'post_status'      =>   'publish',
                    'post__in'         =>   $theme_slider,
                    'posts_per_page'   =>   -1
                  );
       
        $recent_posts = new WP_Query($args);
        $slider_cycle   =   wpresidence_get_option( 'wp_estate_slider_cycle', ''); 
        if($slider_cycle == 0){
            $slider_cycle = false;
        }
        
        $extended_search    =   wpresidence_get_option('wp_estate_show_adv_search_extended','');
        $extended_class     =   '';

        if ( $extended_search =='yes' ){
            $extended_class='theme_slider_extended';
        }
        $theme_slider_height   =   wpresidence_get_option( 'wp_estate_theme_slider_height', '');
        
        if($theme_slider_height==0){
            $theme_slider_height=900;
            $extended_class .= " full_screen_yes ";
        }
        
        print '<div class="theme_slider_wrapper '.$extended_class.' carousel  slide" data-ride="carousel" data-interval="'.esc_attr($slider_cycle).'" id="estate-carousel"  style="height:'.$theme_slider_height.'px;">';

        while ($recent_posts->have_posts()): $recent_posts->the_post();
               $theid=get_the_ID();
             

                $preview        =   wp_get_attachment_image_src(get_post_thumbnail_id($theid), 'property_full_map');
                if($preview[0]==''){
                    $preview[0]= get_theme_file_uri('/img/defaults/default_property_featured.jpg');
                }

               if($counter==0){
                    $active=" active ";
                }else{
                    $active=" ";
                }
                $measure_sys    =   wpresidence_get_option('wp_estate_measure_sys','');
                $price          =   floatval( get_post_meta($theid, 'property_price', true) );
                $price_label    =   '<span class="">'.esc_html ( get_post_meta($theid, 'property_label', true) ).'</span>';
                $price_label_before   =   '<span class="">'.esc_html ( get_post_meta($theid, 'property_label_before', true) ).'</span>';
                $beds           =   floatval( get_post_meta($theid, 'property_bedrooms', true) );
                $baths          =   floatval( get_post_meta($theid, 'property_bathrooms', true) );
                $size           =   wpestate_get_converted_measure( $theid, 'property_size' );
                
                if ($price != 0) {
                   $price  = wpestate_show_price($theid,$wpestate_currency,$where_currency,1);  
                }else{
                    $price=$price_label_before.''.$price_label;
                }


               $slides.= '
               <div class="item theme_slider_classic '.$active.'" data-href="'.esc_url( get_permalink()).'" style="background-image:url('.esc_url($preview[0]).');height:'.$theme_slider_height.'px;">
                   
                    <div class="slider-content-wrapper">  
                    <div class="slider-content">

                        <h3><a href="'. esc_url( get_permalink() ).'">';
                            $title = get_the_title();
                
                            $slides.= mb_substr( $title,0,54); 
                            if(mb_strlen($title)>54){
                                $slides.= '...';   
                            }         
                        $slides.='</a> </h3>
                        
                        <span> '. wpestate_strip_words( get_the_excerpt(),20).' ...<a href="'. esc_url( get_permalink() ).'" class="read_more">'.esc_html__('Read more','wpresidence').'<i class="fa fa-angle-right"></i></a></span>

                         <div class="theme-slider-price">
                            '.$price.'  
                            <div class="listing-details">';
                            if($beds!=0){
                                $slides.= '<span class="inforoom">'.$beds.'</span>';
                            }
                            if($baths!=0){
                                $slides.= '<span class="infobath">'.$baths.'</span>';
                            }
                            if($size!=0){
                                $slides.= '<span class="infosize">'.$size.'</span>';
                            }
                            
                            $slides.= '    
                            </div>
                         </div>

                         <a class="carousel-control-theme-next" href="#estate-carousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
                         <a class="carousel-control-theme-prev" href="#estate-carousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>
                    </div> 
                    </div>
                </div>';

               $indicators.= '
               <li data-target="#estate-carousel" data-slide-to="'.esc_attr($counter).'" class="'.esc_attr($active).'">

               </li>';

               $counter++;
        endwhile;
        wp_reset_query();
        print '<div class="carousel-inner" role="listbox">
                  '.$slides.'
               </div>

               <ol class="carousel-indicators">
                    '.$indicators.'
               </ol>

               </div>';
    } 
endif;




if( !function_exists('wpestate_present_theme_slider_type2') ):
    function wpestate_present_theme_slider_type2(){
    
        
       
        
        $attr=array(
            'class'	=>'img-responsive'
        );

        $theme_slider   =   wpresidence_get_option( 'wp_estate_theme_slider', ''); 

        if(empty($theme_slider)){
            return; // no listings in slider - just return
        }
        $wpestate_currency       =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
        $where_currency =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );

        $counter    =   0;
        $slides     =   '';
        $indicators =   '';
        $args = array(  
                    'post_type'        =>   'estate_property',
                    'post_status'      =>   'publish',
                    'post__in'         =>   $theme_slider,
                    'posts_per_page'   =>   -1
                  );
       
        $recent_posts = new WP_Query($args);
        $slider_cycle   =   wpresidence_get_option( 'wp_estate_slider_cycle', ''); 
       
        $extended_search    =   wpresidence_get_option('wp_estate_show_adv_search_extended','');
        $extended_class     =   '';

        if ( $extended_search =='yes' ){
            $extended_class='theme_slider_extended';
        }
        
        
        $theme_slider_height   =   wpresidence_get_option( 'wp_estate_theme_slider_height', '');
        if($theme_slider_height==0){
            $theme_slider_height=900;
            $extended_class .= " full_screen_yes ";
        }
        
        print '<div class="theme_slider_wrapper theme_slider_2 '.esc_attr($extended_class).' " data-auto="'.esc_attr($slider_cycle).'" style="height:'.esc_attr($theme_slider_height).'px;">';

        while ($recent_posts->have_posts()): $recent_posts->the_post();
               $theid=get_the_ID();
           
                $preview        =   wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_full_map');
                if($preview[0]==''){
                    $preview[0]= get_theme_file_uri('/img/defaults/default_property_featured.jpg');
                }

               if($counter==0){
                    $active=" active ";
                }else{
                    $active=" ";
                }
                $measure_sys    =   wpresidence_get_option('wp_estate_measure_sys','');
                $price          =   floatval( get_post_meta($theid, 'property_price', true) );
                $price_label    =   '<span class="">'.esc_html ( get_post_meta($theid, 'property_label', true) ).'</span>';
                $price_label_before   =   '<span class="">'.esc_html ( get_post_meta($theid, 'property_label_before', true) ).'</span>';
                $beds           =   floatval( get_post_meta($theid, 'property_bedrooms', true) );
                $baths          =   floatval( get_post_meta($theid, 'property_bathrooms', true) );
		$size           =   wpestate_get_converted_measure( $theid, 'property_size' );
                $property_city      =   get_the_term_list($theid, 'property_city', '', ', ', '') ;
                $property_area      =   get_the_term_list($theid, 'property_area', '', ', ', '');	
				
                if ($price != 0) {
                   $price  = wpestate_show_price($theid,$wpestate_currency,$where_currency,1);  
                }else{
                    $price=$price_label_before.''.$price_label;
                }


               $slides.= '
               <div class="item_type2 '.$active.'"  style="background-image:url('.esc_url($preview[0]).');height:'.$theme_slider_height.'px;">
                   
                

                        <div class="prop_new_details" data-href="'. esc_url( get_permalink() ).'">
                            <div class="prop_new_details_back"></div>
                            <div class="prop_new_detals_info">
                                <div class="theme-slider-price">
                                    '.$price.'  
                                </div>
                                <h3><a href="'. esc_url( get_permalink() ).'">'.get_the_title().'</a> </h3>

                                <div class="theme-slider-location">';
                                    if($property_area!=''){
                                        $slides.= wp_kses_post($property_area).', ';
                                    }
                                    if($property_city!=''){
                                        $slides.= wp_kses_post($property_city);
                                    }
                                $slides.='</div>

                            </div>
                        </div>
                   
                </div>';

            
               $counter++;
        endwhile;
        wp_reset_query();
        print trim($slides).'</div>';
    } 
endif;


if( !function_exists('wpestate_present_theme_slider_type3') ):
    function wpestate_present_theme_slider_type3(){
    
        
        $theme_slider   =   wpresidence_get_option( 'wp_estate_theme_slider_type'); 
    
        $attr=array(
            'class'	=>'img-responsive'
        );

        $theme_slider   =   wpresidence_get_option( 'wp_estate_theme_slider'); 

        if(empty($theme_slider)){
            return; // no listings in slider - just return
        }
        $wpestate_currency       =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
        $where_currency =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );

        $counter    =   0;
        $slides     =   '';
        $excerpts     =   '';
        $indicators =   '';
        $args = array(  
                    'post_type'        =>   'estate_property',
                    'post_status'      =>   'publish',
                    'post__in'         =>   $theme_slider,
                    'posts_per_page'   =>   4
                  );
       
        $recent_posts = new WP_Query($args);
        $slider_cycle   =   wpresidence_get_option( 'wp_estate_slider_cycle', ''); 
        if($slider_cycle == 0){
            $slider_cycle = false;
        }
        
        $extended_search    =   wpresidence_get_option('wp_estate_show_adv_search_extended','');
        $extended_class     =   '';

        if ( $extended_search =='yes' ){
            $extended_class='theme_slider_extended';
        }
        $theme_slider_height   =   wpresidence_get_option( 'wp_estate_theme_slider_height', '');
        
        if($theme_slider_height==0){
            $theme_slider_height=900;
            $extended_class .= " full_screen_yes ";
        }
        
        print '<div class="theme_slider_wrapper '.$extended_class.' theme_slider_3 slider_type_3 carousel  slide" data-ride="carousel" data-interval="'.esc_attr($slider_cycle).'" id="estate-carousel" >';
        
        $class_counter = 1;
        while ($recent_posts->have_posts()): $recent_posts->the_post();
				
				
               $theid=get_the_ID();
             

                $preview        =   wp_get_attachment_image_src(get_post_thumbnail_id($theid), 'property_full_map');
                if($preview[0]==''){
                    $preview[0]= get_theme_file_uri('/img/defaults/default_property_featured.jpg');
                }

               if($counter==0){
                    $active=" active ";
                }else{
                    $active=" ";
                }
                $measure_sys    =   wpresidence_get_option('wp_estate_measure_sys','');
                $price          =   floatval( get_post_meta($theid, 'property_price', true) );
                $price_label    =   '<span class="">'.esc_html ( get_post_meta($theid, 'property_label', true) ).'</span>';
                $price_label_before   =   '<span class="">'.esc_html ( get_post_meta($theid, 'property_label_before', true) ).'</span>';
                $beds           =   floatval( get_post_meta($theid, 'property_bedrooms', true) );
                $baths          =   floatval( get_post_meta($theid, 'property_bathrooms', true) );
                
                $size           = wpestate_get_converted_measure( $theid, 'property_size' );
                
                
                if ($price != 0) {
                   $price  = wpestate_show_price($theid,$wpestate_currency,$where_currency,1);  
                }else{
                    $price=$price_label_before.''.$price_label;
                }
				
                $ex_cont=wpestate_strip_words( get_the_excerpt(),10,$theid).' ...';
//                $ex_cont    =get_the_excerpt($theid);

                $slides.= '
                <div class="item   animation_class_'.$class_counter.' '.$active.' " data-id="'.esc_attr($counter).'" data-href="'. esc_url( get_permalink() ).'" style=" height:'.$theme_slider_height.'px;" >
                    <div class="theme_slider_3_gradient"></div>
                   
                    <div class="image_div">
                        <img src="'.esc_url($preview[0]).'" alt="'.esc_html__('slider','wpresidence').'">
                    </div>
			   
					 
                    <div class="slide_cont_block">
                        <a href="'.esc_url ( get_permalink($theid)).'" target="_blank"><h2>'.get_the_title().'</h2></a>
                    </div>
                    
                  		
                    
                </div>';

                $indicators.= '
                <li data-target="#estate-carousel" data-slide-to="'.esc_attr($counter).'" class="'. esc_attr($active).'">
                    '.$ex_cont.'
                </li>';

                $counter++;
			   
                $class_counter++;
                if( $class_counter > 3 ){
                    $class_counter = 1;
                }
			    
			   
        endwhile;
        wp_reset_query();
        print '<div class="carousel-inner" role="listbox">
                  '.$slides.'
               </div>
			   
			 
              
				 
               <ol class="carousel-indicators">
                    '.$indicators.'
               </ol>

                <a id="carousel-control-theme-next" class="carousel-control-theme-next" href="#estate-carousel" data-slide="next"><i class="fa fa-angle-right"></i></a>
                <a id="carousel-control-theme-prev" class="carousel-control-theme-prev" href="#estate-carousel" data-slide="prev"><i class="fa fa-angle-left"></i></a>

               </div>

                ';
        
        
    }  
endif;

?>
