<?php
/**
 * ActivityFixture
 *
 */
class ActivityFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'training_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'name' => array('type' => 'string', 'null' => false, 'default' => null, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'availability' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 9),
		'date' => array('type' => 'date', 'null' => false, 'default' => null),
		'time_start' => array('type' => 'time', 'null' => false, 'default' => null),
		'time_end' => array('type' => 'time', 'null' => false, 'default' => null),
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
			'training_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'availability' => 1,
			'date' => '2013-11-15',
			'time_start' => '11:03:54',
			'time_end' => '11:03:54'
		),
	);

}
