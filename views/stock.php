<?php
  $db = Database::Connect();
  $query = $db->query("SELECT s.*, a.nom_article, a.id_categorie, a.prix_unitaire, a.quantite, c.libelle_categorie FROM stock s INNER JOIN article a ON a.id = s.id_article INNER JOIN categorie_article c ON c.id = a.id_categorie");
  $stock = $query->fetchAll(PDO::FETCH_OBJ);

  $query2 = $db->query("SELECT * FROM article");
  $articles = $query2->fetchAll(PDO::FETCH_OBJ);

  if(isset($_POST['nouveau'])){
    $id_article = $_POST['id_article'];
    $quantite = $_POST['quantite'];
    $date_expiration = $_POST['date_expiration'];
    
    $query3 = $db->prepare("INSERT INTO stock(id_article, quantite_stock, date_expiration_stock) VALUES(?, ?, ?)");
    $query3->execute(array($id_article, $quantite, $date_expiration));
    header('location: index.php?p=stock');

  }

  if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query4 = $db->query("SELECT libelle_categorie, quantite, prix_unitaire FROM article a INNER JOIN categorie_article c ON c.id = a.id_categorie WHERE a.id = ".$id);
    $articleInfo = $query4->fetch(PDO::FETCH_OBJ);
  }

?>


<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./public/style.css" />
    <link rel="stylesheet" href="./public/stockEpuiser.css" />
    <link rel="stylesheet" href="./public/bootstrap/css/bootstrap.min.css">
    <!-- Boxicons CDN Link -->
    <link
      href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
      rel="stylesheet"
    />
    <script src="./public/app.js" defer></script>
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
          <a href="index.php?p=article">
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
          <a href="index.php?p=stock"  class="active">
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
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="card p-3 shadow">
                  <form method="post" action="">
                    <table class="table table-hover table-sm table-striped table-bordered">
                        <thead>
                            <th>Nom article</th>
                            <th>Catégorie</th>
                            <th>Quantité</th>
                            <th>Prix Unitaire</th>
                            <th>Date Expiration</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                  <select id="articles" onchange="changerArticle()" name="id_article" class="form-select" required>
                                  <option>---Sélectionner un article---</option>
                                    <?php foreach($articles as $article): ?>
                                      <?php if(isset($_GET['id']) && $_GET['id'] == $article->id): ?>
                                        <option value="<?= $article->id ?>" selected><?= $article->nom_article ?></option>
                                      <?php else: ?>
                                        <option value="<?= $article->id ?>"><?= $article->nom_article ?></option>
                                      <?php endif; ?>
                                    <?php endforeach; ?>
                                  </select>
                                </td>
                                <?php if(isset($articleInfo)): ?>
                                  <td>
                                    <input type="text" readonly value="<?= $articleInfo->libelle_categorie ?>" class="form-control">
                                  </td>
                                  <td>
                                    <input type="number" maxlength="10" value="<?= $articleInfo->quantite ?>" name="quantite" class="form-control" placeholder="Saisir la quantité" readonly>
                                  </td>
                                  <td>
                                    <input type="number" name="prix" class="form-control" value="<?= $articleInfo->prix_unitaire ?>" readonly>
                                  </td>
                                  <?php else: ?>
                                    <td>
                                      <input type="text" readonly value="" class="form-control">
                                    </td>
                                    <td>
                                        <input type="number" value="" name="quantite" class="form-control" placeholder="Saisir la quantité">
                                    </td>
                                    <td>
                                        <input type="number" name="prix" class="form-control" value="" readonly>
                                    </td>
                                <?php endif ?>
                                <td>
                                    <input type="date" name="date_expiration" class="form-control" required>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="submit" name="nouveau" class="btn btn-primary w-100">Nouveau stock</button>
                  </form>
                    <table class="table table-hover table-striped table-bordered table-sm mt-3">
                        <thead>
                          <th>Nom article</th>
                          <th>Catégorie</th>
                          <th>Quantité</th>
                          <th>Prix Unitaire</th>
                          <th>Date d'ajout</th>
                          <th>Date Expiration</th>
                          <th>Status</th>
                          <th>Action</th>
                        </thead>
                        <tbody>
                          <?php foreach($stock as $stk): ?>
                            <tr>
                              <td><?= $stk->nom_article ?></td>
                              <td><?= $stk->libelle_categorie ?></td>
                              <td><?= $stk->quantite_stock ?></td>
                              <td><?= $stk->prix_unitaire ?></td>
                              <td><?= $stk->date_ajout?></td>
                              <td><?= $stk->date_expiration_stock ?></td>
                              <td>Epuisé</td>
                              <td>
                                <button type="button" data-id="<?= $stk->id ?>" class="btn btn-primary btn-sm btn-modifier">Modifier</button>
                                <a href="index.php?p=deleteStock&id=<?= $stk->id ?>" class="btn btn-danger btn-sm">Supprimer</a>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                    </table>
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled"><a href="#" class="page-link">&laquo;</a></li>
                        <li class="page-item active"><a href="#" class="page-link">1</a></li>
                        <li class="page-item"><a href="#" class="page-link">2</a></li>
                        <li class="page-item"><a href="#" class="page-link">3</a></li>
                        <li class="page-item disabled"><a href="#" class="page-link">&raquo;</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-1"></div>
        </div>
      </div>
    </section>
    <form action="models/updateStock.php" class="formUpdate">
      <div class="card shadow p-3">
        <input type="hidden" name="idStock" id="stockID">
        <div class="d-flex justify-content-between align-items-center">
          <h5>Augmenter le stock</h5>
          <button type="button" class="btn btn-danger btn-sm">X</button>
        </div>
        <div class="form-floating mb-3 mt-3">
          <input type="number" name="quantite" class="form-control" placeholder="Entrez la quantité" required>
          <label for="">Entrez la quantité</label>
        </div>
        <button href="" type="submit"  class="btn btn-primary w-100">Modifier</button>
      </div>
    </form>

    <script>
      let sidebar = document.querySelector(".sidebar");
      let sidebarBtn = document.querySelector(".sidebarBtn");
      sidebarBtn.onclick = function () {
        sidebar.classList.toggle("active");
        if (sidebar.classList.contains("active")) {
          sidebarBtn.classList.replace("bx-menu", "bx-menu-alt-right");
        } else sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
      };

      function changerArticle(){
        let articles = document.querySelector('#articles');
        let id = articles.options[articles.selectedIndex].value;
        if(parseInt(id)){
          window.location.href = 'index.php?p=stock&id='+id;
        }
      }
    </script>
  </body>
</html>
