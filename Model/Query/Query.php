<?
/*
{
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "10/07/2018",
	"MODEL": "Queryes SQL",
	"LAST EDIT": "10/07/2018",
	"VERSION":"0.0.1"
}
*/
class Model_Query_Query extends Model_Query_Conexao{


	public $conexao;

	function __construct(){

		$this->conexao = $this->conexao();
	}

	function __destruct(){

		$this->conexao = null;
	}
}