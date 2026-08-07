<?php
if (!defined('ABSPATH')) exit;
/* Template Name: Avocat */
get_header();
$photo_id = get_theme_mod('sg_photo_avocat', 0);
$photo_url = $photo_id ? wp_get_attachment_image_url($photo_id, 'large') : 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&q=80';
?>

<div class="page-header">
  <div class="container">
    <span class="section-tag r">Avocat</span>
    <h1 class="page-header__title">
      <span class="lr"><span><?php echo esc_html(sg_text('avocat_prenom', 'Me Seri')); ?></span></span>
      <span class="lr"><span><em><?php echo esc_html(sg_text('avocat_nom', 'Gueffie')); ?></em></span></span>
    </h1>
  </div>
</div>

<section class="team" style="padding-top: clamp(50px, 6vh, 80px);">
  <div class="container">
    <div class="team__card">
      <div class="team__photo r">
        <img src="<?php echo esc_url($photo_url); ?>" alt="Me Seri Gueffie" loading="lazy">
      </div>
      <div class="team__info">
        <p class="team__role r"><?php echo esc_html(sg_text('avocat_subtitle', 'Avocat au Barreau de Lyon')); ?></p>
        <div class="team__bio r">
          <?php echo wp_kses_post(sg_text('avocat_bio', '<p>Passionné par le droit et animé par un sens profond de la justice, Me Seri Gueffie met son expertise au service de clients confrontés à des enjeux juridiques complexes.</p><p>Son approche allie rigueur analytique et vision stratégique, avec une attention constante portée à la dimension humaine de chaque affaire. Il défend avec conviction les intérêts de ses clients devant toutes les juridictions.</p>')); ?>
        </div>
        <div class="team__meta r">
          <div class="team__meta-row">
            <span class="team__meta-label">Formation</span>
            <span class="team__meta-value"><?php echo esc_html(sg_text('avocat_formation', 'Master en Droit — Université de Paris')); ?></span>
          </div>
          <div class="team__meta-row">
            <span class="team__meta-label">Barreau</span>
            <span class="team__meta-value"><?php echo esc_html(sg_text('avocat_barreau', 'Barreau de Lyon')); ?></span>
          </div>
          <?php $serment = sg_text('avocat_serment', '6 décembre 2021'); if ($serment) : ?>
          <div class="team__meta-row">
            <span class="team__meta-label">Serment</span>
            <span class="team__meta-value"><?php echo esc_html($serment); ?></span>
          </div>
          <?php endif; ?>
          <?php $specialite = sg_text('avocat_specialite', 'Droit des assurances'); if ($specialite) : ?>
          <div class="team__meta-row">
            <span class="team__meta-label">Spécialité</span>
            <span class="team__meta-value"><?php echo esc_html($specialite); ?></span>
          </div>
          <?php endif; ?>
          <div class="team__meta-row">
            <span class="team__meta-label">Langues</span>
            <span class="team__meta-value"><?php echo esc_html(sg_text('avocat_langues', 'Français, Anglais')); ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
