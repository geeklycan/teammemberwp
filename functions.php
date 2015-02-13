<?php
/**
 * tmthree functions and definitions
 *
 * @package tmthree
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 640; /* pixels */
}

if ( ! function_exists( 'tmthree_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function tmthree_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on tmthree, use a find and replace
	 * to change 'tmthree' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'tmthree', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'tmthree' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'tmthree_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // tmthree_setup
add_action( 'after_setup_theme', 'tmthree_setup' );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function tmthree_widgets_init() {
	register_sidebar( array(
		'name'          => __( 'Sidebar', 'tmthree' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'tmthree_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
   


function tmthree_scripts() {
	wp_enqueue_style( 'tmthree-style', get_stylesheet_uri() );
	wp_enqueue_style("bootstrapcss", "//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css");

	wp_enqueue_script( 'tmthree-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'tmthree-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	wp_enqueue_script( 'bootstrapjs', get_template_directory_uri() . '//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js', array('jquery'), '20130115', true );
	

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'tmthree_scripts' );

/**
 * Implement the Custom Header feature.
 */
//require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';

/// custom meta box

if(!class_exists("CMB2")) {
    require get_template_directory() . '/libs/cmb2/init.php';
    require get_template_directory() . '/libs/metaboxes.php';

}

/// about widget 
if(!class_exists('Foo_Widget')){
	require get_template_directory() . '/widget/widget.adv.php';
}


/// team member post type hook 

// Register Custom Post Type
function generate_team_post_type() {

	$labels = array(
		'name'                => _x( 'Team Members', 'Post Type General Name', 'tmthree' ),
		'singular_name'       => _x( 'Team Member', 'Post Type Singular Name', 'tmthree' ),
		'menu_name'           => __( 'Team Member', 'tmthree' ),
		'parent_item_colon'   => __( 'Parent Team Member:', 'tmthree' ),
		'all_items'           => __( 'All Items', 'tmthree' ),
		'view_item'           => __( 'View Team Member', 'tmthree' ),
		'add_new_item'        => __( 'Add New Team Member', 'tmthree' ),
		'add_new'             => __( 'Add Team Member', 'tmthree' ),
		'edit_item'           => __( 'Edit Team Member', 'tmthree' ),
		'update_item'         => __( 'Update Team Member', 'tmthree' ),
		'search_items'        => __( 'Search Team Member', 'tmthree' ),
		'not_found'           => __( 'Not found', 'tmthree' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'tmthree' ),
	);
	$args = array(
		'label'               => __( 'team', 'tmthree' ),
		'description'         => __( 'Team Member Description', 'tmthree' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'thumbnail', ),
		'taxonomies'          => array( 'category', 'post_tag' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'team', $args );

}

// Hook into the 'init' action
add_action( 'init', 'generate_team_post_type', 0 );

// admin js
// 
add_action("admin_enqueue_scripts", "admin_scripts");
function admin_scripts($hook)
{
    if ($hook == "post.php")
    wp_enqueue_script("tmthree-mb", get_stylesheet_directory_uri() . "/js/teampage.js", array("jquery"), null, 1);
}

/// function for get cpt 
function get_latest_cpt($post_type, $count = 5)
{
    $params = array(
        "posts_per_page" => $count,
        "post_type" => $post_type,
        "orderby" => "ID",
        "order" => "DESC"
    );
    $movies = get_posts($params);
    return $movies;
}

function get_team_member_select_opt(){
	$result = array();
	$teams = get_latest_cpt("team",-1);

    foreach($teams as $p){
        $result[$p->ID]= $p->post_title;
    }
    return $result;
}

