<?php
if (!defined('ABSPATH')) exit;
/**
 * Admin — Messages reçus
 * Stockage des messages du formulaire de contact en base de données
 * @package SG_Avocat
 */

/* =============================================
   CUSTOM POST TYPE — Messages (hidden from front)
============================================= */
add_action('init', function () {
    register_post_type('sg_message', [
        'labels' => [
            'name'               => 'Messages',
            'singular_name'      => 'Message',
            'menu_name'          => 'Messages',
            'all_items'          => 'Tous les messages',
            'search_items'       => 'Rechercher',
            'not_found'          => 'Aucun message',
            'not_found_in_trash' => 'Aucun message dans la corbeille',
        ],
        'public'            => false,
        'show_ui'           => true,
        'show_in_menu'      => true,
        'menu_icon'         => 'dashicons-email-alt',
        'menu_position'     => 26,
        'supports'          => false,
        'capability_type'   => 'post',
        'capabilities'      => [
            'create_posts' => 'do_not_allow',
        ],
        'map_meta_cap'      => true,
    ]);
});

/* =============================================
   SAVE MESSAGE TO DB
============================================= */
function sg_save_message($data) {
    $post_id = wp_insert_post([
        'post_type'   => 'sg_message',
        'post_title'  => sanitize_text_field($data['name']) . ' — ' . sanitize_email($data['email']),
        'post_status' => 'publish',
        'post_date'   => current_time('mysql'),
    ]);

    if ($post_id && !is_wp_error($post_id)) {
        update_post_meta($post_id, '_sg_msg_name', sanitize_text_field($data['name']));
        update_post_meta($post_id, '_sg_msg_prenom', sanitize_text_field($data['prenom'] ?? ''));
        update_post_meta($post_id, '_sg_msg_email', sanitize_email($data['email']));
        update_post_meta($post_id, '_sg_msg_phone', sanitize_text_field($data['phone'] ?? ''));
        update_post_meta($post_id, '_sg_msg_domain', sanitize_text_field($data['domain'] ?? ''));
        update_post_meta($post_id, '_sg_msg_enjeu', sanitize_text_field($data['enjeu'] ?? ''));
        update_post_meta($post_id, '_sg_msg_message', sanitize_textarea_field($data['message']));
        update_post_meta($post_id, '_sg_msg_source', sanitize_text_field($data['source'] ?? 'contact'));
        update_post_meta($post_id, '_sg_msg_status', 'nouveau');
        update_post_meta($post_id, '_sg_msg_ip', sanitize_text_field($_SERVER['REMOTE_ADDR'] ?? ''));
    }

    return $post_id;
}

/* =============================================
   ADMIN COLUMNS
============================================= */
add_filter('manage_sg_message_posts_columns', function ($columns) {
    return [
        'cb'         => '<input type="checkbox">',
        'sg_status'  => 'Statut',
        'title'      => 'Expéditeur',
        'sg_email'   => 'Email',
        'sg_phone'   => 'Téléphone',
        'sg_domain'  => 'Domaine',
        'sg_enjeu'   => 'Enjeu',
        'sg_source'  => 'Source',
        'date'       => 'Date',
    ];
});

