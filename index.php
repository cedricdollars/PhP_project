<?php 
	require 'config/config.php';
	require 'database/database.php';
	require 'generic/functions.php';

	@$page = $_GET['page'];
	if(isset($page) && file_exists('templates/'.$page.'.php')) {
		$page = 'templates/'.$page.'.php';
	}else {
		$page = 'templates/home.php';
	}

	$connection = DBManager::getConnection(
		$GLOBALS['db_server'], 
		$GLOBALS['db_name'],
		$GLOBALS['db_user'],
		$GLOBALS['db_password']
	);
 ?>
<!DOCTYPE html>
<html>
<head>
	<title><?php  ?></title>
	<meta charset="utf-8">
	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="libs/bootstrap/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="libs/bootstrap-material/dist/css/bootstrap-material-design.css">
	<link rel="stylesheet" type="text/css" href="libs/bootstrap-material/dist/css/ripples.min.css">
	
	<link href="libs/bootstrap-material/dist/css/snackbar.min.css" rel="stylesheet">

	<link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<div class="">
	<div class="navbar navbar-pills">
	  <div class="container">
	  	<div class="container-fluid">
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-inverse-collapse">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="index.php"><img src="img/logo.png" class="logo"></a>
	    </div>
	    <div class="navbar-collapse collapse navbar-inverse-collapse">
	      <ul class="nav navbar-nav">
	        <li class="dropdown">
	          <a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Fichier</a>
	          <ul class="dropdown-menu">
	            <li><a href="javascript:void(0)">Mon compte</a></li>
	            <li><a href="javascript:void(0)">Déconnection</a></li>
	          </ul>
	        </li>
	        <li class="dropdown">
	          <a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Edition</a>
	          <ul class="dropdown-menu">
	            <li><a href="?page=list_fournisseurs">Fournisseurs</a></li>
	            <li><a href="?page=edit_maladie">Maladies</a></li>
	            <li><a href="?page=list_pays">Pays</a></li>
	          </ul>
	        </li>

	        <li class="dropdown">
	          <a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Types produits</a>
	          <ul class="dropdown-menu">
	            <li><a href="?page=edit_type_produit">Ajouter</a></li>
	            <li><a href="?page=list_type_produits">Liste</a></li>
	          </ul>
	        </li>

	        <li class="dropdown">
	          <a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Poduits</a>
	          <ul class="dropdown-menu">
	            <li><a href="?page=edit_produit">Ajouter</a></li>
	            <li><a href="?page=list_produits">Liste</a></li>
	          </ul>
	        </li>

	        <li class="dropdown">
	          <a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Stocks</a>
	          <ul class="dropdown-menu">
	            <li><a href="javascript:void(0)">Ajouter</a></li>
	            <li><a href="javascript:void(0)">Liste</a></li>
	          </ul>
	        </li>

	        <li class="dropdown">
	          <a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Ventes</a>
	          <ul class="dropdown-menu">
	            <li><a href="javascript:void(0)">Ajouter</a></li>
	            <li><a href="javascript:void(0)">Liste</a></li>
	          </ul>
	        </li>

	        <li class="dropdown">
	          <a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Clients</a>
	          <ul class="dropdown-menu">
	            <li><a href="javascript:void(0)">Ajouter</a></li>
	            <li><a href="javascript:void(0)">Liste</a></li>
	          </ul>
	        </li>

	        <li class="dropdown">
	          <a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Commandes</a>
	          <ul class="dropdown-menu">
	            <li><a href="javascript:void(0)">Ajouter</a></li>
	            <li><a href="javascript:void(0)">Liste</a></li>
	          </ul>
	        </li>
	      </ul>
	    </div>
	  </div>
	</div>
	</div>
	<div class="backdrop"></div>

	<div class="header-back">
		<div class="container title-container">
			<h2 class="title" id="title">Gestion des achats et ventes</h2>
		</div>
		<div class="container main-container">
			<?php include $page; ?>
		</div>
		</div>
	</div>
</div>
</body>

	<script type="text/javascript" src="libs/jquery/jquery.js"></script>
	<script type="text/javascript" src="libs/bootstrap/bootstrap.js"></script>
	<script type="text/javascript" src="libs/bootstrap-material/dist/js/ripples.min.js"></script>
	<script type="text/javascript" src="libs/bootstrap-material/dist/js/material.min.js"></script>

	<script type="text/javascript">
		$(function(){
			$.material.init();
		})
	</script>
</html>