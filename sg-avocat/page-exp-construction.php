<?php
if (!defined('ABSPATH')) exit;
/* Template Name: Expertise 04 — Construction et dommage-ouvrage */
get_header();
?>

<div class="page-header">
  <div class="container">
    <p class="exp-page__crumbs">
      <a href="<?php echo home_url(); ?>">Accueil</a><span>·</span><a href="<?php echo sg_page_url('competences'); ?>">Domaines d&rsquo;intervention</a><span>·</span>Construction et habitation
    </p>
    <span class="section-tag r">Domaines d&rsquo;intervention · 04</span>
    <h1 class="page-header__title">
      <span class="lr"><span>Avocat en assurance construction</span></span>
      <span class="lr"><span><em>et dommage-ouvrage</em></span></span>
    </h1>
    <p class="exp-page__intro r">Votre bien est endommagé. L’assureur dommages-ouvrage tarde à répondre, refuse la prise en charge, ou conteste l’origine des désordres.</p>
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
      <h2 class="exp-faq__heading r">Ce que les propriétaires demandent le plus souvent</h2>

      <details class="exp-faq__item r">
        <summary class="exp-faq__q">L’assureur dommages-ouvrage ne répond pas dans les délais. Que faire ?</summary>
        <div class="exp-faq__a"><p>L’assureur dommages-ouvrage est tenu à des délais stricts pour se prononcer et formuler une offre. Leur non-respect ouvre des droits à l’assuré, y compris des sanctions. Un examen du calendrier de gestion est la première étape.</p></div>
      </details>

      <details class="exp-faq__item r">
        <summary class="exp-faq__q">J’ai déjà accepté une indemnisation. Est-il trop tard ?</summary>
        <div class="exp-faq__a"><p>Cela dépend des termes de l’accord et des postes de préjudice omis. Certains chefs de préjudice, comme la perte de jouissance ou des désordres évolutifs, peuvent encore être discutés. Une analyse au cas par cas est nécessaire.</p></div>
      </details>

    </div>
  </div>
</section>

<section class="exp-cta">
  <div class="container">
    <div class="exp-cta__inner">
      <div>
        <h2 class="exp-cta__heading r">Un désordre, une malfaçon, <em>un refus de l’assureur ?</em></h2>
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
