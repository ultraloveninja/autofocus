<?php
/**
 * AutoFocus functions and definitions
 *
 * @package AutoFocus
 * @since AutoFocus 2.0
 */

if (!function_exists('autofocus_setup')) :
    /**
     * Sets up theme defaults and registers support for various WordPress features.
     */
    function autofocus_setup() {
        // Make theme available for translation
        load_theme_textdomain('autofocus', get_template_directory() . '/languages');

        // Add default posts and comments RSS feed links to head
        add_theme_support('automatic-feed-links');

        // Let WordPress manage the document title
        add_theme_support('title-tag');

        // Enable support for Post Thumbnails on posts and pages
        add_theme_support('post-thumbnails');
        set_post_thumbnail_size(800, 300, true);
        add_image_size('autofocus-large', 800, 800, false);

        // Register menu locations
        register_nav_menus(array(
            'primary' => esc_html__('Primary Menu', 'autofocus'),
        ));

        // Switch default core markup to output valid HTML5
        add_theme_support('html5', array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        ));

        // Add theme support for Custom Logo
        add_theme_support('custom-logo', array(
            'height'      => 80,
            'width'       => 200,
            'flex-width'  => true,
            'flex-height' => true,
        ));

        // Add theme support for selective refresh for widgets
        add_theme_support('customize-selective-refresh-widgets');

        // Add support for Block Styles
        add_theme_support('wp-block-styles');

        // Add support for full and wide align images
        add_theme_support('align-wide');

        // Add support for responsive embeds
        add_theme_support('responsive-embeds');

        // Set max content width (for images etc.)
        global $content_width;
        if (!isset($content_width)) {
            $content_width = 800;
        }
    }
endif;
add_action('after_setup_theme', 'autofocus_setup');

/**
 * Enqueue scripts and styles
 */
function autofocus_scripts() {
    // Enqueue main stylesheet
    wp_enqueue_style('autofocus-style', get_stylesheet_uri(), array(), '2.0');
    
    // Add responsive menu script
    wp_enqueue_script('autofocus-menu', get_template_directory_uri() . '/js/menu.js', array('jquery'), '2.0', true);
    
    // Add responsive features
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'autofocus_scripts');

/**
 * Register widget areas
 */
function autofocus_widgets_init() {
    register_sidebar(array(
        'name'          => esc_html__('Primary Sidebar', 'autofocus'),
        'id'            => 'sidebar-1',
        'description'   => esc_html__('Add widgets here to appear in your sidebar.', 'autofocus'),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h3 class="widgettitle">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => esc_html__('Secondary Sidebar', 'autofocus'),
        'id'            => 'sidebar-2',
        'description'   => esc_html__('Add widgets here to appear in your secondary sidebar.', 'autofocus'),
        'before_widget' => '<li id="%1$s" class="widget %2$s">',
        'after_widget'  => '</li>',
        'before_title'  => '<h3 class="widgettitle">',
        'after_title'   => '</h3>',
    ));
}
add_action('widgets_init', 'autofocus_widgets_init');

/**
 * Generates semantic classes for BODY element
 */
function autofocus_body_class($classes) {
    global $wp_query, $post;
    
    // Add specific CSS class by filter
    $classes[] = 'autofocus-theme';
    
    if (is_front_page()) {
        $classes[] = 'front-page';
    }
    
    if (is_home()) {
        $classes[] = 'blog-home';
    }
    
    if (is_singular() && !is_attachment()) {
        // Post formats
        if (get_post_format()) {
            $classes[] = 'format-' . get_post_format();
        } else {
            $classes[] = 'format-standard';
        }
        
        // Custom post type
        if ($post) {
            $classes[] = 'post-type-' . $post->post_type;
        }
    }
    
    // Multi-author blog check
    if (is_multi_author()) {
        $classes[] = 'multi-author';
    }
    
    return $classes;
}
add_filter('body_class', 'autofocus_body_class');

/**
 * Generates semantic classes for each post DIV element
 */
function autofocus_post_class($classes) {
    global $post;
    
    // Add hentry for compliance
    if (!in_array('hentry', $classes)) {
        $classes[] = 'hentry';
    }
    
    // Add author class
    if ($post->post_author) {
        $author = sanitize_html_class(get_the_author_meta('user_nicename', $post->post_author));
        if (!empty($author)) {
            $classes[] = 'author-' . $author;
        }
    }
    
    return $classes;
}
add_filter('post_class', 'autofocus_post_class');

/**
 * Generates comment classes
 */
