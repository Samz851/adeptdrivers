<?php
/**
 * The template to display Admin notices
 *
 * @package WordPress
 * @subpackage FSDRIVING
 * @since FSDRIVING 1.0.1
 */
?>
<div class="update-nag" id="fsdriving_admin_notice">
	<h3 class="fsdriving_notice_title"><?php echo sprintf(esc_html__('Welcome to %s', 'fsdriving'), wp_get_theme()->name); ?></h3>
	<?php
	if (!fsdriving_exists_trx_addons()) {
		?><p><?php echo wp_kses_data(__('<b>Attention!</b> Plugin "ThemeREX Addons is required! Please, install and activate it!', 'fsdriving')); ?></p><?php
	}
	?><p><?php
		if (fsdriving_get_value_gp('page')!='tgmpa-install-plugins') {
			?>
			<a href="<?php echo esc_url(admin_url().'themes.php?page=tgmpa-install-plugins'); ?>" class="button-primary"><i class="dashicons dashicons-admin-plugins"></i> <?php esc_html_e('Install plugins', 'fsdriving'); ?></a>
			<?php
		}
		if (function_exists('fsdriving_exists_trx_addons') && fsdriving_exists_trx_addons()) {
			?>
			<a href="<?php echo esc_url(admin_url().'themes.php?page=trx_importer'); ?>" class="button-primary"><i class="dashicons dashicons-download"></i> <?php esc_html_e('One Click Demo Data', 'fsdriving'); ?></a>
			<?php
		}
		?>
        <a href="<?php echo esc_url(admin_url().'customize.php'); ?>" class="button-primary"><i class="dashicons dashicons-admin-appearance"></i> <?php esc_html_e('Theme Customizer', 'fsdriving'); ?></a>
        <a href="#" class="button fsdriving_hide_notice"><i class="dashicons dashicons-dismiss"></i> <?php esc_html_e('Hide Notice', 'fsdriving'); ?></a>
	</p>
</div>