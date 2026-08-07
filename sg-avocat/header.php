<?php if (!defined('ABSPATH')) exit; ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <script>document.documentElement.classList.remove('no-js');</script>
  <link rel="icon" type="image/svg+xml" href="<?php echo SG_URI; ?>/img/favicon.svg">
  <link rel="icon" type="image/png" href="<?php echo SG_URI; ?>/img/favicon.png">
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main">Aller au contenu principal</a>

<?php $header_class = is_front_page() ? 'header' : 'header header--solid'; ?>

<header class="<?php echo $header_class; ?>" id="header">
  <div class="container header__inner">
    <a href="<?php echo home_url(); ?>" class="header__logo"><?php echo esc_html(sg_text('site_logo', 'Seri Gueffie')); ?></a>
    <nav class="header__nav">
      <?php
      wp_nav_menu([
          'theme_location' => 'primary',
          'container'       => false,
          'items_wrap'      => '%3$s',
          'depth'           => 1, // La barre est une ligne unique : les entrées enfants sont ignorées ici.
          'walker'          => new SG_Desktop_Walker(),
          'fallback_cb'     => 'sg_fallback_menu',
      ]);
      ?>
    </nav>
    <button class="burger" id="burger" aria-label="Menu">
      <span></span><span></span><span></span>
    </button>
  </div>
</header>

<div class="mobile-nav" id="mobileNav">
  <?php
  wp_nav_menu([
      'theme_location' => 'primary',
      'container'       => false,
      'items_wrap'      => '%3$s',
      'walker'          => new SG_Mobile_Walker(),
      'fallback_cb'     => 'sg_fallback_mobile_menu',
  ]);
  ?>
</div>

<main id="main">
