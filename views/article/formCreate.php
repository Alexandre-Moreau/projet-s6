			<div class="container">
				<h3><?php echo _CREATEARTICLE;?></h3>
				<hr><br>
				<div id="formStatus">
					<div id="">
						
					</div>
				</div>
				<div class="row">
					<form method="post" action =".?r=Article/ajaxCreate" enctype="multipart/form-data">
						<div class="input-field inline col s12 m6">
							<!-- <i class="material-icons prefix text-primary">mode_edit</i> -->
							<input type="text" name="nom" id="nom" placeholder="<?php echo _CHOOSENAME;?>" />
							<label for="nom"><?php echo _NAME;?> : <span class="requis">*</span></label>
						</div>
						<div class="file-field input-field inline col s12 m6">
							<div class="btn primary">
								<span><?php echo _CHOOSEFILE;?><i class="material-icons right">file_upload</i></span>
								<input type="file" name="file" id="file" accept=".pdf,.html,.htm,.txt">
							</div>
							<div class="file-path-wrapper">
								<input class="file-path validate" type="text">
							</div>
						</div>
						<br>
						<div class="input-field col s12">
							<select id="langue" name="langue">
								<?php
									foreach($data['langues'] as $langue){
										if($langue->nom == $data['langueDefaut']){
											echo '<option value="'.$langue->nom.'" selected>'.$langue->nom.'</option>';
										}else{
											echo '<option value="'.$langue->nom.'">'.$langue->nom.'</option>';
										}
									}
								?>
								<option value="null"><?php echo _OTHERLANGUAGE;?></option>
							</select>
							<label for="langue"><?php echo _LANGUAGE;?> :</label>
						</div>
						<br>
						<div class="center col s12">
							<button id="submit" type="submit" class="btn success waves-effect"><?php echo _FORMSUBMIT;?></button>
							<button id="reset" type="reset" class="btn danger waves-effect waves-light"><?php echo _FORMRESET;?></button>
						</div>
					</form>
				</div>
				<!--<progress></progress>-->
				<br>
				<span class="requis">*</span> <?php echo _FORMREQUESTED;?>
			</div>

			<script>
				var formAnswer = [];
				formAnswer['erreursSaisie'] = [];
				
				var messageFormError = "<?php echo _FORMERROR; ?>";
				var messageErrorFormHandling = "<?php echo _ERRORFORMHANDLING; ?>";
				var messageWatchLogs = "<?php echo _WATCHLOGS; ?>";

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

					refreshDivFormStatus(formAnswer, messageFormError, messageErrorFormHandling, messageWatchLogs);
					
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
									formAnswer['info'] = '<span id="statusMessage" <strong><?php echo _CREATESUCCES;?>.</strong> <a href=".?r=article/showById&id=' + formAnswer['articleId'] + '">Accéder à l\'article</a></span>';
								}
								refreshDivFormStatus(formAnswer, messageFormError, messageErrorFormHandling, messageWatchLogs);
							},
							error: function (xhr, textStatus, errorThrown) {
								console.log(xhr.responseText);
								formAnswer['statut'] = 'echec';
								formAnswer['erreursSaisie'].length = 0;
								refreshDivFormStatus(formAnswer, messageFormError, messageErrorFormHandling, messageWatchLogs);
							}
						});
					});
					
				});

			</script>
	
