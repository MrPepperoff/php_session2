<?php 

function connect(){
    $link = mysqli_connect(HOST, USER, PASSWORD, DB_NAME);
    if($link){
		return $link;
	}
	else{
		die("Ошибка подключеня к Базе Данных");
	}
}

function products($link){
    $sql = "SELECT 
            id,
            title,
            text,
            price,
            image
            FROM products";

    $result = mysqli_query($link, $sql);


    $items= null;
    while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
        $items[]= $row;
    }
    return $items;
}
function orders($link){

    $sql = "SELECT
         u.id, 
         p.id,
         p.image,
         p.title,
         p.price,
         o.user_id,
         o.product_id
         
         FROM orders o 
         INNER JOIN users u ON u.id = o.user_id
         INNER JOIN products p ON p.id = o.product_id";

    $result = mysqli_query($link, $sql);


    $items= null;
    while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
        $items[]= $row;
    }
    return $items;
}
function selectOneData($link, $data, $table){

    $sqlWhere = (is_array($data) && count($data) > 0)? "WHERE email = '".$data['email']."' AND password = '".md5($data['password'])."'": "";

    $sql = "SELECT * FROM `$table` ".$sqlWhere;

    $result = mysqli_query($link, $sql);

    $data = null;

    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $data = $row;
    }

    return $data;
}
function searchUserEmail($link, $email){


    $sql = "SELECT * FROM `users`";

    $result = mysqli_query($link, $sql);

    $users = null;

    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
        $users[] = $row;
    }

    $desiredUser = false;

    foreach ($users as $user) {

        if(md5($user['email']) == $email){
            $desiredUser = $user;
        }
    }

    return $desiredUser;
}