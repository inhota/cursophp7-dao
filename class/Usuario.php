<?php 

class Usuario
{
	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

	public function getIdusuario()
	{
		return $this->idusuario;
	}

	public function setIdusuario($value)
	{
		$this->idusuario = $value;
	}
//-----------------------------------------------------//
	public function getDeslogin()
	{
		return $this->deslogin;
	}

	public function setDeslogin($value)
	{
		$this->deslogin = $value;
	}

//-----------------------------------------------------//

	public function getDessenha()
	{
		return $this->dessenha;
	}

	public function setDessenha($value)
	{
		$this->dessenha = $value;
	}
//-----------------------------------------------------//

	public function getDtcadastro()
	{
		return $this->dtcadastro;
	}

	public function setDtcadastro($value)
	{
		$this->dtcadastro = $value;
	}


// metodo trazer informações do bd set = alimentar
	public function loadById($id)
	{
		$sql = new Sql();
		$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario = :ID", array(
			":ID"=>$id
		));


	if (count($results)> 0)
	 	{
		
		$this->setData($results[0]);
		
		}
	}

//lista com todos os usuarios no bd

public static function getList()
{
	$sql = new Sql();

	return $sql->select("select * from tb_usuarios order by deslogin;");
}

//Lista de usurios buscando por parametro defiinido no login ex tudo que tiver inhota
public static function search($login)
{
	$sql = new Sql();

	return $sql->select("SELECT * from tb_usuarios where deslogin like :SEARCH order by deslogin", array(
		':SEARCH'=>"%".$login."%"

	));
}

//obter os dados do usuario fazendo verificação autenticação
public function login($login, $password)
{

	$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin = :LOGIN and dessenha = :PASSWORD", array(
			":LOGIN"=>$login,
			":PASSWORD"=>$password
		));


	if (count($results)> 0)
	 	{
		
		$this->setData($results[0]);

		}
		else
		{
			throw new Exception("login e/ou senha invalidos.");
			
		}

}

public function setData($data)
{
	$this->setIdusuario($data["idusuario"]);
	$this->setDeslogin($data["deslogin"]);
	$this->setDessenha($data["dessenha"]);
	$this->setDtcadastro(new DateTime($data["dtcadastro"]));
	}
// Metodo insert
public function insert()
{
	$sql = new Sql();

	$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(

		':LOGIN'=>$this->getDeslogin(),
		':PASSWORD'=>$this->getDessenha()

	));

	if (count($results)> 0) 
	{
		$this->setData($results[0]);
	}
}


//metodo update
public function update($login, $password)
{
	$this->setDeslogin($login);
	$this->setDessenha($password);

	$sql = new Sql();

	$sql->query("UPDATE tb_usuarios set deslogin = :LOGIN, dessenha = :PASSWORD where idusuario = :ID", array(

		':LOGIN'=>$this->getDeslogin(),
		':PASSWORD'=>$this->getDessenha(),
		':ID'=>$this->getIdusuario()

	));
}

// delete
public function delete()
{
	$sql = new Sql();

	$sql-> query("DELETE from tb_usuarios where idusuario = :ID", array(
		':ID'=>$this->getIdusuario()

	));

	$this->setIdusuario(0);
	$this->setDeslogin("");
	$this->setDessenha("");
	$this->setDtcadastro(new DateTime());
}


// metodo construtor
public function __construct($login = "", $password = "")
{
	$this->setDeslogin($login);
	$this->setDessenha($password);
}


//Metodo para exibir informações json get= mostrar
	public function __toString()
	{
		return json_encode(array(
			"idusuario"=>$this->getIdusuario(),
			"deslogin"=>$this->getDeslogin(),
			"dessenha"=>$this->getDessenha(),
			"dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
			));
	}
}
	 ?>