<?php
class UserModel
{
    private $db;
    private $message;

    public function __construct(Connection $db)
    {
        session_start();
        $db->connect();
        $this->db=$db;
    }

    /**
     * Return all registered users
     * @return array|bool
     */
    public function findAllUsers(){
        $users=array();
        $query='SELECT * FROM vw_users';
        if($result = $this->db->query($query)->fetchAll()){
            foreach($result as $row){
                $users[]=array(
                  'id' => $row['id'],
                  'username' => $row['username'],
                  'email' => $row['username'],
                  'password' => $row['password'],
                  'name' => $row['name'],
                  'lastname' => $row['lastname'],
                  'phone_number' => $row['phone_number'],
                  'roles_id' => $row['roles_id'],
                  'role_name' => $row['role_name']
                );
            }
        }else{
            return false;
        }
        return $users;
    }

    public function findUsersByRole($role_name){
        $users=array();
        $query="SELECT * FROM vw_users WHERE role_name = '{$role_name}'";
        if($result = $this->db->query($query)->fetchAll()){
            foreach($result as $row){
                $users[]=array(
                    'id' => $row['id'],
                    'username' => $row['username'],
                    'email' => $row['username'],
                    'password' => $row['password'],
                    'name' => $row['name'],
                    'lastname' => $row['lastname'],
                    'phone_number' => $row['phone_number'],
                    'roles_id' => $row['roles_id'],
                    'role_name' => $row['role_name']
                );
            }
        }else{
            return false;
        }
        return $users;
    }


    /**
     * Get users by email
     *@param String $email
     *@return array
     */

    public function findOneUserById($email){
        $user=array();
        $query= "SELECT * FROM vw_users WHERE email = '{$email}' or username = '{$email}'";
        if ($result = $this->db->query($query)){
            $row=$result->fetch();
            if(!$row) return false;
            $user = array(
                'id' => $row['id'],
                'username' => $row['username'],
                'email' => $row['email'],
                'password' => $row['password'],
                'name' => $row['name'],
                'role_name' => $row ['role_name']
            );
            $result = NULL;
        } else{
            exit($this->db->errorInfo());
        }
        return $user;
    }

    /** Auth user
     * @param String $email
     * @param String $password
     * @return boolean
    */

    public function AuthUser(){
        if(isset($_POST['username']) and isset($_POST['password'])){
            $username=filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
            $password=filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
            if(!empty($username) and !empty($password)){
                $user = $this->findOneUserById($username);
                if($user){
                    if(password_verify($password, $user['password'])){
                        Functions::setsession($user['id'], $user['username'], $user['role_name']);
                        Functions::redirect('index.php');
                        return true;
                        $this->message = 'Uspešno ste se ulogovali!';
                    }else{
                        return false;
                        $this->message='Lozinka nije ispravna!';
                    }
                }else{
                    return false;
                    $this->message = 'Korisnik ne postoji!';
                }
            }else{
                return false;
                $this->message= 'Neka polja su prazna!';
            }
        }
    }

    /**
     * Function for get reset password email and token, and add token or email to Data Base
     * @return bool
     * @throws Exception
     */

    public function resetPassword(){
        if(isset($_GET['reset_password'])){
            if($_POST['reset_email']){
                $email=filter_var($_POST['reset_email'], FILTER_SANITIZE_EMAIL);
                if(Functions::validateEmail($email)){
                    $token=bin2hex(random_bytes(50));
                    $query="SELECT email FROM users WHERE email ='{$email}'";
                    if($result = $this->db->query($query)){
                        $count=$result->rowCount();
                        if($count>=1){
                            $this->db->exec("INSERT INTO password_resets (email, token) VALUES ('{$email}', '{$token}')");
                            $to=$email;
                            $subject= 'Resetovanje lozinke korisnika administracionog panela Rent a car Speed';
                            // Change href to add site on server
                            $message= "Zdravo, kliknite za resetovanje vaše lozinke <a href='https://www.rentacar-speed.rs/load/index.php?new_password&token={$token}&email={$email}'>ovde</a>. <br> Vaša Rent a car aplikacija! ";
                            $message=wordwrap($message, 70);
                            $headers='From: info@rentacar-speed.rs';
                            mail($to, $subject, $message, $headers);
                            $this->message = 'Uspešno poslat kod za resetovanje lozinke na vašu e-poštu!';
                        }else{
                            return false;
                            $this->message='Nepostojeci korisnik!';
                        }
                    }else{
                        return false;
                    }
                }else{
                    return false;
                    $this->message='E-pošta nije u ispravnom formatu!';
                }
            }
        }
    }

