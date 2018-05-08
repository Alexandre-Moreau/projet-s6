	<div class="container">
		<h3><?php echo _CREATEONTO; ?></h3>
		<hr><br>
		<div id="formStatus">
		</div>

		<div class="row">
			<form method="post" action =".?r=Site/ajaxCreate" enctype="multipart/form-data">
				<!-- <div class="form-group">
					<input type="file" name='file' id='file' accept=".xml, .ote" class="form-control">
				</div> -->
				<div class="file-field input-field col s12">
					<div class="btn primary">
						<span><?php echo _CHOOSEFILE;?><i class="material-icons right">file_upload</i></span>
						<input type="file" name="file" id="file" accept=".xml, .ote">
					</div>
					<div class="file-path-wrapper">
						<input class="file-path validate" type="text">
					</div>
				</div>

				<div class="input-field center col s12">
					<button type="button" class="btn success waves-effect modal-trigger" href="#confirmationModal"><?php echo _FORMSUBMIT; ?></button>
					<button id="reset" type="reset" class="btn danger waves-effect waves-light"><?php echo _FORMRESET;?></button>
				</div>

				<!-- Modal -->
				<div class="modal" id="confirmationModal">
					<div class="modal-content">
						<h4><?php echo _CONFIRM;?></h4>
						<hr><br>
						<?php echo _ASKREPLACE;?>
					</div>
					<div class="modal-footer input-field ">
						<button id="cancel" type="button" class="btn secondary waves-effect waves-light modal-close"><?php echo _FORMCANCEL;?></button>
						<button id="submit" type="submit" class="btn success waves-effect waves-light modal-close"><?php echo _FORMSUBMIT;?></button>
					</div>
				</div>
			</form>
		</div>
			
		<br>
	</div>
			<script>
				var formAnswer = [];
				var answer;
				formAnswer['erreursSaisie'] = [];


				function resetForm(){
					$('#formStatus').removeClass('alert alert-success alert-warning alert-danger');
					$('#formStatus #statusMessage').remove();
					$('#formStatus div').remove();

					formAnswer = [];
				}

				$(document).ready(function () {
					
					var form = $('form');
					
					form.on('reset', function(e){
						resetForm();
					});

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
									var error = '';
									if(reponse['errorMessage'] == 'noFile'){
										error = '<?php echo _NOFILEERROR;?>';
									}else if(reponse['errorMessage'] == 'parseError'){
										error = '<?php echo _PARSEERROR;?>';
									}else{
										error = '<?php echo _UNKNOWNERROR;?>';
									}
									$('#formStatus').append('<div class="alert alert-danger"><strong><?php echo _ERROR; ?>:</strong> ' + error + '</div>');
								}
							},
							error: function (xhr, textStatus, errorThrown) {						
								console.log(xhr.responseText);
							}
						});
					});
					
				});

			</script>