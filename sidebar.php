<?php
/**
 * The sidebar containing the main widget area
 *
 * @package AutoFocus
 */

if (!is_active_sidebar('sidebar-1') && !is_active_sidebar('sidebar-2')) {
    return;
}
?>

<aside id="primary" class="sidebar widget-area" role="complementary">
    <ul class="xoxo">
        <?php if (is_active_sidebar('sidebar-1')) : ?>
            <?php dynamic_sidebar('sidebar-1'); ?>
        <?php else : ?>
            <li id="pages" class="widget">
                <h3><?php _e('Pages', 'autofocus'); ?></h3>
                <ul>
                    <?php wp_list_pages('title_li=&sort_column=post_title&depth=1'); ?>
                </ul>
            </li>
            
            <li id="search" class="widget">
                <h3><label for="s"><?php _e('Search', 'autofocus'); ?></label></h3>
                <form id="searchform" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                    <div>
                        <input id="s" name="s" type="text" value="<?php echo esc_attr(get_search_query()); ?>" size="10" tabindex="1" />
                        <input id="searchsubmit" name="searchsubmit" type="submit" value="<?php esc_attr_e('Find', 'autofocus'); ?>" tabindex="2" />
                    </div>
                </form>
            </li>

            <li id="categories" class="widget">
                <h3><?php _e('Categories', 'autofocus'); ?></h3>
                <ul>
                    <?php wp_list_categories('title_li=&hierarchical=1&use_desc_for_title=1'); ?>
                </ul>
            </li>

            <li id="archives" class="widget">
                <h3><?php _e('Archives', 'autofocus'); ?></h3>
                <ul>
                    <?php wp_get_archives('type=monthly'); ?>
                </ul>
            </li>
        <?php endif; ?>
    </ul>
</aside><!-- #primary -->

<aside id="secondary" class="sidebar widget-area" role="complementary">
    <ul class="xoxo">
        <?php if (is_active_sidebar('sidebar-2')) : ?>
            <?php dynamic_sidebar('sidebar-2'); ?>
        <?php else : ?>
            <li id="rss-links" class="widget">
                <h3><?php _e('Subscribe', 'autofocus'); ?></h3>
                <ul>
                    <li>
                        <a href="<?php bloginfo('rss2_url'); ?>" title="<?php echo esc_attr(get_bloginfo('name')); ?> <?php _e('Posts RSS feed', 'autofocus'); ?>" rel="alternate" type="application/rss+xml">
                            <?php _e('All posts', 'autofocus'); ?>
                        </a>
                    </li>
                    <li>
                        <a href="<?php bloginfo('comments_rss2_url'); ?>" title="<?php echo esc_attr(get_bloginfo('name')); ?> <?php _e('Comments RSS feed', 'autofocus'); ?>" rel="alternate" type="application/rss+xml">
                            <?php _e('All comments', 'autofocus'); ?>
                        </a>
                    </li>
                </ul>
            </li>

            <li id="meta" class="widget">
                <h3><?php _e('Meta', 'autofocus'); ?></h3>
                <ul>
                    <?php wp_register(); ?>
                    <li><?php wp_loginout(); ?></li>
                    <?php wp_meta(); ?>
                </ul>
            </li>
        <?php endif; ?>
    </ul>
</aside><!-- #secondary -->