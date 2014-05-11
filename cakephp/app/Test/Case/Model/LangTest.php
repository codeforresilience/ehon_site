<?php
App::uses('Lang', 'Model');

/**
 * Lang Test Case
 *
 */
class LangTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.lang',
		'app.title',
		'app.translation'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Lang = ClassRegistry::init('Lang');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Lang);

		parent::tearDown();
	}

}
