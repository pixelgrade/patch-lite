<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Patch
 * @since Patch 1.0
 */

if ( ! function_exists( 'patch_posted_on' ) ) :

	/**
	 * Prints HTML with meta information for the current post-date/time and author.
	 */
	function patch_posted_on() {
		echo patch_get_posted_on();
	} #function

endif;

if ( ! function_exists( 'patch_get_posted_on' ) ) :

    /**
     * Returns HTML with meta information for the current post-date/time and author.
     */
    function patch_get_posted_on() {

        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s<span class="entry-time">%3$s</span></time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s<span class="entry-time">%3$s</span></time><time class="updated" hidden datetime="%4$s">%5$s</time>';
        }

        $date_format = ''; //use the format set in Settings > General

        if ( ! is_single() ) {
            //on home and archives, due to the layout, we need a shorter date format so it won't jump on a second line
            $date_format = 'M j, Y';
        }

        $time_string = sprintf( $time_string,
                esc_attr( get_the_date( 'c' ) ),
                esc_html( get_the_date( $date_format ) ),
                esc_html( get_the_time() ),
                esc_attr( get_the_modified_date( 'c' ) ),
                esc_html( get_the_modified_date() )
        );

        $posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

        $author_name = get_the_author();

        $byline = sprintf(
                _x( 'by %s', 'post author', 'patch' ),
                '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( $author_name ) . '</a></span>'
        );

        return '<span class="byline"> ' . $byline . '</span><span class="posted-on">' . $posted_on . '</span>';
    } #function

endif;

if ( ! function_exists( 'patch_get_author_first_name' ) ) :

	/**
	 * Retrieve the author first name of the current post.
	 *
	 * @uses $authordata The current author's DB object.
	 *
	 * @return string The author's first name or display name if not defined.
	 */
	function patch_get_author_first_name() {
		global $authordata;

		if ( is_object( $authordata ) ) {
			if ( ! empty( $authordata->first_name ) ) {
				return $authordata->first_name;
			} else {
				return apply_filters( 'the_author', $authordata->display_name );
			}
		}

		return '';
	}

endif;

if ( ! function_exists( 'patch_get_cats_list' ) ) :

	/**
	 * Returns HTML with comma separated category links
	 *
	 * @param int|WP_Post $post_ID Optional. Post ID or post object.
	 *
	 * @return string
	 */
	function patch_get_cats_list( $post_ID = null ) {

		//use the current post ID is none given
		if ( empty( $post_ID ) ) {
			$post_ID = get_the_ID();
		}

		//obviously pages don't have categories
		if ( 'page' == get_post_type( $post_ID ) ) {
			return '';
		}

		$cats = '';
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'patch' ), '', $post_ID );
		if ( $categories_list && patch_categorized_blog() ) {
			$cats = '<span class="cat-links">' . $categories_list . '</span>';
		}

		return $cats;

	} #function

endif;

if ( ! function_exists( 'patch_cats_list' ) ) :

	/**
	 * Prints HTML with comma separated category links
	 *
	 * @param int|WP_Post $post_ID Optional. Post ID or post object.
	 */
	function patch_cats_list( $post_ID = null ) {

		echo patch_get_cats_list( $post_ID );

	} #function

endif;

if ( ! function_exists( 'patch_get_post_format_link' ) ) :

	/**
	 * Returns HTML with the post format link
	 *
	 * @param int|WP_Post $post_ID Optional. Post ID or post object.
	 *
	 * @return string
	 */
	function patch_get_post_format_link( $post_ID = null ) {

		//use the current post ID is none given
		if ( empty( $post_ID ) ) {
			$post_ID = get_the_ID();
		}

		$post_format = get_post_format( $post_ID );

		if ( empty( $post_format ) || 'standard' == $post_format ) {
			return '';
		}

		return '<span class="entry-format">
				<a href="' . esc_url( get_post_format_link( $post_format ) ) .'" title="' . esc_attr( sprintf( __( 'All %s Posts', 'patch' ), get_post_format_string( $post_format ) ) ) . '">' .
					get_post_format_string( $post_format ) .
				'</a>
			</span>';

	} #function

