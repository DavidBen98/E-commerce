<?php
include('config.php');

//Reset OAuth access token
$google_client->revokeToken();

//Destroy entire session data.
session_destroy();

$auth = new TwitterAuth($cliente);

$auth->signOut();

//redirect page to index.php
header('location:index.php');

?>