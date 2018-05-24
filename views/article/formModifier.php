			<div class="container">
				<h3><?php echo _EDITARTICLE?></h3>
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
							<!--<option value="null"><?php echo _OTHERLANGUAGE?></option>-->
						</select>
					</div>
					<div class="form-group form_boutons">
						<input id="submit" type="submit" value="<?php echo _FORMSUBMIT?>" class="btn btn-primary"><!--
						--><input id="reset" type="reset" value="<?php echo _FORMRESET?>" class="btn btn-secondary"></input>
					</div>
				</form>
				<br/>
				<div>
					<ul class="collection with-header">
						<li class="collection-header">
							<h2><?php echo _REFERENCE;?></h2>
						</li>						
						<?php
							foreach($data['references'] as $reference){
								echo '<li class="collection-item">';
								echo $reference->concept->nom.':<br/>';
								$pattern = '/(\|\|)(.*)(\|\|)/';
								$replacement = '<b>$2</b>';
								echo preg_replace($pattern, $replacement, $reference->contexte);
								echo '</li>';
							}
						?>
					</ul>
				</div>
			</div>
			<script>
				$(document).ready(function(){
					var formAnswer = [];
					var article_nom =  $('#nom').val();
					var article_id = <?php echo $_GET['id']; ?>;
					var article_langue = $('#langue').find(":selected").text();
					formAnswer['erreursSaisie'] = [];

					refreshDivFormStatus(formAnswer);
					
					var form = $('form');
					
					form.on('submit', function(e) {
						
						erreursForm = [];
						var data = new FormData();
						
						data.append('nom', article_nom);
						data.append('id', article_id);
						data.append('langue', article_langue);

						formAnswer['statut'] = 'warning';
						formAnswer['info'] = 'Chargement... <img style="margin-left: 5px" src="images/loading.svg" width="28">';
						refreshDivFormStatus(formAnswer);
					
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
								if(reponse['statut'] == 'succes'){
									formAnswer['info'] = '<span id="statusMessage" <strong><?php echo _CREATESUCCES;?></strong> <a href=".?r=article/showById&id=' + article_id + '">Accéder à l\'article</a></span>';
								}
								refreshDivFormStatus(formAnswer);
							},
							error: function (xhr, textStatus, errorThrown) {
								console.log(xhr.responseText);
								refreshDivFormStatus();
							}
						});
					});
				});				
			</script>
