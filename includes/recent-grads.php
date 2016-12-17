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

$college_id = ( isset( $_GET['college_id'] ) && array_key_exists( $_GET['college_id'], $colleges ) ) ? $_GET['college_id'] : NULL;
$program_id = ( isset( $_GET['program_id'] ) && array_key_exists( $_GET['program_id'], $colleges ) ) ? $_GET['program_id'] : NULL;
if ( $program_id !== NULL )
{
    $college_id = $programs[ $program_id ]->getCollegeId();
}

?>

<?php if ( count( $programs ) == 0 ) { ?>

	<div class="alert alert-info">
		There are no recent graduate programs at this time.
		Please check back later.
	</div>

<?php } elseif ( $college_id !== NULL ) { ?>



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

		</div>

		<div class="col-md-4">

			<div class="panel panel-coe">
				<div class="panel-heading">
					Categories
                    <span class="pull-right">
                        <i class="fa fa-chevron-down coe-filter-arrow" data-menu="a" data-display="none"></i>
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
                        <i class="fa fa-chevron-down coe-filter-arrow" data-menu="b" data-display="none"></i>
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
                        <i class="fa fa-chevron-down coe-filter-arrow" data-menu="c" data-display="none"></i>
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
