<?php

use \Hcode\Page;
use Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\model\Category;

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

//Rota para as categorias
$app->get("/categories/:idcategory", function($idcategory){

	$category = new Category();

	//carregando a categoria
	$category->get((int)$idcategory);

	$page = new page();
	$page->setTpl("category",[
		'category'=>$category->getValues(),
		'products'=>[]
	]); 

});