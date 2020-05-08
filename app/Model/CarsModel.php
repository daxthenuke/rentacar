<?php
class CarsModel
{
    private $db;
    private $message;

    public function __construct(Connection $db)
    {
        $db->connect();
        $this->db=$db;
    }

    /**
     * Get all cars published
     * @return array
     */

    public function findAllPublishedCars(){
        $cars=array();
        $query='SELECT * FROM vw_cars ORDER BY time_added DESC';
        $result= $this->db->query($query);
        if($result){
            foreach ($result->fetchAll() as $row){
                $cars[] = array(
                    'id' => $row['id'],
                    'model' => $row['model'],
                    'availble' => $row['availble'],
                    'image' => $row['image'],
                    'time_added' => $row['time_added'],
                    'time_change' => $row['time_change'],
                    'brands_id' => $row['brands_id'],
                    'brand_name' => $row['brand_name'],
                    'class_id' => $row['class_id'],
                    'class_name' => $row['class_name'],
                    'car_body_id' => $row['car_body_name'],
                    'fuels_id' => $row['fuels_id'],
                    'fuel' => $row['fuel'],
                    'price_id' => $row['price_id'],
                    '24h' => $row['24h'],
                    '48h' => $row['48h'],
                    '72h' => $row['72h'],
                    '7_days' => $row['7_days'],
                    '14_days' => $row['14_days'],
                );
            }
            $result=NULL;
        }else{
            echo ($this->db->errorInfo());
        }
        return $cars;
    }

    /**
     * Get one car by ID
     * @param Int $id
     * @return array
     */

    public function findOneCarById($id){
        $car=array();
        $query="SELECT * FROM vw_cars WHERE id = '{$id}'";
        if($result = $this->db->query($query)){
            $row = $result->fetchAll();
            $car = array(
                'id' => $row['id'],
                'model' => $row['model'],
                'availble' => $row['availble'],
                'image' => $row['image'],
                'time_added' => $row['time_added'],
                'time_change' => $row['time_change'],
                'brands_id' => $row['brands_id'],
                'brand_name' => $row['brand_name'],
                'class_id' => $row['class_id'],
                'class_name' => $row['class_name'],
                'car_body_id' => $row['car_body_name'],
                'fuels_id' => $row['fuels_id'],
                'fuel' => $row['fuel'],
                'price_id' => $row['price_id'],
                '24h' => $row['24h'],
                '48h' => $row['48h'],
                '72h' => $row['72h'],
                '7_days' => $row['7_days'],
                '14_days' => $row['14_days']
            );

            $result = NUll;
        }else{
            exit($this->db->errorInfo());
        }
        return $car;
    }

    public function findOneCarByGetMethod(){
        if(isset($_GET['car_id'])){
            $car_id = filter_var(trim($_GET['car_id']), FILTER_SANITIZE_NUMBER_INT);
            $car=array();
            $query="SELECT * FROM vw_cars WHERE id = '{$car_id}'";
            if($result = $this->db->query($query)){
                $row = $result->fetchAll();
                $car = array(
                    'id' => $row['id'],
                    'model' => $row['model'],
                    'availble' => $row['availble'],
                    'image' => $row['image'],
                    'time_added' => $row['time_added'],
                    'time_change' => $row['time_change'],
                    'brands_id' => $row['brands_id'],
                    'brand_name' => $row['brand_name'],
                    'class_id' => $row['class_id'],
                    'class_name' => $row['class_name'],
                    'car_body_id' => $row['car_body_name'],
                    'fuels_id' => $row['fuels_id'],
                    'fuel' => $row['fuel'],
                    'price_id' => $row['price_id'],
                    '24h' => $row['24h'],
                    '48h' => $row['48h'],
                    '72h' => $row['72h'],
                    '7_days' => $row['7_days'],
                    '14_days' => $row['14_days']
            );

            $result = NUll;
        }else{
            exit($this->db->errorInfo());
        }
        return $car;
        }
    }

    public function findCarByClass($class_id){
        $cars=array();
        $query="SELECT * FROM vw_cars WHERE class_id = '{$class_id}' ORDER BY time_added DESC ";
        if($result = $this->db->query($query)){
            $result=$result->fetchAll();
            foreach ($result as $row){
                $cars[]=array(
                    'id' => $row['id'],
                    'model' => $row['model'],
                    'availble' => $row['availble'],
                    'image' => $row['image'],
                    'time_added' => $row['time_added'],
                    'brands_id' => $row['brands_id'],
                    'brand_name' => $row['brand_name'],
                    'class_id' => $row['class_id'],
                    'class_name' => $row['class_name'],
                    'car_body_id' => $row['car_body_name'],
                    'fuels_id' => $row['fuels_id'],
                    'fuel' => $row['fuel'],
                    'price_id' => $row['price_id'],
                    '24h' => $row['24h'],
                    '48h' => $row['48h'],
                    '72h' => $row['72h'],
                    '7_days' => $row['7_days'],
                    '14_days' => $row['14_days']
                );
            }
        }
        return $cars;
    }

