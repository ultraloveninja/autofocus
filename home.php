<?php
/**
 * Template for displaying the home/front page
 *
 * @package AutoFocus
 */

get_header(); 
?>

<div id="container">
    <div id="content">
        <div id="nav-above" class="navigation">
            <div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span>', 'autofocus')); ?></div>
            <div class="nav-next"><?php previous_posts_link(__('<span class="meta-nav">&raquo;</span>', 'autofocus')); ?></div>
        </div>
        
        <?php if (have_posts()) : ?>
            <?php 
            // Start the Loop
            $post_count = 0;
            while (have_posts()) : the_post(); 
                $post_count++;
                $post_class = 'featured post p' . $post_count;
            ?>

            <article id="post-<?php the_ID(); ?>" class="<?php echo esc_attr($post_class); ?>">
                <div class="entry-date bigdate">
                    <time class="published" datetime="<?php echo esc_attr(get_the_date('c')); ?>">
                        <?php the_time('d M'); ?>
                    </time>
                </div>
                
                <h2 class="entry-title post-content-title">
                    <a href="<?php the_permalink(); ?>" title="<?php printf(__('Permalink to %s', 'autofocus'), the_title_attribute('echo=0')); ?>" rel="bookmark">
                        <span><?php the_title(); ?></span>
                    </a>
                </h2>
                
                <div class="entry-content post-content">
                    <h4><?php the_title(); ?></h4>
                    <p><?php the_excerpt(); ?></p>

                    <?php 
                    wp_link_pages(array(
                        'before' => '<div class="page-link">' . __('Pages:', 'autofocus') . '</div>',
                        'after'  => '',
                    )); 
                    ?>
                </div><!-- .entry-content -->
                
                <span class="attach-post-image" style="height:300px;display:block;background:url('<?php autofocus_post_image_url('large'); ?>') center center no-repeat;background-size:cover;">&nbsp;</span>
            </article><!-- .post -->

            <?php endwhile; ?>

            <div id="nav-below" class="navigation">
                <div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts', 'autofocus')); ?></div>
                <div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&raquo;</span>', 'autofocus')); ?></div>
            </div>

        <?php else : ?>

            <article id="post-0" class="post no-results not-found">
                <h2 class="entry-title"><?php _e('Nothing Found', 'autofocus'); ?></h2>
                <div class="entry-content">
                    <p><?php _e('Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'autofocus'); ?></p>
                    <?php get_search_form(); ?>
                </div><!-- .entry-content -->
            </article><!-- .post -->

        <?php endif; ?>
    </div><!-- #content -->
</div><!-- #container -->

<?php get_footer(); ?>