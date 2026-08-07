<?php
if (!defined('ABSPATH')) exit;
/**
 * Admin — Textes du site
 * @package SG_Avocat
 */

add_action('admin_menu', function () {
    add_menu_page(
        'Textes du site',
        'Textes du site',
        'edit_theme_options',
        'sg-textes',
        'sg_render_textes_page',
        'dashicons-edit-page',
        30
    );
});

add_action('admin_init', function () {
    register_setting('sg_textes_group', 'sg_site_texts', [
        'type'              => 'array',
        'sanitize_callback' => 'sg_sanitize_texts',
    ]);
});

function sg_sanitize_texts($input) {
    $clean = [];
    if (is_array($input)) {
        foreach ($input as $key => $value) {
            $clean[sanitize_key($key)] = wp_kses_post($value);
        }
    }
    return $clean;
}

function sg_render_textes_page() {
    $texts = get_option('sg_site_texts', []);
    $t = function ($key, $default = '') use ($texts) {
        return isset($texts[$key]) && $texts[$key] !== '' ? esc_attr($texts[$key]) : esc_attr($default);
    };
    $ta = function ($key, $default = '') use ($texts) {
        return isset($texts[$key]) && $texts[$key] !== '' ? esc_textarea($texts[$key]) : esc_textarea($default);
    };

    if (isset($_GET['settings-updated']) && $_GET['settings-updated'] === 'true') {
        echo '<div class="notice notice-success is-dismissible"><p>Modifications enregistrées.</p></div>';
    }
    ?>
    <div class="wrap">
        <h1>Textes du site</h1>
        <p class="description">Modifiez les textes affichés sur chaque page. Les modifications sont visibles immédiatement.</p>

        <form method="post" action="options.php">
            <?php settings_fields('sg_textes_group'); ?>

            <h2 class="nav-tab-wrapper">
                <a href="#tab-general" class="nav-tab nav-tab-active" data-tab="general" onclick="sgTab(event,this,'general')">Général</a>
                <a href="#tab-accueil" class="nav-tab" data-tab="accueil" onclick="sgTab(event,this,'accueil')">Accueil</a>
                <a href="#tab-landing" class="nav-tab" data-tab="landing" onclick="sgTab(event,this,'landing')">Landing</a>
                <a href="#tab-expertise" class="nav-tab" data-tab="expertise" onclick="sgTab(event,this,'expertise')">Expertise</a>
                <a href="#tab-avocat" class="nav-tab" data-tab="avocat" onclick="sgTab(event,this,'avocat')">Avocat</a>
                <a href="#tab-contact" class="nav-tab" data-tab="contact" onclick="sgTab(event,this,'contact')">Contact</a>
                <a href="#tab-articles" class="nav-tab" data-tab="articles" onclick="sgTab(event,this,'articles')">Articles</a>
                <a href="#tab-404" class="nav-tab" data-tab="404" onclick="sgTab(event,this,'404')">404</a>
            </h2>

            <!-- GÉNÉRAL -->
            <div id="sg-tab-general" class="sg-tab-content" style="display:block;">
                <h3>Identité du site</h3>
                <table class="form-table">
                    <tr><th>Nom du cabinet (logo)</th><td><input type="text" name="sg_site_texts[site_logo]" value="<?php echo $t('site_logo', 'Seri Gueffie'); ?>" class="regular-text"><p class="description">Affiché dans le header, le footer et le loader.</p></td></tr>
                    <tr><th>Tagline footer</th><td><textarea name="sg_site_texts[footer_tagline]" rows="2" class="large-text"><?php echo $ta('footer_tagline', 'Cabinet d\'avocat indépendant. Excellence, engagement et détermination au service de votre défense.'); ?></textarea></td></tr>
                    <tr><th>Copyright</th><td><input type="text" name="sg_site_texts[footer_copyright]" value="<?php echo $t('footer_copyright', 'Tous droits réservés.'); ?>" class="regular-text"></td></tr>
                </table>

                <h3>Loader (page d'accueil)</h3>
                <table class="form-table">
                    <tr><th>Nom affiché</th><td><input type="text" name="sg_site_texts[loader_name]" value="<?php echo $t('loader_name', 'Me Seri Gueffie'); ?>" class="regular-text"></td></tr>
                    <tr><th>Sous-texte</th><td><input type="text" name="sg_site_texts[loader_sub]" value="<?php echo $t('loader_sub', 'AVOCAT'); ?>" class="regular-text"></td></tr>
                </table>

            </div>

            <!-- ACCUEIL -->
            <div id="sg-tab-accueil" class="sg-tab-content" style="display:none;">
                <h3>Hero</h3>
                <table class="form-table">
                    <tr><th>Sous-titre</th><td><input type="text" name="sg_site_texts[home_hero_tag]" value="<?php echo $t('home_hero_tag', 'Avocat au Barreau de Lyon'); ?>" class="large-text"></td></tr>
                    <tr><th>Titre principal</th><td><input type="text" name="sg_site_texts[home_hero_l1]" value="<?php echo $t('home_hero_l1', 'Seri Gueffie'); ?>" class="large-text"><p class="description">C'est le titre H1 du site. Il est affiché en grand sur une seule ligne, à la manière d'un logo.</p></td></tr>
                    <tr><th>Introduction</th><td><textarea name="sg_site_texts[home_hero_intro]" rows="3" class="large-text"><?php echo $ta('home_hero_intro', 'Une approche rigoureuse, humaine et déterminée au service de la défense de vos droits et de vos intérêts.'); ?></textarea></td></tr>
                </table>

                <h3>Section Expertise</h3>
                <table class="form-table">
                    <tr><th>Tag</th><td><input type="text" name="sg_site_texts[home_exp_tag]" value="<?php echo $t('home_exp_tag', 'Expertise'); ?>" class="regular-text"></td></tr>
                    <tr><th>Titre</th><td><input type="text" name="sg_site_texts[home_exp_title]" value="<?php echo $t('home_exp_title', 'Domaines d\'intervention'); ?>" class="large-text"></td></tr>
                    <tr><th>Introduction</th><td><textarea name="sg_site_texts[home_exp_intro]" rows="2" class="large-text"><?php echo $ta('home_exp_intro', 'Le cabinet déploie ses compétences pour la protection des intérêts de ses clients dans l\'ensemble des domaines du droit, avec une exigence constante d\'efficacité.'); ?></textarea></td></tr>
                </table>

                <h3>Section Contact</h3>
                <table class="form-table">
                    <tr><th>Titre</th><td><input type="text" name="sg_site_texts[home_contact_title]" value="<?php echo $t('home_contact_title', 'Prenons<br><em>rendez-vous</em>'); ?>" class="large-text"><p class="description">Balises autorisées : &lt;br&gt; pour passer à la ligne, &lt;em&gt; pour l'italique.</p></td></tr>
                    <tr><th>Texte</th><td><textarea name="sg_site_texts[home_contact_text]" rows="2" class="large-text"><?php echo $ta('home_contact_text', 'Pour toute demande de consultation ou d\'information, n\'hésitez pas à contacter le cabinet. Chaque situation mérite une attention particulière.'); ?></textarea></td></tr>
                    <tr><th>Consentement RGPD</th><td><textarea name="sg_site_texts[home_contact_rgpd]" rows="2" class="large-text"><?php echo $ta('home_contact_rgpd', 'En envoyant ce formulaire, vous acceptez le traitement de vos données conformément à notre politique de confidentialité.'); ?></textarea><p class="description">Balise &lt;a href="..."&gt; autorisée pour le lien vers la politique de confidentialité.</p></td></tr>
                </table>

                <h3>Valeurs</h3>
                <table class="form-table">
                    <tr><th>Valeur 1</th><td><input type="text" name="sg_site_texts[home_value1]" value="<?php echo $t('home_value1', 'Excellence'); ?>" class="regular-text"></td></tr>
                    <tr><th>Valeur 2</th><td><input type="text" name="sg_site_texts[home_value2]" value="<?php echo $t('home_value2', 'Détermination'); ?>" class="regular-text"></td></tr>
                    <tr><th>Valeur 3</th><td><input type="text" name="sg_site_texts[home_value3]" value="<?php echo $t('home_value3', 'Intégrité'); ?>" class="regular-text"></td></tr>
                    <tr><th>Valeur 4</th><td><input type="text" name="sg_site_texts[home_value4]" value="<?php echo $t('home_value4', 'Réactivité'); ?>" class="regular-text"></td></tr>
                    <tr><th>Valeur 5</th><td><input type="text" name="sg_site_texts[home_value5]" value="<?php echo $t('home_value5', 'Engagement'); ?>" class="regular-text"></td></tr>
                </table>

                <h3>Section Le Cabinet</h3>
                <table class="form-table">
                    <tr><th>Tag</th><td><input type="text" name="sg_site_texts[home_about_tag]" value="<?php echo $t('home_about_tag', 'Le Cabinet'); ?>" class="regular-text"></td></tr>
                    <tr><th>Introduction</th><td><textarea name="sg_site_texts[home_about_intro]" rows="3" class="large-text"><?php echo $ta('home_about_intro', 'Le cabinet de Me Seri Gueffie est une structure indépendante dédiée à la défense et au conseil juridique. Chaque client bénéficie d\'un accompagnement <em>global, personnalisé et confidentiel</em>, avec une exigence constante d\'efficacité et de résultat.'); ?></textarea><p class="description">Balises HTML autorisées : &lt;em&gt; pour l'italique.</p></td></tr>
                </table>

                <h3>Section Description</h3>
                <table class="form-table">
                    <tr><th>Texte colonne 1</th><td><textarea name="sg_site_texts[home_desc1]" rows="3" class="large-text"><?php echo $ta('home_desc1', 'Maîtrise du dossier, sauvegarde des intérêts, pragmatisme du conseil et de la défense : le cabinet est animé par une exigence d\'efficacité au service de clients en prise avec des enjeux personnels et professionnels sensibles.'); ?></textarea></td></tr>
                    <tr><th>Texte colonne 2</th><td><textarea name="sg_site_texts[home_desc2]" rows="3" class="large-text"><?php echo $ta('home_desc2', 'Le cabinet accorde une importance capitale à la compréhension de la situation de chaque client pour mieux appréhender les enjeux et les défis auxquels il fait face, avec rigueur et humanité.'); ?></textarea></td></tr>
                </table>

                <h3>Section Publications</h3>
                <table class="form-table">
                    <tr><th>Tag</th><td><input type="text" name="sg_site_texts[home_pub_tag]" value="<?php echo $t('home_pub_tag', 'Publications'); ?>" class="regular-text"></td></tr>
                    <tr><th>Titre</th><td><input type="text" name="sg_site_texts[home_pub_title]" value="<?php echo $t('home_pub_title', 'Articles & Publications'); ?>" class="large-text"><p class="description">Titre de l'encadré sur la page d'accueil. Le titre de la page Publications elle-même se règle dans l'onglet Articles.</p></td></tr>
                    <tr><th>Lien "Voir tout"</th><td><input type="text" name="sg_site_texts[home_pub_more]" value="<?php echo $t('home_pub_more', 'Voir tout ↗'); ?>" class="regular-text"></td></tr>
                </table>

                <h3>Section Avocat (aperçu)</h3>
                <table class="form-table">
                    <tr><th>Tag</th><td><input type="text" name="sg_site_texts[home_avocat_tag]" value="<?php echo $t('home_avocat_tag', 'Avocat'); ?>" class="regular-text"></td></tr>
                    <tr><th>Tag Contact</th><td><input type="text" name="sg_site_texts[home_contact_tag]" value="<?php echo $t('home_contact_tag', 'Contact'); ?>" class="regular-text"></td></tr>
                </table>
            </div>

            <!-- LANDING -->
            <div id="sg-tab-landing" class="sg-tab-content" style="display:none;">
                <h3>Hero</h3>
                <table class="form-table">
                    <tr><th>Tag</th><td><input type="text" name="sg_site_texts[land_hero_tag]" value="<?php echo $t('land_hero_tag', 'Avocat en droit des assurances · Lyon'); ?>" class="large-text"></td></tr>
                    <tr><th>Titre ligne 1</th><td><input type="text" name="sg_site_texts[land_hero_l1]" value="<?php echo $t('land_hero_l1', 'Votre assureur refuse'); ?>" class="large-text"></td></tr>
                    <tr><th>Titre ligne 2</th><td><input type="text" name="sg_site_texts[land_hero_l2]" value="<?php echo $t('land_hero_l2', 'de vous <em>indemniser ?</em>'); ?>" class="large-text"><p class="description">Balise &lt;em&gt; pour l'italique.</p></td></tr>
                    <tr><th>Sous-titre</th><td><textarea name="sg_site_texts[land_hero_sub]" rows="3" class="large-text"><?php echo $ta('land_hero_sub', 'Sinistre contesté, garantie refusée, indemnisation insuffisante — Me Seri Gueffie défend vos droits face aux compagnies d\'assurance.'); ?></textarea></td></tr>
                </table>

                <h3>Barre de confiance</h3>
                <table class="form-table">
                    <?php for ($i = 1; $i <= 3; $i++) : ?>
                    <tr>
                        <th>Chiffre <?php echo $i; ?></th>
                        <td>
                            <input type="text" name="sg_site_texts[land_trust_num<?php echo $i; ?>]" value="<?php echo $t("land_trust_num$i", $i === 1 ? '100%' : ($i === 2 ? 'Lyon' : 'Sur mesure')); ?>" class="regular-text">
                            <input type="text" name="sg_site_texts[land_trust_label<?php echo $i; ?>]" value="<?php echo $t("land_trust_label$i", $i === 1 ? 'Dédié aux assurances' : ($i === 2 ? 'Barreau de Lyon' : 'Stratégie personnalisée')); ?>" class="regular-text">
                        </td>
                    </tr>
                    <?php endfor; ?>
                </table>

                <h3>Situations fréquentes (pain points)</h3>
                <table class="form-table">
                    <tr><th>Tag</th><td><input type="text" name="sg_site_texts[land_problems_tag]" value="<?php echo $t('land_problems_tag', 'Situations fréquentes'); ?>" class="regular-text"></td></tr>
                    <tr><th>Titre</th><td><input type="text" name="sg_site_texts[land_problems_title]" value="<?php echo $t('land_problems_title', 'Vous faites face à un litige avec votre <em>assureur ?</em>'); ?>" class="large-text"><p class="description">Balise &lt;em&gt; pour l'italique.</p></td></tr>
                </table>
                <?php
                $default_problems = [
                    'Refus d\'indemnisation', 'Indemnisation insuffisante', 'Sinistre décennal contesté',
                    'Sinistre industriel', 'Responsabilité professionnelle', 'Catastrophe naturelle',
                ];
                for ($i = 1; $i <= 6; $i++) : ?>
                <table class="form-table">
                    <tr><th>Carte <?php echo $i; ?> — Titre</th><td><input type="text" name="sg_site_texts[land_problem<?php echo $i; ?>_title]" value="<?php echo $t("land_problem{$i}_title", $default_problems[$i-1]); ?>" class="regular-text"></td></tr>
                    <tr><th>Carte <?php echo $i; ?> — Texte</th><td><textarea name="sg_site_texts[land_problem<?php echo $i; ?>_text]" rows="2" class="large-text"><?php echo $ta("land_problem{$i}_text"); ?></textarea></td></tr>
                </table>
                <?php endfor; ?>

                <h3>Expertise (fond noir)</h3>
                <table class="form-table">
                    <tr><th>Titre</th><td><input type="text" name="sg_site_texts[land_exp_title]" value="<?php echo $t('land_exp_title', 'Une pratique <em>exclusivement</em> dédiée au droit des assurances'); ?>" class="large-text"><p class="description">Balise &lt;em&gt; pour l'italique. La liste des domaines est reprise de l'onglet Expertise.</p></td></tr>
                    <tr><th>Texte</th><td><textarea name="sg_site_texts[land_exp_text]" rows="3" class="large-text"><?php echo $ta('land_exp_text', 'Me Seri Gueffie consacre l\'intégralité de son activité au droit des assurances. Cette spécialisation exclusive garantit une maîtrise approfondie des mécanismes assurantiels, de la jurisprudence applicable et des stratégies de défense les plus efficaces.'); ?></textarea></td></tr>
                </table>

                <h3>Approche (3 étapes)</h3>
                <table class="form-table">
                    <tr><th>Tag</th><td><input type="text" name="sg_site_texts[land_approach_tag]" value="<?php echo $t('land_approach_tag', 'Approche'); ?>" class="regular-text"></td></tr>
                    <tr><th>Titre</th><td><input type="text" name="sg_site_texts[land_approach_title]" value="<?php echo $t('land_approach_title', 'Comment se déroule votre accompagnement'); ?>" class="large-text"></td></tr>
                    <tr><th>Sous-titre</th><td><input type="text" name="sg_site_texts[land_approach_sub]" value="<?php echo $t('land_approach_sub', 'Une méthode rigoureuse pour maximiser vos chances de succès.'); ?>" class="large-text"></td></tr>
                </table>
                <?php
                $default_steps = ['Analyse du dossier', 'Stratégie & négociation', 'Action contentieuse'];
                for ($i = 1; $i <= 3; $i++) : ?>
                <table class="form-table">
                    <tr><th>Étape <?php echo $i; ?> — Titre</th><td><input type="text" name="sg_site_texts[land_step<?php echo $i; ?>_title]" value="<?php echo $t("land_step{$i}_title", $default_steps[$i-1]); ?>" class="regular-text"></td></tr>
                    <tr><th>Étape <?php echo $i; ?> — Texte</th><td><textarea name="sg_site_texts[land_step<?php echo $i; ?>_text]" rows="2" class="large-text"><?php echo $ta("land_step{$i}_text"); ?></textarea></td></tr>
                </table>
                <?php endfor; ?>

                <h3>Section Contact (landing)</h3>
                <table class="form-table">
                    <tr><th>Titre</th><td><input type="text" name="sg_site_texts[land_contact_title]" value="<?php echo $t('land_contact_title', 'Défendons vos<br><em>intérêts</em>'); ?>" class="large-text"><p class="description">Balises autorisées : &lt;br&gt; pour passer à la ligne, &lt;em&gt; pour l'italique.</p></td></tr>
                    <tr><th>Texte</th><td><textarea name="sg_site_texts[land_contact_text]" rows="2" class="large-text"><?php echo $ta('land_contact_text', 'Chaque situation mérite une analyse approfondie. Prenez rendez-vous pour une première consultation et exposez votre dossier en toute confidentialité.'); ?></textarea></td></tr>
                </table>

                <h3>Boutons et libellés</h3>
                <table class="form-table">
                    <tr><th>URL prise de rendez-vous</th><td><input type="text" name="sg_site_texts[land_rdv_url]" value="<?php echo $t('land_rdv_url', '#contact'); ?>" class="large-text" placeholder="https://calendly.com/..."><p class="description">URL Calendly ou autre. Mettez <code>#contact</code> pour scroller vers le formulaire de la page.</p></td></tr>
                    <tr><th>Bouton principal (hero)</th><td><input type="text" name="sg_site_texts[land_btn1]" value="<?php echo $t('land_btn1', 'Prendre rendez-vous'); ?>" class="regular-text"></td></tr>
                    <tr><th>Bouton secondaire (hero)</th><td><input type="text" name="sg_site_texts[land_btn2]" value="<?php echo $t('land_btn2', 'Découvrir l\'expertise'); ?>" class="regular-text"></td></tr>
                    <tr><th>Bouton topbar</th><td><input type="text" name="sg_site_texts[land_topbar_cta]" value="<?php echo $t('land_topbar_cta', 'Consultation'); ?>" class="regular-text"></td></tr>
                    <tr><th>Bouton formulaire</th><td><input type="text" name="sg_site_texts[land_form_submit]" value="<?php echo $t('land_form_submit', 'Envoyer ma demande'); ?>" class="regular-text"></td></tr>
                    <tr><th>Texte footer landing</th><td><input type="text" name="sg_site_texts[land_footer_text]" value="<?php echo $t('land_footer_text', 'Avocat au Barreau de Lyon.'); ?>" class="large-text"></td></tr>
                </table>
            </div>

            <!-- EXPERTISE -->
            <div id="sg-tab-expertise" class="sg-tab-content" style="display:none;">
                <h3>Page liste</h3>
                <table class="form-table">
                    <tr><th>Introduction</th><td><textarea name="sg_site_texts[exp_intro]" rows="2" class="large-text"><?php echo $ta('exp_intro', 'Le cabinet déploie ses compétences pour la protection des intérêts de ses clients dans l\'ensemble des domaines du droit, avec une exigence constante d\'efficacité.'); ?></textarea></td></tr>
                </table>
                <?php for ($i = 1; $i <= SG_MAX_EXPERTISES; $i++) : ?>
                <h3>Domaine <?php echo $i; ?><?php echo $i > 6 ? ' (facultatif)' : ''; ?></h3>
                <table class="form-table">
                    <tr><th>Titre</th><td><input type="text" name="sg_site_texts[exp_d<?php echo $i; ?>_title]" value="<?php echo $t("exp_d{$i}_title"); ?>" class="large-text"><p class="description">Ce titre est utilisé sur la page liste ET la page détail.</p></td></tr>
                    <tr><th>Description (liste)</th><td><textarea name="sg_site_texts[exp_d<?php echo $i; ?>_desc]" rows="2" class="large-text"><?php echo $ta("exp_d{$i}_desc"); ?></textarea></td></tr>
                    <tr><th>Page liée</th><td>
                        <?php wp_dropdown_pages([
                            'name'              => "sg_site_texts[exp_d{$i}_page]",
                            'selected'          => (int) ($texts["exp_d{$i}_page"] ?? 0),
                            'show_option_none'  => '— Page par défaut —',
                            'option_none_value' => '0',
                            'post_status'       => ['publish', 'draft'],
                        ]); ?>
                        <p class="description">Page ouverte par cette carte, sur l'accueil et la page Expertise. Si vous réordonnez les domaines, pensez à réaffecter la page.</p>
                    </td></tr>
                </table>
                <?php endfor; ?>

                <hr style="margin:2rem 0;">
                <h3>Page détail</h3>
                <table class="form-table">
                    <tr><th>Titre ligne 1</th><td><input type="text" name="sg_site_texts[exp_detail_title_l1]" value="<?php echo $t('exp_detail_title_l1', 'Domaines'); ?>" class="regular-text"></td></tr>
                    <tr><th>Titre ligne 2</th><td><input type="text" name="sg_site_texts[exp_detail_title_l2]" value="<?php echo $t('exp_detail_title_l2', 'd\'intervention'); ?>" class="regular-text"></td></tr>
                    <tr><th>Lien retour</th><td><input type="text" name="sg_site_texts[exp_detail_back]" value="<?php echo $t('exp_detail_back', '← Retour aux domaines'); ?>" class="regular-text"></td></tr>
                </table>

                <?php
                $detail_domains = [
                    'droit_penal' => ['label' => '01 — Droit Pénal', 'default_title' => 'Droit <em>Pénal</em>'],
                    'droit_famille' => ['label' => '02 — Droit de la Famille', 'default_title' => 'Droit de la <em>Famille</em>'],
                    'droit_affaires' => ['label' => '03 — Droit des Affaires', 'default_title' => 'Droit des <em>Affaires</em>'],
                    'droit_travail' => ['label' => '04 — Droit du Travail', 'default_title' => 'Droit du <em>Travail</em>'],
                    'droit_immobilier' => ['label' => '05 — Droit Immobilier', 'default_title' => 'Droit <em>Immobilier</em>'],
                    'droit_etrangers' => ['label' => '06 — Droit des Étrangers', 'default_title' => 'Droit des <em>Étrangers</em>'],
                ];
                foreach ($detail_domains as $key => $d) :
                    $field_key = "exp_detail_{$key}_text";
                    $field_value = isset($texts[$field_key]) && $texts[$field_key] !== '' ? $texts[$field_key] : '';
                    $saved_title = isset($texts["exp_detail_{$key}_title"]) && $texts["exp_detail_{$key}_title"] !== '' ? wp_strip_all_tags($texts["exp_detail_{$key}_title"]) : wp_strip_all_tags($d['default_title']);
                ?>
                <h3><?php echo esc_html($d['num'] ?? substr($d['label'], 0, 2)); ?> — <?php echo esc_html($saved_title); ?> — Détail</h3>
                <table class="form-table">
                    <tr><th>Titre</th><td><input type="text" name="sg_site_texts[exp_detail_<?php echo $key; ?>_title]" value="<?php echo $t("exp_detail_{$key}_title", $d['default_title']); ?>" class="large-text"><p class="description">Balise &lt;em&gt; pour l'italique. Ex : Droit &lt;em&gt;Pénal&lt;/em&gt;</p></td></tr>
                    <tr><th>Texte complet</th><td>
                        <?php wp_editor($field_value, 'sg_editor_' . $key, [
                            'textarea_name' => "sg_site_texts[$field_key]",
                            'textarea_rows' => 12,
                            'media_buttons' => false,
                            'teeny'         => false,
                            'quicktags'     => true,
                            'tinymce'       => [
                                'toolbar1' => 'formatselect,bold,italic,underline,strikethrough,separator,bullist,numlist,separator,blockquote,separator,link,unlink,separator,alignleft,aligncenter,alignright,separator,indent,outdent,separator,hr,separator,pastetext,removeformat,separator,undo,redo',
                                'toolbar2' => '',
                                'block_formats' => 'Paragraphe=p;Sous-titre=h3;Petit titre=h4',
                                'paste_as_text' => true,
                                'valid_styles' => '{"*":"text-align"}',
                            ],
                        ]); ?>
                        <p class="description">Paragraphes, sous-titres (H3/H4), listes, citations, gras, italique — tout est stylé automatiquement.</p>
                    </td></tr>
                </table>
                <?php endforeach; ?>

                <h3>CTA bas de page détail</h3>
                <table class="form-table">
                    <tr><th>Titre</th><td><input type="text" name="sg_site_texts[exp_detail_cta_title]" value="<?php echo $t('exp_detail_cta_title', 'Besoin d\'un <em>accompagnement ?</em>'); ?>" class="large-text"><p class="description">Balise &lt;em&gt; pour l'italique.</p></td></tr>
                    <tr><th>Sous-titre</th><td><input type="text" name="sg_site_texts[exp_detail_cta_sub]" value="<?php echo $t('exp_detail_cta_sub', 'Chaque dossier mérite une analyse personnalisée.'); ?>" class="large-text"></td></tr>
                    <tr><th>Bouton</th><td><input type="text" name="sg_site_texts[exp_detail_cta_btn]" value="<?php echo $t('exp_detail_cta_btn', 'Prendre rendez-vous'); ?>" class="regular-text"></td></tr>
                </table>
            </div>

            <!-- AVOCAT -->
            <div id="sg-tab-avocat" class="sg-tab-content" style="display:none;">
                <table class="form-table">
                    <tr><th>Prénom</th><td><input type="text" name="sg_site_texts[avocat_prenom]" value="<?php echo $t('avocat_prenom', 'Me Seri'); ?>" class="regular-text"><p class="description">Première ligne du titre de la page Avocat, et du bloc Avocat sur l'accueil.</p></td></tr>
                    <tr><th>Nom</th><td><input type="text" name="sg_site_texts[avocat_nom]" value="<?php echo $t('avocat_nom', 'Gueffie'); ?>" class="regular-text"><p class="description">Seconde ligne, affichée en italique.</p></td></tr>
                    <tr><th>Sous-titre</th><td><input type="text" name="sg_site_texts[avocat_subtitle]" value="<?php echo $t('avocat_subtitle', 'Avocat au Barreau de Lyon'); ?>" class="large-text"></td></tr>
                    <tr><th>Biographie</th><td><textarea name="sg_site_texts[avocat_bio]" rows="6" class="large-text"><?php echo $ta('avocat_bio', '<p>Passionné par le droit et animé par un sens profond de la justice, Me Seri Gueffie met son expertise au service de clients confrontés à des enjeux juridiques complexes.</p><p>Son approche allie rigueur analytique et vision stratégique, avec une attention constante portée à la dimension humaine de chaque affaire. Il défend avec conviction les intérêts de ses clients devant toutes les juridictions.</p>'); ?></textarea><p class="description">Balises HTML autorisées : &lt;p&gt;, &lt;em&gt;, &lt;strong&gt;</p></td></tr>
                    <tr><th>Barreau</th><td><input type="text" name="sg_site_texts[avocat_barreau]" value="<?php echo $t('avocat_barreau', 'Barreau de Lyon'); ?>" class="regular-text"></td></tr>
                    <tr><th>Serment</th><td><input type="text" name="sg_site_texts[avocat_serment]" value="<?php echo $t('avocat_serment', '6 décembre 2021'); ?>" class="regular-text"></td></tr>
                    <tr><th>Spécialité</th><td><input type="text" name="sg_site_texts[avocat_specialite]" value="<?php echo $t('avocat_specialite', 'Droit des assurances'); ?>" class="regular-text"></td></tr>
                    <tr><th>Formation</th><td><input type="text" name="sg_site_texts[avocat_formation]" value="<?php echo $t('avocat_formation', 'Master en Droit — Université de Paris'); ?>" class="large-text"></td></tr>
                    <tr><th>Langues</th><td><input type="text" name="sg_site_texts[avocat_langues]" value="<?php echo $t('avocat_langues', 'Français, Anglais'); ?>" class="regular-text"></td></tr>
                </table>
            </div>

            <!-- CONTACT -->
            <div id="sg-tab-contact" class="sg-tab-content" style="display:none;">
                <h3>Page Contact</h3>
                <table class="form-table">
                    <tr><th>Introduction</th><td><textarea name="sg_site_texts[contact_intro]" rows="2" class="large-text"><?php echo $ta('contact_intro', 'Pour toute demande de consultation ou d\'information, n\'hésitez pas à contacter le cabinet. Chaque situation mérite une attention particulière.'); ?></textarea></td></tr>
                </table>

                <h3>Formulaire de contact</h3>
                <p class="description">Ces réglages valent pour tous les formulaires du site, y compris celui de la page d'accueil.</p>
                <table class="form-table">
                    <tr><th>Bouton d'envoi</th><td><input type="text" name="sg_site_texts[form_submit]" value="<?php echo $t('form_submit', 'Envoyer'); ?>" class="regular-text"></td></tr>
                    <tr><th>Domaines juridiques</th><td><textarea name="sg_site_texts[form_domains]" rows="2" class="large-text"><?php echo $ta('form_domains', 'Droit Pénal,Droit de la Famille,Droit des Affaires,Droit du Travail,Droit Immobilier,Droit des Étrangers,Autre'); ?></textarea><p class="description">Séparés par des virgules. Apparaissent dans le menu déroulant du formulaire.</p></td></tr>
                    <tr><th>Enjeux du litige</th><td><textarea name="sg_site_texts[form_enjeux]" rows="2" class="large-text"><?php echo $ta('form_enjeux', '50 000 € – 100 000 €,100 000 € – 200 000 €,200 000 € – 500 000 €,Plus de 500 000 €,Je ne connais pas encore le montant'); ?></textarea><p class="description">Séparés par des virgules. Apparaissent dans le menu déroulant "Enjeu du litige".</p></td></tr>
                    <tr><th>Label "Adresse"</th><td><input type="text" name="sg_site_texts[label_adresse]" value="<?php echo $t('label_adresse', 'Adresse'); ?>" class="regular-text"></td></tr>
                    <tr><th>Label "Téléphone"</th><td><input type="text" name="sg_site_texts[label_telephone]" value="<?php echo $t('label_telephone', 'Téléphone'); ?>" class="regular-text"></td></tr>
                    <tr><th>Label "Email"</th><td><input type="text" name="sg_site_texts[label_email]" value="<?php echo $t('label_email', 'Email'); ?>" class="regular-text"></td></tr>
                </table>
            </div>

            <!-- ARTICLES -->
            <div id="sg-tab-articles" class="sg-tab-content" style="display:none;">
                <h3>Titre de la page Publications</h3>
                <table class="form-table">
                    <tr><th>Titre ligne 1</th><td><input type="text" name="sg_site_texts[pub_title_l1]" value="<?php echo $t('pub_title_l1', 'Articles &'); ?>" class="regular-text"></td></tr>
                    <tr><th>Titre ligne 2</th><td><input type="text" name="sg_site_texts[pub_title_l2]" value="<?php echo $t('pub_title_l2', 'Publications'); ?>" class="regular-text"><p class="description">Affichée en italique, sous la ligne 1.</p></td></tr>
                </table>

                <h3>Auteur (affiché sous chaque article)</h3>
                <table class="form-table">
                    <tr><th>Nom de l'auteur</th><td><input type="text" name="sg_site_texts[article_author_name]" value="<?php echo $t('article_author_name', 'Me Seri Gueffie'); ?>" class="regular-text"></td></tr>
                    <tr><th>Rôle / spécialité</th><td><input type="text" name="sg_site_texts[article_author_role]" value="<?php echo $t('article_author_role', 'Avocat au Barreau de Lyon · Droit des assurances'); ?>" class="large-text"></td></tr>
                </table>

                <h3>Bloc PDF (bas d'article)</h3>
                <table class="form-table">
                    <tr><th>Titre du bloc</th><td><input type="text" name="sg_site_texts[article_pdf_label]" value="<?php echo $t('article_pdf_label', 'Télécharger cet article en PDF'); ?>" class="large-text"></td></tr>
                    <tr><th>Sous-texte</th><td><input type="text" name="sg_site_texts[article_pdf_hint]" value="<?php echo $t('article_pdf_hint', 'Version mise en forme, idéale pour l\'impression ou la lecture hors-ligne.'); ?>" class="large-text"></td></tr>
                    <tr><th>Bouton</th><td><input type="text" name="sg_site_texts[article_pdf_btn]" value="<?php echo $t('article_pdf_btn', 'Télécharger PDF'); ?>" class="regular-text"></td></tr>
                </table>

                <h3>Bandeau CTA (bas d'article)</h3>
                <table class="form-table">
                    <tr><th>Titre</th><td><input type="text" name="sg_site_texts[article_cta_title]" value="<?php echo $t('article_cta_title', 'Besoin d\'un <em>accompagnement ?</em>'); ?>" class="large-text"><p class="description">Balise &lt;em&gt; pour l'italique.</p></td></tr>
                    <tr><th>Sous-titre</th><td><input type="text" name="sg_site_texts[article_cta_sub]" value="<?php echo $t('article_cta_sub', 'Chaque dossier mérite une analyse personnalisée.'); ?>" class="large-text"></td></tr>
                    <tr><th>Bouton</th><td><input type="text" name="sg_site_texts[article_cta_btn]" value="<?php echo $t('article_cta_btn', 'Prendre rendez-vous'); ?>" class="regular-text"></td></tr>
                </table>

                <h3>Libellés</h3>
                <table class="form-table">
                    <tr><th>Tag "Autres publications"</th><td><input type="text" name="sg_site_texts[article_related_tag]" value="<?php echo $t('article_related_tag', 'Autres publications'); ?>" class="regular-text"></td></tr>
                </table>
            </div>

            <!-- 404 -->
            <div id="sg-tab-404" class="sg-tab-content" style="display:none;">
                <table class="form-table">
                    <tr><th>Titre</th><td><input type="text" name="sg_site_texts[e404_title]" value="<?php echo $t('e404_title', 'Page introuvable'); ?>" class="large-text"></td></tr>
                    <tr><th>Message</th><td><textarea name="sg_site_texts[e404_text]" rows="2" class="large-text"><?php echo $ta('e404_text', 'La page que vous recherchez n\'existe pas ou a été déplacée. Nous vous invitons à retourner à l\'accueil.'); ?></textarea></td></tr>
                    <tr><th>Bouton principal</th><td><input type="text" name="sg_site_texts[e404_btn1]" value="<?php echo $t('e404_btn1', 'Retour à l\'accueil'); ?>" class="regular-text"></td></tr>
                    <tr><th>Bouton secondaire</th><td><input type="text" name="sg_site_texts[e404_btn2]" value="<?php echo $t('e404_btn2', 'Nous contacter'); ?>" class="regular-text"></td></tr>
                </table>
            </div>

            <div class="sg-save-bar">
                <?php submit_button('Enregistrer les modifications', 'primary', 'submit', false); ?>
            </div>
        </form>
    </div>

    <style>
    /* Le bouton reste atteignable : l'onglet Landing compte 25 champs. */
    .sg-save-bar {
        position: sticky;
        bottom: 0;
        z-index: 10;
        margin-top: 20px;
        padding: 12px 0;
        background: #f0f0f1;
        border-top: 1px solid #c3c4c7;
    }
    </style>

    <script>
    // L'onglet actif survit à l'enregistrement : sans ça, options.php recharge
    // la page et l'utilisateur retombe sur « Général », en doutant d'avoir sauvegardé.
    function sgShowTab(tab) {
        var pane = document.getElementById('sg-tab-' + tab);
        var link = document.querySelector('.nav-tab[data-tab="' + tab + '"]');
        if (!pane || !link) return false;
        document.querySelectorAll('.nav-tab').forEach(function (t) { t.classList.remove('nav-tab-active'); });
        document.querySelectorAll('.sg-tab-content').forEach(function (c) { c.style.display = 'none'; });
        link.classList.add('nav-tab-active');
        pane.style.display = 'block';
        return true;
    }

    function sgTab(event, el, tab) {
        event.preventDefault();
        if (sgShowTab(tab)) {
            try { sessionStorage.setItem('sgActiveTab', tab); } catch (e) {}
        }
    }

    (function () {
        var saved = null;
        try { saved = sessionStorage.getItem('sgActiveTab'); } catch (e) {}
        if (saved) { sgShowTab(saved); }
    })();
    </script>
    <?php
}

/**
 * Page de diagnostic — lecture seule.
 *
 * Un texte affiché sur le site provient soit de l'option sg_site_texts, soit,
 * si la clé y est absente ou vide, de la valeur par défaut inscrite dans le
 * gabarit. Le HTML rendu ne permet pas de distinguer les deux : cette page
 * montre l'état réel de l'option.
 */
add_action('admin_menu', function () {
    add_submenu_page(
        'sg-textes',
        'Diagnostic des textes',
        'Diagnostic',
        'edit_theme_options',
        'sg-textes-diagnostic',
        'sg_render_diagnostic_page'
    );
});

function sg_render_diagnostic_page() {
    $raw    = get_option('sg_site_texts', null);
    $saved  = is_array($raw) ? $raw : [];
    $filled = array_filter($saved, function ($v) { return trim((string) $v) !== ''; });
    ksort($filled);
    ?>
    <div class="wrap">
        <h1>Diagnostic des textes</h1>
        <p class="description">
            Page en lecture seule. Elle n'enregistre rien et ne modifie rien.
            Elle affiche ce qui est réellement stocké en base de données, par
            opposition aux valeurs par défaut inscrites dans les gabarits.
        </p>

        <?php if ($raw === null) : ?>
            <div class="notice notice-info inline"><p>
                <strong>L'option <code>sg_site_texts</code> n'existe pas.</strong>
                L'écran Textes n'a jamais été enregistré. Le site affiche donc
                les valeurs par défaut des gabarits.
            </p></div>
        <?php else : ?>
            <div class="notice notice-warning inline"><p>
                <strong><?php echo count($filled); ?> clé<?php echo count($filled) > 1 ? 's' : ''; ?>
                enregistrée<?php echo count($filled) > 1 ? 's' : ''; ?> en base</strong>
                (sur <?php echo count($saved); ?> présentes dans l'option).
                Ce sont ces valeurs qui s'affichent sur le site : pour ces clés,
                les valeurs par défaut des gabarits ne sont pas utilisées.
            </p></div>
        <?php endif; ?>

        <?php if ($filled) : ?>
            <h2>Valeurs enregistrées</h2>
            <table class="widefat striped">
                <thead><tr><th style="width:220px;">Clé</th><th>Valeur en base</th></tr></thead>
                <tbody>
                <?php foreach ($filled as $key => $value) : ?>
                    <tr>
                        <td><code><?php echo esc_html($key); ?></code></td>
                        <td style="word-break:break-word;"><?php echo esc_html($value); ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

            <h2>Export</h2>
            <p class="description">Sélectionnez tout le contenu ci-dessous et copiez-le pour le transmettre.</p>
            <textarea class="large-text code" rows="14" readonly onclick="this.select();"><?php
                echo esc_textarea(wp_json_encode(
                    $filled,
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                ));
            ?></textarea>
        <?php endif; ?>
    </div>
    <?php
}