endif;

if ( ! function_exists( 'patch_post_format_link' ) ) :

	/**
	 * Prints HTML with the post format link
	 *
	 * @param int|WP_Post $post_ID Optional. Post ID or post object.
	 */
	function patch_post_format_link( $post_ID = null ) {

		echo patch_get_post_format_link( $post_ID );

	} #function

endif;

/**
 * Prints HTML with the category of a certain post, with the most posts in it
 * The most important category of a post
 *
 * @param int|WP_Post $post_ID Optional. Post ID or post object.
 * @return string
 */
function patch_first_category( $post_ID = null ) {
	global $wp_rewrite;

	//use the current post ID is none given
	if ( empty( $post_ID ) ) {
		$post_ID = get_the_ID();
	}

	//obviously pages don't have categories
	if ( 'page' == get_post_type( $post_ID ) ) {
		return null;
	}

	//first get all categories ordered by count
	$all_categories = get_categories( array(
		'orderby' => 'count',
		'order' => 'DESC',
	) );

	//get the post's categories
	$categories = get_the_category( $post_ID );
	if ( empty( $categories ) ) {
		//get the default category instead
		$categories = array( get_the_category_by_ID( get_option( 'default_category' ) ) );
	}

	//now intersect them so that we are left with e descending ordered array of the post's categories
	$categories = array_uintersect( $all_categories, $categories, 'patch_compare_categories' );

	if ( ! empty ( $categories ) ) {
		$category = array_shift( $categories );
		$rel = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) ? 'rel="category tag"' : 'rel="category"';

		return '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" ' . $rel . '>' . $category->name . '</a>';
	}

	return null;
} #function

function patch_first_tag( $post_ID = null ) {
	global $wp_rewrite;

	//use the current post ID is none given
	if ( empty( $post_ID ) ) {
		$post_ID = get_the_ID();
	}

	//obviously pages don't have categories
	if ( 'page' == get_post_type( $post_ID ) ) {
		return null;
	}

	//first get all categories ordered by count
	$tags = wp_get_post_tags( $post_ID,  array(
		'orderby' => 'count',
		'order' => 'DESC',
	) );

	if ( ! empty ( $tags ) ) {
		$category = array_shift( $tags );
		$rel = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) ? 'rel="category tag"' : 'rel="tag"';

		return '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" ' . $rel . '>' . $category->name . '</a>';
	}

	return null;
} #function


function patch_card_meta ( $post_id = NULL ) {
	$meta = array();

	$meta['category'] = patch_first_category();
	$meta['tag'] = patch_first_tag();
	$meta['author'] = get_the_author();
	$meta['date'] = get_the_time( 'j F' );
    $meta['author_date'] = patch_get_posted_on();

	$comments_number = get_comments_number(); // get_comments_number() returns only a numeric value

	if ( comments_open() ) {
		if ( $comments_number == 0 ) {
			$comments = esc_html__( 'No Comments', 'osteria' );
		} else {
			$comments = sprintf( _n( '%d Comment', '%d Comments', $comments_number, 'osteria' ), $comments_number );
		}
		$meta['comments'] = '<a href="' . esc_url( get_comments_link() ) .'">' . esc_html( $comments ) . '</a>';
	} else {
		$meta['comments'] = '';
	}

	$blog_items_primary_meta = pixelgrade_option( 'blog_items_primary_meta', 'category', false );
	if ( $blog_items_primary_meta !== 'none' && ! empty( $meta[ $blog_items_primary_meta ] ) ) {
		echo '<span class="cat-links">' . $meta[ $blog_items_primary_meta ] . '</span>';
	}

	$meta['category_secondary'] = '<span class="byline">' . $meta['category'] . '</span>';
	$meta['tag_secondary'] = '<span class="byline">' . $meta['tag'] . '</span>';
	$meta['author_secondary'] = '<span class="byline">' . $meta['author'] . '</span>';
	$meta['date_secondary'] = '<span class="byline">' . $meta['date'] . '</span>';
	$meta['comments_secondary'] = '<span class="byline">' . $meta['comments'] . '</span>';

	$blog_items_secondary_meta = pixelgrade_option( 'blog_items_secondary_meta', 'date', false );

	if ( $blog_items_secondary_meta !== 'none' && ! empty( $meta[ $blog_items_secondary_meta ] ) ) {
		echo $meta[ $blog_items_secondary_meta ];
	}
}

