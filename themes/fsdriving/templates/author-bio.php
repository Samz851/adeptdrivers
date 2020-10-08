<?php
/**
 * The template to display the Author bio
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0
 */
?>

<div class="author_info scheme_dark author vcard" itemprop="author" itemscope itemtype="http://schema.org/Person">

	<div class="author_avatar" itemprop="image">
		<?php 
		$fsdriving_mult = fsdriving_get_retina_multiplier();
		echo get_avatar( get_the_author_meta( 'user_email' ), 120*$fsdriving_mult ); 
		?>
	</div><!-- .author_avatar -->

	<div class="author_description">
		<h5 class="author_title" itemprop="name"><?php echo wp_kses_data(sprintf(__('About %s', 'fsdriving'), '<span class="fn">'.get_the_author().'</span>')); ?></h5>

		<div class="author_bio" itemprop="description">
			<?php echo wpautop(get_the_author_meta( 'description' )); ?>
			<a class="author_link" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
				<?php printf( esc_html__( 'View all posts by %s', 'fsdriving' ), '<span class="author_name">' . esc_html(get_the_author()) . '</span>' ); ?>
			</a>
		</div><!-- .author_bio -->

	</div><!-- .author_description -->

</div><!-- .author_info -->
