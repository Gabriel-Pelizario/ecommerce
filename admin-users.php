<?php

use Hcode\PageAdmin;
use \Hcode\Model\User;

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
