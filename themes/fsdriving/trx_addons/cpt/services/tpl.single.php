<?php
/**
 * The template to display the service's single page
 *
 * @package WordPress
 * @subpackage ThemeREX Addons
 * @since v1.4
 */

global $TRX_ADDONS_STORAGE;

get_header();

while ( have_posts() ) { the_post();
	?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'services_page itemscope' ); ?>
		itemscope itemtype="http://schema.org/Article">
		
		<section class="services_page_header">	

			<?php
			// Image
			if ( has_post_thumbnail() ) {
				?><div class="services_page_featured">
					<?php
					the_post_thumbnail( trx_addons_get_thumb_size('huge'), array(
								'alt' => get_the_title(),
								'itemprop' => 'image'
								)
							);
					?>
				</div>
				<?php
			}

			// Title
			if ( !fsdriving_sc_layouts_showed('title') ) {
			?>
			<h3 class="services_page_title post_title entry-title"><?php the_title(); ?></h3>

			<?php }
			// Post meta on the single service
			if ( !fsdriving_sc_layouts_showed('meta') && is_single() ) {
				?><div class="sc_layouts_title_meta"><?php
				fsdriving_show_post_meta(array(
						'date' => true,
						'edit' => false,
						'categories' => false,
						'seo' => false,
						'share' => false,
						'counters' => ''
					)
				);
				?></div><?php
			}

			?>

		</section>
		<?php

		// Post content
		?><section class="services_page_content entry-content" itemprop="articleBody"><?php
			the_content( );
		?></section><!-- .entry-content --><?php

	?></article><?php

	// Related posts.
	fsdriving_show_related_posts(array('orderby' => 'rand',
		'posts_per_page' => max(2, min(4, fsdriving_get_theme_option('related_posts')))
	),
		fsdriving_get_theme_option('related_style')
	);

	// If comments are open or we have at least one comment, load up the comment template.
	if ( comments_open() || get_comments_number() ) {
		comments_template();
	}
}

get_footer();
?>