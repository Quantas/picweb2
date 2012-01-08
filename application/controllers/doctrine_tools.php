<?php
class Doctrine_Tools extends MY_Controller 
{

	function __construct() 
    {
		parent::__construct();
    }

	function create_tables() {
		echo 'Reminder: Make sure the tables do not exist already.<br />
		<form action="" method="POST">
		<input type="submit" name="action" value="Create Tables"><br /><br />';

		if ($this->input->post('action')) {
			Doctrine::createTablesFromModels();
			echo "Done!";
		}
	}
	
	function load_fixtures() {
		echo 'This will delete all existing data!<br />
		<form action="" method="POST">
		<input type="submit" name="action" value="Load Fixtures"><br /><br />';

		if ($this->input->post('action')) {

			Doctrine_Manager::connection()->execute(
				'SET FOREIGN_KEY_CHECKS = 0');

			Doctrine::loadData(APPPATH.'/fixtures');
			echo "Done!";
		}
	}
	
	function dump_fixtures() {
		echo 'This will dump all existing data.<br />
		<form action="" method="POST">
		<input type="submit" name="action" value="Dump Fixtures"><br /><br />';
		if ($this->input->post('action'))
		{
			Doctrine::dataDump(APPATH.'/models', APPATH.'/fixtures');	
			echo "Done!";
		}
	}
	
	function home_profiler() {

		// set up the profiler
		$profiler = new Doctrine_Connection_Profiler();
		foreach (Doctrine_Manager::getInstance()->getConnections() as $conn) {
			$conn->setListener($profiler);
		}

		// copied from home controller
		$vars['albums'] = Doctrine::getTable('Album')->findAll();

		$this->load->view('home', $vars);

		// analyze the profiler data
		$time = 0;
		$events = array();
		foreach ($profiler as $event) {
		    $time += $event->getElapsedSecs();
			if ($event->getName() == 'query' || $event->getName() == 'execute') {
				$event_details = array(
					"type" => $event->getName(),
					"query" => $event->getQuery(),
					"time" => sprintf("%f", $event->getElapsedSecs())
				);
				if (count($event->getParams())) {
					$event_details["params"] = $event->getParams();
				}
				$events []= $event_details;
			}
		}
		print_r($events);
		echo "\nTotal Doctrine time: " . $time  . "\n";
		echo "Peak Memory: " . memory_get_peak_usage() . "\n";
	}

}