<?php 

	$message = "";
	$id = -1;

	@$getId = $_GET['id'];
	$id = isset($getId) && $getId != '' ? $getId : $id;

	@$postId = $_POST['id'];
	$id = isset($postId) && $postId != '' ? $postId : $id;

	if(isset($_POST['terminer']) && $_POST['terminer'] == 'ok') {
		try {
			$params = getQueryParams($table_columns);
			if($params != null) {
				if($id == -1) {
					$command = $connection->prepare(getInsertQuery($table_name, $table_columns));
					if($command->execute($params)) {
						$message = "<h4 class='text-success'><i class='material-icons'>checkmark</i> Enregistrement effectué</h4>";
					}else {
						throw new Exception("Ereur d'enregistrement !", 1);
					}
					$id = $connection->lastInsertId();
				}else {
					$command = $connection->prepare(getUpdateQuery($table_name, $table_columns));
					array_push($params, $id);
					if($command->execute($params)) {
						$message = "<h4 class='text-success'><i class='material-icons'>checkmark</i> Modifications effectuées</h4>";
					}else {
						throw new Exception("Ereur de modification !", 1);
					}
				}
			}
		}catch(Exception $e) {
			$message = "<h4 class='text-danger'><i class='material-icons'>clear</i>".$e->getMessage()."</h4>";
		}
	}else {
		if($id!=-1) {
			$response = $connection->query(getSelectQuery($id));
			if($donnees = $response->fetch()) {
				foreach ($donnees as $key => $value) {
					$_POST[strtolower($key)] = $value;
				}
			}else {
				$message = "<h4 class='text-danger'><i class='material-icons'>clear</i> Impossible d'accéder à la ressource !</h4>";
			}
		}
	}

 ?>