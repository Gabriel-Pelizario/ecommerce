<?php

use Hcode\Model\Category;
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

//Rota para as categorias
$app->get("/categories/:idcategory", function($idcategory){

	$category = new Category();

	//carregando a categoria
	$category->get((int)$idcategory);

	$page = new page();
	$page->setTpl("category",[
		'category'=>$category->getValues(),
		'products'=>Product::checkList($category->getProducts())
	]); 

});