function patch_compare_categories( $a1, $a2 ) {
	if ( $a1->term_id == $a2->term_id ) {
		return 0; //we are only interested by equality but PHP wants the whole thing
	}

	if ( $a1->term_id > $a2->term_id ) {
		return 1;
	}
	return -1;
}

if ( ! function_exists( 'patch_entry_footer' ) ) :

	/**
	 * Prints HTML with meta information for posts on archives.
	 */
	function patch_entry_footer() {
		edit_post_link( __( 'Edit', 'patch' ), '<span class="edit-link">', '</span>' );
	}

endif;

if ( ! function_exists( 'patch_single_entry_footer' ) ) :

	/**
	 * Prints HTML with meta information for the categories, tags, Jetpack likes, shares, related, and comments.
	 */
	function patch_single_entry_footer() {
		//only show tags and author bio for posts, not pages and what have you
		if ( 'post' == get_post_type() ) {

			$tags_list = get_the_tag_list( '', ' ' );
			if ( $tags_list ) {
				/* translators: There is a space at the end */
				echo '<span class="screen-reader-text">' . __( 'Tagged with: ', 'patch' ) . '</span><span class="tags-links">' . $tags_list . '</span>';
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link( __( 'Leave a comment', 'patch' ), __( '1 Comment', 'patch' ), __( '% Comments', 'patch' ) );
			echo '</span>';
		}

		edit_post_link( __( 'Edit', 'patch' ), '<span class="edit-link">', '</span>' );
	} #function

endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function patch_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'patch_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'patch_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so patch_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so patch_categorized_blog should return false.
		return false;
	}
} #function

/**
 * Flush out the transients used in patch_categorized_blog.
 */
function patch_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'patch_categories' );
}
add_action( 'edit_category', 'patch_category_transient_flusher' );
add_action( 'save_post',     'patch_category_transient_flusher' );

/**
 * Display the classes for the post thumbail div.
 *
 * @param string|array $class One or more classes to add to the class list.
 * @param int|WP_Post $post_id Optional. Post ID or post object.
 */
function patch_post_thumbnail_class( $class = '', $post_id = null ) {
	// Separates classes with a single space, collates classes for post thumbnail DIV
	echo 'class="' . join( ' ', patch_get_post_thumbnail_class( $class, $post_id ) ) . '"';
}

if ( ! function_exists( 'patch_get_post_thumbnail_class' ) ) :

	/**
	 * Retrieve the classes for the post_thumbnail,
	 * depending on the aspect ratio of the featured image
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @param int|WP_Post $post_id Optional. Post ID or post object.
	 * @return array Array of classes.
	 */
	function patch_get_post_thumbnail_class( $class = '', $post_id = null ) {

		$post = get_post( $post_id );

		$classes = array();

		if ( empty( $post ) ) {
			return $classes;
		}

		//get the aspect ratio specific class
		$classes[] = 'entry-image--' . patch_get_post_thumbnail_aspect_ratio_class( $post );

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}

			$classes = array_merge( $classes, $class );
		}

		$classes = array_map( 'esc_attr', $classes );

		/**
		 * Filter the list of CSS classes for the current post thumbnail.
		 *
		 * @param array  $classes An array of post classes.
		 * @param string $class   A comma-separated list of additional classes added to the post.
		 * @param int    $post_id The post ID.
		 */
		$classes = apply_filters( 'patch_post_thumbnail_class', $classes, $class, $post->ID );

		return array_unique( $classes );
	} #function

endif;

if ( ! function_exists( 'patch_get_post_thumbnail_aspect_ratio_class' ) ) :

	/**
	 * Get the aspect ratio of the featured image
	 *
	 * @param int|WP_Post $post_id Optional. Post ID or post object.
	 * @return string Aspect ratio specific class.
	 */
	function patch_get_post_thumbnail_aspect_ratio_class( $post_id = null ) {
		return '';
	} #function

