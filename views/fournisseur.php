<?php

    $db = Database::Connect();

    $query = $db->query("SELECT * FROM fournisseur");
    $fournisseur = $query->fetchAll(PDO::FETCH_OBJ);

    if(isset($_POST['ajouter'])){
        $nom = $_POST['nom'];
        $nom_entreprise = $_POST['nom_entreprise'];
        $numero = $_POST['numero'];
        $paiement = $_POST['paiement'];
        $produit = $_POST['produit'];
        $quantite = $_POST['quantite'];
        $prix = $_POST['prix'];
        $total = $_POST['montant'];

        $requete = $db->prepare("INSERT INTO fournisseur(nom, nom_entreprise, numero, condition_paiement, produit, quantite, prix, montant_total) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
        $requete->execute(array($nom, $nom_entreprise, $numero, $paiement, $produit, $quantite, $prix, $total));

        header('location: index.php?p=fournisseur');
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
                    <h3>Ajouter un fournisseur</h3>
                    <div class="form-floating mb-3 rounded">
                        <input type="text" name="nom" id="nom" class="form-control" placeholder="Entrez le nom du fournisseur" required>
                        <label for="nom">Entrez le nom du fournisseur</label>
                    </div>
                    <div class="form-floating mb-3 rounded">
                        <input type="text" name="nom_entreprise" id="nom_entreprise" class="form-control" placeholder="Entrez le nom de l'entreprise" required>
                        <label for="nom_entreprise">Entrez le nom de l'entreprise</label>
                    </div>
                    <div class="form-floating mb-3 rounded">
                        <input type="text" name="numero" id="numero" class="form-control" placeholder="Entrez le numéro du fournisseur" required>
                        <label for="numero">Entrez le numéro du fournisseur</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select name="paiement" id="paiement" class="form-select" required>
                            <option value="Paiement à la livraison">Paiement à la livraison</option>
                            <option value="Paiement anticipé">Paiement anticipé</option>
                            <option value="Net 30 jours">Net 30 jours</option>
                        </select>
                        <label for="paiement">Mode de paiement</label>
                    </div>
                    <div class="form-floating mb-3" required>
                        <input type="text" name="produit" id="produit" class="form-control" placeholder="Entrez le nom du produit" required>
                        <label for="produit">Entrez le nom du produit</label>
                    </div>
                    <div class="form-floating mb-3" required>
                        <input type="number" name="quantite" id="quantite" class="form-control" placeholder="Entrez la quantité" required>
                        <label for="quantite">Entrez la quantité</label>
                    </div>
                    <div class="form-floating mb-3" required>
                        <input type="text" name="prix" id="prix" class="form-control" placeholder="Entrez le prix unitaire" required>
                        <label for="prix">Entrez le prix unitaire</label>
                    </div>
                    <div class="form-floating mb-3" required>
                        <input type="text" name="montant" id="montant" class="form-control" placeholder="Montant total" readonly required>
                        <label for="montant">Montant total</label>
                    </div>
                    <button type="submit" name="ajouter" class="btn btn-primary">Ajouter</button>
                </form>
            </div>
            <div class="col-sm-8">
                <div class="card p-3 shadow">
                    <table class="table table-striped table-bordered table-hover table-sm">
                        <thead>
                            <th>Nom</th>
                            <th>Entreprise</th>
                            <th>Numéro</th>
                            <th>Condition paiement</th>
                            <th>Produits</th>
                            <th>Quantite</th>
                            <th>Total</th>
                            <!-- <th>Date Fabrication</th>
                            <th>Date Expiration</th> -->
                            <!-- <th>Image</th> -->
                            <th>Actions</th>
                        </thead>
                        <tbody>
                            <?php foreach($fournisseur as $fourni): ?>
                                <tr>
                                    <td><?= $fourni->nom ?></td>
                                    <td><?= $fourni->nom_entreprise ?></td>
                                    <td><?= $fourni->numero ?></td>
                                    <td><?= $fourni->condition_paiement ?></td>
                                    <td><?= $fourni->produit ?></td>
                                    <td><?= $fourni->quantite ?></td>
                                    <td><?= $fourni->montant_total ?></td>
                                    <td>
                                        <a href="index.php?p=deletefournisseur&id=<?= $fourni->id ?>" class="btn btn-danger btn-sm">Supprimer</button>
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
