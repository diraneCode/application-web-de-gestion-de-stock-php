<?php

  $db = Database::Connect();
  $query = $db->query("SELECT * FROM categorie_article");
  $categories = $query->fetchAll(PDO::FETCH_OBJ);

  if(isset($_GET['nom'])){
    $nom = $_GET['nom'];
    
    $requete = $db->prepare('SELECT v.*, a.nom_article, a.prix_unitaire FROM vente v INNER JOIN article a ON a.id = v.id_article WHERE v.nom_vente = ?');
    $requete->execute(array($nom));
    $ventes = $requete->fetchAll(PDO::FETCH_OBJ);

    $requete = $db->query("SELECT * FROM client WHERE nom = '$nom'");
    $client = $requete->fetch(PDO::FETCH_OBJ);

    $total = 0;
    foreach ($ventes as $vte) {
      $total += $vte->prix;
    }

  }

?>


<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="UTF-8" />
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./public/style.css" />
    <link rel="stylesheet" href="./public/bootstrap/css/bootstrap.min.css">
    <!-- Boxicons CDN Link -->
    <link
      href="https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="./public/stockEpuiser.css" />
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
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="card shadow p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3>Gestion Stock</h3>
                        <span>Date: <?php echo date('d-m-Y'); ?></span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        De: COMPANY TIR-BOUCHON SARL <br>
                        Ville: DOUALA <br>
                        Email: admin@admin.com
                      </div>
                      <div>
                        A: <?= $client->prenom ?> <?= $client->nom ?> <br>
                        Ville: <?= $client->adresse ?> <br>
                        Téléphone: <?= $client->telephone ?>
                      </div>
                      <div>
                      Facture #006 <br>
                      Payé Le: <?= date('d/m/y') ?> <br>
                      Heure: <?= date('h:m:s') ?>
                      </div>
                    </div>
                    <hr>
                    <div class="p-4">
                      <table class="table table-hover table-striped table-bordered">
                        <thead>
                          <th>Désignation</th>
                          <th>Quantité</th>
                          <th>Prix Unitaire</th>
                          <th>Prix Total</th>
                        </thead>
                        <tbody>
                          <?php foreach($ventes as $vte): ?>
                            <tr>
                              <td><?= $vte->nom_article ?></td>
                              <td><?= $vte->quantite ?></td>
                              <td><?= $vte->prix_unitaire ?> F CFA</td>
                              <td><?= $vte->prix ?> F CFA</td>
                            </tr>
                          <?php endforeach; ?>
                        </tbody>
                      </table>
                    </div>
                    <div class="row">
                      <div class="col-sm-6">
                        <h3>Méthodes de paiement:</h3>
                        <div class="alert alert-info">
                          <span>Chèr(e) client, Notre entreprise vient juste de terminer votre facture vous devez le payer le <?= date('d-m-y') ?></span>
                        </div>
                      </div>
                      <div class="col-sm-1"></div>
                      <div class="col-sm-5">
                        <span>Infos Facture</span>
                        <table class="table table-bordered">
                          <tr>
                            <td>Total:</td>
                            <td><?= $total ?></td>
                          </tr>
                          <tr>
                            <td>Total:</td>
                            <td><?= $total ?> F CFA</td>
                          </tr>
                        </table>
                      </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                      <a href="index.php?p=imprimer&nom=<?= $nom ?>" target="_blank" class="btn btn-primary" >Imprimer</a>
                      <button class="btn btn-danger">Générer le pdf</button>
                    </div>
                </div>
            </div>
            <div class="col-sm-1"></div>
        </div>
        </div>
      </div>
    </section>