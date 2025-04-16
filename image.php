<?php
/**
 * The template for displaying image attachments
 *
 * @package AutoFocus
 */

get_header();
?>

<div id="container">
    <div id="content">
        <?php
        // Start the loop
        while (have_posts()) : the_post();
        ?>

        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            <div class="full-photo">
                <div class="bigdate photo-credit">&copy; <?php the_time('Y'); ?> <?php the_author(); ?></div>
                <?php 
                // Display the image
                $image_size = apply_filters('autofocus_attachment_size', 'large');
                echo wp_get_attachment_image(get_the_ID(), $image_size, false, array('class' => 'attachment-image'));
                ?>
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
                
                <div class="exif-data">
                    <h4><?php _e('Exif Data', 'autofocus'); ?></h4>
                    <?php autofocus_grab_exif_data(); ?>
                </div>
            </div><!-- .entry-content -->
            
            <div class="entry-meta">
                <a href="<?php echo esc_url(get_permalink($post->post_parent)); ?>" class="attachment-title" rel="attachment">
                    &laquo; <?php _e('Back to:', 'autofocus'); ?> <?php echo get_the_title($post->post_parent); ?>
                </a>
                
                <?php
                printf(
                    __('This photograph was taken by %1$s and posted on <time class="published" datetime="%2$s">%3$s at %4$s</time>. Bookmark the <a href="%5$s" title="Permalink to %6$s" rel="bookmark">permalink</a>. Follow any comments here with the <a href="%7$s" title="Comments RSS to %6$s" rel="alternate" type="application/rss+xml">RSS feed for this post</a>.', 'autofocus'),
                    '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" title="' . esc_attr(sprintf(__('View all posts by %s', 'autofocus'), get_the_author())) . '">' . get_the_author() . '</a></span>',
                    esc_attr(get_the_date('c')),
                    get_the_date(),
                    get_the_time(),
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
            <div class="nav-previous">
                <small><?php autofocus_previous_image_link('<div>&laquo; ' . __('Previous Image', 'autofocus') . '</div> %link'); ?></small>
            </div>
            <div class="nav-next">
                <small><?php autofocus_next_image_link('<div>' . __('Next Image', 'autofocus') . ' &raquo;</div> %link'); ?></small>
            </div>
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