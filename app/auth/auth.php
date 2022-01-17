<?php
    use Hybridauth\Hybridauth;

    class Auth
    {
        protected static $allow = ['Facebook', 'Twitter', 'Google'];

        protected static function issetRequest(){
            if (isset($_GET['login'])){
                if (in_array($_GET['login'], self::$allow)){
                    return true;
                }
            }
            return false;
        }

        public static function getUserAuth (){
            if (self::issetRequest()){
                $service = $_GET['login'];
                
                $hybridAuth = new Hybridauth(__DIR__ . '\config.php');

                $adapter = $hybridAuth->authenticate($service);

                //global $userProfile; 
                
                $userProfile = $adapter->getUserProfile();

                var_dump($userProfile);

                echo $userProfile['first_name'];
                die();
  
            }
        }


    }
?>