    /**
     * Changing password in Data Base
     * @return bool
     */

    public function newPassword(){
        if(isset($_GET['new_password'])){
            if(isset($_GET['token']) and isset($_GET['email'])){
                $token=$_GET['token'];
                $email=$_GET['email'];
                if(isset($_POST['password']) and isset($_POST['cpassword'])){
                    $password=filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
                    $cpassword=filter_var(trim($_POST['cpassword']), FILTER_SANITIZE_STRING);
                    if(!empty($password) and !empty($cpassword)){
                        if(Functions::validateString($password) and Functions::validateString($cpassword)){
                            $query= "SELECT * FROM password_reset WHERE email = '{$email}' and token = '{$token}'";
                            if($result = $this->db->query($query)){
                                $count=$result->rowCount();
                                if($count>=1){
                                    if($password===$cpassword){
                                        $hash=password_hash($password, PASSWORD_DEFAULT);
                                        $query="UPDATE users SET password='{$hash}' WHERE  email ='{$email}'";
                                        if($this->db->exec($query)){
                                            return true;
                                            $this->message='Uspesno resetovana loznika!';
                                        }
                                    }else{
                                        return false;
                                        $this->message='Nepoklapajuce lozinke!';
                                    }
                                }else{
                                    return false;
                                    $this->message='Nepostojeci korisnik!';
                                }
                            }else{
                                return false;
                            }
                        }else{
                            return false;
                            $this->message = 'Uneti nedozvoljeni karakteri!';
                        }
                    }else{
                        return false;
                        $this->message = 'Neka polja su prazna!';
                    }
                }
            }
        }

    }



    public function addUser(){
        if(isset($_GET['add_user'])){
            if(isset($_POST['username']) and isset($_POST['name']) and isset($_POST['lastname']) and isset($_POST['email']) and isset($_POST['password']) and isset($_POST['cpassword']) and isset($_POST['role_id'])){
                $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
                $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
                $lastname = filter_var(trim($_POST['lastname']), FILTER_SANITIZE_STRING);
                $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
                $password = filter_var(trim($_POST['password']), FILTER_SANITIZE_STRING);
                $cpassword = filter_var(trim($_POST['cpassword']), FILTER_SANITIZE_STRING);
                $roles_id=filter_var($_POST['roles_id'], FILTER_SANITIZE_NUMBER_INT);
                if(!empty($username) and !empty($name) and !empty($lastname) and !empty($email) and !empty($password) and !empty($cpassword) and !empty($roles_id)){
                    if(Functions::validateString($username) and Functions::validateString($email) and Functions::validateString($name) and Functions::validateString($lastname) and Functions::validateString($password) and Functions::validateString($cpassword)){
                        if(Functions::validateEmail($email)){
                            $query="SELECT * FROM users WHERE email = '{$email}' or username = '{$username}' LIMIT 1";
                            $check_user=$this->db->query($query);
                            if($check_user->rowCount()==0){
                                if($cpassword === $password){
                                    $hash=password_hash($password, PASSWORD_DEFAULT);
                                    $query="INSERT INTO users (username, email, password, name, lastname, role id) VALUES ('$username', '{$email}', '{$hash}', '{$name}', '{$lastname}', '{$roles_id}')";
                                    if($this->db->exec($query)){
                                        $this->message= 'Uspesno ste dodali korisnika';
                                    }else{
                                        $this->message='Doslo je do problema sa unosom, pokusajte kasnije!';
                                    }
                                }else{
                                    return false;
                                    $this->message = 'Lozinke se ne poklapaju!';
                                }
                            }else{
                                $user = $check_user->fetch();
                                if($user['username']==$username){
                                    return false;
                                    $this->message = 'Korisničko ime je zauzeto!';
                                }elseif ($user['email']==$email){
                                    return false;
                                    $this->message = 'E-pošta je zauzeta!';
                                }
                            }
                        }else{
                            return false;
                            $this->message = 'E-pošta nije validna!';
                        }
                    }else{
                        return false;
                        $this->message = 'Uneli ste nedozvljene karaktere!';
                    }
                }else{
                    return false;
                    $this->message = 'Neka od unetih polja su prazna!';
                }

            }
        }
    }

