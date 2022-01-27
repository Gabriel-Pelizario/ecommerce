<?php 

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;
use \Hcode\Mailer;

class Category extends Model {

	//função para listar os os grupos de categorias
	public static function listAll()
	{
		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_categories ORDER BY descategory");

	}

	public function save()
	{

		$sql = new Sql();

		$results = $sql->select("CALL sp_categories_save(:idcategory, :descategory)", array(
			":idcategory"=>utf8_decode($this->getidcategory()),
			":descategory"=>$this->getdescategory()
		));

		$this->setData($results[0]);

		Category::updateFile();
	}

	public function get($idcategory)
	{

		$sql = new Sql();
		$results = $sql->select("SELECT * FROM tb_categories WHERE idcategory = :idcategory", [
			':idcategory'=>$idcategory
		]);

		$this->setData($results[0]);
	}

	public function delete()
	{

		$sql = new Sql();

		$sql->query("DELETE FROM tb_categories WHERE idcategory = :idcategory", [
			':idcategory'=>$this->getidcategory()
		]);

		Category::updateFile();

	}

	//atualizar a lsita de categorias
	public static function updateFile()
	{

		$categories = Category::listAll();

		$html = [];

		foreach ($categories as $row) {
			array_push($html, '<li><a href="/categories/'.$row['idcategory'].'">'.$row['descategory'].'</a></li>');
		}

		//salvar o arquivo
		//implode (converter o array para string $html)
		file_put_contents($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "categories-menu.html", implode('', $html));

	}

	public function getProducts($related = true)
	{

		$sql = new Sql();

		//produtos que estão relacinados
		if($related === true){

			return $sql->select("
			select * from tb_products where idproduct in(
				select a.idproduct
				from tb_products a
				inner join tb_productscategories b on a.idproduct = b.idproduct
				where b.idcategory = :idcategory
			);
			", [
				':idcategory'=>$this->getidcategory()
			]);


		} else{

			//Produtos não relacionados
			return $sql->select("
			select * from tb_products where idproduct not in(
				select a.idproduct
				from tb_products a
				inner join tb_productscategories b on a.idproduct = b.idproduct
			where b.idcategory = :idcategory
			);
			", [
				':idcategory'=>$this->getidcategory()
			]);
		}
	}

	//Configuração da paginação do front
	public function getProductsPage($page = 1, $itemsParPage = 8)
	{

		//Qual é a regra?
		//Se eu estiver na pagina 1, 1-1 = 0, 0*3 = 0 (Primeira página começa no 0)
		//Se eu estiver na pagina 2, 2-1 = 1, 1*3 = 3 (Pulou o 0,1,2 e começa no registro 3 e me traga 3)
		$start = ($page-1)*$itemsParPage;

		$sql = new Sql();

		$results = $sql->select("
		SELECT sql_calc_found_rows *
			FROM tb_products a 
			INNER JOIN tb_productscategories b ON a.idproduct = b.idproduct
			INNER JOIN tb_categories c ON c.idcategory = b.idcategory
			WHERE c.idcategory = :idcategory
			LIMIT $start, $itemsParPage;
		", [
			':idcategory'=>$this->getidcategory()
		]);

		//Segunda consulta
		$resultTotal = $sql->select("SELECT found_rows() as nrtotal;");

		return [
			'data'=>Product::checkList($results),
			'total'=> (int)$resultTotal[0]["nrtotal"],
			'pages'=>ceil($resultTotal[0]["nrtotal"] / $itemsParPage)
		];

		
		
	}

	//Método para adicionar produtos na categoria
	public function addProduct(Product $product)
	{

		$sql = new Sql();

		$sql->query("INSERT INTO tb_productscategories (idcategory, idproduct) VALUES(:idcategory, :idproduct)",[
			':idcategory'=>$this->getidcategory(),
			':idproduct'=>$product->getidproduct()
		]);
	}

	//Método para remover produtos na categoria
	public function removeProduct(Product $product)
	{

		$sql = new Sql();

		$sql->query("DELETE FROM tb_productscategories WHERE idcategory = :idcategory AND idproduct = :idproduct",[
			':idcategory'=>$this->getidcategory(),
			':idproduct'=>$product->getidproduct()
		]);
	}

}
