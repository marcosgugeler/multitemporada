<?php
// register the custom post type was init
add_action('setup_theme', 'wpestate_create_property_type',20);

if( !function_exists('wpestate_create_property_type') ):
function wpestate_create_property_type() {
    $rewrites =   get_option('wp_estate_url_rewrites',true);
    register_post_type('estate_property', array(
        'labels' => array(
            'name'                  => esc_html__('Properties','wpresidence-core'),
            'singular_name'         => esc_html__('Property','wpresidence-core'),
            'add_new'               => esc_html__('Add New Property','wpresidence-core'),
            'add_new_item'          => esc_html__('Add Property','wpresidence-core'),
            'edit'                  => esc_html__('Edit','wpresidence-core'),
            'edit_item'             => esc_html__('Edit Property','wpresidence-core'),
            'new_item'              => esc_html__('New Property','wpresidence-core'),
            'view'                  => esc_html__('View','wpresidence-core'),
            'view_item'             => esc_html__('View Property','wpresidence-core'),
            'search_items'          => esc_html__('Search Property','wpresidence-core'),
            'not_found'             => esc_html__('No Properties found','wpresidence-core'),
            'not_found_in_trash'    => esc_html__('No Properties found in Trash','wpresidence-core'),
            'parent'                => esc_html__('Parent Property','wpresidence-core')
        ),
        'public' => true,
        'has_archive' => true,
        'rewrite' => array('slug' => $rewrites[0]),
        'supports' => array('title', 'editor', 'thumbnail', 'comments','excerpt'),
        'can_export' => true,
        'register_meta_box_cb' => 'wpestate_add_property_metaboxes',
        'menu_icon'=>WPESTATE_PLUGIN_DIR_URL.'/img/properties.png'
         )
    );

    
    
////////////////////////////////////////////////////////////////////////////////////////////////
// Add custom taxomies
////////////////////////////////////////////////////////////////////////////////////////////////
    register_taxonomy('property_category', array('estate_property'), array(
        'labels' => array(
            'name'              => esc_html__('Categories','wpresidence-core'),
            'add_new_item'      => esc_html__('Add New Property Category','wpresidence-core'),
            'new_item_name'     => esc_html__('New Property Category','wpresidence-core')
        ),
        'hierarchical'  => true,
        'query_var'     => true,
        'rewrite'       => array( 'slug' => $rewrites[1] )
        )
    );



// add custom taxonomy
register_taxonomy('property_action_category', array('estate_property'), array(
    'labels' => array(
        'name'              => esc_html__('Action','wpresidence-core'),
        'add_new_item'      => esc_html__('Add New Action','wpresidence-core'),
        'new_item_name'     => esc_html__('New Action','wpresidence-core')
    ),
    'hierarchical'  => true,
    'query_var'     => true,
    'rewrite'       => array( 'slug' =>  $rewrites[2] )
   )      
);



// add custom taxonomy
register_taxonomy('property_city', array('estate_property'), array(
    'labels' => array(
        'name'              => esc_html__('City','wpresidence-core'),
        'add_new_item'      => esc_html__('Add New City','wpresidence-core'),
        'new_item_name'     => esc_html__('New City','wpresidence-core')
    ),
    'hierarchical'  => true,
    'query_var'     => true,
    'rewrite'       => array( 'slug' =>  $rewrites[3],'with_front' => false)
    )
);




// add custom taxonomy
register_taxonomy('property_area', array('estate_property'), array(
    'labels' => array(
        'name'              => esc_html__('Neighborhood','wpresidence-core'),
        'add_new_item'      => esc_html__('Add New Neighborhood','wpresidence-core'),
        'new_item_name'     => esc_html__('New Neighborhood','wpresidence-core')
    ),
    'hierarchical'  => true,
    'query_var'     => true,
    'rewrite'       => array( 'slug' =>  $rewrites[4] )

    )
);

// add custom taxonomy
register_taxonomy('property_county_state', array('estate_property'), array(
    'labels' => array(
        'name'              => esc_html__('County / State','wpresidence-core'),
        'add_new_item'      => esc_html__('Add New County / State','wpresidence-core'),
        'new_item_name'     => esc_html__('New County / State','wpresidence-core')
    ),
    'hierarchical'  => true,
    'query_var'     => true,
    'rewrite'       => array( 'slug' =>  $rewrites[5] )

    )
);





}// end create property type
endif; // end   wpestate_create_property_type      



///////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Add metaboxes for Property
///////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_add_property_metaboxes') ):
function wpestate_add_property_metaboxes() {
   add_meta_box('new_tabbed_interface',         esc_html__('Property Details', 'wpresidence-core'),             'estate_tabbed_interface', 'estate_property', 'normal', 'default' );
}
endif; // end   wpestate_add_property_metaboxes  


if( !function_exists('estate_tabbed_interface') ):
    function estate_tabbed_interface(){
        global $post;
        print'<div class="property_options_wrapper meta-options">
           
             <div class="property_options_wrapper_list">
                <div class="property_tab_item active_tab" data-content="property_details">'.esc_html__('Property Details','wpresidence-core').'</div>
                <div class="property_tab_item " data-content="property_media">'.esc_html__('Property Media','wpresidence-core').'</div>
                <div class="property_tab_item" data-content="property_customs">'.esc_html__('Property Custom Fields','wpresidence-core').'</div>
                <div class="property_tab_item" data-content="property_map" id="property_map_trigger">'.esc_html__('Map','wpresidence-core').'</div>
                <div class="property_tab_item" data-content="property_features">'.esc_html__('Amenities and Features','wpresidence-core').'</div>
                <div class="property_tab_item" data-content="property_agent">'.esc_html__('Agent','wpresidence-core').'</div>
                <div class="property_tab_item" data-content="property_floor">'.esc_html__('Floor Plans','wpresidence-core').'</div>
                <div class="property_tab_item" data-content="property_paid">'.esc_html__('Paid Submission','wpresidence-core').'</div>
                <div class="property_tab_item" data-content="property_subunits">'.esc_html__('Property  Subunits','wpresidence-core').'</div>
            </div>
            <div class="property_options_content_wrapper">
                <div class="property_tab_item_content active_tab" id="property_details"><h3>'.esc_html__('Property Details','wpresidence-core').'</h3>';
                wpestate_estate_box();
                print'</div>
                
                <div class="property_tab_item_content " id="property_media"><h3>'.esc_html__('Property Media','wpresidence-core').'</h3>';
                wpestate_property_add_media();
                print'</div> 

                <div class="property_tab_item_content" id="property_customs"><h3>'.esc_html__('Property Custom','wpresidence-core').'</h3>';
                wpestate_custom_details_box();
                print'</div>
                <div class="property_tab_item_content" id="property_map"><h3>'.esc_html__('Map','wpresidence-core').'</h3>';
                wpestate_map_estate_box();
                print'</div>
                <div class="property_tab_item_content" id="property_features"><h3>'.esc_html__('Amenities and Features','wpresidence-core').'</h3>';
                wpestate_amenities_estate_box();
                print'</div>
                <div class="property_tab_item_content" id="property_agent"><h3>'.esc_html__('Responsible Agent / User','wpresidence-core').'</h3>';
                wpestate_agentestate_box();
                print'</div>
                <div class="property_tab_item_content" id="property_floor"><h3>'.esc_html__('Floor Plans','wpresidence-core').'</h3>';
                wpestate_floorplan_box();
                print'</div>
                <div class="property_tab_item_content" id="property_paid"><h3>'.esc_html__('Paid Submission','wpresidence-core').'</h3>';
                wpestate_estate_paid_submission();
                print'</div>
                <div class="property_tab_item_content" id="property_subunits"><h3>'.esc_html__('Property Subunits','wpresidence-core').'</h3>';
                wpestate_propery_subunits();
                print'</div>
            </div>
         
        </div>';
    }
endif;




if( !function_exists('wpestate_floorplan_box') ):
function wpestate_floorplan_box(){
    global $post;
    $plan_title         =   '';
    $plan_image         =   '';
    $plan_description   =   '';
    $plan_bath=$plan_rooms=$plan_size=$plan_price='';
    $use_floor_plans   = get_post_meta($post->ID, 'use_floor_plans', true);
    print '<p class="meta-options"> 
              <input type="hidden" name="use_floor_plans" value="0">
              <input type="checkbox" id="use_floor_plans" name="use_floor_plans" value="1"'; 
            if($use_floor_plans==1){
                print ' checked="checked" ';
            }
    print' >
              <label for="use_floor_plans">'.esc_html__('Use Floor Plans','wpresidence-core').'</label>
          </p>';
    
    print '<div id="plan_wrapper">';
    
    $plan_title_array           = get_post_meta($post->ID, 'plan_title', true);
    $plan_desc_array            = get_post_meta($post->ID, 'plan_description', true) ;
    $plan_image_array           = get_post_meta($post->ID, 'plan_image', true) ;
    $plan_image_attach_array    = get_post_meta($post->ID, 'plan_image_attach', true) ;
    $plan_size_array            = get_post_meta($post->ID, 'plan_size', true) ;
    $plan_rooms_array           = get_post_meta($post->ID, 'plan_rooms', true) ;
    $plan_bath_array            = get_post_meta($post->ID, 'plan_bath', true);
    $plan_price_array           = get_post_meta($post->ID, 'plan_price', true) ;

  
    
    if(is_array($plan_title_array)){
        foreach ($plan_title_array as $key=> $plan_name) {

            if ( isset($plan_desc_array[$key])){
                $plan_desc=$plan_desc_array[$key];
            }else{
                $plan_desc='';
            }
            
            if ( isset($plan_image_attach_array[$key])){
                $plan_image_attach=$plan_image_attach_array[$key];
            }else{
                $plan_image_attach='';
            }
                
                
            if ( isset($plan_image_array[$key])){
                $plan_img=$plan_image_array[$key];
            }else{
                $plan_img='';
            }

            if ( isset($plan_size_array[$key])){
                $plan_size=$plan_size_array[$key];
            }else{
                $plan_size='';
            }

            if ( isset($plan_rooms_array[$key])){
                $plan_rooms=$plan_rooms_array[$key];
            }else{
                $plan_rooms='';
            }

            if ( isset($plan_bath_array[$key])){
                $plan_bath=$plan_bath_array[$key];
            }else{
                $plan_bath='';
            }

            if ( isset($plan_price_array[$key])){
                $plan_price=$plan_price_array[$key];
            }else{
                $plan_price='';
            }


            print '

            <div class="plan_row">  
            <i class="fa deleter_floor fa-trash-o"></i>

            <p class="meta-options floor_p">
                <label for="plan_title">'.esc_html__('Plan Title','wpresidence-core').'</label><br />
                <input id="plan_title" type="text" size="36" name="plan_title[]" value="'.$plan_name.'" />
           </p>

            <p class="meta-options floor_p">
                <label for="plan_description">'.esc_html__('Plan Description','wpresidence-core').'</label><br />
                <textarea class="plan_description" type="text" size="36" name="plan_description[]" >'.$plan_desc.'</textarea>
            </p>

          

            <p class="meta-options floor_p">
                <label for="plan_size">'.esc_html__('Plan Size','wpresidence-core').'</label><br />
                <input id="plan_size" type="text" size="36" name="plan_size[]" value="'.$plan_size.'" />
            </p>

            <p class="meta-options floor_p">
                <label for="plan_rooms">'.esc_html__('Plan Rooms','wpresidence-core').'</label><br />
                <input id="plan_rooms" type="text" size="36" name="plan_rooms[]" value="'.$plan_rooms.'" />
            </p>

            <p class="meta-options floor_p">
                <label for="plan_bath">'.esc_html__('Plan Bathrooms','wpresidence-core').'</label><br />
                <input id="plan_bath" type="text" size="36" name="plan_bath[]" value="'.$plan_bath.'" />
            </p>

            <p class="meta-options floor_p">
                <label for="plan_price">'.esc_html__('Plan Price','wpresidence-core').'</label><br />
                <input id="plan_price" type="text" size="36" name="plan_price[]" value="'.$plan_price.'" />
            </p>
            

            <p class="meta-options floor_p image_plan">
                <label for="plan_image">'.esc_html__('Plan Image','wpresidence-core').'</label><br />
                <input id="plan_image" type="text" size="36" name="plan_image[]" value="'.$plan_img.'" /> '
                    . '<input type="hidden" id="plan_image_attach" name="plan_image_attach[]" value="'.$plan_image_attach.'"/>   
                <input id="plan_image_button" type="button"   size="40" class="upload_button button floorbuttons" value="'.esc_html__('Upload Image','wpresidence-core').'" />
              
               
            </p>
            </div>';
        }
    }
  
    
  
 
    print '
    </div>    
    <span id="add_new_plan">'.esc_html__('Add new plan','wpresidence-core').'</span>
    ';
   
    
}
endif;


///////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Property Custom details  function
///////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_custom_details_box') ):
function wpestate_custom_details_box(){
     global $post;
     $i=0;
     $custom_fields = wpresidence_get_option( 'wp_estate_custom_fields', '');    
     if( !empty($custom_fields)){  
        while($i< count($custom_fields) ){     
            $name =   $custom_fields[$i][0]; 
            $label =   $custom_fields[$i][1];
            $type =   $custom_fields[$i][2];
            $order =   $custom_fields[$i][3];
            $dropdown_values =   $custom_fields[$i][4];
            
            $slug         =     wpestate_limit45(sanitize_title( $name )); 
            $slug         =     sanitize_key($slug); 
            $post_id      =     $post->ID;
            $show         =     1;
            print ' <div class="property_prop_half">   ';
              wpestate_show_custom_field($show,$slug,$name,$label,$type,$order,$dropdown_values,$post_id);
            print '</div>';  
            $i++;        
       }
    }
    print '<div style="clear:both"></div>';
     
}
endif; // end   wpestate_custom_details_box  


if( !function_exists('wpestate_show_custom_field')):
    function wpestate_show_custom_field( $show,$slug,$name,$label,$type,$order,$dropdown_values,$post_id,$value=''){
    
        // get value
        if($value ==''){
            $value          =   esc_html(get_post_meta($post_id, $slug, true));
            if( $type == 'numeric'  ){
                
                $value          =   (get_post_meta($post_id, $slug, true));
                if($value!==''){
                   $value =  floatval ($value);
                }
                
                
            }else{
                $value          =   esc_html(get_post_meta($post_id, $slug, true));
            }
      
        }
        
        
        $template='';
        if ( $type =='long text' ){
            $template.= '<label for="'.$slug.'">'.$label.' '.esc_html__('(*text)','wpresidence-core').' </label>';
            $template.= '<textarea type="text" id="'.$slug.'"  size="0" name="'.$slug.'" rows="3" cols="42">' .$value. '</textarea>'; 
        }else if( $type =='short text' ){
            $template.=  '<label for="'.$slug.'">'.$label.' '.esc_html__('(*text)','wpresidence-core').' </label>';
            $template.=  '<input type="text" id="'.$slug.'" size="40" name="'.$slug.'" value="' . $value . '">';
        }else if( $type =='numeric'  ){
            $template.=  '<label for="'.$slug.'">'.$label.' '.esc_html__('(*numeric)','wpresidence-core').' </label>';
            $template.=  '<input type="text" id="'.$slug.'" size="40" name="'.$slug.'" value="' . $value . '">';
        }else if( $type =='date' ){
            $template.=  '<label for="'.$slug.'">'.$label.' '.esc_html__('(*date)','wpresidence-core').' </label>';
            $template.=  '<input type="text" id="'.$slug.'" size="40" name="'.$slug.'" value="' .$value . '">';
            $template.= wpestate_date_picker_translation_return($slug);
        }else if( $type =='dropdown' ){
            $dropdown_values_array=explode(',',$dropdown_values);
           
            $template.=  '<label for="'.$slug.'">'.$label.' </label>';
            $template.= '<select id="'.$slug.'"  name="'.$slug.'" >';
            foreach($dropdown_values_array as $key=>$value_drop){
                $template.= '<option value="'.trim($value_drop).'"';
                if( trim( htmlspecialchars_decode($value) ) === trim( htmlspecialchars_decode ($value_drop) ) ){
        
                    $template.=' selected ';
                }
                if (function_exists('icl_translate') ){
                    $value_drop = apply_filters('wpml_translate_single_string', $value_drop,'custom field value','custom_field_value'.$value_drop );
                }
                
                $template.= '>'.trim($value_drop).'</option>';
            }
            $template.= '</select>';
        }
        
        if($show==1){
            print $template;
        }else{
            return $template;
        }
        
    }