function autofocus_comment_class($classes) {
    global $comment, $post;
    
    // Comment type class
    if ($comment->comment_type === 'pingback' || $comment->comment_type === 'trackback') {
        $classes[] = 'trackback';
    }
    
    // Add byuser class for registered users
    if ($comment->user_id > 0) {
        $user = get_userdata($comment->user_id);
        if ($user) {
            $classes[] = 'byuser';
            $classes[] = 'comment-author-' . sanitize_html_class($user->user_login);
            
            // Add bypostauthor class if comment is by the author of the post
            if ($comment->user_id === $post->post_author) {
                $classes[] = 'bypostauthor';
            }
        }
    }
    
    return $classes;
}
add_filter('comment_class', 'autofocus_comment_class');

/**
 * Clean up the_excerpt()
 */
function autofocus_excerpt($text) {
    // Remove [caption] and [gallery] shortcodes from excerpt
    $text = preg_replace('/\[caption.*?\](.*?)\[\/caption\]/is', '', $text);
    $text = preg_replace('/\[gallery.*?\](.*?)\[\/gallery\]/is', '', $text);
    
    // Remove other shortcodes
    $text = preg_replace('/\[.*?\]/is', '', $text);
    
    return $text;
}
add_filter('get_the_excerpt', 'autofocus_excerpt');

/**
 * Custom excerpt length and more text
 */
function autofocus_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'autofocus_excerpt_length');

function autofocus_excerpt_more($more) {
    return '&hellip;';
}
add_filter('excerpt_more', 'autofocus_excerpt_more');

/**
 * Creates custom excerpt for navigation
 */
function autofocus_post_excerpt($post) {
    $excerpt = ($post->post_excerpt == '') ? 
        wp_trim_words(strip_shortcodes(get_post_field('post_content', $post->ID)), 25, '&hellip;') : 
        apply_filters('the_excerpt', $post->post_excerpt);
    
    return $excerpt;
}

/**
 * Previous post excerpt for navigation
 */
function autofocus_previous_post_excerpt($in_same_cat = false, $excluded_categories = '') {
    $previous = get_previous_post($in_same_cat, $excluded_categories);
    if (!$previous) {
        return;
    }
    
    echo autofocus_post_excerpt($previous);
}

/**
 * Next post excerpt for navigation
 */
function autofocus_next_post_excerpt($in_same_cat = false, $excluded_categories = '') {
    $next = get_next_post($in_same_cat, $excluded_categories);
    if (!$next) {
        return;
    }
    
    echo autofocus_post_excerpt($next);
}

/**
 * Post Attachment image function. Image URL for CSS Background.
 */
function autofocus_post_image_url($size = 'large') {
    global $post;
    
    // First check for post thumbnail
    if (has_post_thumbnail()) {
        $image_src = wp_get_attachment_image_src(get_post_thumbnail_id(), $size);
        if ($image_src) {
            echo esc_url($image_src[0]);
            return;
        }
    }
    
    // Then check for attached images
    $attachments = get_children(array(
        'post_parent' => get_the_ID(),
        'post_type' => 'attachment',
        'numberposts' => 1,
        'post_mime_type' => 'image',
    ));
    
    if ($attachments) {
        foreach ($attachments as $attachment) {
            $image_src = wp_get_attachment_image_src($attachment->ID, $size);
            if ($image_src) {
                echo esc_url($image_src[0]);
                return;
            }
        }
    }
    
    // If no image found, use default
    echo esc_url(get_template_directory_uri() . '/img/no-attachment.gif');
}

/**
 * Post Attachment image function. Direct link to file.
 */
function autofocus_post_image($size = 'thumbnail') {
    global $post;
    
    // First check for post thumbnail
    if (has_post_thumbnail()) {
        echo get_the_post_thumbnail(null, $size);
        return;
    }
    
    // Then check for attached images
    $attachments = get_children(array(
        'post_parent' => get_the_ID(),
        'post_type' => 'attachment',
        'numberposts' => 1,
        'post_mime_type' => 'image',
    ));
    
    if ($attachments) {
        foreach ($attachments as $attachment) {
            echo wp_get_attachment_image($attachment->ID, $size);
            return;
        }
    }
    
    // If no image found, use default
    echo '<img src="' . esc_url(get_template_directory_uri()) . '/img/no-attachment-large.gif" alt="' . esc_attr__('No Image', 'autofocus') . '" />';
}

/**
 * Get EXIF data from image attachments
 */