    /**
     * Add car in DataBase
     * @return boolean
     */

    public function addCar(){
        if(isset($_POST['car_image']) and isset($_POST['add_car_model']) and isset($_POST['add_car_availble']) and isset($_POST['add_car_brand_id']) and isset($_POST['add_car_class_id']) and isset($_POST['add_car_car_body_id']) and isset($_POST['add_car_fuel_id']) and isset($_POST['add_price_24h']) and isset($_POST['add_price_48h']) and isset($_POST['add_price_72h']) and isset($_POST['add_price_7_days']) and isset($_POST['add_price_14_days'])){
            $model=filter_var(trim($_POST['add_car_model']), FILTER_SANITIZE_STRING);
            $availble=filter_var(trim($_POST['add_car_availble']), FILTER_SANITIZE_NUMBER_INT);
            $brand_id=filter_var(trim($_POST['add_car_brand_id']), FILTER_SANITIZE_NUMBER_INT);
            $class_id=filter_var(trim($_POST['add_car_class_id']), FILTER_SANITIZE_NUMBER_INT);
            $car_body_id=filter_var(trim($_POST['add_car_car_body_id']), FILTER_SANITIZE_NUMBER_INT);
            $fuel_id=filter_var(trim($_POST['add_car_fuel_id']), FILTER_SANITIZE_NUMBER_INT);
            $price_24h=filter_var(trim($_POST['add_price_24h']), FILTER_SANITIZE_NUMBER_INT);
            $price_48h=filter_var(trim($_POST['add_price_48h']), FILTER_SANITIZE_NUMBER_INT);
            $price_72h=filter_var(trim($_POST['add_price_72h']), FILTER_SANITIZE_NUMBER_INT);
            $price_7_days=filter_var(trim($_POST['add_price_7_days']), FILTER_SANITIZE_NUMBER_INT);
            $price_14_days=filter_var(trim($_POST['add_price_14_days']), FILTER_SANITIZE_NUMBER_INT);

            // first add price
            $query_price= "INSERT INTO price (24h, 48h, 72h, 7_days, 14_days) VALUES ('{$price_24h}', '{$price_48h}', '{$price_72h}', '{$price_7_days}', '{$price_14_days}')";
            if($result = $this->db->exec($query_price)){
                return true;
            }else{
                return false;
                $this->message='Neuspešno dodavanje automobila!';
                exit($this->db->errorInfo());
            }

            //second add car in DB table cars
            $price_id = $this->db->query('SELECT * FROM price')->lastInsertId();
            $image=time();

            $query_car="INSERT INTO cars (model, availble, image, brands_id, class_id, car_body_id, fuels_id, price_id) VALUES ('{$model}', '{$availble}', '{$image}', '{$brand_id}', '{$class_id}', '{$car_body_id}', '{$fuel_id}', '{$price_id}')";
            if($result = $this->db-exec($query_car)){
                return true;
            }else{
                return false;
                $this->message='Neuspešno dodavanje automobila!';
                exit($this->db->errorInfo());
            }

            $query="SELECT image FROM vw_cars WHERE id='{$last_car_id}'";
            $imageName=$image;
            ini_set("upload_max_filesize","20M");
            $dir='asset/img/cars/';
            $nameimg=$_FILES['car_image']['name'];
            $eks=strtolower(pathinfo($nameimg, PATHINFO_EXTENSION));
            if(getimagesize($_FILES['car_image']['tmp_name'])){
                if(file_exists($dir.$imageName.$eks)){
                    unlink($dir.$imageName.$eks);
                    move_uploaded_file($_FILES['car_image']['tmp_name'], $dir.$imageName.$eks);
                    $this->message='Uspešno ste dodali automobil!';
                }else{
                    move_uploaded_file($_FILES['car_image']['tmp_name'], $dir.$imageName.$eks);
                    $this->message='Uspešno ste dodali automobil!';
                }
            }else{
                $this->message='Niste uneli sliku!';
                exit();
            }

        }else{
            $this->message = 'Niste uneli sve podatke!';
        }

    }

