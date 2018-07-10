<?
/*
{
	"AUTHOR":"Matheus Mayana",
	"CREATED_DATA": "10/06/2018",
	"MODEL": "Consultas",
	"LAST EDIT": "10/07/2018",
	"VERSION":"0.0.1"
}
*/
class Model_Bancodados_Consultas {

	public $_conexao;

	public $_util;

	public $_hoje = HOJE;

	public $_agora = AGORA;

	public $_ip = IP;

	function __construct($conexao){

		$this->_conexao = $conexao->conexao();

		$this->_util = new Model_Pluggs_Utilit;
	}

	function __destruct(){

		$this->_conexao = null;

		$this->_util = null;

	}

	function logout($id_conta){

		$return = 1;
		if(!empty($id_conta) and is_numeric($id_conta)){
			
			$this->_timesnow($id_conta);
			unset($_SESSION[CLIENTE]);
			$return = 2;
		}

		return $return;
	}

	function _timesnow($id_conta, $login = null){

		/**
		** @param (INT)
		** @param (boolean)
		** @see ESTA FUNÇÃO ATUALIZA OS DADOS NO BANCO, DATA, HORA E IP (last login)
		** @see SE $login vier !== null, usuario está logando
		**/

		$id_conta = $this->_util->basico($id_conta);

		/* USUARIO SAINDO (LOGOUT) - MUDA STATUS */
		$status = 2;
		if($login !== null){

			/* USUARIO LOGANDO (LOGIN) - MUDA STATUS */
			$status = 3;
		}

		$sql = $this->_conexao->prepare('
			UPDATE conta SET 
				status = :status, 
				hora_ultimo_login = :hora_ultimo_login, 
				data_ultimo_login = :data_ultimo_login, 
				ip_ultimo_login	= :ip_ultimo_login 
			WHERE id_conta = :id_conta
		');
		$sql->bindParam(':status', $status, PDO::PARAM_INT);
		$sql->bindParam(':hora_ultimo_login', $this->_agora, PDO::PARAM_STR);
		$sql->bindParam(':data_ultimo_login', $this->_hoje, PDO::PARAM_STR);
		$sql->bindParam(':ip_ultimo_login', $this->_ip, PDO::PARAM_STR);
		$sql->bindParam(':id_conta', $id_conta, PDO::PARAM_INT);
		$sql->execute();

		$sql = null;
		$PDO = null;

		if(!isset($_SESSION[CLIENTE]['login']) || empty($_SESSION[CLIENTE]['login'])){

			$_SESSION[CLIENTE]['login'] = $id_conta;
		}
	}
}