endif;





///////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Property Pay Submission  function
///////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_estate_paid_submission') ):

function wpestate_estate_paid_submission(){
    global $post;
    print ' <div class="property_prop_half">   ';
    $paid_submission_status= esc_html ( wpresidence_get_option('wp_estate_paid_submission','') );
    if($paid_submission_status=='no'){
       esc_html_e('Paid Submission is disabled','wpresidence-core');  
    }
    if($paid_submission_status=='membership'){
       esc_html_e('You are on membership mode. There are no details to show for this mode.','wpresidence-core');  
    }
    if($paid_submission_status=='per listing'){
        esc_html_e('Pay Status: ','wpresidence-core');
        $pay_status           = get_post_meta($post->ID, 'pay_status', true);
        if($pay_status=='paid'){
           esc_html_e('PAID','wpresidence-core');
        }
        else{
           esc_html_e('Not Paid','wpresidence-core');
        }
    }
    print'</div>';
    
}
endif; // end   wpestate_estate_paid_submission  




///////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Property details  function
///////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('details_estate_box') ):

function details_estate_box($post) {
    global $post;
    wp_nonce_field(plugin_basename(__FILE__), 'estate_property_noncename');
    
    $mypost             =   $post->ID;
    print'            
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="33%" valign="top" align="left">
            <p class="meta-options">
            <label for="property_price">'.esc_html__('Price: ','wpresidence-core').'</label><br />
            <input type="text" id="property_price" size="40" name="property_price" value="' . esc_html(get_post_meta($mypost, 'property_price', true)) . '">
            </p>
        </td>

        <td width="33%" valign="top" align="left">
            <p class="meta-options">
            <label for="property_label">'.esc_html__('After Price Label(*for example "per month"): ','wpresidence-core').'</label><br />
            <input type="text" id="property_label" size="40" name="property_label" value="' . esc_html(get_post_meta($mypost, 'property_label', true)) . '">
            </p>
        </td>
    </tr>
    <tr>
        <td width="33%" valign="top" align="left">
            <p class="meta-options">
            <label for="property_label_before">'.esc_html__('Before Price Label(*for example "per month"): ','wpresidence-core').'</label><br />
            <input type="text" id="property_label_before" size="40" name="property_label_before" value="' . esc_html(get_post_meta($mypost, 'property_label_before', true)) . '">
            </p>
        </td>
    </tr>
    


    <tr>
    
    <td width="33%" valign="top" align="left">
        <p class="meta-options">
        <label for="property_size">'.esc_html__('Size(*only numbers): ','wpresidence-core').'</label><br />
        <input type="text" id="property_size" size="40" name="property_size" value="' . esc_html(get_post_meta($mypost, 'property_size', true)) . '">
        </p>
    </td>
    
    <td width="33%" valign="top" align="left">
        <p class="meta-options">
        <label for="property_lot_size">'.esc_html__('Lot Size(*only numbers): ','wpresidence-core').'</label><br />
        <input type="text" id="property_lot_size" size="40" name="property_lot_size" value="' . esc_html(get_post_meta($mypost, 'property_lot_size', true)) . '">
        </p>
    </td>   
    </tr>
    
    <tr>      
    <td valign="top" align="left">
        <p class="meta-options">
        <label for="property_rooms">'.esc_html__('Rooms(*only numbers): ','wpresidence-core').'</label><br />
        <input type="text" id="property_rooms" size="40" name="property_rooms" value="' . esc_html(get_post_meta($mypost, 'property_rooms', true)) . '">
        </p>
    </td>
    
    <td valign="top" align="left">
        <p class="meta-options">
        <label for="property_bedrooms">'.esc_html__('Bedrooms(*only numbers): ','wpresidence-core').'</label><br />
        <input type="text" id="property_bedrooms" size="40" name="property_bedrooms" value="' . esc_html(get_post_meta($mypost, 'property_bedrooms', true)) . '">
        </p>
    </td>
    </tr>

    <tr>
    <td valign="top" align="left">  
        <p class="meta-options">
        <label for="property_bedrooms">'.esc_html__('Bathrooms(*only numbers): ','wpresidence-core').'</label><br />
        <input type="text" id="property_bathrooms" size="40" name="property_bathrooms" value="' . esc_html(get_post_meta($mypost, 'property_bathrooms', true)) . '">
        </p>
    </td>
  
    </tr>
    <tr>';
     
     $option_video='';
     $video_values = array('vimeo', 'youtube');
     $video_type = get_post_meta($mypost, 'embed_video_type', true);

     foreach ($video_values as $value) {
         $option_video.='<option value="' . $value . '"';
         if ($value == $video_type) {
             $option_video.='selected="selected"';
         }
         $option_video.='>' . $value . '</option>';
     }
     
     
    print'
    <td valign="top" align="left">
        <p class="meta-options">
        <label for="embed_video_type">'.esc_html__('Video from ','wpresidence-core').'</label><br />
        <select id="embed_video_type" name="embed_video_type" style="width: 237px;">
                ' . $option_video . '
        </select>       
        </p>
    </td>';

  
    print'
    <td valign="top" align="left">
      <p class="meta-options">     
      <label for="embed_video_id">'.esc_html__('Embed Video id: ','wpresidence-core').'</label> <br />
        <input type="text" id="embed_video_id" name="embed_video_id" size="40" value="'.esc_html( get_post_meta($mypost, 'embed_video_id', true) ).'">
      </p>
    </td>
    </tr>';
    
  
     
    print'
    <td valign="top" align="left">
      <p class="meta-options">     
      <label for="embed_video_type">'.esc_html__('Virtual Tour ','wpresidence-core').'</label><br />
        <textarea id="embed_virtual_tour" name="embed_virtual_tour">'.( get_post_meta($mypost, 'embed_virtual_tour', true) ).'</textarea>
    </td>
    </tr>';
    print'
    <td valign="top" align="left">
      <p class="meta-options">     
      <label for="owner_notes">'.esc_html__('Owner/Agent notes (*not visible on front end): ','wpresidence-core').'</label> <br />
        <textarea id="owner_notes" name="owner_notes" >'.esc_html( get_post_meta($mypost, 'owner_notes', true) ).'</textarea>

      </p>
    </td>
    </tr>';
    
    
    print'
    </table>';
}
endif; // end   details_estate_box  



///////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Google map function
///////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_map_estate_box') ):
 
function wpestate_map_estate_box() {
    wp_nonce_field(plugin_basename(__FILE__), 'estate_property_noncename');
    global $post;
    
    $mypost                 =   $post->ID;
    $gmap_lat               =   floatval(get_post_meta($mypost, 'property_latitude', true));
    $gmap_long              =   floatval(get_post_meta($mypost, 'property_longitude', true));
    $google_camera_angle    =   intval( esc_html(get_post_meta($mypost, 'google_camera_angle', true)) );
    $cache_array            =   array('yes','no');
    $keep_min_symbol        =   '';
    $keep_min_status        =   esc_html ( get_post_meta($post->ID, 'keep_min', true) );

    foreach($cache_array as $value){
            $keep_min_symbol.='<option value="'.$value.'"';
            if ($keep_min_status==$value){
                    $keep_min_symbol.=' selected="selected" ';
            }
            $keep_min_symbol.='>'.$value.'</option>';
    }
    
    
    $page_custom_zoom  = get_post_meta($mypost, 'page_custom_zoom', true);
    if ($page_custom_zoom==''){
        $page_custom_zoom=16;
    }
   
    wpestate_date_picker_translation('property_date');
    print'
    <p class="meta-options"> 
    <div id="googleMap" style="width:100%;height:380px;margin-bottom:30px;"></div>    
    <p class="meta-options"> 
        <a class="button" href="#" id="admin_place_pin">'.esc_html__('Place Pin with Property Address','wpresidence-core').'</a>
    </p>
    
    <div class="property_prop_half">
        <label for="embed_video_id">'.esc_html__('Latitude:','wpresidence-core').'</label> <br />
        <input type="text" id="property_latitude" style="margin-right:20px;" size="40" name="property_latitude" value="' . $gmap_lat . '">
    </div>
    
    <div class="property_prop_half">  
        <label for="embed_video_id">'.esc_html__('Longitude:','wpresidence-core').'</label> <br />
        <input type="text" id="property_longitude" style="margin-right:20px;" size="40" name="property_longitude" value="' . $gmap_long . '">
    </div>

   <div class="property_prop_half">  
       <label for="page_custom_zoom">'.esc_html__('Zoom Level for map (1-20)','wpresidence-core').'</label><br />
       <select name="page_custom_zoom" id="page_custom_zoom">';
      
        for ($i=1;$i<21;$i++){
            print '<option value="'.$i.'"';
            if($page_custom_zoom==$i){
                print ' selected="selected" ';
            }
            print '>'.$i.'</option>';
        }
        
        print'
        </select>
    </div>
    

    <div class="property_prop_half" style="padding-top:20px;">  
        <input type="hidden" name="property_google_view" value="">
        <input type="checkbox"  id="property_google_view" name="property_google_view" value="1" ';
            if (esc_html(get_post_meta($mypost, 'property_google_view', true)) == 1) {
                print'checked="checked"';
            }
            print' />
        <label class="checklabel" for="property_google_view">'.esc_html__('Enable Google Street View','wpresidence-core').'</label>
    </div>    


    <div class="property_prop_half">  
        <label for="google_camera_angle" >'.esc_html__('Google View Camera Angle','wpresidence-core').'</label>
        <input type="text" id="google_camera_angle" style="margin-right:0px;" size="5" name="google_camera_angle" value="'.$google_camera_angle.'">
    </div>

   
    ';     
}
endif; // end   wpestate_map_estate_box 




///////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Agent box function
///////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_agentestate_box') ):
function wpestate_agentestate_box() {
    global $post;
    wp_nonce_field(plugin_basename(__FILE__), 'estate_property_noncename');
   
    $mypost             =   $post->ID;
    $originalpost       =   $post;
    $agent_list         =   '';
    $agent_list_sec     =   '';
    $picked_agent       =   get_post_meta($mypost, 'property_agent', true);
    $agents_secondary   =   get_post_meta($mypost, 'property_agent_secondary', true);
    

    $args = array(
       'post_type'      => array('estate_agent','estate_agency','estate_developer'),
       'post_status'    => 'publish',
       'posts_per_page' => 150
       );
    
    $agent_selection  =  new WP_Query($args);

    while ($agent_selection->have_posts()){
        $agent_selection->the_post();  
        $the_id       =  get_the_ID();

        $agent_list  .=  '<option value="' . $the_id . '"  ';
        if ($the_id == $picked_agent) {
            $agent_list.=' selected="selected" ';
        }
        $agent_list.= '>' . get_the_title() . '</option>';
        
      
        
    }
      
    wp_reset_postdata();
    
    
    $args2 = array(
       'post_type'      => array('estate_agent'),
       'post_status'    => 'publish',
       'posts_per_page' => 150
       );
    
    $agent_selection2  =  new WP_Query($args2);
    while ($agent_selection2->have_posts()){
        $agent_selection2->the_post();  
        $the_id       =  get_the_ID();

      
        
        
        $agent_list_sec .=  '<option value="' . $the_id . '"  ';
        if ( is_array($agents_secondary) && in_array($the_id,$agents_secondary) ) {
            $agent_list_sec.=' selected="selected" ';
        }
        $agent_list_sec.= '>' . get_the_title() . '</option>';
        
    }
    wp_reset_postdata();
    
    
    $post = $originalpost;
      
    print '
        <div class="property_prop_half">  
        <label for="property_agent">'.esc_html__('Main Agent: ','wpresidence-core').'</label><br />
        <select id="property_agent" style="width: 237px;" name="property_agent">
            <option value="">none</option>
            <option value=""></option>
            '. $agent_list .'
        </select>
        </div>';  
    
    
    $originalpost   =   $post;
    $blog_list      =   '';
    $original_user  =   wpsestate_get_author();


    
    $blogusers = get_users( 'blog_id=1&orderby=nicename&role=subscriber' );

    foreach ( $blogusers as $user ) {
 
        $the_id=$user->ID;
        $blog_list  .=  '<option value="' . $the_id . '"  ';
            if ($the_id == $original_user) {
                $blog_list.=' selected="selected" ';
            }
        $blog_list.= '>' .$user->user_login . '</option>';
    }


    
      
    print '
    <div class="property_prop_half">  
        <label for="property_user">'.esc_html__('User: ','wpresidence-core').'</label><br />
        <select id="property_user" style="width: 237px;" name="property_user">
            <option value=""></option>
            <option value="1">admin</option>
            '. $blog_list .'
        </select>
      </div>';  
    
 
       print '
        <div class="property_prop_half">  
        <label for="property_agent_secondary">'.esc_html__('Secondary Agents(*multiple selection): ','wpresidence-core').'</label><br />
        <select id="property_agent_secondary" style="width: 237px;height:250px" multiple="multiple" name="property_agent_secondary[]">
            <option value="">none</option>
            <option value=""></option>
            '. $agent_list_sec .'
        </select>
        </div>';  
       
       
       
    
}
endif; // end   wpestate_agentestate_box  





///////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Features And Amenties function
///////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_amenities_estate_box') ):
function wpestate_amenities_estate_box() {
    wp_nonce_field(plugin_basename(__FILE__), 'estate_property_noncename');
    global $post;
    $mypost             =   $post->ID;
    $feature_list_array =   array();
    $feature_list       =   esc_html( wpresidence_get_option('wp_estate_feature_list') );
    $feature_list_array =   explode( ',',$feature_list);
    $counter            =   0;
    

    foreach($feature_list_array as $key => $value){
        $counter++;
        $post_var_name=  str_replace(' ','_', trim($value) );
        $value_label=$value;
        if (function_exists('icl_translate') ){
            $value_label    =   icl_translate('wpresidence-core','wp_estate_property_custom_amm_'.$value, $value ) ;                                      
        }
    
    
        if( ($counter-1) % 3 == 0){
            print'<tr>';
        }
        $input_name =   wpestate_limit45(sanitize_title( $post_var_name ));
        $input_name =   sanitize_key($input_name);
      
      
        print '     
        <div class="property_prop_half propcheck"  style="padding-top:20px;">
            <input type="hidden"    name="'.$input_name.'" value="">
            <input type="checkbox"  name="'.$input_name.'" value="1" ';
        
        if (esc_html(get_post_meta($mypost, $input_name, true)) == 1) {
            print' checked="checked" ';
        }
        print' />
            <label class="checklabel" for="'.$input_name.'">'.stripslashes($value_label).'</label>
           
        </div>';
       
    }
  
}
endif; // end   wpestate_amenities_estate_box  



