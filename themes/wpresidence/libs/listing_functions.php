<?php
///////////////////////////////////////////////////////////////////////////////////////////
// floor plans
///////////////////////////////////////////////////////////////////////////////////////////


if( !function_exists('estate_floor_plan') ):
    function estate_floor_plan($post_id,$is_print=0){

        $is_print_class='';
        if($is_print==1){
            $is_print_class=' floor_print_class ';
        }

        $unit               = wpestate_get_meaurement_unit_formated( );

        $plan_title_array   = get_post_meta($post_id, 'plan_title', true);
        $plan_desc_array    = get_post_meta($post_id, 'plan_description', true) ;
        $plan_image_array   = get_post_meta($post_id, 'plan_image', true) ;
        $plan_size_array    = get_post_meta($post_id, 'plan_size', true) ;


        $plan_image_attach_array    = get_post_meta($post_id, 'plan_image_attach', true) ;

        $plan_rooms_array   = get_post_meta($post_id, 'plan_rooms', true) ;
        $plan_bath_array    = get_post_meta($post_id, 'plan_bath', true);
        $plan_price_array   = get_post_meta($post_id, 'plan_price', true) ;

        $wpestate_currency                   =   esc_html( wpresidence_get_option('wp_estate_currency_symbol', '') );
        $where_currency             =   esc_html( wpresidence_get_option('wp_estate_where_currency_symbol', '') );
        global $lightbox;
        $lightbox                   =   '';
        $show= ' style="display:block"; ';

        if (is_array($plan_title_array)){
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

                if ( isset($plan_size_array[$key]) && $plan_size_array[$key]!=''){
                    $plan_size='<span class="bold_detail">'.esc_html__('size:','wpresidence').'</span> '.wpestate_convert_measure($plan_size_array[$key]).' '.$unit;
                }else{
                    $plan_size='';
                }

                if ( isset($plan_rooms_array[$key]) && $plan_rooms_array[$key]!=''){
                    $plan_rooms= '<span class="bold_detail">'.esc_html__('rooms: ','wpresidence').'</span> '.$plan_rooms_array[$key];
                }else{
                    $plan_rooms='';
                }

                if ( isset($plan_bath_array[$key]) && $plan_bath_array[$key]!=''){
                    $plan_bath='<span class="bold_detail">'.esc_html__('baths:','wpresidence').'</span> '.$plan_bath_array[$key];
                }else{
                    $plan_bath='';
                }
                $price='';
                if ( isset($plan_price_array[$key]) && $plan_price_array[$key]!=''){
                    $plan_price=$plan_price_array[$key];
                }else{
                    $plan_price='';
                }
                $full_img           = wp_get_attachment_image_src($plan_image_attach, 'full');

                print '
                <div class="front_plan_row '.esc_attr($is_print_class).'">
                    <div class="floor_title">'.esc_html($plan_name).'</div>
                    <div class="floor_details">'.trim($plan_size).'</div>
                    <div class="floor_details">'.trim($plan_rooms).'</div>
                    <div class="floor_details">'.trim($plan_bath).'</div>
                    <div class="floor_details floor_price_details">';
                        if($plan_price!=''){
                            print '<span class="bold_detail">'. esc_html__('price: ','wpresidence').'</span> '.wpestate_show_price_floor($plan_price,$wpestate_currency,$where_currency,1);
                        }
                        print'</div>
                </div>
                <div class="front_plan_row_image '.esc_attr($is_print_class).'"   '.trim($show).'>
                    <div class="floor_image">
                        <a href="'.esc_url($full_img[0]).'" rel="prettyPhoto" title="'.esc_attr($plan_desc).'"><img class="lightbox_trigger_floor" src="'.esc_url($full_img[0]).'"  alt="'.esc_attr($plan_name).'"></a>
                    </div>
                    <div class="floor_description">'.esc_html($plan_desc).'</div>
                </div>';
                $show='';


                $lightbox.='<div class="item" >
                                <div class="itemimage">
                                    <img src="'.esc_url($full_img[0]).'" alt="'.esc_html($plan_name).'">
                                </div>

                                <div class="lightbox_floor_details">
                                    <div class="floor_title">'.esc_html($plan_name).'</div>
                                    <div class="floor_light_desc">'.esc_html($plan_desc).'</div>
                                    <div class="floor_details">'.trim($plan_size).'</div>
                                    <div class="floor_details">'.trim($plan_rooms).'</div>
                                    <div class="floor_details">'.trim($plan_bath).'</div>
                                    <div class="floor_details">';
                                    if($plan_price!=''){
                                        $lightbox.= '<span class="bold_detail">'. esc_html__('price: ','wpresidence').'</span> '.wpestate_show_price_floor($plan_price,$wpestate_currency,$where_currency,1);
                                    }
                                    $lightbox.='</div>
                                </div>
                        </div>';


            }


         include( locate_template('templates/floorplans_gallery.php') );
        }
    }
