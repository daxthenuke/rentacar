<?php
ini_set('display_errors', 1);
include_once 'app/Model/CarsModel.php';
include_once 'app/Model/UserModel.php';
include_once 'connection/Connection.php';
include_once 'app/renderView.php';
include_once 'functions/Functions.php';

// Instance models
$CarsModel=new CarsModel(new Connection());
$UserModel=new UserModel(new Connection());

/* Routing by GET method */
if(isset($_GET['rent_car'])){
    $controller_name='IndexController';
    $action='rent';
}
else{
    $controller_name = 'IndexController';
    $action='index';
}
include_once 'app/Controller/'.$controller_name.'.php';
$contoller = new $controller_name($UserModel, $CarsModel);
$contoller->$action();
?>