add_action('manage_sg_message_posts_custom_column', function ($column, $post_id) {
    switch ($column) {
        case 'sg_status':
            $status = get_post_meta($post_id, '_sg_msg_status', true) ?: 'nouveau';
            $colors = ['nouveau' => '#111', 'lu' => '#888', 'traite' => '#00a32a', 'archive' => '#bbb'];
            $labels = ['nouveau' => '● Nouveau', 'lu' => '● Lu', 'traite' => '● Traité', 'archive' => '● Archivé'];
            echo '<span style="color:' . ($colors[$status] ?? '#888') . ';font-weight:500;font-size:12px;">' . ($labels[$status] ?? $status) . '</span>';
            break;
        case 'sg_email':
            $email = get_post_meta($post_id, '_sg_msg_email', true);
            echo '<a href="mailto:' . esc_attr($email) . '">' . esc_html($email) . '</a>';
            break;
        case 'sg_phone':
            $phone = get_post_meta($post_id, '_sg_msg_phone', true);
            echo $phone ? '<a href="tel:' . esc_attr($phone) . '">' . esc_html($phone) . '</a>' : '—';
            break;
        case 'sg_domain':
            echo esc_html(get_post_meta($post_id, '_sg_msg_domain', true) ?: '—');
            break;
        case 'sg_enjeu':
            echo esc_html(get_post_meta($post_id, '_sg_msg_enjeu', true) ?: '—');
            break;
        case 'sg_source':
            $src = get_post_meta($post_id, '_sg_msg_source', true) ?: 'contact';
            $labels = ['contact' => 'Contact', 'landing' => 'Landing', 'accueil' => 'Accueil'];
            echo esc_html($labels[$src] ?? $src);
            break;
    }
}, 10, 2);

/* =============================================
   MESSAGE DETAIL VIEW (replaces default edit screen)
============================================= */
add_action('add_meta_boxes', function () {
    add_meta_box('sg_msg_detail', 'Détail du message', 'sg_msg_detail_metabox', 'sg_message', 'normal', 'high');
    add_meta_box('sg_msg_actions', 'Actions', 'sg_msg_actions_metabox', 'sg_message', 'side', 'high');
});

