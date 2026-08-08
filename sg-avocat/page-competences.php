<?php
if (!defined('ABSPATH')) exit;
/* Template Name: Domaines d'intervention (page chapeau) */
get_header();
?>

<div class="page-header">
  <div class="container">
    <span class="section-tag r">Le cabinet</span>
    <h1 class="page-header__title"><?php echo sg_titre_deux_lignes(); ?></h1>
    <p class="exp-page__intro r"><?php echo esc_html(sg_chapo('Le cabinet Gueffie intervient exclusivement en droit des assurances, au service des assurés. Face à un sinistre, assuré et assureur ne disposent pas des mêmes armes : la compagnie s’appuie sur un réseau d’experts mandatés pour limiter l’indemnisation. L’intervention du cabinet rétablit l’équilibre.')); ?></p>
    <p class="page-header__note r">Chaque domaine fait l&rsquo;objet d&rsquo;une page dédiée, qui détaille les motifs de refus habituellement opposés par les compagnies, les moyens de contestation et le déroulé d&rsquo;un dossier. Le cabinet défend ses clients à Lyon et sur l&rsquo;ensemble du territoire.</p>
  </div>
</div>

<section class="expertise expertise--light">
  <div class="container">
    <div class="expertise__list">
      <?php foreach (sg_expertises() as $e) : ?>
        <a href="<?php echo esc_url($e['url']); ?>" class="expertise__item r" style="text-decoration:none;color:inherit;">
          <span class="expertise__num"><?php echo $e['num']; ?></span>
          <h2 class="expertise__title"><?php echo esc_html($e['title']); ?></h2>
          <p class="expertise__desc"><?php echo esc_html($e['desc']); ?></p>
          <span class="expertise__arrow">↗</span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php if (sg_a_du_contenu()) : ?>
<section class="exp-page">
  <div class="container">
    <div class="exp-page__inner exp-page__body r <?php echo esc_attr(sg_toc_classe()); ?>">
      <?php while (have_posts()) : the_post(); $sg = sg_toc_article(); ?>
        <?php echo $sg['sommaire']; ?>
        <?php echo $sg['sommaire'] !== '' ? '<div class="article-body">' . $sg['contenu'] . '</div>' : $sg['contenu']; ?>
      <?php endwhile; ?>
    </div>
  </div>
</section>
<?php endif; ?>

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
