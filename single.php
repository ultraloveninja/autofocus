<?php
/**
 * The template for displaying all single posts
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
        
        <div id="nav-above" class="navigation">
            <div class="nav-previous"><?php previous_post_link('%link', '<span class="meta-nav">&laquo;</span>'); ?></div>
            <div class="nav-next"><?php next_post_link('%link', '<span class="meta-nav">&raquo;</span>'); ?></div>
        </div>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="full-photo">
                <span class="photo-credit">&copy; <?php the_time('Y'); ?> <?php the_author(); ?></span>
                <?php autofocus_post_image('large'); ?>
            </div>

            <h2 class="entry-title"><?php the_title(); ?></h2>
            
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
                <span class="bigdate entry-date">
                    <time class="published" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                        <?php the_time('d M'); ?>
                    </time>
                </span>
                
                <?php
                printf(
                    __('This entry was written by %1$s, posted on %2$s at %3$s, filed under %4$s%5$s. Bookmark the <a href="%6$s" title="Permalink to %7$s" rel="bookmark">permalink</a>. Follow any comments here with the <a href="%8$s" title="Comments RSS to %7$s" rel="alternate" type="application/rss+xml">RSS feed for this post</a>.', 'autofocus'),
                    '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" title="' . esc_attr(sprintf(__('View all posts by %s', 'autofocus'), get_the_author())) . '">' . get_the_author() . '</a></span>',
                    '<time class="entry-date" datetime="' . esc_attr(get_the_date('c')) . '">' . get_the_date() . '</time>',
                    get_the_time(),
                    get_the_category_list(', '),
                    get_the_tag_list(' ' . __('and tagged', 'autofocus') . ' ', ', ', ''),
                    esc_url(get_permalink()),
                    the_title_attribute('echo=0'),
                    esc_url(get_post_comments_feed_link())
                );
                ?>

                <?php if ((comments_open()) && (pings_open())) : ?>
                    <?php 
                    printf(
                        __('<a class="comment-link" href="#respond" title="Post a comment">Post a comment</a> or leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'autofocus'),
                        esc_url(get_trackback_url())
                    ); 
                    ?>
                <?php elseif (!comments_open() && pings_open()) : ?>
                    <?php 
                    printf(
                        __('Comments are closed, but you can leave a trackback: <a class="trackback-link" href="%s" title="Trackback URL for your post" rel="trackback">Trackback URL</a>.', 'autofocus'),
                        esc_url(get_trackback_url())
                    ); 
                    ?>
                <?php elseif (comments_open() && !pings_open()) : ?>
                    <?php _e('Trackbacks are closed, but you can <a class="comment-link" href="#respond" title="Post a comment">post a comment</a>.', 'autofocus'); ?>
                <?php elseif (!comments_open() && !pings_open()) : ?>
                    <?php _e('Both comments and trackbacks are currently closed.', 'autofocus'); ?>
                <?php endif; ?>
                
                <?php edit_post_link(__('Edit', 'autofocus'), '<span class="edit-link">', '</span>'); ?>
            </div><!-- .entry-meta -->
        </article><!-- .post -->

        <div id="nav-below" class="navigation">
            <div class="browse"><h3><?php _e('Browse', 'autofocus'); ?></h3></div>
            
            <?php
            $previous_post = get_previous_post();
            if ($previous_post) : 
            ?>
                <div class="nav-previous">
                    <?php previous_post_link(__('Older: %link', 'autofocus')); ?>
                    <div class="nav-excerpt">
                        <p><?php autofocus_previous_post_excerpt(); ?></p>
                    </div>
                </div>
            <?php 
            endif;
            
            $next_post = get_next_post();
            if ($next_post) : 
            ?>
                <div class="nav-next">
                    <?php next_post_link(__('Newer: %link', 'autofocus')); ?>
                    <div class="nav-excerpt">
                        <p><?php autofocus_next_post_excerpt(); ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div><!-- #nav-below -->
        
        <?php
        // If comments are open or we have at least one comment, load up the comment template
        if (comments_open() || get_comments_number()) :
            comments_template();
        endif;
        
        endwhile; // End of the loop.
        ?>
    </div><!-- #content -->
</div><!-- #container -->

<?php get_footer(); ?>