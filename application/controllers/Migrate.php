<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller {

	public function index()
	{
		$this->load->library('migration');

		$migration_version = $this->migration->current();

		if ($migration_version === FALSE)
		{
			show_error($this->migration->error_string());
		}
		else
		{
			echo "Migration success";
			echo "<br>";
			echo "Current version: " . $migration_version;
		}
	}
}
