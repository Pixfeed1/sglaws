<?php
if (!defined('ABSPATH')) exit;
/**
 * Admin — Configuration SMTP
 * Configurateur intégré au thème, fallback sur wp_mail() si non configuré
 * @package SG_Avocat
 */

add_action('admin_menu', function () {
    add_submenu_page(
        'options-general.php',
        'Configuration SMTP',
        'SMTP',
        'manage_options',
        'sg-smtp',
        'sg_render_smtp_page'
    );
});

add_action('admin_init', function () {
    register_setting('sg_smtp_group', 'sg_smtp_settings', [
        'type'              => 'array',
        'sanitize_callback' => 'sg_sanitize_smtp',
    ]);
});

function sg_sanitize_smtp($input) {
    $clean = [];
    $clean['enabled']   = !empty($input['enabled']) ? 1 : 0;
    $clean['host']      = sanitize_text_field($input['host'] ?? '');
    $clean['port']      = absint($input['port'] ?? 587);
    $clean['encryption']= in_array($input['encryption'] ?? '', ['', 'ssl', 'tls']) ? $input['encryption'] : 'tls';
    $clean['auth']      = !empty($input['auth']) ? 1 : 0;
    $clean['username']  = sanitize_text_field($input['username'] ?? '');
    // Only update password if provided (don't wipe existing)
    $existing = get_option('sg_smtp_settings', []);
    $clean['password']  = !empty($input['password']) ? $input['password'] : ($existing['password'] ?? '');
    $clean['from_email']= sanitize_email($input['from_email'] ?? '');
    $clean['from_name'] = sanitize_text_field($input['from_name'] ?? '');
    $clean['formspree'] = esc_url_raw($input['formspree'] ?? '');
    return $clean;
}

/* =============================================
   APPLY SMTP CONFIG TO wp_mail
============================================= */
add_action('phpmailer_init', function ($phpmailer) {
    $settings = get_option('sg_smtp_settings', []);

    if (empty($settings['enabled']) || empty($settings['host'])) return;

    $phpmailer->isSMTP();
    $phpmailer->Host       = $settings['host'];
    $phpmailer->Port       = $settings['port'] ?: 587;
    $phpmailer->SMTPSecure = $settings['encryption'] ?: '';

    /* Localhost: disable auto-TLS upgrade (no cert on 127.0.0.1) */
    if (in_array($settings['host'], ['127.0.0.1', 'localhost']) || empty($settings['encryption'])) {
        $phpmailer->SMTPAutoTLS = false;
    }

    if (!empty($settings['auth'])) {
        $phpmailer->SMTPAuth = true;
        $phpmailer->Username = $settings['username'];
        $phpmailer->Password = $settings['password'];
    }

    if (!empty($settings['from_email'])) {
        $phpmailer->From     = $settings['from_email'];
        $phpmailer->FromName = $settings['from_name'] ?: get_bloginfo('name');
    }
});

