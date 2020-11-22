<?php 
	
	function getInsertQuery($table_name, $table_columns) {
		$query =  "INSERT INTO $table_name(";
		foreach ($table_columns as $key => $column)
			$query .= $column . ($key < count($table_columns)-1 ? ',' : ') VALUES(');
		foreach ($table_columns as $key => $column)
			$query .= ($key < count($table_columns)-1 ? '?,' : '?)');
		return $query;
	}

	function getUpdateQuery($table_name, $table_columns) {
		$query =  "UPDATE $table_name SET ";
		foreach ($table_columns as $key => $column)
			$query .= $column .'=?'. ($key < count($table_columns)-1 ? ',' : ' WHERE id=?');
		return $query;
	}

	function getSelectQuery($id) {
		global $table_name;
		return "SELECT * FROM $table_name WHERE id=$id LIMIT 1";
	}

	function getQueryParams($table_columns) {
		$params = array();
		foreach ($table_columns as $key => $column) {
			$posted_value = isset($_POST[strtolower($column)]) ? $_POST[strtolower($column)] : '';
			array_push($params, $posted_value);
		}
		return $params;
	}

	function getChildRows($connection, $table_name, $foreign_key_name, $id) {
		$child_rows = array();
		$response = $connection->query("SELECT * FROM ".$table_name." WHERE ".$foreign_key_name." = ".$id);
		while ($donnees = $response->fetch()) {
			array_push($child_rows, $donnees);
		}
		return $child_rows;
	}

	function getParentRow($connection, $table_name, $parent_id) {
		$parent_row = null;
		$response = $connection->query("SELECT * FROM ".$table_name." WHERE id=".$parent_id);
		if($donnees = $response->fetch()) {
			$parent_row = $donnees;
		}
		return $parent_row;
	}

	function getAllRows($connection, $table_name) {
		$response = $connection->query("SELECT * FROM ".$table_name);
		$rows = [];
		while ($donnees = $response->fetch()) {
			array_push($rows, $donnees);
		}
		return $rows;
	}

	function getAllRowsWhere($connection, $table_name, $where) {
		$response = $connection->query("SELECT * FROM ".$table_name." WHERE ".$where);
		$rows = [];
		while ($donnees = $response->fetch()) {
			array_push($rows, $donnees);
		}
		return $rows;
	}

 ?>