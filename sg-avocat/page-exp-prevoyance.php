<?php
if (!defined('ABSPATH')) exit;
/* Template Name: Expertise 02 — Prévoyance */
get_header();
?>

<div class="page-header">
  <div class="container">
    <p class="exp-page__crumbs">
      <a href="<?php echo home_url(); ?>">Accueil</a><span>·</span><a href="<?php echo sg_page_url('competences'); ?>">Domaines d&rsquo;intervention</a><span>·</span>Prévoyance
    </p>
    <span class="section-tag r">Domaines d&rsquo;intervention · 02</span>
    <h1 class="page-header__title">
      <span class="lr"><span>Avocat en assurance prévoyance :</span></span>
      <span class="lr"><span><em>contester le refus d’indemnisation</em></span></span>
    </h1>
    <p class="exp-page__intro r">Un contrat de prévoyance, individuel ou collectif, a une fonction simple : prendre le relais de vos revenus lorsque la maladie ou l’accident vous empêche de travailler. Lorsque l’assureur refuse cette garantie, alors que vous êtes en arrêt de travail ou reconnu invalide, les conséquences sont immédiates et souvent lourdes.</p>
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
      <h2 class="exp-faq__heading r">Ce que les assurés demandent le plus souvent</h2>

      <details class="exp-faq__item r">
        <summary class="exp-faq__q">Quand la prévoyance prend-elle le relais ?</summary>
        <div class="exp-faq__a"><p>En principe à l’issue du délai de franchise prévu au contrat, après un arrêt de travail ou une invalidité, et tant que les conditions de la garantie sont réunies. Un refus fondé sur la rupture du contrat de travail ou une maladie antérieure ne met pas nécessairement fin à la prise en charge.</p></div>
      </details>

      <details class="exp-faq__item r">
        <summary class="exp-faq__q">L’assureur invoque une maladie antérieure. Est-ce un motif valable ?</summary>
        <div class="exp-faq__a"><p>Pas toujours. Encore faut-il que la pathologie ait été connue, déclarable et effectivement exclue par le contrat. Une antériorité médicale ne suffit pas, à elle seule, à priver l’assuré de sa garantie.</p></div>
      </details>

      <details class="exp-faq__item r">
        <summary class="exp-faq__q">J’ai été licencié après mon arrêt de travail. Est-ce que je perds mes droits ?</summary>
        <div class="exp-faq__a"><p>Pas nécessairement. Les droits nés pendant la période de garantie peuvent être maintenus, notamment lorsque l’arrêt ou l’invalidité est antérieur à la rupture. C’est l’un des arguments les plus fréquemment opposés à tort par les assureurs.</p></div>
      </details>

      <details class="exp-faq__item r">
        <summary class="exp-faq__q">Comment savoir si le refus de mon assureur est contestable ?</summary>
        <div class="exp-faq__a"><p>Il faut confronter le motif écrit du refus aux clauses du contrat et à leur opposabilité (notice remise ou non), puis soumettre le volet médical à une lecture indépendante. C’est cette double analyse qui révèle si le refus tient juridiquement.</p></div>
      </details>

      <details class="exp-faq__item r">
        <summary class="exp-faq__q">Dans quels délais faut-il agir ?</summary>
        <div class="exp-faq__a"><p>Les actions dérivant d’un contrat d’assurance sont enfermées dans des délais de prescription qu’il ne faut pas laisser courir. Plus l’analyse est engagée tôt, mieux les preuves médicales et contractuelles sont préservées. Une première consultation permet de sécuriser ces délais.</p></div>
      </details>

    </div>
  </div>
</section>

<section class="exp-cta">
  <div class="container">
    <div class="exp-cta__inner">
      <div>
        <h2 class="exp-cta__heading r">Votre assureur prévoyance <em>refuse sa garantie ?</em></h2>
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