///////////////////////////////////////////////////////////////////////////////////////////////////////////
/// Property custom fields
///////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_property_add_media') ): 
function wpestate_property_add_media() {


global $post;

$arguments      = array(
    'numberposts' => -1,
    'post_type' => 'attachment',
    'post_mime_type' => 'image',
    'post_parent' => $post->ID,
    'post_status' => null,
    'exclude' => get_post_thumbnail_id(),
    'orderby' => 'menu_order',
    'order' => 'ASC',
    'orderby' => 'menu_order',
    'order' => 'ASC'
    );

$already_in='';
$post_attachments   = get_posts($arguments);

print '<div class="property_uploaded_thumb_wrapepr" id="property_uploaded_thumb_wrapepr">';
$ajax_nonce = wp_create_nonce( "wpestate_attach_delete" );
print'<input type="hidden" id="wpestate_attach_delete" value="'.esc_html($ajax_nonce).'" />    ';
foreach ($post_attachments as $attachment) {
    
    $already_in         =   $already_in.$attachment->ID.',';
    $preview            =   wp_get_attachment_image_src($attachment->ID, 'thumbnail');
    print '<div class="uploaded_thumb" data-imageid="'.$attachment->ID.'">
        <img  src="'.$preview[0].'"  alt="slider" />
        <a target="_blank" href="'.esc_url(admin_url() ) .'post.php?post='.$attachment->ID.'&action=edit" class="attach_edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>
        <span class="attach_delete"><i class="fa fa-trash-o" aria-hidden="true"></i></span>
    </div>';
}
  
print '<input type="hidden" id="image_to_attach" name="image_to_attach" value="'.$already_in.'"/>';
 

print '</div>';

print '<button class="upload_button button" id="button_new_image" data-postid="'.$post->ID.'">'.esc_html__('Upload new Image','wpresidence-core').'</button>';
  
 
    $mypost = $post->ID;
    $option_video='';
    $video_values = array('vimeo', 'youtube');
    $video_type = get_post_meta($mypost, 'embed_video_type', true);
    $property_custom_video= get_post_meta($mypost, 'property_custom_video', true);
    
    foreach ($video_values as $value) {
        $option_video.='<option value="' . $value . '"';
        if ($value == $video_type) {
            $option_video.='selected="selected"';
        }
        $option_video.='>' . $value . '</option>';
    }
     
 

  
    print'
    <div class="property_prop_half" style="clear: both;">   
        <label for="embed_video_id">'.esc_html__('Video From: ','wpresidence-core').'</label> <br />
         <select id="embed_video_type" name="embed_video_type" >
                ' . $option_video . '
        </select>  
    </div>
    

    <div class="property_prop_half">   
        <label for="embed_video_id">'.esc_html__('Embed Video id: ','wpresidence-core').'</label> <br />
        <input type="text" id="embed_video_id" name="embed_video_id" size="40" value="'.esc_html( get_post_meta($mypost, 'embed_video_id', true) ).'">
    </div>';
    
  
    print'<div class="property_prop_half prop_full">
            <label for="property_custom_video_button">'.esc_html__('Video Placeholder Image','wpresidence-core').'</label><br />
            <input id="property_custom_video" type="text" size="36" name="property_custom_video" value="'.esc_url($property_custom_video).'" />
            <input id="property_custom_video_button" type="button"   size="40" class="upload_button button" value="'.esc_html__('Upload Image','wpresidence-core').'" />
        </div>';
    
    print'
    <div class="property_prop_half">   
        <label for="embed_video_type">'.esc_html__('Virtual Tour ','wpresidence-core').'</label><br />
        <textarea id="embed_virtual_tour" name="embed_virtual_tour">'.( get_post_meta($mypost, 'embed_virtual_tour', true) ).'</textarea>
    </div>';
}
endif;

if( !function_exists('wpestate_estate_box') ): 
function wpestate_estate_box() {
    global $post;
    wp_nonce_field(plugin_basename(__FILE__), 'estate_property_noncename');
    $mypost = $post->ID;
    
    
    print'            
    <div class="property_prop_half">
        <label for="property_price">'.esc_html__('Price: ','wpresidence-core').'</label><br />
        <input type="text" id="property_price" size="40" name="property_price" value="' . esc_html(get_post_meta($mypost, 'property_price', true)) . '">
    </div>
    
    <div class="property_prop_half">
        <label for="property_label">'.esc_html__('After Price Label(*for example "per month"): ','wpresidence-core').'</label><br />
        <input type="text" id="property_label" size="40" name="property_label" value="' . esc_html(get_post_meta($mypost, 'property_label', true)) . '">
    </div>
    
    <div class="property_prop_half">
        <label for="property_label_before">'.esc_html__('Before Price Label(*for example "per month"): ','wpresidence-core').'</label><br />
        <input type="text" id="property_label_before" size="40" name="property_label_before" value="' . esc_html(get_post_meta($mypost, 'property_label_before', true)) . '">
    </div>
    
 
    
    <div class="property_prop_half">
        <label for="property_address">'.esc_html__('Address(*only street name and building no): ','wpresidence-core').'</label><br />
        <input type="text" type="text" id="property_address"  size="40" name="property_address" value="' . esc_html(get_post_meta($mypost, 'property_address', true)) . '" >
    </div>
   
    <div class="property_prop_half">
        <label for="property_zip">'.esc_html__('Zip: ','wpresidence-core').'</label><br />
        <input type="text" id="property_zip" size="40" name="property_zip" value="' . esc_html(get_post_meta($mypost, 'property_zip', true)) . '">
    </div>
    
    <div class="property_prop_half">
        <label for="property_country">'.esc_html__('Country: ','wpresidence-core').'</label><br />';
    print wpestate_country_list(esc_html(get_post_meta($mypost, 'property_country', true)));
    print '</div>
    
    
    <div class="property_prop_half">
        <label for="property_size">'.esc_html__('Size(*only numbers): ','wpresidence-core').'</label><br />
        <input type="text" id="property_size" size="40" name="property_size" value="' . esc_html(get_post_meta($mypost, 'property_size', true)) . '">
    </div>

    <div class="property_prop_half">
        <label for="property_lot_size">'.esc_html__('Lot Size(*only numbers): ','wpresidence-core').'</label><br />
        <input type="text" id="property_lot_size" size="40" name="property_lot_size" value="' . esc_html(get_post_meta($mypost, 'property_lot_size', true)) . '">
    </div>
    
    <div class="property_prop_half">    
        <label for="property_rooms">'.esc_html__('Rooms(*only numbers): ','wpresidence-core').'</label><br />
        <input type="text" id="property_rooms" size="40" name="property_rooms" value="' . esc_html(get_post_meta($mypost, 'property_rooms', true)) . '">
    </div>        

    <div class="property_prop_half">
        <label for="property_bedrooms">'.esc_html__('Bedrooms(*only numbers): ','wpresidence-core').'</label><br />
        <input type="text" id="property_bedrooms" size="40" name="property_bedrooms" value="' . esc_html(get_post_meta($mypost, 'property_bedrooms', true)) . '">
    </div>
    
    <div class="property_prop_half">  
        <label for="property_bedrooms">'.esc_html__('Bathrooms(*only numbers): ','wpresidence-core').'</label><br />
        <input type="text" id="property_bathrooms" size="40" name="property_bathrooms" value="' . esc_html(get_post_meta($mypost, 'property_bathrooms', true)) . '">
    </div>
	<div class="property_prop_half">  
        <label for="energy_index">'.esc_html__('Energy Index in kWh/m2a: ','wpresidence-core').'</label><br />
        <input type="text" id="energy_index" size="40" name="energy_index" value="' . esc_html(get_post_meta($mypost, 'energy_index', true)) . '">
    </div>
	
	';
     
    
  
     
 
    print'
    <div class="property_prop_half prop_half"> 
        <label for="owner_notes">'.esc_html__('Owner/Agent notes (*not visible on front end): ','wpresidence-core').'</label> <br />
        <textarea id="owner_notes" name="owner_notes" >'.esc_html( get_post_meta($mypost, 'owner_notes', true) ).'</textarea>
    </div>
    ';
    
    print'
    <div class="property_prop_half">  
        <label for="energy_class">'.esc_html__('Energy Class: ','wpresidence-core').'</label><br />
		<select name="energy_class" id="energy_class">
			<option value="">'.esc_html__('Select Energy Class (EU regulation)','wpresidence-core');
			$energy_class_array = array( 'A+', 'A', 'B', 'C', 'D', 'E', 'F', 'G' );
			foreach( $energy_class_array as $single_class ){
				print '<option value="'.$single_class.'" '.(  get_post_meta($mypost, 'energy_class', true) ==  $single_class ? ' selected ' : '' ).' >'.$single_class;
			}
	 print'
		</select>
    </div>
    ';
   
    
    $status_values          =   esc_html( wpresidence_get_option('wp_estate_status_list') );
    $status_values_array    =   explode(",",$status_values);
    $prop_stat              =   get_post_meta($mypost, 'property_status', true);
    $property_status        =   '';

    
    foreach ($status_values_array as $key=>$value) {
        if(trim($value)!= ''){
            if (function_exists('icl_translate') ){
                $value     =   icl_translate('wpresidence-core','wp_estate_property_status_'.$value, $value ) ;                                      
            }

            $value = trim($value);
            $property_status.='<option value="' . $value . '"';
            if ($value == $prop_stat) {
                $property_status.='selected="selected"';
            }
            $property_status.='>' .stripslashes( $value ). '</option>';
        }   
    }
    
    
    
    
    $normal_selected='';
    if ( trim($status_values)==''){
      print   $normal_selected= ' selected ' ;
    }

 
    print'    
    <div class="property_prop_half">
        <label for="property_status">'.esc_html__('Property Status:','wpresidence-core').'</label><br />
        <select id="property_status"  name="property_status">
        <option value="normal" '.$normal_selected.'>normal</option>
        ' . $property_status . '
        </select>
    </div>
    
     <div class="property_prop_half" style="padding-top:20px;">
            <input type="hidden" name="prop_featured" value="0">
            <input type="checkbox"  id="prop_featured" name="prop_featured" value="1" ';
            if (intval(get_post_meta($mypost, 'prop_featured', true)) == 1) {
                print'checked="checked"';
            }
            print' />
            <label class="checklabel" for="prop_featured">'.esc_html__('Make it Featured Property','wpresidence-core').'</label>
    </div>  ';
    
    $theme_slider   =   wpresidence_get_option( 'wp_estate_theme_slider', ''); 
    print '
    <div class="property_prop_half">
        <input type="hidden" name="property_theme_slider" value="0">
        <input type="checkbox"  id="property_theme_slider" name="property_theme_slider" value="1" ';
        
        if ( is_array($theme_slider) && in_array ( $mypost, $theme_slider) ) {
            print'checked="checked"';
        }
        print' />
        <label class="checklabel" for="property_theme_slider">'.esc_html__('Property in theme Slider','wpresidence-core').'</label>
    </div>

 
	
	
	
    ';
       
}
endif; // end    


///////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Country list function
///////////////////////////////////////////////////////////////////////////////////////////////////////////


