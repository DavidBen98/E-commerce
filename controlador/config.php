<?php
    session_start();
    require_once "../vendor/autoload.php";
    require_once "../vendor\jublonet\codebird-php\src\codebird.php";
    // require_once "../app/TwitterAuth.php";

    // $tokengoogle = getenv('IDCLIENTEGOOGLE');
    $tokengoogle = "594064547014-qtsmu9tgks9lsgucsl81mu850aadfi4a.apps.googleusercontent.com";
    // $secretoclavetokengoogle = getenv('SECRETOCLAVEGOOGLE');
    $secretoclavetokengoogle = "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";
    $tokentwitter = getenv('TOKENTWITTER');
    $secretoclavetokentwitter = getenv('SECRETOCLAVETWITTER');

    $user = (isset($_SESSION["user"]) && !empty($_SESSION["user"]))? trim($_SESSION["user"]):""; 
    $perfil = (isset($_SESSION["perfil"]) && !empty($_SESSION["perfil"]))? trim($_SESSION["perfil"]):""; 

    // \Codebird\Codebird::setConsumerKey($tokentwitter);
    
    // $cliente = \Codebird\Codebird::getInstance();

    if ($user==""){      
        //Make object of Google API Client for call Google API
        $google_client = new Google_Client();
        
        // //Set the OAuth 2.0 Client ID | Copiar "ID DE CLIENTE"
        $google_client->setClientId($tokengoogle);
        
        // //Set the OAuth 2.0 Client Secret key
        $google_client->setClientSecret($secretoclavetokengoogle);
        
        // //Set the OAuth 2.0 Redirect URI | URL AUTORIZADO
        $google_client->setRedirectUri("http://127.0.0.1/vistas/index.php");
        
        // // to get the email and profile 
        $google_client->addScope("email");
        
        $google_client->addScope("profile");

        if(isset($_SESSION["user_first_name"]) || isset($_SESSION["user_id"])){
            $perfil = "U";
        }
    }
?>