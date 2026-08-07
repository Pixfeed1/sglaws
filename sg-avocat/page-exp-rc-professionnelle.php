<?php
if (!defined('ABSPATH')) exit;
/* Template Name: Expertise 05 — Responsabilité civile professionnelle */
get_header();
?>

<div class="page-header">
  <div class="container">
    <p class="exp-page__crumbs">
      <a href="<?php echo home_url(); ?>">Accueil</a><span>·</span><a href="<?php echo sg_page_url('competences'); ?>">Domaines d&rsquo;intervention</a><span>·</span>Responsabilité civile professionnelle
    </p>
    <span class="section-tag r">Domaines d&rsquo;intervention · 05</span>
    <h1 class="page-header__title">
      <span class="lr"><span>Avocat en responsabilité</span></span>
      <span class="lr"><span><em>civile professionnelle</em></span></span>
    </h1>
    <p class="exp-page__intro r">Votre responsabilité professionnelle est mise en cause par un client ou un tiers, à la suite d’un dommage survenu dans le cadre de votre activité. L’enjeu est double : votre garantie, et la continuité de votre exercice.</p>
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

<section class="exp-faq">
  <div class="container">
    <div class="exp-faq__inner">
      <span class="section-tag r">Questions fréquentes</span>
      <h2 class="exp-faq__heading r">Ce que les professionnels demandent le plus souvent</h2>

      <details class="exp-faq__item r">
        <summary class="exp-faq__q">L’assureur applique une règle proportionnelle. Puis-je la contester ?</summary>
        <div class="exp-faq__a"><p>Oui. La règle proportionnelle suppose la preuve, à la charge de l’assureur, d’une déclaration de risque inexacte et non intentionnelle. Ses conditions sont encadrées et son calcul peut être discuté.</p></div>
      </details>

      <details class="exp-faq__item r">
        <summary class="exp-faq__q">Dois-je attendre l’issue de la mise en cause pour agir ?</summary>
        <div class="exp-faq__a"><p>Non. Plus l’intervention est précoce, mieux les preuves sont préservées et les responsabilités cadrées. Attendre expose à des choix de gestion qui réduisent la marge de négociation.</p></div>
      </details>

    </div>
  </div>
</section>

<section class="exp-cta">
  <div class="container">
    <div class="exp-cta__inner">
      <div>
        <h2 class="exp-cta__heading r">Votre responsabilité professionnelle <em>est mise en cause ?</em></h2>
        <p class="exp-cta__sub r">Prenez contact pour une première analyse confidentielle de votre situation.</p>
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
