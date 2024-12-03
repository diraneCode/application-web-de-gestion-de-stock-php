<?php
  session_start();
  require './class/Database.php';

  if(isset($_GET['p'])){
    $p = $_GET['p'];
  }else{
    $p = 'dashboard';
  }

if(isset($_SESSION['id'])){
  if($p === 'dashboard'){

    $title = 'Dashboard';
    require './views/dashboard.php';
  }elseif($p === 'article'){

    $title = 'Articles';
    require './views/article.php';
  }elseif($p === 'categorie'){

    $title = 'Catégorie';
    require './views/categorie.php';
  }elseif($p === 'client'){

    $title = 'Client';
    require './views/client.php';
  }elseif($p === 'commande'){

    $title = 'Commande';
    require './views/commande.php';
  }elseif($p === 'stock'){

    $title = 'Stock';
    require './views/stock.php';
  }elseif($p === 'vente'){

    $title = 'Vente';
    require './views/vente.php';
  }elseif($p === 'deleteArticle'){

    $title = 'Supprimer article';
    require './views/deleteArticle.php';
  }elseif($p === 'deleteCategorie'){

    $title = 'Supprimer catégorie';
    require './views/deleteCategorie.php';
  }elseif($p === 'deleteClient'){

    $title = 'Supprimer client';
    require './views/deleteClient.php';
  }elseif($p === 'deleteVente'){

    $title = 'Supprimer vente';
    require './views/deleteVente.php';
  }elseif($p === 'modifierArticle'){

    $title = 'Modifier article';
    require './views/modifierArticle.php';
  }elseif($p === 'modifierCategorie'){

    $title = 'Modifier catégorie';
    require './views/modifierCategorie.php';
  }elseif($p === 'modifierClient'){

    $title = 'Modifier client';
    require './views/modifierClient.php';
  }elseif($p === 'factureVente'){

    $title = 'Modifier vente';
    require './views/factureVente.php';
  }elseif($p === 'login'){

    $title = 'Modifier login';
    require './views/login.php';
  }elseif($p === 'deconnexion'){
    session_destroy();
    header('location: index.php?p=login');
  }
  elseif($p === 'annuleCmd'){
    if(isset($_GET['cmd']) && isset($_GET['art']) && isset($_GET['qte'])){
      $db = Database::Connect();
      $idCommande = $_GET['cmd'];
      $idArticle = $_GET['art'];
      $quantite = $_GET['qte'];
      $req1 = $db->query("SELECT quantite FROM article WHERE id = ". $idArticle);
      $qte = $req1->fetch(PDO::FETCH_OBJ);
      $req2 = $db->query("UPDATE article SET quantite = ". $qte->quantite + $quantite ." WHERE id = ".$idArticle);
      $requete = $db->query("DELETE FROM commande WHERE id = ". $idCommande);
      header('location: index.php?p=commande');
    }
  }elseif($p === 'imprimer'){

    $title = 'Imprimer';
    require './views/imprimerFacture.php';
  }elseif($p === 'fournisseur'){

    $title = 'Fournisseur';
    require './views/fournisseur.php';
  }elseif($p === 'deletefournisseur'){

    $title = 'Supprimer un fournisseur';
    require './views/deletefournisseur.php';
  }elseif($p === 'deleteStock'){

    $title = 'Supprimer Stock';
    require './views/deleteStock.php';
  }
  else{

    $title = 'Connexion';
    require './views/login.php';
  }

  $query1 = Database::Connect()->query("SELECT id, quantite_stock FROM stock");
  $stockEpuiser = $query1->fetchAll(PDO::FETCH_OBJ);

  foreach ($stockEpuiser as $stk) {
    if($stk->quantite_stock < 10){
      $re = Database::Connect()->query("UPDATE stock SET status = 'epuiser' WHERE id = ".$stk->id);
    }else{
      $re = Database::Connect()->query("UPDATE stock SET status = 'normal' WHERE id = ".$stk->id);
    }
  }

  $query = Database::Connect()->query("SELECT nom_article FROM stock s INNER JOIN article a ON a.id = s.id_article WHERE status = 'epuiser'");
  $stockEpuiser = $query->fetchAll(PDO::FETCH_OBJ);
  foreach($stockEpuiser as $stk){
    echo '<div class="stock alert alert-warning w-25">
              <p>Vos stock sont presque épuisés <a href="index.php?p=stock">cliquer ici pour recharger</a></p>
          </div>';
  }
}else{
  require './views/login.php';
}
