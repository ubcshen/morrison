<?php

/*-----------------------------------------------------------------------------------*/
/*  Register News post type
/*-----------------------------------------------------------------------------------*/
add_action( 'init', 'news_posttype_init' );
if ( !function_exists( 'news_posttype_init' ) ) :
function news_posttype_init() {
    $project_labels = array(
        'name' => _x('News', 'post type general name'),
        'singular_name' => _x('news', 'post type singular name'),
        'menu_name' => __('News')

    );
    $project_args = array(
        'labels' => $project_labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'has_archive' => false,
        'hierarchical' => false,
        'exclude_from_search' => false,
        'menu_position' => 5,
        'rewrite' => array('slug' => 'news'),
        //'taxonomies' => array('post_tag'),
        //'taxonomies' => array('category', 'post_tag'),
        'supports' => array( 'title', 'excerpt', 'thumbnail', 'editor', 'tags','author')
    );
    register_post_type( 'news', $project_args );

}
endif;


/*-----------------------------------------------------------------------------------*/
/*  project custom taxonomies.
/*-----------------------------------------------------------------------------------*/
add_action( 'init', 'news_taxonomies_init', 0 );
if ( !function_exists( 'news_taxonomies_init' ) ) :
function news_taxonomies_init() {
    // project Category

    $labels = array(
        'name' => _x( 'Categories', 'taxonomy general name'),
        'singular_name' => _x( 'newsfilter', 'taxonomy singular name' ),
        'search_items' =>  __( 'Search Categories' ),
        'all_items' => __( 'All Categories'),
        'parent_item' => __( 'Parent Category'),
        'parent_item_colon' => __( 'Parent Category:'),
        'edit_item' => __( 'Edit Category'),
        'update_item' => __( 'Update Category'),
        'add_new_item' => __( 'Add New Category'),
        'new_item_name' => __( 'New Category Name'),
        'menu_name' => __( 'News Filter'),
    );

    register_taxonomy('news-filter',array('news'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'query_var' => true,
        'rewrite' => array( 'slug' => 'news_categories' ),
    ));

    // project Tags
    $labels = array(
        'name' => _x( 'Tags', 'taxonomy general name'),
        'singular_name' => _x( 'Tag', 'taxonomy singular name'),
        'search_items' =>  __( 'Search Tags'),
        'popular_items' => __( 'Popular Tags'),
        'all_items' => __( 'All Tags'),
        'parent_item' => null,
        'parent_item_colon' => null,
        'edit_item' => __( 'Edit Tag'),
        'update_item' => __( 'Update Tag'),
        'add_new_item' => __( 'Add New Tag'),
        'new_item_name' => __( 'New Tag Name'),
        'separate_items_with_commas' => __( 'Separate tags with commas'),
        'add_or_remove_items' => __( 'Add or remove tags'),
        'choose_from_most_used' => __( 'Choose from the most used tags'),
        'menu_name' => __( 'Tags'),
    );

    register_taxonomy('news-tag','news',array(
        'hierarchical' => false,
        'labels' => $labels,
        'show_ui' => true,
        'update_count_callback' => '_update_post_term_count',
        'query_var' => true,
        'rewrite' => array( 'slug' => 'news-tag' ),
    ));
}
endif;
