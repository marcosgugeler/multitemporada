<?php
global $property_adr_text;
global $property_details_text;
global $property_features_text;
global $feature_list_array;
global $use_floor_plans;
global $property_description_text;
global $post;
$walkscore_api                  =   esc_html ( wpresidence_get_option('wp_estate_walkscore_api','') );
$show_graph_prop_page           =   esc_html( wpresidence_get_option('wp_estate_show_graph_prop_page', '') );
$virtual_tour                   =   get_post_meta($post->ID, 'embed_virtual_tour', true);
$header_type                    =   get_post_meta ( $post->ID, 'header_type', true);

?>
<div role="tabpanel" id="tab_prpg">

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">

    <li role="presentation" class="active">
        <a href="#details" aria-controls="details" role="tab" data-toggle="tab">
            <?php
                if($property_details_text=='') {
                    print esc_html__('Property Details', 'wpresidence');
                }else{
                    print  esc_html($property_details_text);
                }
            ?>
        </a>
    </li>

    <li role="presentation">
        <a href="#description" aria-controls="description" role="tab" data-toggle="tab">
        <?php
            if($property_description_text!=''){
                echo esc_html($property_description_text);
            }else{
                esc_html_e('Description','wpresidence');
            }
        ?>
        </a>

    </li>

    <?php
    if ( count( $feature_list_array )!= 0 && count($feature_list_array)!=1 ){ ?>
        <li role="presentation">
            <a href="#features" aria-controls="features" role="tab" data-toggle="tab">
               <?php
                    if($property_features_text ==''){
                        print esc_html__('Amenities and Features', 'wpresidence');
                    }else{
                        print esc_html($property_features_text);
                    }
                ?>
            </a>
        </li>
    <?php } ?>


    <li role="presentation">
        <a href="#camacozinha" aria-controls="camacozinha" role="tab" data-toggle="tab">Cama & Coz.</a>
    </li>

    <?php if ( $use_floor_plans==1 ){  ?>
    <li role="presentation">
        <a href="#floor" aria-controls="floor" role="tab" data-toggle="tab">
            <?php esc_html_e('Floor Plans','wpresidence');?>
        </a>
    </li>
    <?php } ?>


  </ul>

  <!-- Tab panes -->
  <div class="tab-content">

    <div role="tabpanel" class="tab-pane active" id="details">
        <?php print estate_listing_details($post->ID, 2);?>
    </div>

    <div role="tabpanel" class="tab-pane" id="description">
        <?php
            $content = get_the_content();
            $content = apply_filters('the_content', $content);
            $content = str_replace(']]>', ']]&gt;', $content);

            if($content!=''){
                print trim($content);
            }

            get_template_part ('/templates/download_pdf');
        ?>

        <!-- Energy saving -->
        <?php

            $energy_index       = get_post_meta($post->ID, 'energy_index', true) ;
            $energy_class       = get_post_meta($post->ID, 'energy_class', true) ;

        if ( $energy_index != ''    || $energy_class != ''  ){ //  if energy data  exists
        ?>
        <div class="property_energy_saving_info"  >
                    <?php print wpestate_energy_save_features($post->ID); ?>
        </div>
        <?php
        } // end if energy data  exists
        ?>
        <!-- END Energy saving -->


    </div>

    <div role="tabpanel" class="tab-pane" id="features">
        <?php print estate_listing_features($post->ID); ?>
    </div>

    <div role="tabpanel" class="tab-pane" id="camacozinha">
        <div class="col-md-6">
            <h5>Camas:</h5>
            <?php show_acf_group_fields('camas'); ?>
        </div>
        <div class="col-md-6">
            <h5>Cozinha:</h5>
            <ul style="list-style-type: none; margin-left: 0px;">
            <?php
            $allCheckbox = get_field('cozinha');
            $field = get_field_object('cozinha');
            foreach($field['choices'] as $lab => $val){
                if(in_array($val, $allCheckbox)){
                    $checked = 'checked = "checked"';
                    $enable = '';
                    ?>
                    <li><input type="checkbox" value="<?php echo $lab; ?>" <?php echo $enable; ?> <?php echo $checked; ?> /><?php echo $val; ?></li>
                    <?php
                }
                ?>
            <?php } ?>
            </ul>
        </div>
    </div>

    <?php if ( 1 == 2 && $use_floor_plans==1 ){  ?>
        <div role="tabpanel" class="tab-pane" id="floor">
            <?php print estate_floor_plan($post->ID); ?>
        </div>
    <?php } ?>



  </div>

