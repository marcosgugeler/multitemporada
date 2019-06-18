<div class="top_bar_wrapper <?php echo 'topbar_show_mobile_'.wpresidence_get_option('wp_estate_show_top_bar_user_menu_mobile',''); ?>">
    <div class="top_bar">      
        <?php if ( !wpestate_is_user_dashboard() ){?>
        
            <?php  if ( is_active_sidebar( 'top-bar-left-widget-area' ) ) { ?>
                <div class="left-top-widet">
                    <ul class="xoxo">
                        <?php dynamic_sidebar('top-bar-left-widget-area'); ?>
                    </ul>    
                </div> 
            <?php } ?>

            <?php  if ( is_active_sidebar( 'top-bar-right-widget-area' ) ) { ?>
                <div class="right-top-widet">
                    <ul class="xoxo">
                        <?php dynamic_sidebar('top-bar-right-widget-area'); ?>
                    </ul>
                </div> 
            <?php } ?>
        
        <?php }else{?>
        
            <?php  if ( is_active_sidebar( 'dashboard-top-bar-left-widget-area' ) ) { ?>
                <div class="left-top-widet">
                    <ul class="xoxo"> 
                        <?php dynamic_sidebar('dashboard-top-bar-left-widget-area'); ?>
                    </ul>    
                </div>  
            <?php } ?>
        
            <?php  if ( is_active_sidebar( 'dashboard-top-bar-right-widget-area' ) ) { ?>
                <div class="right-top-widet">
                    <ul class="xoxo">
                        <?php dynamic_sidebar('dashboard-top-bar-right-widget-area'); ?>
                    </ul>
                </div> 
             <?php } ?>
        
        <?php } ?>

    </div>    
</div>