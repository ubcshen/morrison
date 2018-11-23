<?php $detect = new Mobile_Detect; ?>
<header class="banner">
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
      <nav class="mobile-primary inline <?php if($detect->isMobile()) { echo 'mobile-enable'; } ?>">
        <i class="icon-menu"></i>
      </nav>
    </div>
  </div>
</header>
