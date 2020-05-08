<?php
class AdminController
{
    private $userModel;
    private $carsModel;

    public function __construct($userModel, $carsModel)
    {
        $this->userModel=$userModel;
        $this->carsModel=$carsModel;
    }

    public function admin(){
        // for cars
        $cars= $this->carsModel->findAllPublishedCars();
        $car = $this->carsModel->findOneCarByGetMethod();
        $this->carsModel->addCar();
        $this->carsModel->updateCar();
        $this->carsModel->deleteCar();

        //for brands
        $this->carsModel->addBrand();
        $this->carsModel->updateBrand();
        $this->carsModel->deleteBrand();
        $brands = $this->carsModel->findAllBrands();

        // for classes
        $this->carsModel->addClass();
        $this->carsModel->deleteClass();
        $this->carsModel->updateClass();
        $classes = $this->carsModel->findAllClass();

        // for car bodies
        $this->carsModel->addCarBody();
        $this->carsModel->updateCarBody();
        $this->carsModel->deleteCarBody();
        $carbodies = $this->carsModel->findAllCarBodies();

        //  for fuels
        $fuels = $this->carsModel->findAllFuels();
        $this->carsModel->addFuel();
        $this->carsModel->updateFuel();
        $this->carsModel->deleteFuel();

        //for rented cars
        $this->carsModel->deleteRentedCar();
        $rented_cars = $this->carsModel->listAllRentedCars();
        $all_cars_on_rented_list = $this->carsModel->listAllCarsOnRentList();
        $cars_on_rent_hold_list = $this->carsModel->listAllCarsOnHoldForRent();


        // get message from UserModel
        $carsMessage = $this->userModel->getMessage();

        //for users
        $all_users = $this->userModel->findAllUsers();
        $this->userModel->addUser();
        $this->userModel->updateUser();
        $this->userModel->deleteUser();

        //for roles
        $all_roles=$this->userModel->findAllRoles();
        $this->userModel->addRole();
        $this->userModel->updateRole();
        $this->userModel->deleteRole();

        //for ratings
        $allowed_ratings = $this->userModel->findAllowedRatings();
        $ratings_on_hold = $this->userModel->findRatingsOnHold();
        $this->userModel->deleteRating();

        //for informations
        $this->userModel->updateInformations();
        $informations = $this->userModel->getInformations();

        //get message from UserModel
        $userMessage = $this->userModel->getMessage();

        if(isset($_GET['logout'])){
            Functions::logout();
            Functions::redirect('index.php');
        }

        $view = new renderView('layoutPanel', 'admin');
        $view->assignVariable('cars', $cars);
        $view->assignVariable('car', $car);
        $view->assignVariable('brands', $brands);
        $view->assignVariable('classes', $classes);
        $view->assignVariable('carbodies', $carbodies);
        $view->assignVariable('fuels', $fuels);
        $view->assignVariable('carsMessage', $carsMessage);

    }

    public function moderator(){
        // for cars
        $cars= $this->carsModel->findAllPublishedCars();
        $car = $this->carsModel->findOneCarByGetMethod();
        $this->carsModel->addCar();
        $this->carsModel->updateCar();
        $this->carsModel->deleteCar();

        //for rented cars
        $this->carsModel->deleteRentedCar();
        $rented_cars = $this->carsModel->listAllRentedCars();
        $all_cars_on_rented_list = $this->carsModel->listAllCarsOnRentList();
        $cars_on_rent_hold_list = $this->carsModel->listAllCarsOnHoldForRent();
        //odraditi funkciju za update rent narudzbine

        // get message from UserModel
        $carsMessage = $this->userModel->getMessage();

        //for ratings
        $allowed_ratings = $this->userModel->findAllowedRatings();
        $ratings_on_hold = $this->userModel->findRatingsOnHold();
        $this->userModel->deleteRating();

        //get message from UserModel
        $userMessage = $this->userModel->getMessage();
    }

    public function login(){
        $this->userModel->authUser();
        $message = $this->userModel->getMessage();
        $view = new renderView('layoutLogin', 'login');
        $view->assignVariable('message', $message);
    }

    public function reset_password(){
        $this->userModel->resetPassword();
        $message = $this->userModel->getMessage();
        $view = new renderView('layoutLogin', 'resetPassword');
        $view->assignVariable('message', $message);
    }

    public function new_password(){
        $this->userModel->newPassword();
        $message = $this->userModel->getMessage();
        $view = new renderView('layoutLogin', 'newPassword');
        $view->assignVariable('message', $message);
    }
}