    public function updateCar(){
        if(isset($_GET['update_car'])){
            $id=filter_var(trim($_GET['update_car']), FILTER_SANITIZE_NUMBER_INT);
            if(isset($_POST['update_car_model'])){
                $car_model=filter_var(trim($_POST['update_car_model']), FILTER_SANITIZE_STRING);
                $query="UPDATE cars SET model = '{$car_model}' WHERE id = '{$id}'";
                if($this->db->exec($query)){
                    return true;
                    $this->message='Uspešna izmena!';
                }else{
                    return false;
                    $this->message='Neuspešna izmena!';
                }
            }
            if(isset($_POST['update_car_availble'])){
                $car_availble=filter_var(trim($_POST['update_car_availble']), FILTER_SANITIZE_STRING);
                $query="UPDATE cars SET availble = '{$car_availble}' WHERE id = '{$id}'";
                if($this->db->exec($query)){
                    return true;
                    $this->message='Uspešna izmena!';
                }else{
                    return false;
                    $this->message='Neuspešna izmena!';
                }
            }
            if(isset($_POST['update_car_brand'])){
                $car_brand=filter_var(trim($_POST['update_car_brand']), FILTER_SANITIZE_NUMBER_INT);
                $query="UPDATE cars SET brands_id = '{$car_brand}' WHERE id = '{$id}'";
                if($this->db->exec($query)){
                    return true;
                    $this->message='Uspešna izmena!';
                }else{
                    return false;
                    $this->message='Neuspešna izmena!';
                }
            }

            if(isset($_POST['update_car_body'])){
                $car_body=filter_var(trim($_POST['update_car_body']), FILTER_SANITIZE_NUMBER_INT);
                $query="UPDATE cars SET car_body_id = '{$car_body}' WHERE id = '{$id}'";
                if($this->db->exec($query)){
                    return true;
                    $this->message='Uspešna izmena!';
                }else{
                    return false;
                    $this->message='Neuspešna izmena!';
                }
            }

            if(isset($_POST['update_car_fuel'])){
                $car_fuel=filter_var(trim($_POST['update_car_fuel']), FILTER_SANITIZE_NUMBER_INT);
                $query="UPDATE cars SET fuels_id = '{$car_fuel}' WHERE id = '{$id}'";
                if($this->db->exec($query)){
                    return true;
                    $this->message='Uspešna izmena!';
                }else{
                    return false;
                    $this->message='Neuspešna izmena!';
                }
            }

            $query_price = "SELECT price_id FROM cars WHERE id ='{$id}'";
            $price_id=$this->db->query($query_price)->fetch();

            if(isset($_POST['update_price_24_h'])){
                $price_24=filter_var(trim($_POST['update_price_24_h']), FILTER_SANITIZE_NUMBER_INT);
                $query="UPDATE price SET 24h = '{$price_24}' WHERE id = '{$price_id}'";
                if($this->db->exec($query)){
                    return true;
                    $this->message='Uspešna izmena!';
                }else{
                    return false;
                    $this->message='Neuspešna izmena!';
                }
            }

            if(isset($_POST['update_price_48_h'])){
                $price_48=filter_var(trim($_POST['update_price_48_h']), FILTER_SANITIZE_NUMBER_INT);
                $query="UPDATE price SET 48h = '{$price_48}' WHERE id = '{$price_id}'";
                if($this->db->exec($query)){
                    return true;
                    $this->message='Uspešna izmena!';
                }else{
                    return false;
                    $this->message='Neuspešna izmena!';
                }
            }

            if(isset($_POST['update_price_72_h'])){
                $price_72=filter_var(trim($_POST['update_price_72_h']), FILTER_SANITIZE_NUMBER_INT);
                $query="UPDATE price SET 72h = '{$price_72}' WHERE id = '{$price_id}'";
                if($this->db->exec($query)){
                    return true;
                    $this->message='Uspešna izmena!';
                }else{
                    return false;
                    $this->message='Neuspešna izmena!';
                }
            }

            if(isset($_POST['update_price_7_days'])){
                $price_7_days=filter_var(trim($_POST['update_price_7_days']), FILTER_SANITIZE_NUMBER_INT);
                $query="UPDATE price SET 7_days = '{$price_7_days}' WHERE id = '{$price_id}'";
                if($this->db->exec($query)){
                    return true;
                    $this->message='Uspešna izmena!';
                }else{
                    return false;
                    $this->message='Neuspešna izmena!';
                }
            }

            if(isset($_POST['update_price_14_days'])){
                $price_14_days=filter_var(trim($_POST['update_price_14_days']), FILTER_SANITIZE_NUMBER_INT);
                $query="UPDATE price SET 14_days = '{$price_14_days}' WHERE id = '{$price_id}'";
                if($this->db->exec($query)){
                    return true;
                    $this->message='Uspešna izmena!';
                }else{
                    return false;
                    $this->message='Neuspešna izmena!';
                }
            }

            if(isset($_POST['update_image'])){
                //current image name
                $query="SELECT image FROM cars WHERE id = '{$id}'";
                $currentImage=$this->db->query($query)->fetch();
                $dir='asset/img/cars/';
                if(file_exists($dir.$currentImage.'/.jpg')){
                    unlink($dir.$currentImage.'/.jpg');
                }elseif (file_exists($dir.$currentImage.'/.jpeg')) {
                    unlink($dir . $currentImage . '/.jpeg');
                }elseif (file_exists($dir.$currentImage.'/.bmp')) {
                    unlink($dir . $currentImage . '/.bmp');
                }elseif (file_exists($dir.$currentImage.'/.png')) {
                    unlink($dir . $currentImage . '/.png');
                }elseif (file_exists($dir.$currentImage.'/.gif')) {
                    unlink($dir . $currentImage . '/.gif');
                }elseif (file_exists($dir.$currentImage.'/.tiff')) {
                    unlink($dir . $currentImage . '/.tiff');
                }

                $newimagename=time();
                $nameimg=$_FILES['update_image']['name'];
                $eks=strtolower(pathinfo($nameimg, PATHINFO_EXTENSION));
                if(getimagesize($_FILES['update_image']['tmp_name'])){
                    $query="UPDATE cars SET image = '{$newimagename}' WHERE id = '{$id}'";
                    if(move_uploaded_file($_FILES['update_image']['tmp_name'], $dir.$newimagename.$eks) and $this->db->exec($query)){
                        return true;
                        $this->message='Uspešna izmena!';
                    }else{
                        return false;
                        $this->message='Neuspešna izmena!';
                    }
                }else{
                    return false;
                    $this->message='Neuspešno dodavanje slike, niste uneli sliku!';
                }


            }
        }
    }

