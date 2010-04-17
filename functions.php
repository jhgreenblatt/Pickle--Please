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


//adding the top utility bar as an action hook-----------------------------------------------------------

function pickle_top_utility() {
?>

<!Ð the utility html starts here Ð>

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
<!Ð the utility html ends here Ð>
<?php

} // end of our new function childtheme_top_utility

// Now we add our new function to our Thematic Action Hook

add_action('thematic_before','pickle_top_utility');

//adding a div around the postheader--------------------------------------------------------------------


      //function childtheme_posttitle($posttitle) {

       //return '<div class="containing">' . $posttitle . '</div>';
      //}

      //add_filter('thematic_postheader_posttitle','childtheme_posttitle');

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
       while ( have_posts() ) : the_post()  // Start the loop:
    // This is just what we decide to show in each post ?>
    <div id="post-<?php the_ID() ?>" class="<?php thematic_post_class() ?>">
        <?php the_post_thumbnail();  // we just called for the thumbnail ?>
        <div class="entry-content">
             <!-- Display the Title as a link to the Post's permalink. -->
            <h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
            <?php the_meta(); ?>
            <?php the_content('Read more...'); ?>         
        </div>
    </div><!-- .post -->
    <?php
    endwhile; // loop done, go back up 
}
// And in the end activate the new loop.
add_action('thematic_indexloop', 'thumb_index_loop');




?>