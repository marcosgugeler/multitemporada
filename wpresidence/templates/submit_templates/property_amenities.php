<?php
global $feature_list_array;
global $edit_id;
global $moving_array;
global $wpestate_submission_page_fields;

$list_to_show='';



foreach($feature_list_array as $key => $value){
    
    $post_var_name1 = str_replace(' ','_', trim($value) ); 
    $post_var_name =  html_entity_decode ( str_replace(' ','_', trim($value) ) , ENT_QUOTES | ENT_HTML5);


    
    if(  is_array($wpestate_submission_page_fields) && ( in_array($post_var_name, $wpestate_submission_page_fields) || in_array($post_var_name1, $wpestate_submission_page_fields)) ) { 
        $post_var_name =   wpestate_limit45(sanitize_title( $post_var_name ));
        $post_var_name =   sanitize_key($post_var_name);

        $value_label=$value;
        if (function_exists('icl_translate') ){
            $value_label    =   icl_translate('wpestate','wp_estate_property_custom_amm_'.$value, $value ) ;                                      
        }

        $list_to_show.= '<p class="featurescol">
               <input type="hidden"    name="'.$post_var_name.'" value="" >
               <input type="checkbox"   id="'.$post_var_name.'" name="'.$post_var_name.'" value="1" ';

        if (esc_html(get_post_meta($edit_id, $post_var_name, true)) == 1) {
            $list_to_show.=' checked="checked" ';
        }else{
            if(is_array($moving_array) ){                      
                if( in_array($post_var_name,$moving_array) ){
                    $list_to_show.= ' checked="checked" ';
                }
            }
        }
        $list_to_show.= ' /><label for="'.$post_var_name.'">'.stripslashes($value_label).'</label></p>';  
    }
}



if ( !empty($feature_list_array) && $list_to_show!='' ){ ?>
    <div class="col-md-12 add-estate profile-page profile-onprofile row"> 
        <div class="submit_container ">  
            <div class="col-md-4 profile_label">
                <div class="user_details_row"><?php esc_html_e('Amenities and Features','wpresidence');?></div> 
                <div class="user_profile_explain"><?php esc_html_e('Select what features and amenities apply for your property. ','wpresidence')?></div>
            </div>

            <div class="col-md-8">
                <?php print trim($list_to_show);?>
            </div>

        </div>
    </div>
<?php } ?>
