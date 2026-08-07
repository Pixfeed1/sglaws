<?php
if (!defined('ABSPATH')) exit;
/* Template Name: Expertise */
get_header(); ?>

<div class="page-header">
  <div class="container">
    <span class="section-tag r"><?php echo esc_html(sg_text('home_exp_tag', 'Expertise')); ?></span>
    <h1 class="page-header__title">
      <span class="lr"><span><?php echo esc_html(sg_text('exp_detail_title_l1', 'Domaines')); ?></span></span>
      <span class="lr"><span><em><?php echo esc_html(sg_text('exp_detail_title_l2', 'd\'intervention')); ?></em></span></span>
    </h1>
  </div>
</div>

<section class="expertise expertise--light" style="padding-top: clamp(50px, 6vh, 80px);">
  <div class="container">
    <div class="expertise__header" style="grid-template-columns: 1fr;">
      <p class="expertise__intro r"><?php echo esc_html(sg_text('exp_intro', 'Le cabinet déploie ses compétences pour la protection des intérêts de ses clients dans l\'ensemble des domaines du droit, avec une exigence constante d\'efficacité.')); ?></p>
    </div>
    <div class="expertise__list">
      <?php
      foreach (sg_expertises() as $e) :
          $num = $e['num']; $title = $e['title'];
      ?>
        <a href="<?php echo esc_url($e['url']); ?>" class="expertise__item r" style="text-decoration:none;color:inherit;">
          <span class="expertise__num"><?php echo $num; ?></span>
          <h3 class="expertise__title"><?php echo esc_html($title); ?></h3>
          <p class="expertise__desc"><?php echo esc_html($e['desc']); ?></p>
          <span class="expertise__arrow">↗</span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php get_footer(); ?>
