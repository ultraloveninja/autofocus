<?php
/**
 * The template for displaying search results pages
 *
 * @package AutoFocus
 */

get_header();
?>

<div id="container">
    <div id="content">
        <?php if (have_posts()) : ?>
            <div class="comment-count">
                <h2 class="page-title">
                    <?php 
                    printf(
                        __('Search Results for: <span>%s</span>', 'autofocus'),
                        get_search_query()
                    ); 
                    ?>
                </h2>
            </div>
            
            <div id="nav-above" class="navigation">
                <div class="nav-previous"><?php next_posts_link(__('<span class="meta-nav">&laquo;</span> Older posts', 'autofocus')); ?></div>
                <div class="nav-next"><?php previous_posts_link(__('Newer posts <span class="meta-nav">&raquo;</span>', 'autofocus')); ?></div>
            </div>

            <?php
            // Start the Loop
            while (have_posts()) : the_post();
            ?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <div class="preview">
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
                            'before' => '<div class="page-link">' . __('Pages:', 'autofocus'),
                            'after'  => '</div>',
                        )); 
                        ?>
                    </div><!-- .entry-content -->
                    
                    <span class="attach-post-image" style="height:300px;display:block;background:url('<?php autofocus_post_image_url('large'); ?>') center center no-repeat;background-size:cover;">&nbsp;</span>
                </div><!-- .preview -->
                
                <div class="entry-meta">
                    <span class="author vcard">
                        <?php 
                        printf(
                            __('By %s', 'autofocus'),
                            '<a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '" title="' . esc_attr(sprintf(__('View all posts by %s', 'autofocus'), get_the_author())) . '">' . get_the_author() . '</a>'
                        ); 
                        ?>
                    </span><br />
                    
                    <span class="cat-links">
                        <?php printf(__(' Filed under: %s', 'autofocus'), get_the_category_list(', ')); ?>
                    </span><br />
                    
                    <?php the_tags('<span class="tag-links">' . __('Tags: ', 'autofocus'), ', ', '</span><br />'); ?>
                    
                    <span class="comments-link">
                        <?php _e('Comments: ', 'autofocus'); ?>
                        <?php 
                        comments_popup_link(
                            __('Add a Comment', 'autofocus'),
                            __('1', 'autofocus'),
                            __('%', 'autofocus')
                        ); 
                        ?>
                    </span>
                    
                    <?php 
                    edit_post_link(
                        __('Edit', 'autofocus'),
                        '<span class="edit-link">',
                        '</span><br />'
                    ); 
                    ?>
                </div><!-- .entry-meta -->
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
                    <p><?php _e('Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'autofocus'); ?></p>
                    
                    <form id="noresults-searchform" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                        <div>
                            <input id="noresults-s" name="s" type="text" value="<?php echo esc_attr(get_search_query()); ?>" size="40" />
                            <input id="noresults-searchsubmit" name="searchsubmit" type="submit" value="<?php esc_attr_e('Find', 'autofocus'); ?>" />
                        </div>
                    </form>
                </div><!-- .entry-content -->
            </article><!-- .post -->

        <?php endif; ?>
    </div><!-- #content -->
</div><!-- #container -->

<?php
get_sidebar();
get_footer();