/* =============================================
   ADMIN PAGE
============================================= */
function sg_render_smtp_page() {
    $s = get_option('sg_smtp_settings', []);
    $enabled    = $s['enabled'] ?? 0;
    $host       = $s['host'] ?? '';
    $port       = $s['port'] ?? 587;
    $encryption = $s['encryption'] ?? 'tls';
    $auth       = $s['auth'] ?? 1;
    $username   = $s['username'] ?? '';
    $password   = $s['password'] ?? '';
    $from_email = $s['from_email'] ?? '';
    $from_name  = $s['from_name'] ?? '';
    $formspree  = $s['formspree'] ?? '';

    if (isset($_GET['settings-updated']) && $_GET['settings-updated'] === 'true') {
        echo '<div class="notice notice-success is-dismissible"><p>Configuration SMTP enregistrée.</p></div>';
    }

    // Test email result
    if (isset($_GET['sg-smtp-test']) && $_GET['sg-smtp-test'] === 'sent') {
        echo '<div class="notice notice-success is-dismissible"><p>Email de test envoyé avec succès.</p></div>';
    }
    if (isset($_GET['sg-smtp-test']) && $_GET['sg-smtp-test'] === 'failed') {
        $error_msg = isset($_GET['sg-smtp-error']) ? esc_html(urldecode($_GET['sg-smtp-error'])) : '';
        echo '<div class="notice notice-error is-dismissible"><p>Échec de l\'envoi. Vérifiez votre configuration SMTP.' . ($error_msg ? '<br><strong>Erreur :</strong> ' . $error_msg : '') . '</p></div>';
    }
    ?>
    <div class="wrap">
        <h1>Configuration SMTP</h1>
        <p class="description">Configurez l'envoi d'emails via SMTP ou Formspree pour une meilleure délivrabilité. Les messages sont toujours sauvegardés dans la section Messages de l'admin.</p>

        <form method="post" action="options.php">
            <?php settings_fields('sg_smtp_group'); ?>

            <h3>Formspree (recommandé)</h3>
            <table class="form-table">
                <tr>
                    <th>URL Formspree</th>
                    <td>
                        <input type="url" name="sg_smtp_settings[formspree]" id="sg-formspree-url" value="<?php echo esc_url($formspree); ?>" class="large-text" placeholder="https://formspree.io/f/xyzabc123">
                        <p class="description">Créez un formulaire sur <a href="https://formspree.io" target="_blank">formspree.io</a> (gratuit, 50 envois/mois) et collez l'URL ici. Les soumissions seront envoyées par email via Formspree ET sauvegardées dans Messages.</p>
                        <p style="margin-top:8px;">
                            <button type="button" class="button" id="sg-formspree-test">Tester Formspree</button>
                            <span id="sg-formspree-result" style="margin-left:10px;"></span>
                        </p>
                        <script>
                        document.getElementById('sg-formspree-test').addEventListener('click', function() {
                            var url = document.getElementById('sg-formspree-url').value.trim();
                            var result = document.getElementById('sg-formspree-result');
                            if (!url) { result.innerHTML = '<span style="color:#d63638;">Entrez une URL Formspree d\'abord.</span>'; return; }
                            result.innerHTML = '<em>Envoi en cours...</em>';
                            fetch(url, {
                                method: 'POST',
                                headers: { 'Accept': 'application/json', 'Content-Type': 'application/json' },
                                body: JSON.stringify({ name: 'Test SMTP', email: 'test@gueffie-avocat.fr', message: 'Email de test depuis WordPress — ' + new Date().toLocaleString('fr-FR'), source: 'test-admin' })
                            })
                            .then(function(r) {
                                if (r.ok) { result.innerHTML = '<span style="color:#00a32a;"><strong>✓ Envoyé avec succès !</strong> Vérifiez votre boîte mail.</span>'; }
                                else { r.json().then(function(d) { result.innerHTML = '<span style="color:#d63638;">Erreur : ' + (d.error || 'Vérifiez l\'URL') + '</span>'; }); }
                            })
                            .catch(function() { result.innerHTML = '<span style="color:#d63638;">Erreur de connexion. Vérifiez l\'URL.</span>'; });
                        });
                        </script>
                    </td>
                </tr>
            </table>

            <hr>

            <table class="form-table">
                <tr>
                    <th>Activer SMTP</th>
                    <td>
                        <label>
                            <input type="checkbox" name="sg_smtp_settings[enabled]" value="1" <?php checked($enabled, 1); ?>>
                            Utiliser un serveur SMTP pour l'envoi des emails
                        </label>
                        <p class="description">Si décoché, les emails seront envoyés via la fonction mail() de PHP (moins fiable).</p>
                    </td>
                </tr>
            </table>

            <div id="sg-smtp-fields" style="<?php echo $enabled ? '' : 'opacity:0.4;pointer-events:none;'; ?>">
                <h3>Serveur SMTP</h3>
                <table class="form-table">
                    <tr>
                        <th>Hôte SMTP</th>
                        <td><input type="text" name="sg_smtp_settings[host]" value="<?php echo esc_attr($host); ?>" class="regular-text" placeholder="smtp.exemple.com"></td>
                    </tr>
                    <tr>
                        <th>Port</th>
                        <td>
                            <input type="number" name="sg_smtp_settings[port]" value="<?php echo esc_attr($port); ?>" class="small-text">
                            <p class="description">587 (TLS) ou 465 (SSL) sont les plus courants.</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Chiffrement</th>
                        <td>
                            <select name="sg_smtp_settings[encryption]">
                                <option value="tls" <?php selected($encryption, 'tls'); ?>>TLS</option>
                                <option value="ssl" <?php selected($encryption, 'ssl'); ?>>SSL</option>
                                <option value="" <?php selected($encryption, ''); ?>>Aucun</option>
                            </select>
                        </td>
                    </tr>
                </table>

                <h3>Authentification</h3>
                <table class="form-table">
                    <tr>
                        <th>Authentification</th>
                        <td>
                            <label>
                                <input type="checkbox" name="sg_smtp_settings[auth]" value="1" <?php checked($auth, 1); ?>>
                                Utiliser l'authentification SMTP
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <th>Identifiant</th>
                        <td><input type="text" name="sg_smtp_settings[username]" value="<?php echo esc_attr($username); ?>" class="regular-text" autocomplete="off"></td>
                    </tr>
                    <tr>
                        <th>Mot de passe</th>
                        <td>
                            <input type="password" name="sg_smtp_settings[password]" value="" class="regular-text" autocomplete="new-password" placeholder="<?php echo $password ? '••••••••' : ''; ?>">
                            <p class="description"><?php echo $password ? 'Mot de passe enregistré. Laissez vide pour ne pas modifier.' : 'Entrez le mot de passe SMTP.'; ?></p>
                        </td>
                    </tr>
                </table>

                <h3>Expéditeur</h3>
                <table class="form-table">
                    <tr>
                        <th>Email expéditeur</th>
                        <td>
                            <input type="email" name="sg_smtp_settings[from_email]" value="<?php echo esc_attr($from_email); ?>" class="regular-text" placeholder="contact@votre-domaine.fr">
                            <p class="description">L'adresse qui apparaîtra comme expéditeur. Doit correspondre au domaine du serveur SMTP.</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Nom expéditeur</th>
                        <td><input type="text" name="sg_smtp_settings[from_name]" value="<?php echo esc_attr($from_name); ?>" class="regular-text" placeholder="Me Seri Gueffie"></td>
                    </tr>
                </table>
            </div>

            <?php submit_button('Enregistrer la configuration'); ?>
        </form>

        <?php if ($enabled && $host) : ?>
        <hr>
        <h3>Test d'envoi</h3>
        <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
            <input type="hidden" name="action" value="sg_smtp_test">
            <?php wp_nonce_field('sg_smtp_test_nonce', 'sg_smtp_test_field'); ?>
            <table class="form-table">
                <tr>
                    <th>Email de test</th>
                    <td>
                        <input type="email" name="test_email" value="<?php echo esc_attr(wp_get_current_user()->user_email); ?>" class="regular-text">
                        <?php submit_button('Envoyer un email de test', 'secondary', 'submit-test', false); ?>
                    </td>
                </tr>
            </table>
        </form>
        <?php endif; ?>

        <hr>
        <h3>Presets rapides</h3>
        <p class="description">Cliquez sur un preset pour pré-remplir les champs. Vous devrez entrer votre identifiant et mot de passe.</p>
        <p>
            <button type="button" class="button" onclick="sgSmtpPreset('smtp.hostinger.com', 465, 'ssl')">Hostinger</button>
            <button type="button" class="button" onclick="sgSmtpPreset('ssl0.ovh.net', 465, 'ssl')">OVH</button>
            <button type="button" class="button" onclick="sgSmtpPreset('smtp-relay.brevo.com', 587, 'tls')">Brevo (ex-Sendinblue)</button>
            <button type="button" class="button" onclick="sgSmtpPreset('smtp.gmail.com', 587, 'tls')">Gmail</button>
            <button type="button" class="button" onclick="sgSmtpPreset('smtp.office365.com', 587, 'tls')">Outlook / Office 365</button>
            <button type="button" class="button" onclick="sgSmtpPreset('smtp.mailgun.org', 587, 'tls')">Mailgun</button>
        </p>
    </div>

    <script>
    (function() {
        var checkbox = document.querySelector('[name="sg_smtp_settings[enabled]"]');
        var fields = document.getElementById('sg-smtp-fields');
        if (checkbox && fields) {
            checkbox.addEventListener('change', function() {
                fields.style.opacity = this.checked ? '' : '0.4';
                fields.style.pointerEvents = this.checked ? '' : 'none';
            });
        }
    })();

    function sgSmtpPreset(host, port, enc) {
        document.querySelector('[name="sg_smtp_settings[host]"]').value = host;
        document.querySelector('[name="sg_smtp_settings[port]"]').value = port;
        document.querySelector('[name="sg_smtp_settings[encryption]"]').value = enc;
    }
    </script>
    <?php
}

