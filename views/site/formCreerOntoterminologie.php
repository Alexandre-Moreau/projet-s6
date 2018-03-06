	<div class="container">
		<h3>Créer une nouvelle ontoterminologie</h3>
		<hr style="border-top: 3px double grey"><br>
		<div id="formStatus" >
		</div>
		<form method="post" action =".?r=Site/ajaxCreate" enctype="multipart/form-data" class="col">
			<div class="form-group">
				<input type="file" name='file' id='file' accept=".xml, .ote" class="form-control">
			</div>
			<div class="form-group form_boutons">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmationModal">Confirmer</button><!--
				--><input id="reset" type="reset" name="annuler" class="btn btn-secondary" />
			</div>

			<!-- Modal -->
			<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							Êtes-vous sûr de vouloir charger une nouvelle ontoterminologie? Cela entraînera la suppression totale de l'ancienne.
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Abandonner</button>
							<input id="submit" type="submit" value="Confirmer" class="btn btn-success" disabled="true" />
						</div>
					</div>
				</div>
			</div>
		</form>
		<br>
	</div>
