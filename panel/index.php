<?php
ini_set('display_errors', 1);
include_once '../app/Model/CarsModel.php';
include_once '../app/Model/UserModel.php';
include_once '../connection/Connection.php';
include_once '../app/renderView.php';
include_once '../functions/Functions.php';

// Instance models
$CarsModel=new CarsModel(new Connection());
$UserModel=new UserModel(new Connection());

/* Routing by GET method */
if(Functions::is_logged_in()==true){
    if($_SESSION['role_name']=='administrator'){
        $controller_name='AdminController';
        $action = 'admin';
    }elseif ($_SESSION['role_name']=='moderator'){
        $controller_name='AdminController';
        $action = 'moderator';
    }
}else{
    if(isset($_GET['new_password'])){
        $controller_name = 'AdminController';
        $action = 'new_password';
    }elseif(isset($_GET['resset_password'])){
        $controller_name = 'AdminController';
        $action = 'reset_password';
    }else{
        $controller_name = 'AdminController';
        $action = 'login';
    }
}
include_once '../app/Controller/'.$controller_name.'.php';
$contoller = new $controller_name($UserModel, $CarsModel);
$contoller->$action();
?>