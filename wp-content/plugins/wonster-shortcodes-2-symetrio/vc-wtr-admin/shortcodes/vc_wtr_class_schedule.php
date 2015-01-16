<?php
// Don't load directly
if ( !defined('ABSPATH') ) { die('-1'); }

include_once ( 'vc_wtr.php' );


class ClassScheduleExt{

	static public function getClassScheduleList(){

		global $wpdb;

		$data		= $wpdb->get_results( 'SELECT `t`.id, `t`.name FROM `' . $wpdb->prefix . 'wtr_schedule`as `t`','ARRAY_A' );
		$result_c	= count( $data );

		if( !$result_c ) {
			$result = array( __( 'There is no item to choose from', 'wtr_sht_framework' ) => 'NN' );
		}
		else{
			$result		= array();
			for($i = 0; $i < $result_c; $i++ ){
				$result[ ' ' . $data[ $i ][ 'name' ] .' ' ] = $data[ $i ][ 'id' ];
			}
		}

		return $result;
	}

};//end ClassScheduleExt


class VCExtendAddonClassSchedule extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_class_schedule';
	public $fields	= array();

	//===FUNCTIONS
	public function __construct(){

		parent::__construct();

		// We safely integrate with VC with this hook
		add_action( 'init', array( &$this, 'integrateWithVC' ) );
	}//end __construct


	public function integrateWithVC(){
		// Map fields

		$this->fields = array(
			array(
				'param_name'	=> 'alert',
				'heading'		=> '',
				'description'	=> '',
				'type'			=> 'wtr_alert',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_alert_class',
				'dependency' 	=> array(	'element'	=> 'type',
											'value'		=> array( 'boxed' ) ),
				'wtr_attr'		=> array(	'extra_class'	=> '',
											'message'		=> __( '<b>Important!</b> This element  may be used in a page
																<b>only in column 1/1</b>', 'wtr_sht_framework' )
										 ),
			),

			array(
				'param_name'	=> 'id_schedule',
				'heading'		=> __( 'Schedule', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> ClassScheduleExt::getClassScheduleList(),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_mode_class',
			),

			array(
				'param_name'	=> 'version',
				'heading'		=> __( 'Version', 'wtr_sht_framework' ),
				'description'	=> __( 'Enable this option if you want to put this item on the background and make it
										more attractive', 'wtr_sht_framework' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Standard', 'wtr_sht_framework' )	=> 'wtrShtTimeTableStandard',
											__( 'Light', 'wtr_sht_framework' )		=> 'wtrShtTimeTableLight',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_version_class',
			),

			array(
				'param_name'	=> 'empty_hours',
				'heading'		=> __( "Don't show empty spaces when there is no classes", 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'Show', 'wtr_sht_framework' )	=> 'no',
											__( 'Hide', 'wtr_sht_framework' )	=> 'yes',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_empty_hours',
			),


			array(
				'param_name'	=> 'modal',
				'heading'		=> __( 'Modal', 'wtr_sht_framework' ),
				'description'	=> __( 'Show additional info for classes' ),
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'No', 'wtr_sht_framework' )		=> 'no',
											__( 'Yes', 'wtr_sht_framework' )	=> 'yes',
										),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_modal_class',
			),

			array(
				'param_name'	=> 'show_level',
				'heading'		=> __( 'Hide class details in header section', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'No', 'wtr_sht_framework' )		=> 'no',
											__( 'Yes', 'wtr_sht_framework' )	=> 'yes'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_show_level',
				'dependency' 	=> array(	'element'	=> 'modal',
											'value'		=> array( 'yes' ) ),
			),

			array(
				'param_name'	=> 'pdf',
				'heading'		=> __( 'Link to the timetable in PDF file', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'No', 'wtr_sht_framework' )		=> 'no',
											__( 'Yes', 'wtr_sht_framework' )	=> 'yes',
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_pdf_class',
			),

			array(
				'param_name'	=> 'pdf_url',
				'heading'		=> __( 'Link to the timetable in PDF file', 'wtr_sht_framework' ),
				'description'	=> __( 'Insert full url', 'wtr_sht_framework' ),
				'type'			=> 'textfield',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_pdf_url_class',
				'dependency' 	=> array(	'element'	=> 'pdf',
											'value'		=> array( 'yes' ) )
			),

			$this->getDefaultVCfield( 'el_class' ),
		);


		vc_map( array(
			'name'			=> __( 'Class schedule', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'elements' ],
			'params'		=> $this->fields,
			'weight'		=> 35500,
			)
		);
	}//end integrateWithVC

}//end VCExtendAddonClassSchedule


class VCExtendAddonDailySchedule extends VCExtendAddonWtr{

	public $base	= 'vc_wtr_daily_schedule';
	public $fields	= array();

	//===FUNCTIONS
	public function __construct(){

		parent::__construct();

		// We safely integrate with VC with this hook
		add_action( 'init', array( &$this, 'integrateWithVC' ) );
	}//end __construct


	public function integrateWithVC(){
		// Map fields

		$this->fields = array(
			array(
				'param_name'	=> 'alert',
				'heading'		=> '',
				'description'	=> '',
				'type'			=> 'wtr_alert',
				'value'			=> '',
				'admin_label' 	=> false,
				'class'			=> $this->base . '_alert_class',
				'dependency' 	=> array(	'element'	=> 'type',
											'value'		=> array( 'boxed' ) ),
				'wtr_attr'		=> array(	'extra_class'	=> '',
											'message'		=> __( '<b>Important!</b> This element  may be used in a page
																<b>only in column 1/1</b>', 'wtr_sht_framework' )
										 ),
			),

			array(
				'param_name'	=> 'id_schedule',
				'heading'		=> __( 'Schedule', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> ClassScheduleExt::getClassScheduleList(),
				'admin_label' 	=> true,
				'class'			=> $this->base . '_mode_class',
			),

			array(
				'param_name'	=> 'show_level',
				'heading'		=> __( 'Hide the difficulty of the classes', 'wtr_sht_framework' ),
				'description'	=> '',
				'type'			=> 'dropdown',
				'value'			=> array(	__( 'No', 'wtr_sht_framework' )		=> 'no',
											__( 'Yes', 'wtr_sht_framework' )	=> 'yes'
										),
				'admin_label' 	=> false,
				'class'			=> $this->base . '_show_level',
			),

			$this->getDefaultVCfield( 'el_class' ),
		);


		vc_map( array(
			'name'			=> __( 'Daily schedule', 'wtr_sht_framework' ),
			'description'	=> '',
			'base'			=> $this->base,
			'class'			=> $this->base . '_div '. $this->wtrShtMainClass,
			'icon'			=> $this->base . '_icon',
			'controls'		=> 'full',
			'category'		=> $this->groupSht[ 'elements' ],
			'params'		=> $this->fields,
			'weight'		=> 30500,
			)
		);

		// animate attr
		$this->shtAnimateAttrGenerator( $this->fields, true );
	}//end integrateWithVC

}//end VCExtendAddonDailySchedule


if( defined( 'WTR_CS_PLUGIN_STATUS' ) ){
	new VCExtendAddonClassSchedule();
	new VCExtendAddonDailySchedule();
}
