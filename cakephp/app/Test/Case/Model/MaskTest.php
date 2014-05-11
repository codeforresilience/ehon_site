<?php
App::uses('Mask', 'Model');

/**
 * Mask Test Case
 *
 */
class MaskTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.mask',
		'app.pages',
		'app.user',
		'app.translation'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Mask = ClassRegistry::init('Mask');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Mask);

		parent::tearDown();
	}

}