if( !function_exists('wpestate_country_list') ): 
function wpestate_country_list($selected,$class='') {
    $countries = array(esc_html__("Afghanistan","wpresidence-core"),esc_html__("Albania","wpresidence-core"),esc_html__("Algeria","wpresidence-core"),esc_html__("American Samoa","wpresidence-core"),esc_html__("Andorra","wpresidence-core"),esc_html__("Angola","wpresidence-core"),esc_html__("Anguilla","wpresidence-core"),esc_html__("Antarctica","wpresidence-core"),esc_html__("Antigua and Barbuda","wpresidence-core"),esc_html__("Argentina","wpresidence-core"),esc_html__("Armenia","wpresidence-core"),esc_html__("Aruba","wpresidence-core"),esc_html__("Australia","wpresidence-core"),esc_html__("Austria","wpresidence-core"),esc_html__("Azerbaijan","wpresidence-core"),esc_html__("Bahamas","wpresidence-core"),esc_html__("Bahrain","wpresidence-core"),esc_html__("Bangladesh","wpresidence-core"),esc_html__("Barbados","wpresidence-core"),esc_html__("Belarus","wpresidence-core"),esc_html__("Belgium","wpresidence-core"),esc_html__("Belize","wpresidence-core"),esc_html__("Benin","wpresidence-core"),esc_html__("Bermuda","wpresidence-core"),esc_html__("Bhutan","wpresidence-core"),esc_html__("Bolivia","wpresidence-core"),esc_html__("Bosnia and Herzegowina","wpresidence-core"),esc_html__("Botswana","wpresidence-core"),esc_html__("Bouvet Island","wpresidence-core"),esc_html__("Brazil","wpresidence-core"),esc_html__("British Indian Ocean Territory","wpresidence-core"),esc_html__("Brunei Darussalam","wpresidence-core"),esc_html__("Bulgaria","wpresidence-core"),esc_html__("Burkina Faso","wpresidence-core"),esc_html__("Burundi","wpresidence-core"),esc_html__("Cambodia","wpresidence-core"),esc_html__("Cameroon","wpresidence-core"),esc_html__("Canada","wpresidence-core"),esc_html__("Cape Verde","wpresidence-core"),esc_html__("Cayman Islands","wpresidence-core"),esc_html__("Central African Republic","wpresidence-core"),esc_html__("Chad","wpresidence-core"),esc_html__("Chile","wpresidence-core"),esc_html__("China","wpresidence-core"),esc_html__("Christmas Island","wpresidence-core"),esc_html__("Cocos (Keeling) Islands","wpresidence-core"),esc_html__("Colombia","wpresidence-core"),esc_html__("Comoros","wpresidence-core"),esc_html__("Congo","wpresidence-core"),esc_html__("Congo, the Democratic Republic of the","wpresidence-core"),esc_html__("Cook Islands","wpresidence-core"),esc_html__("Costa Rica","wpresidence-core"),esc_html__("Cote d'Ivoire","wpresidence-core"),esc_html__("Croatia (Hrvatska)","wpresidence-core"),esc_html__("Cuba","wpresidence-core"),esc_html__('Curacao','wpresidence-core'),esc_html__("Cyprus","wpresidence-core"),esc_html__("Czech Republic","wpresidence-core"),esc_html__("Denmark","wpresidence-core"),esc_html__("Djibouti","wpresidence-core"),esc_html__("Dominica","wpresidence-core"),esc_html__("Dominican Republic","wpresidence-core"),esc_html__("East Timor","wpresidence-core"),esc_html__("Ecuador","wpresidence-core"),esc_html__("Egypt","wpresidence-core"),esc_html__("El Salvador","wpresidence-core"),esc_html__("Equatorial Guinea","wpresidence-core"),esc_html__("Eritrea","wpresidence-core"),esc_html__("Estonia","wpresidence-core"),esc_html__("Ethiopia","wpresidence-core"),esc_html__("Falkland Islands (Malvinas)","wpresidence-core"),esc_html__("Faroe Islands","wpresidence-core"),esc_html__("Fiji","wpresidence-core"),esc_html__("Finland","wpresidence-core"),esc_html__("France","wpresidence-core"),esc_html__("France Metropolitan","wpresidence-core"),esc_html__("French Guiana","wpresidence-core"),esc_html__("French Polynesia","wpresidence-core"),esc_html__("French Southern Territories","wpresidence-core"),esc_html__("Gabon","wpresidence-core"),esc_html__("Gambia","wpresidence-core"),esc_html__("Georgia","wpresidence-core"),esc_html__("Germany","wpresidence-core"),esc_html__("Ghana","wpresidence-core"),esc_html__("Gibraltar","wpresidence-core"),esc_html__("Greece","wpresidence-core"),esc_html__("Greenland","wpresidence-core"),esc_html__("Grenada","wpresidence-core"),esc_html__("Guadeloupe","wpresidence-core"),esc_html__("Guam","wpresidence-core"),esc_html__("Guatemala","wpresidence-core"),esc_html__("Guinea","wpresidence-core"),esc_html__("Guinea-Bissau","wpresidence-core"),esc_html__("Guyana","wpresidence-core"),esc_html__("Haiti","wpresidence-core"),esc_html__("Heard and Mc Donald Islands","wpresidence-core"),esc_html__("Holy See (Vatican City State)","wpresidence-core"),esc_html__("Honduras","wpresidence-core"),esc_html__("Hong Kong","wpresidence-core"),esc_html__("Hungary","wpresidence-core"),esc_html__("Iceland","wpresidence-core"),esc_html__("India","wpresidence-core"),esc_html__("Indonesia","wpresidence-core"),esc_html__("Iran (Islamic Republic of)","wpresidence-core"),esc_html__("Iraq","wpresidence-core"),esc_html__("Ireland","wpresidence-core"),esc_html__("Israel","wpresidence-core"),esc_html__("Italy","wpresidence-core"),esc_html__("Jamaica","wpresidence-core"),esc_html__("Japan","wpresidence-core"),esc_html__("Jordan","wpresidence-core"),esc_html__("Kazakhstan","wpresidence-core"),esc_html__("Kenya","wpresidence-core"),esc_html__("Kiribati","wpresidence-core"),esc_html__("Korea, Democratic People's Republic of","wpresidence-core"),esc_html__("Korea, Republic of","wpresidence-core"),esc_html__("Kuwait","wpresidence-core"),esc_html__("Kyrgyzstan","wpresidence-core"),esc_html__("Lao, People's Democratic Republic","wpresidence-core"),esc_html__("Latvia","wpresidence-core"),esc_html__("Lebanon","wpresidence-core"),esc_html__("Lesotho","wpresidence-core"),esc_html__("Liberia","wpresidence-core"),esc_html__("Libyan Arab Jamahiriya","wpresidence-core"),esc_html__("Liechtenstein","wpresidence-core"),esc_html__("Lithuania","wpresidence-core"),esc_html__("Luxembourg","wpresidence-core"),esc_html__("Macau","wpresidence-core"),esc_html__("Macedonia (FYROM)","wpresidence-core"),esc_html__("Madagascar","wpresidence-core"),esc_html__("Malawi","wpresidence-core"),esc_html__("Malaysia","wpresidence-core"),esc_html__("Maldives","wpresidence-core"),esc_html__("Mali","wpresidence-core"),esc_html__("Malta","wpresidence-core"),esc_html__("Marshall Islands","wpresidence-core"),esc_html__("Martinique","wpresidence-core"),esc_html__("Mauritania","wpresidence-core"),esc_html__("Mauritius","wpresidence-core"),esc_html__("Mayotte","wpresidence-core"),esc_html__("Mexico","wpresidence-core"),esc_html__("Micronesia, Federated States of","wpresidence-core"),esc_html__("Moldova, Republic of","wpresidence-core"),esc_html__("Monaco","wpresidence-core"),esc_html__("Mongolia","wpresidence-core"),esc_html__("Montserrat","wpresidence-core"),esc_html__("Morocco","wpresidence-core"),esc_html__("Mozambique","wpresidence-core"),esc_html__("Montenegro","wpresidence-core"),esc_html__("Myanmar","wpresidence-core"),esc_html__("Namibia","wpresidence-core"),esc_html__("Nauru","wpresidence-core"),esc_html__("Nepal","wpresidence-core"),esc_html__("Netherlands","wpresidence-core"),esc_html__("Netherlands Antilles","wpresidence-core"),esc_html__("New Caledonia","wpresidence-core"),esc_html__("New Zealand","wpresidence-core"),esc_html__("Nicaragua","wpresidence-core"),esc_html__("Niger","wpresidence-core"),esc_html__("Nigeria","wpresidence-core"),esc_html__("Niue","wpresidence-core"),esc_html__("Norfolk Island","wpresidence-core"),esc_html__("Northern Mariana Islands","wpresidence-core"),esc_html__("Norway","wpresidence-core"),esc_html__("Oman","wpresidence-core"),esc_html__("Pakistan","wpresidence-core"),esc_html__("Palau","wpresidence-core"),esc_html__("Panama","wpresidence-core"),esc_html__("Papua New Guinea","wpresidence-core"),esc_html__("Paraguay","wpresidence-core"),esc_html__("Peru","wpresidence-core"),esc_html__("Philippines","wpresidence-core"),esc_html__("Pitcairn","wpresidence-core"),esc_html__("Poland","wpresidence-core"),esc_html__("Portugal","wpresidence-core"),esc_html__("Puerto Rico","wpresidence-core"),esc_html__("Qatar","wpresidence-core"),esc_html__("Reunion","wpresidence-core"),esc_html__("Romania","wpresidence-core"),esc_html__("Russian Federation","wpresidence-core"),esc_html__("Rwanda","wpresidence-core"),esc_html__("Saint Kitts and Nevis","wpresidence-core"),esc_html__("Saint Martin","wpresidence-core"),esc_html__("Saint Lucia","wpresidence-core"),esc_html__("Saint Vincent and the Grenadines","wpresidence-core"),esc_html__("Samoa","wpresidence-core"),esc_html__("San Marino","wpresidence-core"),esc_html__("Sao Tome and Principe","wpresidence-core"),esc_html__("Saudi Arabia","wpresidence-core"),esc_html__("Senegal","wpresidence-core"),esc_html__("Seychelles","wpresidence-core"),esc_html__("Serbia","wpresidence-core"),esc_html__("Sierra Leone","wpresidence-core"),esc_html__("Singapore","wpresidence-core"),esc_html__("Slovakia (Slovak Republic)","wpresidence-core"),esc_html__("Slovenia","wpresidence-core"),esc_html__("Solomon Islands","wpresidence-core"),esc_html__("Somalia","wpresidence-core"),esc_html__("South Africa","wpresidence-core"),esc_html__("South Georgia and the South Sandwich Islands","wpresidence-core"),esc_html__("Spain","wpresidence-core"),esc_html__("Sri Lanka","wpresidence-core"),esc_html__("St. Helena","wpresidence-core"),esc_html__("St. Pierre and Miquelon","wpresidence-core"),esc_html__("Sudan","wpresidence-core"),esc_html__("Suriname","wpresidence-core"),esc_html__("Svalbard and Jan Mayen Islands","wpresidence-core"),esc_html__("Swaziland","wpresidence-core"),esc_html__("Sweden","wpresidence-core"),esc_html__("Switzerland","wpresidence-core"),esc_html__("Syrian Arab Republic","wpresidence-core"),esc_html__("Taiwan, Province of China","wpresidence-core"),esc_html__("Tajikistan","wpresidence-core"),esc_html__("Tanzania, United Republic of","wpresidence-core"),esc_html__("Thailand","wpresidence-core"),esc_html__("Togo","wpresidence-core"),esc_html__("Tokelau","wpresidence-core"),esc_html__("Tonga","wpresidence-core"),esc_html__("Trinidad and Tobago","wpresidence-core"),esc_html__("Tunisia","wpresidence-core"),esc_html__("Turkey","wpresidence-core"),esc_html__("Turkmenistan","wpresidence-core"),esc_html__("Turks and Caicos Islands","wpresidence-core"),esc_html__("Tuvalu","wpresidence-core"),esc_html__("Uganda","wpresidence-core"),esc_html__("Ukraine","wpresidence-core"),esc_html__("United Arab Emirates","wpresidence-core"),esc_html__("United Kingdom","wpresidence-core"),esc_html__("United States","wpresidence-core"),esc_html__("United States Minor Outlying Islands","wpresidence-core"),esc_html__("Uruguay","wpresidence-core"),esc_html__("Uzbekistan","wpresidence-core"),esc_html__("Vanuatu","wpresidence-core"),esc_html__("Venezuela","wpresidence-core"),esc_html__("Vietnam","wpresidence-core"),esc_html__("Virgin Islands (British)","wpresidence-core"),esc_html__("Virgin Islands (U.S.)","wpresidence-core"),esc_html__("Wallis and Futuna Islands","wpresidence-core"),esc_html__("Western Sahara","wpresidence-core"),esc_html__("Yemen","wpresidence-core"),esc_html__("Zambia","wpresidence-core"),esc_html__("Zimbabwe","wpresidence-core"));

    $country_select = '<select id="property_country"  name="property_country" class="'.$class.'">';

    if ($selected == '') {
        $selected = wpresidence_get_option('wp_estate_general_country');
    }
    foreach ($countries as $country) {
        $country_select.='<option value="' . $country . '"';
        if ($selected == $country) {
            $country_select.='selected="selected"';
        }
        $country_select.='>' . $country . '</option>';
    }

    $country_select.='</select>';
    return $country_select;
}
endif; // end   wpestate_country_list 



