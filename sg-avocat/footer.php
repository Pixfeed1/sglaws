<?php if (!defined('ABSPATH')) exit; ?>
</main>

<footer class="footer">
  <div class="container">
    <div class="footer__top">
      <div>
        <div class="footer__logo"><?php echo esc_html(sg_text('site_logo', 'Seri Gueffie')); ?></div>
        <p class="footer__tagline"><?php echo esc_html(sg_text('footer_tagline', 'Cabinet d\'avocat indépendant. Excellence, engagement et détermination au service de votre défense.')); ?></p>
      </div>
      <div>
        <div class="footer__col-title">Navigation</div>
        <div class="footer__links">
          <?php
          wp_nav_menu([
              'theme_location' => 'primary',
              'container'       => false,
              'items_wrap'      => '%3$s',
              'walker'          => new SG_Footer_Walker(),
              'fallback_cb'     => function() {
                  echo '<a href="' . home_url('/expertise/') . '">Expertise</a>';
                  echo '<a href="' . home_url('/avocat/') . '">Avocat</a>';
                  echo '<a href="' . home_url('/publications/') . '">Publications</a>';
                  echo '<a href="' . home_url('/contact/') . '">Contact</a>';
              },
          ]);
          ?>
        </div>
      </div>
      <div>
        <div class="footer__col-title">Contact</div>
        <div class="footer__contact-info">
          <?php echo sg_option('sg_address', '86, Rue Paul Bert<br>69003 Lyon'); ?><br><br>
          <a href="tel:+33<?php echo preg_replace('/[^0-9]/', '', sg_option('sg_phone', '0481130940')); ?>"><?php echo sg_option('sg_phone', '04 81 13 09 40'); ?></a><br>
          <a href="mailto:<?php echo sg_option('sg_email', 'seri@gueffie.fr'); ?>"><?php echo sg_option('sg_email', 'seri@gueffie.fr'); ?></a>
        </div>
        <div class="footer__social">
          <?php if ($li = sg_option('sg_linkedin')) : ?>
            <a href="<?php echo esc_url($li); ?>" target="_blank" rel="noopener">LinkedIn</a>
          <?php endif; ?>
          <?php if ($ig = sg_option('sg_instagram')) : ?>
            <a href="<?php echo esc_url($ig); ?>" target="_blank" rel="noopener">Instagram</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="footer__bottom">
      <span>&copy; <?php echo esc_html(sg_text('site_logo', 'Seri Gueffie')); ?>, <?php echo wp_date('Y'); ?>. <?php echo esc_html(sg_text('footer_copyright', 'Tous droits réservés.')); ?></span>
      <div class="footer__legal-links">
        <a href="<?php echo sg_page_url('mentions-legales'); ?>">Mentions légales</a>
        <a href="<?php echo sg_page_url('politique-de-confidentialite'); ?>">Politique de confidentialité</a>
      </div>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
