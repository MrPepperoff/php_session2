<?php
    session_start();
    require_once("../config.php");
	require_once("../lib/db.php");

    $status = [
		"error" => ["code" => 501, "msg" => "Error"],
		"error_data" => ["code" => 502, "msg" => "Неверные данные"],
		"success" => ["code" => 201, "msg" => "ok"]
	];

    if(isset($_POST['email']) && !empty($_POST['email']) && 
		isset($_POST['password']) && !empty($_POST['password'])){

            $link = connect();

            $data = [
                "email" => $_POST['email'],
                "password" => $_POST['password']
            ];

            $result = selectOneData($link, $data, "users");


            if(is_null($result)){
                header("location: ".BASE_URL."index.php?status=".json_encode($status["error_data"]));
            }
            else{
                $_SESSION['login'] = md5($result['email']);
    
                header("location: ".BASE_URL."index.php?status=".json_encode($status["success"]));
                die();
            }
        }    
    header("location: ".BASE_URL."index.php?status=".json_encode($status["error"]));
    