<?php

  $db = Database::Connect();

  $query1 = $db->query("SELECT v.*, a.nom_article, c.nom FROM vente v INNER JOIN article a ON a.id = v.id_article INNER JOIN client c ON c.id = v.id_client LIMIT 5");
  $ventes = $query1->fetchAll(PDO::FETCH_OBJ);

  $query2 = $db->query("SELECT v.id_client, c.nom, c.telephone FROM vente v INNER JOIN client c ON c.id = v.id_client");
  $client = $query2->fetchAll(PDO::FETCH_OBJ);

  $query3 = $db->query("SELECT count(*) FROM commande");
  $nbCommande = $query3->fetch();

  $query4 = $db->query("SELECT count(*) FROM vente");
  $nbVente = $query4->fetch();

  $query5 = $db->query("SELECT SUM(prix) FROM vente");
  $totalVente = $query5->fetch();

  $query6 = $db->query("SELECT SUM(prix) FROM commande");
  $totalCommande = $query6->fetch();

  $query7 = $db->query("SELECT count(*) FROM article");
  $nbArticle = $query7->fetch();

  $query8 = $db->query("SELECT count(*) FROM client");
  $nbClient = $query8->fetch();

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
          <a href="index.php?p=dashboard" class="active">
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
        <div class="overview-boxes">
          <div class="box">
            <div class="right-side">
              <div class="box-topic">Commande</div>
              <?php if($totalCommande[0] == 0): ?>
                <div class="number">0 F</div>
              <?php else: ?>
                <div class="number"><?= $totalCommande[0] ?> F</div>
              <?php endif; ?>
              <div class="indicator">
                <i class="bx bx-up-arrow-alt"></i>
                <span class="text"><?= $nbCommande[0] ?> commandes</span>
              </div>
            </div>
            <i class="bx bx-cart-alt cart"></i>
          </div>
          <div class="box">
            <div class="right-side">
              <div class="box-topic">Vente</div>
              <?php if($totalCommande[0] == 0): ?>
                <div class="number">0 F</div>
              <?php else: ?>
                  <div class="number"><?= $totalVente[0] ?> F</div>
              <?php endif; ?>
              <div class="indicator">
                <i class="bx bx-up-arrow-alt"></i>
                <span class="text"><?= $nbVente[0] ?> ventes</span>
              </div>
            </div>
            <i class="bx bxs-cart-add cart two"></i>
          </div>
          <div class="box">
            <div class="right-side">
              <div class="box-topic">Client</div>
              <div class="number"><?= $nbClient[0] ?></div>
              <div class="indicator">
                <i class="bx bx-up-arrow-alt"></i>
                <span class="text"><?= $nbClient[0] ?> clients</span>
              </div>
            </div>
            <i class="bx bx-cart cart three"></i>
          </div>
          <div class="box">
            <div class="right-side">
              <div class="box-topic">Article</div>
              <div class="number"><?= $nbArticle[0] ?></div>
              <div class="indicator">
                <i class="bx bx-down-arrow-alt down"></i>
                <span class="text"><?= $nbArticle[0] ?> articles</span>
              </div>
            </div>
            <i class="bx bxs-cart-download cart four"></i>
          </div>
        </div>

        <div class="row p-3">
          <div class="col-sm-8">
            <div class="card shadow p-3">
              <caption>Ventes Récentes</caption>
              <table class="table table-sm table-hover">
                <thead>
                  <th>Article</th>
                  <th>Client</th>
                  <th>Quantité</th>
                  <th>Prix</th>
                </thead>
                <tbody>
                  <?php foreach($ventes as $vte): ?>
                    <tr>
                      <td><?= $vte->nom_article ?></td>
                      <td><?= $vte->nom ?></td>
                      <td><?= $vte->quantite ?></td>
                      <td><?= $vte->prix ?> F CFA</td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <a href="index.php?p=vente" class="btn btn-primary btn-sm w-25">Tout voir</a>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="card shadow p-3">
              <caption>Meilleur client</caption>
              <table class="table table-sm table-hover">
                <thead>
                  <th>Client</th>
                  <th>Téléphone</th>
                </thead>
                <tbody>
                  <?php foreach($client as $clt): ?>
                    <tr>
                      <td><?= $clt->nom ?></td>
                      <td><?= $clt->telephone ?></td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <a href="index.php?p=client" class="btn btn-primary btn-sm w-25">Tout voir</a>
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
