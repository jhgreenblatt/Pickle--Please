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


//--------------------------------------------adding the top utility bar as an action hook
function pickle_top_utility() {


//the utility html starts here
    ?>
    <div class="top_container">
        <div class="top_container_content">
            <div id="login">
                <span class="loginout"><?php wp_loginout(); ?></span>
                <span class="register"><?php wp_register('| ', ''); ?></span>
            </div>
            <div id="greeting">
                <p>Please tell us what pickle pleases you. <span style="color:red;">Join Here</span></p>
            </div>
            <div class="search_form_container">
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>
    <?php
//the utility html ends here


} // end of our new function childtheme_top_utility
// Here we add our new function to our Thematic Action Hook
add_action('thematic_before','pickle_top_utility'); 


//--------------------------------------------creating a thumb loop (seeMirnaOSDF09)
//--------------------------------------------combined with angel loop
//--------------------------------------------two sepearte loops on home page. both inside the pickle_index_loop function 


//First we will add the thumbnail feature
    add_theme_support('post-thumbnails');

// To create our own loop we have to get rid of thematic index loop first.
function remove_index_loop() {
     remove_action('thematic_indexloop', 'thematic_index_loop');
}
add_action('init', 'remove_index_loop');
 
    //Code below adapted from Angel Ng
    //www.thisisangelng.com/blog.
    //http://github.com/thisisangelng/wordpressv1/blob/master/angel_thematic_v1/functions.php
    //Thanks Angel! 
    
    
    //Below we are defining our loops within a function that replaces the index loop.
    // Start by defining the function 
function pickle_indexloop(){


//Use php to create a new loop. 
    if (is_home() & !is_paged()) { 
    
    //NOTE: this is where angel created divs to hold her loop content and also category header,
    //because she is adding her function as an action hook below_container
    //but in my case, i'm filtering the thematic_indexloop, so no html is necessary here for me.
    


//Create a query to use with a loop. Big thanks to Allan Cole - www.allancole.com - for sharing his code!
// First, grab any global settings you may need for your loop.
global $paged, $more, $post;       //the post variable is for calling meta data created with custom write panels
$more = 0;

// Second, create a new temporary Variable for your query.
// $feature_pickle_query is the Variable used in this example query.
// If you run any new Queries, change the variable to something else more specific ie: $feature_wp_query.
$temp = $feature_pickle_query;

// Next, set your new Variable to NULL so it's empty.
$feature_pickle_query = null;

// Then, turn your variable int the WP_Query() function.
$feature_pickle_query = new WP_Query();

// Set you're query parameters. Need more Parameters?: http://codex.wordpress.org/Template_Tags/query_posts
$feature_pickle_query->query(array(

// This will create a loop that shows 1 post from the featured-pickle.
    'category_name' => 'featured-pickle',
    'showposts' => '1',
    )); 

// Add Previous and Next post links here. (http://codex.wordpress.org/Template_Tags/previous_post_link)
// Or just use the thematic action.
thematic_navigation_above();

// While posts exists in the Query, display them.
while ($feature_pickle_query->have_posts()) : $feature_pickle_query->the_post();

        
     // Start the looped content here. ?>  
        <div id="post-<?php the_ID(); ?>" class="<?php thematic_post_class() ?>">
                
            <div id="post-content">       
                <?php the_post_thumbnail();  // we just called for the thumbnail ?>
                <div class="entry-content">
                     <!-- Display the Title as a link to the Post's permalink. -->
                    <h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                    <?php if(get_post_meta($post->ID, 'pickle-maker')){ ?><p class="maker_name"><?php echo get_post_meta($post->ID, 'pickle-maker', $single = true); ?></p><?php } ?>
                    <?php echo polldaddy_get_rating_html(); ?>
                    <?php the_content('Read more...'); ?>
                </div>
            </div>    
        </div><?php //#featured
        
endwhile; //This is how to end a loop
}

// Add Previous and Next post links here. (http://codex.wordpress.org/Template_Tags/previous_post_link)
// Or us the thematic action.
thematic_navigation_below(); 

// End the Query and set it back to temporary so that it doesn't interfere with other queries.
$feature_pickle_query = null; $feature_pickle_query = $temp;

// Thats it! End of the feature pickle query.



//------------------------Now we want to create another loop that shows 6 posts as a gallery below the feature pickle post.
//------------------------Remember we are still within the same funtion, which is ultimately replacing the index loop.
    
//Use php to create a new loop. 
     if (is_home() & !is_paged()) { 

// Second, create a new temporary Variable for your query.
// $front_page_gallery is the Variable used in this example query.
// If you run any new Queries, change the variable to something else more specific ie: $feature_wp_query.
$temp = $front_page_gallery;

// Next, set your new Variable to NULL so it's empty.
$front_page_gallery = null;

// Then, turn your variable int the WP_Query() function.
$front_page_gallery = new WP_Query();

// Set you're query parameters. Need more Parameters?: http://codex.wordpress.org/Template_Tags/query_posts
$front_page_gallery->query(array(

// This will create a loop that shows 6 posts from the front-page-gallery category.
    'category_name' => 'front-page-gallery',
    'showposts' => '6',
    ));

// Add Previous and Next post links here. (http://codex.wordpress.org/Template_Tags/previous_post_link)
// Or just use the thematic action.
thematic_navigation_above(); 


// While posts exists in the Query, display them.
while ($front_page_gallery->have_posts()) : $front_page_gallery->the_post();  

            // Start the looped content here. ?>
            <div class="gallery_thumb_container">
                <div id="post-<?php the_ID(); ?>" class="<?php thematic_post_class();?>">
                    <?php the_post_thumbnail();  // we just called for the thumbnail ?>
                    <div class="gallery-content">
                        <!-- Display the Title as a link to the Post's permalink. -->
                        <h2 class="entry-title"><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                        <?php if(get_post_meta($post->ID, 'pickle-maker')){ ?><p class="maker_name"><?php echo get_post_meta($post->ID, 'pickle-maker', $single = true); ?></p><?php } ?>
                        <?php echo polldaddy_get_rating_html(); ?>
                    </div>
                </div>
            </div>
<?php
       
endwhile; //This is how to end a loop
}

// Add Previous and Next post links here. (http://codex.wordpress.org/Template_Tags/previous_post_link)
// Or us the thematic action.
thematic_navigation_below();


// End the Query and set it back to temporary so that it doesn't interfere with other queries.
$front_page_gallery = null; $front_page_gallery = $temp; ?>

<?php // Thats it! End of front page gallery.



    
} // And importantly we must include this bracket to close out our feature_pickle function

