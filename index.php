<?php 
    session_start();
    require_once('config.php');
    require_once('lib/db.php');

    $link = connect();
    $products = products($link);
    $orders = orders($link);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-2">
                    <h1>Session</h1>
                </div>
                <div class="col-10">
                    <?php
                    if(!isset($_SESSION['login'])){?>
                        <form action="login/login.php" method='POST' class="row g-3 justify-content-end">
                            <div class="col-auto">
                                <label for="inputEmail" class="visually-hidden">Почта</label>
                                <input type="text" class="form-control" id="inputEmail" name='email' placeholder="Почта... 1-2@mail.ru">
                            </div>
                            <div class="col-auto">
                                <label for="inputPassword2" class="visually-hidden">Пароль</label>
                                <input type="password" class="form-control" id="inputPassword2" name="password" placeholder="Пароль... {123}">
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn header__btn">Войти</button>
                            </div>
                        </form>
					<?php 
                    }else{
						$link = connect();
						$user = searchUserEmail($link, $_SESSION['login']);
						if(!is_null($user)):?>
								<div class="header__user user">
									<p>Привет, 
										<span class="user__name"><?php echo $user['login']; ?></span> 
										<a href="login/logout.php" class="btn header__btn">Выйти</a>
									</p>
								</div>
                    <?php endif; }?>
                </div>
            </div>
        </div>
    </header>
    <main class="main">
        
        <div class="container">
            <div class="row">
                <article class="col-8 main__section">
                    <section class="section">
                        <div class="row">
                            <?php foreach ($products as $product) : ?>
                                <div class="col-4">
                                    <div class="card">
                                        <img src="images/<?php echo $product['image']; ?>" class="card-img-top" alt="...">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $product['title']; ?></h5>
                                            <p class="card-text"><?php echo $product['text']; ?></p>
                                            <p class="card-price"><?php echo $product['price']; ?> руб.</p>
                                            <a href="#" class="btn btn_card" title="не работает">Карзина</a>
                                        </div>
                                    </div>    
                                </div>
                                
                            <?php endforeach; ?>    
                        </div>
                        
                    </section>
                </article>  
                <div class="col-4 main__backet backet">
                    <h4>Корзина</h4>
                    <div class="row">
                        <?php

                        if(isset($_SESSION['backet'])):
                            foreach ($orders as $order) :


                                if($_SESSION['backet'] == $order['user_id']) :
                                ?>
                                <div class="col-12">
                                    <div class="card backet__card">
                                        <img src="images/<?php echo $order['image']; ?>" class="card-img-top backet__img" alt="...">
                                        <div class="card-body  backet__body">
                                            
                                            <h5 class="card-title backet__title"> <?php echo $order['title']; ?></h5>
                                            <p class="card-price backet__price"><?php echo $order['price']; ?> руб.</p>
                                        </div>
                                    </div> 
                                </div> 
                        <?php endif;
                        endforeach;
                            endif; ?>  
                    </div>
                </div>  
            </div>
            
        </div>
    </main>
    <footer class="footer">

    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>