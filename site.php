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

//Rota para as categorias e paginação
$app->get("/categories/:idcategory", function($idcategory){

	$page = (isset($_GET['page'])) ? (int)$_GET['page'] :1;

	$category = new Category();

	//carregando a categoria
	$category->get((int)$idcategory);

	//Paginação
	$pagination = $category->getProductsPage($page);

	$pages = [];

	for ($i=1; $i<= $pagination['pages']; $i++) {
		array_push($pages, [
			'link'=>'/categories/'.$category->getidcategory().'?page='.$i,
			'page'=>$i
		]);
	}

	$page = new page();

	$page->setTpl("category",[
		'category'=>$category->getValues(),
		'products'=>$pagination["data"],
		'pages'=>$pages
	]); 

});
