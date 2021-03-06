<?
/*
	"AUTHOR":"Matheus Mayana",
	"CREATED_DATA": "10/07/2018",
	"MODEL": "Functions",
	"LAST EDIT": "10/07/2018",
	"VERSION":"0.0.1"
*/

class Model_Functions_Functions {

	public $_conexao;

	public $_consulta;

	function __construct(){

		$this->_conexao = new Model_Bancodados_Conexao;

		$this->_consulta = new Model_Bancodados_Consultas($this->_conexao);
	}

	function __destruct(){

		$this->_conexao = null;

		$this->_consulta = null;

	}

	function _token(){

		$token = $this->HASH(md5(sha1(uniqid(time()))));
		$url = URL_SITE;

		$dados = array();
		if(isset($_SESSION['token']) and !empty($_SESSION['token'])){
			unset($_SESSION['token']);
		}

		if(isset($_SESSION['url'])){
			unset($_SESSION['url']);
		}

		$_SESSION['token'] = $token;
		$_SESSION['url'] = $url;
		$dados['token'] = $token;
		$dados['url'] = $url;
		
		return $dados;
	}

	/**
	** @see Cria o hash da senha, usando MD5 e SHA-1 + Salt
	** @param string
	** @return string
	**/

   function HASH($string){

   		/**
   		** @see NUNCA !!!!
   		** @see NUNCA, JAMAIS, ALTERE O VALOR DA VARIÁVEL $salt
   		**/
   		$string = (string) $string;
		$salt = '31256578196*&%@#*(!$!+_%$(_+!%anpadfbahidpqwm,ksdpoqww[pqwṕqw[';

		return sha1(substr(md5($salt.$string), 5,25));
	}
}