endif;

/**
 * Display the classes for the post title div.
 *
 * @param string|array $class One or more classes to add to the class list.
 * @param int|WP_Post $post_id Optional. Post ID or post object.
 */
function patch_post_title_class( $class = '', $post_id = null ) {
	// Separates classes with a single space, collates classes for post title
	echo 'class="' . join( ' ', patch_get_post_title_class( $class, $post_id ) ) . '"';
}

if ( ! function_exists( 'patch_get_post_title_class' ) ) :

	/**
	 * Retrieve the classes for the post title,
	 * depending on the length of the title
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function patch_get_post_title_class( $class = '', $post_id = null ) {

		$post = get_post( $post_id );

		$classes = array();

		if ( empty( $post ) ) {
			return $classes;
		}

		$classes[] = 'entry-header';

		// .entry-header--[short|medium|long] depending on the title length
		// 0-29 chars = short
		// 30-59 = medium
		// 60+ = long
		$title_length = mb_strlen( get_the_title( $post ) );

		if ( $title_length < 30 ) {
			$classes[] = 'entry-header--short';
		} elseif ( $title_length < 60 ) {
			$classes[] = 'entry-header--medium';
		} else {
			$classes[] = 'entry-header--long';
		}

		if ( ! empty($class) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}

			$classes = array_merge( $classes, $class );
		}

		$classes = array_map( 'esc_attr', $classes );

		/**
		 * Filter the list of CSS classes for the current post title.
		 *
		 * @param array  $classes An array of post classes.
		 * @param string $class   A comma-separated list of additional classes added to the post.
		 * @param int    $post_id The post ID.
		 */
		$classes = apply_filters( 'patch_post_title_class', $classes, $class, $post->ID );

		return array_unique( $classes );
	} #function

endif;

/**
 * Display the classes for the post excerpt div.
 *
 * @param string|array $class One or more classes to add to the class list.
 * @param int|WP_Post $post_id Optional. Post ID or post object.
 */
function patch_post_excerpt_class( $class = '', $post_id = null ) {
	// Separates classes with a single space, collates classes for the post excerpt div
	echo 'class="' . join( ' ', patch_get_post_excerpt_class( $class, $post_id ) ) . '"';
}

if ( ! function_exists( 'patch_get_post_excerpt_class' ) ) :

	/**
	 * Retrieve the classes for the post excerpt,
	 * depending on the length of the excerpt
	 *
	 * @param string|array $class One or more classes to add to the class list.
	 * @return array Array of classes.
	 */
	function patch_get_post_excerpt_class( $class = '', $post_id = null ) {

		$post = get_post( $post_id );

		$classes = array();

		if ( empty( $post ) ) {
			return $classes;
		}

		$classes[] = 'entry-content';

		// .entry-title--[short|medium|long] depending on the title length
		// 0-99 chars = short
		// 100-199 = medium
		// 200+ = long
		$excerpt_length = mb_strlen( patch_get_post_excerpt( $post ) );

		if ( $excerpt_length < 99 ) {
			$classes[] = 'entry-content--short';
		} elseif ( $excerpt_length < 199 ) {
			$classes[] = 'entry-content--medium';
		} else {
			$classes[] = 'entry-content--long';
		}

		if ( ! empty( $class ) ) {
			if ( ! is_array( $class ) ) {
				$class = preg_split( '#\s+#', $class );
			}

			$classes = array_merge( $classes, $class );
		}

		$classes = array_map( 'esc_attr', $classes );

		/**
		 * Filter the list of CSS classes for the current post excerpt.
		 *
		 * @param array  $classes An array of post classes.
		 * @param string $class   A comma-separated list of additional classes added to the post.
		 * @param int    $post_id The post ID.
		 */
		$classes = apply_filters( 'patch_post_excerpt_class', $classes, $class, $post->ID );

		return array_unique( $classes );
	} #function

endif;