    public function deleteCar(){
        if(isset($_GET['delete_car'])){
            $id=filter_var(trim($_GET['delete_car']), FILTER_SANITIZE_NUMBER_INT);
            $car = $this->findOneCarById($id);
            if ($car){
                // First delete price
                $price_id = $car['price_id'];
                $sql="DELETE FROM price WHERE id = '{$price_id}'";
                $this->db->exec($sql);
            }else{
                return false;
                exit();
                $this->message= 'Oops, nesto nije u redu..';
            }

            if ($car){
                // Second delete image
                $imagename=$car['image'];
                $dir='asset/img/cars/';
                if(file_exists($dir.$imagename.'.jpg')){
                    unlink($dir.$imagename.'.jpg');
                    return true;
                }elseif (file_exists($dir.$imagename.'.jpeg')){
                    unlink($dir.$imagename.'.jpeg');
                    return true;
                }elseif (file_exists($dir.$imagename.'.png')){
                    unlink($dir.$imagename.'.png');
                    return true;
                }elseif (file_exists($dir.$imagename.'.bmp')){
                    unlink($dir.$imagename.'.bmp');
                    return true;
                }elseif (file_exists($dir.$imagename.'.gif')){
                    unlink($dir.$imagename.'.gif');
                    return true;
                }elseif (file_exists($dir.$imagename.'.tiff')){
                    unlink($dir.$imagename.'.tiff');
                    return true;
                }
            }else{
                return false;
                exit();
                $this->message= 'Oops, nesto nije u redu..';
            }
            $car = null;

            // Third delete car
            $sql="DELETE FROM cars WHERE id = '{$id}'";
            if($this->db->exec($sql)){
                return true;
                $this->message='Uspešno ste obrisa automobil!';
            }else{
                return false;
                $this->message='Neuspešno brisanje!';
            }
        }
    }

    public function addBrand(){
        if(isset($_POST['add_brand'])){
            $brandName=filter_var(trim($_POST['add_brand']), FILTER_SANITIZE_STRING);
            $query = "INSERT INTO brands (brand_name) VALUES ('{$brandName}')";
            if($this->db->exec($query)){
                return true;
                $this->message ='Uspešno ste dodali brend automobila!';
            }else{
                return false;
                $this->message ='Neuspešno dodavanje brenda!';
            }
        }
    }

    public function updateBrand(){
        if(isset($_GET['update_brand_id'])){
            if(isset($_POST['update_brand_name'])){
                $brand_id=filter_var(trim($_GET['update_brand_id']), FILTER_SANITIZE_NUMBER_INT);
                $brand_name=filter_var(trim($_POST['update_brand_name']), FILTER_SANITIZE_STRING);
                $query="UPDATE brands SET brand_name = '{$brand_name}' WHERE id ='{$brand_id}'";
                if($this->db->exec($query)){
                    $this->message='Uspešno izmenjen brend!';
                }else{
                    $this->message='Neuspešno izmenjen brend!';
                }
            }
        }
    }

    public function deleteBrand(){
       if(isset($_GET['delete_brand'])){
           $brand_id=filter_var(trim($_GET['delete_brand']), FILTER_SANITIZE_NUMBER_INT);
           $query="DELETE FROM brands WHERE id = '{$brand_id}'";
           if($this->db->exec($query)){
               $this->message='Uspešno brisanje brenda!';
           }else{
               $this->message='Neuspešno brisanje brenda!';
           }
       }
    }

    public function findAllBrands(){
        $brands=array();
        $query='SELECT * FROM brands';
        if($rows = $this->db->query($query)->fetchAll()){
            foreach ($rows as $row){
                $brands[] = array(
                    'id' => $row['id'],
                    'brand_name' => $row['brand_name']
                );
            }
        }
        return $brands;
    }