</div>


<!-- ACF -->
<div class="panel-group property-panel" id="accordion_politicas">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title" id="prop_acf">Políticas da propriedade:</h4>
        </div>
        <div class="panel-body">
            <div class="col-md-12"><h5><i class="fa fa-clock-o"></i>Políticas de horário</h5></div>
            <?php $politicas_de_horarios = get_field('politicas_de_horarios'); ?>
            <div class="col-md-6">
                <h6>Check-in</h6>
                Horário início: <?php echo $politicas_de_horarios['horario_inicio_de_check-in']; ?>
                <br/>
                Horário término: <?php echo $politicas_de_horarios['horario_termino_de_check-in']; ?>
            </div>
            <div class="col-md-6">
                <h6>Check-out</h6>
                Horário início: <?php echo $politicas_de_horarios['horario_inicio_de_check-out']; ?>
                <br/>
                Horário término: <?php echo $politicas_de_horarios['horario_termino_de_check-out']; ?>
            </div>
        </div>

        <div class="panel-body">
            <div class="col-md-6">
                <h5><i class="fa fa-bed"></i>Políticas da hospedagem</h5>
                <?php show_acf_group_fields('politicas_da_hospedagem'); ?>
            </div>
            <div class="col-md-6">
                <h5><i class="fa fa-credit-card"></i>Políticas de pagamento</h5>
                <?php show_acf_group_fields('politica_de_pagamento'); ?>
            </div>
            <div class="col-md-6">
                <h5><i class="fa fa-ban"></i>Políticas de cancelamento</h5>
                <ul style="list-style-type: none; margin-left: 0px;">
                    <li><input type="checkbox" checked /><?php echo get_field('politicas_de_cancelamento'); ?></li>
                </ul>
            </div>
        </div>

    </div>
</div>
<!-- End ACF -->




<!-- Video -->
<?php
$video_id=  get_post_meta ( $post->ID, 'embed_video_id', true);
if ( $video_id!='' ){
?>

<div class="panel-group property-panel" id="accordion_video">
    <div class="panel panel-default">
        <div class="panel-heading">
            <a data-toggle="collapse" data-parent="#accordion_video" href="#collapseThreeOne">
              <?php
                if($property_features_text ==''){
                    print '<h4 class="panel-title" id="prop_video">'.esc_html__('Video', 'wpresidence').'</h4>';
                }else{
                    print '<h4 class="panel-title" id="prop_video">'.esc_html($property_video_text).'</h4>';
                }
              ?>
            </a>
        </div>
        <div id="collapseThreeOne" class="panel-collapse collapse in">
          <div class="panel-body">
            <?php
            print wpestate_listing_video($post->ID);
            ?>

          </div>
        </div>
    </div>
</div>

<?php
}
?>
<!-- End Video -->







<?php

    $prpg_slider_type_status= esc_html ( wpresidence_get_option('wp_estate_global_prpg_slider_type','') );
    $local_pgpr_slider_type_status  =   get_post_meta($post->ID, 'local_pgpr_slider_type', true);

    if( $local_pgpr_slider_type_status=='global' && ( $prpg_slider_type_status == 'full width header'||  $prpg_slider_type_status=='multi image slider' ||  $prpg_slider_type_status=='gallery'  )
            || $local_pgpr_slider_type_status=='full width header'  ||  $local_pgpr_slider_type_status=='multi image slider'  ||  $local_pgpr_slider_type_status=='gallery'
            ||  $local_pgpr_slider_type_status=='animation slider'){
    ?>
    <div class="panel-group property-panel" id="accordion_prop_map">
        <div class="panel panel-default">
            <div class="panel-heading">
                <a data-toggle="collapse" data-parent="#accordion_prop_map" href="#collapsemap">
                    <h4 class="panel-title" id="prop_ame"><?php esc_html_e('Map', 'wpresidence');?></h4>

                </a>
            </div>
            <div id="collapsemap" class="panel-collapse collapse in">
                <div class="panel-body">
                    <?php print do_shortcode('[property_page_map propertyid="'.$post->ID.'" ][/property_page_map]') ?>
                </div>
            </div>
        </div>
    </div>


    <?php
    }
