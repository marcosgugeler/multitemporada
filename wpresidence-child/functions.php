<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;


if ( !function_exists( 'wpestate_chld_thm_cfg_parent_css' ) ):
    function wpestate_chld_thm_cfg_parent_css() {
        $parent_style = 'wpestate_style';
        wp_enqueue_style('bootstrap.min',get_theme_file_uri('/css/bootstrap.min.css'), array(), '1.0', 'all');
        wp_enqueue_style('bootstrap-theme.min',get_theme_file_uri('/css/bootstrap-theme.min.css'), array(), '1.0', 'all');

        $use_mimify     =   wpresidence_get_option('wp_estate_use_mimify','');
        $mimify_prefix  =   '';
        if($use_mimify==='yes'){
            $mimify_prefix  =   '.min';
        }

        if($mimify_prefix===''){
            wp_enqueue_style($parent_style,get_template_directory_uri().'/style.css', array('bootstrap.min','bootstrap-theme.min'), '1.0', 'all');
        }else{
            wp_enqueue_style($parent_style,get_template_directory_uri().'/style.min.css', array('bootstrap.min','bootstrap-theme.min'), '1.0', 'all');
        }

        if ( is_rtl() ) {
           wp_enqueue_style( 'chld_thm_cfg_parent-rtl',  trailingslashit( get_template_directory_uri() ). '/rtl.css' );
	}
        wp_enqueue_style( 'wpestate-child-style',
            get_stylesheet_directory_uri() . '/style.css',
                array( $parent_style ),
                wp_get_theme()->get('Version')
        );

    }
endif;

load_child_theme_textdomain('wpresidence', get_stylesheet_directory().'/languages');
add_action( 'wp_enqueue_scripts', 'wpestate_chld_thm_cfg_parent_css' );

//-- ACF
function show_vista_do_imovel_items() {
    $field = get_field_object('vista_do_imovel');
    $colors = $field['value'];
    if( $colors ) {
    ?>
    <h5><?php echo do_shortcode('[font_awesome icon="eye" margin_right="5px"]'); ?>Vista do imóvel:</h5>
    <ul>
    <?php foreach( $colors as $color ) { ?>
    <li><?php echo $field['choices'][ $color ]; ?></li>
    <?php } ?>
    </ul>
    <?php
    }
}
add_shortcode( 'vista_do_imovel_items', 'show_vista_do_imovel_items' );

function show_localiza_se_items() {
    $field = get_field_object('localiza_se');
    $colors = $field['value'];
    if( $colors ) {
    ?>
    <h5><?php echo do_shortcode('[font_awesome icon="map-marker" margin_right="5px"]'); ?>Localiza-se:</h5>
    <ul>
    <?php foreach( $colors as $color ) { ?>
    <li><?php echo $field['choices'][ $color ]; ?></li>
    <?php } ?>
    </ul>
    <?php
    }
}
add_shortcode( 'localiza_se_items', 'show_localiza_se_items' );

function show_camas_items() {
    $field = get_field_object('camas');
    $colors = $field['value'];
    if( $colors ) {
    ?>
    <h5><?php echo do_shortcode('[font_awesome icon="bed" margin_right="5px"]'); ?>Camas:</h5>
    <ul>
    <?php foreach( $colors as $color ) { ?>
    <li><?php echo $field['choices'][ $color ]; ?></li>
    <?php } ?>
    </ul>
    <?php
    }
}
add_shortcode( 'camas_items', 'show_camas_items' );

function show_cozinha_items() {
    $field = get_field_object('cozinha');
    $colors = $field['value'];
    if( $colors ) {
    ?>
    <h5><?php echo do_shortcode('[font_awesome icon="cutlery" margin_right="5px"]'); ?>Cozinha:</h5>
    <ul>
    <?php foreach( $colors as $color ) { ?>
    <li><?php echo $field['choices'][ $color ]; ?></li>
    <?php } ?>
    </ul>
    <?php
    }
}
add_shortcode( 'cozinha_items', 'show_cozinha_items' );

function show_checkin_items() {
    $field = get_field_object('check_in');
    $colors = $field['value'];
    if( $colors ) {
    ?>
    <h5><?php echo do_shortcode('[font_awesome icon="sign-in" margin_right="5px"]'); ?>Check-in:</h5>
    <ul>
    <?php foreach( $colors as $color ) { ?>
    <li><?php echo $field['choices'][ $color ]; ?></li>
    <?php } ?>
    </ul>
    <?php
    }
}
add_shortcode( 'checkin_items', 'show_checkin_items' );

function show_checkout_items() {
    $field = get_field_object('check_out');
    $colors = $field['value'];
    if( $colors ) {
    ?>
    <h5><?php echo do_shortcode('[font_awesome icon="sign-out" margin_right="5px"]'); ?>Check-out:</h5>
    <ul>
    <?php foreach( $colors as $color ) { ?>
    <li><?php echo $field['choices'][ $color ]; ?></li>
    <?php } ?>
    </ul>
    <?php
    }
}
add_shortcode( 'checkout_items', 'show_checkout_items' );

function show_politicas_items() {
    $field = get_field_object('politicas');
    $colors = $field['value'];
    if( $colors ) {
    ?>
    <h5><?php echo do_shortcode('[font_awesome icon="file" margin_right="5px"]'); ?>Políticas:</h5>
    <ul>
    <?php foreach( $colors as $color ) { ?>
    <li><?php echo $field['choices'][ $color ]; ?></li>
    <?php } ?>
    </ul>
    <?php
    }
}
add_shortcode( 'politicas_items', 'show_politicas_items' );

