<?php

//
//  Custom Child Theme Functions
//

// I've included a "commented out" sample function below that'll add a home link to your menu
// More ideas can be found on "A Guide To Customizing The Thematic Theme Framework" 
// http://themeshaper.com/thematic-for-wordpress/guide-customizing-thematic-theme-framework/

// Adds a home link to your menu
// http://codex.wordpress.org/Template_Tags/wp_page_menu
//function childtheme_menu_args($args) {
//    $args = array(
//        'show_home' => 'Home',
//        'sort_column' => 'menu_order',
//        'menu_class' => 'menu',
//        'echo' => true
//    );
//	return $args;
//}
//add_filter('wp_page_menu_args','childtheme_menu_args');


//------------------------------------------------------------------------------adding the top utility bar as an action hook
function pickle_top_utility() {
?>

<!-- the utility html starts here -->

<div class="top_container">
    <div class="top_container_content">
        <div id="login">
            <span class="loginout"><?php wp_loginout(); ?></span>
            <span class="register"><?php wp_register('| ', ''); ?></span>
        </div>
        <div id="greeting">
            <p>Please tell us what pickle pleases you. Join Here</p>
        </div>
        <div>
            <span class="searchform"><?php get_search_form(); ?> </span>
        </div>
    </div>
</div>
<!-- the utility html ends here -->
<?php
} // end of our new function childtheme_top_utility
add_action('thematic_before','pickle_top_utility'); // Here we add our new function to our Thematic Action Hook


//------------------------------------------------------------------------------creating a thumb loop (seeMirnaOSDF09)
//* First we will add the thumbnail feature *//
add_theme_support('post-thumbnails');
 
//* To create our own loop we have to get rid of thematic index loop first.*//
function remove_index_loop() {
     remove_action('thematic_indexloop', 'thematic_index_loop');
}
add_action('init', 'remove_index_loop');
 
// Now we will create our own loop.
function thumb_index_loop(){
           
    // This shows posts only from category (featured pickle) id=18
    query_posts($query_string . '&cat=18');
            
        // Start the loop:  
        if (have_posts()) :
        while ( have_posts() ) : the_post();
        
        
            // This is just what we decide to show in each post ?>
            <div id="featured" class="<?php thematic_post_class() ?>">
                <?php the_post_thumbnail();  // we just called for the thumbnail ?>
                <div class="entry-content">
                     <!-- Display the Title as a link to the Post's permalink. -->
                    <h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                    <?php echo polldaddy_get_rating_html(); ?>
                    <?php the_meta(); ?>
                    <?php the_content('Read more...'); ?>         
                </div>
            </div><!-- .post -->
    
        <?php endwhile; // loop done, go back up | enter navigational links between here and else
        
        else : ?> <!-- add not found content here -->
            <h2>Not Found</h2>
        <?php endif;  //the first loop is now completely ended 

//------------------------------------------------------------------------------This query asks for posts only from category (front page gallery) id=17
    query_posts($query_string . '&cat=17');
                
        // Start the second loop:  
        if (have_posts()) :
        while ( have_posts() ) : the_post();?>
            
            <div id="gallery_thumb" class="<?php thematic_post_class() ?>">
                <?php the_post_thumbnail();  // we just called for the thumbnail ?>
                <div class="gallery-content">
                    <!-- Display the Title as a link to the Post's permalink. -->
                    <h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                    <?php echo polldaddy_get_rating_html(); ?>
                    <?php the_meta(); ?>
                </div>
            </div><!-- .post -->
        <?php endwhile; // loop done, go back up | enter navigational links between here and else
        
        else : ?> <!-- add not found content here -->
            <h2>Not Found</h2>
        <?php endif;  //the loop is now completely ended 
    

} //closes the thumb_index_loop function code
    
// activate the new loop fucntion.
add_action('thematic_indexloop', 'thumb_index_loop');


//------------------------------------------------------------------------------UN-Register unneccesary sidebars & register a new Sidebar.

function pickleplease_sidebars_init() {

      // Register the New Footer Sidebar
      register_sidebar(array(
        
      // Title for the Widget Dashboard
      'name' => 'New Sidebar',
      
      // ID for the XHTML Markup
      'id' => 'new-sidebar',

      // Description for the Widget Dashboard Box
      'description' => __('This is a right column widget area.', 'thematic'),

      // Do not edit these. It keeps Headers and lists consistent for Thematic
      'before_widget' => thematic_before_widget(),
      'after_widget' => thematic_after_widget(),
      'before_title' => thematic_before_title(),
      'after_title' => thematic_after_title(),
      ));


      // Unregister and sidebars you donÕt need based on its ID.
      // For a full list of Thematic sidebar IDs, look at /thematc/library/extensions/widgets-extensions.php
      //unregister_sidebar('primary-aside');
      unregister_sidebar('secondary-aside');
      unregister_sidebar('index-top');
      unregister_sidebar('index-insert');
      unregister_sidebar('index-bottom');
      unregister_sidebar('single-top');
      unregister_sidebar('single-insert');
      unregister_sidebar('single-bottom');
      unregister_sidebar('page-top');
      unregister_sidebar('page-bottom');
      }
      // When WP initiates, add the above settings
      add_action( 'init', 'pickleplease_sidebars_init',20 );
      ?>
<?php function pickle_sidebar() {
    ?><div id="side_bar">
        <div id="sociable">
            <?php if (function_exists('sociable_html')) {
            echo sociable_html();
            } ?> 
        </div>
        <div id="tag_cloud">
            <h2>Tags</h2> 
            <?php wp_tag_cloud( $args );  
            
            $args = array(
    'smallest'  => 8, 
    'largest'   => 22,
    'unit'      => 'pt', 
    'number'    => 45,  
    'format'    => 'flat',
    'separator' => '\n',
    'orderby'   => 'name', 
    'order'     => 'ASC',
    'link'      => 'view', 
    'taxonomy'  => 'post_tag', 
    'echo'      => true ); ?>         
        </div>
        <div id="join">
        <?php    theme_my_login() ?>    
        </div>
    </div>
<?php
}
add_action('thematic_sidebar','pickle_sidebar');



?>