function sg_msg_detail_metabox($post) {
    $name    = get_post_meta($post->ID, '_sg_msg_name', true);
    $prenom  = get_post_meta($post->ID, '_sg_msg_prenom', true);
    $email   = get_post_meta($post->ID, '_sg_msg_email', true);
    $phone   = get_post_meta($post->ID, '_sg_msg_phone', true);
    $domain  = get_post_meta($post->ID, '_sg_msg_domain', true);
    $enjeu   = get_post_meta($post->ID, '_sg_msg_enjeu', true);
    $message = get_post_meta($post->ID, '_sg_msg_message', true);
    $source  = get_post_meta($post->ID, '_sg_msg_source', true);
    $ip      = get_post_meta($post->ID, '_sg_msg_ip', true);

    // Mark as read
    $status = get_post_meta($post->ID, '_sg_msg_status', true);
    if ($status === 'nouveau') {
        update_post_meta($post->ID, '_sg_msg_status', 'lu');
    }
    ?>
    <style>
        .sg-msg-table { width:100%; border-collapse:collapse; }
        .sg-msg-table th { text-align:left; padding:10px 12px; font-size:12px; font-weight:600; color:#666; text-transform:uppercase; letter-spacing:0.05em; width:120px; vertical-align:top; border-bottom:1px solid #f0f0f1; }
        .sg-msg-table td { padding:10px 12px; font-size:14px; border-bottom:1px solid #f0f0f1; }
        .sg-msg-table td a { color:#111; }
        .sg-msg-body { background:#f9f9f9; padding:16px 20px; border-radius:4px; margin-top:12px; font-size:14px; line-height:1.8; white-space:pre-wrap; }
        .sg-msg-meta { font-size:11px; color:#999; margin-top:8px; }
    </style>
    <table class="sg-msg-table">
        <tr><th>Nom</th><td><?php echo esc_html($prenom . ' ' . $name); ?></td></tr>
        <tr><th>Email</th><td><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></td></tr>
        <?php if ($phone) : ?><tr><th>Téléphone</th><td><a href="tel:<?php echo esc_attr($phone); ?>"><?php echo esc_html($phone); ?></a></td></tr><?php endif; ?>
        <?php if ($domain) : ?><tr><th>Domaine</th><td><?php echo esc_html($domain); ?></td></tr><?php endif; ?>
        <?php if ($enjeu) : ?><tr><th>Enjeu</th><td><?php echo esc_html($enjeu); ?></td></tr><?php endif; ?>
        <tr><th>Date</th><td><?php echo get_the_date('d F Y à H:i', $post->ID); ?></td></tr>
    </table>
    <h4 style="margin:20px 0 0;font-size:12px;font-weight:600;color:#666;text-transform:uppercase;letter-spacing:0.05em;">Message</h4>
    <div class="sg-msg-body"><?php echo esc_html($message); ?></div>
    <div class="sg-msg-meta">Source : <?php echo esc_html($source ?: 'contact'); ?> · IP : <?php echo esc_html($ip ?: 'inconnue'); ?></div>
    <?php
}

function sg_msg_actions_metabox($post) {
    wp_nonce_field('sg_msg_status_nonce', 'sg_msg_status_field');
    $status = get_post_meta($post->ID, '_sg_msg_status', true) ?: 'nouveau';
    $email = get_post_meta($post->ID, '_sg_msg_email', true);
    ?>
    <p>
        <label style="font-size:12px;font-weight:600;">Statut</label><br>
        <select name="sg_msg_status" style="width:100%;margin-top:4px;">
            <option value="nouveau" <?php selected($status, 'nouveau'); ?>>● Nouveau</option>
            <option value="lu" <?php selected($status, 'lu'); ?>>● Lu</option>
            <option value="traite" <?php selected($status, 'traite'); ?>>● Traité</option>
            <option value="archive" <?php selected($status, 'archive'); ?>>● Archivé</option>
        </select>
    </p>
    <p>
        <a href="mailto:<?php echo esc_attr($email); ?>" class="button button-primary" style="width:100%;text-align:center;">Répondre par email</a>
    </p>
    <?php
}

add_action('save_post_sg_message', function ($post_id) {
    if (!isset($_POST['sg_msg_status_field']) || !wp_verify_nonce($_POST['sg_msg_status_field'], 'sg_msg_status_nonce')) return;
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (isset($_POST['sg_msg_status'])) {
        $allowed = ['nouveau', 'lu', 'traite', 'archive'];
        $status = sanitize_text_field($_POST['sg_msg_status']);
        if (in_array($status, $allowed)) {
            update_post_meta($post_id, '_sg_msg_status', $status);
        }
    }
});

/* =============================================
   UNREAD COUNT IN ADMIN MENU
============================================= */
add_action('admin_menu', function () {
    $count = get_posts([
        'post_type'   => 'sg_message',
        'post_status' => 'publish',
        'meta_key'    => '_sg_msg_status',
        'meta_value'  => 'nouveau',
        'numberposts' => -1,
        'fields'      => 'ids',
    ]);
    $unread = count($count);
    if ($unread > 0) {
        global $menu;
        foreach ($menu as $key => $item) {
            if (isset($item[2]) && $item[2] === 'edit.php?post_type=sg_message') {
                $menu[$key][0] .= ' <span class="awaiting-mod count-' . $unread . '"><span class="pending-count">' . $unread . '</span></span>';
                break;
            }
        }
    }
});

/* =============================================
   ROW ACTIONS — remove edit, add view
============================================= */
add_filter('post_row_actions', function ($actions, $post) {
    if ($post->post_type === 'sg_message') {
        unset($actions['inline hide-if-no-js']); // Remove quick edit
        $actions['view'] = '<a href="' . get_edit_post_link($post->ID) . '">Voir le message</a>';
    }
    return $actions;
}, 10, 2);

/* =============================================
   HIGHLIGHT NEW MESSAGES IN LIST
============================================= */
add_action('admin_head', function () {
    global $post_type;
    if ($post_type !== 'sg_message') return;
    ?>
    <style>
        .post-type-sg_message .type-sg_message { background:#fff; }
        .post-type-sg_message .type-sg_message td { vertical-align:middle; }
        .post-type-sg_message .wp-list-table th#sg_status { width:80px; }
        .post-type-sg_message .wp-list-table th#sg_source { width:80px; }
        .post-type-sg_message .row-title { font-weight:400 !important; }
    </style>
    <?php
});
