<?php 
	$page_name = 'edit_produit';

	$table_name = 'PRODUIT';
	$table_columns = ['REFERENCE', 'LIBELLE', 'ID_TYPE_PRODUIT', 'ID_PAYS', 'ID_FOURNISSEUR', 'DESCRIPTION'];
	$table_label = 'Produit';

	$parent_tables =[
		"TYPE_PRODUIT"=>[
			'name'=>'TYPE_PRODUIT',
			'label'=>'Type de produit', 
			'foreign_key'=>'ID_TYPE_PRODUIT',
			'columns'=>['NOM', 'DESCRIPTION'],
			'record' => [],
			'edit_page'=>'edit_produit',
			'list_page'=>'list_produits'
		],
		"PAYS"=>[
			'name'=>'PAYS',
			'label'=>'Pays', 
			'foreign_key'=>'ID_PAYS',
			'columns'=>['CODE', 'NOM'],
			'record' => [],
			'edit_page'=>'edit_pays',
			'list_page'=>'list_pays'
		],
		"FOURNISSEUR"=>[
			'name'=>'FOURNISSEUR',
			'label'=>'Fournisseur', 
			'foreign_key'=>'ID_FOURNISSEUR',
			'columns'=>['NOM', 'ADRESSE'],
			'record' => [],
			'edit_page'=>'edit_fournisseur',
			'list_page'=>'list_fournisseurs'
		]
	];

	$child_tables = [];
	$many_to_many_child_tables = [
		[
			'name'=>'MALADIE',
			'label'=>'Maladie',
			'association_table'=> [
				'name'=>'PRODUIT_MALADIE',
				'foreign_id'=>'ID_MALADIE',
				'external_id'=>'ID_PRODUIT',
				'columns'=>[]
			],
			'columns'=>['NOM', 'DESCRIPTION'], 
			'records' => [],
			'edit_page'=>'edit_maladie',
			'list_page'=>'list_maladies',
			'records'=>[]
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
					$parent_tables[$key]['record'] = getParentRow($connection, $parent_table['name'], $parent_id);
				}
			}
		}
		$parent_tables[$key]['list'] = getAllRows($connection, $parent_tables[$key]['name']);
	}

	foreach ($many_to_many_child_tables as $key => $child_table) {
		if($id!=-1) {
			$association_table = $child_table['association_table'];
			$association_records = getAllRows($connection, $association_table['name']);
			foreach ($association_records as $key1 => $association_record) {
				$many_to_many_child_tables[$key] = getAllRowsWhere($connection, $child_table['name'], 'ID='.$association_record[$association_table['external_id']]);
			}
		}
	}

	$title = $id != -1 && isset($_POST['libelle']) ? "'Modifier le $table_label (<span class=\'text-info\'>".$_POST['libelle']."</span>)'" : "'Enregistrer un $table_label'";
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
						<label>Référence</label>
						<input class="form-control" placeholder="Référence" id="" type="text" name="reference" required="required" value="<?php echo isset($_POST['reference']) ? $_POST['reference'] : ''; ?>">
						<p class="help-block">Représente la reference du maladie</p>
					</div>

					<div class="form-group label-floating">
						<label>Libellé</label>
						<input class="form-control" placeholder="Libellé" id="" type="text" name="libelle" required="required" value="<?php echo isset($_POST['libelle']) ? $_POST['libelle'] : ''; ?>">
						<p class="help-block">Représente le libelle du maladie</p>
					</div>

					<div class="form-group label-floating">
						<label>Type</label>
						<select class="form-control" name="id_type_produit" required="required">
							<?php foreach ($parent_tables['TYPE_PRODUIT']['list'] as $key => $type_produit): ?>
								<option <?php echo $id!=-1 && $_POST['id_type_produit'] == $type_produit['ID'] ? 'selected=selected' : '' ?> value="<?php echo $type_produit['ID'] ?>"><?php echo $type_produit['NOM']; ?></option>
							<?php endforeach ?>
						</select>
						<p class="help-block">Représente le type du maladie</p>
					</div>

					<div class="form-group label-floating">
						<label>Fournisseur</label>
						<select class="form-control" name="id_fournisseur" required="required">
							<?php foreach ($parent_tables['FOURNISSEUR']['list'] as $key => $fournisseur): ?>
								<option <?php echo $id!=-1 && $_POST['id_fournisseur'] == $fournisseur['ID'] ? 'selected=selected' : '' ?> value="<?php echo $fournisseur['ID'] ?>"><?php echo $fournisseur['NOM']; ?></option>
							<?php endforeach ?>
						</select>
						<p class="help-block">Représente le fournisseur du maladie</p>
					</div>

					<div class="form-group label-floating">
						<label>Fournisseur</label>
						<select class="form-control" name="id_pays" required="required" value="<?php echo isset($_POST['id_pays']) ? $_POST['id_pays'] : ''; ?>">
							<?php foreach ($parent_tables['PAYS']['list'] as $key => $pays): ?>
								<option <?php echo $id!=-1 && $_POST['id_pays'] == $pays['ID'] ? 'selected=selected' : '' ?> value="<?php echo $pays['ID'] ?>"><?php echo $pays['NOM']; ?></option>
							<?php endforeach ?>
						</select>
						<p class="help-block">Représente le pays d'origine du maladie</p>
					</div>

					<div class="form-group label-floating">
						<label>Description</label>
						<textarea class="form-control" placeholder="Description" rows="3" id="textArea" name="description"><?php echo isset($_POST['description']) ? $_POST['description'] : ''; ?></textarea>
						<span class="help-block">La description du maladie</span>
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
				<a href="?page=<?php echo $child_table['list_page']; ?>" class="btn btn-raised btn-default btn-new-item">Liste complête</a>			</div>
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