<?php
if (!defined('ABSPATH')) exit;
/**
 * Sommaire d'article — remplace l'extension Easy Table of Contents.
 *
 * Deux réglages par article, dans le panneau latéral de l'éditeur : afficher
 * ou non le sommaire, et de quel côté le placer sur grand écran. En dessous de
 * 1025 px il n'y a pas de place pour un rail latéral : le sommaire redevient
 * un bloc repliable en tête d'article, quel que soit le côté choisi.
 *
 * @package SG_Avocat
 */

const SG_TOC_META     = '_sg_toc';
const SG_TOC_POSITION = '_sg_toc_position';

add_action('init', function () {
    $droit = function () {
        return current_user_can('edit_posts');
    };
    register_post_meta('post', SG_TOC_META, [
        'type'          => 'boolean',
        'single'        => true,
        'default'       => false,
        'show_in_rest'  => true,
        'auth_callback' => $droit,
    ]);
    register_post_meta('post', SG_TOC_POSITION, [
        'type'              => 'string',
        'single'            => true,
        'default'           => 'gauche',
        'show_in_rest'      => true,
        'auth_callback'     => $droit,
        'sanitize_callback' => function ($v) {
            return $v === 'droite' ? 'droite' : 'gauche';
        },
    ]);
});

add_action('enqueue_block_editor_assets', function () {
    if (get_post_type() !== 'post') {
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
 * Numérote les titres de niveau 2 et 3 et en dresse la liste.
 *
 * Seules les balises de titre sont réécrites : le reste du contenu ressort
 * octet pour octet. Un identifiant déjà posé — par l'éditeur ou à la main —
 * est conservé, pour ne pas casser un lien qui pointerait dessus.
 *
 * @return array{0:string,1:array} Le contenu ancré, puis les entrées relevées.
 */
function sg_toc_ancrer($contenu) {
    $entrees = [];
    $pris    = [];

    $contenu = preg_replace_callback(
        '#<h([23])([^>]*)>(.*?)</h\1>#is',
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
 * Balisage du sommaire. Rendu fermé : sur grand écran la feuille de style
 * rouvre la liste, ce qui évite qu'elle clignote à l'ouverture de la page.
 */
function sg_toc_balisage($entrees) {
    if (count($entrees) < 2) {
        return '';
    }

    $out  = '<details class="sg-toc">';
    $out .= '<summary class="sg-toc__head">' . esc_html(sg_text('article_toc_titre', 'Sommaire')) . '</summary>';
    $out .= '<ol class="sg-toc__list">';
    foreach ($entrees as $e) {
        $out .= '<li class="sg-toc__item' . ($e['niveau'] === 3 ? ' sg-toc__item--sub' : '') . '">';
        $out .= '<a href="#' . esc_attr($e['id']) . '">' . esc_html($e['titre']) . '</a>';
        $out .= '</li>';
    }
    $out .= '</ol></details>';

    return $out;
}

/**
 * Contenu de l'article en cours, sommaire compris.
 *
 * @return array{classe:string,sommaire:string,contenu:string}
 */
function sg_toc_article() {
    $contenu = apply_filters('the_content', get_the_content());

    if (!get_post_meta(get_the_ID(), SG_TOC_META, true)) {
        return ['classe' => '', 'sommaire' => '', 'contenu' => $contenu];
    }

    list($contenu, $entrees) = sg_toc_ancrer($contenu);
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
