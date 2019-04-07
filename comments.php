<?php
/**
 * The template for displaying Comments.
 *
 * @package Patch
 * @since   Patch 1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

if ( post_password_required() ) {
	return;
} ?>

<aside>
	<div id="comments" class="comments-area  <?php echo ( ! have_comments() ) ? 'no-comments' : ''; ?>">
		<div class="comments-area-title">
			<h2 class="comments-title"><?php
			if ( have_comments() ) {
				echo '<span class="comment-number  comment-number--dark  total">' . number_format_i18n( get_comments_number() ) . '</span>' . _n( 'Comment', 'Comments', get_comments_number(), 'patch-lite' );
			} else {
				echo '<span class="comment-number  comment-number--dark  no-comments">i</span>' . __( 'There are no comments', 'patch-lite' );
			} ?></h2>
			<?php echo '<a class="comments_add-comment" href="#reply-title">' . __( 'Add yours', 'patch-lite' ) . '</a>'; ?>
		</div>
		<?php
		// You can start editing here -- including this comment!
		if ( have_comments() ) :
			if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {
				// are there comments to navigate through
				?>
				<nav role="navigation" id="comment-nav-above" class="site-navigation comment-navigation">
					<span class="comment-number comment-number--dark">&hellip;</span>

					<h3 class="assistive-text"><?php _e( 'Comment navigation', 'patch-lite' ); ?></h3>

					<div class="nav-previous"><?php previous_comments_link( __( 'Older Comments', 'patch-lite' ) ); ?></div>
					<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'patch-lite' ) ); ?></div>
				</nav><!-- #comment-nav-before .site-navigation .comment-navigation -->
			<?php } // check for comment navigation ?>

			<ol class="commentlist">
				<?php
				/* Loop through and list the comments. Tell wp_list_comments()
				 * to use patch_comment() to format the comments.
				 * See patch_comment() in inc/extras.php for more.
				 */
				wp_list_comments( array( 'callback' => 'patch_lite_comment', 'short_ping' => true ) ); ?>
			</ol><!-- .commentlist -->

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>

			<nav role="navigation" id="comment-nav-below" class="site-navigation comment-navigation">
				<span class="comment-number comment-number--dark">&hellip;</span>

				<h3 class="assistive-text"><?php _e( 'Comment navigation', 'patch-lite' ); ?></h3>

				<div class="nav-previous"><?php previous_comments_link( __( 'Older Comments', 'patch-lite' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( __( 'Newer Comments', 'patch-lite' ) ); ?></div>
			</nav><!-- #comment-nav-below .site-navigation .comment-navigation -->

			<?php endif; // check for comment navigation
		endif; // have_comments() ?>

	</div>
	<!-- #comments .comments-area -->
	<?php
	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="nocomments">
			<span class="comment-number comment-number--dark  no-comments-box">&middot;</span><span><?php _e( 'Comments are closed.', 'patch-lite' ); ?></span>
		</p>
	<?php endif; ?>

	<?php comment_form(); ?>

</aside>