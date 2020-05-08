<?php

class Functions {

    /**
     * Validate not allowed characters in string
     * @param $str
     * @return bool
     */
    public static function validateString($str)
    {
        if(strpos($str, "=")!==false) return false;
        if(strpos($str, " ")!==false) return false;
        if(strpos($str, "(")!==false) return false;
        if(strpos($str, ")")!==false) return false;
        if(strpos($str, "'")!==false) return false;
        if(strpos($str, "/")!==false) return false;
        return true;
    }

    /**
     * Validate email function
     * @param $email
     * @return bool
     */
    public static function validateEmail($email){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $exp1=explode('@', $email);
            if($exp1){
                $exp2=explode('.', $exp1[1]);
                if($exp2){
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else{
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Log out user and destroy sessions
     * @return bool
     */
    public static function logout(){
        session_unset($_SESSION['id']);
        session_unset($_SESSION['username']);
        session_unset($_SESSION['role_name']);
        session_destroy();
        return true;
    }

    /**
     * Check if user is already logged in
     * @return boolean ;
     */

    public static function is_logged_in()
    {
        if (isset($_SESSION['id']) and isset($_SESSION['username']) and isset($_SESSION['role_name'])){
            return true;
        }else{
            return false;
        }
    }

    /**
     * Set sessions for log in user
     * @param $name
     * @param $id
     * @param $role_id
     */
    public static function setsession($id, $name, $role_name){
        $_SESSION['id']=$id;
        $_SESSION['username']=$name;
        $_SESSION['role_name']=$role_name;
    }

    /**
     * Identification tittle page of user load
     * @param $role_id
     * @param IDataBase $dataBase
     * @return string
     */
    public static function identifyTittle($role_id, IDataBase $dataBase){
        $db=$dataBase;
        $db->connect();
        $res=$db->query("SELECT * FROM roles WHERE id = '{$role_id}'")->fetch();
        if($res){
            if($res['name']=='administrator'){
                return "Administracioni load";
            }
            elseif ($res['name']=='moderator'){
                return "Moderacioni load";
            }
            elseif ($res['name']=='user'){
                return "Korisnicki load";
            }
        }
        else
        {
            echo "Nepoznat naziv.";
        }
    }

    /**
     * Disable page for guests
     */
    public static function disablePage(){
        if (isset($_SESSION['name']) and !isset($_SESSION['name']))
        {
            header('location: ../load/index.php');
        }
    }

    /**
     * Find image of cars on server and return image name, and image extension.
     * @param $imagename
     * @return string
     */
    public static function selectImageCar($imagename){
        $jpg = $imagename. '.jpg';
        $jpeg = $imagename. '.jpeg';
        $png = $imagename. '.png';
        $bmp = $imagename. '.bmp';
        if(file_exists('../asset/img/cars/'.$jpg)){
            return $jpg;
        }elseif (file_exists('../asset/img/cars/'.$jpeg)){
            return $jpeg;
        }elseif (file_exists('../asset/img/cars/'.$png)){
            return $png;
        }elseif (file_exists('../asset/img/cars/'.$bmp)){
            return $bmp;
        }
    }

    public static function redirect($route){
        header("location: {$route}");
    }

}