if ( ! function_exists( 'patch_get_custom_excerpt' ) ) :
	/**
	 * Generate a custom post excerpt suited to both latin alphabet languages and multibyte ones, like Chinese of Japanese
	 */
	function patch_get_custom_excerpt( $post_id = null ) {
		$post = get_post( $post_id );

		if ( empty( $post ) ) {
			return '';
		}

		//so we need to generate a custom excerpt
		//
		//the problem arises when we are dealing with multibyte characters
		//in this case we need to do a multibyte character length excerpt not the regular, number of words excerpt
		//but first we need to detect such a case

		//the excerpt returned by WordPress
		$excerpt = get_the_excerpt();
		//now we try to truncate the default excerpt with the length = number of words * 6 - the average word length in English
		$mb_excerpt = patch_truncate( $excerpt, ( apply_filters( 'excerpt_length', 55 ) * 6 ) );

		//if the multibyte excerpt's length is smaller then the regular excerpt's length divided by 1.8 (this is a conservative number)
		//then it's quite clear that the default one is no good
		//else leave things like they used to work
		if ( mb_strlen( $mb_excerpt ) < mb_strlen( $excerpt ) / 1.8 ) {
			$excerpt = $mb_excerpt;
		}
		return $excerpt;
	}
endif;

if ( ! function_exists( 'patch_post_excerpt' ) ) :
	/**
	 * Display the post excerpt, either with the <!--more--> tag or regular excerpt
	 *
	 * @param int|WP_Post $id Optional. Post ID or post object.
	 * @return string The custom excerpt
	 */
	function patch_post_excerpt( $post_id = null ) {
		$post = get_post( $post_id );

		if ( empty( $post ) ) {
			return '';
		}

		// Check the content for the more text
		$has_more = strpos( $post->post_content, '<!--more' );

		//when we encounter a read more tag, we respect that and forget about doing anything automatic
		if ( $has_more ) {
			/* translators: %s: Name of current post */
			the_content( sprintf(
				__( 'Continue reading %s', 'patch' ),
				the_title( '<span class="screen-reader-text">', '</span>', false )
			) );
		} elseif ( has_excerpt( $post ) ) {
			//in case of a manual excerpt we will go forth as planned - no processing
			the_excerpt();
		} else {
			//need custom generated excerpt
			echo apply_filters('the_excerpt', patch_get_custom_excerpt( $post ) );
		}
	} #function
endif;

/**
 * Get the post excerpt, either with the <!--more--> tag or regular excerpt
 *
 * @param int|WP_Post $post_id Optional. Post ID or post object.
 * @return string The post excerpt.
 */
function patch_get_post_excerpt( $post_id = null ) {
	$post = get_post( $post_id );

	$excerpt = '';

	if ( empty( $post ) ) {
		return $excerpt;
	}

	// Check the content for the more text
	$has_more = strpos( $post->post_content, '<!--more' );

	if ( $has_more ) {
		/* translators: %s: Name of current post */
		$excerpt = get_the_content( sprintf(
			__( 'Continue reading %s', 'patch' ),
			the_title( '<span class="screen-reader-text">', '</span>', false )
		) );
	} else {
		$excerpt = patch_get_custom_excerpt( $post );
	}

	return $excerpt;
} #function

/**
 * Display the markup for the author bio links.
 * These are the links/websites added by one to it's Gravatar profile
 *
 * @param int|WP_Post $post_id Optional. Post ID or post object.
 */
function patch_author_bio_links( $post_id = null ) {
	echo patch_get_author_bio_links( $post_id );
}

