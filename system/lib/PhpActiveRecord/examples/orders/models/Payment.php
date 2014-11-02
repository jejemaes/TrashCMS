<?php

namespace test;

use \System\Models;


class Payment extends \System\Models\TrashModel
{

	// payment belongs to a person
	static $belongs_to = array(
		array('person'),
		array('order'));
}
?>