//Add the function to the Action Hook.
add_action ('thematic_indexloop','pickle_indexloop');


//Creating the content for the Single Post
function remove_single_post() {
  remove_action('thematic_singlepost', 'thematic_single_post');
}
add_action('init', 'remove_single_post');

function gallery_single_post() { 
  global $post;
        ?><div id="post-<?php the_ID(); ?>" class="<?php thematic_post_class();?>"> 
            <ul>
            <?php   if(get_post_meta($post->ID, 'pickle-name')){ ?><li class="maker_name"><?php echo get_post_meta($post->ID, 'pickle-name', $single = true); ?></li><?php }
                    if(get_post_meta($post->ID, 'pickle-maker')){ ?><li class="maker_name"><?php echo get_post_meta($post->ID, 'pickle-maker', $single = true); ?></li><?php }
                    if(get_post_meta($post->ID, 'store-purchased')){ ?><li class="maker_name"><?php echo get_post_meta($post->ID, 'store-purchased', $single = true); ?></li><?php }
                    if(get_post_meta($post->ID, 'store-location')){ ?><li class="maker_name"><?php echo get_post_meta($post->ID, 'store-location', $single = true); ?></li><?php }
                    if(get_post_meta($post->ID, 'price')){ ?><li class="maker_name"><?php echo get_post_meta($post->ID, 'price', $single = true); ?></li><?php }
                    if(get_post_meta($post->ID, 'vegetable-type')){ ?><li class="maker_name"><?php echo get_post_meta($post->ID, 'vegetable-type', $single = true); ?></li><?php }
                    if(get_post_meta($post->ID, 'flavor')){ ?><li class="maker_name"><?php echo get_post_meta($post->ID, 'flavor', $single = true); ?></li><?php }
                    if(get_post_meta($post->ID, 'texture')){ ?><li class="maker_name"><?php echo get_post_meta($post->ID, 'texture', $single = true); ?></li><?php }
        ?> </ul>
        </div>
<?php
}
add_action('thematic_singlepost', 'gallery_single_post');

