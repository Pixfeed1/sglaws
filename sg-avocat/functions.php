<?php
if (!defined('ABSPATH')) exit;
/**
 * S-G Avocat — functions.php
 * @package SG_Avocat
 * @author PixFeed (pixfeed.net)
 */

define('SG_VERSION', '1.3.0');
define('SG_DIR', get_template_directory());
define('SG_URI', get_template_directory_uri());

/* =============================================
   THEME SETUP
============================================= */
add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['comment-form', 'comment-list', 'search-form', 'gallery', 'caption']);
    add_theme_support('custom-logo');
    // Sans ça, une vidéo ou une carte collée dans un article sort avec une largeur
    // fixe et déborde de l'écran sur mobile.
    add_theme_support('responsive-embeds');
    set_post_thumbnail_size(1200, 630, true);
    add_image_size('sg-hero', 1920, 1080, true);
    add_image_size('sg-card', 600, 400, true);
    register_nav_menus(['primary' => 'Navigation principale']);
});

/* =============================================
   AUTO-CREATE PAGES ON THEME ACTIVATION
============================================= */
add_action('after_switch_theme', 'sg_setup_pages');
add_action('after_switch_theme', 'sg_setup_menu');

add_action('after_switch_theme', 'sg_setup_expertise_pages');

// Also run on admin_init if never run before (handles upload without switch)
add_action('admin_init', function () {
    if (get_option('sg_installed') === SG_VERSION) {
        return;
    }
    /* La liste historique n'est posée qu'à la toute première installation.
       La rejouer à chaque montée de version recréerait toute page dont
       l'adresse a changé depuis : renommer /expertise/ en /competences/ suffit
       à ce que le contrôle d'existence échoue et qu'un doublon vide
       réapparaisse, en emportant au passage la redirection que WordPress avait
       posée sur l'ancienne adresse. */
    if (!get_option('sg_installed')) {
        sg_setup_pages();
        sg_setup_menu();
    }
    sg_setup_expertise_pages();
    update_option('sg_installed', SG_VERSION);
});

function sg_setup_pages() {
    $pages = [
        'accueil'       => ['title' => 'Accueil', 'template' => ''],
        'expertise'     => ['title' => 'Expertise', 'template' => 'page-expertise.php'],
        'avocat'        => ['title' => 'Avocat', 'template' => 'page-avocat.php'],
        'publications'  => ['title' => 'Publications', 'template' => 'page-publications.php'],
        'contact'       => ['title' => 'Contact', 'template' => 'page-contact.php'],
        'landing'       => ['title' => 'Landing Page', 'template' => 'template-landing.php'],
        'expertise-detail' => ['title' => 'Expertise Détail', 'template' => 'page-expertise-detail.php'],
        'mentions-legales' => ['title' => 'Mentions légales', 'template' => '', 'content' => '<h2>Éditeur du site</h2><p>Me Seri Gueffie — Avocat au Barreau de Lyon<br>86, Rue Paul Bert — 69003 Lyon<br>Tél : 04 81 13 09 40 — Email : seri@gueffie.fr</p><h2>Conception</h2><p>PixFeed — <a href="https://pixfeed.net">pixfeed.net</a><br>SIRET : 852 393 735 00018</p><h2>Hébergement</h2><p>Hostinger International Ltd. — Larnaca, Chypre</p><h2>Propriété intellectuelle</h2><p>L\'ensemble des contenus sont la propriété exclusive de Me Seri Gueffie. Toute reproduction sans autorisation est interdite.</p><h2>Médiation</h2><p>Médiateur : Carole Pascarel — 180, Boulevard Haussmann — 75008 Paris</p>'],
        'politique-de-confidentialite' => ['title' => 'Politique de confidentialité', 'template' => '', 'content' => '<h2>Responsable du traitement</h2><p>Me Seri Gueffie, avocat au Barreau de Lyon.</p><h2>Données collectées</h2><p>Nom, email, téléphone, domaine juridique et message via le formulaire de contact.</p><h2>Finalité</h2><p>Répondre à vos demandes de consultation.</p><h2>Base légale</h2><p>Consentement (art. 6.1.a RGPD) et intérêt légitime (art. 6.1.f).</p><h2>Conservation</h2><p>3 ans à compter du dernier contact.</p><h2>Vos droits</h2><p>Accès, rectification, effacement, limitation, portabilité, opposition. Contact : seri@gueffie.fr</p><h2>Réclamation</h2><p>CNIL : <a href="https://www.cnil.fr">www.cnil.fr</a></p>'],
    ];

    foreach ($pages as $slug => $page) {
        if (!get_page_by_path($slug)) {
            $id = wp_insert_post([
                'post_title'   => $page['title'],
                'post_name'    => $slug,
                'post_content' => $page['content'] ?? '',
                'post_status'  => $page['status'] ?? 'publish',
                'post_type'    => 'page',
            ]);
            if ($page['template'] && $id && !is_wp_error($id)) {
                update_post_meta($id, '_wp_page_template', $page['template']);
            }
        }
    }

    // Set Accueil as front page
    $front = get_page_by_path('accueil');
    if ($front) {
        update_option('show_on_front', 'page');
        update_option('page_on_front', $front->ID);
    }
}

