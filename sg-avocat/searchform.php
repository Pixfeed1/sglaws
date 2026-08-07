<?php if (!defined('ABSPATH')) exit; ?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
  <div class="search-bar__inner">
    <svg class="search-bar__icon" viewBox="0 0 24 24" aria-hidden="true"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
    <input class="search-bar__input" type="search" name="s" placeholder="Rechercher un article..." value="<?php echo get_search_query(); ?>" required>
    <button type="submit" class="search-bar__submit" aria-label="Rechercher">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
    </button>
  </div>
</form>
