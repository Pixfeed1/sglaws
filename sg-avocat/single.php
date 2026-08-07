<?php
if (!defined('ABSPATH')) exit; get_header(); ?>

<?php sg_breadcrumb(); ?>

<div class="page-header" style="text-align:center;padding-top:0;">
  <div class="container">
    <span class="section-tag r">Publication</span>
    <h1 class="page-header__title">
      <span class="lr"><span><?php the_title(); ?></span></span>
    </h1>
  </div>
</div>

<div class="article-meta">
  <div class="container">
    <div class="article-meta__inner">
      <span class="article-meta__date"><?php echo get_the_date('d F Y'); ?></span>
      <?php $cats = get_the_category(); if ($cats) : ?>
        <span class="article-meta__cat"><?php echo esc_html($cats[0]->name); ?></span>
      <?php endif; ?>
      <span class="article-meta__cat"><?php echo sg_reading_time(); ?></span>
      <a href="<?php echo home_url('/publications/'); ?>" class="article-meta__back">← Toutes les publications</a>
    </div>
  </div>
</div>

<?php if (has_post_thumbnail()) : ?>
<div class="container">
  <figure class="article-hero">
    <?php the_post_thumbnail('sg-hero', ['loading' => 'eager']); ?>
  </figure>
</div>
<?php endif; ?>

<section class="article">
  <div class="container">
    <div class="article__inner">
      <?php while (have_posts()) : the_post(); ?>
        <?php the_content(); ?>
      <?php endwhile; ?>
    </div>

    <?php $pdf_url = get_post_meta(get_the_ID(), '_sg_pdf_url', true); ?>
    <?php if ($pdf_url) : ?>
    <div class="article__inner">
      <div class="article-pdf r">
        <div class="article-pdf__icon">
          <svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" fill="none" stroke-width="1.5"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14,2 14,8 20,8"/><line x1="12" y1="18" x2="12" y2="12"/><polyline points="9,15 12,18 15,15"/></svg>
        </div>
        <div class="article-pdf__text">
          <span class="article-pdf__label"><?php echo esc_html(sg_text('article_pdf_label', 'Télécharger cet article en PDF')); ?></span>
          <span class="article-pdf__hint"><?php echo esc_html(sg_text('article_pdf_hint', 'Version mise en forme, idéale pour l\'impression ou la lecture hors-ligne.')); ?></span>
        </div>
        <a href="<?php echo esc_url($pdf_url); ?>" download class="article-pdf__btn"><?php echo esc_html(sg_text('article_pdf_btn', 'Télécharger PDF')); ?></a>
      </div>
    </div>
    <?php endif; ?>

    <div class="article__inner">
      <div class="article-author">
        <?php
        $photo_id = get_theme_mod('sg_photo_avocat', 0);
        $photo_url = $photo_id ? wp_get_attachment_image_url($photo_id, 'thumbnail') : 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100&q=80';
        ?>
        <img src="<?php echo esc_url($photo_url); ?>" alt="Me Seri Gueffie" class="article-author__avatar" loading="lazy">
        <div>
          <div class="article-author__name"><?php echo esc_html(sg_text('article_author_name', 'Me Seri Gueffie')); ?></div>
          <div class="article-author__role"><?php echo esc_html(sg_text('article_author_role', 'Avocat au Barreau de Lyon · Droit des assurances')); ?></div>
        </div>
      </div>
    </div>

    <?php get_template_part('template-parts/share-buttons'); ?>

    <div class="article-tags">
      <span class="article-tags__label">Tags</span>
      <?php $tags = get_the_tags(); if ($tags) : foreach ($tags as $tag) : ?>
        <a href="<?php echo get_tag_link($tag->term_id); ?>" class="article-tags__item"><?php echo esc_html($tag->name); ?></a>
      <?php endforeach; endif; ?>
    </div>
  </div>
</section>

<?php if (comments_open() || get_comments_number()) : ?>
  <?php comments_template(); ?>
<?php endif; ?>

<div class="container">
  <div class="article-prevnext">
    <?php $prev = get_previous_post(); if ($prev) : ?>
      <a href="<?php echo get_permalink($prev); ?>" class="article-prevnext__item">
        <span class="article-prevnext__dir">← Précédent</span>
        <span class="article-prevnext__title"><?php echo esc_html($prev->post_title); ?></span>
      </a>
    <?php else : ?><div></div><?php endif; ?>
    <?php $next = get_next_post(); if ($next) : ?>
      <a href="<?php echo get_permalink($next); ?>" class="article-prevnext__item article-prevnext__item--next">
        <span class="article-prevnext__dir">Suivant →</span>
        <span class="article-prevnext__title"><?php echo esc_html($next->post_title); ?></span>
      </a>
    <?php else : ?><div></div><?php endif; ?>
  </div>
</div>

<?php
/* Articles du même thème d'abord : un lecteur venu d'un article sur la
   prévoyance doit se voir proposer de la prévoyance, pas du dommage-ouvrage.
   Repli sur les plus récents si la catégorie n'en fournit pas trois. */
$exclude     = [get_the_ID()];
$cat_ids     = wp_get_post_categories(get_the_ID());
$related_ids = $cat_ids ? get_posts([
    'post_type'           => 'post',
    'posts_per_page'      => 3,
    'post__not_in'        => $exclude,
    'category__in'        => $cat_ids,
    'fields'              => 'ids',
    'ignore_sticky_posts' => true,
]) : [];

if (count($related_ids) < 3) {
    $related_ids = array_merge($related_ids, get_posts([
        'post_type'           => 'post',
        'posts_per_page'      => 3 - count($related_ids),
        'post__not_in'        => array_merge($exclude, $related_ids),
        'fields'              => 'ids',
        'ignore_sticky_posts' => true,
    ]));
}

if ($related_ids) :
    $related = new WP_Query([
        'post_type'           => 'post',
        'post__in'            => $related_ids,
        'orderby'             => 'post__in',
        'posts_per_page'      => 3,
        'ignore_sticky_posts' => true,
    ]);
?>
<section class="related">
  <div class="container">
    <span class="related__tag r"><?php echo esc_html(sg_text('article_related_tag', 'Autres publications')); ?></span>
    <div class="publications__list">
      <?php while ($related->have_posts()) : $related->the_post(); ?>
        <a href="<?php the_permalink(); ?>" class="pub-item r">
          <span class="pub-item__date"><?php echo get_the_date('d.m.Y'); ?></span>
          <span class="pub-item__title"><?php the_title(); ?></span>
          <span class="pub-item__download">Lire →</span>
        </a>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="article-cta">
  <div class="container">
    <div class="article-cta__inner">
      <div class="article-cta__text">
        <h2 class="article-cta__heading r"><?php echo wp_kses_post(sg_text('article_cta_title', 'Besoin d\'un <em>accompagnement ?</em>')); ?></h2>
        <p class="article-cta__sub r"><?php echo esc_html(sg_text('article_cta_sub', 'Chaque dossier mérite une analyse personnalisée.')); ?></p>
      </div>
      <a href="<?php echo home_url('/contact/'); ?>" class="btn btn--white r"><?php echo esc_html(sg_text('article_cta_btn', 'Prendre rendez-vous')); ?></a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