/**
 * Pages d'expertise — une par domaine, avec son gabarit, son adresse et son
 * texte. Le texte vit dans contenu-a-coller/ et devient le contenu de la page :
 * il se modifie ensuite dans WordPress, et survit donc aux mises à jour.
 *
 * Les adresses sont celles du plan de référencement, elles ne s'improvisent
 * pas : les pages se lient entre elles par ces adresses.
 *
 * Une page dont l'adresse existe déjà n'est jamais recréée ni modifiée : la
 * fonction peut être rejouée sans risque pour un texte saisi depuis WordPress.
 */
function sg_setup_expertise_pages() {
    $expertises = [
        'competences' => ['Domaines d\'intervention', 'page-competences.php', null],
        'avocat-assurance-emprunteur' => ['Assurance emprunteur', 'page-exp-assurance-emprunteur.php', 'assurance-emprunteur'],
        'avocat-prevoyance-refus-garantie' => ['Prévoyance', 'page-exp-prevoyance.php', 'prevoyance'],
        'avocat-catastrophe-naturelle-assurance' => ['Catastrophe naturelle', 'page-exp-catastrophe-naturelle.php', 'catastrophe-naturelle'],
        'avocat-assurance-construction-dommage-ouvrage' => ['Construction et dommage-ouvrage', 'page-exp-construction.php', 'construction'],
        'avocat-responsabilite-civile-professionnelle' => ['Responsabilité civile professionnelle', 'page-exp-rc-professionnelle.php', 'rc-professionnelle'],
        'avocat-risque-industriel-assurance' => ['Risque industriel', 'page-exp-risque-industriel.php', 'risque-industriel'],
        // Brouillon : le cabinet ne s'est pas encore prononcé sur ce domaine.
        'avocat-accident-de-la-route-indemnisation' => ['Accident de la route', 'page-exp-accident-route.php', 'accident-route', 'draft'],
    ];

    foreach ($expertises as $slug => $e) {
        if (get_page_by_path($slug)) {
            continue;
        }
        $body = '';
        if ($e[2]) {
            $file = SG_DIR . '/contenu-a-coller/' . $e[2] . '.txt';
            if (is_readable($file)) {
                $body = file_get_contents($file);
            }
        }
        $id = wp_insert_post([
            'post_title'   => $e[0],
            'post_name'    => $slug,
            'post_content' => $body,
            'post_status'  => $e[3] ?? 'publish',
            'post_type'    => 'page',
        ]);
        if ($id && !is_wp_error($id)) {
            update_post_meta($id, '_wp_page_template', $e[1]);
        }
    }
}

/* =============================================
   ENQUEUE
============================================= */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('sg-style', SG_URI . '/style.css', [], SG_VERSION);

    // Remove bloat
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('global-styles');
    wp_dequeue_style('classic-theme-styles');

    // JS in footer
    wp_enqueue_script('sg-gsap', SG_URI . '/js/gsap.min.js', [], '3.12.5', true);
    wp_enqueue_script('sg-scrolltrigger', SG_URI . '/js/ScrollTrigger.min.js', ['sg-gsap'], '3.12.5', true);
    wp_enqueue_script('sg-lenis', SG_URI . '/js/lenis.min.js', [], '1.1.13', true);
    wp_enqueue_script('sg-main', SG_URI . '/js/main.js', ['sg-gsap', 'sg-scrolltrigger', 'sg-lenis'], SG_VERSION, true);

    $smtp = get_option('sg_smtp_settings', []);
    wp_localize_script('sg-main', 'sgData', [
        'ajaxUrl'  => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('sg_nonce'),
        'formspree'=> $smtp['formspree'] ?? '',
    ]);
});

