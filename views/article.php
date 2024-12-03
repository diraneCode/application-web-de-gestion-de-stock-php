<?php

    $db = Database::Connect();

    $query = $db->query("SELECT * FROM categorie_article INNER JOIN article ON article.id_categorie = categorie_article.id");
    $articles = $query->fetchAll(PDO::FETCH_OBJ);

    if(isset($_POST['ajouter'])){
        $article = $_POST['article'];
        $categorie = $_POST['categorie'];
        $quantite = $_POST['quantite'];
        $prixUnitaire = $_POST['prixUnitaire'];
        $dateFabrication = $_POST['dateFabrication'];
        $dateExpiration = $_POST['dateExpiration'];

        $requete = $db->prepare("INSERT INTO article(nom_article, id_categorie, quantite, prix_unitaire, date_fabrication, date_expiration) VALUES(?, ?, ?, ?, ?, ?)");
        $requete->execute(array($article, $categorie, $quantite, $prixUnitaire, $dateFabrication, $dateExpiration));

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
    <link rel="stylesheet" href="./public/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./public/style.css" />
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
        <i class="bx bx-cube"></i>
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
            <i class="bx bx-duplicate"></i>
            <span class="links_name">Catégorie</span>
          </a>
        </li>
        <li>
          <a href="index.php?p=client">
            <i class="bx bx-user"></i>
            <span class="links_name">Client</span>
          </a>
        </li>
        <li>
          <a href="index.php?p=commande">
            <i class="bx bx-command"></i>
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
            <i class="bx bx-store"></i>
            <span class="links_name">Stock</span>
          </a>
        </li>
        </li> 
        <li>
          <a href="index.php?p=vente">
            <i class="bx bx-purchase-tag-alt"></i>
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
            <div class="col-sm-4">
                <form method="post" action="" class="card p-3 shadow">
                    <h3>Ajouter un article</h3>
                    <div class="form-floating mb-3 rounded">
                        <input type="text" name="article" id="article" class="form-control" placeholder="Entrez le nom de l'article" required>
                        <label for="article">Entrez le nom de l'article</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select name="categorie" id="categorie" class="form-select" required>
                            <?php foreach($categories as $categorie): ?>
                              <option value="<?= $categorie->id ?>"><?= $categorie->libelle_categorie ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="categorie">Choississez une catégorie</label>
                    </div>
                    <div class="form-floating mb-3" required>
                        <input type="number" name="quantite" id="quantite" class="form-control" placeholder="Entrez la quantité" required>
                        <label for="quantite">Entrez la quantité</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" name="prixUnitaire" id="prixUnitaire" class="form-control" placeholder="Entrez le prix unitaire" required>
                        <label for="prixUnitaire">Entrez le prix unitaire</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" name="dateFabrication" id="dateFabrication" class="form-control" required>
                        <label for="dateFabrication">Date de fabrication</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" name="dateExpiration" id="dateExpiration" class="form-control" required>
                        <label for="dateExpiration">Date d'expiration</label>
                    </div>
                    <button type="submit" name="ajouter" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
            <div class="col-sm-8">
                <div class="card p-3 shadow">
                    <table class="table table-striped table-bordered table-hover table-sm">
                        <thead>
                            <th>Article</th>
                            <th>Catégorie</th>
                            <th>Quantité</th>
                            <th>Prix Unitaire</th>
                            <!-- <th>Date Fabrication</th>
                            <th>Date Expiration</th> -->
                            <!-- <th>Image</th> -->
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            <?php foreach($articles as $article): ?>
                                <tr>
                                    <td><?= $article->nom_article ?></td>
                                    <td><?= $article->libelle_categorie ?></td>
                                    <td><?= $article->quantite ?></td>
                                    <td><?= $article->prix_unitaire ?> F CFA</td>
                                    <!-- <td><?= $article->date_fabrication ?></td>
                                    <td><?= $article->date_expiration ?></td> -->
                                    <!-- <td><?= $article->images ?></td> -->
                                    <td>
                                        <a href="index.php?p=modifierArticle&id=<?= $article->id ?>" class="btn btn-primary btn-sm">Modifier</a>
                                        <a href="index.php?p=deleteArticle&id=<?= $article->id ?>" class="btn btn-danger btn-sm">Supprimer</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled"><a href="#" class="page-link">&laquo</a></li>
                        <li class="page-item active"><a href="#" class="page-link">1</a></li>
                        <li class="page-item"><a href="#" class="page-link">2</a></li>
                        <li class="page-item"><a href="#" class="page-link">3</a></li>
                        <li class="page-item"><a href="#" class="page-link">4</a></li>
                        <li class="page-item disabled"><a href="#" class="page-link">&raquo</a></li>
                    </ul>
                </div>
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
