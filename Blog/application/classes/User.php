<?php
class User extends Model {
    public static $TABLE_NAME='users';
    public $id;
    public $name;
    public $email;
    public $password;
    public $type;
    
    static function checkUser($email, $pass){
        $cond = sprintf("email='%s' AND password='%s'", $email, md5($pass.secretString()));
        $result=static::readRecords($cond, true, false);
        $response = empty($result) ? false : true;
        if ($response) {
            return $result;
        }else{
            return $response;
        }
    }
    
    static function checkUserByName($name, $pass){
        $cond = sprintf("name='%s' AND password='%s'", $name, md5($pass.secretString()));
        $result=static::readRecords($cond, true, false);
        $response = empty($result) ? false : true;
        if ($response) {
            return $result;
        }else{
            return $response;
        }
    }    
    
    public static function emailExists($email) {
        $cond = sprintf("email='%s'", $email);
        return static::readRecords($cond);
    }
    
    public function login() {
        $_SESSION['loggedUserId']=$this->id;
    }
    
    public static function isLogged(){
        if (isset($_SESSION['loggedUserId'])) {   return true;   }else{   return false;   }
    }
    
    public static function getUserId(){
        if (isset($_SESSION['loggedUserId'])) {   return $_SESSION['loggedUserId'];   }else{   return 0;   }
    }    
    
    public static function logout(){
        if (!isset($_SESSION['loggedUserId'])) {   unset($_SESSION['loggedUserId']);   }
    }    
    
    public static function getLogged(){
        if (static::isLogged()){
            $user=new User($_SESSION['loggedUserId']);
            return isset($user) ? $user : null;
        }else{
            return null;
        }
            
    }
}