// Remove junk from head
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_shortlink_wp_head');
remove_action('wp_head', 'rest_output_link_wp_head');
add_action('init', function () {
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('wp_print_styles', 'print_emoji_styles');
});

// Preload fonts
add_action('wp_head', function () {
    $f = SG_URI . '/fonts';
    echo '<link rel="preload" href="' . $f . '/inter-latin-400-normal.woff2" as="font" type="font/woff2" crossorigin>' . "\n";
    echo '<link rel="preload" href="' . $f . '/playfair-display-latin-400-normal.woff2" as="font" type="font/woff2" crossorigin>' . "\n";
}, 1);

// Favicon in admin
add_action('admin_head', function () {
    echo '<link rel="icon" type="image/svg+xml" href="' . SG_URI . '/img/favicon.svg">' . "\n";
    echo '<link rel="icon" type="image/png" href="' . SG_URI . '/img/favicon.png">' . "\n";
});

// Add defer to all theme scripts
add_filter('script_loader_tag', function ($tag, $handle) {
    if (strpos($handle, 'sg-') === 0 && strpos($tag, 'defer') === false) {
        $tag = str_replace(' src=', ' defer src=', $tag);
    }
    return $tag;
}, 10, 2);

/* =============================================
   PDF ATTACHÉ AUX ARTICLES
   (plus de CPT séparé — le PDF est lié à l'article)
============================================= */
add_action('add_meta_boxes', function () {
    add_meta_box('sg_pdf_file', 'Fichier PDF', 'sg_pdf_metabox', 'post', 'side', 'high');
});

function sg_pdf_metabox($post) {
    wp_nonce_field('sg_pdf_nonce', 'sg_pdf_nonce_field');
    $pdf_url = get_post_meta($post->ID, '_sg_pdf_url', true);
    ?>
    <p>
      <input type="text" name="sg_pdf_url" id="sg_pdf_url" value="<?php echo esc_url($pdf_url); ?>" style="width:100%;" readonly placeholder="Aucun PDF joint">
    </p>
    <p style="margin-top:6px;">
      <button type="button" class="button button-primary" id="sg_pdf_upload_btn" style="width:100%;text-align:center;">Joindre un PDF</button>
    </p>
    <p style="margin-top:4px;">
      <button type="button" class="button" id="sg_pdf_remove_btn" style="width:100%;text-align:center;<?php echo $pdf_url ? '' : 'display:none;'; ?>">Retirer le PDF</button>
    </p>
    <?php if ($pdf_url) : ?>
      <p style="margin-top:4px;">
        <a href="<?php echo esc_url($pdf_url); ?>" target="_blank" class="button" style="width:100%;text-align:center;">Voir le fichier ↗</a>
      </p>
    <?php endif; ?>
    <p class="description" style="margin-top:8px;">PDF mis en forme avec Affinity. Le visiteur pourra lire l'article en ligne ET télécharger le PDF.</p>
    <script>
    jQuery(document).ready(function($){
        var frame;
        $('#sg_pdf_upload_btn').on('click',function(e){
            e.preventDefault();
            if(frame){frame.open();return;}
            frame=wp.media({title:'Joindre un PDF',library:{type:'application/pdf'},multiple:false});
            frame.on('select',function(){
                var a=frame.state().get('selection').first().toJSON();
                $('#sg_pdf_url').val(a.url);
                $('#sg_pdf_remove_btn').show();
            });
            frame.open();
        });
        $('#sg_pdf_remove_btn').on('click',function(){$('#sg_pdf_url').val('');$(this).hide();});
    });
    </script>
    <?php
}