?>


<!-- Virtual Tour -->

<?php

$virtual_tour                   =   get_post_meta($post->ID, 'embed_virtual_tour', true);
if($virtual_tour!='' && $header_type!=11 ){?>


<div class="panel-group property-panel" id="accordion_virtual_tour">
    <div class="panel panel-default">
        <div class="panel-heading">
            <a data-toggle="collapse" data-parent="#accordion_virtual_tour" href="#collapsenine">
                <?php
                    print '<h4 class="panel-title" id="prop_ame">'.esc_html__('Virtual Tour', 'wpresidence').'</h4>';
                ?>
            </a>
        </div>

        <div id="collapsenine" class="panel-collapse collapse in">
            <div class="panel-body">
                <?php wpestate_virtual_tour_details($post->ID); ?>
            </div>
        </div>
    </div>
</div>

<?php
}
?>

<!-- Walkscore -->

<?php
    $walkscore_api= esc_html ( wpresidence_get_option('wp_estate_walkscore_api','') );
    if($walkscore_api!=''){?>


<div class="panel-group property-panel" id="accordion_walkscore">
    <div class="panel panel-default">
        <div class="panel-heading">
            <a data-toggle="collapse" data-parent="#accordion_walkscore" href="#collapseFour">
                <?php
                    print '<h4 class="panel-title" id="prop_ame">'.esc_html__('WalkScore', 'wpresidence').'</h4>';
                ?>
            </a>
        </div>

        <div id="collapseFour" class="panel-collapse collapse in">
            <div class="panel-body">
                <?php wpestate_walkscore_details($post->ID); ?>
            </div>
        </div>
    </div>
</div>


<?php
}
?>


<?php
$yelp_client_id         =   wpresidence_get_option('wp_estate_yelp_client_id','');
$yelp_client_secret     =   wpresidence_get_option('wp_estate_yelp_client_secret','');
$yelp_client_api_key_2018  =   wpresidence_get_option('wp_estate_yelp_client_api_key_2018','');



if($yelp_client_api_key_2018!='' && $yelp_client_id!=''  ){
?>

<div class="panel-group property-panel" id="accordion_yelp">
    <div class="panel panel-default">
        <div class="panel-heading">
            <a data-toggle="collapse" data-parent="#accordion_yelp" href="#collapseyelp">
                <?php
                    print '<h4 class="panel-title" id="prop_ame">'.esc_html__('What\'s Nearby', 'wpresidence').'</h4>';
                ?>
            </a>
        </div>

        <div id="collapseyelp" class="panel-collapse collapse in">
            <div class="panel-body">
                <?php wpestate_yelp_details($post->ID); ?>
            </div>
        </div>
    </div>
</div>

<?php
}
?>


<?php
if($show_graph_prop_page=='yes'){
?>
    <div class="panel-group property-panel" id="accordion_prop_stat">
        <div class="panel panel-default">
           <div class="panel-heading">
               <a data-toggle="collapse" data-parent="#accordion_prop_stat" href="#collapseSeven">
                <h4 class="panel-title">
                <?php
                    esc_html_e('Page Views Statistics','wpresidence');

                ?>
                </h4>
               </a>
           </div>
           <div id="collapseSeven" class="panel-collapse collapse in">
             <div class="panel-body">
                <canvas id="myChart"></canvas>
             </div>
           </div>
        </div>
    </div>
    <script type="text/javascript">
    //<![CDATA[
        jQuery(document).ready(function(){
             wpestate_show_stat_accordion();
        });

    //]]>
    </script>
<?php
}

?>
