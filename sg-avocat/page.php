<?php
if (!defined('ABSPATH')) exit; get_header(); ?>

<div class="page-header">
  <div class="container">
    <h1 class="page-header__title"><?php the_title(); ?></h1>
  </div>
</div>

<section class="legal">
  <div class="container container--narrow">
    <?php while (have_posts()) : the_post(); ?>
      <?php the_content(); ?>
    <?php endwhile; ?>
  </div>
</section>

<?php get_footer(); ?>
