<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$pages = $this->setting_pages;
$current_page = $this->current_page;
$messages = $this->messages;
?>
<div class="wrap wp-mobile">
	<form id="wpMobileAdminSettingsForm" action="" method="POST" enctype="multipart/form-data">
		<nav class="nav-tab-wrapper">
			<?php
			foreach ( $pages as $slug => $page ) :
				$active_class = '';
				$page_url = admin_url( 'admin.php?page=wp-mobile&tab=' . $slug );
				if ( $slug === $current_page ) :
					$active_class = ' nav-tab-active';
					$page_url = '#';
				endif;
				echo '<a class="nav-tab ' . $active_class . '" href="' . $page_url . '">' . $page['title'] . '</a>';
			endforeach;
			?>
		</nav>
		<h2><?php echo esc_html( $pages[ $current_page ]['title'] ); ?></h2>
		<h1 class="screen-reader-text"><?php echo esc_html( $pages[ $current_page ]['title'] ); ?></h1>
		<?php
			foreach ( $messages as $key=>$types ) :
				foreach ( $types as $message ):
					echo '<div class="notice notice-' . $key . ' is-dismissible">';
						echo '<p> ' . $message . ' </p>';
					echo '</div>';
				endforeach;
			endforeach;
		?>
		<?php do_action( 'wp_mobile_settings_content_' . $current_page ); ?>		
		<p class="submit">
			<input name="save" class="button-primary woocommerce-save-button" type="submit" value="<?php esc_attr_e( 'Save changes', 'wp-mobile' ); ?>" />
			<input type="hidden" name="current_page" value="<?php echo $current_page; ?>">
			<?php wp_nonce_field( 'wp-mobile-settings-' . $current_page ); ?>
		</p>
	</form>
</div>
