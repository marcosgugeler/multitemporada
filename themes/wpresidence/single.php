<?php
// Sigle - Blog post
// Wp Estate Pack
get_header();
$wpestate_options=wpestate_page_details($post->ID); 
global $more;
$more = 0;

if ( 'wpestate_message' == get_post_type() || 'wpestate_invoice' == get_post_type() ){
    exit();
}
?>

<div id="post" <?php post_class('row');?>>
    <?php get_template_part('templates/breadcrumbs'); ?>
    <div class=" <?php print esc_html($wpestate_options['content_class']);?> single_width_blog">
        <?php get_template_part('templates/ajax_container'); ?>
        <?php 
        while ( have_posts() ) : the_post();
        if (esc_html( get_post_meta($post->ID, 'post_show_title', true) ) != 'no') { ?> 
            <h1 class="entry-title single-title" ><?php the_title(); ?></h1>
        <?php 
        } 
        
        if (has_post_thumbnail()){
            $pinterest = wp_get_attachment_image_src(get_post_thumbnail_id(),'property_full_map');
        }
         $email_link     =   'subject='.urlencode ( get_the_title() ) .'&body='. urlencode( esc_url(get_permalink()));
        ?>
            
        <div class="meta-info"> 
            <div class="meta-element"> <?php esc_html_e('Posted by ', 'wpresidence'); print ' '.get_the_author().' ';esc_html_e('on', 'wpresidence'); print' '.the_date('', '', '', FALSE); ?></div>
            <div class="meta-element"> <?php print '<span class="meta-separator"> | </span><i class="fa fa-file-o"></i> '; the_category(', ')?></div>
            <div class="meta-element"> <?php print '<span class="meta-separator"> | </span><i class="fa fa-comment-o"></i> '; comments_number( '0', '1' );  ?>   </div>   
            
            
            <div class="prop_social_single">

                <a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&amp;t=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share_facebook"><i class="fa fa-facebook fa-2"></i></a>
                <a href="http://twitter.com/home?status=<?php echo urlencode(get_the_title() .' '.  esc_url( get_permalink() )); ?>" class="share_tweet" target="_blank"><i class="fa fa-twitter fa-2"></i></a>
                <?php if (isset($pinterest[0])){ ?>
                   <a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&amp;media=<?php echo esc_url($pinterest[0]);?>&amp;description=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share_pinterest"> <i class="fa fa-pinterest fa-2"></i> </a>      
                <?php } ?>
                <a href="mailto:email@email.com?<?php echo trim($email_link);?>"  class="social_email"> <i class="fa fa-envelope"></i></a>

            </div>
            
        </div> 


        <div class="single-content single-blog">
            <?php 
            global $more;
            $more=0;
            include( locate_template('templates/postslider.php' ) );   
            the_content('Continue Reading');                     
            $args = array(
                       'before'           => '<p>' . esc_html__('Pages:','wpresidence'),
                       'after'            => '</p>',
                       'link_before'      => '',
                       'link_after'       => '',
                       'next_or_number'   => 'number',
                       'nextpagelink'     => esc_html__('Next page','wpresidence'),
                       'previouspagelink' => esc_html__('Previous page','wpresidence'),
                       'pagelink'         => '%',
                       'echo'             => 1
              ); 
            wp_link_pages( $args ); 
            
           
            ?>                           
        </div>    
     
        <!-- #comments start-->
        <?php 
         if ( comments_open() || get_comments_number() ) :
            comments_template('', true);
        endif;
        ?> 	
        
        <!-- end comments -->   
        
        <!-- #related posts start-->    
        <?php  include( locate_template('templates/related_posts.php') );?>    
        <!-- #end related posts -->   
        
     
        
        <?php endwhile; // end of the loop. ?>
    </div>
       
<?php   include get_theme_file_path('sidebar.php');?>
</div>   

<?php get_footer(); ?>