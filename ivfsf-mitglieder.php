<?php
/*
Plugin Name: ivfsf Mitglieder
Plugin URI: 
Description: Plugin zum Darstellen der ivfsf Mitgliederprofile 
Version: 0.1
Author: Sascha Pogacar
Author URI: 
License: 
License URI: 
*/

function shortcodes_init(){
    add_shortcode( 'ivfsf-profile-list', 'ivfsf_profile_list_handler_function' );
    add_shortcode('ivfsf-mitglieder', 'ivfsf_mitglieder_frontend');
   }

function ivfsf_profile_list_handler_function( $atts, $content, $tag ){ 
    $result = ""; 

    $query = new WP_Query(array(
        'post_type' => 'profile',
        'post_status' => 'publish', 
        'posts_per_page' => -1,
        'order' => 'ASC'
    ));
    
    //var_dump($query);
if($query->have_posts()){	
	$result = '<div class="ivfsf">';
    while ($query->have_posts()) {
        $post = $query->the_post();
        $post_id = get_the_ID();
        $guid = get_the_guid();
        $vita = get_post_meta($post_id, 'vita', true);
        $image = get_the_post_thumbnail_url( get_the_ID(), 'medium' );

        if(strlen($image) <= 1){
            $image = get_attachment_url_by_slug('noimage');
        }

        $result .= '<div class="box">
            <div class="image"><img src="'.$image.'"></div>
            <div class="title">'.get_the_title().'</div>
            <div class="vita">'.$vita.'</div>
            <div><a class="button" href="'.$guid.'">'.'zum Profil'.'</a></div>
            </div>'; 
	    }else {
      $result = '<div class=""> Keine Mitgliederprofile </div>'; 
}
   $result .= '</div>';
    }





    wp_reset_query();
    wp_reset_postdata();
        
    return $result;
    }

function get_attachment_url_by_slug( $slug ) {
    $args = array(
        'post_type' => 'attachment',
        'name' => sanitize_title($slug),
        'posts_per_page' => 1,
        'post_status' => 'inherit',
        );
    $_header = get_posts( $args );
    $header = $_header ? array_pop($_header) : null;
    return $header ? wp_get_attachment_url($header->ID) : '';
    }


function prefix_add_footer_styles() {
    wp_enqueue_style('boostrapcss', plugin_dir_url( __FILE__ ). 'css/bootstrap.min.css', array(), '5.1.3', 'all');
    wp_enqueue_style('customstyle', plugin_dir_url( __FILE__ ). 'css/style.css', array(), '1.0.0', 'all');
};
add_action( 'get_footer', 'prefix_add_footer_styles' );

// First register resources with init 
function ivfsf_mitglieder_frontend_init() {
    $path = "/frontend/build/static";
    if(getenv('WP_ENV')=="development") {
        $path = "/frontend/build/static";
    }
    wp_register_script("ivfsf_mitglieder_frontend_js", plugins_url($path."/js/main.js", __FILE__), array(), "1.0", false);
    wp_register_style("ivfsf_mitglieder_frontend_css", plugins_url($path."/css/main.css", __FILE__), array(), "1.0", "all");
}

// Function for the short code that call React app
function ivfsf_mitglieder_frontend() {
    wp_enqueue_script("ivfsf_mitglieder_frontend_js", '1.0', true);
    wp_enqueue_style("ivfsf_mitglieder_frontend_css");
    return "<div id=\"ivfsf-mitglieder\"></div>";
}

// Write to debug.log

if (!function_exists('write_log')) {

    function write_log($log) {
        if (true === WP_DEBUG) {
            if (is_array($log) || is_object($log)) {
                error_log(print_r($log, true));
            } else {
                error_log($log);
            }
        }
    }

}

// 

add_filter('template_include', 'profile_template');
function profile_template( $template ) {
    $post_types = array('profile');

    if (is_singular($post_types)) {
        $template = plugin_dir_path( __FILE__ )."single-profile.php";
    }

    return $template;
}



// Save Tags Object as json in file when Post type profile is saved


function save_post_callback($post_id)
{
    $post_type = get_post_type($post_id);
    if ($post_type === "profile") {
        $terms = get_terms( array(
            'taxonomy' => 'tags',
            'hide_empty' => false,
        ) );
        $json = json_encode($terms);

        # write_log($json);

        $filename = plugin_dir_path( __FILE__ )."profile_tags.json";
        $myfile = fopen($filename, "w") or die("Unable to open file!");
        fwrite($myfile, $json);
        fclose($myfile);
        }
}

add_action('save_post','save_post_callback');
add_action('init', 'shortcodes_init');
add_action('init', 'ivfsf_mitglieder_frontend_init' );
?>
