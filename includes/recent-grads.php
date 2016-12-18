<?php

/** @var \COE\Controller $coe_controller */
global $coe_controller;

$colleges = \COE\College::getAllPublishedColleges();
$categories = \COE\ProgramCategory::getAllPublishedCategories();
$awards = \COE\Award::getAllPublishedAwards();
$programs = \COE\Program::getAllPublishedPrograms();

$cities = array();
$college_ids = array();
$category_ids = array();
$award_ids = array();

foreach ( $programs as $program )
{
	if ( ! in_array( $program->getCollegeId(), $college_ids ) && isset( $colleges[ $program->getCollegeId() ] ) )
	{
		$college_ids[] =  $program->getCollegeId();

		if ( ! in_array( $colleges[ $program->getCollegeId() ]->getCityState(), $cities ) )
		{
			$cities[] = $colleges[ $program->getCollegeId() ]->getCityState();
		}
	}

	if ( ! in_array( $program->getAwardId(), $award_ids ) && isset( $awards[ $program->getAwardId() ] ) )
	{
		$award_ids[] = $program->getAwardId();
	}

	foreach ( $program->getProgramCategoryIds() as $category_id )
	{
		if ( ! in_array( $category_id, $category_ids ) && isset( $categories[ $category_id ] ) )
		{
			$category_ids[] = $category_id;
		}
	}
}

asort( $cities );

foreach ( $colleges as $college )
{
    if ( ! in_array( $college->getId(), $college_ids ) )
    {
        unset( $colleges[ $college->getId() ] );
    }
}

foreach ( $awards as $award )
{
	if ( ! in_array( $award->getId(), $award_ids ) )
	{
		unset( $awards[ $award->getId() ] );
	}
}

foreach ( $categories as $category )
{
	if ( ! in_array( $category->getId(), $category_ids ) )
	{
		unset( $categories[ $category->getId() ] );
	}
}

foreach ( $programs as $program )
{
    $colleges[ $program->getCollegeId() ]->addProgramId( $program->getId() );
}

$college_id = ( isset( $_GET['college_id'] ) && array_key_exists( $_GET['college_id'], $colleges ) ) ? $_GET['college_id'] : NULL;
$program_id = ( isset( $_GET['program_id'] ) && array_key_exists( $_GET['program_id'], $programs ) ) ? $_GET['program_id'] : NULL;
if ( $program_id !== NULL )
{
    $college_id = $programs[ $program_id ]->getCollegeId();
}

$college = NULL;
if ( $college_id !== NULL )
{
    $college = $colleges[ $college_id ];
}

?>

