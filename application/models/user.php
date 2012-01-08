<?php
class User extends Doctrine_Record {

	public function setTableDefinition() {
		$this->hasColumn('username', 'string', 255, array('unique' => 'true'));
		$this->hasColumn('password', 'string', 255);
		$this->hasColumn('email', 'string', 255, array('unique' => 'true'));
		$this->hasColumn('first_name', 'string', 255);
		$this->hasColumn('last_name', 'string', 255);
                $this->hasColumn('birthdate', 'string', 255);
                $this->hasColumn('show_nsfw', 'integer', 4, array('default' => 0));
		$this->hasColumn('privs', 'integer', 4, array('default' => 0));
                $this->hasColumn('quota', 'integer', 4, array('default' => 104857600));
                $this->hasColumn('picture', 'blob');
	}

	public function setUp() {
		$this->setTableName('user');
		$this->actAs('Timestampable');
		$this->hasMutator('password', '_encrypt_password');
		
		$this->hasMany('Album as Albums', array(
            'local' => 'id',
            'foreign' => 'user_id',
			'cascade' => array('delete')
        ));
		$this->hasMany('Comment as Comments', array(
            'local' => 'id',
            'foreign' => 'user_id',
			'cascade' => array('delete')
        ));
                $this->hasMany('News as Stories', array(
            'local' => 'id',
            'foreign' => 'user_id',
			'cascade' => array('delete')
        ));
                $this->actAs('Searchable', array(
                'fields' => array('username','first_name','last_name')
        ));
        }
	
	protected function _encrypt_password($value) {
        $salt = '#*QuAnT!@-*NeT%';
        $this->_set('password', md5($salt . $value));
    }

}
