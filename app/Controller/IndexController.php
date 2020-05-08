<?php
class IndexController
{
        private $userModel;
        private $carsModel;

        public function __construct($userModel, $carsModel)
        {
            $this->carsModel = $carsModel;
            $this->userModel = $userModel;
        }

        public function index(){
            $cars=$this->carsModel->findAllPublishedCars();
            $ratings=$this->userModel->findAllowedRatings();
            $informations = $this->userModel->getInformations();
            $view=new renderView('layoutPortal', 'cars');
            $view->assignVariable('cars', $cars);
            $view->assignVariable('ratings', $ratings);
            $view->assignVariable('informations', $informations);
        }

        public function rent(){
            $rentcar = $this->carsModel->getCarForRent();
            $message = $this->carsModel->getMessage();
            $this->carsModel->rentCar();
            $view = new renderView('LayoutPortal', 'rentCar');
            $view->assignVariable('rentcar', $rentcar);
            $view->assignVariable('message', $message);
        }

}