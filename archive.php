<?php
/**
 * The template for displaying all pages
 *
 * @package AutoFocus
 */

get_header();
?>

<div id="container">
    <div id="content">
        <?php
        while (have_posts()) : the_post();
        ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <h2 class="entry-title"><?php the_title(); ?></h2>
            
            <?php if (has_post_thumbnail()) : ?>
            <div class="full-photo">
                <?php the_post_thumbnail('large'); ?>
            </div>
            <?php endif; ?>
            
            <div class="entry-content">
                <?php
                the_content();
                
                wp_link_pages(array(
                    'before' => '<div class="page-link">' . __('Pages:', 'autofocus'),
                    'after'  => '</div>',
                ));
                ?>
            </div><!-- .entry-content -->

            <div class="entry-meta">
                <?php edit_post_link(__('Edit', 'autofocus'), '<span class="edit-link">', '</span>'); ?>
            </div><!-- .entry-meta -->
        </article><!-- .post -->

        <?php
        // If comments are open or we have at least one comment, load up the comment template
        if (get_post_custom_values('comments')) {
            comments_template();
        }
        
        endwhile; // End of the loop.
        ?>
    </div><!-- #content -->
</div><!-- #container -->

<?php
get_sidebar();
get_footer();