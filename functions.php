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

<div class="login">
    <div id="login">
        <span class="loginout"><?php wp_loginout(); ?></span>
        <span class="register"><?php wp_register('| ', ''); ?></span>
    </div>
</div>

<!Ð the utility html ends here Ð>
<?php

} // end of our new function childtheme_top_utility


// Now we add our new function to our Thematic Action Hook

add_action('thematic_before','childtheme_top_utility');


?>