<?php
/**
 * Gutenberg compatibility for AutoFocus Theme
 *
 * @package AutoFocus
 */

/**
 * Add theme support for Gutenberg features.
 */
function autofocus_gutenberg_setup() {
    // Add support for editor styles
    add_theme_support('editor-styles');
    
    // Add support for wide alignments
    add_theme_support('align-wide');
    
    // Add support for custom colors
    add_theme_support('editor-color-palette', array(
        array(
            'name'  => __('Primary', 'autofocus'),
            'slug'  => 'primary',
            'color' => '#444444',
        ),
        array(
            'name'  => __('Secondary', 'autofocus'),
            'slug'  => 'secondary',
            'color' => '#888888',
        ),
        array(
            'name'  => __('White', 'autofocus'),
            'slug'  => 'white',
            'color' => '#ffffff',
        ),
        array(
            'name'  => __('Black', 'autofocus'),
            'slug'  => 'black',
            'color' => '#000000',
        ),
    ));
    
    // Add support for font sizes
    add_theme_support('editor-font-sizes', array(
        array(
            'name' => __('Small', 'autofocus'),
            'size' => 14,
            'slug' => 'small',
        ),
        array(
            'name' => __('Normal', 'autofocus'),
            'size' => 16,
            'slug' => 'normal',
        ),
        array(
            'name' => __('Large', 'autofocus'),
            'size' => 20,
            'slug' => 'large',
        ),
        array(
            'name' => __('Huge', 'autofocus'),
            'size' => 26,
            'slug' => 'huge',
        ),
    ));
    
    // Disable custom colors and font sizes
    add_theme_support('disable-custom-colors');
    add_theme_support('disable-custom-font-sizes');
    
    // Add support for responsive embeds
    add_theme_support('responsive-embeds');
    
    // Add support for custom line heights
    add_theme_support('custom-line-height');
    
    // Add support for experimental link color control
    add_theme_support('experimental-link-color');
    
    // Editor styles
    add_editor_style('css/editor-style.css');
}
add_action('after_setup_theme', 'autofocus_gutenberg_setup');

/**
 * Enqueue assets for the block editor.
 */
function autofocus_block_editor_assets() {
    // Enqueue block editor stylesheet
    wp_enqueue_style(
        'autofocus-block-editor-style',
        get_theme_file_uri('/css/editor-style.css'),
        array(),
        '2.0'
    );
}
add_action('enqueue_block_editor_assets', 'autofocus_block_editor_assets');

/**
 * Register block patterns for the AutoFocus theme.
 */
function autofocus_register_block_patterns() {
    if (function_exists('register_block_pattern_category')) {
        register_block_pattern_category(
            'autofocus',
            array('label' => __('AutoFocus', 'autofocus'))
        );
    }
    
    if (function_exists('register_block_pattern')) {
        // Photo with caption pattern
        register_block_pattern(
            'autofocus/photo-with-caption',
            array(
                'title'       => __('Photo with Caption', 'autofocus'),
                'description' => __('A large photo with a caption underneath', 'autofocus'),
                'categories'  => array('autofocus'),
                'content'     => '<!-- wp:image {"align":"wide","sizeSlug":"large"} -->
                <figure class="wp-block-image alignwide size-large"><img src="' . esc_url(get_template_directory_uri()) . '/img/placeholder.jpg" alt=""/><figcaption>' . __('Add caption here', 'autofocus') . '</figcaption></figure>
                <!-- /wp:image -->',
            )
        );
        
        // Photo gallery pattern
        register_block_pattern(
            'autofocus/photo-gallery',
            array(
                'title'       => __('Photo Gallery', 'autofocus'),
                'description' => __('A gallery of photos displayed in a grid', 'autofocus'),
                'categories'  => array('autofocus'),
                'content'     => '<!-- wp:gallery {"ids":[],"columns":3,"linkTo":"none"} -->
                <figure class="wp-block-gallery columns-3 is-cropped"><ul class="blocks-gallery-grid">
                <li class="blocks-gallery-item"><figure><img src="' . esc_url(get_template_directory_uri()) . '/img/placeholder.jpg" alt=""/></figure></li>
                <li class="blocks-gallery-item"><figure><img src="' . esc_url(get_template_directory_uri()) . '/img/placeholder.jpg" alt=""/></figure></li>
                <li class="blocks-gallery-item"><figure><img src="' . esc_url(get_template_directory_uri()) . '/img/placeholder.jpg" alt=""/></figure></li>
                </ul></figure>
                <!-- /wp:gallery -->',
            )
        );
        
        // Photo with text overlay pattern
        register_block_pattern(
            'autofocus/photo-with-text-overlay',
            array(
                'title'       => __('Photo with Text Overlay', 'autofocus'),
                'description' => __('A cover block with text overlay on a photo', 'autofocus'),
                'categories'  => array('autofocus'),
                'content'     => '<!-- wp:cover {"url":"' . esc_url(get_template_directory_uri()) . '/img/placeholder.jpg","id":0,"dimRatio":50,"overlayColor":"black","align":"wide"} -->
                <div class="wp-block-cover alignwide has-black-background-color has-background-dim"><img class="wp-block-cover__image-background" src="' . esc_url(get_template_directory_uri()) . '/img/placeholder.jpg" alt=""/><div class="wp-block-cover__inner-container"><!-- wp:paragraph {"align":"center","placeholder":"Write title…","fontSize":"large"} -->
                <p class="has-text-align-center has-large-font-size">' . __('This is a cover block with a background image and a text overlay', 'autofocus') . '</p>
                <!-- /wp:paragraph --></div></div>
                <!-- /wp:cover -->',
            )
        );
    }
}
add_action('init', 'autofocus_register_block_patterns');

/**
 * Register custom block styles
 */
function autofocus_register_block_styles() {
    if (function_exists('register_block_style')) {
        // Register image border style
        register_block_style(
            'core/image',
            array(
                'name'         => 'border',
                'label'        => __('Border', 'autofocus'),
                'style_handle' => 'autofocus-style',
            )
        );
        
        // Register image shadow style
        register_block_style(
            'core/image',
            array(
                'name'         => 'shadow',
                'label'        => __('Shadow', 'autofocus'),
                'style_handle' => 'autofocus-style',
            )
        );
        
        // Register quote style with large quotation marks
        register_block_style(
            'core/quote',
            array(
                'name'         => 'large-quotes',
                'label'        => __('Large Quotes', 'autofocus'),
                'style_handle' => 'autofocus-style',
            )
        );
    }
}
add_action('init', 'autofocus_register_block_styles');