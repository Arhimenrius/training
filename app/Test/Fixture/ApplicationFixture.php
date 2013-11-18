<?php
/**
 * ApplicationFixture
 *
 */
class ApplicationFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'material_1_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'material_1_number' => array('type' => 'integer', 'null' => false, 'default' => null),
		'material_2_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'material_2_number' => array('type' => 'integer', 'null' => false, 'default' => null),
		'material_3_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'material_3_number' => array('type' => 'integer', 'null' => false, 'default' => null),
		'material_4_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'material_4_number' => array('type' => 'integer', 'null' => false, 'default' => null),
		'material_5_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'material_5_number' => array('type' => 'integer', 'null' => false, 'default' => null),
		'priority_activity_1' => array('type' => 'integer', 'null' => false, 'default' => null),
		'priority_activity_2' => array('type' => 'integer', 'null' => false, 'default' => null),
		'priority_activity_3' => array('type' => 'integer', 'null' => false, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'material_1_id' => 1,
			'material_1_number' => 1,
			'material_2_id' => 1,
			'material_2_number' => 1,
			'material_3_id' => 1,
			'material_3_number' => 1,
			'material_4_id' => 1,
			'material_4_number' => 1,
			'material_5_id' => 1,
			'material_5_number' => 1,
			'priority_activity_1' => 1,
			'priority_activity_2' => 1,
			'priority_activity_3' => 1
		),
	);

}