if( !function_exists('wpestate_country_list_search') ): 
function wpestate_country_list_search($selected) {
    $countries = array(esc_html__("Afghanistan","wpresidence-core"),esc_html__("Albania","wpresidence-core"),esc_html__("Algeria","wpresidence-core"),esc_html__("American Samoa","wpresidence-core"),esc_html__("Andorra","wpresidence-core"),esc_html__("Angola","wpresidence-core"),esc_html__("Anguilla","wpresidence-core"),esc_html__("Antarctica","wpresidence-core"),esc_html__("Antigua and Barbuda","wpresidence-core"),esc_html__("Argentina","wpresidence-core"),esc_html__("Armenia","wpresidence-core"),esc_html__("Aruba","wpresidence-core"),esc_html__("Australia","wpresidence-core"),esc_html__("Austria","wpresidence-core"),esc_html__("Azerbaijan","wpresidence-core"),esc_html__("Bahamas","wpresidence-core"),esc_html__("Bahrain","wpresidence-core"),esc_html__("Bangladesh","wpresidence-core"),esc_html__("Barbados","wpresidence-core"),esc_html__("Belarus","wpresidence-core"),esc_html__("Belgium","wpresidence-core"),esc_html__("Belize","wpresidence-core"),esc_html__("Benin","wpresidence-core"),esc_html__("Bermuda","wpresidence-core"),esc_html__("Bhutan","wpresidence-core"),esc_html__("Bolivia","wpresidence-core"),esc_html__("Bosnia and Herzegowina","wpresidence-core"),esc_html__("Botswana","wpresidence-core"),esc_html__("Bouvet Island","wpresidence-core"),esc_html__("Brazil","wpresidence-core"),esc_html__("British Indian Ocean Territory","wpresidence-core"),esc_html__("Brunei Darussalam","wpresidence-core"),esc_html__("Bulgaria","wpresidence-core"),esc_html__("Burkina Faso","wpresidence-core"),esc_html__("Burundi","wpresidence-core"),esc_html__("Cambodia","wpresidence-core"),esc_html__("Cameroon","wpresidence-core"),esc_html__("Canada","wpresidence-core"),esc_html__("Cape Verde","wpresidence-core"),esc_html__("Cayman Islands","wpresidence-core"),esc_html__("Central African Republic","wpresidence-core"),esc_html__("Chad","wpresidence-core"),esc_html__("Chile","wpresidence-core"),esc_html__("China","wpresidence-core"),esc_html__("Christmas Island","wpresidence-core"),esc_html__("Cocos (Keeling) Islands","wpresidence-core"),esc_html__("Colombia","wpresidence-core"),esc_html__("Comoros","wpresidence-core"),esc_html__("Congo","wpresidence-core"),esc_html__("Congo, the Democratic Republic of the","wpresidence-core"),esc_html__("Cook Islands","wpresidence-core"),esc_html__("Costa Rica","wpresidence-core"),esc_html__("Cote d'Ivoire","wpresidence-core"),esc_html__("Croatia (Hrvatska)","wpresidence-core"),esc_html__("Cuba","wpresidence-core"),esc_html__('Curacao','wpresidence-core'),esc_html__("Cyprus","wpresidence-core"),esc_html__("Czech Republic","wpresidence-core"),esc_html__("Denmark","wpresidence-core"),esc_html__("Djibouti","wpresidence-core"),esc_html__("Dominica","wpresidence-core"),esc_html__("Dominican Republic","wpresidence-core"),esc_html__("East Timor","wpresidence-core"),esc_html__("Ecuador","wpresidence-core"),esc_html__("Egypt","wpresidence-core"),esc_html__("El Salvador","wpresidence-core"),esc_html__("Equatorial Guinea","wpresidence-core"),esc_html__("Eritrea","wpresidence-core"),esc_html__("Estonia","wpresidence-core"),esc_html__("Ethiopia","wpresidence-core"),esc_html__("Falkland Islands (Malvinas)","wpresidence-core"),esc_html__("Faroe Islands","wpresidence-core"),esc_html__("Fiji","wpresidence-core"),esc_html__("Finland","wpresidence-core"),esc_html__("France","wpresidence-core"),esc_html__("France Metropolitan","wpresidence-core"),esc_html__("French Guiana","wpresidence-core"),esc_html__("French Polynesia","wpresidence-core"),esc_html__("French Southern Territories","wpresidence-core"),esc_html__("Gabon","wpresidence-core"),esc_html__("Gambia","wpresidence-core"),esc_html__("Georgia","wpresidence-core"),esc_html__("Germany","wpresidence-core"),esc_html__("Ghana","wpresidence-core"),esc_html__("Gibraltar","wpresidence-core"),esc_html__("Greece","wpresidence-core"),esc_html__("Greenland","wpresidence-core"),esc_html__("Grenada","wpresidence-core"),esc_html__("Guadeloupe","wpresidence-core"),esc_html__("Guam","wpresidence-core"),esc_html__("Guatemala","wpresidence-core"),esc_html__("Guinea","wpresidence-core"),esc_html__("Guinea-Bissau","wpresidence-core"),esc_html__("Guyana","wpresidence-core"),esc_html__("Haiti","wpresidence-core"),esc_html__("Heard and Mc Donald Islands","wpresidence-core"),esc_html__("Holy See (Vatican City State)","wpresidence-core"),esc_html__("Honduras","wpresidence-core"),esc_html__("Hong Kong","wpresidence-core"),esc_html__("Hungary","wpresidence-core"),esc_html__("Iceland","wpresidence-core"),esc_html__("India","wpresidence-core"),esc_html__("Indonesia","wpresidence-core"),esc_html__("Iran (Islamic Republic of)","wpresidence-core"),esc_html__("Iraq","wpresidence-core"),esc_html__("Ireland","wpresidence-core"),esc_html__("Israel","wpresidence-core"),esc_html__("Italy","wpresidence-core"),esc_html__("Jamaica","wpresidence-core"),esc_html__("Japan","wpresidence-core"),esc_html__("Jordan","wpresidence-core"),esc_html__("Kazakhstan","wpresidence-core"),esc_html__("Kenya","wpresidence-core"),esc_html__("Kiribati","wpresidence-core"),esc_html__("Korea, Democratic People's Republic of","wpresidence-core"),esc_html__("Korea, Republic of","wpresidence-core"),esc_html__("Kuwait","wpresidence-core"),esc_html__("Kyrgyzstan","wpresidence-core"),esc_html__("Lao, People's Democratic Republic","wpresidence-core"),esc_html__("Latvia","wpresidence-core"),esc_html__("Lebanon","wpresidence-core"),esc_html__("Lesotho","wpresidence-core"),esc_html__("Liberia","wpresidence-core"),esc_html__("Libyan Arab Jamahiriya","wpresidence-core"),esc_html__("Liechtenstein","wpresidence-core"),esc_html__("Lithuania","wpresidence-core"),esc_html__("Luxembourg","wpresidence-core"),esc_html__("Macau","wpresidence-core"),esc_html__("Macedonia (FYROM)","wpresidence-core"),esc_html__("Madagascar","wpresidence-core"),esc_html__("Malawi","wpresidence-core"),esc_html__("Malaysia","wpresidence-core"),esc_html__("Maldives","wpresidence-core"),esc_html__("Mali","wpresidence-core"),esc_html__("Malta","wpresidence-core"),esc_html__("Marshall Islands","wpresidence-core"),esc_html__("Martinique","wpresidence-core"),esc_html__("Mauritania","wpresidence-core"),esc_html__("Mauritius","wpresidence-core"),esc_html__("Mayotte","wpresidence-core"),esc_html__("Mexico","wpresidence-core"),esc_html__("Micronesia, Federated States of","wpresidence-core"),esc_html__("Moldova, Republic of","wpresidence-core"),esc_html__("Monaco","wpresidence-core"),esc_html__("Mongolia","wpresidence-core"),esc_html__("Montserrat","wpresidence-core"),esc_html__("Morocco","wpresidence-core"),esc_html__("Mozambique","wpresidence-core"),esc_html__("Montenegro","wpresidence-core"),esc_html__("Myanmar","wpresidence-core"),esc_html__("Namibia","wpresidence-core"),esc_html__("Nauru","wpresidence-core"),esc_html__("Nepal","wpresidence-core"),esc_html__("Netherlands","wpresidence-core"),esc_html__("Netherlands Antilles","wpresidence-core"),esc_html__("New Caledonia","wpresidence-core"),esc_html__("New Zealand","wpresidence-core"),esc_html__("Nicaragua","wpresidence-core"),esc_html__("Niger","wpresidence-core"),esc_html__("Nigeria","wpresidence-core"),esc_html__("Niue","wpresidence-core"),esc_html__("Norfolk Island","wpresidence-core"),esc_html__("Northern Mariana Islands","wpresidence-core"),esc_html__("Norway","wpresidence-core"),esc_html__("Oman","wpresidence-core"),esc_html__("Pakistan","wpresidence-core"),esc_html__("Palau","wpresidence-core"),esc_html__("Panama","wpresidence-core"),esc_html__("Papua New Guinea","wpresidence-core"),esc_html__("Paraguay","wpresidence-core"),esc_html__("Peru","wpresidence-core"),esc_html__("Philippines","wpresidence-core"),esc_html__("Pitcairn","wpresidence-core"),esc_html__("Poland","wpresidence-core"),esc_html__("Portugal","wpresidence-core"),esc_html__("Puerto Rico","wpresidence-core"),esc_html__("Qatar","wpresidence-core"),esc_html__("Reunion","wpresidence-core"),esc_html__("Romania","wpresidence-core"),esc_html__("Russian Federation","wpresidence-core"),esc_html__("Rwanda","wpresidence-core"),esc_html__("Saint Kitts and Nevis","wpresidence-core"),esc_html__("Saint Martin","wpresidence-core"),esc_html__("Saint Lucia","wpresidence-core"),esc_html__("Saint Vincent and the Grenadines","wpresidence-core"),esc_html__("Samoa","wpresidence-core"),esc_html__("San Marino","wpresidence-core"),esc_html__("Sao Tome and Principe","wpresidence-core"),esc_html__("Saudi Arabia","wpresidence-core"),esc_html__("Senegal","wpresidence-core"),esc_html__("Seychelles","wpresidence-core"),esc_html__("Serbia","wpresidence-core"),esc_html__("Sierra Leone","wpresidence-core"),esc_html__("Singapore","wpresidence-core"),esc_html__("Slovakia (Slovak Republic)","wpresidence-core"),esc_html__("Slovenia","wpresidence-core"),esc_html__("Solomon Islands","wpresidence-core"),esc_html__("Somalia","wpresidence-core"),esc_html__("South Africa","wpresidence-core"),esc_html__("South Georgia and the South Sandwich Islands","wpresidence-core"),esc_html__("Spain","wpresidence-core"),esc_html__("Sri Lanka","wpresidence-core"),esc_html__("St. Helena","wpresidence-core"),esc_html__("St. Pierre and Miquelon","wpresidence-core"),esc_html__("Sudan","wpresidence-core"),esc_html__("Suriname","wpresidence-core"),esc_html__("Svalbard and Jan Mayen Islands","wpresidence-core"),esc_html__("Swaziland","wpresidence-core"),esc_html__("Sweden","wpresidence-core"),esc_html__("Switzerland","wpresidence-core"),esc_html__("Syrian Arab Republic","wpresidence-core"),esc_html__("Taiwan, Province of China","wpresidence-core"),esc_html__("Tajikistan","wpresidence-core"),esc_html__("Tanzania, United Republic of","wpresidence-core"),esc_html__("Thailand","wpresidence-core"),esc_html__("Togo","wpresidence-core"),esc_html__("Tokelau","wpresidence-core"),esc_html__("Tonga","wpresidence-core"),esc_html__("Trinidad and Tobago","wpresidence-core"),esc_html__("Tunisia","wpresidence-core"),esc_html__("Turkey","wpresidence-core"),esc_html__("Turkmenistan","wpresidence-core"),esc_html__("Turks and Caicos Islands","wpresidence-core"),esc_html__("Tuvalu","wpresidence-core"),esc_html__("Uganda","wpresidence-core"),esc_html__("Ukraine","wpresidence-core"),esc_html__("United Arab Emirates","wpresidence-core"),esc_html__("United Kingdom","wpresidence-core"),esc_html__("United States","wpresidence-core"),esc_html__("United States Minor Outlying Islands","wpresidence-core"),esc_html__("Uruguay","wpresidence-core"),esc_html__("Uzbekistan","wpresidence-core"),esc_html__("Vanuatu","wpresidence-core"),esc_html__("Venezuela","wpresidence-core"),esc_html__("Vietnam","wpresidence-core"),esc_html__("Virgin Islands (British)","wpresidence-core"),esc_html__("Virgin Islands (U.S.)","wpresidence-core"),esc_html__("Wallis and Futuna Islands","wpresidence-core"),esc_html__("Western Sahara","wpresidence-core"),esc_html__("Yemen","wpresidence-core"),esc_html__("Zambia","wpresidence-core"),esc_html__("Zimbabwe","wpresidence-core"));
    $country_select_list='';
    foreach ($countries as $country) {
        $country_select_list.='<li role="presentation" data-value="'.$country.'">'.$country.'</li>';
    }
    


    return $country_select_list;
}
endif; // end   wpestate_country_list 


if( !function_exists('wpestate_agent_list') ):
function wpestate_agent_list($mypost) {
    return $agent_list;
}
endif; // end   wpestate_agent_list








///////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Manage property lists
///////////////////////////////////////////////////////////////////////////////////////////////////////////
add_filter( 'manage_edit-estate_property_columns', 'wpestate_my_columns' );

if( !function_exists('wpestate_my_columns') ):
function wpestate_my_columns( $columns ) {
    $slice=array_slice($columns,2,2);
    unset( $columns['comments'] );
    unset( $slice['comments'] );
    $splice=array_splice($columns, 2);   
    $columns['estate_ID']       = esc_html__('ID','wpresidence-core');
    $columns['estate_thumb']    = esc_html__('Image','wpresidence-core');
    $columns['estate_city']     = esc_html__('City','wpresidence-core');
    $columns['estate_action']   = esc_html__('Action','wpresidence-core');
    $columns['estate_category'] = esc_html__( 'Category','wpresidence-core');
    $columns['estate_autor']    = esc_html__('User','wpresidence-core');
    $columns['estate_status']   = esc_html__('Status','wpresidence-core');
    $columns['estate_price']    = esc_html__('Price','wpresidence-core');
    $columns['estate_featured'] = esc_html__('Featured','wpresidence-core');
    return  array_merge($columns,array_reverse($slice));
}
endif; // end   wpestate_my_columns  


add_action( 'manage_posts_custom_column', 'wpestate_populate_columns' );
if( !function_exists('wpestate_populate_columns') ):
function wpestate_populate_columns( $column ) {
    
    global $post;
    $the_id= $post->ID;

    if ( 'estate_ID' == $column ) {
        echo $the_id;
    }else if ( 'estate_agent_email' == $column ) {
        $agent_email = get_post_meta($the_id , 'agent_email', true);
        echo $agent_email;
    } else if ( 'estate_agency_email' == $column ) {
        $agent_email = get_post_meta($the_id , 'agency_email', true);
        echo $agent_email;
    }else if ( 'estate_agency_email' == $column ) {
        $agent_email = get_post_meta($the_id , 'agency_email', true);
        echo $agent_email;
    }else if ( 'estate_developer_email' == $column ) {
        $agent_email = get_post_meta($the_id , 'developer_email', true);
        echo $agent_email;
    }else if ( 'estate_agency_phone' == $column ) {
        $agent_phone = get_post_meta($the_id , 'agency_phone', true);
        $agent_mobile = get_post_meta($the_id , 'agency_mobile', true);
        echo $agent_phone.' / '.$agent_mobile;
    } else if ( 'estate_developer_phone' == $column ) {
        $agent_phone = get_post_meta($the_id , 'developer_phone', true);
        $agent_mobile = get_post_meta($the_id , 'developer_mobile', true);
        echo $agent_phone.' / '.$agent_mobile;
    } else if ( 'estate_agent_phone' == $column ) {
        $agent_phone = get_post_meta($the_id , 'agent_phone', true);
        $agent_mobile = get_post_meta($the_id , 'agent_mobile', true);
        echo $agent_phone.' / '.$agent_mobile;
    }else if ( 'estate_agent_city' == $column ) {
        $estate_action = get_the_term_list( $the_id, 'property_city_agent', '', ', ', '');
        echo ($estate_action);
    } else if ( 'estate_agent_action' == $column ) {
        $estate_action = get_the_term_list( $the_id, 'property_action_category_agent', '', ', ', '');
        echo ($estate_action);
    }else if ( 'estate_agent_category' == $column ) {
        $estate_category =  get_the_term_list( $the_id, 'property_category_agent', '', ', ', '');
        echo ($estate_category) ;
    } else if ( 'estate_agency_city' == $column ) {
        $estate_action = get_the_term_list( $the_id, 'city_agency', '', ', ', '');
        echo ($estate_action);
    } else if ( 'estate_agency_action' == $column ) {
        $estate_action = get_the_term_list( $the_id, 'action_category_agency', '', ', ', '');
        echo ($estate_action);
    }else if ( 'estate_agency_category' == $column ) {
        $estate_category =  get_the_term_list( $the_id, 'category_agency', '', ', ', '');
        echo ($estate_category) ;
    }else if ( 'estate_developer_city' == $column ) {
        $estate_action = get_the_term_list( $the_id, 'property_city_developer', '', ', ', '');
        echo ($estate_action);
    } else if ( 'estate_developer_action' == $column ) {
        $estate_action = get_the_term_list( $the_id, 'property_action_developer', '', ', ', '');
        echo ($estate_action);
    }else if ( 'estate_developer_category' == $column ) {
        $estate_category =  get_the_term_list( $the_id, 'property_category_developer', '', ', ', '');
        echo ($estate_category) ;
    }else if ( 'estate_status' == $column ) {
        $estate_status = get_post_status($the_id); 
        if($estate_status=='publish'){
            echo esc_html__('published','wpresidence-core');
        }else{
            echo esc_html($estate_status);
        }
        
        $pay_status    = get_post_meta($the_id, 'pay_status', true);
        if($pay_status!=''){
            echo " | ";
            if($pay_status=='paid'){
                esc_html_e('PAID','wpresidence-core');
            }else{
               esc_html_e('Not Paid','wpresidence-core');
            }
        }
        
    }else if ( 'estate_autor' == $column ) {
       $temp_id= $post->ID;
        $user_id=wpsestate_get_author($the_id);
        $estate_autor = get_the_author_meta('display_name',$user_id);
        echo '<a href="'.get_edit_user_link($user_id).'" >'.$estate_autor.'</a>';
      
        $post->ID=$temp_id=$the_id;
    }else if ( 'estate_thumb' == $column  || 'estate_agent_thumb' == $column || 'estate_agency_thumb' == $column || 'estate_developer_thumb' == $column) {
        $thumb_id           =   get_post_thumbnail_id( $the_id);
        $post_thumbnail_url =    wp_get_attachment_image_src($thumb_id, 'slider_thumb');
        echo '<img src="'.$post_thumbnail_url[0].'" style="width:100%;height:auto;">';
    }else if ( 'estate_city' == $column ) {
        $estate_city = get_the_term_list( $the_id, 'property_city', '', ', ', '');
        echo ($estate_city);
    }else if ( 'estate_action' == $column ) {
        $estate_action = get_the_term_list( $the_id, 'property_action_category', '', ', ', '');
        echo ($estate_action);
    }elseif ( 'estate_category' == $column ) {
        $estate_category =  get_the_term_list( $the_id, 'property_category', '', ', ', '');
        echo ($estate_category) ;
    }else if ( 'estate_price' == $column ) {
        $wpestate_currency                   =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
        $where_currency             =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
        
        $price = floatval( get_post_meta($the_id, 'property_price', true) );
        if ($price != 0) {
           $price = number_format($price);

           if ($where_currency == 'before') {
               $price = $wpestate_currency . ' ' . $price;
           } else {
               $price = $price . ' ' . $wpestate_currency;
           }
        }else{
            $price='';
        }
        
        echo get_post_meta($the_id, 'property_label_before', true).' '.$price.' '. get_post_meta($the_id, 'property_label', true);
    }else if ( 'estate_featured' == $column ) {
        $estate_featured = get_post_meta($the_id, 'prop_featured', true); 
        if($estate_featured==1){
            $estate_featured=esc_html__('Yes','wpresidence-core');
        }else{
            $estate_featured=esc_html__('No','wpresidence-core'); 
        }
        echo esc_html($estate_featured);
    }
}
endif; // end   wpestate_populate_columns 





//'manage_edit-estate_property_columns
add_filter( 'manage_edit-estate_property_sortable_columns', 'wpestate_sort_me' );
if( !function_exists('wpestate_sort_me') ):
function wpestate_sort_me( $columns ) {
    $columns['estate_autor']        = 'estate_autor';
    $columns['estate_featured']       = 'estate_featured';
    $columns['estate_price']       = 'estate_price';
    return $columns;
}
endif; // end   wpestate_sort_me 


