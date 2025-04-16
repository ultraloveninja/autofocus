<footer id="footer" role="contentinfo">
        <div class="copyright">
            <?php 
            $copyright_text = sprintf(
                esc_html__('All content is &copy; %s by %s. All rights reserved.', 'autofocus'),
                date('Y'),
                '<a href="' . esc_url(home_url('/')) . '" title="' . esc_attr(get_bloginfo('name')) . '" rel="home">' . get_bloginfo('name') . '</a>'
            );
            echo $copyright_text;
            ?>
        </div>
        
        <p id="footer-credit">
            <span id="generator-link">
                <a href="<?php echo esc_url(__('https://wordpress.org/', 'autofocus')); ?>" title="<?php esc_attr_e('WordPress', 'autofocus'); ?>" rel="generator">
                    <?php esc_html_e('WordPress', 'autofocus'); ?>
                </a>
            </span>
            <span class="meta-sep">|</span>
            <span id="theme-link">
                <a href="<?php echo esc_url(__('https://github.com/allancole/autofocus', 'autofocus')); ?>" title="<?php esc_attr_e('AutoFocus Theme', 'autofocus'); ?>" rel="designer">
                    <?php esc_html_e('AutoFocus', 'autofocus'); ?>
                </a>
            </span>
        </p>
    </footer><!-- #footer -->
</div><!-- #wrapper .hfeed -->

<?php wp_footer(); ?>

</body>
</html>