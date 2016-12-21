<?php

global $post;
$college = new \COE\College( $post->ID );

?>

<table class="form-table">
	<tr>
		<th>
			<label for="coe-college-address">
				Address:
			</label>
		</th>
		<td colspan="2">
			<input name="address" class="form-control" id="coe-college-address" value="<?php echo esc_html( $college->getAddress() ); ?>">
		</td>
	</tr>
	<tr>
		<th>
			<label for="coe-college-city">
				City:
			</label>
		</th>
		<td colspan="2">
			<input name="city" class="form-control" id="coe-college-city" value="<?php echo esc_html( $college->getCity() ); ?>">
		</td>
	</tr>
	<tr>
		<th>
			<label for="coe-college-state">
				State:
			</label>
		</th>
		<td colspan="2">
			<input name="state" class="form-control" id="coe-college-state" value="<?php echo esc_html( $college->getState() ); ?>">
		</td>
	</tr>
	<tr>
		<th>
			<label for="coe-college-zip">
				Zip:
			</label>
		</th>
		<td colspan="2">
			<input name="zip" class="form-control" id="coe-college-zip" value="<?php echo esc_html( $college->getZip() ); ?>">
		</td>
	</tr>
</table>

<?php if ( $college->hasLatLng() ) { ?>

	<div id="coe-map" style="width:100%; height:400px;"></div>

	<script>

		jQuery(function(){

		    coeMapInit();
		});

        function coeMapInit()
        {
            var myLatlng = new google.maps.LatLng( <?php echo $college->getLat() ?>, <?php echo $college->getLng(); ?> );

            var myOptions = {
                zoom: 6,
                center: myLatlng,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            var coe_map = new google.maps.Map( document.getElementById( 'coe-map' ), myOptions );

            var coe_marker = new google.maps.Marker({
                position: myLatlng
            });

            coe_marker.setMap( coe_map );
        }

	</script>

<?php } ?>
