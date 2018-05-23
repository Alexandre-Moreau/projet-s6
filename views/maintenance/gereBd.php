			<div class="row">
				<div class="col l12 m12 s12">
					<ul class="collection with-header">
						<li class="collection-header">
							<h2 id='titleDb'><?php echo _DATABASE;?></h2>
						</li>
						<li class="collection-item">
							<?php echo _SERVER_CONNECTION; ?> : 
							<span class="badge grey white-text" id="nbArticles"><?php echo $data['statut']['reussite']; ?></span>
						</li>
						<div id="infoSupConnexionBdd"></div>
					</ul>
				</div>
			</div>

			<ul class="collapsible popout col l12 m12 s12">
				<li>
					<div class="collapsible-header">
						<i class="material-icons">build</i>
						<?php echo _ADVANCED?>
					</div>
					<div class="collapsible-body">
						<div class="row">
							<div id="formStatus" class="alert fade show">
								<div id=""></div>
							</div>
							<form method="post" action ="">
								<div class="file-field input-field col s12">
									<div class="btn primary">
										<span><?php echo _FILE.' create.sql';?><i class="material-icons right">file_upload</i></span>
										<input type="file" name="fichierCreate" id="fichierCreate" accept=".sql">
									</div>
									<div class="file-path-wrapper">
										<input class="file-path validate" type="text">
									</div>
								</div>

								<div class="input-field center col s12">
									<button type="submit" class="btn success waves-effect" ><?php echo _FORMSUBMIT; ?></button>
									<button id="reset" type="reset" class="btn danger waves-effect waves-light"><?php echo _FORMRESET;?></button>
								</div>
							</form>
						</div>
					</div>
				</li>
			</ul>

			
			<script>
				<?php printJsVar('statut', $data['statut']);?>
				$(document).ready(function(){
					formAnswer = [];
					
					if($('#nbArticles').html() == '2'){
						$('#nbArticles').html('&#x2713;');
						$('#nbArticles').removeClass('grey');
						$('#nbArticles').addClass('success');
					}else if($('#nbArticles').html() == '1'){
						$('#nbArticles').html('!');
						$('#nbArticles').removeClass('grey');
						$('#nbArticles').addClass('warning');
						$('#infoSupConnexionBdd').append('<span class="badge warning">'+'<?php echo 'base de données inconnue';?></span>');
					}else{
						$('#nbArticles').html('!');
						$('#nbArticles').removeClass('grey');
						$('#nbArticles').addClass('danger');
						$('#infoSupConnexionBdd').append('<span class="badge danger">'+'<?php echo $data['statut']['message'];?></span>');
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
								if(formAnswer['erreursForm'] = 'reussite'){
									
								}else if(formAnswer['erreursForm'] = 'echec'){
								
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
