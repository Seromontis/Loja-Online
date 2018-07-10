<?
/*
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "10/07/2018",
	"MODEL": "Render HTML",
	"LAST EDIT": "10/07/2018",
	"VERSION":"0.0.1"
*/

class Model_Functions_Render{

	public $_util;

	function __construct(){

		$this->_util = new Model_Pluggs_Utilit;
	}

	function __destruct(){

		$this->_util = null;
	}
}