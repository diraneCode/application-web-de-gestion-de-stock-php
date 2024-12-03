<?php

  $db = Database::Connect();
  $query = $db->query("SELECT * FROM client");
  $clients = $query->fetchAll(PDO::FETCH_OBJ);

  if(isset($_POST['ajouter'])){
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];

    $requete = $db->prepare("INSERT INTO client(nom, prenom, telephone, adresse) VALUES(?, ?, ?, ?)");
    $requete->execute(array($nom, $prenom, $telephone, $adresse));

    header('location: index.php?p=client');
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
    <script src="./../public/bootstrap/js/bootstrap.min.js"></script>
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
          <a href="index.php?p=client" class="active">
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
                  <h3>Ajouter un client</h3>
                    <div class="form-floating mb-3">
                        <input type="text" name="nom" class="form-control" id="nom" placeholder="Entrez le nom" required>
                        <label for="nom">Entrez le nom</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="prenom" class="form-control" id="prenom" placeholder="Entrez le prenom" required>
                        <label for="prenom">Entrez le prenom</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" name="telephone" class="form-control" id="telephone" placeholder="Entrez le numéro de téléphone" required>
                        <label for="telephone">Entrez le numéro de téléphone</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="adresse" class="form-control" id="adresse" placeholder="Entrez l'adresse" required>
                        <label for="adresse">Entrez l'adresse</label>
                    </div>
                    <button type="submit" name="ajouter" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
            <!-- <div class="col-sm-2"></div> -->
            <div class="col-sm-8">
                <div class="card p-3 shadow">
                    <table class="table table-hover table-sm table-striped table-bordered">
                        <thead>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Téléphone</th>
                            <th>Adresse</th>
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            <?php foreach($clients as $client): ?>
                              <tr>
                                <td><?= $client->nom ?></td>
                                <td><?= $client->prenom ?></td>
                                <td><?= $client->telephone ?></td>
                                <td><?= $client->adresse ?></td>
                                <td>
                                    <a href="index.php?p=modifierClient&id=<?= $client->id ?>" class="btn btn-primary btn-sm">Modifier</a>
                                    <a href="index.php?p=deleteClient&id=<?= $client->id ?>" class="btn btn-danger btn-sm">Supprimer</a>
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