endif;

if( !function_exists('wpestate_listing_video') ):
function wpestate_listing_video($post_id){
    $full_img_path  = get_post_meta($post_id, 'property_custom_video', true);

    if($full_img_path==''){
        $thumb_id           =   get_post_thumbnail_id($post_id);
        $full_img           =   wp_get_attachment_image_src( $thumb_id, 'listing_full_slider_1' );
        $full_img_path      =   $full_img[0];
    }

    $video_id           =   esc_html( get_post_meta($post_id, 'embed_video_id', true) );
    $video_type         =   esc_html( get_post_meta($post_id, 'embed_video_type', true) );
    $video_link         =   '';
    $protocol           =   is_ssl() ? 'https' : 'http';
    if($video_type=='vimeo'){
        $video_link .=  $protocol.'://player.vimeo.com/video/' . $video_id . '?api=1&amp;player_id=player_1';
    }else{
        $video_link .=  $protocol.'://www.youtube.com/embed/' . $video_id  . '?wmode=transparent&amp;rel=0';
    }
    return '<div class="property_video_wrapper" ><div id="property_video_wrapper_player"></div><a href="'.esc_url($video_link).'"  data-autoplay="true" data-vbtype="video" class="venobox"><img  src="'.esc_url($full_img_path).'"  alt="'.esc_html__('video image','wpresidence').'" /></a></div>';

}
endif;
///////////////////////////////////////////////////////////////////////////////////////////
// List features and ammenities
///////////////////////////////////////////////////////////////////////////////////////////

if( !function_exists('estate_listing_features') ):
function estate_listing_features($post_id,$col=3,$is_print=0){
    $return_string='';
    $counter            =   0;
    $feature_list_array =   array();
    $feature_list       =   esc_html( wpresidence_get_option('wp_estate_feature_list') );

    $feature_list_array =   explode( ',',$feature_list);
    $total_features     =   round( count( $feature_list_array )/2 );
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

     $show_no_features= esc_html ( wpresidence_get_option('wp_estate_show_no_features','') );



        if($show_no_features!='no' && $is_print==0){
            foreach($feature_list_array as $checker => $value){
                    $counter++;
                    $post_var_name  =   str_replace(' ','_', trim($value) );
                    $input_name     =   wpestate_limit45(sanitize_title( $post_var_name ));
                    $input_name     =   sanitize_key($input_name);


                    if (function_exists('icl_translate') ){
                        $value     =   icl_translate('wpestate','wp_estate_property_custom_amm_'.$value, $value ) ;
                    }

                    if (esc_html( get_post_meta($post_id, $input_name, true) ) == 1) {
                         $return_string .= '<div class="listing_detail col-md-'.$colmd.'"><i class="fa fa-check"></i>' . trim(stripslashes($value)) . '</div>';
                    }else{
                        $return_string  .=  '<div class="listing_detail col-md-'.$colmd.'"><i class="fa fa-times"></i>' .  trim(stripslashes($value)) . '</div>';
                    }
              }
        }else{

            foreach($feature_list_array as $checker => $value){
                $post_var_name  =  str_replace(' ','_', trim($value) );
                $input_name     =   wpestate_limit45(sanitize_title( $post_var_name ));
                $input_name     =   sanitize_key($input_name);

                if (function_exists('icl_translate') ){
                    $value     =   icl_translate('wpestate','wp_estate_property_custom_amm_'.$value, $value ) ;
                }

                if ($input_name!='' && esc_html( get_post_meta($post_id, $input_name, true) ) == 1) {
                    $return_string .=  '<div class="listing_detail col-md-'.$colmd.'"><i class="fa fa-check"></i>' .  trim(stripslashes($value))  . '</div>';
                }
            }

       }

    return $return_string;
}
endif; // end   estate_listing_features



