<?php
		if($this->session->flashdata('message_exists')) 
		{
			echo '<div id="PM_'.$this->session->flashdata('type').'"><ul><li>'.$this->session->flashdata('message').'</li></ul></div>';
		}
?>