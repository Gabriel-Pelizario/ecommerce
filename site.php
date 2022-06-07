<?php

use Hcode\Model\Cart;
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

//Rota para a pagina de detalhes do produto
$app->get("/products/:desurl", function($desurl){

	$product = new Product();

	$product->getFromURL($desurl);

	$page = new Page();

	$page->setTpl("product-detail", [
		'product'=>$product->getValues(),
		'categories'=>$product->getCategories()
	]);

});

$app->get("/cart", function(){

	$cart = Cart::getFromSession();

	$page = new Page();

	$page->setTpl("cart", [
		'cart'=>$cart->getValues(),
		'products'=>$cart->getProducts(),
		'error'=>Cart::getMsgError()
	]);
});

//rota para adicionar o produto no carrinho
$app->get("/cart/:idproduct/add", function($idproduct){

	$product = new Product();

	$product->get((int)$idproduct);

	//recuperar o carrinho da sessão
	$cart = Cart::getFromSession();

	$qtd = (isset($_GET['qtd'])) ? (int)$_GET['qtd'] : 1;

	for ($i=0; $i < $qtd; $i++) { 
		$cart->addProduct($product);
	}

	header("Location: /cart");
	exit;

});

//rota para adicionar remover um produto do carrinho
$app->get("/cart/:idproduct/minus", function($idproduct){

	$product = new Product();

	$product->get((int)$idproduct);

	//recuperar o carrinho da sessão
	$cart = Cart::getFromSession();

	$cart->removeProduct($product);

	header("Location: /cart");
	exit;

});

//rota para adicionar remover todos os produto do carrinho
$app->get("/cart/:idproduct/remove", function($idproduct){

	$product = new Product();

	$product->get((int)$idproduct);

	//recuperar o carrinho da sessão
	$cart = Cart::getFromSession();

	$cart->removeProduct($product, true);

	header("Location: /cart");
	exit;

});

//Rota para chamar o envio do formulário com o cep para calcular
$app->post("/cart/freight", function(){

	$cart = Cart::getFromSession();

	$cart->setFreight($_POST['zipcode']);

	header("Location: /cart");
	exit;

});