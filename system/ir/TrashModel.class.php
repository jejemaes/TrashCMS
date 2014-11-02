<?php
/**
 * Maes Jerome
 * TrashModel.class.php, created at May 25, 2014
 *
 * This class extends the Active Record Model to allow the user to add, dynamically, methods and attributes
 * to defined model. This is inspired from Open Object Project (Odoo, formerly OpenERP). 
 * All new defined model must be extends like 
 * <code>
 * class Person extends TrashModel{
 *		static $attr_accessible = array( // the attributes
 *			'id', 'name', 'state', 'created_at', 'updated_at'
 *		);
 *		public function sayHello(){ // public methods defined here
 *			echo 'hello';
 *		}
 * }
 * </code>
 * The model Person will be extended like
 * <code>
 *  @TODO
 * </code>
 */


namespace system\ir;

class TrashModel extends \ActiveRecord\Model{
		
	

}


