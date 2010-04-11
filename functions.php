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

function childtheme_top_utility() {
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

add_action('thematic_before','childtheme_top_utility');

//adding a div around the postheader--------------------------------------------------------------------


      function childtheme_posttitle($posttitle) {

       return '<div class="containing">' . $posttitle . '</div>';
      }

      add_filter('thematic_postheader_posttitle','childtheme_posttitle');
      
// Unhook default Thematic functions----(doesn't work >.<)----------------------------------------------------------------

      //function unhook_thematic_functions() {

          // Don't forget the position number if the original function has one
 
          //remove_action('thematic_postheader','thematic_entry-content');
      //}
      //add_action('init','unhook_thematic_functions');


?>
