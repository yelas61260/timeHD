<?php
class Webservice extends CI_Controller {

    function  __construct() {
        parent::__construct();
    }

    public function index() {
        $server = new SoapServer("test.wsdl");
        $server->setObject($this);
        //$server->addFunction('sayHello');
        $server->handle();
    }

    function sayHello($name) {
        $salute = "Hi " . $name . ", it's working!";
        return $salute;
    }

}