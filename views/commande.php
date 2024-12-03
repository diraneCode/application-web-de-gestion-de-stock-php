<?php

  $db = Database::Connect();
  $query = $db->query("SELECT c.*, a.id AS id_article, a.nom_article, clt.nom FROM commande c INNER JOIN client clt ON clt.id = c.id_client INNER JOIN article a ON a.id = c.id_article");
  $commandes = $query->fetchAll(PDO::FETCH_OBJ);

  $reqArticle = $db->query("SELECT * FROM article");
  $articles = $reqArticle->fetchAll(PDO::FETCH_OBJ);

  $reqClient = $db->query("SELECT * FROM client");
  $clients = $reqClient->fetchAll(PDO::FETCH_OBJ);

  if(isset($_POST['valider'])){
    $article = $_POST['article'];
    $client = $_POST['client'];
    $quantite = $_POST['quantite'];
    $prix = $_POST['prix'];


    

    $nbStock = $db->query("SELECT quantite FROM article WHERE id = ". $article);
    $nbStockResult = $nbStock->fetch(PDO::FETCH_OBJ);

    $newStock = ($nbStockResult->quantite - $quantite);

    if($quantite > $nbStockResult->quantite){
      echo "
            <div class='alert alert-danger'>
              La quantité demandée n'est pas disponible
            </div>
          ";
    }else{
      $requete2 = $db->query("UPDATE article SET quantite = ". $newStock ." WHERE id = ".$article);
      $requete = $db->prepare("INSERT INTO commande(id_article, id_client, quantite, prix) VALUES(?, ?, ?, ?)");
      $requete->execute(array($article, $client, $quantite, $prix));
      header('location: index.php?p=commande');
      
    }
  }


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
          <a href="index.php?p=commande"  class="active">
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
            <div class="col-sm-4">
                <form method="post" action="" class="card p-3 shadow">
                  <h3>Ajouter commande</h3>
                    <div class="form-floating mb-3">
                        <select onchange="setPrix()" id="article" name="article" class="form-select" required>
                            <?php foreach($articles as $article): ?>
                              <option data-prix="<?= $article->prix_unitaire ?>" value="<?= $article->id ?>"><?= $article->nom_article ?> - <?= $article->quantite ?> disponibles</option>
                            <?php endforeach; ?>
                        </select>
                        <label for="article">Sélectionner l'article</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select id="client" name="client" class="form-select" required>
                            <?php foreach($clients as $clt): ?>
                              <option value="<?= $clt->id ?>"><?= $clt->nom ?></option>
                            <?php endforeach; ?>
                        </select>
                        <label for="client">Sélectionner le client</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number"  onkeyup="setPrix()" name="quantite" class="form-control" id="quantite" placeholder="Entrez la quantite" required>
                        <label for="quantite">Entrez la quantite</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" name="prix" class="form-control" id="prix" placeholder="Entrez le prix" readonly require>
                        <label for="prix">Entrez le prix</label>
                    </div>
                    <button type="submit" name="valider" class="btn btn-primary">Valider</button>
                </form>
            </div>
            <!-- <div class="col-sm-1 col-md-1"></div> -->
            <div class="col-sm-6 col-md-8">
                <div class="card p-3 shadow">
                    <table class="table table-hover table-sm table-striped table-bordered">
                        <thead>
                            <th>Article</th>
                            <th>Client</th>
                            <th>Quantité</th>
                            <th>Prix</th>
                            <th>Date et Heure</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                          <?php foreach($commandes as $cmd): ?>
                            <tr>
                              <td><?= $cmd->nom_article ?></td>
                              <td><?= $cmd->nom ?></td>
                              <td><?= $cmd->quantite ?></td>
                              <td><?= $cmd->prix ?></td>
                              <td><?= $cmd->date_commande  ?></td>
                              <td>
                                    <!-- <button class="btn btn-primary">Facture</button> -->
                                    <button type="button" onclick="annuleCommande(<?= $cmd->id ?>,<?= $cmd->id_article ?>, <?= $cmd->quantite ?>)" class="btn btn-danger btn-sm">Annuler</button>
                                </td>
                              </tr>
                            <?php endforeach; ?>
                        </tbody>
                      </table>
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

      function annuleCommande(idCommande, idArticle, quantite){
        if(confirm("Voulez-vous annuler cette commande ?")){
          window.location.href = "index.php?p=annuleCmd&cmd="+idCommande+"&art="+idArticle+"&qte="+quantite;
        }
      }

      function setPrix(){
        let article = document.querySelector('#article')
        let prix = document.querySelector('#prix');
        let quantite = document.querySelector('#quantite').value

        let prixUnitaire = article.options[article.selectedIndex].getAttribute('data-prix')
        prix.value = prixUnitaire * quantite
      }
    </script>
  </body>
</html>
