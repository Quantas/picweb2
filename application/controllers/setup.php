<?php
class Setup extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	function index()
	{

		$vars['dbData'] = $this->getDbData();

		$vars['title'] = 'Setup';
		$this->load->view('setup', $vars);
	}

	function getDbData()
	{
		$this->load->database();

		return array("database"=> $this->db->database,
						"username"=> $this->db->username,
						"hostname"=> $this->db->hostname,
						"password"=> $this->db->password,
						"dbdriver"=> $this->db->dbdriver);
	}

	function do_setup_tasks()
	{
		if ($this->input->post('do_setup_tasks'))
		{
			//drop tables
			$this->load->database();
			/* fill in your database name */
			$database_name = $this->db->database;

			/* connect to MySQL */
			if (!$link = mysql_connect($this->db->hostname, $this->db->username, $this->db->password)) {
				die("Could not connect: " . mysql_error());
			}

			/* query all tables */
			$sql = "SHOW TABLES FROM $database_name where tables_in_$database_name not in ('ci_sessions')";
			if($result = mysql_query($sql)){
				/* add table name to array */
				while($row = mysql_fetch_row($result)){
					$found_tables[]=$row[0];
				}
			}
			else{
				die("Error, could not list tables. MySQL Error: " . mysql_error());
			}

			/* loop through and drop each table */
			if(isset($found_tables))
			{
				foreach($found_tables as $table_name){
			  $sql = "DROP TABLE $database_name.$table_name";
			  if($result = mysql_query($sql)){
			  	$vars['mysqlDrop'] = "Success - table $table_name deleted.";
			  }
			  else{
			  	$vars['mysqlDrop'] = "Error deleting $table_name. MySQL Error: " . mysql_error() . "";
			  }
				}
			}
			mysql_close($link);
				
			mysql_free_result($result);
				
			//create Tables
			Doctrine::createTablesFromModels();
			$vars['mysqlCreate'] = "Created Tables";
				
			//load fixtures
			Doctrine_Manager::connection()->execute(
				'SET FOREIGN_KEY_CHECKS = 0');
			Doctrine::loadData(APPPATH.'/fixtures');
			$vars['mysqlLoad'] = "Created Tables";
				
				
			$vars['setup'] = "true";
				
			$vars['dbData'] = $this->getDbData();

			$vars['title'] = 'Setup';
			$this->load->view('setup', $vars);
		}
	}
}
?>