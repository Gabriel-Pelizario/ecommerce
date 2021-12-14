<?php 

//faz parte do composer para traser as dependencias 
require_once("vendor/autoload.php");

//são namespaces do vendor
use \Slim\Slim;
use \Hcode\Page;
use Hcode\PageAdmin;

$app = new Slim();

$app->config('debug', true);

//rota para a pagina da web (usuário)
//o que está acima é sempre o que vamos precisar para criar nossas paginas
$app->get('/', function() {
    
    //neste momento vai chamar o construct e vai chamar o header na sua tela
	$page = new page();

	$page->setTpl("index"); 

});

//rota para a pagina de admin
//o que está acima é sempre o que vamos precisar para criar nossas paginas
$app->get('/admin', function() {
    
    //neste momento vai chamar o construct e vai chamar o header na sua tela
	$page = new PageAdmin();

	$page->setTpl("index"); 

});

$app->run();

 ?>