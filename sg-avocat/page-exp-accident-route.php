<?php
if (!defined('ABSPATH')) exit;
/* Template Name: Expertise 07 — Accident de la route */
get_header();
?>

<div class="page-header">
  <div class="container">
    <p class="exp-page__crumbs">
      <a href="<?php echo home_url(); ?>">Accueil</a><span>·</span><a href="<?php echo sg_page_url('competences'); ?>">Domaines d&rsquo;intervention</a><span>·</span>Accident de la route
    </p>
    <span class="section-tag r">Domaines d&rsquo;intervention · 07</span>
    <h1 class="page-header__title">
      <span class="lr"><span>Avocat en indemnisation des victimes</span></span>
      <span class="lr"><span><em>d’accident de la route</em></span></span>
    </h1>
    <p class="exp-page__intro r">Après un accident de la route, la loi impose à l’assureur de vous présenter une offre d’indemnisation. Cette offre est souvent inférieure à ce que votre préjudice justifie.</p>
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
      <h2 class="exp-faq__heading r">Ce que les victimes demandent le plus souvent</h2>

      <details class="exp-faq__item r">
        <summary class="exp-faq__q">Dois-je accepter la première offre de l’assureur ?</summary>
        <div class="exp-faq__a"><p>Rien ne vous y oblige. Une première offre est souvent sous-évaluée et peut intervenir avant la consolidation de votre état. La faire analyser avant de répondre permet de mesurer l’écart avec votre préjudice réel et d’éviter une renonciation définitive.</p></div>
      </details>

      <details class="exp-faq__item r">
        <summary class="exp-faq__q">Puis-je contester l’expertise médicale de l’assureur ?</summary>
        <div class="exp-faq__a"><p>Oui. Les conclusions de l’expert mandaté par l’assureur ne sont pas intangibles : taux de déficit, imputabilité, date de consolidation peuvent être discutés, au besoin par une nouvelle expertise. L’assistance dès ce stade est déterminante.</p></div>
      </details>

      <details class="exp-faq__item r">
        <summary class="exp-faq__q">Comment est financé le recours à un avocat ?</summary>
        <div class="exp-faq__a"><p>Votre contrat peut comporter une protection juridique susceptible de prendre en charge tout ou partie des honoraires ; par ailleurs, les frais engagés peuvent être réclamés dans le cadre de la procédure. Ce point est examiné dès la première consultation, en toute transparence.</p></div>
      </details>

      <details class="exp-faq__item r">
        <summary class="exp-faq__q">Dans quels délais faut-il agir ?</summary>
        <div class="exp-faq__a"><p>Il est préférable d’intervenir tôt, avant l’expertise et avant toute réponse à l’offre, pour préserver les preuves médicales et vos droits. Des délais de prescription encadrent par ailleurs l’action : une première consultation permet de les sécuriser.</p></div>
      </details>

    </div>
  </div>
</section>

<section class="exp-cta">
  <div class="container">
    <div class="exp-cta__inner">
      <div>
        <h2 class="exp-cta__heading r">Vous avez reçu une offre d’indemnisation <em>après un accident ?</em></h2>
        <p class="exp-cta__sub r">Prenez contact pour une première analyse confidentielle avant d’y répondre.</p>
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
