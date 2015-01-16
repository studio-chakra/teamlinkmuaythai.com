<?php
/**
 * @package Symetrio
 * @author Wonster
 * @link http://wonster.co/
 */

$wtr_date_format = array(
1 => array( 'sample' => '20.10.2013', 'date_d'=> 'd', 'date_m' => 'm', 'date_y' => 'Y' , 'all'=> 'd.m.Y' ),
2 => array( 'sample' => '20/10/2013', 'date_d'=> 'd', 'date_m' => 'm', 'date_y' => 'Y' , 'all'=> 'd/m/Y' ),
3 => array( 'sample' => '10.2013', 'date_d'=> '', 'date_m' => 'm', 'date_y' => 'Y' , 'all'=> 'm.Y' ),
4 => array( 'sample' => '10/2013', 'date_d'=> '', 'date_m' => 'm', 'date_y' => 'Y' , 'all'=> 'm/Y' ),
5 => array( 'sample' => '10.20.2013', 'date_d'=> 'd', 'date_m' => 'm', 'date_y' => 'Y' , 'all'=> 'm.d.Y' ),
6 => array( 'sample' => '10/20/2013', 'date_d'=> 'd', 'date_m' => 'm', 'date_y' => 'Y' , 'all'=> 'm/d/Y' ),
7 => array( 'sample' => '20 October 2013', 'date_d'=> 'd', 'date_m' => 'F', 'date_y' => 'Y' , 'all'=> 'd F Y' ),
8 => array( 'sample' => 'October 20 2013', 'date_d'=> 'd', 'date_m' => 'F', 'date_y' => 'Y' , 'all'=> 'F d Y' ),
9 => array( 'sample' => '20 OCT 2013', 'date_d'=> 'd', 'date_m' => 'M', 'date_y' => 'Y' , 'all'=> 'd M Y' ),
10 => array( 'sample' => 'OCT 20 2013', 'date_d'=> 'd', 'date_m' => 'M', 'date_y' => 'Y' , 'all'=> 'M d Y' ),
);

$wtr_date_format_field = array();
foreach( $wtr_date_format as $key => $value ){
	$wtr_date_format_field[ $key ] = $value['sample'];
}