    public function addClass(){
        if(isset($_POST['add_class'])){
            $class_name=filter_var(trim($_POST['add_class']), FILTER_SANITIZE_STRING);
            $query="INSERT INTO class (class_name) VALUES ('{$class_name}')";
            if($this->db->exec($query)){
                $this->message = 'Uspešno ste dodali klasu!';
            }else{
                $this->message= 'Neupešno dodavanje klase!';
            }
        }
    }

    public function updateClass(){
        if(isset($_GET['update_class'])){
            $class_id=filter_var(trim($_GET['update_class']), FILTER_SANITIZE_NUMBER_INT);
            if(isset($_POST['update_class_name'])){
                $class_name=filter_var(trim($_POST['update_class_name']), FILTER_SANITIZE_STRING);
                $query="UPDATE class SET class_name = '{$class_name}' WHERE id = '{$class_id}'";
                if($this->db->exec($query)){
                    return true;
                    $this->message='Uspešna izmena!';
                }else{
                    return false;
                    $this->message='Neuspešna izmena!';
                }
            }
        }
    }

    public function deleteClass(){
        if(isset($_GET['delete_class'])){
            $id=filter_var(trim($_GET['delete_class']), FILTER_SANITIZE_STRING);
            $query="DELETE FROM class WHERE id = '{$id}'";
            if($this->db->exec($query)){
                return true;
                $this->message='Uspešno ste obrisali klasu!';
            }else{
                return false;
                $this->message='Neuspešno brisanje klase!';
            }
        }
    }

    public function findAllClass(){
        $classes=array();
        $query='SELECT * FROM class';
        if($rows = $this->db->query($query)->fetchAll()){
            foreach ($rows as $row){
                $classes[] = array(
                    'id' => $row['id'],
                    'class_name' => $row['class_name'],
                );
            }
        }
        return $classes;
    }

    public function findClassById(){
        if(isset($_GET['class_id'])){
            $id = filter_var(trim($_GET['class_id']), FILTER_SANITIZE_NUMBER_INT);
            $query="SELECT * FROM class WHERE id = '{$id}'";
            if($rows = $this->db->query($query)->fetch()){
                foreach ($rows as $row){
                    $class[] = array(
                        'id' => $row['id'],
                        'class_name' => $row['class_name'],
                    );
                }
            }
            return $class;
        }
    }

    public function addCarBody(){
            if(isset($_POST['car_body_name'])){
                $car_body_name = filter_var(trim($_POST['car_body_name']), FILTER_SANITIZE_STRING);
                $query="INSERT INTO car_body (car_body_name) VALUES ('{$car_body_name}')";
                if($this->db->exec($query)){
                    return true;
                    $this->message='Uspešno dodavanje karoserije!';
                }else{
                    return false;
                    $this->message='Neuspešno dodavanje karoserije!';
                }
            }
    }

    public function updateCarBody(){
        if(isset($_GET['update_car_body'])){
            $id=filter_var(trim($_GET['update_car_body']), FILTER_SANITIZE_NUMBER_INT);
            if(isset($_POST['update_car_body_name'])){
                $car_body_name = filter_var(trim($_POST['update_car_body_name']), FILTER_SANITIZE_STRING);
                $query="UPDATE car_body SET car_body_name = '{$car_body_name}' WHERE id = '{$id}'";
                if($this->db->exec($query)){
                    return true;
                    $this->message = 'Uspešno izmenjena karoserija!';
                }else{
                    return false;
                    $this->message = 'Nespešno izmenjena karoserija!';
                }
            }
        }
    }

    public function deleteCarBody(){
        if(isset($_GET['delete_car_body'])){
            $id = filter_var(trim($_GET['delete_car_body']), FILTER_SANITIZE_NUMBER_INT);
            $query="DELETE FROM car_body WHERE id = '{$id}'";
            if($this->db->exec($query)){
                return true;
                $this->message='Uspešno brisanje karoserije!';
            }else{
                return false;
                $this->message='Neuspešno brisanje karoserije!';
            }
        }
    }

    public function findAllCarBodies(){
        $car_bodies=array();
        $query="SELECT * FROM car_body";
        if($rows = $this->db->query($query)->fetchAll()){
            foreach ($rows as $row){
                $car_bodies[] = array(
                    'id' => $row['id'],
                    'car_body_name' => $row['car_body_name']
                );
            }
        }

        return $car_bodies;
    }

    public function findAllFuels(){
        $fuels= array();
        $query = "SELECT * FROM fuels";
        if($rows = $this->db->query($query)->fetchAll()){
            foreach ($rows as $row){
                $fuels[] = array(
                    'id' => $row['id'],
                    'fuel' => $row['fuel']
                );
            }
        }
        return $fuels;
    }

    public function addFuel(){
        if(isset($_POST['add_fuel'])){
            $fuel_name=filter_var(trim($_POST['add_fuel']), FILTER_SANITIZE_STRING);
            $query = "INSERT INTO fuels (fuel) VALUES ('{$fuel_name}')";
            if($this->db->exec($query)){
                return true;
                $this->message='Uspešno dodavanje vrste goriva!';
            }else{
                return false;
                $this->message='Neuspešno dodavanje vrste goriva!';
            }
        }
    }