if( !function_exists('estate_listing_content') ):
function estate_listing_content($post_id){
    $content='';
    $args= array(
        'post_type'         => 'estate_property',
        'post_status'       => 'publish',
        'p' => $post_id
    );
    $the_query = new WP_Query( $args);


       while ($the_query->have_posts()) :
            $the_query->the_post();

            $content= get_the_content();
        endwhile;

        wp_reset_postdata();

    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);


    $args = array(  'post_mime_type'    => 'application/pdf',
                'post_type'         => 'attachment',
                'numberposts'       => -1,
                'post_status'       => null,
                'post_parent'       => $post_id
        );

    $attachments = get_posts($args);

    if ($attachments) {

        $content.= '<div class="download_docs">'.esc_html__('Documents','wpresidence').'</div>';
        foreach ( $attachments as $attachment ) {
            $content.= '<div class="document_down"><a href="'. esc_url(wp_get_attachment_url($attachment->ID)).'" target="_blank">'.$attachment->post_title.'<i class="fa fa-download"></i></a></div>';
        }
    }

    wp_reset_postdata();


    return $content;

}
endif;




if( !function_exists('estate_listing_address') ):
function estate_listing_address($post_id,$col=3){

    $property_address   = esc_html( get_post_meta($post_id, 'property_address', true) );
    $property_city      = get_the_term_list($post_id, 'property_city', '', ', ', '');
    $property_area      = get_the_term_list($post_id, 'property_area', '', ', ', '');
    $property_county    = get_the_term_list($post_id, 'property_county_state', '', ', ', '') ;
    $property_zip       = esc_html(get_post_meta($post_id, 'property_zip', true) );
    $property_country   = esc_html(get_post_meta($post_id, 'property_country', true) );
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

    $return_string='';

    if ($property_address != ''){
        $return_string.='<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Address','wpresidence').':</strong> ' . $property_address . '</div>';
    }
    if ($property_city != ''){
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('City','wpresidence').':</strong> ' .$property_city. '</div>';
    }
    if ($property_area != ''){
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Area','wpresidence').':</strong> ' .$property_area. '</div>';
    }
    if ($property_county != ''){
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('State/County','wpresidence').':</strong> ' . $property_county . '</div>';
    }
    if ($property_zip != ''){
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Zip','wpresidence').':</strong> ' . $property_zip . '</div>';
    }
    if ($property_country != '') {
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Country','wpresidence').':</strong> ' . $property_country . '</div>';
    }
    $property_address   =   esc_html( get_post_meta($post_id, 'property_address', true) );
    $property_city      =   strip_tags (  get_the_term_list($post_id, 'property_city', '', ', ', '') );
    $url                =   urlencode($property_address.','.$property_city);
    $google_map_url     =   "http://maps.google.com/?q=".$url;

    $return_string.= ' <a href="'.esc_url($google_map_url).'" target="_blank" class="acc_google_maps">'.esc_html__('Open In Google Maps','wpresidence').'</a>';

    return  $return_string;
}
endif; // end   estate_listing_address



