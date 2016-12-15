<?php

global $post;
$award = new \COE\Award( $post->ID );

?>

<table class="form-table">
	<tr>
		<th>
			<label for="coe-award-type">
				Type:
			</label>
		</th>
		<td>
			<select name="award_type" id="coe-award-type" class="form-control">
                <?php foreach ( \COE\Award::getTypes() as $type ) { ?>
                    <option value="<?php echo $type; ?>"<?php if ( $award->getType() == $type ) { ?> selected<?php } ?>>
                        <?php echo $type; ?>
                    </option>
                <?php } ?>
            </select>
		</td>
	</tr>
</table>