    public function updateFuel(){
        if(isset($_GET['update_fuel'])){
            $fuel_id=filter_var(trim($_GET['update_fuel']), FILTER_SANITIZE_NUMBER_INT);
            if(isset($_POST['update_fuel_name'])){
                $fuel_name=filter_var(trim($_POST['update_fuel_name']), FILTER_SANITIZE_STRING);
                $query="UPDATE fuels SET fuel = '{$fuel_name}' WHERE if  = '{$fuel_id}'";
                if($this->db->exec($query)){
                    return true;
                    $this->message = 'Uspešna izmena naziva goriva!';
                }else{
                    return false;
                    $this->message = 'Neuspešna izmena naziva goriva!';
                }
            }
        }
    }

    public function deleteFuel(){
        if(isset($_GET['delete_fuel'])){
            $id=filter_var(trim($_GET['delete_fuel']), FILTER_SANITIZE_NUMBER_INT);
            $query="DELETE FROM fuels WHERE id = '{$id}'";
            if($this->db->exec($query)){
                return true;
                $this->message = 'Uspešno brisanje vrste goriva!';
            }else{
                return false;
                $this->message = 'Neuspešno brisanje vrste goriva!';
            }
        }
    }

    public function rentCar(){
        if(isset($_POST['rent_car_name']) and isset($_POST['rent_car_lastname']) and isset($_POST['rent_car_email']) and isset($_POST['rent_car_phone_num']) and isset($_POST['rent_car_JMBG']) and isset($_POST['rent_car_rented_length']) and isset($_POST['price']) and isset($_GET['rent_car']) and isset($_GET['rent_car_brand_id']) and isset($_GET['rent_car_body_id']) and isset($_GET['rent_car_fuels_id']) and isset($_GET['rent_car_price_id'])){
            $name = filter_var(trim($_POST['rent_car_name']), FILTER_SANITIZE_STRING);
            $lastname = filter_var(trim($_POST['rent_car_lastname']), FILTER_SANITIZE_STRING);
            $email = filter_var(trim($_POST['rent_car_email']), FILTER_SANITIZE_EMAIL);
            $phone_number = filter_var(trim($_POST['rent_car_phone_num']), FILTER_SANITIZE_STRING);
            $JMBG = filter_var(trim($_POST['rent_car_JMBG']), FILTER_SANITIZE_NUMBER_INT);
            $rented_length = filter_var(trim($_POST['rent_car_rented_length']), FILTER_SANITIZE_STRING);
            $price = filter_var(trim($_POST['price']), FILTER_SANITIZE_NUMBER_INT);
            $car_id = filter_var(trim($_GET['rent_car']), FILTER_SANITIZE_NUMBER_INT);
            $car_brand_id = filter_var(trim($_GET['rent_car_brand_id']), FILTER_SANITIZE_NUMBER_INT);
            $car_body_id = filter_var(trim($_GET['rent_car_body_id']), FILTER_SANITIZE_NUMBER_INT);
            $car_fuels_id = filter_var(trim($_GET['rent_car_fuels_id']), FILTER_SANITIZE_NUMBER_INT);
            $car_price_id = filter_var(trim($_GET['rent_car_price_id']), FILTER_SANITIZE_NUMBER_INT);


            $query = "INSERT INTO rented_cars (name, lastname, email, phone_number, JMBG, rented_length, price, cars_id, cars_brands_id, cars_car_body_id, cars_fuels_id, cars_price_id) VALUES  ('{$name}', '{$lastname}', '{$email}', '{$phone_number}', '{$JMBG}', '{$rented_length}', '{$price}', '{$car_id}', '{$car_brand_id}', '{$car_body_id}', '{$car_fuels_id}', '{$car_price_id}')";


            if(isset($_POST['rent_car_adress'])){
                $adress = $_POST['rent_car_adress'];
                $query = "INSERT INTO rented_cars (name, lastname, phone_number, JMBG, rented_length, price, cars_id, cars_brands_id, cars_car_body_id, cars_fuels_id, cars_price_id, adress) VALUES  ('{$name}', '{$lastname}', '{$phone_number}', '{$JMBG}', '{$rented_length}', '{$price}', '{$car_id}', '{$car_brand_id}', '{$car_body_id}', '{$car_fuels_id}', '{$car_price_id}', '{$adress}')";
            }

            $subtractcar="UPDATE cars SET availble = availble - 1 WHERE id = '{$car_id}'";
            if(Functions::validateEmail($email)){
                if($this->db->exec($query)){
                    if($this->db->exec($subtractcar)){
                        if(isset($_POST['rent_car_adress'])){
                            return true;
                            $message='Uspešno iznamljen autobmobil, u roku od sat vremena ćemo isporučiti automobil na adresi!';
                            $this->message= $message;
                            $subject = 'Iznamljivanje automobila - Rent a car Speed';
                            $to = $email;
                            $message = wordwrap($message);
                            $headers='From: info@rentacar-speed.rs';
                            mail($to, $subject, $message, $headers);
                        }else{
                            return true;
                            $message = 'Uspešno iznamljen automobil, možete preuzeti automobil na našoj adresi!';
                            $this->message= $message;
                            $subject = 'Iznamljivanje automobila - Rent a car Speed';
                            $to = $email;
                            $message = wordwrap($message);
                            $headers='From: info@rentacar-speed.rs';
                            mail($to, $subject, $message, $headers);
                        }
                    }else{
                        return false;
                        $this->message= 'Oops, nesto nije u redu..';
                    }
                }else{
                    return false;
                    $this->message= 'Oops, nesto nije u redu..';
                }
            }else{
                return false;
                $this->message = 'E-pošta nije validna!';
            }
        }
    }

