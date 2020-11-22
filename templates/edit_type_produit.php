<?php 
	$page_name = 'edit_type_produit';

	$table_name = 'TYPE_PRODUIT';
	$table_columns = ['CODE', 'NOM', 'DESCRIPTION'];
	$table_label = 'type de produit';

	$parent_tables =[];
	$child_tables = [
		[
			'name'=>'PRODUIT',
			'label'=>'Produits', 
			'foreign_key'=>'ID_TYPE_PRODUIT', 
			'columns'=>['REFERENCE', 'LIBELLE', 'DESCRIPTION'], 
			'records' => [],
			'edit_page'=>'edit_produit',
			'list_page'=>'list_produits'
		]
	];

	require 'generic/edit_page.php';

	foreach ($child_tables as $key => $child_table) {
		$child_tables[$key]['records'] = getChildRows($connection, $child_table['name'], $child_table['foreign_key'], $id);
	}

	foreach ($parent_tables as $key => $parent_table) {
		if($id!=-1) {
			foreach ($parent_tables as $key1 => $parent_table) {
				if(isset($_POST[strtolower($parent_table['foreign_key'])])) {
					$parent_id = $_POST[strtolower($parent_table['foreign_key'])];
					$parent_table['record'] = getParentRow($connection, $parent_table['name'], $parent_id);
				}
			}
		}
		$parent_tables[$key]['list'] = getAllRows($connection, $parent_tables[$key]['name']);
	}

	$title = $id != -1 ? "'Modifier le $table_label (<span class=\'text-info\'>".$_POST['nom']."</span>)'" : "'Enregistrer un $table_label'";
?>

<script type="text/javascript">
	window.onload = function() {
		var title = <?php echo $title; ?>;
		document.getElementById('title').innerHTML= title;
	}
</script>
<div class="row">
	<div class="col-lg-4 col-md-5 col-sm-6">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Saisir les informations</h3>
			<?php if ($id != -1): ?>
				<a href="?page=<?php echo $page_name; ?>" class="btn btn-raised btn-default btn-new-item">Nouveau</a>
			<?php endif ?>
		</div>
		<div class="panel-body">
			<form method="POST" action="?page=<?php echo $page_name; ?>">
				<div class="message-container">
					<?php echo $message; ?>
				</div>
				<div class="inner-form">
					<input type="hidden" name="id" value="<?php echo $id; ?>">
					<div class="form-group label-floating">
						<label>Code</label>
						<input class="form-control" placeholder="Code" id="" type="text" name="code" required="required" value="<?php echo isset($_POST['code']) ? $_POST['code'] : ''; ?>">
						<p class="help-block">Représente le code du type de produits</p>
					</div>

					<div class="form-group label-floating">
						<label>Nom</label>
						<input class="form-control" placeholder="Nom" id="" type="text" name="nom" required="required" value="<?php echo isset($_POST['nom']) ? $_POST['nom'] : ''; ?>">
						<p class="help-block">Représente le nom du type de produits</p>
					</div>

					<div class="form-group label-floating">
						<label>Description</label>
						<textarea class="form-control" placeholder="Description" rows="3" id="textArea" name="description"><?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea>
						<span class="help-block">La description du type de produits</span>
					</div>
				</div>
				<br><br>
				<div class="row" style="background-color : #ccc">
					<div class="col-lg-5 col-md-6 col-sm-6 col-xs-5">
						<button type="reset" class="btn btn-raised btn-default btn-full">Annuler</button>
					</div>
								    
					<div class="col-lg-7 col-md-6 col-sm-7 col-xs-7">
						<button type="submit" name="terminer" value="ok" class="btn btn-raised btn-primary btn-full"><?php echo $id == -1 ? 'Enregistrer' : 'Modifier' ?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="col-lg-8 col-md-7 col-sm-6">
	<?php if ($id!=-1): ?>
	<?php foreach ($child_tables as $key => $child_table): ?>
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title"><?php echo $child_table['label'] ?>  lié(e)s</h3>
				<a href="?page=<?php echo $child_table['list_page']; ?>" class="btn btn-raised btn-default btn-new-item">Liste complête</a>
			</div>
			<br>
			<div class="panel-body">
				<table class="table table-striped table-hover ">
					<thead>
						<tr>
							<?php foreach ($child_table['columns'] as $key1 => $column): ?>
							<th><?php echo $column; ?></th>
							<?php endforeach ?>
							<th>EDITER</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($child_table['records'] as $key2 => $record): ?>
							<tr>
								<?php foreach ($child_table['columns'] as $key3 => $column): ?>
									<td><?php echo $record[$column]; ?></td>
								<?php endforeach ?>
								<td>
									<a href="?page=<?php echo $child_table['edit_page'] ?>&id=<?php echo $record['ID']; ?>">éditer</a>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	<?php endforeach ?>
	<?php endif ?>
</div>