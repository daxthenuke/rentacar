<?php
include_once 'app/Model/UserModel.php';
include_once 'app/Model/CarsModel.php';
include_once 'connection/Connection.php';

$UserModel = new UserModel(new Connection());
$CarsModel = new CarsModel(new Connection());


$method = $_SERVER['REQUEST_METHOD'];


if(strtolower($method) == 'get' and isset($_GET['getallcars'])){
    $cars = $CarsModel->findAllPublishedCars();
    $array = array();
    foreach ($cars as $row) {
        $array[] = $row['id'];
        $array[] = $row['model'];
        $array[] = $row['availble'];
        $array[] = $row['image'];
        $array[] = $row['time_added'];
        $array[] = $row['time_change'];
        $array[] = $row['brands_id'];
        $array[] = $row['brand_name'];
        $array[] = $row['class_id'];
        $array[] = $row['class_name'];
        $array[] = $row['car_body_name'];
        $array[] = $row['fuels_id'];
        $array[] = $row['fuel'];
        $array[] = $row['price_id'];
        $array[] = $row['24h'];
        $array[] = $row['48h'];
        $array[] = $row['72h'];
        $array[] = $row['7_days'];
        $array[] = $row['14_days'];
    }
    echo json_encode($array);
}