    public function deleteRentedCar(){
        if(isset($_GET['delete_rented_car'])){
            $id = filter_var(trim($_GET['delete_rented_car']), FILTER_SANITIZE_NUMBER_INT);
            $select_query="SELECT cars_id FROM vw_rented_cars WHERE id = '{$id}'";
            if($this->db->query($select_query)){
                $car_id = $this->db->query($select_query)->fetch();
                $query ="UPDATE cars SET availble = availble + 1 WHERE id = '{$car_id['id']}'";
                if($this->db->exec($query)){
                    $query= "DELETE FROM rented_cars WHERE id = '{$id}'";
                    if($this->db->exec($query)){
                        return true;
                        $this->message = 'Upešno vraćen automobil!';
                    }else{
                        return false;
                        $this->message = 'Neupešno vraćen automobil!';
                    }
                }else{
                    return false;
                    $this->message = 'Oops, došlo je do greške, pokušajte kasnije...';
                }
            }else{
                return false;
                $this->message = 'Oops, došlo je do greške, pokušajte kasnije...';
            }
        }
    }

    public function getCarForRent(){
        if(isset($_GET['rent_car'])){
            $id = filter_var(trim($_GET['rent_car']), FILTER_SANITIZE_NUMBER_INT);
            $car = $this->findOneCarById($id);
            return $car;
        }
    }

    //
    public function listAllRentedCars(){
        $rented_cars = array();
        $query = 'SELECT * FORM vw_rented_cars WHERE allowed = 1';
        if($res = $this->db->query($query)){
            $res = $res->fethcAll();
            foreach ($res as $row) {
                $rented_cars[] = array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'lastname' => $row['lastname'],
                    'email' => $row['email'],
                    'phone_number' => $row['phone_number'],
                    'JMBG' => $row['JMBG'],
                    'adress' => $row['adress'],
                    'allowed' => $row['allowed'],
                    'cars_id' => $row['cars_id'],
                    'model' => $row['model'],
                    'cars_brands_id' => $row['cars_brands_id'],
                    'brand_name' => $row['brand_name'],
                    'cars_car_body_id' => $row['cars_car_body_id'],
                    'car_body_name' => $row['car_body_name'],
                    'cars_fuels_id' => $row['cars_fuels_id'],
                    'fuel' => $row['fuel'],
                    'cars_price_id' => $row['cars_price_id'],
                    'time_added' => $row['time_added'],
                );
            }
        }else{
            return false;
            $this->message= 'Oops, nesto nije u redu..';
        }

