<?php
if (!defined('ABSPATH')) exit;
/* Template Name: Domaines d'intervention (page chapeau) */
get_header();
?>

<div class="page-header">
  <div class="container">
    <span class="section-tag r">Le cabinet</span>
    <h1 class="page-header__title">
      <span class="lr"><span>Domaines d&rsquo;intervention</span></span>
      <span class="lr"><span><em>en droit des assurances</em></span></span>
    </h1>
    <p class="exp-page__intro r">Le cabinet Gueffie intervient exclusivement en droit des assurances, au service des assurés. Face à un sinistre, assuré et assureur ne disposent pas des mêmes armes : la compagnie s’appuie sur un réseau d’experts mandatés pour limiter l’indemnisation. L’intervention du cabinet rétablit l’équilibre.</p>
  </div>
</div>

<section class="expertise expertise--light">
  <div class="container">
    <div class="expertise__list">
      <a href="<?php echo sg_page_url('avocat-assurance-emprunteur'); ?>" class="expertise__item r" style="text-decoration:none;color:inherit;">
        <span class="expertise__num">01</span>
        <h2 class="expertise__title">Assurance emprunteur</h2>
        <p class="expertise__desc">Refus de prise en charge de vos mensualités (ITT, IPP, IPT) fondé sur un seuil d’invalidité ou une fausse déclaration ? Le cabinet conteste ces refus.</p>
        <span class="expertise__arrow">↗</span>
      </a>
      <a href="<?php echo sg_page_url('avocat-prevoyance-refus-garantie'); ?>" class="expertise__item r" style="text-decoration:none;color:inherit;">
        <span class="expertise__num">02</span>
        <h2 class="expertise__title">Prévoyance individuelle et collective</h2>
        <p class="expertise__desc">Après un arrêt de travail ou une invalidité, l’assureur refuse sa garantie : maladie antérieure, fausse déclaration, fin de contrat de travail.</p>
        <span class="expertise__arrow">↗</span>
      </a>
      <a href="<?php echo sg_page_url('avocat-catastrophe-naturelle-assurance'); ?>" class="expertise__item r" style="text-decoration:none;color:inherit;">
        <span class="expertise__num">03</span>
        <h2 class="expertise__title">Catastrophes naturelles</h2>
        <p class="expertise__desc">L’état de catastrophe naturelle est reconnu, mais l’assureur conteste le lien entre vos dommages et l’événement climatique.</p>
        <span class="expertise__arrow">↗</span>
      </a>
      <a href="<?php echo sg_page_url('avocat-assurance-construction-dommage-ouvrage'); ?>" class="expertise__item r" style="text-decoration:none;color:inherit;">
        <span class="expertise__num">04</span>
        <h2 class="expertise__title">Assurance construction et habitation</h2>
        <p class="expertise__desc">Désordres, malfaçons, refus ou lenteur de l’assureur dommages-ouvrage, contestation de l’origine du sinistre.</p>
        <span class="expertise__arrow">↗</span>
      </a>
      <a href="<?php echo sg_page_url('avocat-responsabilite-civile-professionnelle'); ?>" class="expertise__item r" style="text-decoration:none;color:inherit;">
        <span class="expertise__num">05</span>
        <h2 class="expertise__title">Responsabilité civile professionnelle</h2>
        <p class="expertise__desc">Votre responsabilité est mise en cause, ou l’assureur applique une règle proportionnelle réduisant l’indemnisation.</p>
        <span class="expertise__arrow">↗</span>
      </a>
      <a href="<?php echo sg_page_url('avocat-risque-industriel-assurance'); ?>" class="expertise__item r" style="text-decoration:none;color:inherit;">
        <span class="expertise__num">06</span>
        <h2 class="expertise__title">Risque industriel</h2>
        <p class="expertise__desc">Sinistre majeur, défaut produit, assureurs et responsables multiples : identifier le véritable débiteur de l’indemnisation.</p>
        <span class="expertise__arrow">↗</span>
      </a>
    </div>
  </div>
</section>

<section class="exp-page">
  <div class="container">
    <div class="exp-page__inner">
      <div class="exp-page__section r">
        <div class="exp-page__text">
          <p>Chaque domaine fait l’objet d’une page dédiée, qui détaille les motifs de refus habituellement opposés par les compagnies, les moyens de contestation et le déroulé d’un dossier. Le cabinet défend ses clients à Lyon et sur l’ensemble du territoire.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="exp-cta">
  <div class="container">
    <div class="exp-cta__inner">
      <div>
        <h2 class="exp-cta__heading r">Un litige avec votre assureur ? <em>Parlons-en.</em></h2>
        <p class="exp-cta__sub r">Chaque situation est unique. Prenez contact pour une première analyse confidentielle.</p>
      </div>
      <a href="<?php echo sg_page_url('contact'); ?>" class="btn btn--white r">Exposer ma situation</a>
    </div>
  </div>
</section>

<?php get_footer(); ?>
