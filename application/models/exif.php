<?php
class Exif extends Doctrine_Record {
    	public function setTableDefinition() {
		$this->hasColumn('picture_id','integer',4, array('notnull' => false));
		$this->hasColumn('make','string',255);
		$this->hasColumn('model','string',255);
                $this->hasColumn('Exposure','string',255);
		$this->hasColumn('FNumber', 'string', 25);
		$this->hasColumn('ISOSpeed', 'string', 255);
                $this->hasColumn('flash', 'string', 255);
		$this->hasColumn('dateTaken', 'string', 255);
		$this->hasColumn('gpsLat','string', 255);
		$this->hasColumn('gpsLon','string', 255);
	}

	public function setUp() {
		$this->actAs('Timestampable');
		$this->hasOne('Picture', array(
			'local' => 'picture_id',
			'foreign' => 'id'));
	}
}
?>
