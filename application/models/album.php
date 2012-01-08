<?php
class Album extends Doctrine_Record {

	public function setTableDefinition() {
		$this->hasColumn('name', 'string', 65535);
		$this->hasColumn('user_id', 'integer',4, array('notnull' => false));
	}

	public function setUp() {
		$this->actAs('Timestampable');
		$this->hasMany('Picture as Pictures', array(
            'local' => 'id',
            'foreign' => 'album_id',
			'cascade' => array('delete')
        ));
		$this->hasOne('User', array(
			'local' => 'user_id',
			'foreign' => 'id'));
                
                $this->actAs('Searchable', array(
                'fields' => array('name')
                ));
        }
}
