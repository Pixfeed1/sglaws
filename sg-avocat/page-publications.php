<?php
if (!defined('ABSPATH')) exit;
/* Template Name: Publications */
get_header(); ?>

<div class="page-header">
  <div class="container">
    <span class="section-tag r"><?php echo esc_html(sg_text('home_pub_tag', 'Publications')); ?></span>
    <h1 class="page-header__title">
      <span class="lr"><span><?php echo esc_html(sg_text('pub_title_l1', 'Articles &')); ?></span></span>
      <span class="lr"><span><em><?php echo esc_html(sg_text('pub_title_l2', 'Publications')); ?></em></span></span>
    </h1>
  </div>
</div>

<section class="publications" style="padding-top: clamp(50px, 6vh, 80px);">
  <div class="container">
    <div class="publications__list">
      <?php
      $all = new WP_Query(['post_type' => 'post', 'posts_per_page' => 20, 'orderby' => 'date', 'order' => 'DESC']);
      while ($all->have_posts()) : $all->the_post();
          $pdf_url = get_post_meta(get_the_ID(), '_sg_pdf_url', true);
      ?>
        <a href="<?php the_permalink(); ?>" class="pub-item r">
          <span class="pub-item__date"><?php echo get_the_date('d.m.Y'); ?></span>
          <span class="pub-item__title"><?php the_title(); ?></span>
          <span class="pub-item__download">Lire →</span>
        </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>
