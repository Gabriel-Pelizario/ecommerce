<?php

use Hcode\Model\Product;
use \Hcode\Page;

//Rotas para o site (index)
//neste momento vai chamar o construct e vai chamar o header na sua tela
$app->get('/', function() {

	//listar todos os produtos do banco
	$products = Product::listAll();

	$page = new page();
    
	$page->setTpl("index", [
		'products'=>Product::checkList($products)
	]); 
});