add_filter( 'request', 'bs_event_date_column_orderby_core' );
function bs_event_date_column_orderby_core( $vars ) {
    if ( isset( $vars['orderby'] ) && 'estate_featured' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'prop_featured',
            'orderby' => 'meta_value_num'
        ) );
    }
    if ( isset( $vars['orderby'] ) && 'estate_price' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
            'meta_key' => 'property_price',
            'orderby' => 'meta_value_num'
        ) );
    }
    
    
      if ( isset( $vars['orderby'] ) && 'estate_autor' == $vars['orderby'] ) {
        $vars = array_merge( $vars, array(
           
            'orderby' => 'author'
        ) );
    }
    
   

    return $vars;
}




///////////////////////////////////////////////////////////////////////////////////////////////////////////
// Tie area with city
///////////////////////////////////////////////////////////////////////////////////////////////////////////
add_action( 'property_area_edit_form_fields',   'wpestate_property_area_callback_function', 10, 2);
add_action( 'property_area_add_form_fields',    'wpestate_property_area_callback_add_function', 10, 2 );  
add_action( 'created_property_area',            'wpestate_property_area_save_extra_fields_callback', 10, 2);
add_action( 'edited_property_area',             'wpestate_property_area_save_extra_fields_callback', 10, 2);
add_filter('manage_edit-property_area_columns', 'ST4_columns_head');  
add_filter('manage_property_area_custom_column','ST4_columns_content_taxonomy', 10, 3); 


if( !function_exists('ST4_columns_head') ):
function ST4_columns_head($new_columns) {   
 
    $new_columns = array(
        'cb'            => '<input type="checkbox" />',
        'name'          => esc_html__('Name','wpresidence-core'),
        'city'          => esc_html__('City','wpresidence-core'),
        'id'          => esc_html__('ID','wpresidence-core'),
        'header_icon'   => '',
        'slug'          => esc_html__('Slug','wpresidence-core'),
        'posts'         => esc_html__('Posts','wpresidence-core')
        );
    
    
    return $new_columns;
} 
endif; // end   ST4_columns_head  


if( !function_exists('ST4_columns_content_taxonomy') ):
function ST4_columns_content_taxonomy($out, $column_name, $term_id) {  
    if ($column_name == 'city') {    
        $term_meta= get_option( "taxonomy_$term_id");
        print stripslashes( $term_meta['cityparent'] );
    }  
    if ($column_name == 'id') {    
        echo $term_id;
    } 
}  
endif; // end   ST4_columns_content_taxonomy  




add_filter('manage_edit-property_city_columns', 'ST4_city_columns_head');  
add_filter('manage_property_city_custom_column','ST4_city_columns_content_taxonomy', 10, 3); 


if( !function_exists('ST4_city_columns_head') ):
function ST4_city_columns_head($new_columns) {   
 
    $new_columns = array(
        'cb'            => '<input type="checkbox" />',
        'name'          => esc_html__('Name','wpresidence-core'),
        'county'          => esc_html__('County / State','wpresidence-core'),
        'id'          => esc_html__('ID','wpresidence-core'),
        'header_icon'   => '',
        'slug'          => esc_html__('Slug','wpresidence-core'),
        'posts'         => esc_html__('Posts','wpresidence-core')
        );
    
    
    return $new_columns;
} 
endif; // end   ST4_city_columns_head  


if( !function_exists('ST4_city_columns_content_taxonomy') ):
function ST4_city_columns_content_taxonomy($out, $column_name, $term_id) {  
    if ($column_name == 'county') {    
        $term_meta= get_option( "taxonomy_$term_id");
        if( isset($term_meta['stateparent'] ) ){
            print stripslashes( $term_meta['stateparent'] );
        }
        
    }  
    if ($column_name == 'id') {    
        echo $term_id;
    } 
}  
endif; // end   ST4_city_columns_content_taxonomy  




if( !function_exists('wpestate_property_area_callback_add_function') ):
    function wpestate_property_area_callback_add_function($tag){
        if(is_object ($tag)){
            $t_id                       =   $tag->term_id;
            $term_meta                  =   get_option( "taxonomy_$t_id");
            $cityparent                 =   $term_meta['cityparent'] ? $term_meta['cityparent'] : ''; 
            $pagetax                    =   $term_meta['pagetax'] ? $term_meta['pagetax'] : '';
            $category_featured_image    =   $term_meta['category_featured_image'] ? $term_meta['category_featured_image'] : '';
            $category_tagline           =   $term_meta['category_tagline'] ? $term_meta['category_tagline'] : '';
            
            $category_attach_id         =   $term_meta['category_attach_id'] ? $term_meta['category_attach_id'] : '';
        }else{
            $cityparent                 =   wpestate_get_all_cities();
            $pagetax                    =   '';
            $category_featured_image    =   '';
            $category_tagline           =   '';
            $category_attach_id         =   '';
        }

        print'
            <div class="form-field">
            <label for="term_meta[cityparent]">'. esc_html__( 'Which city has this area','wpresidence-core').'</label>
                <select name="term_meta[cityparent]" class="postform">  
                    '.$cityparent.'
                </select>
            </div>
            ';

         print'
            <div class="form-field">
            <label for="term_meta[pagetax]">'. esc_html__( 'Page id for this term','wpresidence-core').'</label>
                <input type="text" name="term_meta[pagetax]" class="postform" value="'.$pagetax.'">  
            </div>

            <div class="form-field">
            <label for="term_meta[pagetax]">'. esc_html__( 'Featured Image','wpresidence-core').'</label>
                <input id="category_featured_image" type="text" size="36" name="term_meta[category_featured_image]" value="'.$category_featured_image.'" />
                <input id="category_featured_image_button" type="button"  class="upload_button button category_featured_image_button" value="'.esc_html__( 'Upload Image','wpresidence-core').'" />
                <input id="category_attach_id" type="hidden" size="36" name="term_meta[category_attach_id]" value="'.$category_attach_id.'" />

            </div> 


            <div class="form-field">
            <label for="term_meta[category_tagline]">'. esc_html__( 'Category Tagline','wpresidence-core').'</label>
                <input id="category_featured_image" type="text" size="36" name="term_meta[category_tagline]" value="'.$category_tagline.'" />
            </div>  
            <input id="category_tax" type="hidden" size="36" name="term_meta[category_tax]" value="property_area" />
            ';
    }
endif; // end     




if( !function_exists('wpestate_property_area_callback_function') ):
    function wpestate_property_area_callback_function($tag){
        if(is_object ($tag)){
            $t_id                       =   $tag->term_id;
            $term_meta                  =   get_option( "taxonomy_$t_id");
            $cityparent                 =   $term_meta['cityparent'] ? $term_meta['cityparent'] : ''; 
            $pagetax                    =   '';
            $category_featured_image    =   '';
            $category_tagline           =   '';
            $category_attach_id         =   '';
            if(isset($term_meta['pagetax'] )){
                $pagetax                    =   $term_meta['pagetax'] ? $term_meta['pagetax'] : '';
            }
            
            if(isset($term_meta['category_featured_image'] )){
                $category_featured_image    =   $term_meta['category_featured_image'] ? $term_meta['category_featured_image'] : '';
            }
            
            if(isset($term_meta['category_tagline'] )){
                $category_tagline           =   $term_meta['category_tagline'] ? $term_meta['category_tagline'] : '';
            }
            
            $category_tagline           =   stripslashes($category_tagline);
            if(isset($term_meta['category_attach_id'] )){
                $category_attach_id         =   $term_meta['category_attach_id'] ? $term_meta['category_attach_id'] : '';
            }
            
            $cityparent =   wpestate_get_all_cities($cityparent);
        }else{
            $cityparent                 =   wpestate_get_all_cities();
            $pagetax                    =   '';
            $category_featured_image    =   '';
            $category_tagline           =   '';
            $category_attach_id         =   '';

        }

        print'
            <table class="form-table">
            <tbody>
                    <tr class="form-field">
                            <th scope="row" valign="top"><label for="term_meta[cityparent]">'. esc_html__( 'Which city has this area','wpresidence-core').'</label></th>
                            <td> 
                                <select name="term_meta[cityparent]" class="postform">  
                                 '.$cityparent.'
                                    </select>
                                <p class="description">'.esc_html__( 'City that has this area','wpresidence-core').'</p>
                            </td>
                    </tr>

                   <tr class="form-field">
                            <th scope="row" valign="top"><label for="term_meta[pagetax]">'.esc_html__( 'Page id for this term','wpresidence-core').'</label></th>
                            <td> 
                                <input type="text" name="term_meta[pagetax]" class="postform" value="'.$pagetax.'">  
                                <p class="description">'.esc_html__( 'Page id for this term','wpresidence-core').'</p>
                            </td>
                    </tr>

                    <tr valign="top">
                        <th scope="row"><label for="logo_image">'.esc_html__( 'Featured Image','wpresidence-core').'</label></th>
                        <td>
                            <input id="category_featured_image" type="text" size="36" name="term_meta[category_featured_image]" value="'.$category_featured_image.'" />
                            <input id="category_featured_image_button" type="button"  class="upload_button button category_featured_image_button" value="'.esc_html__( 'Upload Image','wpresidence-core').'" />
                            <input id="category_attach_id" type="hidden" size="36" name="term_meta[category_attach_id]" value="'.$category_attach_id.'" />
                        </td>
                    </tr> 

                    <tr valign="top">
                        <th scope="row"><label for="term_meta[category_tagline]">'. esc_html__( 'Category Tagline','wpresidence-core').'</label></th>
                        <td>
                          <input id="category_featured_image" type="text" size="36" name="term_meta[category_tagline]" value="'.$category_tagline.'" />
                        </td>
                    </tr> 


                    <input id="category_tax" type="hidden" size="36" name="term_meta[category_tax]" value="property_area" />




              </tbody>
             </table>';
    }
endif; // end     




if( !function_exists('wpestate_get_all_cities') ): 
function wpestate_get_all_cities($selected=''){
    $taxonomy       =   'property_city';
    $args = array(
        'hide_empty'    => false
    );
    $tax_terms      =   get_terms($taxonomy,$args);
    $select_city    =   '';
    
    foreach ($tax_terms as $tax_term) {             
        $select_city.= '<option value="' . $tax_term->name.'" ';
        if($tax_term->name == $selected){
            $select_city.= ' selected="selected" ';
        }
        $select_city.= ' >' . $tax_term->name . '</option>'; 
    }
    return $select_city;
}
endif; // end   wpestate_get_all_cities 


if( !function_exists('wpestate_get_all_states') ): 
function wpestate_get_all_states($selected=''){
    $taxonomy       =   'property_county_state';
    $args = array(
        'hide_empty'    => false
    );
    $tax_terms      =   get_terms($taxonomy,$args);
 
    $select_city    =   '';
    
    foreach ($tax_terms as $tax_term) {             
        $select_city.= '<option value="' . $tax_term->name.'" ';
        if($tax_term->name == $selected){
            $select_city.= ' selected="selected" ';
        }
        $select_city.= ' >' . $tax_term->name . '</option>'; 
    }
    return $select_city;
}
endif; // end   wpestate_get_all_cities 





if( !function_exists('wpestate_property_area_save_extra_fields_callback') ):
    function wpestate_property_area_save_extra_fields_callback($term_id ){
          if ( isset( $_POST['term_meta'] ) ) {
            $t_id = $term_id;
            $term_meta = get_option( "taxonomy_$t_id");
            $cat_keys = array_keys($_POST['term_meta']);
            $allowed_html   =   array();
                foreach ($cat_keys as $key){
                    $key=sanitize_key($key);
                    if (isset($_POST['term_meta'][$key])){
                        $term_meta[$key] =  wp_kses( $_POST['term_meta'][$key],$allowed_html);
                    }
                }
            //save the option array
            update_option( "taxonomy_$t_id", $term_meta );
        }
    }
endif; // end     


add_action( 'init', 'wpestate_my_custom_post_status' );
if( !function_exists('wpestate_my_custom_post_status') ):
function wpestate_my_custom_post_status(){
    register_post_status( 'expired', array(
            'label'                     => esc_html__( 'expired', 'wpresidence-core' ),
            'public'                    => true,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop( 'Membership Expired <span class="count">(%s)</span>', 'Membership Expired <span class="count">(%s)</span>' ),
    ) ,
    register_post_status( 'disabled', array(
            'label'                     => esc_html__(  'disabled', 'wpresidence-core' ),
            'public'                    => false,
            'exclude_from_search'       => false,
            'show_in_admin_all_list'    => true,
            'show_in_admin_status_list' => true,
            'label_count'               => _n_noop( 'Disabled by user <span class="count">(%s)</span>', 'Disabled by user <span class="count">(%s)</span>','wpresidence-core' ),
    )
    
    ) 

                
    );
}
endif; // end   wpestate_my_custom_post_status  


/////////////////////////////////////////////////////////
// customizable taxonomy header
/////////////////////////////////////////////////////////

add_action( 'property_city_edit_form_fields',   'wpestate_property_city_callback_function', 10, 2);
add_action( 'property_city_add_form_fields',    'wpestate_property_city_callback_add_function', 10, 2 );  
add_action( 'created_property_city',            'wpestate_property_city_save_extra_fields_callback', 10, 2);
add_action( 'edited_property_city',             'wpestate_property_city_save_extra_fields_callback', 10, 2);


add_action( 'property_category_edit_form_fields',   'wpestate_property_category_callback_function', 10, 2);
add_action( 'property_category_add_form_fields',    'wpestate_property_category_callback_add_function', 10, 2 );  
add_action( 'created_property_category',            'wpestate_property_city_save_extra_fields_callback', 10, 2);
add_action( 'edited_property_category',             'wpestate_property_city_save_extra_fields_callback', 10, 2);


add_action( 'property_action_category_edit_form_fields',   'wpestate_property_action_category_callback_function', 10, 2);
add_action( 'property_action_category_add_form_fields',    'wpestate_property_action_category_callback_add_function', 10, 2 );  
add_action( 'created_property_action_category',            'wpestate_property_city_save_extra_fields_callback', 10, 2);
add_action( 'edited_property_action_category',             'wpestate_property_city_save_extra_fields_callback', 10, 2);

add_action( 'property_county_state_edit_form_fields',   'wpestate_property_county_state_callback_function', 10, 2);
add_action( 'property_county_state_add_form_fields',    'wpestate_property_county_state_callback_add_function', 10, 2 );  
add_action( 'created_property_county_state',            'wpestate_property_city_save_extra_fields_callback', 10, 2);
add_action( 'edited_property_county_state',             'wpestate_property_city_save_extra_fields_callback', 10, 2);

