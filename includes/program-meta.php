<?php

global $post;
$program = new \COE\Program( $post->ID );

$colleges = \COE\College::getAllPublishedColleges();
$awards = \COE\Award::getAllPublishedAwards();
$categories = \COE\ProgramCategory::getAllPublishedCategories()

?>

<table class="form-table">
    <tr>
        <th>
            <label for="coe-program-college-id">
                College (<a href="post-new.php?post_type=coe_college" target="_blank">Add New</a>):
            </label>
        </th>
        <td>
            <select class="form-control" id="coe-program-college-id" name="college_id">
                <option value="">
                    N/A
                </option>
                <?php foreach ( $colleges as $college ) { ?>
                    <option value="<?php echo $college->getId(); ?>"<?php if ( $college->getId() == $program->getCollegeId() ) { ?> selected<?php } ?>>
                        <?php echo $college->getTitle(); ?>
                    </option>
                <?php } ?>
            </select>
        </td>
    </tr>
    <tr>
        <th>
            <label for="coe-program-award-id">
                Award (<a href="post-new.php?post_type=coe_award" target="_blank">Add New</a>):
            </label>
        </th>
        <td>
            <select class="form-control" id="coe-program-award-id" name="award_id">
                <option value="">
                    N/A
                </option>
				<?php foreach ( $awards as $award ) { ?>
                    <option value="<?php echo $award->getId(); ?>"<?php if ( $award->getId() == $program->getAwardId() ) { ?> selected<?php } ?>>
						<?php echo $award->getTitle(); ?>
                        (<?php echo $award->getType(); ?>)
                    </option>
				<?php } ?>
            </select>
        </td>
    </tr>
    <tr>
        <th>
            <label for="coe-program-category-id">
                Categories (<a href="post-new.php?post_type=coe_program_category" target="_blank">Add New</a>):
            </label>
        </th>
        <td>
            <?php foreach ( $categories as $category ) { ?>
                <input type="checkbox" name="category_id[]" value="<?php echo $category->getId(); ?>" <?php if ( in_array( $category->getId(), $program->getProgramCategoryIds() ) ) { ?> checked <?php } ?>>
                <?php echo $category->getTitle(); ?><br>
            <?php } ?>
        </td>
    </tr>
	<tr>
		<th>
			<label for="coe-program-contact-name">
				Contact Name:
			</label>
		</th>
		<td>
			<input name="contact_name" class="form-control" id="coe-program-contact-name" value="<?php echo esc_html( $program->getContactName() ); ?>">
		</td>
	</tr>
    <tr>
        <th>
            <label for="coe-program-contact-email">
                Contact Email:
            </label>
        </th>
        <td>
            <input type="email" name="contact_email" class="form-control" id="coe-program-contact-email" value="<?php echo esc_html( $program->getContactEmail() ); ?>">
        </td>
    </tr>
    <tr>
        <th>
            <label for="coe-program-contact-phone">
                Contact Phone:
            </label>
        </th>
        <td>
            <input name="contact_phone" class="form-control" id="coe-program-contact-phone" value="<?php echo esc_html( $program->getContactPhone() ); ?>">
        </td>
    </tr>
    <tr>
        <th>
            <label for="coe-program-credits">
                Credits:
            </label>
        </th>
        <td>
            <input name="credits" class="form-control" id="coe-program-credits" value="<?php echo esc_html( $program->getCredits() ); ?>">
        </td>
    </tr>
    <tr>
        <th>
            <label for="coe-program-starts-at">
                Start Date:
            </label>
        </th>
        <td>
            <input name="starts_at" class="form-control" id="coe-program-starts-at" value="<?php echo esc_html( $program->getStartsAt() ); ?>">
        </td>
    </tr>
    <tr>
        <th>
            <label for="coe-program-ends-at">
                End Date:
            </label>
        </th>
        <td>
            <input name="ends_at" class="form-control" id="coe-program-ends-at" value="<?php echo esc_html( $program->getEndsAt() ); ?>">
        </td>
    </tr>
    <tr>
        <th>
            <label for="coe-program-graduates">
                Anticipated Graduates:
            </label>
        </th>
        <td>
            <input name="graduates" class="form-control" id="coe-program-graduates" value="<?php echo esc_html( $program->getAnticipatedGraduates() ); ?>">
        </td>
    </tr>
    <tr>
        <th>
            <label for="coe-program-skill-sets">
                Skill Sets:
            </label>
        </th>
        <td></td>
    </tr>
    <tr>
        <td colspan="2">
            <?php

            $settings = array( 'media_buttons' => FALSE );
            wp_editor( $program->getSkillSets(), 'skill_sets', $settings );

            ?>
        </td>
    </tr>
</table>
