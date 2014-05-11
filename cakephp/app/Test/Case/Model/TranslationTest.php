<?php
App::uses('Translation', 'Model');

/**
 * Translation Test Case
 *
 */
class TranslationTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.translation',
		'app.mask',
		'app.pages',
		'app.user',
		'app.lang',
		'app.title',
		'app.ehon',
		'app.page'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Translation = ClassRegistry::init('Translation');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Translation);

		parent::tearDown();
	}

}
