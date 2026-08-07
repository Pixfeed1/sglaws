<?php
if (!defined('ABSPATH')) exit;
/* Template Name: Expertise 03 — Catastrophe naturelle */
get_header();
?>

<div class="page-header">
  <div class="container">
    <p class="exp-page__crumbs">
      <a href="<?php echo home_url(); ?>">Accueil</a><span>·</span><a href="<?php echo sg_page_url('competences'); ?>">Domaines d&rsquo;intervention</a><span>·</span>Catastrophes naturelles
    </p>
    <span class="section-tag r">Domaines d&rsquo;intervention · 03</span>
    <h1 class="page-header__title">
      <span class="lr"><span>Avocat en assurance</span></span>
      <span class="lr"><span><em>catastrophe naturelle</em></span></span>
    </h1>
    <p class="exp-page__intro r">L’arrêté de reconnaissance de l’état de catastrophe naturelle est publié. Vous pensez la prise en charge acquise. Pourtant, la compagnie conteste le lien entre les dommages affectant votre bien et l’événement climatique reconnu.</p>
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
        <summary class="exp-faq__q">L’état de catastrophe naturelle est reconnu. L’assureur peut-il refuser ?</summary>
        <div class="exp-faq__a"><p>Oui. La reconnaissance de l’état de catastrophe naturelle ouvre la garantie, mais l’assuré doit encore établir que ses dommages résultent de l’événement. C’est ce lien que l’assureur conteste le plus souvent.</p></div>
      </details>

      <details class="exp-faq__item r">
        <summary class="exp-faq__q">L’expertise m’est défavorable. Puis-je la remettre en cause ?</summary>
        <div class="exp-faq__a"><p>Une expertise n’est pas intangible. Ses conclusions peuvent être discutées, complétées ou contredites, notamment lorsque les investigations techniques sont insuffisantes. Encore faut-il agir au bon moment.</p></div>
      </details>

    </div>
  </div>
</section>

<section class="exp-cta">
  <div class="container">
    <div class="exp-cta__inner">
      <div>
        <h2 class="exp-cta__heading r">L’assureur conteste le lien <em>avec l’événement climatique ?</em></h2>
        <p class="exp-cta__sub r">Prenez contact pour une première analyse confidentielle.</p>
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
