<?php 

	$page_name = 'list_fournisseurs';

	$table_name = 'FOURNISSEUR';
	$table_columns = ['NOM', 'ADRESSE'];
	$table_label = 'Fournisseur';

	$edit_page = 'edit_fournisseur';
	$delete_page = 'delete_page';

	$title = "Liste de fournisseurs";

	$list = getALlRows($connection, $table_name);
 ?>

 <script type="text/javascript">
	window.onload = function() {
		var title = '<?php echo $title; ?>';
		document.getElementById('title').innerHTML= title;
	}
</script>

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<h3 class="panel-title">liste</h3>
				<a href="?page=<?php echo $edit_page; ?>" class="btn btn-raised btn-default btn-new-item">Ajouter</a>
			</div>
			<div class="panel-body">
				<table class="table table-striped table-hover ">
					<thead>
						<tr>
							<?php foreach ($table_columns as $key1 => $column): ?>
							<th><?php echo $column; ?></th>
							<?php endforeach ?>
							<th>ACTIONS</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($list as $key2 => $record): ?>
							<tr>
								<?php foreach ($table_columns as $key3 => $column): ?>
									<td><?php echo $record[$column]; ?></td>
								<?php endforeach ?>
								<td>
									<a href="?page=<?php echo $edit_page; ?>&id=<?php echo $record['ID']; ?>">éditer</a> | 
									<a href="?page=<?php echo $delete_page; ?>&id=<?php echo $record['ID']; ?>">supprimer</a>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>