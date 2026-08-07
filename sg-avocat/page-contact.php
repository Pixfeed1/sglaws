<?php
if (!defined('ABSPATH')) exit;
/* Template Name: Contact */
get_header(); ?>

<div class="page-header">
  <div class="container">
    <span class="section-tag r">Contact</span>
    <h1 class="page-header__title">
      <span class="lr"><span>Prenons</span></span>
      <span class="lr"><span><em>rendez-vous</em></span></span>
    </h1>
  </div>
</div>

<section class="contact" style="padding-top: clamp(50px, 6vh, 80px); background: var(--white);">
  <div class="container">
    <div class="contact__grid">
      <div>
        <p class="contact__text r"><?php echo esc_html(sg_text('contact_intro', 'Pour toute demande de consultation ou d\'information, n\'hésitez pas à contacter le cabinet. Chaque situation mérite une attention particulière.')); ?></p>
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
        <input type="hidden" name="source" value="contact">
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
