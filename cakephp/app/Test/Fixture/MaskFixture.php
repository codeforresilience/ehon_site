<?php
/**
 * MaskFixture
 *
 */
class MaskFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 10, 'key' => 'primary'),
		'pages_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => null),
		'x' => array('type' => 'integer', 'null' => true, 'default' => null),
		'y' => array('type' => 'integer', 'null' => true, 'default' => null),
		'width' => array('type' => 'integer', 'null' => true, 'default' => null),
		'height' => array('type' => 'integer', 'null' => true, 'default' => null),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => null),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'pages_id' => 1,
			'user_id' => 1,
			'x' => 1,
			'y' => 1,
			'width' => 1,
			'height' => 1,
			'created' => '2014-04-26 08:50:57',
			'modified' => '2014-04-26 08:50:57'
		),
	);

}
