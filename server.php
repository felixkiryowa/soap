<?php

define("DB_HOST", "localhost");
define("DB_NAME", "soap");
define("DB_USER", "root");
define("DB_PASSWORD", "password12");
define("TABLE", "products");


class server
{

    private $db_handle;

    public function __construct()
    {
        $this->connect();
    }

    private function connect()
    {
        try {

            $this->db_handle = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        } catch (Exception $ex) {
            exit($ex->getMessage());
        }
    }

    public function getAllProducts()
    {
        $query = mysqli_query($this->db_handle, "SELECT * FROM " . TABLE);

        $products = [
            'HEY' => 'Am testibg this out',
        ];

        
        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {

            array_push($products, new Product($row['id'], $row['title'], $row['description'], $row['price']));
        }

        return $products;
    }


    public function getProduct($params)
    {
        $query = mysqli_query($this->db_handle, "SELECT * FROM " . TABLE . " WHERE id='{$params['id']}'");

        $row = mysqli_fetch_row($query);

        if($row) {
            return new Product($row[0], $row[1], $row[2], $row[3]);
        }

        return "no such product";
    }
}


class Product 
{
    public $id, $title, $description, $price;

    public function __construct($id, $title, $description, $price) 
    {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
    }
}

//INITIALIZE SOAP SERVER  CLASS
$params = array('uri' => 'http://localhost/soap/server.php');

$soapServer = new SoapServer(null, $params);
//MAP ALL THE FUNCTIONS IN THE CLASS INTO AN XML DOCUMENT
$soapServer->setClass('server');
//TURN ON THE SOAP SERVER
$soapServer->handle();