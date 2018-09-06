<?php 

require_once("config.php");

// carrega somente um
//$root = new Usuario();
//$root->loadbyId(1);
//echo $root;

// carrega lista
//$lista = Usuario::getList();
//echo json_encode($lista);

// carrega uma lista de usuarios buscando pelo login
//$search = Usuario::search("inhota");
//echo json_encode($search);

//carrega um usuario usando o login e a senha
//$usuario = new Usuario();
//$usuario->login("inhota", "123");
//echo $usuario;

//insert de usuario novo
//$aluno = new Usuario("professor", "456");
//$aluno->insert();
//echo $aluno;


// update
$usuario = new Usuario();

$usuario->loadById(7);

$usuario->update("Professor", "!@#");

echo $usuario;
?>