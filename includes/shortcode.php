<?php

/** @var \COE\Controller $coe_controller */
global $coe_controller;

echo '<div id="coe-main-container">';

if ( $coe_controller->get_attribute( 'display' ) == 'recent_grads' && $coe_controller->isRecentGradsVisible() )
{
	include( 'recent-grads.php' );
}

echo '</div>';