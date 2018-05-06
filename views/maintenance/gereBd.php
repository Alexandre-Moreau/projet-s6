			<h2 id='titleDb'><?php echo _DATABASE;?></h2>
			<div class="card">
				<div class="card-body"><?php echo 'Connexion au serveur'; ?> : <span class="badge badge-default" id="nbArticles"><?php echo $data['statut']['reussite']; ?></span></div>
				<div id="infoSupConnexionBdd"></div>
			</div>
			</br>
			<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#formLoadFichiers"><?php echo _ADVANCED?></button>
			<div id="formLoadFichiers" class="collapse">
				<div id="formStatus" class="alert-dismissible fade show" role="alert">
					<div id="">
						
					</div>
				</div>
				<form method="post" action ="">
					<div class="form-group">
						<label for="fichierCreate"><?php echo _FILE.' create.sql';?> : <span class="requis">*</span></label>
						<input type="file" name='fichierCreate' id='fichierCreate' accept=".sql" class="form-control">
					</div>
					<div class="form-group form_boutons">
						<input id="submit" type="submit" value="<?php echo _FORMSUBMIT;?>" class="btn btn-primary"><!--
						--><input id="reset" type="reset" value="<?php echo _FORMRESET;?>" class="btn btn-secondary"></input>
					</div>
				</form>
			</div>
			<script>
				<?php printJsVar('statut', $data['statut']);?>
				$(document).ready(function(){
					formAnswer = [];
					
					if($('#nbArticles').html() == '2'){
						$('#nbArticles').html('&#x2713;');
						$('#nbArticles').removeClass('badge-default');
						$('#nbArticles').addClass('badge-success');
					}else if($('#nbArticles').html() == '1'){
						$('#nbArticles').html('!');
						$('#nbArticles').removeClass('badge-default');
						$('#nbArticles').addClass('badge-warning');
						$('#infoSupConnexionBdd').append('<span class="badge badge-warning">'+'<?php echo 'base de données inconnue';?></span>');
					}else{
						$('#nbArticles').html('!');
						$('#nbArticles').removeClass('badge-default');
						$('#nbArticles').addClass('badge-danger');
						$('#infoSupConnexionBdd').append('<span class="badge badge-danger">'+'<?php echo $data['statut']['message'];?></span>');
					}
					
					var form = $('form');
					
					form.on('reset', function(e){
						resetForm();
					});

					form.on('submit', function(e) {
						erreursForm = [];
						var data = new FormData();
						
						$.each($('#fichierCreate')[0].files, function(i, file) {
							data.append(i, file);
						});
						
						e.preventDefault();
						$.ajax({
							url: '.?r=maintenance/ajaxChargeFichiers',
							type: form.attr('method'),						
							data: data,
							
							cache: false,
							processData: false,
							contentType: false,
							
							success: function (reponse) {
								console.log(reponse);
								formAnswer = JSON.parse(reponse);
								if(formAnswer['log'].length != 0){
									console.log(formAnswer['log']);
								}
								//console.log(formAnswer['erreursForm']);
								if(){
									
								}else if(){
								
								}
								//refreshDivFormStatus();
							},
							error: function (xhr, textStatus, errorThrown) {
								console.log(xhr.responseText);
								//refreshDivFormStatus();
							}
						});
					});
					
					function resetForm(){
						$('#formStatus').removeClass('alert alert-success alert-warning alert-danger');
						$('#formStatus #statusMessage').remove();
						$('#formStatus ul').remove();

						formAnswer = [];
					}
				});
			</script>
