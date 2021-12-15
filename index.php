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

//rota para a pagina da web (usuário)
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

//iniciar os templates
$app->run();

 ?>