function autofocus_grab_exif_data() {
    global $post;
    
    if (!is_attachment() || !wp_attachment_is_image()) {
        return;
    }
    
    $image_meta = wp_get_attachment_metadata();
    
    if (!isset($image_meta['image_meta'])) {
        return;
    }
    
    $exif = $image_meta['image_meta'];
    
    echo '<ul>';
    
    if (!empty($exif['created_timestamp'])) {
        echo '<li><span class="exif-title">' . esc_html__('Date Taken:', 'autofocus') . '</span> ' . 
             esc_html(date_i18n(get_option('date_format') . ' ' . get_option('time_format'), $exif['created_timestamp'])) . '</li>';
    }
    
    if (!empty($exif['copyright'])) {
        echo '<li><span class="exif-title">' . esc_html__('Copyright:', 'autofocus') . '</span> ' . 
             esc_html($exif['copyright']) . '</li>';
    }
    
    if (!empty($exif['credit'])) {
        echo '<li><span class="exif-title">' . esc_html__('Credit:', 'autofocus') . '</span> ' . 
             esc_html($exif['credit']) . '</li>';
    }
    
    if (!empty($exif['title'])) {
        echo '<li><span class="exif-title">' . esc_html__('Title:', 'autofocus') . '</span> ' . 
             esc_html($exif['title']) . '</li>';
    }
    
    if (!empty($exif['caption'])) {
        echo '<li><span class="exif-title">' . esc_html__('Caption:', 'autofocus') . '</span> ' . 
             esc_html($exif['caption']) . '</li>';
    }
    
    if (!empty($exif['camera'])) {
        echo '<li><span class="exif-title">' . esc_html__('Camera:', 'autofocus') . '</span> ' . 
             esc_html($exif['camera']) . '</li>';
    }
    
    if (!empty($exif['focal_length'])) {
        echo '<li><span class="exif-title">' . esc_html__('Focal Length:', 'autofocus') . '</span> ' . 
             esc_html($exif['focal_length']) . 'mm</li>';
    }
    
    if (!empty($exif['aperture'])) {
        echo '<li><span class="exif-title">' . esc_html__('Aperture:', 'autofocus') . '</span> f/' . 
             esc_html($exif['aperture']) . '</li>';
    }
    
    if (!empty($exif['iso'])) {
        echo '<li><span class="exif-title">' . esc_html__('ISO:', 'autofocus') . '</span> ' . 
             esc_html($exif['iso']) . '</li>';
    }
    
    echo '</ul>';
}

/**
 * Fix next/previous image navigation for attachments
 */
function autofocus_previous_image_link($format) {
    $adjacent = autofocus_adjacent_image_link(true);
    if ($adjacent) {
        echo str_replace('%link', $adjacent, $format);
    }
}

function autofocus_next_image_link($format) {
    $adjacent = autofocus_adjacent_image_link(false);
    if ($adjacent) {
        echo str_replace('%link', $adjacent, $format);
    }
}

function autofocus_adjacent_image_link($prev = true) {
    global $post;
    
    $post = get_post($post);
    $attachments = get_children(array(
        'post_parent' => $post->post_parent,
        'post_type' => 'attachment',
        'post_mime_type' => 'image',
        'orderby' => 'menu_order ASC, ID ASC'
    ));
    
    if (empty($attachments)) {
        return '';
    }
    
    $attachments = array_values($attachments);
    $current_key = 0;
    
    // Find the current attachment index
    foreach ($attachments as $k => $attachment) {
        if ($attachment->ID == $post->ID) {
            $current_key = $k;
            break;
        }
    }
    
    $target_key = $prev ? $current_key - 1 : $current_key + 1;
    
    if (isset($attachments[$target_key])) {
        return wp_get_attachment_link($attachments[$target_key]->ID, 'thumbnail', true);
    }
    
    return '';
}

/**
 * Custom comment callback function
 */
