<?php
class Comment extends Doctrine_Record {

	public function setTableDefinition() {
		$this->hasColumn('user_id', 'integer',4, array('notnull' => false));
		$this->hasColumn('picture_id', 'integer',4, array('notnull' => false));
		$this->hasColumn('comment', 'string', 65535);
	}

	public function setUp() {
		$this->actAs('Timestampable');
		$this->hasOne('Picture', array(
			'local' => 'picture_id',
			'foreign' => 'id'));
		$this->hasOne('User', array(
			'local' => 'user_id',
			'foreign' => 'id'));
	}

}
