			<div class="container">
				<h3>Modifier un article</h3>
				<hr><br>
				<div id="formStatus" >
				</div>
				<form method="post" action =".?r=Article/ajaxModifier" enctype="multipart/form-data">
					<div class="form-group">
						<label for="nom"><?php echo _NAME?> :</label>
						<input type="text" name="nom" id="nom" class="form-control" value="<?php echo $data['article']->nom; ?>" />
					</div>
					<div class="form-group">
						<label for="langue"><?php echo _LANGUAGE?> :</label>
						<select id="langue">
							<?php
								foreach($data['langues'] as $langue){
									if($langue->nom == $data['article']->langue->nom){
										echo '<option value="'.$langue->nom.'" selected>'.$langue->nom.'</option>';
									}else{
										echo '<option value="'.$langue->nom.'">'.$langue->nom.'</option>';
									}
									
								}
							?>
							<option value="null"><?php echo _OTHERLANGUAGE?></option>
						</select>
					</div>
					<div class="form-group form_boutons">
						<input id="submit" type="submit" value="<?php echo _FORMSUBMIT?>" class="btn btn-primary"><!--
						--><input id="reset" type="reset" value="<?php echo _FORMRESET?>" class="btn btn-secondary"></input>
					</div>
				</form>
			</div>
			<script>
				var formAnswer = [];
				formAnswer['erreursSaisie'] = [];
				
				$(document).ready(function () {
					function refreshDivFormStatus(){
						$('#formStatus').removeClass('alert alert-success alert-warning alert-danger');
						$('#formStatus #statusMessage').remove();
						$('#formStatus ul').remove();
						
						if(formAnswer['statut'] == 'echec'){
							$('#formStatus').addClass('alert alert-danger');
							$('#formStatus').append('<strong id="statusMessage"><?php echo _FORMERROR;?></strong>');
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
							$('#formStatus').append('<span id="statusMessage" <strong>L\'article a été modifié avec succès</strong> <a href=".?r=article/showById&id=' + <?php echo $_GET['id']; ?> + '">Accéder à l\'article</a></span>');
						}else if(formAnswer['statut'] == 'warning'){
							$('#formStatus').addClass('alert alert-warning');
							$('#formStatus').append(formAnswer['info']);
						}
					}
					
					function askRedirect(articleId){
						
					}
					refreshDivFormStatus();
					
					var form = $('form');
					
					form.on('submit', function(e) {
						
						erreursForm = [];
						var data = new FormData();
						
						data.append('nom', $('#nom').val());
						data.append('id', <?php echo $_GET['id']; ?>);
						// data.append('langue', $('#langue').find(":selected").text());
					
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
								if(reponse['statut'] == "succes"){
									askRedirect(reponse['articleId']);							
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