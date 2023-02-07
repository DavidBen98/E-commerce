<?php
    session_start();
    require_once "../vendor/autoload.php";
    require_once "../vendor\jublonet\codebird-php\src\codebird.php";
    // require_once "../app/TwitterAuth.php";
    // define ("TOKENTWITTER", "VZtL1D6kiULEhnWS0tRtKXHDp");
    // define ("SECRETOCLAVETWITTER", "k7HZWpbc3oYh3N8Vjx2w0HRE1zgIX1yLfzN7hIOLsGjHxeTFuE");
    // define ("IDCLIENTEGOOGLE", "594064547014-qtsmu9tgks9lsgucsl81mu850aadfi4a.apps.googleusercontent.com");
    // define ("SECRETOCLAVEGOOGLE", "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");

    $user = (isset($_SESSION["user"]) && !empty($_SESSION["user"]))? trim($_SESSION["user"]):""; 
    $perfil = (isset($_SESSION["perfil"]) && !empty($_SESSION["perfil"]))? trim($_SESSION["perfil"]):""; 

    // \Codebird\Codebird::setConsumerKey("VZtL1D6kiULEhnWS0tRtKXHDp",
    // "k7HZWpbc3oYh3N8Vjx2w0HRE1zgIX1yLfzN7hIOLsGjHxeTFuE");
    
    // $cliente = \Codebird\Codebird::getInstance();

    if ($user==""){      
        //Make object of Google API Client for call Google API
        $google_client = new Google_Client();
        
        // //Set the OAuth 2.0 Client ID | Copiar "ID DE CLIENTE"
        $google_client->setClientId("594064547014-qtsmu9tgks9lsgucsl81mu850aadfi4a.apps.googleusercontent.com");
        
        // //Set the OAuth 2.0 Client Secret key
        $google_client->setClientSecret("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");
        
        // //Set the OAuth 2.0 Redirect URI | URL AUTORIZADO
        $google_client->setRedirectUri("http://127.0.0.1/E-commerceMuebleria/index.php");
        
        // // to get the email and profile 
        $google_client->addScope("email");
        
        $google_client->addScope("profile");

        if(isset($_SESSION["user_first_name"]) || isset($_SESSION["user_id"])){
            $perfil = "U";
        }
    }
?>