if ( ! function_exists( 'patch_get_author_bio_links' ) ) :

	/**
	 * Return the markup for the author bio links.
	 * These are the links/websites added by one to it's Gravatar profile
	 *
	 * @param int|WP_Post $post_id Optional. Post ID or post object.
	 * @return string The HTML markup of the author bio links list.
	 */
	function patch_get_author_bio_links( $post_id = null ) {
		$post = get_post( $post_id );

		$markup = '';

		if ( empty( $post ) ) {
			return $markup;
		}

		$str = wp_remote_fopen( 'https://www.gravatar.com/' . md5( strtolower( trim( get_the_author_meta( 'user_email' ) ) ) ) . '.php' );

		$profile = unserialize( $str );

		if ( is_array( $profile ) && ! empty( $profile['entry'][0]['urls'] ) ) {
			$markup .= '<ul class="author__social-links">' . PHP_EOL;

			foreach ( $profile['entry'][0]['urls'] as $link ) {
				if ( ! empty( $link['value'] ) && ! empty( $link['title'] ) ) {
					$markup .= '<li class="author__social-links__list-item">' . PHP_EOL;
					$markup .= '<a class="author__social-link" href="' . esc_url( $link['value'] ) . '" target="_blank">' . $link['title'] . '</a>' . PHP_EOL;
					$markup .= '</li>' . PHP_EOL;
				}
			}

			$markup .= '</ul>' . PHP_EOL;
		}

		return $markup;
	} #function

endif;

if ( ! function_exists( 'patch_secondary_page_title' ) ) :

	/**
	 * Display the markup for the archive or search pages title.
	 */
	function patch_the_secondary_page_title() {

		if ( is_archive() || is_search() ) { ?>

			<div class="grid__item">

				<?php if ( is_archive() ) : ?>

					<div class="page-header entry-card">
						<header class="entry-header">
						<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>

						<?php the_archive_description( '<div class="taxonomy-description">', '</div>' ); ?>
						</header>
					</div><!-- .page-header -->

				<?php elseif ( is_search() ) : ?>

					<header class="page-header entry-card">
						<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'patch' ), get_search_query() ); ?></h1>
					</header><!-- .page-header -->

				<?php endif; ?>

			</div><!-- .grid__item -->

		<?php }
	} #function

endif;

if ( ! function_exists( 'patch_the_image_navigation' ) ) :

	/**
	 * Display navigation to next/previous image attachment
	 */
	function patch_the_image_navigation() {
		// Don't print empty markup if there's nowhere to navigate.
		$prev_image = patch_get_adjacent_image();
		$next_image = patch_get_adjacent_image( false );

		if ( ! $next_image && ! $prev_image ) {
			return;
		} ?>

		<nav class="navigation post-navigation" role="navigation">
			<h5 class="screen-reader-text"><?php _e( 'Image navigation', 'patch' ); ?></h5>
			<div class="attachment-navigation">
				<?php
				if ( $prev_image ) {
					$prev_thumbnail = wp_get_attachment_image( $prev_image->ID, 'patch-tiny-image' ); ?>

					<span class="navigation-item  navigation-item--previous">
						<a href="<?php echo get_attachment_link( $prev_image->ID ); ?>" rel="prev">
		                    <span class="navigation-item__content">
                                <span class="post-thumb"><?php echo $prev_thumbnail; ?></span>
                                <span class="navigation-item__name"><?php _e( 'Previous image', 'patch' ); ?></span>
                                <h3 class="post-title"><?php echo get_the_title( $prev_image->ID ); ?></h3>
		                    </span>
						</a>
					</span>

				<?php }

				if ( $next_image ) {
					$next_thumbnail = wp_get_attachment_image( $next_image->ID, 'patch-tiny-image' ); ?>

					<span class="navigation-item  navigation-item--next">
						<a href="<?php echo get_attachment_link( $next_image->ID ); ?>" rel="prev">
		                    <span class="navigation-item__content">
	                                <span class="post-thumb"><?php echo $next_thumbnail; ?></span>
	                                <span class="navigation-item__name"><?php _e( 'Next image', 'patch' ); ?></span>
	                                <h3 class="post-title"><?php echo get_the_title( $next_image->ID ); ?></h3>
	                        </span>
						</a>
					</span>

				<?php } ?>

		</nav><!-- .navigation -->

	<?php
	} #function

endif;

