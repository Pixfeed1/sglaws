<?php
if (!defined('ABSPATH')) exit;
/**
 * Sommaire — remplace l'extension Easy Table of Contents.
 *
 * Deux réglages, par article comme par page, dans le panneau latéral de
 * l'éditeur : afficher ou non le sommaire, et de quel côté le placer sur grand
 * écran. En dessous de 1025 px il n'y a pas la place d'un rail latéral : le
 * sommaire redevient un bloc repliable en tête de contenu, quel que soit le
 * côté choisi.
 *
 * @package SG_Avocat
 */

const SG_TOC_META     = '_sg_toc';
const SG_TOC_POSITION = '_sg_toc_position';
const SG_TOC_PROFONDEUR = '_sg_toc_profondeur';

add_action('init', function () {
    $droit = function () {
        return current_user_can('edit_posts');
    };
    foreach (['post', 'page'] as $type) {
        register_post_meta($type, SG_TOC_META, [
            'type'          => 'boolean',
            'single'        => true,
            'default'       => false,
            'show_in_rest'  => true,
            'auth_callback' => $droit,
        ]);
        register_post_meta($type, SG_TOC_POSITION, [
            'type'              => 'string',
            'single'            => true,
            'default'           => 'gauche',
            'show_in_rest'      => true,
            'auth_callback'     => $droit,
            'sanitize_callback' => function ($v) {
                return $v === 'droite' ? 'droite' : 'gauche';
            },
        ]);
        register_post_meta($type, SG_TOC_PROFONDEUR, [
            'type'              => 'integer',
            'single'            => true,
            'default'           => 3,
            'show_in_rest'      => true,
            'auth_callback'     => $droit,
            'sanitize_callback' => 'sg_toc_profondeur_valide',
        ]);
    }
});

/**
 * Niveau de titre le plus profond repris par le sommaire.
 *
 * Trois valeurs seulement : 2 pour les sections, 3 pour les sous-sections,
 * 6 pour tout. Descendre plus bas n'a de sens que dans le bloc replié : dans
 * le rail, large de 220 px, un quatrième niveau indenté ne laisse plus assez
 * de place au texte et les titres partent sur trois lignes.
 */
function sg_toc_profondeur_valide($valeur) {
    $valeur = (int) $valeur;
    return in_array($valeur, [2, 3, 6], true) ? $valeur : 3;
}

add_action('enqueue_block_editor_assets', function () {
    if (!in_array(get_post_type(), ['post', 'page'], true)) {
        return;
    }
    wp_enqueue_script(
        'sg-editor-toc',
        SG_URI . '/js/editor-toc.js',
        ['wp-plugins', 'wp-editor', 'wp-components', 'wp-data', 'wp-element', 'wp-core-data'],
        SG_VERSION,
        true
    );
});

/**
 * Numérote les titres jusqu'au niveau demandé et en dresse la liste.
 *
 * Le titre de l'article est exclu d'office : c'est le nom du contenu, pas une
 * de ses sections, et le faire figurer dans son propre sommaire n'aurait pas
 * de sens.
 *
 * Seules les balises de titre sont réécrites : le reste du contenu ressort
 * octet pour octet. Un identifiant déjà posé — par l'éditeur ou à la main —
 * est conservé, pour ne pas casser un lien qui pointerait dessus.
 *
 * @return array{0:string,1:array} Le contenu ancré, puis les entrées relevées.
 */
function sg_toc_ancrer($contenu, $profondeur = 3) {
    $entrees = [];
    $pris    = [];

    $contenu = preg_replace_callback(
        '#<h([2-' . sg_toc_profondeur_valide($profondeur) . '])([^>]*)>(.*?)</h\1>#is',
        function ($m) use (&$entrees, &$pris) {
            $niveau = (int) $m[1];
            $attrs  = $m[2];
            $titre  = trim(wp_strip_all_tags($m[3]));

            if ($titre === '') {
                return $m[0];
            }

            if (preg_match('#\bid=["\']([^"\']+)["\']#i', $attrs, $existant)) {
                $id = $existant[1];
            } else {
                $base = sanitize_title($titre);
                $base = $base !== '' ? $base : 'section';
                $id   = $base;
                $n    = 2;
                while (isset($pris[$id])) {
                    $id = $base . '-' . $n++;
                }
                $attrs .= ' id="' . esc_attr($id) . '"';
            }

            $pris[$id] = true;
            $entrees[] = ['id' => $id, 'titre' => $titre, 'niveau' => $niveau];

            return '<h' . $niveau . $attrs . '>' . $m[3] . '</h' . $niveau . '>';
        },
        $contenu
    );

    return [$contenu, $entrees];
}