if( !function_exists('wpestate_property_category_callback_function') ):
    function wpestate_property_category_callback_function($tag){
        if(is_object ($tag)){
            $t_id                       =   $tag->term_id;
            $term_meta                  =   get_option( "taxonomy_$t_id");
            $pagetax                    =   $term_meta['pagetax'] ? $term_meta['pagetax'] : '';
            $category_featured_image    =   $term_meta['category_featured_image'] ? $term_meta['category_featured_image'] : '';
            $category_tagline           =   $term_meta['category_tagline'] ? $term_meta['category_tagline'] : '';
            $category_tagline           =   stripslashes($category_tagline);
            $category_attach_id         =   $term_meta['category_attach_id'] ? $term_meta['category_attach_id'] : '';
        }else{
            $pagetax                    =   '';
            $category_featured_image    =   '';
            $category_tagline           =   '';
            $category_attach_id         =   '';
        }

        print'
        <table class="form-table">
        <tbody>    
            <tr class="form-field">
                <th scope="row" valign="top"><label for="term_meta[pagetax]">'.esc_html__( 'Page id for this term','wpresidence-core').'</label></th>
                <td> 
                    <input type="text" name="term_meta[pagetax]" class="postform" value="'.$pagetax.'">  
                    <p class="description">'.esc_html__( 'Page id for this term','wpresidence-core').'</p>
                </td>

                <tr valign="top">
                    <th scope="row"><label for="category_featured_image">'.esc_html__( 'Featured Image','wpresidence-core').'</label></th>
                    <td>
                        <input id="category_featured_image" type="text" class="postform" size="36" name="term_meta[category_featured_image]" value="'.$category_featured_image.'" />
                        <input id="category_featured_image_button" type="button"  class="upload_button button category_featured_image_button" value="'.esc_html__( 'Upload Image','wpresidence-core').'" />
                        <input id="category_attach_id" type="hidden" size="36" name="term_meta[category_attach_id]" value="'.$category_attach_id.'" />
                    </td>
                </tr> 

                <tr valign="top">
                    <th scope="row"><label for="term_meta[category_tagline]">'. esc_html__( 'Category Tagline','wpresidence-core').'</label></th>
                    <td>
                        <input id="category_tagline" type="text" size="36" name="term_meta[category_tagline]" value="'.$category_tagline.'" />
                    </td>
                </tr> 



                <input id="category_tax" type="hidden" size="36" name="term_meta[category_tax]" value="property_category" />


            </tr>
        </tbody>
        </table>';
    }
endif;

if( !function_exists('wpestate_property_category_callback_add_function') ):
    function wpestate_property_category_callback_add_function($tag){
        if(is_object ($tag)){
            $t_id                       =   $tag->term_id;
            $term_meta                  =   get_option( "taxonomy_$t_id");
            $pagetax                    =   $term_meta['pagetax'] ? $term_meta['pagetax'] : '';
            $category_featured_image    =   $term_meta['category_featured_image'] ? $term_meta['category_featured_image'] : '';
            $category_tagline           =   $term_meta['category_tagline'] ? $term_meta['category_tagline'] : '';
            $category_attach_id         =   $term_meta['category_attach_id'] ? $term_meta['category_attach_id'] : '';
        }else{
            $pagetax                    =   '';
            $category_featured_image    =   '';
            $category_tagline           =   '';
            $category_attach_id         =   '';

        }

        print'
        <div class="form-field">
        <label for="term_meta[pagetax]">'. esc_html__( 'Page id for this term','wpresidence-core').'</label>
            <input type="text" name="term_meta[pagetax]" class="postform" value="'.$pagetax.'">  
        </div>

        <div class="form-field">
            <label for="term_meta[pagetax]">'. esc_html__( 'Featured Image','wpresidence-core').'</label>
            <input id="category_featured_image" type="text" size="36" name="term_meta[category_featured_image]" value="'.$category_featured_image.'" />
            <input id="category_featured_image_button" type="button"  class="upload_button button category_featured_image_button" value="'.esc_html__( 'Upload Image','wpresidence-core').'" />
           <input id="category_attach_id" type="hidden" size="36" name="term_meta[category_attach_id]" value="'.$category_attach_id.'" />

        </div>     

        <div class="form-field">
        <label for="term_meta[category_tagline]">'. esc_html__( 'Category Tagline','wpresidence-core').'</label>
            <input id="category_tagline" type="text" size="36" name="term_meta[category_tagline]" value="'.$category_tagline.'" />
        </div> 
        <input id="category_tax" type="hidden" size="36" name="term_meta[category_tax]" value="property_category" />
        ';
    }
endif;


if( !function_exists('wpestate_property_action_category_callback_function') ):
    function wpestate_property_action_category_callback_function($tag){
        if(is_object ($tag)){
            $t_id                       =   $tag->term_id;
            $term_meta                  =   get_option( "taxonomy_$t_id");
            $pagetax                    =   $term_meta['pagetax'] ? $term_meta['pagetax'] : '';
            $category_featured_image    =   $term_meta['category_featured_image'] ? $term_meta['category_featured_image'] : '';
            $category_tagline           =   $term_meta['category_tagline'] ? $term_meta['category_tagline'] : '';
            $category_tagline           =   stripslashes($category_tagline);
            $category_attach_id         =   $term_meta['category_attach_id'] ? $term_meta['category_attach_id'] : '';
        }else{
            $pagetax                    =   '';
            $category_featured_image    =   '';
            $category_tagline           =   '';
            $category_attach_id         =   '';
        }

        print'
        <table class="form-table">
        <tbody>    
            <tr class="form-field">
                <th scope="row" valign="top"><label for="term_meta[pagetax]">'.esc_html__( 'Page id for this term','wpresidence-core').'</label></th>
                <td> 
                    <input type="text" name="term_meta[pagetax]" class="postform" value="'.$pagetax.'">  
                    <p class="description">'.esc_html__( 'Page id for this term','wpresidence-core').'</p>
                </td>

                <tr valign="top">
                    <th scope="row"><label for="category_featured_image">'.esc_html__( 'Featured Image','wpresidence-core').'</label></th>
                    <td>
                        <input id="category_featured_image" type="text" class="postform" size="36" name="term_meta[category_featured_image]" value="'.$category_featured_image.'" />
                        <input id="category_featured_image_button" type="button"  class="upload_button button category_featured_image_button" value="'.esc_html__( 'Upload Image','wpresidence-core').'" />
                        <input id="category_attach_id" type="hidden" size="36" name="term_meta[category_attach_id]" value="'.$category_attach_id.'" />
                    </td>
                </tr> 

                <tr valign="top">
                    <th scope="row"><label for="term_meta[category_tagline]">'. esc_html__( 'Category Tagline','wpresidence-core').'</label></th>
                    <td>
                        <input id="category_tagline" type="text" size="36" name="term_meta[category_tagline]" value="'.$category_tagline.'" />
                    </td>
                </tr> 



                <input id="category_tax" type="hidden" size="36" name="term_meta[category_tax]" value="property_action_category" />


            </tr>
        </tbody>
        </table>';
    }
endif;

if( !function_exists('wpestate_property_action_category_callback_add_function') ):
    function wpestate_property_action_category_callback_add_function($tag){
        if(is_object ($tag)){
            $t_id                       =   $tag->term_id;
            $term_meta                  =   get_option( "taxonomy_$t_id");
            $pagetax                    =   $term_meta['pagetax'] ? $term_meta['pagetax'] : '';
            $category_featured_image    =   $term_meta['category_featured_image'] ? $term_meta['category_featured_image'] : '';
            $category_tagline           =   $term_meta['category_tagline'] ? $term_meta['category_tagline'] : '';
            $category_attach_id         =   $term_meta['category_attach_id'] ? $term_meta['category_attach_id'] : '';
        }else{
            $pagetax                    =   '';
            $category_featured_image    =   '';
            $category_tagline           =   '';
            $category_attach_id         =   '';

        }

        print'
        <div class="form-field">
        <label for="term_meta[pagetax]">'. esc_html__( 'Page id for this term','wpresidence-core').'</label>
            <input type="text" name="term_meta[pagetax]" class="postform" value="'.$pagetax.'">  
        </div>

        <div class="form-field">
            <label for="term_meta[pagetax]">'. esc_html__( 'Featured Image','wpresidence-core').'</label>
            <input id="category_featured_image" type="text" size="36" name="term_meta[category_featured_image]" value="'.$category_featured_image.'" />
            <input id="category_featured_image_button" type="button"  class="upload_button button category_featured_image_button" value="'.esc_html__( 'Upload Image','wpresidence-core').'" />
           <input id="category_attach_id" type="hidden" size="36" name="term_meta[category_attach_id]" value="'.$category_attach_id.'" />

        </div>     

        <div class="form-field">
        <label for="term_meta[category_tagline]">'. esc_html__( 'Category Tagline','wpresidence-core').'</label>
            <input id="category_tagline" type="text" size="36" name="term_meta[category_tagline]" value="'.$category_tagline.'" />
        </div> 
        <input id="category_tax" type="hidden" size="36" name="term_meta[category_tax]" value="property_action_category" />
        ';
    }
endif;



if( !function_exists('wpestate_property_city_callback_function') ):
    function wpestate_property_city_callback_function($tag){
            $pagetax                    =   '';	
            $category_featured_image    =   '';
            $category_tagline           =   '';
            $category_attach_id         =   '';
        if(is_object ($tag)){
            $t_id                       =   $tag->term_id;
            $term_meta                  =   get_option( "taxonomy_$t_id");
            if( isset($term_meta['pagetax']) )   {
                $pagetax                    =   $term_meta['pagetax'] ? $term_meta['pagetax'] : '';
            }
            
            $stateparent                 =   isset( $term_meta['stateparent'] ) ? $term_meta['stateparent'] : ''; 
			
            if(isset( $term_meta['category_featured_image'] )){
                $category_featured_image    =   $term_meta['category_featured_image'] ? $term_meta['category_featured_image'] : '';
            }
            
            if(isset($term_meta['category_tagline'])){
                $category_tagline           =   $term_meta['category_tagline'] ? $term_meta['category_tagline'] : '';
            }
            $category_tagline           =   stripslashes($category_tagline);
            
            if( isset($term_meta['category_attach_id']) ){
                $category_attach_id         =   $term_meta['category_attach_id'] ? $term_meta['category_attach_id'] : '';
            }	
            $stateparent =   wpestate_get_all_states($stateparent);
			
        }else{
            $pagetax                    =   '';
			
            $stateparent                 =   wpestate_get_all_states();
			
            $category_featured_image    =   '';
            $category_tagline           =   '';
            $category_attach_id         =   '';
        }
	
        print'
        <table class="form-table">
        <tbody>    
			<tr class="form-field">
                            <th scope="row" valign="top"><label for="term_meta[stateparent]">'. esc_html__( 'Which county / state has this city','wpresidence-core').'</label></th>
                            <td> 
                                <select name="term_meta[stateparent]" class="postform">  
                                 '.$stateparent.'
                                    </select>
                                <p class="description">'.esc_html__( 'County / State that has this city','wpresidence-core').'</p>
                            </td>
                    </tr>
		
		
            <tr class="form-field">
                <th scope="row" valign="top"><label for="term_meta[pagetax]">'.esc_html__( 'Page id for this term','wpresidence-core').'</label></th>
                <td> 
                    <input type="text" name="term_meta[pagetax]" class="postform" value="'.$pagetax.'">  
                    <p class="description">'.esc_html__( 'Page id for this term','wpresidence-core').'</p>
                </td>

                <tr valign="top">
                    <th scope="row"><label for="category_featured_image">'.esc_html__( 'Featured Image','wpresidence-core').'</label></th>
                    <td>
                        <input id="category_featured_image" type="text" class="postform" size="36" name="term_meta[category_featured_image]" value="'.$category_featured_image.'" />
                        <input id="category_featured_image_button" type="button"  class="upload_button button category_featured_image_button" value="'.esc_html__( 'Upload Image','wpresidence-core').'" />
                        <input id="category_attach_id" type="hidden" size="36" name="term_meta[category_attach_id]" value="'.$category_attach_id.'" />
                    </td>
                </tr> 

                <tr valign="top">
                    <th scope="row"><label for="term_meta[category_tagline]">'. esc_html__( 'Category Tagline','wpresidence-core').'</label></th>
                    <td>
                        <input id="category_tagline" type="text" size="36" name="term_meta[category_tagline]" value="'.$category_tagline.'" />
                    </td>
                </tr> 



                <input id="category_tax" type="hidden" size="36" name="term_meta[category_tax]" value="property_city" />


            </tr>
        </tbody>
        </table>';
    }
endif;


if( !function_exists('wpestate_property_county_state_callback_function') ):
    function wpestate_property_county_state_callback_function($tag){
        if(is_object ($tag)){
            $t_id                       =   $tag->term_id;
            $term_meta                  =   get_option( "taxonomy_$t_id");
            $pagetax                    =   $term_meta['pagetax'] ? $term_meta['pagetax'] : '';
            $category_featured_image    =   $term_meta['category_featured_image'] ? $term_meta['category_featured_image'] : '';
            $category_tagline           =   $term_meta['category_tagline'] ? $term_meta['category_tagline'] : '';
            $category_tagline           =   stripslashes($category_tagline);
            $category_attach_id         =   $term_meta['category_attach_id'] ? $term_meta['category_attach_id'] : '';
        }else{
            $pagetax                    =   '';
            $category_featured_image    =   '';
            $category_tagline           =   '';
            $category_attach_id         =   '';
        }

        print'
        <table class="form-table">
        <tbody>    
            <tr class="form-field">
                <th scope="row" valign="top"><label for="term_meta[pagetax]">'.esc_html__( 'Page id for this term','wpresidence-core').'</label></th>
                <td> 
                    <input type="text" name="term_meta[pagetax]" class="postform" value="'.$pagetax.'">  
                    <p class="description">'.esc_html__( 'Page id for this term','wpresidence-core').'</p>
                </td>

                <tr valign="top">
                    <th scope="row"><label for="category_featured_image">'.esc_html__( 'Featured Image','wpresidence-core').'</label></th>
                    <td>
                        <input id="category_featured_image" type="text" class="postform" size="36" name="term_meta[category_featured_image]" value="'.$category_featured_image.'" />
                        <input id="category_featured_image_button" type="button"  class="upload_button button category_featured_image_button" value="'.esc_html__( 'Upload Image','wpresidence-core').'" />
                        <input id="category_attach_id" type="hidden" size="36" name="term_meta[category_attach_id]" value="'.$category_attach_id.'" />
                    </td>
                </tr> 

                <tr valign="top">
                    <th scope="row"><label for="term_meta[category_tagline]">'. esc_html__( 'Category Tagline','wpresidence-core').'</label></th>
                    <td>
                        <input id="category_tagline" type="text" size="36" name="term_meta[category_tagline]" value="'.$category_tagline.'" />
                    </td>
                </tr> 



                <input id="category_tax" type="hidden" size="36" name="term_meta[category_tax]" value="property_county_state" />


            </tr>
        </tbody>
        </table>';
    }
endif;



