<?php
/**
 * The template for displaying comments
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Logic_Nagoya
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$logic_nagoya_comment_count = get_comments_number();
			if ( '1' === $logic_nagoya_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One comment on &ldquo;%1$s&rdquo;', 'logic-nagoya' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {
				printf(
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s comment on &ldquo;%2$s&rdquo;', '%1$s comments on &ldquo;%2$s&rdquo;', $logic_nagoya_comment_count, 'comments title', 'logic-nagoya' ) ),
					number_format_i18n( $logic_nagoya_comment_count ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2><!-- .comments-title -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 60,
					'callback'   => 'logic_nagoya_comment_callback',
				)
			);
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_navigation();

		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'logic-nagoya' ); ?></p>
			<?php
		endif;

	endif; // Check for have_comments().

	// Custom comment form styling
	$logic_nagoya_comment_fields = array(
		'author' => sprintf(
			'<div class="comment-form-author comment-form-field"><label for="author">%1$s%2$s</label><input id="author" name="author" type="text" value="%3$s" size="30" maxlength="245" %4$s /></div>',
			esc_html__( 'Name', 'logic-nagoya' ),
			( get_option( 'require_name_email' ) ? ' <span class="required">*</span>' : '' ),
			esc_attr( $commenter['comment_author'] ),
			( get_option( 'require_name_email' ) ? 'required' : '' )
		),
		'email'  => sprintf(
			'<div class="comment-form-email comment-form-field"><label for="email">%1$s%2$s</label><input id="email" name="email" type="email" value="%3$s" size="30" maxlength="100" aria-describedby="email-notes" %4$s /></div>',
			esc_html__( 'Email', 'logic-nagoya' ),
			( get_option( 'require_name_email' ) ? ' <span class="required">*</span>' : '' ),
			esc_attr( $commenter['comment_author_email'] ),
			( get_option( 'require_name_email' ) ? 'required' : '' )
		),
		'url'    => sprintf(
			'<div class="comment-form-url comment-form-field"><label for="url">%1$s</label><input id="url" name="url" type="url" value="%2$s" size="30" maxlength="200" /></div>',
			esc_html__( 'Website', 'logic-nagoya' ),
			esc_attr( $commenter['comment_author_url'] )
		),
	);

	$logic_nagoya_comment_form_args = array(
		'fields'               => $logic_nagoya_comment_fields,
		'comment_field'        => sprintf(
			'<div class="comment-form-comment comment-form-field"><label for="comment">%1$s <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></div>',
			esc_html__( 'Comment', 'logic-nagoya' )
		),
		'class_form'           => 'comment-form',
		'class_submit'         => 'btn btn-primary',
		'title_reply'          => esc_html__( 'Leave a Comment', 'logic-nagoya' ),
		'title_reply_to'       => esc_html__( 'Leave a Reply to %s', 'logic-nagoya' ),
		'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title">',
		'title_reply_after'    => '</h3>',
		'cancel_reply_before'  => ' <small>',
		'cancel_reply_after'   => '</small>',
		'cancel_reply_link'    => esc_html__( 'Cancel Reply', 'logic-nagoya' ),
		'label_submit'         => esc_html__( 'Post Comment', 'logic-nagoya' ),
		'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="%3$s">%4$s</button>',
		'submit_field'         => '<div class="form-submit">%1$s %2$s</div>',
	);

	comment_form( $logic_nagoya_comment_form_args );
	?>

</div><!-- #comments -->

<style>
/* Comment Styles */
.comments-area {
    margin-top: 60px;
    padding-top: 40px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.comments-title {
    font-size: 1.5rem;
    margin-bottom: 30px;
    color: var(--light);
}

.comment-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.comment {
    margin-bottom: 30px;
    padding: 20px;
    background-color: rgba(255, 255, 255, 0.05);
    border-radius: 5px;
}

.comment-body {
    position: relative;
}

.comment-author {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.comment-author .avatar {
    border-radius: 50%;
    margin-right: 15px;
    border: 2px solid var(--primary);
}

.comment-author .fn {
    font-weight: 500;
    color: var(--light);
    font-style: normal;
}

.comment-metadata {
    font-size: 0.85rem;
    margin-bottom: 15px;
    color: rgba(255, 255, 255, 0.7);
}

.comment-metadata a {
    color: rgba(255, 255, 255, 0.7);
}

.comment-content {
    margin-bottom: 15px;
    color: var(--light);
}

.reply {
    text-align: right;
}

.reply a {
    display: inline-block;
    padding: 5px 15px;
    background-color: rgba(255, 255, 255, 0.1);
    color: var(--light);
    border-radius: 3px;
    font-size: 0.85rem;
    transition: var(--transition);
}

.reply a:hover {
    background-color: var(--primary);
}

.no-comments {
    margin-top: 20px;
    padding: 10px;
    background-color: rgba(255, 255, 255, 0.05);
    border-radius: 5px;
    text-align: center;
}

/* Comment Form */
.comment-respond {
    margin-top: 40px;
    padding: 30px;
    background-color: rgba(255, 255, 255, 0.05);
    border-radius: 5px;
}

.comment-reply-title {
    font-size: 1.3rem;
    margin-bottom: 20px;
    color: var(--light);
}

.comment-form-field {
    margin-bottom: 20px;
}

.comment-form-field label {
    display: block;
    margin-bottom: 5px;
    color: var(--light);
}

.comment-form-field input,
.comment-form-field textarea {
    width: 100%;
    padding: 10px;
    background-color: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    color: var(--light);
    border-radius: 3px;
    transition: var(--transition);
}

.comment-form-field input:focus,
.comment-form-field textarea:focus {
    outline: none;
    border-color: var(--primary);
    background-color: rgba(255, 255, 255, 0.15);
}

.form-submit {
    text-align: right;
}

.required {
    color: var(--accent);
}

@media screen and (max-width: 768px) {
    .comments-area {
        margin-top: 40px;
        padding-top: 30px;
    }
    
    .comment {
        padding: 15px;
    }
    
    .comment-respond {
        padding: 20px;
    }
}
</style>