function autofocus_comment($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    $comment_type = get_comment_type();
    
    if ($comment_type === 'trackback' || $comment_type === 'pingback') {
        ?>
        <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
            <div class="comment-author">
                <?php
                printf(
                    esc_html__('By %1$s on %2$s at %3$s', 'autofocus'),
                    get_comment_author_link(),
                    get_comment_date(),
                    get_comment_time()
                );
                
                edit_comment_link(
                    esc_html__('Edit', 'autofocus'),
                    ' <span class="meta-sep">|</span> <span class="edit-link">',
                    '</span>'
                );
                ?>
            </div>
            
            <?php if ($comment->comment_approved == '0') : ?>
                <span class="unapproved"><?php esc_html_e('Your trackback is awaiting moderation.', 'autofocus'); ?></span>
            <?php endif; ?>
            
            <div class="comment-content">
                <?php comment_text(); ?>
            </div>
        </li>
        <?php
    } else {
        ?>
        <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
            <div class="comment-author vcard">
                <?php 
                echo get_avatar($comment, 50, '', '', array('class' => 'photo avatar')); 
                printf(
                    '<span class="fn n">%s</span>',
                    get_comment_author_link()
                );
                ?>
            </div>
            
            <div class="comment-meta">
                <?php
                printf(
                    esc_html__('Posted %1$s at %2$s', 'autofocus'),
                    get_comment_date(),
                    get_comment_time()
                );
                ?>
                <span class="meta-sep">|</span> 
                <a href="<?php echo esc_url(get_comment_link()); ?>" title="<?php esc_attr_e('Permalink to this comment', 'autofocus'); ?>">#</a>
                <?php
                edit_comment_link(
                    esc_html__('Edit', 'autofocus'),
                    ' <span class="meta-sep">|</span> <span class="edit-link">',
                    '</span>'
                );
                ?>
            </div>
            
            <?php if ($comment->comment_approved == '0') : ?>
                <span class="unapproved"><?php esc_html_e('Your comment is awaiting moderation.', 'autofocus'); ?></span>
            <?php endif; ?>
            
            <div class="comment-content">
                <?php comment_text(); ?>
            </div>
            
            <?php
            if ($args['type'] == 'all' || get_comment_type() == 'comment') {
                comment_reply_link(array_merge($args, array(
                    'reply_text' => esc_html__('Reply', 'autofocus'),
                    'login_text' => esc_html__('Log in to reply.', 'autofocus'),
                    'depth' => $depth,
                    'before' => '<div class="comment-reply-link">',
                    'after' => '</div>'
                )));
            }
            ?>
        </li>
        <?php
    }
}

/**
 * Custom navigation menu
 */
function autofocus_nav_menu() {
    ?>
    <div id="menu">
        <button class="menu-toggle" aria-controls="menu" aria-expanded="false">
            <?php esc_html_e('Menu', 'autofocus'); ?>
        </button>
        
        <ul>
            <li class="page_item">
                <a href="<?php echo esc_url(home_url('/')); ?>" title="<?php bloginfo('name'); ?>" rel="home">
                    <?php esc_html_e('Home', 'autofocus'); ?>
                </a>
            </li>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => false,
                'items_wrap' => '%3$s',
                'fallback_cb' => 'wp_page_menu',
                'echo' => true,
                'walker' => new Autofocus_Nav_Walker(),
            ));
            ?>
            <li class="page_item">
                <a href="<?php bloginfo('rss2_url'); ?>">
                    <?php esc_html_e('RSS', 'autofocus'); ?>
                </a>
            </li>
        </ul>
    </div>
    <?php
}

/**
 * Custom Nav Walker
 */
class Autofocus_Nav_Walker extends Walker_Nav_Menu {
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
        
        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';
        
        $output .= $indent . '<li' . $id . $class_names .'>';
        
        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '';
        
        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
        
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }
        
        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);
        
        $item_output = $args->before;
        $item_output .= '<a'. $attributes .'>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

/**
 * Add IE-specific CSS
 */
