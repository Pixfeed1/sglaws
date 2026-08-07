<?php
if (!defined('ABSPATH')) exit; get_header(); ?>

<div class="page-header">
  <div class="container">
    <span class="section-tag r">Blog</span>
    <h1 class="page-header__title">
      <span class="lr"><span>Articles &</span></span>
      <span class="lr"><span><em>Publications</em></span></span>
    </h1>
  </div>
</div>

<section class="publications" style="padding-top:clamp(50px,6vh,80px);">
  <div class="container">
    <div class="publications__list">
      <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <a href="<?php the_permalink(); ?>" class="pub-item r">
          <span class="pub-item__date"><?php echo get_the_date('d.m.Y'); ?></span>
          <span class="pub-item__title"><?php the_title(); ?></span>
          <span class="pub-item__download">Lire →</span>
        </a>
      <?php endwhile; ?>
    </div>

    <div style="text-align:center;padding:2rem 0;">
      <?php the_posts_pagination(['prev_text' => '←', 'next_text' => '→']); ?>
    </div>

    <?php else : ?>
      <p style="text-align:center;padding:4rem 0;color:var(--grey-500);">Aucun article trouvé.</p>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
