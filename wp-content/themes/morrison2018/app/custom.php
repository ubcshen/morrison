<?php

/**
 * Custom functions
 */

// Remove Open Sans that WP adds from frontend
if (!function_exists('remove_wp_open_sans')) :
function remove_wp_open_sans() {
wp_deregister_style( 'open-sans' );
wp_register_style( 'open-sans', false );
}
add_action('wp_enqueue_scripts', 'remove_wp_open_sans');
endif;

add_filter( 'rest_endpoints', function( $endpoints ){
    if ( isset( $endpoints['/wp/v2/users'] ) ) {
        unset( $endpoints['/wp/v2/users'] );
    }
    if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
        unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
    }
    return $endpoints;
});

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

add_action( 'init', function() {
  // Remove the REST API endpoint.
  remove_action('rest_api_init', 'wp_oembed_register_route');
  // Turn off oEmbed auto discovery.
  // Don't filter oEmbed results.
  remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
  // Remove oEmbed discovery links.
  remove_action('wp_head', 'wp_oembed_add_discovery_links');
  // Remove oEmbed-specific JavaScript from the front-end and back-end.
  remove_action('wp_head', 'wp_oembed_add_host_js');
}, PHP_INT_MAX - 1 );  // remove the wp-embed.min.js file from the frontend completely

function multiexplode ($delimiters,$string) {

    $ready = str_replace($delimiters, $delimiters[0], $string);
    $launch = explode($delimiters[0], $ready);
    return  $launch;
}

//remove wordpress dns-prefetch
function remove_dns_prefetch( $hints, $relation_type ) {
    if ( 'dns-prefetch' === $relation_type ) {
        return array_diff( wp_dependencies_unique_hosts(), $hints );
    }

    return $hints;
}

add_filter( 'wp_resource_hints', 'remove_dns_prefetch', 10, 2 );

function cc_mime_types($mimes) {
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

if( !defined('MG_PAGE_PATH') ){
    define('MG_PAGE_PATH', get_template_directory() .'/' );
}
require_once MG_PAGE_PATH . 'mobiledetect/Mobile_Detect.php';

if( function_exists('acf_add_options_page') ) {
  // add parent
  $parent = acf_add_options_page(array(
    'page_title'  => 'MG Settings',
    'menu_title'  => 'MG Settings',
    'redirect'    => false
  ));

  acf_add_options_sub_page(array(
    'page_title'  => 'Footer CopyRight',
    'menu_title'  => 'Footer CopyRight',
    'menu_slug'   => 'footer-copyright',
    'parent_slug'   => $parent['menu_slug'],
    'capability'  => 'activate_plugins',
    'redirect'    => false
  ));

  acf_add_options_sub_page(array(
    'page_title'  => 'Header Setting',
    'menu_title'  => 'Header Setting',
    'menu_slug'   => 'header_setting',
    'parent_slug'   => $parent['menu_slug'],
    'capability'  => 'activate_plugins',
    'redirect'    => false
  ));

  acf_add_options_sub_page(array(
    'page_title'  => 'Sidebar Setting',
    'menu_title'  => 'Sidebar Setting',
    'menu_slug'   => 'sidebar_setting',
    'parent_slug'   => $parent['menu_slug'],
    'capability'  => 'activate_plugins',
    'redirect'    => false
  ));
}

if ( function_exists( 'add_theme_support' ) ) {
  add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 150, 150 ); // default Post Thumbnail dimensions
}

if ( function_exists( 'add_image_size' ) ) {
    /*add_image_size('news-thumbnail', 390, 240,  array( 'center', 'top' ));
    add_image_size('member-thumbnail', 780, 780,  array( 'center', 'top' ));
    add_image_size('member-lightbox-thumbnail', 600, 340,  array( 'center', 'top' ));*/
}

//get primary category name in Wordpress
if ( ! function_exists( 'get_primary_taxonomy_id' ) ) {
  function get_primary_taxonomy_id( $post_id, $taxonomy ) {
      $prm_term = '';
      if (class_exists('WPSEO_Primary_Term')) {
          $wpseo_primary_term = new WPSEO_Primary_Term( $taxonomy, $post_id );
          $prm_term = $wpseo_primary_term->get_primary_term();
      }
      if ( !is_object($wpseo_primary_term) && empty( $prm_term ) ) {
          $term = wp_get_post_terms( $post_id, $taxonomy );
          if (isset( $term ) && !empty( $term ) ) {
              return wp_get_post_terms( $post_id, $taxonomy )[0]->term_id;
          } else {
              return '';
          }
      }
      return $wpseo_primary_term->get_primary_term();
  }
}

