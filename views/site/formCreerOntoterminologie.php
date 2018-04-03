	<div class="container">
		<h3><?php echo _CREATEONTO; ?></h3>
		<hr><br>
		<div id="formStatus" >
		</div>
		<form method="post" action =".?r=Site/ajaxCreate" enctype="multipart/form-data" class="col">
			<div class="form-group">
				<input type="file" name='file' id='file' accept=".xml, .ote" class="form-control">
			</div>
			<div class="form-group form_boutons">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#confirmationModal"><?php echo _FORMSUBMIT; ?></button><!--
				--><input id="reset" type="reset" value="<?php echo _FORMRESET; ?>" class="btn btn-secondary" />
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
							<?php echo _ASKREPLACE;?>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo _FORMCANCEL;?></button>
							<input id="submit" type="submit" value="<?php echo _FORMSUBMIT;?>" class="btn btn-success" />
						</div>
					</div>
				</div>
			</div>
		</form>
		<br>
	</div>
			<script>
				var formAnswer = [];
				var answer;
				formAnswer['erreursSaisie'] = [];
				
				$(document).ready(function () {
					
					var form = $('form');

					form.on('submit', function(e) {
						
						erreursForm = [];
						var data = new FormData();
						
						$.each($('#file')[0].files, function(i, file) {
							data.append('file'+i, file);
						});
					
						e.preventDefault();
						$.ajax({
							url: form.attr('action'),
							type: form.attr('method'),						
							data: data,
							
							cache: false,
							processData: false,
							contentType: false,
							
							success: function (reponse) {
								answer = reponse;
								if(reponse['log'].length != 0){
									console.log(reponse['log']);
								}
								if(reponse['statut'] !== 'echec'){
									window.location.replace('.?r=site/rechercher');
								}else{
									// traiter erreur dans un div dismissable
									console.log('dans le else ECHEC');
								}
							},
							error: function (xhr, textStatus, errorThrown) {
								console.log(xhr.responseText);
							}
						});
					});
					
				});

			</script>