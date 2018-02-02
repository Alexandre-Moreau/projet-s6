
			<div id="divErreursForm">
				<ul>
				</ul>
			</div>
			<form method="post" action =".?r=Article/ajaxCreate" enctype="multipart/form-data">
				<label for="nom">nom : <span class="requis">*</span></label>
				<input type="text" name="nom" id="nom"/>
				<input type="file" name='file' id='file' accept=".pdf,.html,.htm">
				<div class="form_boutons">
					<input type="submit" value="Confirmer"><!--
					--><button>Annuler</button>
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
	