<?php 

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;
use \Hcode\Model\User;

class Cart extends Model{

	//constante para a sessão do carrinho
	const SESSION = "Cart";

	public static function getFromSession()
	{

		$cart = new Cart();

		//este carrinho já está na sessão?
		//Se for verdade e se tem uma sessão maior que zero, já foi inserido no banco
		if (isset($_SESSION[Cart::SESSION]) && (int)$_SESSION[Cart::SESSION]['idcart'] > 0){

			$cart->get((int)$_SESSION[Cart::SESSION]['idcart']);

		}else{

			$cart->getFromSessionID();

			if(!(int)$cart->getidcart() > 0){

				$data = [
					'dessessionid'=>session_id()
				];

				if(User::checkLogin(false) === true){
					//verificar se o usuário está logado
					$user = User::getFromSession();

					$data['iduser'] = $user->getiduser();

				}

				$cart->setData($data);

				//Salvar no banco
				$cart->save();

				$cart->setToSession();
				
			}
		}

		return $cart;

	}

	//Não é estatico pois vai fazer o uso da variavel this
	public function setToSession()
	{

		$_SESSION[Cart::SESSION] = $this->getValues();

	}


	public function getFromSessionID()
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_carts WHERE dessessionid = :dessessionid",[
			':dessessionid'=>session_id()
		]);

		if(count($results) > 0){

			$this->setData($results[0]);
		}

	}

	public function get(int $idcart)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_carts WHERE idcart = :idcart",[
			':idcart'=>$idcart
		]);

		if(count($results) > 0){

			$this->setData($results[0]);
		}

	}

	//save do carrinho
	public function save()
	{

		$sql = new Sql();

		//passando os parametros para a procedure cart
		$results = $sql->select("CALL sp_carts_save(:idcart, :dessessionid, :iduser, :deszipcode, :vlfreight, :nrdays)",
		[
			':idcart'=>$this->getidcart(),
			':dessessionid'=>$this->getdessessionid(),
			':iduser'=>$this->getiduser(),
			':deszipcode'=>$this->getdeszipcode(),
			':vlfreight'=>$this->getvlfreight(),
			':nrdays'=>$this->getnrdays(),
		]);

		$this->setData($results[0]);

	}

}




