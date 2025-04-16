<?php
/**
 * The template for displaying comments
 *
 * @package AutoFocus
 */

// If the current post is protected by a password and the visitor has not yet entered the password,
// return early without loading the comments.
if (post_password_required()) {
    ?>
    <div id="comments" class="comments-area">
        <div class="nopassword"><?php _e('This post is password protected. Enter the password to view comments.', 'autofocus'); ?></div>
    </div><!-- #comments -->
    <?php
    return;
}
?>

<div id="comments" class="comments-area">
    <?php
    // You can start editing here -- including this comment!
    if (have_comments()) :
        $comment_count = get_comment_count();
        $comment_num = $comment_count['approved'];
        $ping_count = 0;
        
        // Count the number of comments and trackbacks (or pings)
        foreach ($comments as $comment) {
            if (get_comment_type() == "comment") {
                ++$comment_num;
            } else {
                ++$ping_count;
            }
        }
    ?>
        
        <?php if (!empty($comments_by_type['comment'])) : ?>
        <div id="comments-list" class="comments">
            <h3>
                <?php
                printf(
                    $comment_num > 1 ? __('<span>%d</span> Comments', 'autofocus') : __('<span>One</span> Comment', 'autofocus'),
                    $comment_num
                );
                ?>
            </h3>

            <?php
            // Are there comments to navigate through?
            $total_pages = get_comment_pages_count();
            if ($total_pages > 1) :
            ?>
            <div id="comments-nav-above" class="comments-navigation">
                <div class="paginated-comments-links"><?php paginate_comments_links(); ?></div>
            </div><!-- #comments-nav-above -->
            <?php endif; ?>

            <ol class="comment-list">
                <?php
                wp_list_comments(array(
                    'type'      => 'comment',
                    'callback'  => 'autofocus_comment',
                    'avatar_size' => 50,
                ));
                ?>
            </ol>

            <?php
            // Are there comments to navigate through?
            $total_pages = get_comment_pages_count();
            if ($total_pages > 1) :
            ?>
            <div id="comments-nav-below" class="comments-navigation">
                <div class="paginated-comments-links"><?php paginate_comments_links(); ?></div>
            </div><!-- #comments-nav-below -->
            <?php endif; ?>
        </div><!-- #comments-list .comments -->
        <?php endif; // if there are comments ?>

        <?php if (!empty($comments_by_type['pings'])) : ?>
        <div id="trackbacks-list" class="comments">
            <h3>
                <?php
                printf(
                    $ping_count > 1 ? __('<span>%d</span> Trackbacks', 'autofocus') : __('<span>One</span> Trackback', 'autofocus'),
                    $ping_count
                );
                ?>
            </h3>

            <ol class="pingback-list">
                <?php
                wp_list_comments(array(
                    'type'      => 'pings',
                    'callback'  => 'autofocus_comment',
                ));
                ?>
            </ol>
        </div><!-- #trackbacks-list .comments -->
        <?php endif; // if there are pings ?>

    <?php
    endif; // have_comments()
    
    // If comments are open
    if (comments_open()) :
    ?>
        <div id="respond" class="comment-respond">
            <h3>
                <?php
                comment_form_title(
                    __('Post a Comment', 'autofocus'),
                    __('Post a Reply to %s', 'autofocus')
                );
                ?>
            </h3>

            <div id="cancel-comment-reply"><?php cancel_comment_reply_link(); ?></div>

            <?php if (get_option('comment_registration') && !is_user_logged_in()) : ?>
                <p id="login-req">
                    <?php
                    printf(
                        __('You must be <a href="%s" title="Log in">logged in</a> to post a comment.', 'autofocus'),
                        wp_login_url(get_permalink())
                    );
                    ?>
                </p>
            <?php else : ?>
                <div class="formcontainer">
                    <form id="commentform" action="<?php echo esc_url(site_url('/wp-comments-post.php')); ?>" method="post">
                        <?php if (is_user_logged_in()) : ?>
                            <p id="login">
                                <?php
                                printf(
                                    __('<span class="loggedin">Logged in as <a href="%1$s" title="Logged in as %2$s">%2$s</a>.</span> <span class="logout"><a href="%3$s" title="Log out of this account">Log out?</a></span>', 'autofocus'),
                                    esc_url(get_edit_user_link()),
                                    esc_html($user_identity),
                                    esc_url(wp_logout_url(get_permalink()))
                                );
                                ?>
                            </p>
                        <?php else : ?>
                            <p id="comment-notes">
                                <?php _e('Your email is <em>never</em> published nor shared.', 'autofocus'); ?>
                                <?php if ($req) _e('Required fields are marked <span class="required">*</span>', 'autofocus'); ?>
                            </p>

                            <div id="form-section-author" class="form-section">
                                <div class="form-label">
                                    <label for="author"><?php _e('Name', 'autofocus'); ?></label>
                                    <?php if ($req) _e('<span class="required">*</span>', 'autofocus'); ?>
                                </div>
                                <div class="form-input">
                                    <input id="author" name="author" type="text" value="<?php echo esc_attr($comment_author); ?>" size="30" maxlength="245" <?php if ($req) echo 'required'; ?> />
                                </div>
                            </div><!-- #form-section-author .form-section -->

                            <div id="form-section-email" class="form-section">
                                <div class="form-label">
                                    <label for="email"><?php _e('Email', 'autofocus'); ?></label>
                                    <?php if ($req) _e('<span class="required">*</span>', 'autofocus'); ?>
                                </div>
                                <div class="form-input">
                                    <input id="email" name="email" type="email" value="<?php echo esc_attr($comment_author_email); ?>" size="30" maxlength="100" aria-describedby="email-notes" <?php if ($req) echo 'required'; ?> />
                                </div>
                            </div><!-- #form-section-email .form-section -->

                            <div id="form-section-url" class="form-section">
                                <div class="form-label">
                                    <label for="url"><?php _e('Website', 'autofocus'); ?></label>
                                </div>
                                <div class="form-input">
                                    <input id="url" name="url" type="url" value="<?php echo esc_attr($comment_author_url); ?>" size="30" maxlength="200" />
                                </div>
                            </div><!-- #form-section-url .form-section -->
                        <?php endif; ?>

                        <div id="form-section-comment" class="form-section">
                            <div class="form-label">
                                <label for="comment"><?php _e('Comment', 'autofocus'); ?></label>
                            </div>
                            <div class="form-textarea">
                                <textarea id="comment" name="comment" cols="45" rows="8" required></textarea>
                            </div>
                        </div><!-- #form-section-comment .form-section -->

                        <div id="form-allowed-tags" class="form-section">
                            <p>
                                <span><?php _e('You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes:', 'autofocus'); ?></span>
                                <code><?php echo allowed_tags(); ?></code>
                            </p>
                        </div>

                        <?php do_action('comment_form', $post->ID); ?>

                        <div class="form-submit">
                            <input id="submit" name="submit" type="submit" value="<?php esc_attr_e('Post Comment', 'autofocus'); ?>" />
                            <?php comment_id_fields(); ?>
                        </div>
                    </form><!-- #commentform -->
                </div><!-- .formcontainer -->
            <?php endif; // if registration required and not logged in ?>
        </div><!-- #respond -->
    <?php
    endif; // if comments open
    ?>
</div><!-- #comments -->