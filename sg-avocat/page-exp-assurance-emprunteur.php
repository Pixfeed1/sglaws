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
    <h1 class="page-header__title">
      <span class="lr"><span>Refus d’assurance emprunteur :</span></span>
      <span class="lr"><span><em>contester le refus de garantie</em></span></span>
    </h1>
    <p class="exp-page__intro r">Vous avez souscrit une assurance emprunteur pour garantir le remboursement de votre crédit en cas d’accident de la vie. Aujourd’hui, votre état de santé ne vous permet plus de travailler, mais l’assureur refuse de prendre en charge vos mensualités.</p>
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
      <h2 class="exp-faq__heading r">Ce que les emprunteurs demandent le plus souvent</h2>

      <details class="exp-faq__item r">
        <summary class="exp-faq__q">L’assureur invoque une fausse déclaration : puis-je encore agir ?</summary>
        <div class="exp-faq__a"><p>Oui. La fausse déclaration intentionnelle suppose la preuve, à la charge de l’assureur, d’une réponse inexacte à une question précise posée lors de la souscription et d’une intention de tromper. À défaut, la garantie reste due. Un examen du questionnaire de santé est indispensable.</p></div>
      </details>

      <details class="exp-faq__item r">
        <summary class="exp-faq__q">Mon taux d’invalidité est inférieur au seuil du contrat. Ai-je un recours ?</summary>
        <div class="exp-faq__a"><p>Le taux retenu par le médecin de l’assureur n’est pas définitif. Une seconde lecture médicale indépendante permet souvent de le contester, notamment lorsque le barème appliqué ou les pièces retenues sont discutables.</p></div>
      </details>

      <details class="exp-faq__item r">
        <summary class="exp-faq__q">Comment se faire indemniser après un refus de l’assurance emprunteur ?</summary>
        <div class="exp-faq__a"><p>La première étape consiste à obtenir la motivation écrite du refus, puis à réunir le contrat, la notice, le questionnaire de santé et les pièces médicales. Ces éléments permettent de vérifier si le motif invoqué, seuil d’invalidité ou fausse déclaration, est juridiquement fondé, avant d’engager un recours amiable ou judiciaire.</p></div>
      </details>

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
