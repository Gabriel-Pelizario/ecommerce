<?php

use Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\model\Category;
use \Hcode\Model\Product;

//Rota para acessar o template de categorias
$app->get("/admin/categories", function(){

	//verificar se o usuário está logado
	User::verifyLogin();
	
	$categories = Category::listAll();
	
	$page = new PageAdmin();
	$page->setTpl("categories", [
		'categories'=>$categories
	]);
});

//Rota para abir o tpl categorias
$app->get("/admin/categories/create", function(){

	//verificar se o usuário está logado
	User::verifyLogin();
	
	$page = new PageAdmin();
	$page->setTpl("categories-create");	
});

//Rota para cadastrar categorias
$app->post("/admin/categories/create", function(){

	//verificar se o usuário está logado
	User::verifyLogin();
	
	$category = new Category();

	$category->setData($_POST);

	$category->save();

	header('Location: /admin/categories');
	exit;

});

//Rota para excluir categorias
$app->get("/admin/categories/:idcategory/delete", function($idcategory){

	//verificar se o usuário está logado
	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->delete();

	header('Location: /admin/categories');
	exit;

});

//Rota para editar categorias (aparecer o template)
$app->get("/admin/categories/:idcategory", function($idcategory){

	//verificar se o usuário está logado
	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new PageAdmin();
	$page->setTpl("categories-update", [
		'category'=>$category->getValues()
	]);	

});

//Rota para dar update em itens categorias
$app->post("/admin/categories/:idcategory", function($idcategory){

	//verificar se o usuário está logado
	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	//Antes carrega os dados atuais
	$category->setData($_POST);

	$category->save();

	header('Location: /admin/categories');
	exit;

});


//Rota para acessar a tela de  categorias dos produtoss
$app->get("/admin/categories/:idcategory/products", function($idcategory){

	User::verifyLogin();

	$category = new Category();

	//carregando a categoria
	$category->get((int)$idcategory);

	$page = new PageAdmin();
	$page->setTpl("categories-products",[
		'category'=>$category->getValues(),
		'productsRelated'=>$category->getProducts(),
		'productsNotRelated'=>$category->getProducts(false)
	]); 

});

//Rota para adicionar produtos na lista de categorias
$app->get("/admin/categories/:idcategory/products/:idproduct/add", function($idcategory, $idproduct){

	User::verifyLogin();

	$category = new Category();

	//carregando a categoria
	$category->get((int)$idcategory);

	$product = new Product();

	$product->get((int)$idproduct);

	$category->addProduct($product);

	header("Location: /admin/categories/".$idcategory."/products");
	exit;

});

//Rota para remover produtos na lista de categorias
$app->get("/admin/categories/:idcategory/products/:idproduct/remove", function($idcategory, $idproduct){

	User::verifyLogin();

	$category = new Category();

	//carregando a categoria
	$category->get((int)$idcategory);

	$product = new Product();

	$product->get((int)$idproduct);

	$category->removeProduct($product);

	header("Location: /admin/categories/".$idcategory."/products");
	exit;

});