function load_Img($className, $fieldName) { ?>

    <!--[if lt IE 9]>
    <script>
        $(document).ready(function() {
            $("<?php print $className ?>").backstretch("<?php $img=wp_get_attachment_image_src(get_sub_field($fieldName), "full"); echo $img[0];  ?>");
        });
    </script>
    <![endif]-->

  <style scoped>
  <?php echo $className; ?> {
    background-image: url(<?php $img=wp_get_attachment_image_src(get_sub_field($fieldName), "full"); echo $img[0];  ?>);
        background-repeat:no-repeat;
        background-position: center center;
        background-size: cover;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
  }
  @media only screen and (max-width: 1024px) {
    <?php echo $className; ?> {
      background-image: url(<?php $img=wp_get_attachment_image_src(get_sub_field($fieldName), "large"); echo $img[0];  ?>);
    }
  }
  </style>
  <?php
    $detect = new Mobile_Detect;
    $css_code = "<style scoped>";
    if ( $detect->isMobile() )
    {
      $css_code .= $className . ' {background-attachment: scroll;}';
    }
    $css_code .= "</style>";
    echo $css_code;
}

function load_Tax_Img($className, $fieldName, $hasTerm) { ?>

    <!--[if lt IE 9]>
    <script>
        $(document).ready(function() {
            $("<?php print $className ?>").backstretch("<?php $img=wp_get_attachment_image_src(get_field($fieldName, $hasTerm), "full"); echo $img[0];  ?>");
        });
    </script>
    <![endif]-->

  <style scoped>
  <?php echo $className; ?> {
    background-image: url(<?php $img=wp_get_attachment_image_src(get_field($fieldName, $hasTerm), "full"); echo $img[0];  ?>);
        background-repeat:no-repeat;
        background-position: center center;
        background-size: cover;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
  }
  @media only screen and (max-width: 1024px) {
    <?php echo $className; ?> {
      background-image: url(<?php $img=wp_get_attachment_image_src(get_field($fieldName, $hasTerm), "large"); echo $img[0];  ?>);
    }
  }
  </style>
  <?php
    $detect = new Mobile_Detect;
    $css_code = "<style scoped>";
    if ( $detect->isMobile() )
    {
      $css_code .= $className . ' {background-attachment: scroll;}';
    }
    $css_code .= "</style>";
    echo $css_code;
}

function load_Feature_Img($className, $fieldName) { ?>

  <style scoped>
  <?php echo $className; ?> {
    background-image: url(<?php $img=wp_get_attachment_image_src( get_post_thumbnail_id( $fieldName ), "full" ); echo $img[0];  ?>);
        background-repeat:no-repeat;
        background-position: center center;
        background-size: cover;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
  }
  @media only screen and (max-width: 1024px) {
    <?php echo $className; ?> {
      background-image: url(<?php $img=wp_get_attachment_image_src( get_post_thumbnail_id( $fieldName ),  "large"); echo $img[0];  ?>);
    }
  }
  </style>
  <?php
    $detect = new Mobile_Detect;
    $css_code = "<style scoped>";
    if ( $detect->isMobile() )
    {
      $css_code .= $className . ' {background-attachment: scroll;}';
    }
    $css_code .= "</style>";
    echo $css_code;
}

function load_Feature_Img_Item($className, $fieldName, $size) { ?>

  <style scoped>
  <?php echo $className; ?> {
    background-image: url(<?php $img=wp_get_attachment_image_src( get_post_thumbnail_id( $fieldName ), $size ); echo $img[0];  ?>);
        background-repeat:no-repeat;
        background-position: center center;
        background-size: cover;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
  }
  </style>
  <?php
    $detect = new Mobile_Detect;
    $css_code = "<style scoped>";
    if ( $detect->isMobile() )
    {
      $css_code .= $className . ' {background-attachment: scroll;}';
    }
    $css_code .= "</style>";
    echo $css_code;
}

function load_Img_no_mobile_not_sub($className, $fieldName) { ?>
  <style>
  <?php echo $className; ?> {
    background-image: url(<?php $img=wp_get_attachment_image_src(get_field($fieldName), "full"); echo $img[0];  ?>);
  }
  @media only screen and (max-width: 1024px) {
    <?php echo $className; ?> {
      background-image: url(<?php $img=wp_get_attachment_image_src(get_field($fieldName), "large"); echo $img[0];  ?>);
    }
  }
  @media only screen and (max-width: 640px) {
    <?php echo $className; ?> {
      background: none;
    }
  }
  </style>
  <?php
}

