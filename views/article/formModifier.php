			<div class="container">
				<h3><?php echo _EDITARTICLE?></h3>
				<hr><br>
				<div id="formStatus">
					<div id="">
						
					</div>
				</div>
				<form method="post" action =".?r=Article/ajaxModifier" enctype="multipart/form-data">
					<div class="input-field">
						<input type="text" name="nom" id="nom" placeholder="<?php echo _CHOOSENAME;?>" value="<?php echo $data['article']->nom; ?>" />
						<label for="nom"><?php echo _NAME?> : <span class="requis">*</span></label>
					</div>
					<div class="input-field">
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
						<label for="langue"><?php echo _LANGUAGE?> :</label>
					</div>
					<div class="center">
						<button id="submit" type="submit" class="btn success waves-effect"><?php echo _FORMSUBMIT;?></button>
						<button id="reset" type="reset" class="btn danger waves-effect waves-light"><?php echo _FORMRESET;?></button>
					</div>
				</form>

				<br>
				<span class="requis">*</span> <?php echo _FORMREQUESTED;?>
				<br><br>
				
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

					var messageFormError = "<?php echo _FORMERROR; ?>";
					var messageErrorFormHandling = "<?php echo _ERRORFORMHANDLING; ?>";
					var messageWatchLogs = "<?php echo _WATCHLOGS; ?>";

					refreshDivFormStatus(formAnswer, messageFormError, messageErrorFormHandling, messageWatchLogs);
					
					var form = $('form');
					
					form.on('submit', function(e) {
						
						erreursForm = [];
						var data = new FormData();
						
						data.append('nom', article_nom);
						data.append('id', article_id);
						data.append('langue', article_langue);

						formAnswer['statut'] = 'warning';
						formAnswer['info'] = 'Chargement... <img style="margin-left: 5px" src="images/loading.svg" width="28">';
						refreshDivFormStatus(formAnswer, messageFormError, messageErrorFormHandling, messageWatchLogs);
					
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
									formAnswer['info'] = '<span id="statusMessage" <strong><?php echo _EDITSUCCES;?></strong> <a href=".?r=article/showById&id=' + article_id + '">Accéder à l\'article</a></span>';
								}
								refreshDivFormStatus(formAnswer, messageFormError, messageErrorFormHandling, messageWatchLogs);
							},
							error: function (xhr, textStatus, errorThrown) {
								console.log(xhr.responseText);
								refreshDivFormStatus(formAnswer, messageFormError, messageErrorFormHandling, messageWatchLogs);
							}
						});
					});
				});				
			</script>