if( !function_exists('estate_listing_address_printing') ):
function estate_listing_address_printing($post_id){

    $property_address   = esc_html( get_post_meta($post_id, 'property_address', true) );
    $property_city      = strip_tags (  get_the_term_list($post_id, 'property_city', '', ', ', '') );
    $property_area      = strip_tags ( get_the_term_list($post_id, 'property_area', '', ', ', '') );
    $property_county    = strip_tags ( get_the_term_list($post_id, 'property_county_state', '', ', ', '')) ;
    //$property_state     = esc_html(get_post_meta($post_id, 'property_state', true) );
    $property_zip       = esc_html(get_post_meta($post_id, 'property_zip', true) );
    //$property_state     = esc_html(get_post_meta($post_id, 'property_state', true) );

    $property_country   = esc_html(get_post_meta($post_id, 'property_country', true) );

    $return_string='';

    if ($property_address != ''){
        $return_string.='<div class="listing_detail col-md-4"><strong>'.esc_html__('Address','wpresidence').':</strong> ' . $property_address . '</div>';
    }
    if ($property_city != ''){
        $return_string.= '<div class="listing_detail col-md-4"><strong>'.esc_html__('City','wpresidence').':</strong> ' .$property_city. '</div>';
    }
    if ($property_area != ''){
        $return_string.= '<div class="listing_detail col-md-4"><strong>'.esc_html__('Area','wpresidence').':</strong> ' .$property_area. '</div>';
    }
    if ($property_county != ''){
        $return_string.= '<div class="listing_detail col-md-4"><strong>'.esc_html__('State/County','wpresidence').':  </strong> ' . $property_county . '</div>';
    }
   /* if ($property_state != ''){
        $return_string.= '<div class="listing_detail col-md-4"><strong>'.esc_html__('State','wpresidence').':</strong> ' . $property_state . '</div>';
    }

    */
    if ($property_zip != ''){
        $return_string.= '<div class="listing_detail col-md-4"><strong>'.esc_html__('Zip','wpresidence').':</strong> ' . $property_zip . '</div>';
    }
    if ($property_country != '') {
        $return_string.= '<div class="listing_detail col-md-4"><strong>'.esc_html__('Country','wpresidence').':</strong> ' . $property_country . '</div>';
    }


    return  $return_string;
}
endif; // end   estate_listing_address






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
    $return_string.='<div class="listing_detail col-md-'.$colmd.'" id="propertyid_display"><strong>'.esc_html__('Property Id ','wpresidence'). ':</strong> '.$post_id.'</div>';
    if ($price !='' ){
        $return_string.='<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Price','wpresidence'). ':</strong> '. $price.'</div>';
    }

    if ($property_size != ''){
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Property Size','wpresidence').':</strong> ' . $property_size . '</div>';
    }
    if ($property_lot_size != ''){
        $return_string.= '<div class="listing_detail col-md-'.$colmd.'"><strong>'.esc_html__('Property Lot Size','wpresidence').':</strong> ' . $property_lot_size . '</div>';
    }
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

	// ee end


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



