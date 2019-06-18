<?php
global $post;
global $curent_fav;
global $wpestate_currency;
global $where_currency;
global $show_compare;
global $show_compare_only;
global $show_remove_fav;
global $wpestate_options;
global $isdashabord;
global $align;
global $align_class;
global $is_shortcode;
global $row_number_col;
global $is_col_md_12;
global $wpestate_prop_unit;
global $wpestate_property_unit_slider;
global $wpestate_custom_unit_structure;
global $wpestate_no_listins_per_row;
global $wpestate_uset_unit;
global $property_address;

$pinterest          =   '';
$previe             =   '';
$compare            =   '';
$extra              =   '';
$property_size      =   '';
$property_bathrooms =   '';
$property_rooms     =   '';
$measure_sys        =   '';

if($wpestate_no_listins_per_row==3){
    $col_class  =   'col-md-6';
    $col_org    =   6;
}else{   
    $col_class  =   'col-md-4';
    $col_org    =   4;
}


if($wpestate_options['content_class']=='col-md-12' && $show_remove_fav!=1){
    if($wpestate_no_listins_per_row==3){
        $col_class  =   'col-md-4';
        $col_org    =   4;
    }else{
        $col_class  =   'col-md-3';
        $col_org    =   3;
    }
    
}
// if template is vertical
if($align=='col-md-12'){
    $col_class  =  'col-md-12';
    $col_org    =  12;
}

if(isset($is_shortcode) && $is_shortcode==1 ){
    $col_class='col-md-'.$row_number_col.' shortcode-col';
}

if(isset($is_col_md_12) && $is_col_md_12==1){
    $col_class  =   'col-md-6';
    $col_org    =   6;
}

$title          =   get_the_title();
$link           =    esc_url( get_permalink() );
$preview        =   array();
$preview[0]     =   '';
$favorite_class =   'icon-fav-off';
$fav_mes        =   esc_html__('add to favorites','wpresidence');
if($curent_fav){
    if ( in_array ($post->ID,$curent_fav) ){
    $favorite_class =   'icon-fav-on';   
    $fav_mes        =   esc_html__('remove from favorites','wpresidence');
    } 
}
if(isset($wpestate_prop_unit) && $wpestate_prop_unit=='list'){
   $col_class= 'col-md-12';
}

if( $wpestate_property_unit_slider==1){
    $col_class.=' has_prop_slider ';
}

if($wpestate_no_listins_per_row==4){
    $col_class.=' has_4per_row ';
}
$is_custom_desing=11;
$property_city      =   get_the_term_list($post->ID, 'property_city', '', ', ', '') ;
$property_address   =   get_post_meta($post->ID,'property_address',true);
?>  



