<?php
class Picture extends Doctrine_Record {

	public function setTableDefinition() {
		$this->hasColumn('album_id','integer',4, array('notnull' => false));
		$this->hasColumn('album_pos','integer',4);
		$this->hasColumn('name','string',255);
		$this->hasColumn('type','string',255);
		$this->hasColumn('width', 'integer', 12);
		$this->hasColumn('height', 'integer', 12);
		$this->hasColumn('size', 'integer', 12);
                $this->hasColumn('nsfw','integer',4);
                $this->hasColumn('flagged','integer',4);
                $this->hasColumn('views', 'integer', 4, array('default' => 0));
		$this->hasColumn('image','blob');
		$this->hasColumn('thumb','blob');
	}

	public function setUp() {
		$this->actAs('Timestampable');
		$this->hasOne('Album', array(
			'local' => 'album_id',
			'foreign' => 'id'));
                $this->hasOne('Exif', array(
			'local' => 'id',
			'foreign' => 'picture_id',
                        'cascade' => array('delete')));
		$this->hasMany('Comment as Comments', array(
            'local' => 'id',
            'foreign' => 'picture_id',
			'cascade' => array('delete')
        ));
		$this->actAs('Searchable', array(
                'fields' => array('name')
            )
        );
	}
}