if( !function_exists('wpestate_energy_save_features') ):
function wpestate_energy_save_features($post_id,$col=3){

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

    $energy_index = null;
	$energy_class = null;
	$return_string =  '';

	$energy_index       = get_post_meta($post_id, 'energy_index', true) ;
	$energy_class       = get_post_meta($post_id, 'energy_class', true) ;




     //END Custom Fields

	$energy_class_array = array(
		array( 'value' => 'A+', 'from' => 0, 'to' => 14 ),
		array( 'value' => 'A', 'from' => 14, 'to' => 29 ),
		array( 'value' => 'B', 'from' => 29, 'to' => 58 ),
		array( 'value' => 'C', 'from' => 58, 'to' => 87 ),
		array( 'value' => 'D', 'from' => 87, 'to' => 116 ),
		array( 'value' => 'E', 'from' => 116, 'to' => 145 ),
		array( 'value' => 'F', 'from' => 145, 'to' => 175 ),
		array( 'value' => 'G', 'from' => 175, 'to' => 1000 ),
	);
	 $default_energy_class = '';
	if ($energy_index != '')    {
		// getting class by index

		foreach( $energy_class_array as $single_row ){

			if( (int)$energy_index > $single_row['from'] && (int)$energy_index <= $single_row['to'] ){
				$default_energy_class = $single_row['value'];
			}
		}
    }


	if ($energy_class != '')    {

		if( $default_energy_class != $energy_class ){
			$default_energy_class = $energy_class;
		}

		if( $default_energy_class == '' ){
			$default_energy_class = $energy_class;
		}
		$out_msg_array = array();
		$message_pop = array( 'Aplus' => null, 'A' => null, 'B' => null, 'C' => null, 'D' => null, 'E' => null, 'F' => null,  'G' => null );


		switch( $default_energy_class ){
			case "A+":
				if( $energy_index ){
					$message_pop['Aplus'] = '<div class="indicator-energy" data-energyclass="A+">
								 '.$energy_index.' kWh/m²a | '.esc_html__('Your energy class is ','wpresidence').' A+</div>';
				}else{
					$message_pop['Aplus'] = '<div class="indicator-energy" data-energyclass="A+">
								 '.esc_html__('Your energy class is ','wpresidence').' A+</div>';
				}
			break;
			case "A":
				if( $energy_index ){
					$message_pop['A'] = '<div class="indicator-energy" data-energyclass="A">
								 '.$energy_index.' kWh/m²a | '.esc_html__('Your energy class ','wpresidence').' A</div>';
				}else{
					$message_pop['A'] = '<div class="indicator-energy" data-energyclass="A">
								 '.esc_html__('Your energy class is ','wpresidence').' A</div>';
				}
			break;
			case "B":
				if( $energy_index ){
					$message_pop['B'] = '<div class="indicator-energy" data-energyclass="B">
								 '.$energy_index.' kWh/m²a | '.esc_html__('Your energy class ','wpresidence').' B</div>';
				}else{
					$message_pop['B'] = '<div class="indicator-energy" data-energyclass="B">
								 '.esc_html__('Your energy class is ','wpresidence').' B</div>';
				}
			break;
			case "C":
				if( $energy_index ){
					$message_pop['C'] = '<div class="indicator-energy" data-energyclass="C">
								 '.$energy_index.' kWh/m²a | '.esc_html__('Your energy class is','wpresidence').' C</div>';
				}else{
					$message_pop['C'] = '<div class="indicator-energy" data-energyclass="C">
								 '.esc_html__('Your energy class is','wpresidence').' C</div>';
				}
			break;
			case "D":
				if( $energy_index ){
					$message_pop['D'] = '<div class="indicator-energy" data-energyclass="D">
								 '.$energy_index.' kWh/m²a | '.esc_html__('Your energy class is ','wpresidence').' D</div>';
				}else{
					$message_pop['D'] = '<div class="indicator-energy" data-energyclass="D">
								 '.esc_html__('Your energy class ','wpresidence').' D</div>';
				}
			break;
			case "E":
				if( $energy_index ){
					$message_pop['E'] = '<div class="indicator-energy" data-energyclass="E">
								 '.$energy_index.' kWh/m²a | '.esc_html__('Your energy class is ','wpresidence').' E</div>';
				}else{
					$message_pop['E'] = '<div class="indicator-energy" data-energyclass="E">
								 '.esc_html__('Your energy class ','wpresidence').' E</div>';
				}
			break;
			case "F":
				if( $energy_index ){
					$message_pop['F'] = '<div class="indicator-energy" data-energyclass="F">
								 '.$energy_index.' kWh/m²a | '.esc_html__('Your energy class is ','wpresidence').' F</div>';
				}else{
					$message_pop['F'] = '<div class="indicator-energy" data-energyclass="F">
								 '.esc_html__('Your energy class ','wpresidence').' F</div>';
				}
			break;
			case "G":
				if( $energy_index ){
					$message_pop['G'] = '<div class="indicator-energy" data-energyclass="G">
								 '.$energy_index.' kWh/m²a | '.esc_html__('Your energy class is ','wpresidence').' G</div>';
				}else{
					$message_pop['G'] = '<div class="indicator-energy" data-energyclass="G">
								 '.esc_html__('Your energy class is ','wpresidence').' G</div>';
				}
			break;
		}



        $return_string .=
		'
		<div class="listing_detail col-md-12">

			<div class="energy_class_container">
				<div class="col-xs-extra">
					<div class="row class-energy">
							<div class="col-eng-gruppo energy-gruppo-1">
								'.$message_pop['Aplus'].'
								<p class="energy-Aplus">A+</p>
							</div>
							<div class="col-eng-gruppo energy-gruppo-1">
								'.$message_pop['A'].'
								<p class="energy-A">A</p>
							</div>
							<div class="col-eng-gruppo energy-gruppo-1">
								'.$message_pop['B'].'
								<p class="energy-B">B</p>
							</div>
							<div class="col-eng-gruppo energy-gruppo-1">
								'.$message_pop['C'].'
								<p class="energy-C">C</p>
							</div>
							<div class="col-eng-gruppo energy-gruppo-1">
								'.$message_pop['D'].'
								<p class="energy-D">D</p>
							</div>
							<div class="col-eng-gruppo energy-gruppo-1">
								'.$message_pop['E'].'
								<p class="energy-E">E</p>
							</div>
							<div class="col-eng-gruppo energy-gruppo-1">
								'.$message_pop['F'].'
								<p class="energy-F">F</p>
							</div>
							<div class="col-eng-gruppo energy-gruppo-1">
								 '.$message_pop['G'].'
								<p class="energy-G">G</p>
							</div>
					</div>
				</div>
			</div>
		</div>';
    }


    return $return_string;
}
endif; // end   energy save
?>