add_action('save_post', function ($post_id) {
    if (get_post_type($post_id) !== 'post') return;
    if (!isset($_POST['sg_pdf_nonce_field']) || !wp_verify_nonce($_POST['sg_pdf_nonce_field'], 'sg_pdf_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['sg_pdf_url'])) update_post_meta($post_id, '_sg_pdf_url', esc_url_raw($_POST['sg_pdf_url']));
});

add_action('admin_enqueue_scripts', function ($hook) {
    global $post_type;
    if ($post_type === 'post' && in_array($hook, ['post.php', 'post-new.php'])) wp_enqueue_media();
});

/* =============================================
   CUSTOMIZER
============================================= */
add_action('customize_register', function ($wp_customize) {
    $wp_customize->add_section('sg_contact', ['title' => 'Coordonnées du cabinet', 'priority' => 30]);

    $fields = [
        'sg_address'   => ['Adresse', '86, Rue Paul Bert<br>69003 Lyon', 'textarea'],
        'sg_phone'     => ['Téléphone', '04 81 13 09 40', 'text'],
        'sg_email'     => ['Email', 'seri@gueffie.fr', 'text'],
        'sg_linkedin'  => ['URL LinkedIn', 'https://www.linkedin.com/in/seri-gueffie-067200229/', 'text'],
        'sg_instagram' => ['URL Instagram', 'https://www.instagram.com/serigueffie/', 'text'],
    ];
    foreach ($fields as $id => $f) {
        $wp_customize->add_setting($id, ['default' => $f[1], 'sanitize_callback' => 'wp_kses_post']);
        $wp_customize->add_control($id, ['label' => $f[0], 'section' => 'sg_contact', 'type' => $f[2]]);
    }

    // Médias
    $wp_customize->add_section('sg_medias', ['title' => 'Médias du site', 'priority' => 35]);

    $wp_customize->add_setting('sg_hero_video', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('sg_hero_video', ['label' => 'URL vidéo hero (accueil)', 'description' => 'MP4. Vide = image poster.', 'section' => 'sg_medias', 'type' => 'url']);

    $wp_customize->add_setting('sg_hero_image', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'sg_hero_image', ['label' => 'Image hero (accueil)', 'section' => 'sg_medias']));

    $wp_customize->add_setting('sg_landing_video', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control('sg_landing_video', ['label' => 'URL vidéo hero (landing)', 'section' => 'sg_medias', 'type' => 'url']);

    $wp_customize->add_setting('sg_landing_image', ['default' => '', 'sanitize_callback' => 'esc_url_raw']);
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'sg_landing_image', ['label' => 'Image hero (landing)', 'section' => 'sg_medias']));

    $wp_customize->add_setting('sg_photo_avocat', ['default' => 0, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control(new WP_Customize_Media_Control($wp_customize, 'sg_photo_avocat', ['label' => 'Photo de Me Gueffie', 'section' => 'sg_medias', 'mime_type' => 'image']));
});

/* =============================================
   HELPERS
============================================= */
function sg_option($key, $default = '') { return get_theme_mod($key, $default); }

/**
 * Get page URL by slug — safe, never returns wrong URL
 */
function sg_page_url($slug) {
    // Try by exact slug
    $page = get_page_by_path($slug);
    if ($page && $page->post_status === 'publish') return get_permalink($page->ID);
    
    // Try WP_Query as fallback (handles slug variations)
    $query = new WP_Query([
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'name'           => $slug,
    ]);
    if ($query->have_posts()) {
        return get_permalink($query->posts[0]->ID);
    }
    
    // Try by title as last resort
    $query = new WP_Query([
        'post_type'      => 'page',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'title'          => str_replace('-', ' ', ucwords($slug, '-')),
    ]);
    if ($query->have_posts()) {
        return get_permalink($query->posts[0]->ID);
    }
    
    // Absolute fallback: manual URL
    return home_url('/' . $slug . '/');
}

/**
 * Adresse de la page dédiée à un domaine d'expertise, numéroté de 1 à 6.
 *
 * Les six cartes pointaient vers une ancre sur une page unique : pour Google
 * il n'existait qu'une seule page pour six expertises, et le référencement s'y
 * diluait. Chaque domaine a maintenant sa page. Un numéro inconnu renvoie vers
 * la page chapeau plutôt que vers une adresse inexistante.
 */
function sg_expertise_url($num) {
    $slugs = [
        1 => 'avocat-assurance-emprunteur',
        2 => 'avocat-prevoyance-refus-garantie',
        3 => 'avocat-catastrophe-naturelle-assurance',
        4 => 'avocat-assurance-construction-dommage-ouvrage',
        5 => 'avocat-responsabilite-civile-professionnelle',
        6 => 'avocat-risque-industriel-assurance',
    ];
    return sg_page_url($slugs[$num] ?? 'competences');
}

function sg_text($key, $default = '') {
    $texts = get_option('sg_site_texts', []);
    return isset($texts[$key]) && $texts[$key] !== '' ? $texts[$key] : $default;
}

function sg_reading_time($post_id = null) {
    $content = get_post_field('post_content', $post_id ?: get_the_ID());
    return max(1, ceil(str_word_count(strip_tags($content)) / 200)) . ' min de lecture';
}

function sg_breadcrumb() {
    echo '<div class="breadcrumb"><div class="container"><div class="breadcrumb__inner">';
    echo '<a href="' . home_url() . '">Accueil</a>';
    if (is_single()) {
        $cats = get_the_category();
        if ($cats) echo '<span>/</span><a href="' . get_category_link($cats[0]->term_id) . '">' . esc_html($cats[0]->name) . '</a>';
        echo '<span>/</span><span>' . wp_trim_words(get_the_title(), 5) . '</span>';
    } elseif (is_category()) { echo '<span>/</span><span>' . single_cat_title('', false) . '</span>'; }
    elseif (is_tag()) { echo '<span>/</span><span>' . single_tag_title('', false) . '</span>'; }
    elseif (is_search()) { echo '<span>/</span><span>Recherche</span>'; }
    elseif (is_page()) { echo '<span>/</span><span>' . get_the_title() . '</span>'; }
    echo '</div></div></div>';
}

/* =============================================
   CONTACT FORM AJAX
============================================= */
add_action('wp_ajax_sg_contact', 'sg_handle_contact');
add_action('wp_ajax_nopriv_sg_contact', 'sg_handle_contact');
function sg_handle_contact() {
    check_ajax_referer('sg_nonce', 'nonce');
    if (!empty($_POST['sg_hp'])) wp_send_json_error('Spam detected.');
    $name = sanitize_text_field($_POST['name'] ?? '');
    $email = sanitize_email($_POST['email'] ?? '');
    $phone = sanitize_text_field($_POST['phone'] ?? '');
    $domain = sanitize_text_field($_POST['domain'] ?? '');
    $enjeu = sanitize_text_field($_POST['enjeu'] ?? '');
    $message = sanitize_textarea_field($_POST['message'] ?? '');
    $prenom = sanitize_text_field($_POST['prenom'] ?? '');
    $source = sanitize_text_field($_POST['source'] ?? 'contact');
    if (!$name || !$email || !$message) wp_send_json_error('Champs requis manquants.');

    // 1. Save to database
    $saved = sg_save_message([
        'name'    => $name,
        'prenom'  => $prenom,
        'email'   => $email,
        'phone'   => $phone,
        'domain'  => $domain,
        'enjeu'   => $enjeu,
        'message' => $message,
        'source'  => $source,
    ]);

    // 2. Send email
    $to = sg_option('sg_email', 'seri@gueffie.fr');
    $full_name = trim($prenom . ' ' . $name);
    $body = "Nom: $full_name\nEmail: $email\nTél: $phone\nDomaine: $domain\nEnjeu: $enjeu\nSource: $source\n\nMessage:\n$message";
    $headers = ['Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $email];
    $emailed = wp_mail($to, "Nouveau message de $full_name — gueffie-avocat.fr", $body, $headers);

    // Success if saved OR emailed
    if ($saved || $emailed) {
        wp_send_json_success('Message envoyé.');
    } else {
        wp_send_json_error('Erreur lors de l\'envoi.');
    }
}

/* =============================================
   COMMENTS
============================================= */
add_filter('comment_form_default_fields', function ($fields) { unset($fields['url']); return $fields; });

/* =============================================
   INCLUDES
============================================= */
require_once SG_DIR . '/inc/admin-textes.php';
require_once SG_DIR . '/inc/admin-messages.php';
require_once SG_DIR . '/inc/admin-smtp.php';

/* =============================================
   NAV WALKERS — Desktop & Mobile
============================================= */
class SG_Desktop_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = [];
        if ($item->current || $item->current_item_ancestor) $classes[] = 'active';

        // Last menu item gets CTA style (via CSS class "sg-cta" set in menu admin)
        if (in_array('sg-cta', $item->classes)) {
            $classes[] = 'header__cta';
        }

        $class_str = $classes ? ' class="' . implode(' ', $classes) . '"' : '';
        $output .= '<a href="' . esc_url($item->url) . '"' . $class_str . '>' . esc_html($item->title) . '</a>';
    }
    function end_el(&$output, $item, $depth = 0, $args = null) {}
    function start_lvl(&$output, $depth = 0, $args = null) {}
    function end_lvl(&$output, $depth = 0, $args = null) {}
}

/**
 * Menu mobile — seul des trois à rendre les entrées enfants.
 *
 * La colonne est verticale et centrée : la hiérarchie se lit à la taille et à
 * la couleur, pas à l'indentation, qui ne se verrait pas sur un axe centré.
 * start_lvl() et end_lvl() restent vides volontairement — items_wrap vaut
 * '%3$s', il n'y a donc pas de <ul> à ouvrir.
 */
class SG_Mobile_Walker extends Walker_Nav_Menu {
    private $index = 0;

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = ['mob-link'];
        if ($depth > 0) {
            $classes[] = 'mob-link--child';
        }
        $output .= '<a href="' . esc_url($item->url) . '"'
                 . ' class="' . esc_attr(implode(' ', $classes)) . '"'
                 . ' style="--i:' . (int) $this->index++ . '">'
                 . esc_html($item->title) . '</a>';
    }
    function end_el(&$output, $item, $depth = 0, $args = null) {}
    function start_lvl(&$output, $depth = 0, $args = null) {}
    function end_lvl(&$output, $depth = 0, $args = null) {}
}

class SG_Footer_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $output .= '<a href="' . esc_url($item->url) . '">' . esc_html($item->title) . '</a>';
    }
    function end_el(&$output, $item, $depth = 0, $args = null) {}
    function start_lvl(&$output, $depth = 0, $args = null) {}
    function end_lvl(&$output, $depth = 0, $args = null) {}
}

