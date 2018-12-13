<!doctype html>
<html {!! get_language_attributes() !!}>
  @include('partials.head')
  <body @php body_class() @endphp>
    <nav class="hide-desktop">
      <div class="language-switch inline language-switch-mobile">
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
      @if (has_nav_menu('primary_navigation'))
        {!! wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']) !!}
      @endif
    </nav>
    <div class="main-container">
      @php do_action('get_header') @endphp
      @include('partials.header')
      <div class="wrap" role="document">
        <div class="content">
          <main class="main">
            @yield('content')
          </main>
          @if (App\display_sidebar())
            <aside class="sidebar">
              @include('partials.sidebar')
            </aside>
          @endif
        </div>
      </div>
      @php do_action('get_footer') @endphp
      @include('partials.footer')
      @php wp_footer() @endphp
    </div>
  </body>
</html>