<div class="<?php echo esc_html($col_class);?> listing_wrapper property_unit_type4 " data-org="<?php echo esc_attr($col_org);?>" data-listid="<?php echo intval($post->ID);?>" > 
    <div class="property_listing property_unit_type4 <?php if($wpestate_uset_unit==1) print 'property_listing_custom_design' ?> " data-link="<?php   if(  $wpestate_property_unit_slider==0){ echo esc_attr($link);}?>">
        
        <?php if ($wpestate_uset_unit==1){
            if ( isset($show_remove_fav) && $show_remove_fav==1 ) {
                print '<span class="icon-fav icon-fav-on-remove" data-postid="'.intval($post->ID).'">'.esc_html($fav_mes).'</span>';
            }
  
         wpestate_build_unit_custom_structure($wpestate_custom_unit_structure,$post->ID,$wpestate_property_unit_slider);
            
        } else{
           
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
                
                    
                $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_full_map');
                $preview   = wp_get_attachment_image_src(get_post_thumbnail_id(), 'property_listings');
                $compare   = wp_get_attachment_image_src(get_post_thumbnail_id(), 'slider_thumb');
                $extra= array(
                    'data-original' =>  $preview[0],
                    'class'         =>  'lazyload img-responsive',    
                );


                $thumb_prop             =   get_the_post_thumbnail($post->ID, 'property_listings',$extra);

                if($thumb_prop ==''){
                    $thumb_prop_default =  get_theme_file_uri('/img/defaults/default_property_listings.jpg');
                    $thumb_prop         =  '<img src="'.esc_url($thumb_prop_default).'" class="b-lazy img-responsive wp-post-image  lazy-hidden" alt="'.esc_html__('user image','wpresidence').'" />';   
                }


                $prop_stat              =   stripslashes ( esc_html( get_post_meta($post->ID, 'property_status', true) ) );
                $featured               =   intval  ( get_post_meta($post->ID, 'prop_featured', true) );
                $property_rooms         =   get_post_meta($post->ID, 'property_rooms', true);
                if($property_rooms!=''){
                    $property_rooms=floatval($property_rooms);
                }

                $property_bathrooms     =   get_post_meta($post->ID, 'property_bathrooms', true) ;
                if($property_bathrooms!=''){
                    $property_bathrooms=floatval($property_bathrooms);
                }

                $property_size     =    wpestate_get_converted_measure( $post->ID, 'property_size' );
                $garage_no          =   get_post_meta($post->ID, 'property-garage', true) ;
                $measure_sys            = esc_html ( wpresidence_get_option('wp_estate_measure_sys','') ); 

                print   '<div class="listing-unit-img-wrapper">';
            
                
                if(  $wpestate_property_unit_slider==1){
                    //slider
                   

                    $slides='';

                    $no_slides = 0;
                    foreach ($post_attachments as $attachment) { 
                        $no_slides++;
                        $preview    =   wp_get_attachment_image_src($attachment->ID, 'property_listings');

                        $slides     .= '<div class="item lazy-load-item">
                                            <a href="'.esc_url($link).'"><img  data-lazy-load-src="'.esc_url($preview[0]).'" alt="'.esc_attr($title).'" class="img-responsive" /></a>
                                        </div>';

                    }// end foreach
                    $unique_prop_id=uniqid();
                    print '
                    <div id="property_unit_carousel_'.esc_attr($unique_prop_id).'" class="carousel property_unit_carousel slide " data-ride="carousel" data-interval="false">
                        <div class="carousel-inner">         
                            <div class="item active">    
                                <a href="'.esc_url($link).'">'.$thumb_prop.'</a>     
                            </div>
                            '.$slides.'
                        </div>

                        <a href="'.esc_url($link).'"> </a>';// slides and thumg_prop are escaped above

                        if( $no_slides>0){
                            print '<a class="left  carousel-control" href="#property_unit_carousel_'.esc_attr($unique_prop_id).'" data-slide="prev">
                                <i class="demo-icon icon-left-open-big"></i>
                            </a>

                            <a class="right  carousel-control" href="#property_unit_carousel_'.esc_attr($unique_prop_id).'" data-slide="next">
                                <i class="demo-icon icon-right-open-big"></i>
                            </a>';
                        }
                    print'
                    </div>';


                }else{
                    print   '<a href="'.esc_url($link).'">'.$thumb_prop.'</a>';// escaped above               
                }

                if( !isset($show_compare) || $show_compare!=0  ){
                    ?>
                    <div class="listing_actions">
                        <?php print wpestate_share_unit_desing($post->ID); ?>
                        <span class="share_list"  data-original-title="<?php esc_attr_e('share','wpresidence');?>" ></span>
                        <span class="icon-fav <?php echo esc_html($favorite_class);?>" data-original-title="<?php print esc_attr($fav_mes); ?>" data-postid="<?php echo intval($post->ID); ?>"></span>
                        <span class="compare-action" data-original-title="<?php  esc_attr_e('compare','wpresidence');?>" data-pimage="<?php if( isset($compare[0])){echo esc_html($compare[0]);} ?>" data-pid="<?php echo intval($post->ID); ?>"></span>
                    </div>
                <?php
                }
                

                print'<div class="tag-wrapper">';
                    if($featured==1){
                        print '<div class="featured_div">'.esc_html__('Featured','wpresidence').'</div>';
                    }
                 
                
                    print'<div class="status-wrapper">';    
                        $property_action            =   get_the_terms($post->ID, 'property_action_category');  
                        if(isset($property_action[0])){
                            $property_action_term = $property_action[0]->name;
                            print '<div class="action_tag_wrapper '.esc_attr($property_action_term).' ">'.wp_kses_post($property_action_term).'</div>';
                        }

                        if ($prop_stat != 'normal') {
                            $ribbon_class = str_replace(' ', '-', $prop_stat);
                            if (function_exists('icl_translate') ){
                                $prop_stat     =   icl_translate('wpestate','wp_estate_property_status'.$prop_stat, $prop_stat );
                            }
                            print'<div class="ribbon-inside '.esc_attr($ribbon_class).'">'.esc_html($prop_stat).'</div>';
                        } 
     
                    print   '</div>';
                print   '</div>'; 
                
            print   '</div>';
                
           
            
            if ( isset($show_remove_fav) && $show_remove_fav==1 ) {
                print '<span class="icon-fav icon-fav-on-remove" data-postid="'.intval($post->ID).'">'.esc_html($fav_mes).'</span>';
            }
            ?>


            <h4><a href="<?php echo esc_url($link); ?>">
                <?php
                    echo mb_substr( $title,0,44); 
                    if(mb_strlen($title)>44){
                        echo '...';   
                    } 
                 
                ?>
                </a> 
            </h4> 
        
            <div class="property_address_type4">
                <?php
                    if($property_address!=''){
                        print '<span>'.esc_html($property_address).'</span>';
                    }
                    if($property_city!=''){
                        print '<span>, '.wp_kses_post($property_city).'</span>';
                    }

                ?>
            </div>
              

            <div class="property_listing_details">
                <?php
                    print '<div class="listing_unit_price_wrapper">';
                        wpestate_show_price($post->ID,$wpestate_currency,$where_currency);
                    print '</div>';
                ?>
                
                <?php 
                    if($property_rooms!=''){
                        print '<div class="inforoom_unit_type4">'.esc_html__('Rooms','wpresidence').'<span>'.esc_html($property_rooms).'</span></div>';
                    }

                    if($property_bathrooms!=''){
                        print '<div class="infobath_unit_type4">'.esc_html__('Bedrooms','wpresidence').'<span>'.esc_html($property_bathrooms).'</span></div>';
                    }
                    
                    if($property_size!=''){
                        print '<div class="infosize_unit_type4">'.esc_html__('Size','wpresidence').'<span>'.trim($property_size).'</span></div>';//escaped above
                    }
                    
                  ?>
            </div>
        
        
        <div class="property_listing_details4_grid_view">
            <?php
            if($property_bathrooms!=''){
                print '<div class="infobath_unit_type4">'.esc_html($property_bathrooms).' '.esc_html__('Bedrooms','wpresidence').'</div>';
            }
            
            if($property_size!=''){
                print '<div class="infosize_unit_type4">'.$property_size.'</div>';//escaped above
            }
            
            ?>
        </div>
        
 
            <?php if ($align_class=='the_list_view') {?>
                <div class="listing_details the_list_view" style="display:block;">
                    <?php   
                        echo wpestate_strip_excerpt_by_char(get_the_excerpt(),100,$post->ID);
                    ?>
                </div>   
        
                <div class="listing_details half_map_list_view" >
                    <?php   
                        echo wpestate_strip_excerpt_by_char(get_the_excerpt(),60,$post->ID);
                    ?>
                </div>   

                <div class="listing_details the_grid_view" style="display:none;">
                    <?php 
                        echo  wpestate_strip_excerpt_by_char(get_the_excerpt(),110,$post->ID);
                    ?>
                </div>
            <?php
            }else{
            ?>
                <div class="listing_details the_grid_view">
                    <?php
                        echo wpestate_strip_excerpt_by_char(get_the_excerpt(),120,$post->ID);
                    ?>
                </div>

                <div class="listing_details the_list_view">
                    <?php
                        echo  wpestate_strip_excerpt_by_char(get_the_excerpt(),100,$post->ID);
                    ?>
                </div>
            <?php } ?>   
        

            <div class="property_agent_unit_type4">
                    
                    <div class="propery_price4_grid">
                        <?php  wpestate_show_price($post->ID,$wpestate_currency,$where_currency);?>
                    </div>
                
                
                    <?php 
                    $agent_id       =   intval  ( get_post_meta($post->ID, 'property_agent', true) );
                    $thumb_id       =   get_post_thumbnail_id($agent_id);
                    $agent_face     =   wp_get_attachment_image_src($thumb_id, 'agent_picture_thumb');

                    if ($agent_face[0]==''){
                       $agent_face[0]= get_theme_file_uri('/img/default-user_1.png');
                    }
                    ?>
                    <div class="property_agent_wrapper">
                        <?php echo '<a href="'.  esc_url (  get_permalink($agent_id) ).'">' ?>
                        <div class="property_agent_image" style="background-image:url('<?php print esc_attr($agent_face[0]); ?>')"></div> 
                        <div class="property_agent_image_sign"><i class="fa fa-user-circle-o" aria-hidden="true"></i></div>
                        <?php echo '</a>' ?>
                    </div>
                
            </div>    
                        
                
                <?php
                }// end if custom structure
                ?>
            </div>  

    </div>