/* =============================================
   TEST EMAIL HANDLER
============================================= */
add_action('admin_post_sg_smtp_test', function () {
    if (!current_user_can('manage_options')) wp_die('Non autorisé');
    check_admin_referer('sg_smtp_test_nonce', 'sg_smtp_test_field');

    $to = sanitize_email($_POST['test_email'] ?? '');
    if (!$to) {
        wp_redirect(admin_url('options-general.php?page=sg-smtp&sg-smtp-test=failed'));
        exit;
    }

    /* Capture PHPMailer errors */
    global $sg_smtp_debug;
    $sg_smtp_debug = '';
    add_action('wp_mail_failed', function ($error) {
        global $sg_smtp_debug;
        $sg_smtp_debug = $error->get_error_message();
    });

    $subject = 'Test SMTP — ' . get_bloginfo('name');
    $body = "Cet email confirme que la configuration SMTP fonctionne correctement.\n\nEnvoyé depuis : " . home_url() . "\nDate : " . current_time('d/m/Y H:i');
    $result = wp_mail($to, $subject, $body);

    $status = $result ? 'sent' : 'failed';
    $redirect = admin_url('options-general.php?page=sg-smtp&sg-smtp-test=' . $status);
    if (!$result && $sg_smtp_debug) {
        $redirect .= '&sg-smtp-error=' . urlencode($sg_smtp_debug);
    }
    wp_redirect($redirect);
    exit;
});