    public function updateUser(){
        if(isset($_GET['update_user']) or isset($_GET['update_users'])){
            $id=$_GET['update_user'];
            if(isset($_POST['update_username'])){
                $username = filter_var(trim($_POST['update_username']), FILTER_SANITIZE_STRING);
                if(Functions::validateString($username)){
                    $query = "UPDATE users SET username = '{$username}' WHERE  id = '{$id}'";
                    if($this->db->exec($query)){
                        if(session_unset($_SESSION['name'])){
                            $SESSION['name']=$username;
                            return true;
                            $this->message = 'Uspešna izmena!';
                        }else{
                            return false;
                            $this->message = 'Oops, došlo je do greške, pokušajte kasnije...';
                        }
                    }else{
                        return false;
                        $this->message = 'Oops, došlo je do greške, pokušajte kasnije...';
                    }
                }else{
                    return false;
                    $this->message = 'Uneti nedozvoljeni karakteri!';
                }
            }

            if(isset($_POST['update_name'])){
                $name = filter_var(trim($_POST['update_name']), FILTER_SANITIZE_STRING);
                if(Functions::validateString($name)){
                    $query = "UPDATE users SET name = '{$name}' WHERE id = '{$id}'";
                    if ($this->db->exec($query)){
                        return true;
                        $this->message = 'Uspešna izmena!';
                    }else{
                        return false;
                        $this->message = 'Oops, došlo je do greške, pokušajte kasnije...';
                    }
                }else{
                    return false;
                    $this->message = 'Uneti nedozvoljeni karakteri!';
                }
            }

            if(isset($_POST['update_lastname'])){
                $lastname = filter_var(trim($_POST['update_lastname']), FILTER_SANITIZE_STRING);
                if (Functions::validateString($lastname)){
                    $query = "UPDATE users SET lastname = '{$lastname}' WHERE id = '{$id}'";
                    if ($this->db->exec($query)){
                        return true;
                        $this->message = 'Uspešna izmena!';
                    }else{
                        return false;
                        $this->message = 'Oops, došlo je do greške, pokušajte kasnije...';
                    }
                }else{
                    return false;
                    $this->message = 'Uneti nedozvoljeni karakteri!';
                }
            }

            if(isset($_POST['update_password']) and isset($_POST['update_cpassword']) and isset($_POST['update_old_password'])){
                $password = filter_var(trim($_POST['update_password']), FILTER_SANITIZE_STRING);
                $cpassword = filter_var(trim($_POST['update_cpassword']), FILTER_SANITIZE_STRING);
                $old_password = filter_var(trim($_POST['update_old_password']), FILTER_SANITIZE_STRING);
                if (Functions::validateString($password) and Functions::validateString($cpassword) and Functions::validateString($old_password)){
                    $query = "SELECT password FROM users WHERE id = '{$id}'";
                    $hash = $this->db->query($query)->fetch();
                    if($hash){
                        if(password_verify($old_password, $hash['password'])){
                            if ($password == $cpassword){
                                $hash = password_hash($password, PASSWORD_DEFAULT);
                                $query = "UPDATE users SET password = '{$hash}' WHERE id = '{$id}'";
                                if($this->db->exec($query)){
                                    return true;
                                    $this->message = 'Uspešne izmene!';
                                }else{
                                    return false;
                                    $this->message = 'Oops, došlo je do greške, pokušajte kasnije...';
                                }
                            }else{
                                return false;
                                $this->message = 'Nepokljapajuće lozinke!';
                            }
                        }else{
                            return false;
                            $this->message = 'Netačna stara lozinka!';
                        }
                    }else{
                        return false;
                        $this->message = 'Oops, došlo je do greške, pokušajte kasnije...';
                    }
                }else{
                    return false;
                    $this->message = 'Uneti nedozvoljeni karakteri!';
                }
            }

            if(isset($_POST['update_email'])){
                $email=filter_var(trim($_POST['update_email']), FILTER_SANITIZE_EMAIL);
                if(Functions::validateString($email)){
                    if(Functions::validateEmail($email)){
                        $query="UPDATE users SET email = '{$email}' WHERE id = '{$id}'";
                        if($this->db->exec($query)){
                            return true;
                            $this->message = 'Uspešne izmene!';
                        }else{
                            return false;
                            $this->message = 'Oops, došlo je do greške, pokušajte kasnije...';
                        }
                    }else{
                        return false;
                        $this->message = 'E-pošta nije validna!';
                    }
                }else{
                    return false;
                    $this->message = 'Uneli ste nevalidne karaktere!';
                }
            }

            if(isset($_POST['update_phone_number'])){
                $phone_number = filter_var(trim($_POST['update_phone_number']), FILTER_SANITIZE_STRING);
                if(Functions::validateString($phone_number)){
                    $query = "UPDATE users SET phone_number = '{$phone_number}' WHERE id = '{$id}'";
                    if($this->db->exec($query)){
                        return true;
                        $this->message = 'Uspešne izmene!';
                    }
                }else{
                    return false;
                    $this->message = 'Uneli ste nevalidne karaktere!';
                }
            }

            if(isset($_POST['update_avatar'])){
                $dir= 'asset/img/avatars/';
                $filename = $_FILES['update_avatar']['name'];
                $eks = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                $query = "SELECT id FROM users WHERE id = '{$id}'";
                if($id = $this->db->query($query)){
                    $id = $id->fetch();
                    if(getimagesize($_FILES['update_avatar']['tmp_name'])){
                        if(file_exists($dir.$id.'.jpg')){
                            unlink($dir.$id.'.jpg');
                            if (move_uploaded_file($_FILES['update_avatar']['tmp_name'], $dir.$id.$eks)){
                                return true;
                                $this->message = 'Uspešne izmene!';
                            }else{
                                return false;
                                $this->message = 'Oops, došlo je do greške, pokušajte kasnije...';
                            }
                        }elseif(file_exists($dir.$id.'.png')){
                            unlink($dir.$id.'.png');
                            if (move_uploaded_file($_FILES['update_avatar']['tmp_name'], $dir.$id.$eks)){
                                return true;
                                $this->message = 'Uspešne izmene!';
                            }else{
                                return false;
                                $this->message = 'Oops, došlo je do greške, pokušajte kasnije...';
                            }
                        }elseif(file_exists($dir.$id.'.gif')){
                            unlink($dir.$id.'.gif');
                            if (move_uploaded_file($_FILES['update_avatar']['tmp_name'], $dir.$id.$eks)){
                                return true;
                                $this->message = 'Uspešne izmene!';
                            }else{
                                return false;
                                $this->message = 'Oops, došlo je do greške, pokušajte kasnije...';
                            }
                        }elseif(file_exists($dir.$id.'.jpeg')){
                            unlink($dir.$id.'.jpeg');
                            if (move_uploaded_file($_FILES['update_avatar']['tmp_name'], $dir.$id.$eks)){
                                return true;
                                $this->message = 'Uspešne izmene!';
                            }else{
                                return false;
                                $this->message = 'Oops, došlo je do greške, pokušajte kasnije...';
                            }
                        }elseif(file_exists($dir.$id.'.tiff')){
                            unlink($dir.$id.'.tiff');
                            if (move_uploaded_file($_FILES['update_avatar']['tmp_name'], $dir.$id.$eks)){
                                return true;
                                $this->message = 'Uspešne izmene!';
                            }else{
                                return false;
                                $this->message = 'Oops, došlo je do greške, pokušajte kasnije...';
                            }
                        }elseif(file_exists($dir.$id.'.bmp')){
                            unlink($dir.$id.'.bmp');
                            if (move_uploaded_file($_FILES['update_avatar']['tmp_name'], $dir.$id.$eks)){
                                return true;
                                $this->message = 'Uspešne izmene!';
                            }else{
                                return false;
                                $this->message = 'Oops, došlo je do greške, pokušajte kasnije...';
                            }
                        }

                    }else{
                        return false;
                        $this->message = 'Niste uneli sliku!';
                    }
                }else{
                    return false;
                    $this->message = 'Oops, došlo je do greške, pokušajte kasnije...';
                }
            }

        }
    }

