<?php
    class TwitterAuth
    {
        protected $cliente;
        protected $clienteCallback = "http://127.0.0.1/E-commerceMuebleria/callback.php";

        public function __construct(\Codebird\Codebird $cliente){
            $this->cliente = $cliente;
        }

        public function getAuthUrl(){
            $this->requestTokens();
            $this->verifyTokens();

            return $this->cliente->oauth_authenticate();
        }

        public function requestTokens(){
            $reply = $this->cliente->oauth_requestToken([
                'oauth_callback' => $this->clienteCallback
            ]);

            $this->storeTokens($reply->oauth_token, $reply->oauth_token_secret);
        }

        protected function storeTokens($token, $tokenSecret){
            $_SESSION['oauth_token'] = $token;
            $_SESSION['oauth_token_secret'] = $tokenSecret;
        }

        public function verifyTokens(){
            $this->cliente->setToken($_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
        }

        public function isLogin(){
            return isset($_SESSION['user_id']);
        }

        public function signOut(){
            unset($_SESSION['user_id']);
            $_SESSION = array();
		
		    session_destroy(); 
        }

        public function login(){
            if ($this->hasCallback()){
                $this->verifyTokens();
                $reply = $this->cliente->oauth_accessToken([
                    'oauth_verifier' => $_GET['oauth_verifier']
                ]);

                if ($reply->httpstatus == 200){
                    $this->storeTokens($reply->oauth_token,$reply->oauth_token_secret);
                    $_SESSION['user_id'] = $reply->user_id;

                    $this->verifyTokens();
                    $usuario = $this->cliente->account_verifyCredentials();
                    $_SESSION['nombre_tw'] = $usuario->name;
                    if (isset($usuario->user_name)){
                        $_SESSION['arroba_tw'] = $usuario->user_name;
                    }
                    
                    //header('location: index.php');
                    
                    return true;
                    die();

                }
            }
            return false;
        }

        public function hasCallback(){
            return isset($_GET['oauth_verifier']);
        }
    }

?>