function autofocus_ie_css() {
    ?>
    <!--[if lte IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo esc_url(get_stylesheet_directory_uri()); ?>/css/ie.css" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.min.js"></script>
    <![endif]-->
    <?php
}
add_action('wp_head', 'autofocus_ie_css');

/**
 * Remove the first image from content
 */
function autofocus_remove_first_image($content) {
    if (!is_page() && !is_feed()) {
        $content = preg_replace('/^<p><img(.*?)>/i', "<p><!-- Image removed by theme -->", $content, 1);
        $content = preg_replace('/^<img(.*?)>/i', "<!-- Image removed by theme -->", $content, 1);
        $content = preg_replace('/^<p><a(.*?)><img(.*?)><\/a>/i', '<p><!-- Link and image removed by theme -->', $content);
        $content = preg_replace('/^<a(.*?)><img(.*?)><\/a>/i', '<p><!-- Link and image removed by theme -->', $content);
    }
    return $content;
}
add_filter('the_content', 'autofocus_remove_first_image');

/**
 * Register custom widget: Nice Tag Cloud
 */
function autofocus_nice_tagcloud_widget($args) {
    extract($args);
    echo $before_widget;
    echo $before_title . esc_html__('Tag Cloud', 'autofocus') . $after_title;
    
    if (function_exists('wp_tag_cloud')) {
        echo '<p>';
        wp_tag_cloud(array('orderby' => 'count', 'order' => 'DESC'));
        echo '</p>';
    }
    
    echo $after_widget;
}

function autofocus_register_widgets() {
    register_widget('Autofocus_Nice_Tag_Cloud_Widget');
}
add_action('widgets_init', 'autofocus_register_widgets');

/**
 * Nice Tag Cloud Widget Class
 */
class Autofocus_Nice_Tag_Cloud_Widget extends WP_Widget {
    
    function __construct() {
        parent::__construct(
            'autofocus_nice_tagcloud',
            esc_html__('Nice Tag Cloud', 'autofocus'),
            array('description' => esc_html__('A more aesthetically pleasing tag cloud.', 'autofocus'))
        );
    }
    
    public function widget($args, $instance) {
        autofocus_nice_tagcloud_widget($args);
    }
    
    public function form($instance) {
        echo '<p>' . esc_html__('This widget has no options.', 'autofocus') . '</p>';
    }
    
    public function update($new_instance, $old_instance) {
        return $old_instance;
    }
}

/**
 * Custom template tags
 */

if (!function_exists('autofocus_posted_on')) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function autofocus_posted_on() {
    $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
    
    if (get_the_time('U') !== get_the_modified_time('U')) {
        $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
    }
    
    $time_string = sprintf($time_string,
        esc_attr(get_the_date('c')),
        esc_html(get_the_date()),
        esc_attr(get_the_modified_date('c')),
        esc_html(get_the_modified_date())
    );
    
    $posted_on = sprintf(
        esc_html_x('Posted on %s', 'post date', 'autofocus'),
        '<a href="' . esc_url(get_permalink()) . '" rel="bookmark">' . $time_string . '</a>'
    );
    
    $byline = sprintf(
        esc_html_x('by %s', 'post author', 'autofocus'),
        '<span class="author vcard"><a class="url fn n" href="' . esc_url(get_author_posts_url(get_the_author_meta('ID'))) . '">' . esc_html(get_the_author()) . '</a></span>'
    );
    
    echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';
}
endif;

if (!function_exists('autofocus_entry_footer')) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function autofocus_entry_footer() {
    // Hide category and tag text for pages.
    if ('post' === get_post_type()) {
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list(esc_html__(', ', 'autofocus'));
        if ($categories_list && autofocus_categorized_blog()) {
            printf('<span class="cat-links">' . esc_html__('Posted in %1$s', 'autofocus') . '</span>', $categories_list);
        }
        
        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list('', esc_html__(', ', 'autofocus'));
        if ($tags_list) {
            printf('<span class="tags-links">' . esc_html__('Tagged %1$s', 'autofocus') . '</span>', $tags_list);
        }
    }
    
    if (!is_single() && !post_password_required() && (comments_open() || get_comments_number())) {
        echo '<span class="comments-link">';
        /* translators: %s: post title */
        comments_popup_link(
            sprintf(esc_html__('Leave a Comment<span class="screen-reader-text"> on %s</span>', 'autofocus'), get_the_title())
        );
        echo '</span>';
    }
    
    edit_post_link(
        sprintf(
            /* translators: %s: Name of current post */
            esc_html__('Edit %s', 'autofocus'),
            the_title('<span class="screen-reader-text">"', '"</span>', false)
        ),
        '<span class="edit-link">',
        '</span>'
    );
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 */
function autofocus_categorized_blog() {
    if (false === ($all_cats = get_transient('autofocus_categories'))) {
        // Create an array of all the categories that are attached to posts.
        $all_cats = get_categories(array(
            'fields'     => 'ids',
            'hide_empty' => 1,
            'number'     => 2,
        ));
        
        // Count the number of categories that are attached to the posts.
        $all_cats = count($all_cats);
        
        set_transient('autofocus_categories', $all_cats);
    }
    
    if ($all_cats > 1) {
        // This blog has more than 1 category.
        return true;
    } else {
        // This blog has only 1 category.
        return false;
    }
}

/**
 * Flush out the transients used in autofocus_categorized_blog.
 */
function autofocus_category_transient_flusher() {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    // Like, beat it. Dig?
    delete_transient('autofocus_categories');
}
add_action('edit_category', 'autofocus_category_transient_flusher');
add_action('save_post',     'autofocus_category_transient_flusher');