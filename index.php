<?php 

//faz parte do composer para traser as dependencias 
require_once("vendor/autoload.php");

//são namespaces do vendor
use \Slim\Slim;
use \Hcode\Page;

$app = new Slim();

$app->config('debug', true);

//o que está acima é sempre o que vamos precisar para criar nossas paginas
$app->get('/', function() {
    
    //neste momento vai chamar o construct e vai chamar o header na sua tela
	$page = new page();

	$page->setTpl("index"); 

});

$app->run();

 ?>