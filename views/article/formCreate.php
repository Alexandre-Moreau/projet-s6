
			<div id="formStatus" >
			</div>
			<form method="post" action =".?r=Article/ajaxCreate" enctype="multipart/form-data">
				<div class="form-group">
					<label for="nom">Nom : <span class="requis">*</span></label>
					<input type="text" name="nom" id="nom" class="form-control" placeholder="Entrer un nom" />
				</div>
				<div class="form-group">
					<input type="file" name='file' id='file' accept=".pdf,.html,.htm" class="form-control">
					<!--<label class="custom-file">
						<input type="file" id="file" name="file" accept=".pdf,.html,.htm" class="form-control custom-file-input">
						<span class="custom-file-control"></span>
					</label>-->
				</div>
				<div class="form-group">
					<label for="langue">Langue :</label>
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
					<input id="submit" type="submit" value="Confirmer" class="btn btn-primary"><!--
					--><input id="reset" type="reset" name="annuler" class="btn btn-secondary"></input>
				</div>
			</form>
			<!--<progress></progress>-->
			<span class='requis'>*</span> Champ requis

			<script>
				var formAnswer = [];
				formAnswer['erreursSaisie'] = [];
				
				function refreshDivFormStatus(){
					$('#formStatus').removeClass('alert alert-success alert-warning alert-danger');
					$('#formStatus #statusMessage').remove();
					$('#formStatus ul').remove();
					
					if(formAnswer['statut'] == 'echec'){
						$('#formStatus').addClass('alert alert-danger');
						$('#formStatus').append('<strong id="statusMessage">Il y a des erreurs dans le formulaire</strong>');
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
						$('#formStatus').append('<strong id="statusMessage">L\'article a été créé avec succès</strong> <a href=".?r=Article/showById&id=' + formAnswer['articleId'] + '">Y accéder</a>');
					}else if(formAnswer['statut'] == 'warning'){
						$('#formStatus').addClass('alert alert-warning');
						$('#formStatus').append(formAnswer['info']);
					}
				}
				
				function askRedirect(articleId){
					
				}
				
				$(document).ready(function () {
					refreshDivFormStatus();
					
					var form = $('form');
					
					form.on('submit', function(e) {
						
						erreursForm = [];
						var data = new FormData();
						
						data.append('nom', $('#nom').val());
						data.append('langue', $('#langue').find(":selected").text());
						$.each($('#file')[0].files, function(i, file) {
							data.append(i, file);
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
								console.log(reponse);
								if(reponse['statut'] == "succes"){
									askRedirect(reponse['articleId']);							
								}
								formAnswer = reponse;
								refreshDivFormStatus();
							},
							error: function (xhr, textStatus, errorThrown) {
								console.log(errorThrown);
								console.log(xhr.responseText);
							}
						});
					});
					
				});

			</script>
	