    public function deleteUser(){
        if(isset($_GET['delete_user'])){
            $id = $_GET['delete_user'];
            //first delete image
            $dir = 'asset/img/avatars/';
            $query= "DELETE FROM users WHERE id = '{$id}'";
            if($this->db->exec($query)){
                if(file_exists($dir.$id.'.jpg')){
                    unlink($dir.$id.'.jpg');
                }elseif(file_exists($dir.$id.'.jpeg')){
                    unlink($dir.$id.'.jpeg');
                }elseif(file_exists($dir.$id.'.png')){
                    unlink($dir.$id.'.png');
                }elseif(file_exists($dir.$id.'.tiff')){
                    unlink($dir.$id.'.tiff');
                }elseif(file_exists($dir.$id.'.gif')){
                    unlink($dir.$id.'.gif');
                }elseif(file_exists($dir.$id.'.bmp')){
                    unlink($dir.$id.'.bmp');
                }
                return true;
                $this->message = 'Uspešno ste obrisali korisnika!';
            }else{
                return false;
                $this->message = 'Neuspešno brisanje korisnika!';
            }
        }
    }

    public function findAllRoles(){
        $roles = array();
        $query="SELECT * FROM roles";
        if($result = $this->db->query($query)){
            $result = $result->fetchAll();
            foreach ($result as $role) {
                $roles[] = array(
                    'id' => $role['id'],
                    'role_name' => $role['role_name']
                );
            }
        }
        return $roles;
    }

