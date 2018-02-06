
			<div id="divErreursForm">
				<ul>
				</ul>
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
				<div class="form-group form_boutons">
					<input id="submit" type="submit" value="Confirmer" class="btn btn-primary"><!--
					--><input id="reset" type="reset" name="annuler" class="btn btn-secondary"></input>
				</div>
			</form>
			<!--<progress></progress>-->
			<span class='requis'>*</span> Champ requis

			<script>
				var erreursForm = [];
				
				function refreshDivErreursForm(){
					$('#divErreursForm #messgError').remove();
					$('#divErreursForm ul').empty();
					
					if(erreursForm.length > 0){
						$('#divErreursForm').prepend('<p id="messgError">Il y a des erreurs dans le formulaire:</p>'); //On ajoute avant la liste de la div
						if($.isArray(erreursForm)){
							erreursForm.forEach(function(element){
								$('#divErreursForm ul').append('<li>' + element + '</li>'); //On ajoute l'erreur dans la liste de la div
							});
						}else{
							console.log(erreursForm);
						}
					}
				}
				
				$(document).ready(function () {
					refreshDivErreursForm();
					
					var form = $('form')
					
					
					
					form.on('submit', function(e) {
						
						erreursForm = [];
						var data = new FormData();
						
						data.append('nom', $('#nom').val());
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
								if(reponse != "succes"){
									erreursForm = reponse;
								}
								refreshDivErreursForm();
								//console.log(reponse);
							},
							error: function (xhr, textStatus, errorThrown) {
								console.log(xhr.responseText);
							}
						});
					});
					
				});

			</script>
	