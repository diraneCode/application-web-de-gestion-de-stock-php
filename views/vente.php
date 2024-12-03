<?php

  $db = Database::Connect();
  $query = $db->query("SELECT v.*, c.nom, a.nom_article FROM vente v INNER JOIN client c ON c.id = v.id_client INNER JOIN article a ON a.id = v.id_article");
  $ventes = $query->fetchAll(PDO::FETCH_OBJ);

  $queryArticle = $db->query("SELECT * FROM stock s INNER JOIN article a ON a.id = s.id_article");
  $articles = $queryArticle->fetchAll(PDO::FETCH_OBJ);

  $queryClient = $db->query("SELECT * FROM client");
  $clients = $queryClient->fetchAll(PDO::FETCH_OBJ);

  if(isset($_POST['vendre'])){
    $article = $_POST['article'];
    $client = $_POST['client'];
    $quantite = $_POST['quantite'];
    $prix = $_POST['prix'];

    $nbStock = $db->query("SELECT quantite_stock FROM stock WHERE id_article = ". $article);
    $nbStockResult = $nbStock->fetch(PDO::FETCH_OBJ);

    if((int)$nbStockResult->quantite_stock >= $quantite){
      $requete = $db->prepare("INSERT INTO vente(id_article, id_client, quantite, prix) VALUES( ?, ?, ?, ?)");
      $requete->execute(array($article, $client, $quantite, $prix));
      
      $newStock = ($nbStockResult->quantite_stock - $quantite);
      $requete2 = $db->prepare("UPDATE article SET quantite = ? WHERE id = ".$article);
      $requete2->execute(array($newStock));
      header('location: index.php?p=vente');
    }else{
      echo "
            <div class='alert alert-danger position-absolute'>
              La quantité demandée n'est pas disponible
            </div>
          ";
    }


  }

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
          <a href="index.php?p=stock">
            <i class="bx bx-user"></i>
            <span class="links_name">Stock</span>
          </a>
        </li>
        </li> 
        <li>
          <a href="index.php?p=vente" class="active">
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
            <div class="col-sm-4">
                <form method="post" action="" class="card p-3 shadow">
                    <h3>Vendre un article</h3>
                    <div class="form-floating mb-3">
                        <select onchange="setPrix()" name="article" id="article" class="form-select">
                            <?php foreach($articles as $article): ?>
                              <option value="<?= $article->id ?>" data-prix="<?=$article->prix_unitaire ?>"><?= $article->nom_article ?> - <?= $article->quantite ?> disponibles</option>
                            <?php endforeach; ?>
                        </select>
                        <label for="article">Choisis un article</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select name="client" id="client" class="form-select">
                            <?php foreach($clients as $client): ?>
                              <option value="<?= $client->id ?>"><?= $client->nom ?></option>
                            <?php endforeach; ?>
                            </select>
                        <label for="client">Choisis un client</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" onkeyup="setPrix()" name="quantite" id="quantite" class="form-control" placeholder="Entrez la quantité" required>
                        <label for="quantite">Entrez la quantité</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" name="prix" readonly id="prix" class="form-control" placeholder="Entrez le prix">
                        <label for="prix">Entrez le prix</label>
                    </div>
                    <button type="submit" name="vendre" class="btn btn-primary">Vendre</button>
                </form>
            </div>
            <div class="col-sm-8">
                <div class="card p-3 shadow">
                    <table class="table table-striped table-bordered table-hover table-sm bg-white">
                        <thead>
                            <th>Article</th>
                            <th>Client</th>
                            <th>Quantité</th>
                            <th>Prix</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                          <?php foreach($ventes as $vente): ?>
                            <tr>
                                <td><?= $vente->nom_article ?></td>
                                <td><?= $vente->nom ?></td>
                                <td><?= $vente->quantite ?></td>
                                <td><?= $vente->prix ?></td>
                                <td><?= $vente->date_vente ?></td>
                                <td>
                                    <a href="index.php?p=factureVente&nom=<?= $vente->nom ?>" class="btn btn-primary btn-sm">Facture</a>
                                    <a href="index.php?p=deleteVente&id=<?= $vente->id ?>" class="btn btn-danger btn-sm">Supprimer</a>
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
      function setPrix(){
        let articles = document.querySelector('#article');
        let quantite = document.querySelector('#quantite').value;
        let prix = document.querySelector('#prix');

        prix.value = articles.options[articles.selectedIndex].getAttribute('data-prix') * quantite;
      }

      
    </script>
  </body>
</html>
