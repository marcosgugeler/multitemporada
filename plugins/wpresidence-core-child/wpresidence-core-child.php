<?php
/*
 *  Plugin Name: Wpresidence -Theme Core Child Functionality
 *  Description: Adds functionality to WpResidence
 *  Version:     1.0
 *  Author:      marcosgugeler
 *  Author URI:  https://gugelerit.com/
 *  License:     GPL2
 *  Text Domain: wpresidence-core
 *  Domain Path: /languages
 *
*/

if( !function_exists('wpestate_estate_box') ):
function wpestate_estate_box() {
    global $post;
    wp_nonce_field(plugin_basename(__FILE__), 'estate_property_noncename');
    $mypost = $post->ID;

    $property_label_before_default = get_post_meta($mypost, 'property_label_before', true)?get_post_meta($mypost, 'property_label_before', true):'Tarifa média de';


    print'
    <div class="property_prop_half">
        <label for="property_price">'.esc_html__('Price: ','wpresidence-core').'</label><br />
        <input type="text" id="property_price" size="40" name="property_price" value="' . esc_html(get_post_meta($mypost, 'property_price', true)) . '">
    </div>

    <div class="property_prop_half">
        <label for="property_label_before">'.esc_html__('Before Price Label(*for example "per month"): ','wpresidence-core').'</label><br />
        <input type="text" id="property_label_before" size="40" name="property_label_before" value="' . esc_html($property_label_before_default) . '">
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
endif;
