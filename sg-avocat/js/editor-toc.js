/**
 * Panneau « Sommaire » dans la colonne de droite de l'éditeur.
 *
 * Écrit en JavaScript natif, sans étape de compilation : le thème n'a pas de
 * chaîne de construction, et un panneau de deux réglages n'en justifie pas une.
 */
(function (wp) {
  if (!wp || !wp.plugins || !wp.element) {
    return;
  }

  var el = wp.element.createElement;

  /* Le panneau a changé de paquet avec WordPress 6.6 : on prend celui qui
     répond, pour fonctionner avant comme après. */
  var Panneau =
    (wp.editor && wp.editor.PluginDocumentSettingPanel) ||
    (wp.editPost && wp.editPost.PluginDocumentSettingPanel);

  if (!Panneau) {
    return;
  }

  var CheckboxControl = wp.components.CheckboxControl;
  var RadioControl = wp.components.RadioControl;
  var SelectControl = wp.components.SelectControl;

  function SommairePanneau() {
    var typeArticle = wp.data.useSelect(function (select) {
      return select('core/editor').getCurrentPostType();
    }, []);

    if (typeArticle !== 'post' && typeArticle !== 'page') {
      return null;
    }

    var propriete = wp.coreData.useEntityProp('postType', typeArticle, 'meta');
    var meta = propriete[0] || {};
    var majMeta = propriete[1];

    var actif = !!meta._sg_toc;
    var position = meta._sg_toc_position === 'droite' ? 'droite' : 'gauche';
    var profondeur = String(meta._sg_toc_profondeur || 3);

    var enfants = [
      el(CheckboxControl, {
        key: 'actif',
        label: 'Afficher le sommaire',
        help: 'Construit automatiquement à partir des titres du contenu. Il n’apparaît qu’à partir de trois entrées.',
        checked: actif,
        onChange: function (valeur) {
          majMeta(Object.assign({}, meta, { _sg_toc: valeur }));
        },
      }),
    ];

    if (actif) {
      enfants.push(
        el(SelectControl, {
          key: 'profondeur',
          label: 'Ce que reprend le sommaire',
          help: 'Au-delà des sous-sections, les entrées deviennent étroites dans la colonne latérale. À réserver aux contenus très découpés.',
          value: profondeur,
          options: [
            { label: 'Les sections seulement', value: '2' },
            { label: 'Les sections et leurs sous-sections', value: '3' },
            { label: 'Tous les niveaux de titre', value: '6' },
          ],
          onChange: function (valeur) {
            majMeta(Object.assign({}, meta, { _sg_toc_profondeur: parseInt(valeur, 10) }));
          },
        })
      );
      enfants.push(
        el(RadioControl, {
          key: 'position',
          label: 'Position sur grand écran',
          help: 'Sur mobile et tablette, le sommaire se place toujours en tête de contenu, sous forme de bloc repliable.',
          selected: position,
          options: [
            { label: 'À gauche de l’article', value: 'gauche' },
            { label: 'À droite de l’article', value: 'droite' },
          ],
          onChange: function (valeur) {
            majMeta(Object.assign({}, meta, { _sg_toc_position: valeur }));
          },
        })
      );
    }

    return el(Panneau, { name: 'sg-toc', title: 'Sommaire' }, enfants);
  }

  wp.plugins.registerPlugin('sg-toc', { render: SommairePanneau, icon: null });
})(window.wp);