<?php if ( count( $programs ) == 0 ) { ?>

	<div class="alert alert-info">
		There are no recent graduate programs at this time.
		Please check back later.
	</div>

<?php } elseif ( $college_id !== NULL ) { ?>

    <p>
        <a href="?" class="btn btn-default">
            <i class="fa fa-chevron-left"></i>
            Back to List
        </a>
    </p>

    <div class="row">

        <div class="col-md-8">

            <?php for ( $loop = 1; $loop <= 2; $loop++ ) { ?>

                <?php if ( $loop == 1 && $program_id === NULL ) continue; ?>

                <?php if ( $loop == 2 && $program_id !== NULL && count( $college->getProgramIds() ) > 1 ) { ?>

                    <hr>

                    <h3 align="center">
                        More Programs at<br>
                        <?php echo $college->getTitle(); ?>
                    </h3>

                <?php } ?>

                <?php foreach ( $college->getProgramIds() as $pid ) { ?>

                    <?php if ( ( $loop == 1 && $program_id == $pid ) || ( $loop == 2 && $program_id != $pid ) || ( $loop == 2 && $program_id === NULL ) ) { ?>

                        <?php $program = $programs[ $pid ]; ?>

                        <div class="panel panel-coe-orange">
                            <div class="panel-heading">
					            <?php echo $program->getTitle(); ?>
                                <span class="pull-right">
                                    <?php if ( $loop == 1 ) { ?>
                                        <i class="fa fa-chevron-down coe-filter-arrow" data-menu="<?php echo $program->getId(); ?>" data-display="block"></i>
                                    <?php } else { ?>
                                        <i class="fa fa-chevron-up coe-filter-arrow" data-menu="<?php echo $program->getId(); ?>" data-display="none"></i>
                                    <?php } ?>
                                </span>
                            </div>
                            <div class="panel-body panel-body-<?php echo $program->getId(); ?>"<?php if ( $loop == 2 ) { ?> style="display:none;"<?php } ?>>

                                <?php if ( array_key_exists( $program->getAwardId(), $awards ) ) { ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>Award Type</strong>
                                        </div>
                                        <div class="col-md-8">
                                            <?php echo $awards[ $program->getAwardId() ]->getTitle(); ?>
                                        </div>
                                    </div>
                                <?php } ?>

                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Credits</strong>
                                    </div>
                                    <div class="col-md-8">
			                            <?php echo $program->getCredits(); ?>
                                    </div>
                                </div>

                                <?php if ( strlen( $program->getStartsAt() ) > 0 ) { ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>Starts</strong>
                                        </div>
                                        <div class="col-md-8">
			                                <?php echo $program->getStartsAt(); ?>
                                        </div>
                                    </div>
                                <?php } ?>

	                            <?php if ( strlen( $program->getEndsAt() ) > 0 ) { ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>Ends</strong>
                                        </div>
                                        <div class="col-md-8">
				                            <?php echo $program->getEndsAt(); ?>
                                        </div>
                                    </div>
	                            <?php } ?>

                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Anticipated Graduates</strong>
                                    </div>
                                    <div class="col-md-8">
			                            <?php echo $program->getAnticipatedGraduates(); ?>
                                    </div>
                                </div>

	                            <?php if ( strlen( $program->getContactName() ) > 0 ) { ?>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>Contact</strong>
                                        </div>
                                        <div class="col-md-8">
				                            <?php echo $program->getContactName(); ?>
                                            <?php if ( strlen( $program->getContactPhone() ) > 0 ) { ?>
                                                <br><?php echo $program->getContactPhone(); ?>
                                            <?php } ?>
	                                        <?php if ( strlen( $program->getContactEmail() ) > 0 ) { ?>
                                                <br><a href="mailto:<?php echo $program->getContactEmail(); ?>"><?php echo $program->getContactEmail(); ?></a>
	                                        <?php } ?>
                                        </div>
                                    </div>
	                            <?php } ?>

	                            <?php if ( strlen( $program->getDescription() ) > 0 ) { ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <strong>Description</strong>
                                        </div>
                                        <div class="col-md-12">
				                            <?php echo $program->getDescription(); ?>
                                        </div>
                                    </div>
	                            <?php } ?>

	                            <?php if ( strlen( $program->getSkillSets() ) > 0 ) { ?>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <strong>Skill Sets</strong>
                                        </div>
                                        <div class="col-md-12">
				                            <?php echo $program->getSkillSets(); ?>
                                        </div>
                                    </div>
	                            <?php } ?>

                            </div>
                        </div>

                    <?php } ?>

                <?php } ?>

            <?php } ?>

        </div>

        <div class="col-md-4">

            <div class="panel panel-coe">
                <div class="panel-heading">
	                <?php echo $college->getTitle(); ?>
                </div>
                <div class="panel-body">

	                <?php if ( strlen( $college->getLogo() ) > 0 ) { ?>
                        <p align="center">
                            <img src="<?php echo $college->getLogo(); ?>" class="img-responsive">
                        </p>
                        <hr>
	                <?php } ?>

                    <p align="center">
                        <strong><?php echo $college->getTitle(); ?></strong><br>
		                <?php echo $college->getAddress(); ?><br>
		                <?php echo $college->getCityStateZip(); ?>
                    </p>

                    <?php if ( $college->hasLatLng() ) { ?>

                        <hr>

                        <div id="coe-map" style="width:100%; height:200px;"></div>

                        <script>

                            jQuery(function(){

                                coeMapInit();
                            });

                            function coeMapInit()
                            {
                                var lat_lng = new google.maps.LatLng( <?php echo $college->getLat(); ?>, <?php echo $college->getLng(); ?> );

                                var options = {
                                    zoom: 13,
                                    center: lat_lng,
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                };

                                var coe_map = new google.maps.Map( document.getElementById( 'coe-map' ), options );

			                    var coe_marker = new google.maps.Marker({
                                    position: lat_lng
                                });

			                    coe_marker.setMap( coe_map );
                            }

                        </script>

                        <hr>

                        <p align="center">
                            <a target="_blank" class="btn btn-default" href="<?php echo 'http://www.google.com/maps/place/' . urlencode( $college->getAddressString() ) . '/@' . $college->getLat() . ',' . $college->getLng(); ?>">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                Directions
                            </a>
                        </p>

                    <?php } ?>
                </div>
            </div>


        </div>

    </div>

<?php } else { ?>

	<div class="row">

		<div class="col-md-8">

			<div id="coe-map" style="width:100%; height:300px;"></div>

			<script>

                jQuery(function(){

                    coeMapInit();
                });

                function coeMapInit()
                {
                    var wa_lat_lng = new google.maps.LatLng( 47.3, -120.7 );

                    var options = {
                        zoom: 6,
                        center: wa_lat_lng,
                        mapTypeId: google.maps.MapTypeId.ROADMAP
                    };

                    var coe_map = new google.maps.Map( document.getElementById( 'coe-map' ), options );

                    <?php foreach ( $colleges as $college ) { ?>
	                    <?php if ( $college->hasLatLng() ) { ?>

	                        var lat_lng = new google.maps.LatLng( <?php echo $college->getLat() ?>, <?php echo $college->getLng(); ?> );

		                    var coe_marker = new google.maps.Marker({
		                        position: lat_lng,
                                title: '<?php echo str_replace( "'", "\'", $college->getTitle() ); ?>'
		                    });

		                    coe_marker.setMap( coe_map );

                            coe_marker.addListener('click', function() {
                                window.location = '?college_id=<?php echo $college->getId(); ?>'
                            });

	                    <?php } ?>
	                <?php } ?>
                }

			</script>

            <hr>

            <?php foreach ( $colleges as $college ) { ?>

                <div class="panel panel-coe-orange">
                    <div class="panel-heading">
                        <?php echo $college->getTitle(); ?><br>
                        <small>
                            <?php echo $college->getCityState(); ?>
                        </small>
                        <span class="pull-right">
                            <i class="fa fa-chevron-up coe-filter-arrow" data-menu="<?php echo $college->getId(); ?>" data-display="none"></i>
                        </span>
                    </div>
                    <div class="panel-body panel-body-<?php echo $college->getId(); ?>" style="display:none;">

                        <?php foreach ( $college->getProgramIds() as $program_id ) { ?>
                            <p>
                                <a href="?program_id=<?php echo $program_id; ?>"><?php echo $programs[ $program_id ]->getTitle(); ?></a>
                            </p>
                        <?php } ?>

                    </div>
                </div>

            <?php } ?>

		</div>

		<div class="col-md-4">

			<div class="panel panel-coe">
				<div class="panel-heading">
					Categories
                    <span class="pull-right">
                        <i class="fa fa-chevron-up coe-filter-arrow" data-menu="a" data-display="none"></i>
                    </span>
				</div>
				<div class="panel-body panel-body-a" style="display:none;">
					<?php foreach ( $categories as $category ) { ?>
						<div class="coe-cb coe-cb-category" data-id="<?php echo $category->getId(); ?>">
                            <?php echo $category->getTitle(); ?>
						</div>
					<?php } ?>
				</div>
			</div>

			<div class="panel panel-coe">
				<div class="panel-heading">
					Cities
                    <span class="pull-right">
                        <i class="fa fa-chevron-up coe-filter-arrow" data-menu="b" data-display="none"></i>
                    </span>
				</div>
				<div class="panel-body panel-body-b" style="display:none;">
					<?php foreach ( $cities as $index => $city ) { ?>
                        <div class="coe-cb coe-cb-city" data-id="<?php echo $index; ?>">
                            <?php echo $city; ?>
						</div>
					<?php } ?>
				</div>
			</div>

			<div class="panel panel-coe">
				<div class="panel-heading">
					Colleges
                    <span class="pull-right">
                        <i class="fa fa-chevron-up coe-filter-arrow" data-menu="c" data-display="none"></i>
                    </span>
				</div>
				<div class="panel-body panel-body-c" style="display:none;">
					<?php foreach ( $colleges as $college ) { ?>
                        <div class="coe-cb coe-cb-college" data-id="<?php echo $college->getId(); ?>">
                            <?php echo $college->getTitle(); ?><br>
                            <em><?php echo $college->getCityState(); ?></em>
						</div>
					<?php } ?>
				</div>
			</div>

		</div>

	</div>

<?php } ?>
