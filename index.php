<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
require_once 'functii/sql_functions.php';
session_start();
if (isset($_POST['connect'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $connectResult = connectUser($email, $password);
    
    if ($connectResult) {
        if (isset($_SESSION['fail_login'])) {
            unset($_SESSION['fail_login']);
        }
        $_SESSION['user'] = $email;
    } else {
        $_SESSION['fail_login'] = '<div style="color: red;">Adresa de email și/sau parola greșită!</div>';
    }
}

if (isset($_GET['anuleaza'])) {
    $reservationId = $_GET['anuleaza'];
    deleteReservation($reservationId);
}


?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Agenda personala</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/style.css"/>
        <script src="https://kit.fontawesome.com/3ddee94554.js" crossorigin="anonymous"></script>
    </head>
    <body>
        <header id="banner"></header>
        <?php
        if (isset($_SESSION['user'])) {
            require_once 'templates/template_conectat.php';
        } else {
            require_once 'templates/template_neconectat.php';
        }
        ?>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </body>
</html>
