<?php
if (!defined('ABSPATH')) exit;
/**
 * Template: Front Page (Accueil)
 * Faithfully reproduced from index.html
 */
get_header();

$hero_video = get_theme_mod('sg_hero_video', '');
$hero_image = get_theme_mod('sg_hero_image', 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=1920&q=80');
$photo_id = get_theme_mod('sg_photo_avocat', 0);
$photo_url = $photo_id ? wp_get_attachment_image_url($photo_id, 'large') : 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=800&q=80';
?>

<!-- LOADER -->
<div id="loader">
  <div class="loader-monogram"><?php echo esc_html(sg_text('loader_name', 'Me Seri Gueffie')); ?><br><small style="font-size:0.45em;letter-spacing:0.25em;font-family:var(--sans);font-weight:300;opacity:0.6;"><?php echo esc_html(sg_text('loader_sub', 'AVOCAT')); ?></small></div>
  <div class="loader-bar"></div>
</div>

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
  <div class="container hero__content">
    <div style="margin-bottom: clamp(3rem, 6vh, 5rem);">
      <h1 class="hero__logo-text">
        <span class="lr"><span><?php echo esc_html(sg_text('home_hero_l1', 'Seri Gueffie')); ?></span></span>
      </h1>
      <div class="hero__baseline">
        <span class="lr"><span><?php echo esc_html(sg_text('home_hero_tag', 'Avocat au Barreau de Lyon')); ?></span></span>
      </div>
    </div>
    <p class="hero__intro r"><?php echo esc_html(sg_text('home_hero_intro', 'Une approche rigoureuse, humaine et déterminée au service de la défense de vos droits et de vos intérêts.')); ?></p>
  </div>
  <div class="hero__scroll">
    <span class="hero__scroll-text">Scroll</span>
    <span class="hero__scroll-line"></span>
  </div>
</section>

<!-- ABOUT -->
<section class="about" id="about">
  <div class="container">
    <span class="section-tag r"><?php echo esc_html(sg_text('home_about_tag', 'Le Cabinet')); ?></span>
    <p class="about__intro r"><?php echo wp_kses_post(sg_text('home_about_intro', 'Le cabinet de Me Seri Gueffie est une structure indépendante dédiée à la défense et au conseil juridique. Chaque client bénéficie d\'un accompagnement <em>global, personnalisé et confidentiel</em>, avec une exigence constante d\'efficacité et de résultat.')); ?></p>
  </div>
</section>

<!-- VALUES -->
<section class="values-row">
  <div class="container">
    <div class="values-row__inner">
      <span class="values-row__word r"><?php echo esc_html(sg_text('home_value1', 'Excellence')); ?></span>
      <span class="values-row__word r"><?php echo esc_html(sg_text('home_value2', 'Détermination')); ?></span>
      <span class="values-row__word r"><?php echo esc_html(sg_text('home_value3', 'Intégrité')); ?></span>
      <span class="values-row__word r"><?php echo esc_html(sg_text('home_value4', 'Réactivité')); ?></span>
      <span class="values-row__word r"><?php echo esc_html(sg_text('home_value5', 'Engagement')); ?></span>
    </div>
  </div>
</section>

<!-- DESC -->
<section class="desc">
  <div class="container">
    <div class="desc__grid">
      <div class="desc__text r">
        <p><?php echo esc_html(sg_text('home_desc1', 'Maîtrise du dossier, sauvegarde des intérêts, pragmatisme du conseil et de la défense : le cabinet est animé par une exigence d\'efficacité au service de clients en prise avec des enjeux personnels et professionnels sensibles.')); ?></p>
      </div>
      <div class="desc__text r">
        <p><?php echo esc_html(sg_text('home_desc2', 'Le cabinet accorde une importance capitale à la compréhension de la situation de chaque client pour mieux appréhender les enjeux et les défis auxquels il fait face, avec rigueur et humanité.')); ?></p>
      </div>
    </div>
  </div>
</section>

<!-- AVOCAT -->
<section class="team" id="avocat">
  <div class="container">
    <div class="team__header">
      <span class="section-tag r"><?php echo esc_html(sg_text('home_avocat_tag', 'Avocat')); ?></span>
    </div>
    <div class="team__card">
      <div class="team__photo r">
        <img src="<?php echo esc_url($photo_url); ?>" alt="Me Seri Gueffie" loading="lazy">
      </div>
      <div class="team__info">
        <h2 class="team__name">
          <span class="lr"><span><?php echo esc_html(sg_text('avocat_prenom', 'Me Seri')); ?></span></span>
          <span class="lr"><span><?php echo esc_html(sg_text('avocat_nom', 'Gueffie')); ?></span></span>
        </h2>
        <p class="team__role r"><?php echo esc_html(sg_text('avocat_subtitle', 'Avocat au Barreau de Lyon')); ?></p>
        <div class="team__bio r">
          <?php echo wp_kses_post(sg_text('avocat_bio', '<p>Passionné par le droit et animé par un sens profond de la justice, Me Seri Gueffie met son expertise au service de clients confrontés à des enjeux juridiques complexes.</p><p>Son approche allie rigueur analytique et vision stratégique, avec une attention constante portée à la dimension humaine de chaque affaire.</p>')); ?>
        </div>
        <div class="team__meta r">
          <div class="team__meta-row">
            <span class="team__meta-label">Formation</span>
            <span class="team__meta-value"><?php echo esc_html(sg_text('avocat_formation', 'Master en Droit — Université de Paris')); ?></span>
          </div>
          <div class="team__meta-row">
            <span class="team__meta-label">Barreau</span>
            <span class="team__meta-value"><?php echo esc_html(sg_text('avocat_barreau', 'Barreau de Lyon')); ?></span>
          </div>
          <div class="team__meta-row">
            <span class="team__meta-label">Langues</span>
            <span class="team__meta-value"><?php echo esc_html(sg_text('avocat_langues', 'Français, Anglais')); ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- EXPERTISE -->
<section class="expertise" id="expertise">
  <div class="container">
    <div class="expertise__header">
      <div>
        <span class="section-tag section-tag--light r"><?php echo esc_html(sg_text('home_exp_tag', 'Expertise')); ?></span>
        <h2 class="expertise__heading r"><?php echo esc_html(sg_text('home_exp_title', 'Domaines d\'intervention')); ?></h2>
      </div>
      <p class="expertise__intro r"><?php echo esc_html(sg_text('home_exp_intro', 'Le cabinet déploie ses compétences pour la protection des intérêts de ses clients dans l\'ensemble des domaines du droit, avec une exigence constante d\'efficacité.')); ?></p>
    </div>
    <div class="expertise__list">
      <?php
      $domains = [
          ['Droit Pénal', 'Défense pénale à tous les stades de la procédure. Garde à vue, instruction, audience correctionnelle et criminelle.'],
          ['Droit de la Famille', 'Divorce, séparation, garde d\'enfants, pension alimentaire, prestation compensatoire, succession.'],
          ['Droit des Affaires', 'Conseil et contentieux commercial, droit des sociétés, litiges entre associés, contentieux contractuels.'],
          ['Droit du Travail', 'Défense salariés et employeurs. Licenciement, harcèlement, rupture conventionnelle, prud\'hommes.'],
          ['Droit Immobilier', 'Litiges locatifs, copropriété, vices cachés, troubles de voisinage, contentieux immobilier.'],
          ['Droit des Étrangers', 'Titres de séjour, asile, régularisation, recours administratifs, contentieux CNDA et tribunal administratif.'],
      ];
      $detail_url = home_url('/expertise-detail/');
      foreach ($domains as $i => $d) :
          $num = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
          $title = sg_text("exp_d" . ($i+1) . "_title", $d[0]);
          $desc = sg_text("exp_d" . ($i+1) . "_desc", $d[1]);
          $anchor = sanitize_title($title);
      ?>
        <a href="<?php echo esc_url($detail_url . '#' . $anchor); ?>" class="expertise__item r" style="text-decoration:none;color:inherit;">
          <span class="expertise__num"><?php echo $num; ?></span>
          <h3 class="expertise__title"><?php echo esc_html($title); ?></h3>
          <p class="expertise__desc"><?php echo esc_html($desc); ?></p>
          <span class="expertise__arrow">↗</span>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- PUBLICATIONS -->
<section class="publications" id="publications">
  <div class="container">
    <div class="publications__header">
      <div>
        <span class="section-tag r"><?php echo esc_html(sg_text('home_pub_tag', 'Publications')); ?></span>
        <h2 class="publications__heading r"><?php echo esc_html(sg_text('home_pub_title', 'Articles & Publications')); ?></h2>
      </div>
      <a href="<?php echo home_url('/publications/'); ?>" class="publications__more r"><?php echo esc_html(sg_text('home_pub_more', 'Voir tout ↗')); ?></a>
    </div>
    <div class="publications__list">
      <?php
      $pubs = new WP_Query(['post_type' => 'post', 'posts_per_page' => 4, 'orderby' => 'date', 'order' => 'DESC']);
      if ($pubs->have_posts()) : while ($pubs->have_posts()) : $pubs->the_post();
          $pdf_url = get_post_meta(get_the_ID(), '_sg_pdf_url', true);
      ?>
        <a href="<?php the_permalink(); ?>" class="pub-item r">
          <span class="pub-item__date"><?php echo get_the_date('d.m.Y'); ?></span>
          <span class="pub-item__title"><?php the_title(); ?></span>
          <span class="pub-item__download">Lire →</span>
        </a>
      <?php endwhile; wp_reset_postdata(); endif; ?>
    </div>
  </div>
</section>

<!-- CONTACT -->
<section class="contact" id="contact">
  <div class="container">
    <div class="contact__grid">
      <div>
        <span class="section-tag r"><?php echo esc_html(sg_text('home_contact_tag', 'Contact')); ?></span>
        <h2 class="contact__heading r"><?php echo wp_kses_post(sg_text('home_contact_title', 'Prenons<br><em>rendez-vous</em>')); ?></h2>
        <p class="contact__text r"><?php echo esc_html(sg_text('home_contact_text', 'Pour toute demande de consultation ou d\'information, n\'hésitez pas à contacter le cabinet. Chaque situation mérite une attention particulière.')); ?></p>
        <div class="contact__infos r">
          <div class="contact__info-group">
            <span class="contact__info-label">Adresse</span>
            <span class="contact__info-value"><?php echo sg_option('sg_address', '86, Rue Paul Bert<br>69003 Lyon'); ?></span>
          </div>
          <div class="contact__info-group">
            <span class="contact__info-label">Téléphone</span>
            <span class="contact__info-value"><a href="tel:+33<?php echo preg_replace('/[^0-9]/', '', sg_option('sg_phone')); ?>"><?php echo sg_option('sg_phone', '04 81 13 09 40'); ?></a></span>
          </div>
          <div class="contact__info-group">
            <span class="contact__info-label">Email</span>
            <span class="contact__info-value"><a href="mailto:<?php echo sg_option('sg_email', 'seri@gueffie.fr'); ?>"><?php echo sg_option('sg_email', 'seri@gueffie.fr'); ?></a></span>
          </div>
        </div>
      </div>
      <form class="form r" id="sg-contact-form" method="post">
        <input type="hidden" name="source" value="accueil">
        <div aria-hidden="true" style="position:absolute;left:-9999px;"><label for="sg_hp_field" class="sr-only">Ne pas remplir</label><input type="text" name="sg_hp" id="sg_hp_field" tabindex="-1" autocomplete="off"></div>
        <div class="form__row">
          <div class="form__group">
            <label class="form__label" for="sg-name">Nom</label>
            <input class="form__input" type="text" name="name" id="sg-name" placeholder="Votre nom" required>
          </div>
          <div class="form__group">
            <label class="form__label" for="sg-prenom">Prénom</label>
            <input class="form__input" type="text" name="prenom" id="sg-prenom" placeholder="Votre prénom">
          </div>
        </div>
        <div class="form__row">
          <div class="form__group">
            <label class="form__label" for="sg-email">Email</label>
            <input class="form__input" type="email" name="email" id="sg-email" placeholder="votre@email.fr" required>
          </div>
          <div class="form__group">
            <label class="form__label" for="sg-phone">Téléphone</label>
            <input class="form__input" type="tel" name="phone" id="sg-phone" placeholder="06 00 00 00 00">
          </div>
        </div>
        <div class="form__group">
          <label class="form__label" for="sg-domain">Domaine</label>
          <select class="form__select" name="domain" id="sg-domain">
            <option value="">Sélectionnez un domaine</option>
            <?php
            $domains_list = sg_text('form_domains', 'Droit Pénal,Droit de la Famille,Droit des Affaires,Droit du Travail,Droit Immobilier,Droit des Étrangers,Autre');
            foreach (explode(',', $domains_list) as $dom) : ?>
              <option><?php echo esc_html(trim($dom)); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form__group">
          <label class="form__label" for="sg-enjeu">Enjeu du litige</label>
          <select class="form__select" name="enjeu" id="sg-enjeu">
            <option value="">Estimation du montant</option>
            <?php
            $enjeux_list = sg_text('form_enjeux', '50 000 € – 100 000 €,100 000 € – 200 000 €,200 000 € – 500 000 €,Plus de 500 000 €,Je ne connais pas encore le montant');
            foreach (explode(',', $enjeux_list) as $enj) : ?>
              <option><?php echo esc_html(trim($enj)); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form__group">
          <label class="form__label" for="sg-message">Message</label>
          <textarea class="form__textarea" name="message" id="sg-message" placeholder="Décrivez brièvement votre situation..."></textarea>
        </div>
        <p class="form__consent"><?php echo wp_kses_post(sg_text('home_contact_rgpd', 'En envoyant ce formulaire, vous acceptez la collecte de vos données personnelles aux fins de traitement de votre demande, conformément à notre <a href="' . sg_page_url('politique-de-confidentialite') . '">politique de confidentialité</a>.')); ?></p>
        <button type="submit" class="form__submit"><?php echo esc_html(sg_text('form_submit', 'Envoyer')); ?></button>
      </form>
    </div>
  </div>
</section>

<?php get_footer(); ?>
