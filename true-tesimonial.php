<?php
/**
 * Plugin Name:       True Testimonial
 * Plugin URI:        https://wordpress.org/plugins/true-testimonial/
 * Description:       True Testimonial is a WordPress plugin to display your client review or testimonial in your WordPress website.
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Rezaun Kabir
 * Author URI:        https://rezaun.netlify.app/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       twpt
 * Domain Path:       /languages
 */


 /**
 * twpt enqueue scripts
 */
function twpt_enqueue_scripts()
{
    // wp_enqueue_script('jquery-min', 'https://code.jquery.com/jquery-1.12.0.min.js', array(), '1.0.0', true);
   // wp_enqueue_script('jquery', false, array(), false, false);
    wp_enqueue_script('jquery-min', 'https://code.jquery.com/jquery-1.12.0.min.js', array(), '1.0.0', true);
    wp_enqueue_script('owl-carousel-min', 'https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.js', false, NULL, true);
    wp_enqueue_script('twpt-script', plugins_url('assets/js/twpt.js', __FILE__), false, NULL, true);
}

add_action('wp_enqueue_scripts', 'twpt_enqueue_scripts');
/**
 * twpt enqueue styles
 */
function twpt_enqueue_style()
{
    wp_enqueue_style('owl.carousel', 'https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.carousel.min.css');
    wp_enqueue_style('owl.theme', 'https://cdnjs.cloudflare.com/ajax/libs/owl-carousel/1.3.3/owl.theme.min.css');
    wp_enqueue_style('fontawesome-min', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css');
    wp_enqueue_style('twpt-style', plugins_url('assets/css/twpt.css', __FILE__));
}

add_action('wp_enqueue_scripts', 'twpt_enqueue_style');



/**
 * twpt Custom Post
 */

if (!function_exists('twpt_custom_post_type')) {

    // Register Custom Post Type
    function twpt_custom_post_type()
    {

        $labels = array(
            'name' => _x('testimonial', 'Post Type General Name', 'twpt'),
            'singular_name' => _x('testimonial Type', 'Post Type Singular Name', 'twpt'),
            'menu_name' => __('Testimonials', 'twpt'),
            'name_admin_bar' => __('Post Type', 'twpt'),
            'archives' => __('Item Archives', 'twpt'),
            'attributes' => __('Item Attributes', 'twpt'),
            'parent_item_colon' => __('Parent Item:', 'twpt'),
            'all_items' => __('All Items', 'twpt'),
            'add_new_item' => __('Add New Item', 'twpt'),
            'add_new' => __('Add New', 'twpt'),
            'new_item' => __('New Item', 'twpt'),
            'edit_item' => __('Edit Item', 'twpt'),
            'update_item' => __('Update Item', 'twpt'),
            'view_item' => __('View Item', 'twpt'),
            'view_items' => __('View Items', 'twpt'),
            'search_items' => __('Search Item', 'twpt'),
            'not_found' => __('Not found', 'twpt'),
            'not_found_in_trash' => __('Not found in Trash', 'twpt'),
            'featured_image' => __('Featured Image', 'twpt'),
            'set_featured_image' => __('Set featured image', 'twpt'),
            'remove_featured_image' => __('Remove featured image', 'twpt'),
            'use_featured_image' => __('Use as featured image', 'twpt'),
            'insert_into_item' => __('Insert into item', 'twpt'),
            'uploaded_to_this_item' => __('Uploaded to this item', 'twpt'),
            'items_list' => __('Items list', 'twpt'),
            'items_list_navigation' => __('Items list navigation', 'twpt'),
            'filter_items_list' => __('Filter items list', 'twpt'),
        );
        $args = array(
            'label' => __('testimonial Type', 'twpt'),
            'description' => __('testimonial Description', 'twpt'),
            'labels' => $labels,
            'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
            'taxonomies' => array('category', 'post_tag'),
            'hierarchical' => false,
            'public' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => true,
            'can_export' => true,
            'has_archive' => true,
            'exclude_from_search' => false,
            'publicly_queryable' => true,
            'capability_type' => 'page',
        );
        register_post_type('testimonial', $args);

    }

    add_action('init', 'twpt_custom_post_type', 0);

}

function twpt_testimonial_loop(){ ?>
    <div id="testimonial-slider" class="owl-carousel">
    <?php
    // WP_Query arguments
    $args = array(
        'post_type' => array('testimonial'),
        'post_status' => array('publish'),
    );

    // The Query
    $twpt_query = new WP_Query($args);

    // The Loop
    if ($twpt_query->have_posts()) {
        while ($twpt_query->have_posts()) {
            $twpt_query->the_post();
            ?>

            <div class="testimonial">
            <div class="pic">
                <img src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full') ?>" alt="<?php the_title(); ?>">
            </div>
            <h3 class="title"><?php the_title(); ?></h3>
            <p class="description"><?php the_excerpt(); ?></p>
            <div class="testimonial-content">
                <div class="testimonial-profile">
                    <h3 class="name"><?php echo get_post_meta(get_the_ID(), 'testi_name', true); ?></h3>
                    <span class="post"><?php echo get_post_meta(get_the_ID(), 'testi_desination', true); ?></span>
                </div>
                <ul class="rating">
                    <?php $twpt_client_review = get_post_meta(get_the_ID(), 'testi-rating', true);
                    if ($twpt_client_review == 1) {
                        echo " <i class='fa-solid fa-star'></i>";
                    } elseif ($twpt_client_review == 2) {
                        echo " 
                                <i class='fa-solid fa-star'></i>
                                <i class='fa-solid fa-star'></i>
                                ";
                    } elseif ($twpt_client_review == 3) {
                        echo " 
                                <i class='fa-solid fa-star'></i>
                                <i class='fa-solidfa-star'></i>
                                <i class='fa-solid fa-star'></i>
                                ";
                    } elseif ($twpt_client_review == 4) {
                        echo " 
                                <i class='fa-solid fa-star'></i>
                                <i class='fa-solid fa-star'></i>
                                <i class='fa-solid fa-star'></i>
                                <i class='fa-solid fa-star'></i>
                                ";
                    } elseif ($twpt_client_review == 1.5) {
                        echo " 
                               <i class='fa-solid fa-star'></i>
                                <li class='fa fa-star-half-empty'></li>
                                ";
                    } elseif ($twpt_client_review == 2.5) {
                        echo " 
                                <i class='fa-solid fa-star'></i>
                               <i class='fa-solid fa-star'></i>
                                <li class='fa fa-star-half-empty'></li>
                                ";
                    } elseif ($twpt_client_review == 3.5) {
                        echo " 
                                <i class='fa-solid fa-star'></i>
                                <i class='fa-solid fa-star'></i>
                                <i class='fa-solid fa-star'></i>
                                <li class='fa fa-star-half-empty'></li>
                                ";
                    } elseif ($twpt_client_review == 4.5) {
                        echo " 
                                <i class='fa-solid fa-star'></i>
                                <i class='fa-solid fa-star'></i>
                                <i class='fa-solid fa-star'></i>
                                <i class='fa-solid fa-star'></i>
                               <i class='fa-solid fa-star-half-stroke'></i>
                                ";
                    } else {
                        echo "Rating Not Found";
                    }
                    ?>
                </ul>
            </div>
            <?php
        }
    } else {
        // no posts found
    }

    // Restore original Post Data
    wp_reset_postdata();
} ?>
    </div>
<?php
/**
* twpt shortcode
 **/


    function twpt_custom_shortcode()
    {
        add_shortcode('TRUEWPTESTIMONIAL', 'twpt_testimonial_loop');
    }
    add_action('init', 'twpt_custom_shortcode');


/**
 *Get all php file.
 **/
//foreach ( glob( plugin_dir_path( __FILE__ )."inc/*.php" ) as $php_file )
//    include_once $php_file;

/**
* bwpt redirect to plugin settings page.
 **/
register_activation_hook(__FILE__, 'twpt_plugin_activate');
add_action('admin_init', 'twpt_plugin_redirect');

function bwpt_plugin_activate() {
    add_option('twpt_plugin_do_activation_redirect', true);
}

function twpt_plugin_redirect() {
    if (get_option('twpt_plugin_do_activation_redirect', false)) {
        delete_option('twpt_plugin_do_activation_redirect');
        if(!isset($_GET['activate-multi']))
        {
            wp_redirect("edit.php?post_type=testimonial&page=twpt-settings-page");
        }
    }
}
?>