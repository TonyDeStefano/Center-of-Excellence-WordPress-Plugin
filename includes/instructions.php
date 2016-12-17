<?php

/**
 * @var \COE\Controller $this
 */

?>

<div class="wrap">

	<h1>
		Center Of Excellence Plugin <?php _e( 'Instructions', 'coe' ); ?>
	</h1>

    <p>Use this shortcode to insert the recent graduates system onto any page:</p>

    [coe display="recent_grads"]

</div>

<?php

if ( isset( $_GET['import'] ) )
{
    $categories = \COE\ProgramCategory::getAllPublishedCategories();
    $colleges = \COE\College::getAllPublishedColleges();
    $awards = \COE\Award::getAllPublishedAwards();
    $current_programs = \COE\Program::getAllPublishedPrograms();

    $json = file_get_contents( __DIR__ . '/import.json' );
    $programs = json_decode( $json, TRUE );

    foreach ( $programs as $program )
    {
	    $award_id = '';

        if ( strlen( $program['award']['title'] ) > 0 )
        {
            foreach ( $awards as $award )
            {
                if ( $award->getTitle() == trim( $program['award']['title'] ) )
                {
                    $award_id = $award->getId();
                    break;
                }
            }

            if ( $award_id == '' )
            {
                $award_id = wp_insert_post( array(
                    'post_title' => $program['award']['title'],
                    'post_type' => \COE\Award::POST_TYPE,
                    'post_status' => 'publish'
                ) );

                $award = new \COE\Award( $award_id );
                $award
                    ->setType( ucfirst( $program['award']['type'] ) )
                    ->update();

                $awards[ $award->getId() ] = $award;
            }
        }

        $college_id = '';

	    if ( strlen( $program['college']['title'] ) > 0 )
	    {
		    foreach ( $colleges as $college )
		    {
			    if ( $college->getTitle() == trim( $program['college']['title'] ) )
			    {
				    $college_id = $college->getId();
				    break;
			    }
		    }

		    if ( $college_id == '' )
		    {
			    $college_id = wp_insert_post( array(
				    'post_title' => $program['college']['title'],
				    'post_type' => \COE\College::POST_TYPE,
				    'post_status' => 'publish'
			    ) );

			    $college = new \COE\College( $college_id );
			    $college
				    ->setCity( $program['college']['city'] )
				    ->setState( $program['college']['state'] )
				    ->update();

			    $colleges[ $college->getId() ] = $college;
		    }
	    }

	    $category_ids = [];

	    if ( count( $program['categories'] ) > 0 )
	    {
	        foreach ( $program['categories'] as $cat )
	        {
	            $category_id = '';

		        foreach ( $categories as $category )
		        {
			        if ( $category->getTitle() == trim( $cat ) )
			        {
				        $category_id = $category->getId();
				        break;
			        }
		        }

		        if ( $category_id == '' )
		        {
			        $category_id = wp_insert_post( array (
				        'post_title' => $cat,
				        'post_type' => \COE\ProgramCategory::POST_TYPE,
				        'post_status' => 'publish'
			        ) );

			        $category = new \COE\ProgramCategory( $category_id );

			        $categories[ $category->getId() ] = $category;
		        }

		        $category_ids[] = $category_id;
	        }
	    }

	    $program_id = '';

	    foreach ( $current_programs as $prog )
        {
            if ( $prog->getCollegeId() == $college_id && $prog->getAwardId() == $award_id && $prog->getTitle() == trim( $program['title'] ) )
            {
                $program_id = $prog->getId();
                break;
            }
        }

        if ( $program_id == '' )
        {
            $program_id = wp_insert_post( array (
	            'post_title' => $program['title'],
                'post_content' => $program['description'],
	            'post_type' => \COE\Program::POST_TYPE,
	            'post_status' => ( $program['visible'] == 1 ) ? 'publish' : 'draft'
            ) );

            $prog = new \COE\Program( $program_id );
            $prog
	            ->setCollegeId( $college_id )
	            ->setAwardId( $award_id )
	            ->setProgramCategoryIds( $category_ids )
	            ->setContactName( $program['contact_name'] )
	            ->setContactEmail( $program['contact_email'] )
	            ->setContactPhone( $program['contact_phone'] )
	            ->setCredits( $program['credits'] )
	            ->setStartsAt( $program['program_start'] )
	            ->setEndsAt( $program['program_end'] )
	            ->setAnticipatedGraduates( $program['capacity'] )
	            ->setSkillSets( $program['skill_sets'] )
	            ->update();

	        $current_programs[ $prog->getId() ] = $prog;
        }
    }
}

?>