function show_politica_de_pagamento_items() {
    $field = get_field_object('politica_de_pagamento');
    $colors = $field['value'];
    if( $colors ) {
    ?>
    <h5><?php echo do_shortcode('[font_awesome icon="usd" margin_right="5px"]'); ?>Políticas de pagamento:</h5>
    <ul>
    <?php foreach( $colors as $color ) { ?>
    <li><?php echo $field['choices'][ $color ]; ?></li>
    <?php } ?>
    </ul>
    <?php
    }
}
add_shortcode( 'politica_de_pagamento_items', 'show_politica_de_pagamento_items' );

function show_politica_de_cancelamento_items() {
    $field = get_field_object('politica_de_cancelamento');
    $colors = $field['value'];
    if( $colors ) {
    ?>
    <h5><?php echo do_shortcode('[font_awesome icon="calendar" margin_right="5px"]'); ?>Políticas de cancelamento:</h5>
    <ul>
    <?php foreach( $colors as $color ) { ?>
    <li><?php echo $field['choices'][ $color ]; ?></li>
    <?php } ?>
    </ul>
    <?php
    }
}
add_shortcode( 'politica_de_cancelamento_items', 'show_politica_de_cancelamento_items' );

if( !function_exists('estate_listing_details') ):
function estate_listing_details($post_id,$col=3){

    $wpestate_currency       =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
    $where_currency =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
    $measure_sys    =   esc_html ( wpresidence_get_option('wp_estate_measure_sys','') );
    $property_size  =   wpestate_get_converted_measure( $post_id, 'property_size' );
    $colmd=4;

    switch ($col) {
        case 1:
            $colmd=12;
            break;
        case  2:
            $colmd=6;
            break;
        case  3:
            $colmd=4;
            break;
        case  4:
            $colmd=3;
            break;
    }



    $property_lot_size = wpestate_get_converted_measure( $post_id, 'property_lot_size' );
    $property_rooms     = floatval ( get_post_meta($post_id, 'property_rooms', true) );
    $property_bedrooms  = floatval ( get_post_meta($post_id, 'property_bedrooms', true) );
    $property_bathrooms = floatval ( get_post_meta($post_id, 'property_bathrooms', true) );
    $price              = floatval   ( get_post_meta($post_id, 'property_price', true) );


    $energy_index       = get_post_meta($post_id, 'energy_index', true) ;
    $energy_class              = get_post_meta($post_id, 'energy_class', true);


    if ($price != 0) {
        $price =wpestate_show_price($post_id,$wpestate_currency,$where_currency,1);
    }else{
        $price='';
    }

    $return_string='';
    $return_string.='<div class="listing_detail col-md-'.$colmd.'" id="propertyid_display"><strong>'.esc_html__('Property Id ','wpresidence'). ':</strong> '.get_post_meta($post_id, 'codigo_imovel', true).'</div>';

    if ($price !='' ){
        $return_string.='<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Price','wpresidence'). ':</strong> '. $price.'</div>';
    }
    if ($property_size != ''){
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Property Size','wpresidence').':</strong> ' . $property_size . '</div>';
    }
    /*
    if ($property_lot_size != ''){
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Property Lot Size','wpresidence').':</strong> ' . $property_lot_size . '</div>';
    }
    */
    if ($property_rooms != ''){
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Rooms','wpresidence').':</strong> ' . $property_rooms . '</div>';
    }
    if ($property_bedrooms != ''){
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Bedrooms','wpresidence').':</strong> ' . $property_bedrooms . '</div>';
    }
    if ($property_bathrooms != '')    {
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Bathrooms','wpresidence').':</strong> ' . $property_bathrooms . '</div>';
    }


    // energy saving
    if ($energy_index != '')    {
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Energy index','wpresidence').':</strong> ' . $energy_index . ' kWh/m²a</div>';
    }
    if ($energy_class != '')    {
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Energy class','wpresidence').':</strong> ' . $energy_class . '</div>';
    }

    $field = get_field_object('camas');
    $camas = $field['value'];
    if( $camas ) {
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.do_shortcode('[font_awesome icon="bed" margin_right="5px"]').'Camas:</strong><ul>';
        foreach( $camas as $cama ) {
            $return_string.= '<li>'.$field['choices'][ $cama ].'</li>';
        }
        $return_string.= '</ul></div>';
    }
    // $return_string.= '<div class="listing_detail col-md-'.$colmd.'">'.show_cozinha_items().'</div>';


    // Custom Fields


    $i=0;
    $custom_fields = wpresidence_get_option( 'wp_estate_custom_fields', '');

    if( !empty($custom_fields)){
        while($i< count($custom_fields) ){
            $name   =   $custom_fields[$i][0];
            $prslig =   str_replace(' ','_',$name);
            $label  =   stripslashes($custom_fields[$i][1]);
            $type   =   $custom_fields[$i][2];
            $slug   =   wpestate_limit45(sanitize_title( $name ));
            $slug   =   sanitize_key($slug);
            $wpestate_submission_page_fields         =   wpresidence_get_option('wp_estate_submission_page_fields','');

            if( is_array($wpestate_submission_page_fields) &&  in_array($prslig, $wpestate_submission_page_fields) ) {
                $value=esc_html(get_post_meta($post_id, $slug, true));
                if (function_exists('icl_translate') ){
                    $label     =   icl_translate('wpestate','wp_estate_property_custom_'.$label, $label ) ;
                    $value     =   icl_translate('wpestate','wp_estate_property_custom_'.$value, $value ) ;
                }

                if($value!=''){
                   $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.trim($label).':</strong> ' .$value. '</div>';
                }
            }

            $i++;
        }
    }

     //END Custom Fields



    return $return_string;
}
endif; // end   estate_listing_details
