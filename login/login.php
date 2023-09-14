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
                $_SESSION['backet'] = $result['id'];
    
                header("location: ".BASE_URL."index.php?status=".json_encode($status["success"]));
                if(isset($_POST['save']) && $_POST['save'] == "on"){
                    // запоминмаем пользователя в куку
                    header("location: ".BASE_URL."index.php?status=".json_encode($status["success"])."&auth=1&email=".md5($result['email']));
                }
                else{
                    header("location: ".BASE_URL."index.php?status=".json_encode($status["success"])."&email=".md5($result['email']));
                }
                die();
            }
        }    
    header("location: ".BASE_URL."index.php?status=".json_encode($status["error"]));
    