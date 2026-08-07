<?php
if (!defined('ABSPATH')) exit;
/* Template Name: Expertise Détail */
get_header();

$default_titles = [
    1 => 'Droit <em>Pénal</em>',
    2 => 'Droit de la <em>Famille</em>',
    3 => 'Droit des <em>Affaires</em>',
    4 => 'Droit du <em>Travail</em>',
    5 => 'Droit <em>Immobilier</em>',
    6 => 'Droit des <em>Étrangers</em>',
];
$detail_keys = ['droit_penal', 'droit_famille', 'droit_affaires', 'droit_travail', 'droit_immobilier', 'droit_etrangers'];
?>

<div class="page-header">
  <div class="container">
    <span class="section-tag r"><?php echo esc_html(sg_text('home_exp_tag', 'Expertise')); ?></span>
    <h1 class="page-header__title">
      <span class="lr"><span><?php echo esc_html(sg_text('exp_detail_title_l1', 'Domaines')); ?></span></span>
      <span class="lr"><span><em><?php echo esc_html(sg_text('exp_detail_title_l2', 'd\'intervention')); ?></em></span></span>
    </h1>
  </div>
</div>

<section class="exp-detail">
  <div class="container">
    <div class="exp-detail__inner">

      <a href="<?php echo home_url('/expertise/'); ?>" class="exp-detail__back r"><?php echo esc_html(sg_text('exp_detail_back', '← Retour aux domaines')); ?></a>

      <?php for ($i = 1; $i <= 6; $i++) :
          $num = str_pad($i, 2, '0', STR_PAD_LEFT);
          $title = sg_text("exp_d{$i}_title", $default_titles[$i] ?? '');
          $detail_key = $detail_keys[$i - 1];
          $text = sg_text("exp_detail_{$detail_key}_text", '');
          if (!$title) continue;
          $anchor = sanitize_title(wp_strip_all_tags($title));
      ?>
        <div class="exp-domain r" id="<?php echo esc_attr($anchor); ?>">
          <span class="exp-domain__num"><?php echo $num; ?></span>
          <h2 class="exp-domain__title"><?php echo wp_kses_post($title); ?></h2>
          <div class="exp-domain__text"><?php echo wp_kses_post(wpautop($text)); ?></div>
        </div>
      <?php endfor; ?>

    </div>
  </div>
</section>

<section class="exp-cta">
  <div class="container">
    <div class="exp-cta__inner">
      <div>
        <h2 class="exp-cta__heading r"><?php echo wp_kses_post(sg_text('exp_detail_cta_title', 'Besoin d\'un <em>accompagnement ?</em>')); ?></h2>
        <p class="exp-cta__sub r"><?php echo esc_html(sg_text('exp_detail_cta_sub', 'Chaque dossier mérite une analyse personnalisée.')); ?></p>
      </div>
      <a href="<?php echo home_url('/contact/'); ?>" class="btn btn--white r"><?php echo esc_html(sg_text('exp_detail_cta_btn', 'Prendre rendez-vous')); ?></a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
