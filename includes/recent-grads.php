<?php

/** @var \COE\Controller $coe_controller */
global $coe_controller;

$all_colleges = \COE\College::getAllPublishedColleges();
$all_categories = \COE\ProgramCategory::getAllPublishedCategories();
$all_awards = \COE\Award::getAllPublishedAwards();
$programs = \COE\Program::getAllPublishedPrograms();

$cities = array();

/** @var \COE\College[] $colleges */
$colleges = array();

/** @var \COE\ProgramCategory[] $categories */
$categories = array();

/** @var \COE\Award[] $awards */
$awards = array();

foreach ( $programs as $program )
{
	if ( ! array_key_exists( $program->getCollegeId(), $colleges ) && isset( $all_colleges[ $program->getCollegeId() ] ) )
	{
		$colleges[ $program->getCollegeId() ] = $all_colleges[ $program->getCollegeId() ];
		if ( ! in_array( $colleges[ $program->getCollegeId() ]->getCityState(), $cities ) )
		{
			$cities[] = $colleges[ $program->getCollegeId() ]->getCityState();
		}
	}

	if ( ! array_key_exists( $program->getAwardId(), $awards ) && isset( $all_awards[ $program->getAwardId() ] ) )
	{
		$awards[ $program->getAwardId() ] = $all_awards[ $program->getAwardId() ];
	}

	foreach ( $program->getProgramCategoryIds() as $category_id )
	{
		if ( ! array_key_exists( $category_id, $categories ) && isset( $all_categories[ $category_id ] ) )
		{
			$categories[ $category_id ] = $all_categories[ $category_id ];
		}
	}
}

?>

<?php if ( count( $programs ) == 0 ) { ?>

	<div class="alert alert-info">
		There are no recent graduate programs at this time.
		Please check back later.
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
		                        position: lat_lng
		                    });

		                    coe_marker.setMap( coe_map );

	                    <?php } ?>
	                <?php } ?>
                }

			</script>

		</div>

		<div class="col-md-4">

			<div class="panel panel-coe">
				<div class="panel-heading">
					Categories
				</div>
				<div class="panel-body">
					<?php foreach ( $categories as $category ) { ?>
						<div class="row">
							<div class="col-xs-2">
								<input type="checkbox">
							</div>
							<div class="col-xs-10">
								<?php echo $category->getTitle(); ?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>

			<div class="panel panel-coe">
				<div class="panel-heading">
					Cities
				</div>
				<div class="panel-body">
					<?php foreach ( $cities as $index => $city ) { ?>
						<div class="row">
							<div class="col-xs-2">
								<input type="checkbox">
							</div>
							<div class="col-xs-10">
								<?php echo $city; ?>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>

			<div class="panel panel-coe">
				<div class="panel-heading">
					Colleges
				</div>
				<div class="panel-body">
					<?php foreach ( $colleges as $college ) { ?>
						<div class="row">
							<div class="col-xs-2">
								<input type="checkbox">
							</div>
							<div class="col-xs-10">
								<?php echo $college->getTitle(); ?><br>
								<em><?php echo $college->getCityState(); ?></em>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>

		</div>

	</div>

<?php } ?>