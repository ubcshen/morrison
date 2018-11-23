<footer class="content-info">
  <div class="container">
    <a class="brand inline" href="{{ home_url('/') }}">
      <?php
        $image = get_field('header_logo', 'option');
      ?>
      <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" width="200" height="60" class="img-responsive forLoaded" />
    </a>
    <div class="fRight footer-text">
      <div class="address inline"><a href="<?php the_field('address_url', 'option'); ?>" target="_blank"><?php the_field('address', 'option'); ?></a></div>
      <div class="phone inline"><?php the_field('phone_number', 'option'); ?></div>
      <div class="phone inline fax"><?php the_field('fax_number', 'option'); ?></div>
      <div class="copyright inline"><?php the_field('copyright', 'option'); ?></div>
    </div>
  </div>
</footer>