if ( ! function_exists( 'patch_get_adjacent_image' ) ) :

	/**
	 * Inspired by the core function adjacent_image_link() from wp-includes/media.php
	 *
	 * @param bool $prev Optional. Default is true to display previous link, false for next.
	 * @return mixed  Attachment object if successful. Null if global $post is not set. false if no corresponding attachment exists.
	 */
	function patch_get_adjacent_image( $prev = true ) {
		if ( ! $post = get_post() ) {
			return null;
		}

		$attachments = get_attached_media( 'image', $post->post_parent );

		foreach ( $attachments as $k => $attachment ) {
			if ( $attachment->ID == $post->ID ) {
				break;
			}
		}

		if ( $attachments ) {
			$k = $prev ? $k - 1 : $k + 1;

			if ( isset( $attachments[ $k ] ) ) {
				return $attachments[ $k ];
			}
		}

		return false;
	} #function

endif;

if ( ! function_exists( 'patch_get_post_format_first_image' ) ) :

	function patch_get_post_format_first_image() {
		global $post;

		$output = '';
		$pattern = get_shortcode_regex();

		//first search for an image with a caption shortcode
		if ( preg_match_all( '/'. $pattern .'/s', $post->post_content, $matches )
		       && array_key_exists( 2, $matches )
		       && in_array( 'caption', $matches[2] ) ) {

			$key = array_search( 'caption', $matches[2] );
			if ( false !== $key ) {
				$output = do_shortcode( $matches[0][ $key ] );
			}
		} else {
			//find regular images
			preg_match( '/<img [^\>]*\ \/>/i', $post->post_content, $matches );

			if ( ! empty( $matches[0] ) ) {
				$output = $matches[0];
			}
		}

		return $output;
	} #function

endif;

if ( ! function_exists( 'patch_get_post_format_link_url' ) ) :

	/**
	 * Returns the URL to use for the link post format.
	 *
	 * First it tries to get the first URL in the content; if not found it uses the permalink instead
	 *
	 * @return string URL
	 */
	function patch_get_post_format_link_url() {
		$has_url = get_url_in_content( get_the_content() );

		return ( $has_url ) ? $has_url : apply_filters( 'the_permalink', get_permalink() );
	}

endif;

if ( ! function_exists( 'patch_paging_nav' ) ) :

	/**
	 * Display navigation to next/previous set of posts when applicable.
	 */
	function patch_paging_nav() {
		global $wp_query, $wp_rewrite;
		// Don't print empty markup if there's only one page.
		if ( $wp_query->max_num_pages < 2 ) {
			return;
		}

		$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
		$pagenum_link = html_entity_decode( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%'; ?>

		<nav class="pagination" role="navigation">
			<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'patch' ); ?></h1>

			<div class="nav-links">

				<?php
				//output a disabled previous "link" if on the fist page
				if ( 1 == $paged ) {
					echo '<span class="prev page-numbers disabled">' . __( 'Previous', 'patch' ) . '</span>';
				}

				//output the numbered page links
				echo paginate_links( array(
					'base'      => $pagenum_link,
					'format'    => $format,
					'total'     => $wp_query->max_num_pages,
					'current'   => $paged,
					'prev_next' => true,
					'prev_text' => __( 'Previous', 'patch' ),
					'next_text' => __( 'Next', 'patch' ),
					'add_args'  => array_map( 'urlencode', $query_args ),
				) );

				//output a disabled next "link" if on the last page
				if ( $paged == $wp_query->max_num_pages ) {
					echo '<span class="next page-numbers disabled">' . __( 'Next', 'patch' ) . '</span>';
				} ?>

			</div><!-- .nav-links -->

		</nav><!-- .navigation -->
	<?php
	} #function

endif;

/**
 * Handles the output of the media for audio attachment posts. This should be used within The Loop.
 *
 * @return string
 */
function patch_audio_attachment() {
	return hybrid_media_grabber( array( 'type' => 'audio', 'split_media' => true ) );
}
/**
 * Handles the output of the media for video attachment posts. This should be used within The Loop.
 *
 * @return string
 */
function patch_video_attachment() {
	return hybrid_media_grabber( array( 'type' => 'video', 'split_media' => true ) );
}

