<?
/*
{
	"AUTHOR":"Matheus Maydana",
	"CREATED_DATA": "10/07/2018",
	"MODEL": "Layout",
	"LAST EDIT": "10/07/2018",
	"VERSION":"0.0.1"
}
*/


/**
**
** @see o Layout precisa ser formato .HTML ou confirgurar no arquivo Setting.php 
**
**/

class Model_Layout {

	public $_url;

	public $_conexao;

	public $_consulta;

	function __construct($conexao, $st_view = null, $v_params = null){

		$this->_conexao = $conexao;

		$this->_consulta = new Model_Bancodados_Consultas($conexao);

		$this->_url 	= new Model_Pluggs_Url;

		if($st_view !== null){

			$this->setView($st_view);
			$this->v_params = $v_params;
		}
	}

	public function setView($st_view){

		try{

			if(file_exists(DIR.'Layout/'.$st_view.EXTENSAO_VISAO)){

				$this->st_view = $st_view;
			}


		}catch(PDOException $e){

			/**
			** ERRO, LAYOUT NÃO ENCONTRADO
			**/
			new de('layout não encontrado');
		}
	}

	public function getView(){
		return $this->st_view;
	}

	public function setParams(Array $v_params){
		$this->v_params = $v_params; 
	}

	public function getParams(){
		return $this->v_params;
	}

	public function Layout(){

		try{

			if(isset($this->st_view)){

				$layout = $this->st_view;

				$cliente = '';
				if(isset($_SESSION[CLIENTE]['login'])){

					/* ESSA VARIAVEL VAI JOGAR NO LAYOUT O NOME DO CLIENTE - PAGINA QUEM SOMOS */
					$cliente = $this->_consulta->getInfoCliente('nome', $_SESSION[CLIENTE]['login']);
				}

				/* COLOCAR CACHE NOS ARQUIVOS STATICOS QUANDO NÃO ESTÁ EM PRODUÇÃO */
				$cache = '';
				$random = mt_rand(10000, 99999);

				if(PRODUCAO !== true){
					$cache = '?cache='.$random;
				}

				$login = $_SESSION[CLIENTE]['login'] ?? '';

				$mustache = array(
					'{{static}}' 		=> URL_STATIC,
					'{{header}}' 		=> $this->_headerHTML(),
					'{{cache}}' 		=> $cache,
				);

				$layout = str_replace(array_keys($mustache), array_values($mustache), file_get_contents(DIR.'Layout/'.$layout.EXTENSAO_VISAO));
				return $layout;
				
			}

		}catch(PDOException $e){

			new de('nada de layout');
			/**
			** ERRO, ARQUIVO LAYOUT NÃO ENCONTRADO
			**/
		} 
	}

	public function showContents(){
		echo $this->getContents();
		exit;
	}

	private function _headerHTML(){

		$url = $this->_url->url();
		
		$noscript = '<noscript><meta  http-equiv="refresh"  content="1; URL=/noscript"  /></noscript>';
		if(isset($url[1]) and $url[1] == 'noscript'){

			$noscript = '';
		}

		$cliente = '';
		if(isset($_SESSION[CLIENTE]['login'])){

			$cliente = $this->_consulta->getInfoCliente('nome', $_SESSION[CLIENTE]['login']);
			$cliente = '- '.$cliente;
		}

		$header = <<<php
<title>LojaOnline</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<meta name="viewport" content="width=device-width, height=device-height, user-scalable=yes, initial-scale=1" />
<meta name="msapplication-tap-highlight" content="no" />
<meta name="format-detection" content="telephone=no" />
<meta name="description" content="">
<meta  name="robots"  content="index, follow"  />
{$noscript}
<meta name="author" content="Matheus Maydana" />
<link rel="shortcut icon" href="/img/site/caveira.png" type="image/x-icon">
<link rel="icon" href="/img/site/caveira.png" type="image/x-icon">
<script src="/js/jQuery.min.js{{cache}}"></script>
<link rel="stylesheet" href="{{static}}css/site.min.css{{cache}}">
php;

		return $header;
	}
}