/**
 * Balisage du sommaire. Rendu fermé : c'est le script qui pose l'attribut open
 * sur grand écran, afin que l'état annoncé aux lecteurs d'écran corresponde à
 * ce qui est affiché.
 */
function sg_toc_balisage($entrees) {
    // Deux entrées ne font pas un sommaire : elles occupent de la place sans
    // rien faire gagner au lecteur, qui voit déjà les deux titres à l'écran.
    if (count($entrees) < 3) {
        return '';
    }

    $out  = '<details class="sg-toc">';
    $out .= '<summary class="sg-toc__head">' . esc_html(sg_text('article_toc_titre', 'Sommaire')) . '</summary>';
    $out .= '<ol class="sg-toc__list">';
    foreach ($entrees as $e) {
        $classe = 'sg-toc__item';
        if ($e['niveau'] > 2) {
            $classe .= ' sg-toc__item--n' . min($e['niveau'], 4);
        }
        $out .= '<li class="' . $classe . '">';
        $out .= '<a href="#' . esc_attr($e['id']) . '">' . esc_html($e['titre']) . '</a>';
        $out .= '</li>';
    }
    $out .= '</ol></details>';

    return $out;
}

/**
 * Contenu en cours de rendu, sommaire compris. Vaut pour un article comme pour
 * une page : c'est au gabarit d'appeler cette fonction plutôt que the_content().
 *
 * @return array{classe:string,sommaire:string,contenu:string}
 */
function sg_toc_article() {
    $contenu = apply_filters('the_content', get_the_content());

    if (!get_post_meta(get_the_ID(), SG_TOC_META, true)) {
        return ['classe' => '', 'sommaire' => '', 'contenu' => $contenu];
    }

    $profondeur = sg_toc_profondeur_valide(get_post_meta(get_the_ID(), SG_TOC_PROFONDEUR, true));
    list($contenu, $entrees) = sg_toc_ancrer($contenu, $profondeur);
    $sommaire = sg_toc_balisage($entrees);

    if ($sommaire === '') {
        return ['classe' => '', 'sommaire' => '', 'contenu' => $contenu];
    }

    $position = get_post_meta(get_the_ID(), SG_TOC_POSITION, true) === 'droite' ? 'droite' : 'gauche';

    return [
        'classe'   => 'article-layout article-layout--' . $position,
        'sommaire' => $sommaire,
        'contenu'  => $contenu,
    ];
}

/**
 * Classe de disposition à poser sur le conteneur, connue avant l'ouverture de
 * la boucle. Les gabarits de page ouvrent leur conteneur avant d'appeler
 * sg_toc_article() : sans cela, la classe arriverait trop tard.
 */
function sg_toc_classe() {
    if (!is_singular() || !get_post_meta(get_queried_object_id(), SG_TOC_META, true)) {
        return '';
    }
    $position = get_post_meta(get_queried_object_id(), SG_TOC_POSITION, true) === 'droite' ? 'droite' : 'gauche';
    return 'article-layout article-layout--' . $position;
}

/**
 * La page en cours porte-t-elle un contenu rédigé dans WordPress ?
 *
 * Un gabarit qui ouvre sa section sans le vérifier laisse, sur une page vide,
 * une bande blanche de plusieurs centaines de pixels : l'habillage de la
 * section s'affiche même lorsqu'il n'y a rien à l'intérieur.
 */
function sg_a_du_contenu() {
    return trim((string) get_post_field('post_content', get_queried_object_id())) !== '';
}
