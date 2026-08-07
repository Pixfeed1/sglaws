<?php
if (!defined('ABSPATH')) exit; get_header(); ?>

<div class="page-header" style="text-align:center;">
  <div class="container">
    <span class="section-tag r"><?php echo is_tag() ? 'Tag' : 'Catégorie'; ?></span>
    <h1 class="page-header__title">
      <span class="lr"><span><?php echo single_term_title('', false); ?></span></span>
    </h1>
    <p class="r" style="font-size:0.88rem;color:var(--grey-500);margin-top:0.8rem;"><?php echo $wp_query->found_posts; ?> article<?php echo $wp_query->found_posts > 1 ? 's' : ''; ?></p>
  </div>
</div>

<section style="padding:clamp(40px,5vh,70px) 0 clamp(60px,8vh,100px);">
  <div class="container">
    <?php if (have_posts()) : ?>
    <div class="publications__list">
      <?php while (have_posts()) : the_post(); ?>
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
      <p style="text-align:center;padding:4rem 0;color:var(--grey-500);">Aucun article dans cette catégorie.</p>
    <?php endif; ?>
  </div>
</section>

<?php get_footer(); ?>
