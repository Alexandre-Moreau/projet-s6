			<div class="container">
				<h3><?php echo _CREATEARTICLE;?></h3>
				<hr><br>
				<div id="formStatus" class="alert-dismissible fade show" role="alert">
					<div id="">
						
					</div>
				</div>
				<form method="post" action =".?r=Article/ajaxCreate" enctype="multipart/form-data">
					<div class="form-group">
						<label for="nom"><?php echo _NAME;?> : <span class="requis">*</span></label>
						<input type="text" name="nom" id="nom" class="form-control" placeholder="<?php echo _CHOOSENAME;?>" />
					</div>
					<div class="form-group">
						<input type="file" name='file' id='file' accept=".pdf,.html,.htm,.txt" class="form-control">
						<!--<label class="custom-file">
							<input type="file" id="file" name="file" accept=".pdf,.html,.htm,.txt" class="form-control custom-file-input">
							<span class="custom-file-control"></span>
						</label>-->
					</div>
					<div class="form-group">
						<label for="langue"><?php echo _LANGUAGE;?> :</label>
						<select id="langue">
							<?php
								foreach($data['langues'] as $langue){
									if($langue->nom == $data['langueDefaut']){
										echo '<option value="'.$langue->nom.'" selected>'.$langue->nom.'</option>';
									}else{
										echo '<option value="'.$langue->nom.'">'.$langue->nom.'</option>';
									}
									
								}
							?>
							<option value="null">autre (le texte ne sera pas référencé)</option>
						</select>
					</div>
					<div class="form-group form_boutons">
						<input id="submit" type="submit" value="<?php echo _FORMSUBMIT;?>" class="btn btn-primary"><!--
						--><input id="reset" type="reset" value="<?php echo _FORMRESET;?>" class="btn btn-secondary"></input>
					</div>
				</form>
				<!--<progress></progress>-->
				<br>
				<span class="requis">*</span> <?php echo _FORMREQUESTED;?>
			</div>

			<script>
				var formAnswer = [];
				formAnswer['erreursSaisie'] = [];
				
				function refreshDivFormStatus(){
					$('#formStatus').removeClass('alert alert-success alert-warning alert-danger');
					$('#formStatus #statusMessage').remove();
					$('#formStatus ul').remove();
					
					if(formAnswer['statut'] == 'echec'){
						$('#formStatus').addClass('alert alert-danger');
						//$('#formStatus').append('<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>');
						$('#formStatus').html('<strong id="statusMessage"><?php echo _FORMERROR;?></strong>');
						$('#formStatus').append('<ul/>');
						if($.isArray(formAnswer['erreursSaisie'])){
							formAnswer['erreursSaisie'].forEach(function(element){
								$('#formStatus ul').append('<li>' + element + '</li>'); //On ajoute l'erreur dans la liste de la div
							});
						}else{
							console.log(formAnswer);
						}
					}else if(formAnswer['statut'] == 'succes'){
						$('#formStatus').addClass('alert alert-success');
						$('#formStatus').html('<span id="statusMessage" <strong>L\'article a été créé avec succès</strong> <a href=".?r=article/showById&id=' + formAnswer['articleId'] + '">Accéder à l\'article</a></span>');
					}else if(formAnswer['statut'] == 'warning'){
						$('#formStatus').addClass('alert alert-warning');
						$('#formStatus').html(formAnswer['info']);
					}
				}
				
				function resetForm(){
					$('#formStatus').removeClass('alert alert-success alert-warning alert-danger');
					$('#formStatus #statusMessage').remove();
					$('#formStatus ul').remove();

					formAnswer = [];
				}
				
				$(document).ready(function () {
					
					var nom;
					
					$('input:file').change(function (){
						if($('input#nom').val() == '' || $('input#nom').val() == nom){
							// On récupère le nom du fichier après le fakepath
							nom = $(this).val().substring($(this).val().lastIndexOf('\\')+1);
							// On récupère le nom du fichier avant le point
							nom = nom.substring(0, nom.indexOf('.'));
							$('input#nom').val(nom);
							$('input#nom').focus();
						}
					});
  
					refreshDivFormStatus();
					
					var form = $('form');
					
					form.on('reset', function(e){
						resetForm();
					});

					form.on('submit', function(e) {
						
						erreursForm = [];
						var data = new FormData();
						
						data.append('nom', $('#nom').val());
						data.append('langue', $('#langue').find(":selected").text());
						$.each($('#file')[0].files, function(i, file) {
							data.append(i, file);
						});

						formAnswer['statut'] = 'warning';
						formAnswer['info'] = 'Chargement... <img style="margin-left: 5px" src="images/loading.svg" width="28">';
						refreshDivFormStatus();
					
						e.preventDefault();
						$.ajax({
							url: form.attr('action'),
							type: form.attr('method'),						
							data: data,
							
							cache: false,
							processData: false,
							contentType: false,
							
							success: function (reponse) {
								if(reponse['log'].length != 0){
									console.log(reponse['log']);
								}
								formAnswer = reponse;
								refreshDivFormStatus();
							},
							error: function (xhr, textStatus, errorThrown) {
								console.log(xhr.responseText);
								refreshDivFormStatus();
							}
						});
					});
					
				});

			</script>
	
