<?php
App::uses('Ehon', 'Model');

/**
 * Ehon Test Case
 *
 */
class EhonTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.ehon',
		'app.user',
		'app.page',
		'app.title'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Ehon = ClassRegistry::init('Ehon');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Ehon);

		parent::tearDown();
	}

}
