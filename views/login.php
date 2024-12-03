<?php

    if(isset($_POST['connexion'])){
        $login = $_POST['login'];
        $password = $_POST['password'];

        if($login == 'admin' && $password == 'admin'){
            $_SESSION['id'] = 1;
            header('location: index.php?p=dashboard');
        }else{
          echo '
          <div class="alert alert-danger w-25">
            Login ou mot de passe différent
          </div>
        ';
        }
    }


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./public/stockEpuiser.css" />
    <link rel="stylesheet" href="./public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./public/adminlte.min.css">
    <title>Document</title>
</head>
<body class="bg-gray" style="width: 100vw; height: 100vh; display: flex; align-items:center; justify-content:center; flex-direction: column;"> 
    <div class="row w-100">
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <div class="card card-primary shadow bg-light">
              <div class="card-header">
                <h3 class="card-title">Gestion de Stock</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form method="post">
                <div class="card-body">
                    <div class="form-floating mb-3">
                        <input type="text" name="login" id="pseudo" class="form-control" placeholder="Entrez votre login" required>
                        <label for="pseudo">Login</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Entrez votre mot de passe" required>
                        <label for="password">Mot de passe</label>
                    </div>
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Se souvenir de moi</label>
                  </div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" name="connexion" class="btn btn-primary">Connexion</button>
                </div>
              </form>
            </div>
        </div>
        <div class="col-sm-4"></div>
    </div>
</body>
</html>