// End of SINGLE   

    
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

/*
Plugin Name: Custom Write Panel
Plugin URI: http://wefunction.com/2008/10/tutorial-create-custom-write-panels-in-wordpress
Description: Allows custom fields to be added to the WordPress Post Page
Version: 1.0
Author: Spencer
Author URI: http://wefunction.com
/* ----------------------------------------------*/

$new_meta_boxes =
  array(
    "pickle-name" => array(  
        "name" => "pickle-name",  
        "title" => "Pickle Name",  
        "description" => "Enter the name of the pickle you are reviewing. Usually found on the label."),  
    "pickle-maker" => array(  
        "name" => "pickle-maker",  
        "title" => "Pickle Maker",  
        "description" => "Enter the name of the company responsible for your brined goodness."),
    "store-purchased" => array(  
        "name" => "store-purchased",  
        "title" => "Store Purchased",  
        "description" => "Name the store where you bought this pickle. The more specific the better."),
    "store-location" => array(  
        "name" => "store-location",  
        "title" => "Store Location",  
        "description" => "And where is this store located?"),
    "price" => array(  
        "name" => "price",  
        "title" => "Price",  
        "description" => "How much did the pickle cost? Please enter in logical currency format: e.g. $9.00."),
    "vegetable-type" => array(  
        "name" => "vegetable-type",  
        "title" => "Vegetable Type",  
        "description" => "What kind of vegetable is your pickle? Don't get bogged down in technicalities here. We also cherish pickled fruits. "),
    "flavor" => array(  
        "name" => "flavor",  
        "title" => "Flavor Tags",  
        "description" => "One or two-word adjectives, please. Seperate them with commas if you have mulitple flavors to report. Most good pickles are complex!"),
    "texture" => array(  
        "name" => "texture",  
        "title" => "Texture Tags",  
        "description" => "Same as above, except describing the pickle's texture."),
);

function new_meta_boxes() {
  global $post, $new_meta_boxes;
  
  foreach($new_meta_boxes as $meta_box) {
    $meta_box_value = get_post_meta($post->ID, $meta_box['name'], true);
    
    if($meta_box_value == "")
      $meta_box_value = $meta_box['std'];
    
    echo'<input type="hidden" name="'.$meta_box['name'].'_noncename" id="'.$meta_box['name'].'_noncename" value="'.wp_create_nonce( plugin_basename(__FILE__) ).'" />';
    
    echo'<label style="font-weight: bold; display: block; padding: 5px 0 2px 2px" for="'.$meta_box['name'].'">'.$meta_box['title'].'</label>';
    
    echo'<input type="text" name="'.$meta_box['name'].'" value="'.$meta_box_value.'" size="55" /><br />';
    
    echo'<p><label for="'.$meta_box['name'].'">'.$meta_box['description'].'</label></p>';
  }
}

function create_meta_box() {
  global $theme_name;
  if ( function_exists('add_meta_box') ) {
    add_meta_box( 'new-meta-boxes', 'Pickle Please Post Settings', 'new_meta_boxes', 'post', 'normal', 'high' );
  }
}

function save_postdata( $post_id ) {
  global $post, $new_meta_boxes;
  
  foreach($new_meta_boxes as $meta_box) {
  // Verify
  if ( !wp_verify_nonce( $_POST[$meta_box['name'].'_noncename'], plugin_basename(__FILE__) )) {
    return $post_id;
  }
  
  if ( 'page' == $_POST['post_type'] ) {
  if ( !current_user_can( 'edit_page', $post_id ))
    return $post_id;
  } else {
  if ( !current_user_can( 'edit_post', $post_id ))
    return $post_id;
  }
  
  $data = $_POST[$meta_box['name']];
  
  if(get_post_meta($post_id, $meta_box['name']) == "")
    add_post_meta($post_id, $meta_box['name'], $data, true);
  elseif($data != get_post_meta($post_id, $meta_box['name'], true))
    update_post_meta($post_id, $meta_box['name'], $data);
  elseif($data == "")
    delete_post_meta($post_id, $meta_box['name'], get_post_meta($post_id, $meta_box['name'], true));
  }
}

add_action('admin_menu', 'create_meta_box');
add_action('save_post', 'save_postdata');
?>