<?php

/**
 * @var \COE\Controller $this
 */

?>

<div class="wrap">

	<h1>
		Center Of Excellence Plugin <?php _e( 'Settings', 'coe' ); ?>
	</h1>

	<form method="post" action="options.php" autocomplete="off">

		<?php

		settings_fields('coe_settings');
		do_settings_sections( 'coe_settings' );

		?>

		<table class="form-table">
			<thead>
				<tr>
					<th></th>
					<th><?php _e('Current Value', 'coe'); ?></th>
					<th><?php _e('Change to', 'coe'); ?></th>
				</tr>
			</thead>
		</table>

		<?php submit_button(); ?>

	</form>

</div>
