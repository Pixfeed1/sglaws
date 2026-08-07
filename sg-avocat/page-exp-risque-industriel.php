<?php
if (!defined('ABSPATH')) exit;
/* Template Name: Expertise 06 — Risque industriel */
get_header();
?>

<div class="page-header">
  <div class="container">
    <p class="exp-page__crumbs">
      <a href="<?php echo home_url(); ?>">Accueil</a><span>·</span><a href="<?php echo sg_page_url('competences'); ?>">Domaines d&rsquo;intervention</a><span>·</span>Risque industriel
    </p>
    <span class="section-tag r">Domaines d&rsquo;intervention · 06</span>
    <h1 class="page-header__title"><?php echo sg_titre_deux_lignes(); ?></h1>
    <p class="exp-page__intro r"><?php echo esc_html(sg_chapo('Un sinistre majeur survient sur votre site ou implique l’un de vos produits. Plusieurs assureurs et responsables sont alors susceptibles d’être mis en cause.')); ?></p>
  </div>
</div>

<section class="exp-page">
  <div class="container">
    <div class="exp-page__inner exp-page__body r">
      <?php
      /* Le texte de cette page se modifie dans WordPress : Pages > (cette page).
         Il n'est plus inscrit dans ce fichier, il survit donc aux mises a jour du theme. */
      while (have_posts()) : the_post();
          the_content();
      endwhile;
      ?>
    </div>
  </div>
</section>

<section class="exp-cta">
  <div class="container">
    <div class="exp-cta__inner">
      <div>
        <h2 class="exp-cta__heading r">Un sinistre industriel <em>à acteurs multiples ?</em></h2>
        <p class="exp-cta__sub r">Prenez contact pour une première analyse confidentielle de votre dossier.</p>
      </div>
      <a href="<?php echo sg_page_url('contact'); ?>" class="btn btn--white r">Exposer ma situation</a>
    </div>
  </div>
</section>

<div class="exp-page__back">
  <div class="container">
    <a href="<?php echo sg_page_url('competences'); ?>">Voir tous les domaines d&rsquo;intervention</a>
  </div>
</div>

<?php get_footer(); ?>
