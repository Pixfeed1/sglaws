<?php
if (!defined('ABSPATH')) exit;
$url = urlencode(get_permalink());
$title = urlencode(get_the_title());
?>
<div class="article-share">
  <span class="article-share__label">Partager</span>
  <div class="article-share__links">
    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $url; ?>" target="_blank" rel="noopener" class="article-share__btn article-share__btn--fill" title="LinkedIn">
      <svg viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2zM4 2a2 2 0 110 4 2 2 0 010-4z"/></svg>
    </a>
    <a href="https://twitter.com/intent/tweet?url=<?php echo $url; ?>&text=<?php echo $title; ?>" target="_blank" rel="noopener" class="article-share__btn article-share__btn--fill" title="X">
      <svg viewBox="0 0 24 24"><path d="M4 4l6.5 8.5L4 20h2l5.5-6.3L16 20h4l-7-9 6-7h-2l-5 5.7L8 4H4z"/></svg>
    </a>
    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>" target="_blank" rel="noopener" class="article-share__btn article-share__btn--fill" title="Facebook">
      <svg viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3V2z"/></svg>
    </a>
    <a href="mailto:?subject=<?php echo $title; ?>&body=<?php echo $url; ?>" class="article-share__btn" title="Email">
      <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
    </a>
  </div>
</div>
