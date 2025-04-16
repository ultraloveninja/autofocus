<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AutoFocus
 */

get_header(); 
?>

<div id="container">
    <div id="content" class="index">
        <?php if (have_posts()) : ?>
            <div id="nav-above" class="navigation">
                <div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts', 'autofocus')); ?></div>
                <div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&raquo;</span>', 'autofocus')); ?></div>
            </div>

            <?php
            // Start the Loop
            while (have_posts()) : the_post();
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <h2 class="entry-title">
                    <a href="<?php the_permalink(); ?>" title="<?php printf(__('Permalink to %s', 'autofocus'), the_title_attribute('echo=0')); ?>" rel="bookmark">
                        <?php the_title(); ?>
                    </a>
                </h2>
                
                <div class="entry-date">
                    <time class="published" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                        <?php the_time('d M'); ?>
                    </time>
                </div>
                
                <div class="entry-content">
                    <?php 
                    the_content(sprintf(
                        __('Read More %s', 'autofocus'),
                        '<span class="meta-nav">&raquo;</span>'
                    )); 
                    
                    wp_link_pages(array(
                        'before' => '<div class="page-link">' . __('Pages:', 'autofocus'),
                        'after'  => '</div>',
                    ));
                    ?>
                </div><!-- .entry-content -->
                
                <div class="entry-meta">
                    <span class="author vcard">
                        <?php 
                        printf(
                            __('By %s', 'autofocus'),
                            '<a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" title="' . esc_attr(sprintf(__('View all posts by %s', 'autofocus'), get_the_author())) . '">' . get_the_author() . '</a>'
                        ); 
                        ?>
                    </span>
                    
                    <span class="cat-links">
                        <?php printf(__('Posted in %s', 'autofocus'), get_the_category_list(', ')); ?>
                    </span>
                    
                    <?php the_tags('<span class="tag-links">' . __('Tagged ', 'autofocus'), ', ', '</span>'); ?>
                    
                    <span class="comments-link">
                        <?php 
                        comments_popup_link(
                            __('Comments (0)', 'autofocus'),
                            __('Comments (1)', 'autofocus'),
                            __('Comments (%)', 'autofocus')
                        ); 
                        ?>
                    </span>
                    
                    <?php 
                    edit_post_link(
                        __('Edit', 'autofocus'),
                        '<span class="edit-link">',
                        '</span>'
                    ); 
                    ?>
                </div><!-- .entry-meta -->
            </article><!-- .post -->

            <?php
                // If comments are open or we have at least one comment, load up the comment template
                if (comments_open() || get_comments_number()) :
                    comments_template();
                endif;
            ?>

            <?php endwhile; ?>

            <div id="nav-below" class="navigation">
                <div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts', 'autofocus')); ?></div>
                <div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&raquo;</span>', 'autofocus')); ?></div>
            </div>

        <?php else : ?>

            <article id="post-0" class="post no-results not-found">
                <h2 class="entry-title"><?php _e('Nothing Found', 'autofocus'); ?></h2>
                <div class="entry-content">
                    <p><?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'autofocus'); ?></p>
                    <?php get_search_form(); ?>
                </div><!-- .entry-content -->
            </article><!-- .post -->

        <?php endif; ?>
    </div><!-- #content -->
</div><!-- #container -->

<?php
get_sidebar();
get_footer();