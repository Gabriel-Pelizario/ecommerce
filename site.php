<?php

use \Hcode\Page;

//Rotas para o site (index)
//neste momento vai chamar o construct e vai chamar o header na sua tela
$app->get('/', function() {

	$page = new page();
    
	$page->setTpl("index"); 
});
