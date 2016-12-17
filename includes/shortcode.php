<?php

/** @var \COE\Controller $coe_controller */
global $coe_controller;

if ( $coe_controller->get_attribute( 'display' ) == 'recent_grads' && $coe_controller->isRecentGradsVisible() )
{
	include( 'recent-grads.php' );
}