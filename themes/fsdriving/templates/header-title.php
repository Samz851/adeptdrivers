<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0
 */

// Page (category, tag, archive, author) title

if ( fsdriving_need_page_title() ) {
	fsdriving_sc_layouts_showed('title', true);
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title">
						<?php
						// Post meta on the single post
						if ( is_single() )  {
							?><div class="sc_layouts_title_meta"><?php
								fsdriving_show_post_meta(array(
									'date' => true,
									'categories' => true,
									'seo' => true,
									'share' => false,
									'counters' => 'views,comments,likes'
									)
								);
							?></div><?php
						}

						// Blog/Post title
						?><div class="sc_layouts_title_title"><?php
							$fsdriving_blog_title = fsdriving_get_blog_title();
							$fsdriving_blog_title_text = $fsdriving_blog_title_class = $fsdriving_blog_title_link = $fsdriving_blog_title_link_text = '';
							if (is_array($fsdriving_blog_title)) {
								$fsdriving_blog_title_text = $fsdriving_blog_title['text'];
								$fsdriving_blog_title_class = !empty($fsdriving_blog_title['class']) ? ' '.$fsdriving_blog_title['class'] : '';
								$fsdriving_blog_title_link = !empty($fsdriving_blog_title['link']) ? $fsdriving_blog_title['link'] : '';
								$fsdriving_blog_title_link_text = !empty($fsdriving_blog_title['link_text']) ? $fsdriving_blog_title['link_text'] : '';
							} else
								$fsdriving_blog_title_text = $fsdriving_blog_title;
							?>
							<h1 class="sc_layouts_title_caption<?php echo esc_attr($fsdriving_blog_title_class); ?>"><?php
								$fsdriving_top_icon = fsdriving_get_category_icon();
								if (!empty($fsdriving_top_icon)) {
									$fsdriving_attr = fsdriving_getimagesize($fsdriving_top_icon);
									?><img src="<?php echo esc_url($fsdriving_top_icon); ?>" alt="<?php echo esc_attr(basename($fsdriving_top_icon)); ?>" <?php if (!empty($fsdriving_attr[3])) fsdriving_show_layout($fsdriving_attr[3]);?>><?php
								}
								echo wp_kses_data($fsdriving_blog_title_text);
							?></h1>
							<?php
							if (!empty($fsdriving_blog_title_link) && !empty($fsdriving_blog_title_link_text)) {
								?><a href="<?php echo esc_url($fsdriving_blog_title_link); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html($fsdriving_blog_title_link_text); ?></a><?php
							}
							
							// Category/Tag description
							if ( is_category() || is_tag() || is_tax() ) 
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
		
						?></div><?php
	
						// Breadcrumbs
						?><div class="sc_layouts_title_breadcrumbs"><?php
							do_action( 'fsdriving_action_breadcrumbs');
						?></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
?>