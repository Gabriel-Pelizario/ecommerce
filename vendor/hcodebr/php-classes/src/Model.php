<?php   

namespace Hcode;

class model{

    private $values  = [];

    public function __call($name, $arguments)
    {
        
        $method = substr($name, 0, 3);
        $fieldname = substr($name, 3, strlen($name));

        switch ($method) {
            case 'get':
                return $this->values[$fieldname];
                break;
            
            case 'set':
                $this->values[$fieldname] = $arguments[0];
                break;
        }
    }

    public function setData($data = array())
    {

        foreach ($data as $key => $value) {
            //Tudo que for criar dinamico precisa colocar entre as chaves
            $this->{"set".$key}($value);
        }

    }

    //dá o retorno do atributo
    public function getValues()
    {
        return $this->values;
    }

}