if ( ! function_exists( 'pixelgrade_footer_the_copyright' ) ) {
	/**
	 * Display the footer copyright.
	 */
	function pixelgrade_footer_the_copyright() {
		$output         = '';
		$output       .= '<div class="site-info c-footer__copyright-text">' . PHP_EOL;
		$output       .= '<a href="' . esc_url( __( 'http://wordpress.org/', 'patch-lite' ) ) . '">' . sprintf( __( 'Proudly powered by WordPress', 'patch-lite' ) ) . '</a>' . PHP_EOL;
		$output .= '<span class="sep"> | </span>';
		$output .= '<span class="c-footer__credits">' . sprintf( esc_html__( 'Theme: %1$s by %2$s.', 'patch-lite' ), 'Patch Lite', '<a href="https://pixelgrade.com/" target="_blank">Pixelgrade</a>' ) . '</span>' . PHP_EOL;
		$output .= '</div>';
		echo apply_filters( 'pixelgrade_footer_the_copyright', $output );
	}
}

if ( ! function_exists( 'pixelgrade_footer_get_copyright_content' ) ) {
	/**
	 * Get the footer copyright content (HTML or simple text).
	 * It already has do_shortcode applied.
	 *
	 * @return bool|string
	 */
	function pixelgrade_footer_get_copyright_content() {
		$copyright_text = pixelgrade_option( 'patch_footer_copyright_text', esc_html__( '&copy; %year% %site-title%.', 'patch' ) );
		if ( ! empty( $copyright_text ) ) {
			// We need to parse some tags
			$copyright_text = pixelgrade_parse_content_tags( $copyright_text );

			// Finally process any shortcodes that might be in there
			return do_shortcode( $copyright_text );
		}

		return '';
	}
}

if ( ! function_exists( 'pixelgrade_parse_content_tags' ) ) {
	/**
	 * Replace any content tags present in the content.
	 *
	 * @param string $content
	 *
	 * @return string
	 */
	function pixelgrade_parse_content_tags( $content ) {
		$original_content = $content;

		// Allow others to alter the content before we do our work
		$content = apply_filters( 'pixelgrade_before_parse_content_tags', $content );

		// Now we will replace all the supported tags with their value
		// %year%
		$content = str_replace( '%year%', date( 'Y' ), $content );

		// %site-title% or %site_title%
		$content = str_replace( '%site-title%', get_bloginfo( 'name' ), $content );
		$content = str_replace( '%site_title%', get_bloginfo( 'name' ), $content );

		// This is a little sketchy because who is the user?
		// It is not necessarily the logged in user, nor the Administrator user...
		// We will go with the author for cases where we are in a post/page context
		// Since we need to dd some heavy lifting, we will only do it when necessary
		if ( false !== strpos( $content, '%first_name%' ) ||
		     false !== strpos( $content, '%last_name%' ) ||
		     false !== strpos( $content, '%display_name%' ) ) {
			$user_id = false;
			// We need to get the current ID in more global manner
			$current_object_id = get_queried_object_id();
			$current_post      = get_post( $current_object_id );
			if ( ! empty( $current_post->post_author ) ) {
				$user_id = $current_post->post_author;
			} else {
				global $authordata;
				$user_id = isset( $authordata->ID ) ? $authordata->ID : false;
			}

			// If we still haven't got a user ID, we will just use the first user on the site
			if ( empty( $user_id ) ) {
				$blogusers = get_users(
					array(
						'role'   => 'administrator',
						'number' => 1,
					)
				);
				if ( ! empty( $blogusers ) ) {
					$blogusers = reset( $blogusers );
					$user_id   = $blogusers->ID;
				}
			}

			if ( ! empty( $user_id ) ) {
				// %first_name%
				$content = str_replace( '%first_name%', get_the_author_meta( 'first_name', $user_id ), $content );
				// %last_name%
				$content = str_replace( '%last_name%', get_the_author_meta( 'last_name', $user_id ), $content );
				// %display_name%
				$content = str_replace( '%display_name%', get_the_author_meta( 'display_name', $user_id ), $content );
			}
		}

		// Allow others to alter the content after we did our work
		return apply_filters( 'pixelgrade_after_parse_content_tags', $content, $original_content );
	}
}