    public function findRoleById($id){
        $roles = array();
        $query="SELECT * FROM roles WHERE id ='{$id}'";
        if($result = $this->db->query($query)){
            $result = $roles->fetch();
            foreach ($result as $role) {
                $roles[] = array(
                    'id' => $role['id'],
                    'role_name' => $role['role_name']
                );
            }
        }
        return $roles;
    }

    public function findRoleByRoleName($role_name){
        $roles = array();
        $query="SELECT * FROM roles WHERE role_name = '{$role_name}'";
        if($result = $this->db->query($query)){
            $result = $roles->fetch();
            foreach ($result as $role) {
                $roles[] = array(
                    'id' => $role['id'],
                    'role_name' => $role['role_name']
                );
            }
        }
        return $roles;
    }

    public function addRole(){
        if(isset($_POST['add_role'])){
            $role_name=filter_var(trim($_POST['add_role']), FILTER_SANITIZE_STRING);
            if(Functions::validateString($role_name)){
                $query = "INSERT INTO roles (role_name) VALUES ('{$role_name}')";
                if($this->db->exec($query)){
                    return true;
                    $this->message = 'Uspešno ste dodali rolu!';
                }else{
                    return false;
                    $this->message = 'Neuspešno dodata rola!';
                }
            }else{
                return false;
                $this->message = 'Uneli ste nedozvoljene karaktere!';
            }
        }
    }

