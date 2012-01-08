<?php
class News extends Doctrine_Record {

	public function setTableDefinition() {
                $this->hasColumn('title', 'string', 65535);
		$this->hasColumn('story', 'string', 65535);
		$this->hasColumn('user_id', 'integer',4, array('notnull' => false));
	}

	public function setUp() {
		$this->actAs('Timestampable');
                
                $this->hasOne('User', array(
			'local' => 'user_id',
			'foreign' => 'id',
			'onDelete' => 'CASCADE'));
        }
}