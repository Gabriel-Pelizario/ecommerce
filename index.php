<?php 

//iniciar o uso da sessão
session_start();

//faz parte do composer para traser as dependencias 
require_once("vendor/autoload.php");

//são namespaces do vendor
use \Slim\Slim;

//chamando o Slim
$app = new Slim();

$app->config('debug', true);
//o que está acima são padrões que sempre é utilizado em projetos

//chamando as rotas
require_once("functions.php");
require_once("site.php");
require_once("admin.php");
require_once("admin-users.php");
require_once("admin-categories.php");
require_once("admin-products.php");

//iniciar os templates
$app->run();

