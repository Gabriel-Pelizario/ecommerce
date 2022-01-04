<?php 

//iniciar o uso da sessão
session_start();

//faz parte do composer para traser as dependencias 
require_once("vendor/autoload.php");

//são namespaces do vendor
use \Slim\Slim;
use \Hcode\Page;
use Hcode\PageAdmin;
use \Hcode\Model\User;

//chamando o Slim
$app = new Slim();

$app->config('debug', true);
//o que está acima são padrões que sempre é utilizado em projetos

//rota para a pagina de usuários
//neste momento vai chamar o construct e vai chamar o header na sua tela
$app->get('/', function() {
	$page = new page();
	$page->setTpl("index"); 
});

//rota para a pagina de admin
//neste momento vai chamar o construct e vai chamar o header na sua tela
//chamar a tela de administrador
$app->get('/admin', function() {
	User::verifyLogin();
	$page = new PageAdmin();
	$page->setTpl("index"); 
});

//rota para a pagina de login
//vai chamar a tela de login
$app->get('/admin/login', function(){
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	//chamando o template
	$page->setTpl("login");
});

//rota post para validar o login administrador
$app->post('/admin/login', function(){
	User::login($_POST["login"], $_POST["password"]);

	//se login e senha estiverem correto vai redirecionar par a homepage admministrador
	header("Location: /admin");
	exit;
});

//Rota para fazer o logout
$app->get('/admin/logout', function(){
	User::logout();
	header("Location: /admin/login");
	exit;
});

//Rota para tela users
$app->get('/admin/users', function(){

	//Método para verficar se o usuário está logado no sistema
	User::verifyLogin();
	$users = User::listAll();
	$page = new PageAdmin();
	$page->setTpl("users", array(
		"users"=>$users
	));
});

//Rota para chamar a tela de cadastrar usuário
$app->get('/admin/users/create', function(){
	//Método para verficar se o usuário está logado no sistema
	User::verifyLogin();
	$page = new PageAdmin();
	$page->setTpl("users-create");
});

//rota para tela de deletar usuários
$app->get("/admin/users/:iduser/delete", function($iduser){
	User::verifyLogin();
	$user = new User();
	$user->get((int)$iduser);
	$user->delete();
	header("Location: /admin/users");
	exit;
});

//Rota para chamar a tela de editar usuários
$app->get('/admin/users/:iduser', function($iduser){
	User::verifyLogin();
	$user = new User();
	$user->get((int)$iduser);
	$page = new PageAdmin();
	$page ->setTpl("users-update", array(
		 "user"=>$user->getValues()
	));
 });

//rota para salvar o novo usuário
$app->post("/admin/users/create", function(){
	User::verifyLogin();
	$user = new User();
	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;
	$user->setData($_POST);
	//chamando o save do arquivo user.php
	$user->save();
	//voltando para a tabela
	header("Location: /admin/users");
	exit;
});

//rota para salvar a edição
$app->post("/admin/users/:iduser", function($iduser){
	User::verifyLogin();
	//Programar a parte de salvar a edição
	$user = new User();
	//fazer a validação do inadmin pra saber se é 1 ou se é 0
	$_POST["inadmin"] = (isset($_POST["inadmin"]))?1:0;
	//pegar os dados e jogar nos campos da tabela
	$user->get((int)$iduser);
	$user->setData($_POST);
	$user->update();
	header("Location: /admin/users");
	exit;
});

//Rota do forgot (tela onde o admin irá digitar o e-mail para recovery da senha)
$app->get("/admin/forgot", function(){
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	//chamando o template
	$page->setTpl("forgot");
});

//Rota para chamar a tela de alterar a senha
$app->post("/admin/forgot", function(){

$user = User::getForgot($_POST["email"]);
header("Location: /admin/forgot/sent");
exit;

});

$app->get("/admin/forgot/sent", function(){

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("forgot-sent");
});

//Rota para redifinição de senha
$app->get("/admin/forgot/reset", function(){

	//verificação do secret code
	$user = User::validForgotDecrypt($_GET["code"]);

	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("forgot-reset", array(

		"name"=>$user["desperson"],
		"code"=>$_GET["code"]
	));
});

//Rota para enviar a nova senha
$app->post("/admin/forgot/reset", function(){

	$forgot = User::validForgotDecrypt($_POST["code"]);
	//método para dar o update no banco, avisar o banco que esta recuperação já foi efetuado ou seja não é possivel
	//recuperar a senha com o mesmo link
	User::setForgotUsed($forgot["idrecovery"]);

	$user = new User();
	//dados do usuário
	$user->get((int)$forgot["iduser"]);

	//criptografia da senha
	$password = password_hash($_POST["password"], PASSWORD_DEFAULT, [
		//numero de processamentos, quanto maior mais seguro, porém é ideal
		"cost"=>12
	]);

	$user->setPassword($password);

	//rota para o template que a senha foi alterada com sucesso
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$page->setTpl("forgot-reset-success");

});

//iniciar os templates
$app->run();

