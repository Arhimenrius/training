<?php
App::uses('PaymentLog', 'Model');

/**
 * PaymentLog Test Case
 *
 */
class PaymentLogTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.payment_log',
		'app.record'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->PaymentLog = ClassRegistry::init('PaymentLog');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->PaymentLog);

		parent::tearDown();
	}

}