        return $rented_cars;
    }

    public function listAllCarsOnRentList(){
        $rented_cars = array();
        $query = 'SELECT * FORM vw_rented_cars';
        if($res = $this->db->query($query)){
            $res = $res->fethcAll();
            foreach ($res as $row) {
                $rented_cars[] = array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'lastname' => $row['lastname'],
                    'email' => $row['email'],
                    'phone_number' => $row['phone_number'],
                    'JMBG' => $row['JMBG'],
                    'adress' => $row['adress'],
                    'allowed' => $row['allowed'],
                    'cars_id' => $row['cars_id'],
                    'model' => $row['model'],
                    'cars_brands_id' => $row['cars_brands_id'],
                    'brand_name' => $row['brand_name'],
                    'cars_car_body_id' => $row['cars_car_body_id'],
                    'car_body_name' => $row['car_body_name'],
                    'cars_fuels_id' => $row['cars_fuels_id'],
                    'fuel' => $row['fuel'],
                    'cars_price_id' => $row['cars_price_id'],
                    'time_added' => $row['time_added'],
                );
            }
        }else{
            return false;
            $this->message= 'Oops, nesto nije u redu..';
        }
        return $rented_cars;
    }

    public function listAllCarsOnHoldForRent(){
        $rented_cars = array();
        $query = 'SELECT * FORM vw_rented_cars WHERE id = 0';
        if($res = $this->db->query($query)){
            $res = $res->fethcAll();
            foreach ($res as $row) {
                $rented_cars[] = array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'lastname' => $row['lastname'],
                    'email' => $row['email'],
                    'phone_number' => $row['phone_number'],
                    'JMBG' => $row['JMBG'],
                    'adress' => $row['adress'],
                    'allowed' => $row['allowed'],
                    'cars_id' => $row['cars_id'],
                    'model' => $row['model'],
                    'cars_brands_id' => $row['cars_brands_id'],
                    'brand_name' => $row['brand_name'],
                    'cars_car_body_id' => $row['cars_car_body_id'],
                    'car_body_name' => $row['car_body_name'],
                    'cars_fuels_id' => $row['cars_fuels_id'],
                    'fuel' => $row['fuel'],
                    'cars_price_id' => $row['cars_price_id'],
                    'time_added' => $row['time_added'],
                );
            }
        }else{
            return false;
            $this->message= 'Oops, nesto nije u redu..';
        }
        return $rented_cars;
    }

    public function changeRentedCar(){
        if(isset($_GET['change_rented_car'])){
            $id = filter_var(trim($_GET['change_rented_car']), FILTER_SANITIZE_NUMBER_INT);
            if(isset($_POST['change_rented_car_name'])){
                $name= filter_var(trim($_POST['change_rented_car_name']), FILTER_SANITIZE_STRING);
                $query = "UPDATE rented_cars SET name = '{$name}' WHERE  id = '{$id}'";
                if($this->db->exec($query)){
                    return true;
                    $this->message = 'Uspešne promene!';
                }else{
                    return false;
                    $this->message = 'Neuspešne promene!';
                }
            }
            if(isset($_POST['change_rented_car_lastname'])){
                $lastname = filter_var(trim($_POST['change_rented_car_lastname']), FILTER_SANITIZE_STRING);
                $query = "UPDATE rented_cars SET lastname = '{$lastname}' WHERE id = '{$id}'";
                if($this->db->exec($query)){
                    return true;
                    $this->message = 'Uspešne promene!';
                }else{
                    return false;
                    $this->message = 'Neuspešne promene!';
                }
            }

            if(isset($_POST['change_rented_car_email'])){
                $email = filter_var(trim($_POST['change_rented_car_email']), FILTER_SANITIZE_EMAIL);
                $query = "UPDATE rented_cars SET email = '{$email}' WHERE id = '{$id}'";
                if($this->db->exec($query)){
                    return true;
                    $this->message = 'Uspešne promene!';
                }else{
                    return false;
                    $this->message = 'Neuspešne promene!';
                }
            }

            if(isset($_POST['change_rented_car_phone_num'])){
                $phone_num = filter_var(trim($_POST['change_rented_car_phone_num']), FILTER_SANITIZE_STRING);
                $query = "UPDATE rented_cars SET phone_number = '{$phone_num}' WHERE id = '{$id}'";
                if($this->db->exec($query)){
                    return true;
                    $this->message = 'Uspešne promene!';
                }else{
                    return false;
                    $this->message = 'Neuspešne promene!';
                }
            }

            if(isset($_POST['change_rented_car_JMBG'])){
                $JMBG = filter_var(trim($_POST['change_rented_car_JMBG']), FILTER_SANITIZE_NUMBER_INT);
                $query = "UPDATE rented_cars SET JMBG = '{$JMBG}' WHERE id = '{$id}'";
                if($this->db->exec($query)){
                    return true;
                    $this->message = 'Uspešne promene!';
                }else{
                    return false;
                    $this->message = 'Neuspešne promene!';
                }
            }

            if(isset($_POST['change_rented_car_adress'])){
                $adress = filter_var(trim($_POST['change_rented_car_adress']), FILTER_SANITIZE_STRING);
                $query = "UPDATE rented_cars SET adress = '{$adress}' WHERE  id = '{$id}'";
                if($this->db->exec($query)){
                    return true;
                    $this->message = 'Uspešne promene!';
                }else{
                    return false;
                    $this->message = 'Neuspešne promene!';
                }
            }

            if(isset($_POST['change_rented_car_car'])){
                $car_id = filter_var(trim($_POST['change_rented_car_car']), FILTER_SANITIZE_NUMBER_INT);
                $query_car = "SELECT * FROM cars WHERE id = '{$car_id}'";
                if ($res = $this->db->query($query_car)){
                    $res = $res->fetch();
                    $query = "UPDATE rented_cars SET cars_id = '{$res['id']}', cars_brands_id = '{$res['brands_id']}', cars_car_body_id = '{$res['car_body_id']}', cars_fuels_id = '{$res['fuels_id']}' , cars_price_id ='{$res['cars_price_id']}'";
                    if($this->db->exec($query)){
                        return true;
                        $this->message = 'Uspešne promene!';
                    }else{
                        return false;
                        $this->message = 'Neuspešne promene!';
                    }
                }else{
                    return false;
                    $this->message = 'Oops, nešto nije u redu...';
                }
            }
        }
    }


    public function getMessage(){
        return $this->message;
    }
}