    public function updateRole(){
        if(isset($_GET['update_role'])){
            $id = $_GET['update_role'];
            if(isset($_POST['update_role_name'])){
                $role_name = filter_var(trim($_POST['update_role_name']), FILTER_SANITIZE_STRING);
                $query="UPDATE roles SET role_name = '{$role_name}' WHERE id = '{$id}'";
                if($this->db->exec($query)){
                    return true;
                    $this->message = 'Uspešne izmene!';
                }else{
                    return false;
                    $this->message = 'Neuspešne izmene!';
                }
            }
        }
    }

    public function deleteRole(){
        if(isset($_GET['delete_role'])){
            $id=$_GET['delete_role'];
            $query="DELETE FROM roles WHERE id = '{$id}'";
            if($this->db->exec($query)){
                return true;
                $this->message = 'Uspešno brisanje role!';
            }else{
                return false;
                $this->message = 'Nespešno brisanje role!';
            }
        }
    }

    public function addRatings(){
        if(isset($_GET['add_rating'])){
            if(isset($_POST['rating_name']) and isset($_POST['rating']) and isset($_POST['rating_comment'])){
                $name=$_POST['rating_name'];
                $rating=$_POST['rating'];
                $comment=$_POST['rating_comment'];
                $query="INSERT INTO ratings (name, rating, comment) VALUES ('{$name}', '{$rating}', '{$comment}')";
                if($this->db->exec($query)){
                    return true;
                    $this->message = "Uspešno ste ocenili našu Rent a car kuću!";
                }else{
                    return false;
                    $this->message = "Neuspešno ocenjivanje!";
                }
            }
        }
    }

    public function findAllRatings(){
        $ratings = array();
        $query = 'SELECT * FROM ratings';
        if($res = $this->db->query($query)){
            $res = $res->fetchAll();
            foreach ($res as $row){
                $ratings[] = array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'rating' => $row['rating'],
                    'comment' => $row['comment'],
                    'allowed' => $row['allowed']
                );
            }
        }
        return $ratings;
    }

    public function findAllowedRatings(){
        $ratings = array();
        $query = 'SELECT * FROM ratings WHERE allowed = 1';
        if($res = $this->db->query($query)){
            $res = $res->fetchAll();
            foreach ($res as $row){
                $ratings[] = array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'rating' => $row['rating'],
                    'comment' => $row['comment'],
                    'allowed' => $row['allowed']
                );
            }
        }
        return $ratings;
    }

    public function findRatingsOnHold(){
        $ratings = array();
        $query = 'SELECT * FROM ratings WHERE allowed = 0';
        if($res = $this->db->query($query)){
            $res = $res->fetchAll();
            foreach ($res as $row){
                $ratings[] = array(
                    'id' => $row['id'],
                    'name' => $row['name'],
                    'rating' => $row['rating'],
                    'comment' => $row['comment'],
                    'allowed' => $row['allowed']
                );
            }
        }
        return $ratings;
    }

    public function deleteRating(){
        if(isset($_GET['delete_rating'])){
            $id = $_GET['delete_rating'];
            $query = "DELETE FROM ratings WHERE id = '{$id}'";
            if($this->db->exec($query)){
                return true;
                $this->message = 'Uspešno obrisana ocena!';
            }else{
                return false;
                $this->message = 'Neuspešno brisanje ocene!';
            }
        }
    }

    public function updateInformations(){
        if(isset($_POST['update_informations'])){
            $informations = $_POST['update_informations'];
            $query = "UPDATE informations SET informations = '{$informations}' WHERE  id = 1";
            if($this->db->exec($query)){
                return true;
                $this->message = 'Uspešno izmenjene informacije!';
            }else{
                return false;
                $this->message = 'Neuspešne izmene!';
            }
        }
    }

    public function getInformations(){
        $query="SELECT informations FROM informations WHERE id = 1";
        if($res = $this->db->query($query)->fetch()){
            return $res['informations'];
        }
    }


    public function getMessage(){
        return $this->message;
    }
}