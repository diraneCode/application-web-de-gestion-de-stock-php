<?php

    $db = Database::Connect();

    if(isset($_GET['id'])){

      $id= $_GET['id'];

      $query = $db->query("SELECT * FROM categorie_article INNER JOIN article ON article.id_categorie = categorie_article.id WHERE article.id = ". $id);
      $article = $query->fetch(PDO::FETCH_OBJ);
    }


    if(isset($_POST['modifier'])){
        $article = $_POST['article'];
        $categorie = $_POST['categorie'];
        $quantite = $_POST['quantite'];
        $prixUnitaire = $_POST['prixUnitaire'];
        $dateFabrication = $_POST['dateFabrication'];
        $dateExpiration = $_POST['dateExpiration'];
        $image = $_POST['image'];

        $requete = $db->prepare("UPDATE article SET nom_article = ? , id_categorie = ?, quantite = ?, prix_unitaire = ?, date_fabrication = ?, date_expiration = ?, images = ? WHERE id = ?");
        $requete->execute(array($article, $categorie, $quantite, $prixUnitaire, $dateFabrication, $dateExpiration, $image, $id));

        header('location: index.php?p=article');
    }
    $query2 = $db->query("SELECT * FROM categorie_article");
    $categories = $query2->fetchAll(PDO::FETCH_OBJ);

?>


<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./public/stockEpuiser.css" />
    <link rel="stylesheet" href="./public/style.css" />
    <link rel="stylesheet" href="./public/bootstrap/css/bootstrap.min.css">
    <!-- Boxicons CDN Link -->
    <link
      href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
      rel="stylesheet"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  </head>
  <body>
    <div class="sidebar">
      <div class="logo-details">
        <i class="bx bxl-c-plus-plus"></i>
        <span class="logo_name">G-STOCK</span>
      </div>
      <ul class="nav-links">
        <li>
          <a href="index.php?p=dashboard">
            <i class="bx bx-grid-alt"></i>
            <span class="links_name">Dashboard</span>
          </a>
        </li>
        <li>
          <a href="index.php?p=article" class="active">
            <i class="bx bx-box"></i>
            <span class="links_name">Article</span>
          </a>
        </li>
        <li>
          <a href="index.php?p=categorie">
            <i class="bx bx-list-ul"></i>
            <span class="links_name">Catégorie</span>
          </a>
        </li>
        <li>
          <a href="index.php?p=client">
            <i class="bx bx-pie-chart-alt-2"></i>
            <span class="links_name">Client</span>
          </a>
        </li>
        <li>
          <a href="index.php?p=commande">
            <i class="bx bx-coin-stack"></i>
            <span class="links_name">Commande</span>
          </a>
        </li>
        <li>
          <a href="index.php?p=fournisseur">
            <i class="bx bx-command"></i>
            <span class="links_name">Fournisseur</span>
          </a>
        </li>
        <li>
          <a href="index.php?p=stock">
            <i class="bx bx-user"></i>
            <span class="links_name">Stock</span>
          </a>
        </li>
        </li> 
        <li>
          <a href="index.php?p=vente">
            <i class="bx bx-cog"></i>
            <span class="links_name">Vente</span>
          </a>
        </li>
        <li class="log_out">
          <a href="index.php?p=deconnexion">
            <i class="bx bx-log-out"></i>
            <span class="links_name">Déconnexion</span>
          </a>
        </li>
      </ul>
    </div>
    <section class="home-section">
      <nav>
        <div class="sidebar-button">
          <i class="bx bx-menu sidebarBtn"></i>
          <span class="dashboard">Dashboard</span>
        </div>
        <div class="search-box">
          <input type="text" placeholder="Recherche..." />
          <i class="bx bx-search"></i>
        </div>
        <div class="profile-details">
          <!--<img src="images/profile.jpg" alt="">-->
          <span class="admin_name">Admin</span>
          <i class="bx bx-chevron-down"></i>
        </div>
      </nav>

      <div class="home-content">
        <div class="row p-3">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-6">
                <form method="post" action="" class="card p-3 shadow">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <h3>Modifier un article</h3>
                      <a href="index.php?p=article" class="btn btn-primary">Retour</a>
                    </div>
                    <div class="form-floating mb-3 rounded">
                        <input type="text" value="<?= $article->nom_article ?>" name="article" id="article" class="form-control" placeholder="Entrez le nom de l'article">
                        <label for="article">Entrez le nom de l'article</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select name="categorie" id="categorie" class="form-select">
                            <option value="<?= $article->id_categorie ?>" selected>---Choississez une catégorie---</option>
                            <?php foreach($categories as $categorie): ?>
                              <option value="<?= $categorie->id ?>"><?= $categorie->libelle_categorie ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="categorie">Choississez une catégorie</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" value="<?= $article->quantite ?>" name="quantite" id="quantite" class="form-control" placeholder="Entrez la quantité">
                        <label for="quantite">Entrez la quantité</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" value="<?= $article->prix_unitaire ?>" name="prixUnitaire" id="prixUnitaire" class="form-control" placeholder="Entrez le prix unitaire">
                        <label for="prixUnitaire">Entrez le prix unitaire</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" value="<?= $article->date_fabrication ?>" name="dateFabrication" id="dateFabrication" class="form-control">
                        <label for="dateFabrication">Date de fabrication</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" value="<?= $article->date_expiration ?>" name="dateExpiration" id="dateExpiration" class="form-control">
                        <label for="dateExpiration">Date d'expiration</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="file" value="<?= $article->images ?>" name="image" id="image" class="form-control">
                        <label for="image">Choississez l'image</label>
                    </div>
                    <button type="submit" name="modifier" class="btn btn-primary">Modifier</button>
                </form>
            </div>
            <div class="col-sm-3">-+
            </div>
        </div>
      </div>
    </section>

    <script>
      let sidebar = document.querySelector(".sidebar");
      let sidebarBtn = document.querySelector(".sidebarBtn");
      sidebarBtn.onclick = function () {
        sidebar.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
          sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
      };
    </script>
  </body>
</html>