if( !function_exists('wpestate_property_city_callback_add_function') ):
    function wpestate_property_city_callback_add_function($tag){
        if(is_object ($tag)){
            $t_id                       =   $tag->term_id;
            $term_meta                  =   get_option( "taxonomy_$t_id");
            $pagetax                    =   $term_meta['pagetax'] ? $term_meta['pagetax'] : '';
			
			$stateparent                 =   $term_meta['stateparent'] ? $term_meta['stateparent'] : ''; 
			
            $category_featured_image    =   $term_meta['category_featured_image'] ? $term_meta['category_featured_image'] : '';
            $category_tagline           =   $term_meta['category_tagline'] ? $term_meta['category_tagline'] : '';
            $category_attach_id         =   $term_meta['category_attach_id'] ? $term_meta['category_attach_id'] : '';
        }else{
            $pagetax                    =   '';
			
			$stateparent                 =   wpestate_get_all_states();
			
            $category_featured_image    =   '';
            $category_tagline           =   '';
            $category_attach_id         =   '';

        }

		print'
            <div class="form-field">
            <label for="term_meta[stateparent]">'. esc_html__( 'Which county / state has this city','wpresidence-core').'</label>
                <select name="term_meta[stateparent]" class="postform">  
                    '.$stateparent.'
                </select>
            </div>
            ';
		
		
        print'
		
		
		
		
        <div class="form-field">
        <label for="term_meta[pagetax]">'. esc_html__( 'Page id for this term','wpresidence-core').'</label>
            <input type="text" name="term_meta[pagetax]" class="postform" value="'.$pagetax.'">  
        </div>

        <div class="form-field">
            <label for="term_meta[pagetax]">'. esc_html__( 'Featured Image','wpresidence-core').'</label>
            <input id="category_featured_image" type="text" size="36" name="term_meta[category_featured_image]" value="'.$category_featured_image.'" />
            <input id="category_featured_image_button" type="button"  class="upload_button button category_featured_image_button" value="'.esc_html__( 'Upload Image','wpresidence-core').'" />
           <input id="category_attach_id" type="hidden" size="36" name="term_meta[category_attach_id]" value="'.$category_attach_id.'" />

        </div>     

        <div class="form-field">
        <label for="term_meta[category_tagline]">'. esc_html__( 'Category Tagline','wpresidence-core').'</label>
            <input id="category_tagline" type="text" size="36" name="term_meta[category_tagline]" value="'.$category_tagline.'" />
        </div> 
        <input id="category_tax" type="hidden" size="36" name="term_meta[category_tax]" value="property_city" />
        ';
    }
endif;



if( !function_exists('wpestate_property_county_state_callback_add_function') ):
    function wpestate_property_county_state_callback_add_function($tag){
        if(is_object ($tag)){
            $t_id                       =   $tag->term_id;
            $term_meta                  =   get_option( "taxonomy_$t_id");
            $pagetax                    =   $term_meta['pagetax'] ? $term_meta['pagetax'] : '';
            $category_featured_image    =   $term_meta['category_featured_image'] ? $term_meta['category_featured_image'] : '';
            $category_tagline           =   $term_meta['category_tagline'] ? $term_meta['category_tagline'] : '';
            $category_attach_id         =   $term_meta['category_attach_id'] ? $term_meta['category_attach_id'] : '';
        }else{
            $pagetax                    =   '';
            $category_featured_image    =   '';
            $category_tagline           =   '';
            $category_attach_id         =   '';

        }

        print'
        <div class="form-field">
        <label for="term_meta[pagetax]">'. esc_html__( 'Page id for this term','wpresidence-core').'</label>
            <input type="text" name="term_meta[pagetax]" class="postform" value="'.$pagetax.'">  
        </div>

        <div class="form-field">
            <label for="term_meta[pagetax]">'. esc_html__( 'Featured Image','wpresidence-core').'</label>
            <input id="category_featured_image" type="text" size="36" name="term_meta[category_featured_image]" value="'.$category_featured_image.'" />
            <input id="category_featured_image_button" type="button"  class="upload_button button category_featured_image_button" value="'.esc_html__( 'Upload Image','wpresidence-core').'" />
           <input id="category_attach_id" type="hidden" size="36" name="term_meta[category_attach_id]" value="'.$category_attach_id.'" />

        </div>     

        <div class="form-field">
        <label for="term_meta[category_tagline]">'. esc_html__( 'Category Tagline','wpresidence-core').'</label>
            <input id="category_tagline" type="text" size="36" name="term_meta[category_tagline]" value="'.$category_tagline.'" />
        </div> 
        <input id="category_tax" type="hidden" size="36" name="term_meta[category_tax]" value="property_city" />
        ';
    }
endif;




if( !function_exists('wpestate_property_city_save_extra_fields_callback') ):
    function wpestate_property_city_save_extra_fields_callback($term_id ){
        if ( isset( $_POST['term_meta'] ) ) {
            $t_id = $term_id;
            $term_meta = get_option( "taxonomy_$t_id");
            $cat_keys = array_keys($_POST['term_meta']);
            $allowed_html   =   array();
                foreach ($cat_keys as $key){
                    $key=sanitize_key($key);
                    if (isset($_POST['term_meta'][$key])){
                        $term_meta[$key] =  wp_kses( $_POST['term_meta'][$key],$allowed_html);
                    }
                }
            //save the option array
             update_option( "taxonomy_$t_id", $term_meta );
        }
    }
endif;


if( !function_exists('wpestate_listing_full_width_slider') ):
function wpestate_multi_image_slider($prop_id){
    
   
    $arguments      = array(
        'numberposts'       =>  -1,
        'post_type'         =>  'attachment',
        'post_mime_type'    =>  'image',
        'post_parent'       =>  $prop_id,
        'post_status'       =>  null,
        'orderby'           =>  'menu_order',
        'order'             =>  'ASC',
        'exclude'           =>  get_post_thumbnail_id( $prop_id ),

    );
                
    $post_attachments   = get_posts($arguments);
   
    $counter_lightbox   =   0;
    $slides             =   '';
    $items              =   '';
    $no_slides          =   0;
    $attach_src        =    '';
    $post_thumbnail_id=0;
    if( has_post_thumbnail($prop_id) ){
        $counter_lightbox++;
        $post_thumbnail_id  =   get_post_thumbnail_id( $prop_id );
        $full_prty          =   wp_get_attachment_image_src($post_thumbnail_id, 'full');
        $attach_src         =   $full_prty[0];
      
    } 

    
    $items .= '<div class="item ">
            <div class="multi_image_slider_image  lightbox_trigger" data-slider-no="'.$counter_lightbox.'" style="background-image:url('.$attach_src.')" ></div>
            <div class="carousel-caption">';

    if ( has_excerpt( $post_thumbnail_id ) ) {
                   $caption=get_the_excerpt($post_thumbnail_id);
                } else {
                    $caption='';
                }
              
                if($caption!=''){
                    $items .= '<div class="carousel-caption_underlay"></div>
                    <div class="carousel_caption_text">'.$caption.'</div>';
                }
    $items .= '       
            </div>
        </div>';   
    
    foreach ($post_attachments as $attachment) { 
        $no_slides++;

        $counter_lightbox++;
        $post_thumbnail_id  =   get_post_thumbnail_id( $prop_id );
        $preview            =   wp_get_attachment_image_src($attachment->ID, 'full');
        $thumb              =   wp_get_attachment_image_src($attachment->ID, 'slider_thumb');
        $attachment_meta    =   wp_get_attachment($post_thumbnail_id);
        $items .= '<div class="item ">
            <div class="multi_image_slider_image  lightbox_trigger" data-slider-no="'.$counter_lightbox.'" style="background-image:url('.$preview[0].')" ></div>
            <div class="carousel-caption">';
            if($attachment->post_excerpt !=''){
                $items .='<div class="carousel-caption_underlay"></div>
                <div class="carousel_caption_text">'.$attachment->post_excerpt.'</div>';
            }
        $items .='
            </div>
        </div>';            
    }

    echo '<div class="property_multi_image_slider" data-auto="0">'.$items.'</div>';
    
}
endif;


if( !function_exists('wpestate_listing_full_width_slider') ):
function wpestate_listing_full_width_slider($prop_id){
    $background_image_style='';
    $counter_lightbox=0;
    if( has_post_thumbnail($prop_id) ){
        $counter_lightbox++;
        $post_thumbnail_id  =   get_post_thumbnail_id( $prop_id );
        $full_prty          =   wp_get_attachment_image_src($post_thumbnail_id, 'full');
        $thumb              =   wp_get_attachment_image_src($post_thumbnail_id, 'slider_thumb');
    } 
    
    $items = '<div class="item active">
            <div class="propery_listing_main_image lightbox_trigger" style="background-image:url('.$full_prty[0].')" data-slider-no="'.$counter_lightbox.'"></div>
            <div class="carousel-caption">
            </div>
        </div>';
    $indicator = '<li data-target="#carousel-property-page-header" data-slide-to="0" class="active"><div class="carousel-property-page-header-overalay"></div><img src="'.$thumb[0].'"></li>';
    
    $arguments      = array(
        'numberposts'       => -1,
        'post_type'         => 'attachment',
        'post_mime_type'    => 'image',
        'post_parent'       => $prop_id,
        'post_status'       => null,
        'exclude'           => get_post_thumbnail_id(),
        'orderby'           => 'menu_order',
        'order'             => 'ASC'
    );
                
    $post_attachments   = get_posts($arguments);
    $slides='';

    $no_slides = 0;
    foreach ($post_attachments as $attachment) { 
        $no_slides++;
        $counter_lightbox++;
        $preview    =   wp_get_attachment_image_src($attachment->ID, 'full');
        $thumb      =   wp_get_attachment_image_src($attachment->ID, 'slider_thumb');
        $indicator .= '<li data-target="#carousel-property-page-header" data-slide-to="'.$no_slides.'" class=""><div class="carousel-property-page-header-overalay"></div><img src="'.$thumb[0].'"></li>';    
        $items .= '<div class="item ">
            <div class="propery_listing_main_image lightbox_trigger" data-slider-no="'.$counter_lightbox.'" style="background-image:url('.$preview[0].')" ></div>
            <div class="carousel-caption">
            </div>
        </div>';            
    }

    
    
    print '<div id="carousel-property-page-header" class="carousel slide propery_listing_main_image" data-interval="false" data-ride="carousel">

 

    <div class="carousel-inner" role="listbox">
        '.$items.'
    </div>
    
    <div class="carousel-indicators-wrapper-header-prop">
        <ol class="carousel-indicators">
            '.$indicator.'
        </ol>
    </div>
    
    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-property-page-header" role="button" data-slide="prev">
       <i class="demo-icon icon-left-open-big"></i>
    </a>
    <a class="right carousel-control" href="#carousel-property-page-header" role="button" data-slide="next">
       <i class="demo-icon icon-right-open-big"></i>
    </a>

    </div>';
    
}
endif;

/////////////////////////////////////////////////////////
// customizable taxonomy header
/////////////////////////////////////////////////////////


///////////////////////////////////////////////////////////////////////////////////////////////////////////
///  Property details  function
///////////////////////////////////////////////////////////////////////////////////////////////////////////
if( !function_exists('wpestate_propery_subunits') ):

function wpestate_propery_subunits() {
    global $post;
    wp_nonce_field(plugin_basename(__FILE__), 'estate_property_noncename');
    
    $mypost             =   $post->ID;
    print'            
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td width="100%" valign="top" align="left">
            <p class="meta-options">';
    
            $property_subunits_master=intval(get_post_meta($mypost, 'property_subunits_master', true));  
          
            if($property_subunits_master!=0 && $property_subunits_master!=$post->ID){
            print '<span>'.esc_html__('Already Subunit for','wpresidence-core').' <a href="'. esc_url( get_permalink($property_subunits_master) ).'" target="_blank">'.get_the_title($property_subunits_master).'</a></span></br></br>';
            }
            print'
            <input type="hidden" name="property_has_subunits" value="">
            <input type="checkbox"  id="property_has_subunits" name="property_has_subunits" value="1" ';
                if (intval(get_post_meta($mypost, 'property_has_subunits', true)) == 1) {
                    print'checked="checked"';
                }
                print' />
            <label class="checklabel" for="property_has_subunits">'.esc_html__('Enable ','wpresidence-core').'</label>
            </p>
        </td>
    </tr>
    <tr>
        <td width="100%" valign="top" align="left">
            <p class="meta-options">';
           
                
            print'<span>'.esc_html__('Due to speed & usability reasons we only show your first 50 properties. If the Listing you want to add as subunit is not in this list please add the id manually.','wpresidence-core').'</span>
            <label for="property_subunits_list">'.esc_html__('Select Subunits From the list: ','wpresidence-core').'</label><br />';
           // <input type="text" id="property_subunits_list" size="40" name="property_subunits_list" value="' . esc_html(get_post_meta($mypost, 'property_subunits_list', true)) . '">
            $property_subunits_list   =  get_post_meta($mypost, 'property_subunits_list', true); 
            
           
            $post__not_in   =   array();
            $post__not_in[] =   $mypost;
            $args = array(       
                        'post_type'                 =>  'estate_property',
                        'post_status'               =>  'publish',
                        'nopaging'                  =>  'true',
                        'cache_results'             =>  false,
                        'update_post_meta_cache'    =>  false,
                        'update_post_term_cache'    =>  false,
                        'post__not_in'              =>  $post__not_in,
                       
                );

            $recent_posts = new WP_Query($args);
            print '<select name="property_subunits_list[]"  style="height:350px;" id="property_subunits_list"  multiple="multiple">';
            while ($recent_posts->have_posts()): $recent_posts->the_post();
                 $theid=get_the_ID();
                 print '<option value="'.$theid.'" ';
                 if( is_array($property_subunits_list) && in_array($theid, $property_subunits_list) ){
                     print ' selected="selected" ';
                 }
                 print'>'.get_the_title().'</option>';
            endwhile;
            wp_reset_postdata();
            $recent_posts->reset_postdata();
            $post->ID=$mypost;
            print '</select>';
            print'
            </p>
        </td>
    </tr>
    <tr>
        
        <td width="100%" valign="top" align="left">
            <p class="meta-options">
            <label for="property_subunits_list_manual">'.esc_html__('Or add the ids separated by comma. ','wpresidence-core').'</label><br />
            <textarea id="property_subunits_list_manual" size="40" name="property_subunits_list_manual" >' . esc_html(get_post_meta($mypost, 'property_subunits_list_manual', true)) . '</textarea>
            </p>
        </td>
    </tr>
    </table>
    ';
}
endif; // end  

$restrict_manage_posts = function($post_type, $taxonomy) {
    return function() use($post_type, $taxonomy) {
        global $typenow;

        if($typenow == $post_type) {
            $selected = isset($_GET[$taxonomy]) ? $_GET[$taxonomy] : '';
            $info_taxonomy = get_taxonomy($taxonomy);

            wp_dropdown_categories(array(
                'show_option_all'   => esc_html__("Show All {$info_taxonomy->label}"),
                'taxonomy'          => $taxonomy,
                'name'              => $taxonomy,
                'orderby'           => 'name',
                'selected'          => $selected,
                'show_count'        => TRUE,
                'hide_empty'        => TRUE,
                'hierarchical'      => true
            ));

        }

    };

};

$parse_query = function($post_type, $taxonomy) {

    return function($query) use($post_type, $taxonomy) {
        global $pagenow;

        $q_vars = &$query->query_vars;

        if( $pagenow == 'edit.php'
            && isset($q_vars['post_type']) && $q_vars['post_type'] == $post_type
            && isset($q_vars[$taxonomy])
            && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0
        ) {
            $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
            $q_vars[$taxonomy] = $term->slug;
        }

    };

};

add_action('restrict_manage_posts', $restrict_manage_posts('estate_property', 'property_category') );
add_filter('parse_query', $parse_query('estate_property', 'property_category') );

add_action('restrict_manage_posts', $restrict_manage_posts('estate_property', 'property_action_category') );
add_filter('parse_query', $parse_query('estate_property', 'property_action_category') );


add_action('restrict_manage_posts', $restrict_manage_posts('estate_property', 'property_city') );
add_filter('parse_query', $parse_query('estate_property', 'property_city') );
?>