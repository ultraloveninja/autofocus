<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package AutoFocus
 */

get_header();
?>

<div id="container">
    <div id="content">
        <article id="post-0" class="post error404 not-found">
            <div class="category">
                <h2 class="entry-title"><?php _e('Not Found', 'autofocus'); ?></h2>
            </div>
            
            <div class="entry-content">
                <p><?php _e('Apologies, but we were unable to find what you were looking for. Perhaps browsing the archive will help.', 'autofocus'); ?></p>
            </div>
            
            <div class="archive-content">
                <?php get_sidebar(); ?>
            </div><!-- .archive-content -->
        </article><!-- .post -->
    </div><!-- #content -->
</div><!-- #container -->

<?php get_footer(); ?>