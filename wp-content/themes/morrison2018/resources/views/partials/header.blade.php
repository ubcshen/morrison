<?php $detect = new Mobile_Detect; ?>
<header class="banner">
  <div class="banner-bg"></div>
  <div class="container">
    <div class="inner-container">
      <a class="brand inline" href="{{ home_url('/') }}">
        <?php
          $image = get_field('header_logo', 'option');
        ?>
        <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="300" height="90" class="img-responsive forLoaded" />
      </a>
      <nav class="nav-primary inline">
        @if (has_nav_menu('primary_navigation'))
          {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
        @endif
      </nav>
      <nav class="mobile-primary inline">
        <i class="icon-menu"></i>
      </nav>
    </div>
  </div>
  <div class="language-switch inline language-switch-desktop">
    <?php if (function_exists('icl_get_languages')) { ?>
    <?php
      $items = '<ul class="langSwitcher">';
      $languages = icl_get_languages('skip_missing=0');
      if (1 < count($languages)) {
        foreach ($languages as $l) {
          if($l['language_code']==ICL_LANGUAGE_CODE) {
            $items = $items . '<li class="menu-item custom-switcher current-lang inline"><a href="' . $l['url'] . '" class="active"><img src="'.$l['country_flag_url'].'" width="18" height="12" /></a></li>';
          }
        }
        foreach ($languages as $l) {
          if($l['language_code']!=ICL_LANGUAGE_CODE) {
            $items = $items . '<li class="menu-item custom-switcher lang-item inline"><a href="' . $l['url'] . '"><img src="'.$l['country_flag_url'].'" width="18" height="12" /></a></li>';
          }
        }
      }
      $items = $items . '</ul>';
      //if(get_field("additional_css", 'option')) { echo get_field("additional_css", 'option'); }
    }
    echo $items;
    ?>
  </div>
</header>
