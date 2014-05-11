<?php
App::uses('Title', 'Model');

/**
 * Title Test Case
 *
 */
class TitleTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.title',
		'app.ehon',
		'app.user',
		'app.page',
		'app.lang',
		'app.translation'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->Title = ClassRegistry::init('Title');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->Title);

		parent::tearDown();
	}

}