// GET SECTION BUILDER
function build_sections()
{
    $question_count = 1;
    $detect = new Mobile_Detect;

    if( get_field('section_builder') )
    {
        while( has_sub_field("section_builder") )
        {
            if( get_row_layout() == "section_html" ) // layout: Section Html
            { ?>
                <section class="container section-html">
                    <div class="inner-container">
                      <?php echo get_sub_field("html_field"); ?>
                    </div>
                </section>
            <?php }
            elseif( get_row_layout() == "section_2_cols_full_width" ) // layout: Section image with text
            {
                $imageAlignment = get_sub_field("section_2_cols_full_width_image_alignment");
                $textAlignement = ($imageAlignment == 'Left') ? "Right" : "Left";
                $image = get_sub_field('section_2_cols_full_width_image');
                $noImage = get_sub_field('if_no_image_but_still_need_space');
            ?>
                <section class="section-2-cols-full-width <?php echo get_sub_field("section_2_cols_full_width_class"); ?>" id="<?php echo get_sub_field("section_2_cols_full_width_id"); ?>">
                  <div class="table-cell">
                    <?php if($image) { ?>
                      <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" class="img-responsive half f<?php echo $imageAlignment; ?> imgHalf" />
                    <?php } ?>
                    <?php if(!$image&&$noImage) { ?>
                    <div class="half f<?php echo $imageAlignment; ?>">&nbsp;</div>
                    <?php } ?>
                    <div class="content half f<?php echo $textAlignement; ?> valign-center">
                      <div class="inner-container">
                        <?php echo get_sub_field("section_2_cols_full_width_content"); ?>
                      </div>
                    </div>
                  </div>
                </section>
            <?php }
            elseif( get_row_layout() == "section_subscribe" ) // layout: Section Subscribe
            {
                load_Img(".section-subscribe", "section_subscribe_background_image");
                $image = get_sub_field('section_subscribe_book_image');
                $enableDownload = get_sub_field('enable_download');
            ?>
                <section class="container section-subscribe" id="section-subscribe">
                    <div class="sub_container">
                        <h2><?php echo get_sub_field("section_subscribe_title"); ?></h2>
                        <div class="section-content"><?php echo get_sub_field("section_subscribe_content"); ?></div>
                        <?php if($enableDownload) { ?>
                            <a href="<?php echo get_sub_field("download_file")['url']; ?>" class="btn white-btn" target="_blank"><?php echo get_sub_field("download_btn"); ?></a>
                        <?php } ?>
                    </div>
                    <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" class="img-responsive sub-img" />
                </section>
            <?php }
            elseif( get_row_layout() == "section_banner" ) // layout: Section Banner
            {
              $image = get_sub_field('banner_background_image');
            ?>
                <section class="section-banner normalHeight">
                  <img src="<?php echo $image['url']; ?>" alt="banner" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" class="img-responsive" />
                </section>
            <?php }
            elseif( get_row_layout() == "section_careers" ) // layout: Section Careers
            { ?>
                <section class="section-careers container">
                  <div class="inner-container">
                    <div class="download-container">
                      <div class="career-job-list">
                        <?php
                          while(has_sub_field('section_career')):
                        ?>
                        <p><a href="<?php echo get_sub_field("career_file"); ?>" target="_blank"><?php echo get_sub_field("career"); ?></a></p>
                        <?php endwhile; ?>
                      </div>
                    </div>
                  </div>
                </section>
            <?php }
            elseif( get_row_layout() == "section_cols" ) // layout: Section Cols
            {
                $colNo = get_sub_field("col_number"); // only 2 right now
                ?>
                <section class="container section-cols section-cols-<?php echo $colNo; ?>">
                    <div class="inner-container">
                        <h2><?php echo get_sub_field("section_cols_headline"); ?></h2>
                        <div class="section-content"><?php echo get_sub_field("section_cols_content"); ?></div>
                    </div>
                    <div class="cols">
                        <?php
                          while(has_sub_field('cols')):
                            $image = get_sub_field('col_image');
                            $newTab = get_sub_field('open_new_tab');
                            $colTitleLink = get_sub_field('col_title_link');
                            $colHeadlineLink = get_sub_field('col_headline_link');
                        ?>
                        <div class="col">
                            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" class="img-responsive col--<?php echo $colNo; ?>" />
                            <div class="item-content">
                                <h4><a href="<?php echo $colTitleLink; ?>" class="cta-brown" target="<?php if($newTab) { echo '_blank'; } else { echo '_self'; } ?>"><?php echo get_sub_field("col_title"); ?></a></h4>
                                <a href="<?php echo $colHeadlineLink; ?>" class="cta-brown" target="<?php if($newTab) { echo '_blank'; } else { echo '_self'; } ?>"><?php echo get_sub_field("col_headline"); ?></a>
                                <p><?php echo get_sub_field("col_content"); ?></p>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </section>
            <?php }
            elseif( get_row_layout() == "section_testimonials" ) // layout: Section Testimonials
            { ?>
                <section class="container section-testimonials">
                    <div class="inner-container"><?php echo get_sub_field("section_testimonials_headline"); ?></div>
                    <div class="section-content bxslider">
                        <?php
                          while(has_sub_field('testimonials')):
                            $image = get_sub_field('testimonial_image');
                            $link = get_sub_field('testimonial_company_link');
                        ?>
                        <div class="testimonial">
                            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" class="img-responsive testimonial-image" />
                            <div class="item-content hasBg">
                                <p class="oib-member <?php if(!get_sub_field("oib_member_info")) { echo 'tran'; } ?>"><?php if(get_sub_field("oib_member_info")) { ?><?php echo get_sub_field("oib_member_info"); ?><?php } else { echo '&nbsp;'; } ?></p>
                                <div class="hasBg-content hasBg-content<?php echo $i; ?>">
                                    <div class="hasBg-content-padding">
                                        <p class="testimonial-content"><?php echo get_sub_field("testimonial"); ?></p>
                                        <p class="testimonial-author"><?php echo get_sub_field("testimonial_author_info"); ?></p>
                                        <p class="testimonial-author">
                                            <?php
                                                echo get_sub_field("testimonial_company");
                                                if($link) {
                                                    echo "<span> | </span><a href='http://" . get_sub_field("testimonial_company_link") . "' target='_blank'>" . get_sub_field("testimonial_company_link") . "</a>";
                                                }
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>
                </section>
            <?php }
            elseif( get_row_layout() == "section_tabs" ) // layout: section_tabs
            { ?>
                <section class="container section-tabs">
                  <h1><?php echo get_sub_field("tabs_title"); ?></h1>
                  <div class="section-tabs-left fLeft">
                      <?php $i = 0;
                          while(has_sub_field('tabs')):
                              $tab = strtolower(get_sub_field("tab"));
                              $tab = preg_replace('/\s+/', '_', $tab);
                      ?>
                          <h3 class='filter-list filter-list-item <?php if($i==0) echo "tab-active"; ?>' data-value='#<?php echo $tab; ?>'><?php echo get_sub_field("tab"); ?></h3>
                      <?php $i++; endwhile; ?>
                  </div>
                  <div class="grid section-content fLeft">
                      <?php
                        while(has_sub_field('tabs')):
                          $tab = strtolower(get_sub_field("tab"));
                          $tab = preg_replace('/\s+/', '_', $tab);
                      ?>
                      <div class="<?php echo $tab; ?> element-item" id="<?php echo $tab; ?>">
                          <div class="inner-container"><?php echo get_sub_field("tab_content"); ?></div>
                      </div>
                      <?php endwhile; ?>
                  </div>
                </section>
            <?php }
            elseif( get_row_layout() == "section_news_list" ) // layout: Section News List
            { ?>
                <section class="container section-news-list">
                  <div class="news-div">
                    <div class="news-wrap">
                      <?php
                        while(has_sub_field('section_news')):
                          $image = get_sub_field('news_image');
                          $hasLink = get_sub_field("news_download"); 
                      ?>
                      <div class="news-post">
                        <?php if($hasLink) { ?><a href="<?php echo $hasLink; ?>" target="_blank"><?php } ?><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="<?php echo $image['width']; ?>" height="<?php echo $image['height']; ?>" class="img-responsive" /><?php if($hasLink) { ?></a><?php } ?>
                        <?php if(!is_page("news")) { ?><p class="projects-district"><strong><?php echo get_sub_field("news_title"); ?></strong></p><?php } ?>
                        <div class="news-post-wrap">
                          <?php if(is_page("news")) { ?>
                          <p><strong><?php echo get_sub_field("news_title"); ?></strong></p>
                          <p><?php echo get_sub_field("news_time"); ?></p>
                          <?php } ?>
                          <?php echo get_sub_field("news_info"); ?>
                          <?php if($hasLink) { ?><p style="text-align:right"><a href="<?php echo $hasLink; ?>" target="_blank">&gt;&gt; Read More</a></p><?php } ?>
                        </div>
                      </div>
                    <?php endwhile; ?>
                    </div>
                  </div>
                </section>
            <?php }
            elseif( get_row_layout() == "section_two_image_cols" ) // layout: Section Two Image Cols
            { ?>
                <section class="section-two-image-cols">
                  <div class="div-table">
                    <div class="div-table-row">
                      <?php $i = 0;
                        while(has_sub_field('section_two_image_col')):
                          //$image = get_sub_field('section_two_image_col_image');
                          load_Img(".ca_property_bg_". $i, "section_two_image_col_image");
                      ?>
                      <div class="real-estate-div-table-cell ca_property_bg ca_property_bg_<?php echo $i; ?>">
                        <div class="overlay"></div>
                        <a href="<?php echo get_sub_field("section_two_image_col_btn_link"); ?>"><div class="real-estate-dept"><?php echo get_sub_field("section_two_image_col_btn"); ?></div></a>
                      </div>
                      <?php $i++; endwhile; ?>
                    </div>
                  </div>
                </section>
            <?php }
            elseif( get_row_layout() == "section_news" && get_sub_field("load_news")) // layout: Section Intro
            { ?>
                <section class="section-news container">
                  <div class="tabs">
                    <?php
                      wp_reset_query();
                      global $paged;
                      if ( get_query_var('paged') ) { $paged = get_query_var('paged'); } else if ( get_query_var('page') ) {$paged = get_query_var('page'); } else {$paged = 1; }
                      $args = array(
                        'post_type'=>'news',
                        'post_status' => 'publish',
                        'posts_per_page'=>6,
                        'orderby'=>'date',
                      );
                      $the_query = new WP_Query( $args );
                      if( $the_query->have_posts() ) {
                    ?>
                    <div class="grid grid-tax">
                      <?php $i = 0;
                        while ( $the_query->have_posts() ): $the_query->the_post();
                          //foreach (get_the_terms(get_the_ID(), 'news-filter') as $cat) {
                          $cat = get_the_terms(get_the_ID(), 'news-filter')[0];
                            //$img=wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'news-thumbnail' );
                      ?>
                        <div class="inline element-item <?php echo $cat->slug; ?>">
                          <?php load_Feature_Img_Item(".item-" . $i, get_the_ID(), "news-thumbnail"); ?>
                          <div class="item item-<?php echo $i; ?> newsitem" data-url="<?php echo get_permalink(); ?>"></div>
                          <!--<img src="<?php echo $img[0]; ?>" width="<?php echo $img[1]; ?>" height="<?php echo $img[2]; ?>" alt="news featured image" class="img-responsive featured-image" /> -->
                          <?php
                            $categories = get_the_terms( get_the_ID(), 'news-filter' );
                            $category = 'news';
                            if ( ! empty( $categories ) ) {
                              $category = esc_html( $categories[0]->name );
                              $categorySlug = esc_html( $categories[0]->slug );
                            }
                            $iid = get_primary_taxonomy_id(get_the_ID(), 'news-filter');

                            if($iid!=null) $category = get_the_category_by_ID($iid);
                          ?>
                          <div class="item-content">
                            <h4><a href="/news_categories/<?php echo strtolower($categorySlug); ?>" class="cta-brown"><?php echo $category; ?></a></h4>
                            <a href="<?php echo get_permalink(); ?>" class="cta-brown"><?php echo get_the_title(); ?></a>
                            <p><?php echo get_the_excerpt(); ?></p>
                            <?php if(get_field("display_author", 'option')) { ?>
                            <p class="author-info-item"><?php echo get_the_author_meta( 'first_name') . ' ' . get_the_author_meta( 'last_name'); ?></p>
                            <?php } ?>
                          </div>
                        </div>
                      <?php $i++; endwhile; wp_reset_postdata(); } //} ?>
                    </div>
                  </div>
                  <div class="find_more"><a href="<?php echo get_sub_field("find_more_link"); ?>" class="btn"><?php echo get_sub_field("find_more_btn"); ?> <i class="icon-right-big"></i></a></div>
                </section>
            <?php }
        }
    }
}
