<?php

//namespace da classe
namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;

//criando a classe par o user administrador
class User extends Model{

    //Costante da sessão
    const SESSION = "User";

    public static function login($login, $password)
    {

        //buscar no bando de dados se o login digitado está correto
        $sql = new Sql();

        $results = $sql->select("SELECT * FROM tb_users WHERE deslogin = :LOGIN", array(
            ":LOGIN"=>$login
        ));

        //verificando se encontrou alguma coisa
        if(count($results) === 0)
        {
            throw new \Exception("Usuário inexistente ou senha inválida.");
        }

        $data = $results[0];

        //verificar a senha do usuário
        //função retorna true ou false da senha do banco
        if(password_verify($password, $data["despassword"]) === true)
        {
            $user = new User();

            $user->setData($data);

            //criando neste momento a sessão
            $_SESSION[User::SESSION] = $user->getValues();

            return $user;

        } else{
            throw new \Exception("Usuário inexistente ou senha inválida.");
        }

    }

    public static function verifyLogin($inadmin= true)
    {
        //verificando se a sessão não for definida
        if (
            !isset($_SESSION[User::SESSION])
            ||
            !$_SESSION[User::SESSION]
            ||
            !(int)$_SESSION[User::SESSION]["iduser"] > 0 
            ||
            (bool)$_SESSION[User::SESSION]["inadmin"] !=$inadmin
        ) {
            //redirecionar novamente para a tela de login
            header("LOCATION: /admin/login");
            exit;
        }

    }

    public static function logout()
    {

        //destruir a sessão
        $_SESSION[User::SESSION] = null;

    }

}