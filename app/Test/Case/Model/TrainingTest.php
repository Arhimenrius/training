<?php
App::uses('Training', 'Model');

/**
 * Training Test Case
 *
 */
class TrainingTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.training',
		'app.activity'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Training = ClassRegistry::init('Training');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Training);

		parent::tearDown();
	}

}
