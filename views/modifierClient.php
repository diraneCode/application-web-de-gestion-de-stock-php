<?php

    $db = Database::Connect();

    if(isset($_GET['id'])){
      $id = $_GET['id'];

      $query = $db->query("SELECT * FROM client WHERE id = ". $id);
      $client = $query->fetch(PDO::FETCH_OBJ);

      if(isset($_POST['modifier'])){
          $nom = $_POST['nom'];
          $prenom = $_POST['prenom'];
          $telephone = $_POST['telephone'];
          $adresse = $_POST['adresse'];

          $requete = $db->prepare("UPDATE client SET nom = ?, prenom = ?, telephone = ?, adresse = ? WHERE id = ". $id);
          $requete->execute(array($nom, $prenom, $telephone, $adresse));

          header('location: index.php?p=client');
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
          <a href="index.php?p=client" class="active">
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
                      <h3>Modifier un client</h3>
                      <a href="index.php?p=client" class="btn btn-primary">Retour</a>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" value="<?= $client->nom ?>" name="nom" class="form-control" id="nom" placeholder="Entrez le nom" required>
                        <label for="nom">Entrez le nom</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" value="<?= $client->prenom ?>" name="prenom" class="form-control" id="prenom" placeholder="Entrez le prenom" required>
                        <label for="prenom">Entrez le prenom</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="number" value="<?= $client->telephone ?>" name="telephone" class="form-control" id="telephone" placeholder="Entrez le numéro de téléphone" required>
                        <label for="telephone">Entrez le numéro de téléphone</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" value="<?= $client->adresse ?>" name="adresse" class="form-control" id="adresse" placeholder="Entrez l'adresse" required>
                        <label for="adresse">Entrez l'adresse</label>
                    </div>
                    <button type="submit" name="modifier" class="btn btn-primary">Modifier</button>
                </form>
            </div>
            <div class="col-sm-3">
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
