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
    <section class="home-section">

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
                </div>
            </div>
            <div class="col-sm-1"></div>
        </div>
        </div>
      </div>
    </section>

      <script>
        window.onload = imprimer();
        function imprimer(){
            window.print()
        }
      </script>