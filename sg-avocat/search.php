<?php
if (!defined('ABSPATH')) exit;
get_header();
$count = $wp_query->found_posts;
?>

<div class="page-header page-header--center">
  <div class="container">
    <span class="section-tag r">Recherche</span>
    <h1 class="page-header__title">
      <span class="lr"><span>Résultats pour «&thinsp;<em><?php echo esc_html(get_search_query()); ?></em>&thinsp;»</span></span>
    </h1>
    <span class="search-results__count r"><?php echo $count; ?> résultat<?php echo $count > 1 ? 's' : ''; ?> trouvé<?php echo $count > 1 ? 's' : ''; ?></span>
  </div>
</div>

<div class="search-bar">
  <div class="container">
    <?php get_search_form(); ?>
  </div>
</div>

<section class="search-results">
  <div class="container">
    <?php if (have_posts()) : ?>
      <div class="search-results__inner">
        <?php while (have_posts()) : the_post(); ?>
          <a href="<?php the_permalink(); ?>" class="search-item r">
            <?php if (has_post_thumbnail()) : ?>
              <img class="search-item__img" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'sg-card'); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
            <?php endif; ?>
            <div class="search-item__content">
              <div class="search-item__meta">
                <span class="search-item__date"><?php echo get_the_date('d.m.Y'); ?></span>
                <?php $cats = get_the_category(); if ($cats) : ?>
                  <span class="search-item__cat"><?php echo esc_html($cats[0]->name); ?></span>
                <?php endif; ?>
              </div>
              <h2 class="search-item__title"><?php the_title(); ?></h2>
              <p class="search-item__excerpt"><?php echo wp_trim_words(get_the_excerpt(), 25); ?></p>
            </div>
          </a>
        <?php endwhile; ?>
      </div>
      <div class="pagination">
        <?php
        the_posts_pagination([
            'prev_text' => '&larr;',
            'next_text' => '&rarr;',
            'mid_size'  => 2,
        ]);
        ?>
      </div>
    <?php else : ?>
      <div class="search-empty">
        <svg class="search-empty__icon" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/><path d="M8 11h6"/></svg>
        <h2 class="search-empty__title">Aucun résultat</h2>
        <p class="search-empty__text">Aucun article ne correspond à votre recherche. Essayez avec d'autres termes ou parcourez nos publications.</p>
      </div>
    <?php endif; ?>
  </div>
</section>

<section class="search-cta">
  <div class="container">
    <div class="search-cta__inner">
      <div class="search-cta__text">
        <h2 class="search-cta__heading r">Vous ne trouvez pas <em>votre réponse ?</em></h2>
        <p class="search-cta__sub r">Contactez-nous directement pour une analyse personnalisée.</p>
      </div>
      <a href="<?php echo home_url('/contact/'); ?>" class="btn btn--white r">Prendre rendez-vous</a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
