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

		settings_fields( 'coe_settings' );
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
            <tr valign="top">
                <th scope="row">
                    <label>
						<?php _e( 'Google Maps API Key (optional)', 'coe' ); ?>
                    </label>
                </th>
                <td><?php echo $this->getGoogleMapsApiKey(); ?></td>
                <td><input class="form-control" type="text" name="<?php echo \COE\Controller::SETTING_GOOGLE_MAP_API_KEY; ?>" value="<?php echo esc_html( $this->getGoogleMapsApiKey() ); ?>"></td>
            </tr>
            <tr valign="top">
                <th scope="row">
                    <label>
						<?php _e( 'Recent Grads Status', 'coe' ); ?>
                    </label>
                </th>
                <td><?php echo ( $this->isRecentGradsVisible() ) ? 'On' : 'Off'; ?></td>
                <td>
                    <select class="form-control" name="<?php echo \COE\Controller::SETTING_RECENT_GRADS_VISIBLE; ?>">
                        <option value="1">
                            On
                        </option>
                        <option value="0"<?php if ( ! $this->isRecentGradsVisible() ) { ?> selected<?php } ?>>
                            Off
                        </option>
                    </select>
                </td>
            </tr>
		</table>

		<?php submit_button(); ?>

	</form>

</div>
