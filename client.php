<?php

class client
{

    private $soap_instance;

    public function __construct()
    {
        $params = array(
            'location' => 'http://localhost/soap/server.php', 
            'uri' => 'http://localhost/soap/server.php', 
            //TRACE TO DISPLAY ERRORS IF THEY OCCUR
            'trace' => 1);

        $this->soap_instance = new SoapClient(null, $params);
    }


    public function getAll()
    {
        try {
            
            return $this->soap_instance->getAllProducts();

        } catch (Exception $ex) {
            exit("soap error: " . $ex->getMessage());
        }
    }


    public function getById($params)
    {
        try {

            return $this->soap_instance->getProduct($params);

        } catch (Exception $ex) {
            exit("soap error: " . $ex->getMessage());
        }
    }
}

$client = new client();