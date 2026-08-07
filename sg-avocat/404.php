<?php
if (!defined('ABSPATH')) exit; get_header(); ?>

<div class="error-page">
  <div class="error-page__code">404</div>
  <h1 class="error-page__title"><?php echo esc_html(sg_text('e404_title', 'Page introuvable')); ?></h1>
  <p class="error-page__text"><?php echo esc_html(sg_text('e404_text', 'La page que vous recherchez n\'existe pas ou a été déplacée. Nous vous invitons à retourner à l\'accueil.')); ?></p>
  <div class="error-page__actions">
    <a href="<?php echo home_url(); ?>" class="error-page__link"><?php echo esc_html(sg_text('e404_btn1', 'Retour à l\'accueil')); ?></a>
    <?php $e404_btn2 = sg_text('e404_btn2', 'Nous contacter'); if ($e404_btn2) : ?>
      <a href="<?php echo sg_page_url('contact'); ?>" class="error-page__link error-page__link--ghost"><?php echo esc_html($e404_btn2); ?></a>
    <?php endif; ?>
  </div>
</div>

<?php get_footer(); ?>