// Fallback if no menu assigned
function sg_fallback_menu() {
    echo '<a href="' . home_url('/expertise/') . '">Expertise</a>';
    echo '<a href="' . home_url('/avocat/') . '">Avocat</a>';
    echo '<a href="' . home_url('/publications/') . '">Publications</a>';
    echo '<a href="' . home_url('/contact/') . '" class="header__cta">Contact</a>';
}
function sg_fallback_mobile_menu() {
    // --i alimente le décalage de la cascade d'ouverture, comme dans SG_Mobile_Walker.
    echo '<a href="' . home_url('/expertise/') . '" class="mob-link" style="--i:0">Expertise</a>';
    echo '<a href="' . home_url('/avocat/') . '" class="mob-link" style="--i:1">Avocat</a>';
    echo '<a href="' . home_url('/publications/') . '" class="mob-link" style="--i:2">Publications</a>';
    echo '<a href="' . home_url('/contact/') . '" class="mob-link" style="--i:3">Contact</a>';
}

/* =============================================
   AUTO-CREATE MENU ON THEME ACTIVATION
============================================= */

function sg_setup_menu() {
    $menu_name = 'Navigation principale';
    $menu_exists = wp_get_nav_menu_object($menu_name);

    if (!$menu_exists) {
        $menu_id = wp_create_nav_menu($menu_name);

        // Get page IDs
        $pages = ['expertise', 'avocat', 'publications', 'contact'];
        $order = 1;

        foreach ($pages as $slug) {
            $page = get_page_by_path($slug);
            if ($page) {
                $item_data = [
                    'menu-item-object-id' => $page->ID,
                    'menu-item-object'    => 'page',
                    'menu-item-type'      => 'post_type',
                    'menu-item-status'    => 'publish',
                    'menu-item-position'  => $order,
                ];

                // Add sg-cta class to Contact
                if ($slug === 'contact') {
                    $item_data['menu-item-classes'] = 'sg-cta';
                }

                wp_update_nav_menu_item($menu_id, 0, $item_data);
                $order++;
            }
        }

        // Assign to theme location
        $locations = get_theme_mod('nav_menu_locations', []);
        $locations['primary'] = $menu_id;
        set_theme_mod('nav_menu_locations', $locations);
    }
}

/* =============================================
   FLUSH REWRITE
============================================= */
add_action('admin_init', function () {
    if (get_option('sg_flush_rewrite') !== SG_VERSION) {
        flush_rewrite_rules();
        update_option('sg_flush_rewrite', SG_VERSION);
    }
});
