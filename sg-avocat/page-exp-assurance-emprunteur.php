<?php
if (!defined('ABSPATH')) exit;
/* Template Name: Expertise 01 — Assurance emprunteur */
get_header();
?>

<div class="page-header">
  <div class="container">
    <p class="exp-page__crumbs">
      <a href="<?php echo home_url(); ?>">Accueil</a><span>·</span><a href="<?php echo sg_page_url('competences'); ?>">Domaines d&rsquo;intervention</a><span>·</span>Assurance emprunteur
    </p>
    <span class="section-tag r">Domaines d&rsquo;intervention · 01</span>
    <h1 class="page-header__title"><?php echo sg_titre_deux_lignes(); ?></h1>
    <p class="exp-page__intro r"><?php echo esc_html(sg_chapo('Vous avez souscrit une assurance emprunteur pour garantir le remboursement de votre crédit en cas d’accident de la vie. Aujourd’hui, votre état de santé ne vous permet plus de travailler, mais l’assureur refuse de prendre en charge vos mensualités.')); ?></p>
  </div>
</div>

<section class="exp-page">
  <div class="container">
    <div class="exp-page__inner exp-page__body r <?php echo esc_attr(sg_toc_classe()); ?>">
      <?php
      /* Le texte de cette page se modifie dans WordPress : Pages > (cette page).
         Il n'est plus inscrit dans ce fichier, il survit donc aux mises a jour du theme. */
      while (have_posts()) : the_post();
          $sg = sg_toc_article();
          echo $sg['sommaire'];
          echo $sg['sommaire'] !== '' ? '<div class="article-body">' . $sg['contenu'] . '</div>' : $sg['contenu'];
      endwhile;
      ?>
    </div>
  </div>
</section>

<section class="exp-cta">
  <div class="container">
    <div class="exp-cta__inner">
      <div>
        <h2 class="exp-cta__heading r">Votre assurance emprunteur <em>refuse la prise en charge ?</em></h2>
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
