<?php
if (!defined('ABSPATH')) exit;
if (post_password_required()) return;
?>

<section class="comments">
  <div class="container">
    <div class="comments__inner">
      <div class="comments__header">
        <h2 class="comments__title">Vos <em>réactions</em></h2>
        <span class="comments__count"><?php echo get_comments_number(); ?> commentaire<?php echo get_comments_number() > 1 ? 's' : ''; ?></span>
      </div>

      <?php if (comments_open()) : ?>
        <div class="comments__form">
          <?php
          comment_form([
              'title_reply'          => '',
              'title_reply_to'       => '',
              'cancel_reply_link'    => 'Annuler',
              'label_submit'         => 'Publier le commentaire',
              'class_submit'         => 'comments__submit',
              'comment_field'        => '<div class="form-group"><textarea name="comment" class="comments__textarea" placeholder="Votre commentaire..." required></textarea></div>',
              'fields'               => [
                  'author' => '<div class="comments__form-row"><div class="form-group"><input name="author" class="comments__input" type="text" placeholder="Votre nom" required></div>',
                  'email'  => '<div class="form-group"><input name="email" class="comments__input" type="email" placeholder="Votre email (non publié)" required></div></div>',
              ],
              'submit_button'        => '<button type="submit" class="comments__submit">%4$s</button>',
              'comment_notes_before' => '',
              'comment_notes_after'  => '',
          ]);
          ?>
        </div>
      <?php endif; ?>

      <?php if (have_comments()) : ?>
        <?php wp_list_comments([
            'callback'    => 'sg_comment_callback',
            'avatar_size' => 0,
            'style'       => 'div',
        ]); ?>

        <?php if (get_comment_pages_count() > 1) : ?>
          <div style="text-align:center;padding:1.5rem 0;">
            <?php paginate_comments_links(['prev_text' => '←', 'next_text' => '→']); ?>
          </div>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php
function sg_comment_callback($comment, $args, $depth) {
    $is_author = ($comment->user_id == get_post_field('post_author', get_the_ID()));
    $initials = '';
    $name = get_comment_author();
    $parts = explode(' ', $name);
    foreach ($parts as $p) { if ($p) $initials .= strtoupper(mb_substr($p, 0, 1)); }
    $initials = mb_substr($initials, 0, 2);
    ?>
    <div <?php comment_class('comment'); ?> id="comment-<?php comment_ID(); ?>">
      <div class="comment__top">
        <div class="comment__avatar" <?php echo $is_author ? 'style="background:var(--black);color:var(--white);"' : ''; ?>><?php echo $initials; ?></div>
        <span class="comment__name"><?php echo esc_html($name); ?></span>
        <?php if ($is_author) : ?>
          <span class="comment__badge">Auteur</span>
        <?php endif; ?>
        <span class="comment__date"><?php echo get_comment_date('d F Y'); ?></span>
      </div>
      <p class="comment__text"><?php comment_text(); ?></p>
      <?php if ($depth < $args['max_depth']) : ?>
        <button class="comment__reply-btn" onclick="addComment.moveForm('comment-<?php comment_ID(); ?>','<?php comment_ID(); ?>','respond','<?php echo get_the_ID(); ?>')">Répondre</button>
      <?php endif; ?>
      <?php if ($depth > 1) : ?>
        </div>
      <?php endif; ?>
    <?php
}
?>
