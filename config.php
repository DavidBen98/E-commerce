<?php
    //start session on web page
    session_start();
    define ('TOKENTWITTER', 'VZtL1D6kiULEhnWS0tRtKXHDp');
    define ('SECRETOCLAVETWITTER', 'k7HZWpbc3oYh3N8Vjx2w0HRE1zgIX1yLfzN7hIOLsGjHxeTFuE');
    define ('IDCLIENTEGOOGLE', '594064547014-qtsmu9tgks9lsgucsl81mu850aadfi4a.apps.googleusercontent.com');
    define ('SECRETOCLAVEGOOGLE', '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');

    $user = (isset($_SESSION["user"]) && !empty($_SESSION["user"]))? trim($_SESSION["user"]):""; 
    $perfil = (isset($_SESSION["perfil"]) && !empty($_SESSION["perfil"]))? trim($_SESSION["perfil"]):""; 

    require_once 'vendor/autoload.php';
    require_once 'app/TwitterAuth.php';
    require_once 'vendor\jublonet\codebird-php\src\codebird.php';

    if ($_SERVER['REQUEST_URI'] != 'E-commerceMuebleria/nueva_compra.php'){
        \Codebird\Codebird::setConsumerKey(TOKENTWITTER,
        SECRETOCLAVETWITTER);
        
        $cliente = \Codebird\Codebird::getInstance();
    }

    if ($user==""){ 
        //Include Google Client Library for PHP autoload file
        require_once 'vendor/autoload.php';
        
        //Make object of Google API Client for call Google API
        $google_client = new Google_Client();
        
        //Set the OAuth 2.0 Client ID | Copiar "ID DE CLIENTE"
        $google_client->setClientId(IDCLIENTEGOOGLE);
        
        //Set the OAuth 2.0 Client Secret key
        $google_client->setClientSecret(SECRETOCLAVEGOOGLE);
        
        //Set the OAuth 2.0 Redirect URI | URL AUTORIZADO
        $google_client->setRedirectUri('http://127.0.0.1/E-commerceMuebleria/index.php');
        
        // to get the email and profile 
        $google_client->addScope('email');
        
        $google_client->addScope('profile');

        if(isset($_SESSION['user_first_name'])){
            $perfil = "U";
        }
    }
?>