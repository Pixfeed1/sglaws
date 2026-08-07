<?php
if (!defined('ABSPATH')) exit;
/*
Template Name: Landing Page
*/
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
  <script>document.documentElement.classList.remove('no-js');</script>
  <link rel="icon" type="image/svg+xml" href="<?php echo SG_URI; ?>/img/favicon.svg">
  <link rel="icon" type="image/png" href="<?php echo SG_URI; ?>/img/favicon.png">
  <?php wp_head(); ?>
</head>
<body <?php body_class('landing-page'); ?>>
<?php wp_body_open(); ?>

<a class="skip-link" href="#main">Aller au contenu principal</a>

<?php
$hero_video = get_theme_mod('sg_landing_video', '');
$hero_image = get_theme_mod('sg_landing_image', 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=1920&q=80');
$phone = sg_option('sg_phone', '04 81 13 09 40');
$phone_clean = preg_replace('/[^0-9]/', '', $phone);
$rdv_url = sg_text('land_rdv_url', '#contact');
?>

<!-- TOPBAR -->
<div class="topbar">
  <div class="container topbar__inner">
    <a href="<?php echo home_url(); ?>" class="topbar__logo"><?php echo esc_html(sg_text('site_logo', 'Seri Gueffie')); ?></a>
    <div class="topbar__right">
      <a href="tel:+33<?php echo $phone_clean; ?>" class="topbar__phone">
        <svg class="topbar__phone-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z"/></svg>
        <?php echo esc_html($phone); ?>
      </a>
      <a href="<?php echo esc_url($rdv_url); ?>"<?php echo strpos($rdv_url, "http") === 0 ? ' target="_blank" rel="noopener"' : ''; ?> class="topbar__cta"><?php echo esc_html(sg_text('land_topbar_cta', 'Consultation')); ?></a>
    </div>
  </div>
</div>

<main id="main">

<!-- HERO -->
<section class="hero" id="hero">
  <div class="hero__media">
    <?php if ($hero_video) : ?>
      <video autoplay muted loop playsinline preload="auto">
        <source src="<?php echo esc_url($hero_video); ?>" type="video/mp4">
      </video>
    <?php else : ?>
      <img src="<?php echo esc_url($hero_image); ?>" alt="<?php bloginfo('name'); ?>" loading="eager">
    <?php endif; ?>
  </div>
  <div class="hero__overlay"></div>
  <div class="container hero__content">
    <span class="hero__tag r"><?php echo esc_html(sg_text('land_hero_tag', 'Avocat en droit des assurances · Lyon')); ?></span>
    <h1>
      <span class="lr"><span><?php echo esc_html(sg_text('land_hero_l1', 'Votre assureur refuse')); ?></span></span>
      <span class="lr"><span><?php echo wp_kses_post(sg_text('land_hero_l2', 'de vous <em>indemniser ?</em>')); ?></span></span>
    </h1>
    <p class="hero__sub r"><?php echo esc_html(sg_text('land_hero_sub', 'Sinistre contesté, garantie refusée, indemnisation insuffisante — Me Seri Gueffie défend vos droits face aux compagnies d\'assurance.')); ?></p>
    <div class="hero__cta-row r">
      <a href="<?php echo esc_url($rdv_url); ?>"<?php echo strpos($rdv_url, "http") === 0 ? ' target="_blank" rel="noopener"' : ''; ?> class="btn btn--white"><?php echo esc_html(sg_text('land_btn1', 'Prendre rendez-vous')); ?></a>
      <a href="#expertise" class="btn btn--ghost"><?php echo esc_html(sg_text('land_btn2', 'Découvrir l\'expertise')); ?></a>
    </div>
  </div>
  <div class="hero__scroll">
    <span class="hero__scroll-text">Scroll</span>
    <span class="hero__scroll-line"></span>
  </div>
</section>

<!-- TRUST BAR -->
<section class="trust" id="trust">
  <div class="container">
    <div class="trust__inner">
      <?php for ($i = 1; $i <= 3; $i++) :
          $num = sg_text("land_trust_num$i", $i === 1 ? '100%' : ($i === 2 ? 'Lyon' : 'Sur mesure'));
          $label = sg_text("land_trust_label$i", $i === 1 ? 'Dédié aux assurances' : ($i === 2 ? 'Barreau de Lyon' : 'Stratégie personnalisée'));
      ?>
        <div class="trust__item r">
          <div class="trust__number"><?php echo esc_html($num); ?></div>
          <div class="trust__label"><?php echo esc_html($label); ?></div>
        </div>
      <?php endfor; ?>
    </div>
  </div>
</section>

<!-- PROBLEMS -->
<section class="problems" id="problems">
  <div class="container">
    <span class="section-tag r"><?php echo esc_html(sg_text('land_problems_tag', 'Situations fréquentes')); ?></span>
    <h2 class="problems__heading r"><?php echo wp_kses_post(sg_text('land_problems_title', 'Vous faites face à un litige avec votre <em>assureur ?</em>')); ?></h2>
    <div class="problems__grid">
      <?php
      $default_problems = [
          ['Refus d\'indemnisation', 'Votre assureur invoque une exclusion de garantie ou conteste la nature du sinistre pour refuser toute prise en charge.'],
          ['Indemnisation insuffisante', 'L\'offre d\'indemnisation proposée ne couvre pas l\'étendue réelle de votre préjudice, qu\'il soit matériel, corporel ou financier.'],
          ['Sinistre décennal contesté', 'Un désordre affecte votre construction et l\'assureur décennale refuse d\'intervenir ou minimise les responsabilités.'],
          ['Sinistre industriel', 'Équipement défectueux, défaillance de process, rappel de produit : les garanties mobilisables sont complexes à activer.'],
          ['Responsabilité professionnelle', 'Votre responsabilité est recherchée suite à un sinistre dans l\'exercice de votre activité et votre RC Pro est contestée.'],
          ['Catastrophe naturelle', 'Vos locaux, équipements ou stocks ont été endommagés et l\'assureur conteste l\'étendue de la garantie ou le montant proposé.'],
      ];
      for ($i = 1; $i <= 6; $i++) :
          $num = str_pad($i, 2, '0', STR_PAD_LEFT);
          $title = sg_text("land_problem{$i}_title", $default_problems[$i-1][0]);
          $text = sg_text("land_problem{$i}_text", $default_problems[$i-1][1]);
      ?>
        <div class="problem-card r">
          <div class="problem-card__num"><?php echo $num; ?></div>
          <h3 class="problem-card__title"><?php echo esc_html($title); ?></h3>
          <p class="problem-card__text"><?php echo esc_html($text); ?></p>
        </div>
      <?php endfor; ?>
    </div>
  </div>
</section>

<!-- EXPERTISE -->
<section class="lp-expertise" id="expertise">
  <div class="container">
    <div class="lp-expertise__grid">
      <div>
        <span class="section-tag section-tag--light r"><?php echo esc_html(sg_text('home_exp_tag', 'Expertise')); ?></span>
        <h2 class="lp-expertise__heading r"><?php echo wp_kses_post(sg_text('land_exp_title', 'Une pratique <em>exclusivement</em> dédiée au droit des assurances')); ?></h2>
        <p class="lp-expertise__text r"><?php echo esc_html(sg_text('land_exp_text', 'Me Seri Gueffie consacre l\'intégralité de son activité au droit des assurances. Cette spécialisation exclusive garantit une maîtrise approfondie des mécanismes assurantiels, de la jurisprudence applicable et des stratégies de défense les plus efficaces.')); ?></p>
        <a href="<?php echo esc_url($rdv_url); ?>"<?php echo strpos($rdv_url, "http") === 0 ? ' target="_blank" rel="noopener"' : ''; ?> class="btn btn--ghost r" style="display:inline-block;"><?php echo esc_html(sg_text('land_btn1', 'Prendre rendez-vous')); ?></a>
      </div>
      <div>
        <div class="lp-expertise__list">
          <?php foreach (sg_expertises() as $e) : $num = $e['num']; $title = $e['title']; ?>
            <a href="<?php echo esc_url($e['url']); ?>" class="lp-expertise__item r">
              <span class="lp-expertise__item-num"><?php echo $num; ?></span>
              <span class="lp-expertise__item-title"><?php echo esc_html($title); ?></span>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- APPROACH -->
<section class="approach" id="approche">
  <div class="container">
    <div class="approach__header">
      <span class="section-tag r"><?php echo esc_html(sg_text('land_approach_tag', 'Approche')); ?></span>
      <h2 class="approach__heading r"><?php echo esc_html(sg_text('land_approach_title', 'Comment se déroule votre accompagnement')); ?></h2>
      <p class="approach__sub r"><?php echo esc_html(sg_text('land_approach_sub', 'Une méthode rigoureuse pour maximiser vos chances de succès.')); ?></p>
    </div>
    <div class="steps">
      <?php
      $default_steps = [
          ['Analyse du dossier', 'Étude approfondie de votre contrat, du sinistre et de la position de l\'assureur. Identification des leviers juridiques et des failles dans l\'argumentation adverse.'],
          ['Stratégie & négociation', 'Élaboration d\'une stratégie sur mesure. Phase amiable structurée avec mise en demeure argumentée et négociation directe avec l\'assureur.'],
          ['Action contentieuse', 'En cas d\'échec de la voie amiable, engagement de la procédure judiciaire avec une argumentation technique solide devant les juridictions compétentes.'],
      ];
      for ($i = 1; $i <= 3; $i++) :
          $title = sg_text("land_step{$i}_title", $default_steps[$i-1][0]);
          $text = sg_text("land_step{$i}_text", $default_steps[$i-1][1]);
      ?>
        <div class="step r">
          <h3 class="step__title"><?php echo esc_html($title); ?></h3>
          <p class="step__text"><?php echo esc_html($text); ?></p>
        </div>
      <?php endfor; ?>
    </div>
  </div>
</section>

<!-- CONTACT -->
<section class="lp-contact" id="contact">
  <div class="container">
    <div class="lp-contact__grid">
      <div>
        <span class="section-tag r"><?php echo esc_html(sg_text('home_contact_tag', 'Contact')); ?></span>
        <h2 class="lp-contact__heading r"><?php echo wp_kses_post(sg_text('land_contact_title', 'Défendons vos<br><em>intérêts</em>')); ?></h2>
        <p class="lp-contact__text r"><?php echo esc_html(sg_text('land_contact_text', 'Chaque situation mérite une analyse approfondie. Prenez rendez-vous pour une première consultation et exposez votre dossier en toute confidentialité.')); ?></p>
        <div class="lp-contact__info r">
          <div class="lp-contact__info-row">
            <span class="lp-contact__info-label"><?php echo esc_html(sg_text('label_adresse', 'Adresse')); ?></span>
            <span class="lp-contact__info-value"><?php echo wp_kses_post(sg_option('sg_address', '86, Rue Paul Bert<br>69003 Lyon')); ?></span>
          </div>
          <div class="lp-contact__info-row">
            <span class="lp-contact__info-label"><?php echo esc_html(sg_text('label_telephone', 'Téléphone')); ?></span>
            <span class="lp-contact__info-value"><a href="tel:+33<?php echo $phone_clean; ?>"><?php echo esc_html($phone); ?></a></span>
          </div>
          <div class="lp-contact__info-row">
            <span class="lp-contact__info-label"><?php echo esc_html(sg_text('label_email', 'Email')); ?></span>
            <span class="lp-contact__info-value"><a href="mailto:<?php echo esc_attr(sg_option('sg_email', 'seri@gueffie.fr')); ?>"><?php echo esc_html(sg_option('sg_email', 'seri@gueffie.fr')); ?></a></span>
          </div>
        </div>
      </div>
      <form class="lp-form r" id="sg-contact-form" method="post">
        <input type="hidden" name="source" value="landing">
        <div aria-hidden="true" style="position:absolute;left:-9999px;"><label for="sg_hp_field" class="sr-only">Ne pas remplir</label><input type="text" name="sg_hp" id="sg_hp_field" tabindex="-1" autocomplete="off"></div>
        <div class="lp-form__row">
          <div class="lp-form__group">
            <label class="lp-form__label" for="lp-name">Nom</label>
            <input class="lp-form__input" type="text" name="name" id="lp-name" placeholder="Votre nom" required>
          </div>
          <div class="lp-form__group">
            <label class="lp-form__label" for="lp-phone">Téléphone</label>
            <input class="lp-form__input" type="tel" name="phone" id="lp-phone" placeholder="06 00 00 00 00">
          </div>
        </div>
        <div class="lp-form__group">
          <label class="lp-form__label" for="lp-email">Email</label>
          <input class="lp-form__input" type="email" name="email" id="lp-email" placeholder="votre@email.fr" required>
        </div>
        <div class="lp-form__group">
          <label class="lp-form__label" for="lp-enjeu">Enjeu du litige</label>
          <select class="lp-form__input" name="enjeu" id="lp-enjeu" style="-webkit-appearance:none;appearance:none;">
            <option value="">Estimation du montant</option>
            <?php
            $enjeux_list = sg_text('form_enjeux', '50 000 € – 100 000 €,100 000 € – 200 000 €,200 000 € – 500 000 €,Plus de 500 000 €,Je ne connais pas encore le montant');
            foreach (explode(',', $enjeux_list) as $enj) : ?>
              <option><?php echo esc_html(trim($enj)); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="lp-form__group">
          <label class="lp-form__label" for="lp-message">Décrivez votre situation</label>
          <textarea class="lp-form__textarea" name="message" id="lp-message" placeholder="Nature du sinistre, position de votre assureur, délais en cours..."></textarea>
        </div>
        <p class="lp-form__consent">En envoyant ce formulaire, vous acceptez le traitement de vos données conformément à notre <a href="<?php echo sg_page_url('politique-de-confidentialite'); ?>">politique de confidentialité</a>. Vos échanges sont couverts par le secret professionnel.</p>
        <button type="submit" class="lp-form__submit"><?php echo esc_html(sg_text('land_form_submit', 'Envoyer ma demande')); ?></button>
      </form>
    </div>
  </div>
</section>

</main>

<!-- FOOTER -->
<footer class="lp-footer">
  <div class="container lp-footer__inner">
    <span>&copy; <?php echo esc_html(sg_text('site_logo', 'Seri Gueffie')); ?>, <?php echo wp_date('Y'); ?>. <?php echo esc_html(sg_text('land_footer_text', 'Avocat au Barreau de Lyon.')); ?></span>
    <div class="lp-footer__links">
      <a href="<?php echo sg_page_url('mentions-legales'); ?>">Mentions légales</a>
      <a href="<?php echo sg_page_url('politique-de-confidentialite'); ?>">Confidentialité</a>
      <?php if ($li = sg_option('sg_linkedin')) : ?>
        <a href="<?php echo esc_url($li); ?>" target="_blank" rel="noopener">LinkedIn</a>
      <?php endif; ?>
      <?php if ($ig = sg_option('sg_instagram')) : ?>
        <a href="<?php echo esc_url($ig); ?>" target="_blank" rel="noopener">Instagram</a>
      <?php endif; ?>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
