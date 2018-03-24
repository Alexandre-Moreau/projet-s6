<form method="post" action =".?r=Article/ajaxRechercher" enctype="multipart/form-data" class="form-inline my-2 my-lg-0">

	<input class="form-control mr-sm-2" type="text" id="queryInput" placeholder="Search">
	<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>

</form>
<div class="third">
	<?php
		function printRecursive($concept, $callStack){
			echo '<div class="ontoTerminologieElement">&#x2514;'.str_repeat('&#x2500;', $callStack).' <span class="refConcept" id="ontoTerminologieElementName'.$concept->id.'">'.$concept->nom.'</span></div>';
			$callStack++;
			foreach($concept->conceptsFils as $fils){
				printRecursive($fils, $callStack);
			}
		}
		foreach($data['onto'] as $conceptRacine){
			printRecursive($conceptRacine, 0);
		}
	?>
</div>
<div class="third" id="articlesList">
	<ul class="list-group">
	</ul>
</div>
<div class="third" id="referencesList">
	<ul class="list-group">
	</ul>
</div>
<script>
	var form = $('form');
	var answer;
	$(document).ready(function () {
		
		$('div.ontoTerminologieElement span').click(function(event){
			var contenuElementClique = $('#'+event.target.id).html();
			$('#queryInput').val(contenuElementClique);
			form.submit();
		});
		
		// On ne peut pas ajouter de .click sur des éléments ajoutés dynamiquement.
		// On met donc un onclick sur l'élémént statique le plus proche et on met l'id/classe de l'élement ou on voulait mettre l'event en 2e paramètre
		$('#referencesList ul').on('click', 'li.ontoTerminologieElement span.refConcept', function (event) {
			var contenuElementClique = $('#'+event.target.id).html();
			$('#queryInput').val(contenuElementClique);
			form.submit();
		});

		form.on('submit', function(e) {
			
			e.preventDefault();

			// traitement des $_POST
			var data = new FormData();
			data.append('query', $('#queryInput').val());



			$.ajax({
				url: form.attr('action'),
				type: form.attr('method'),						
				data: data,

				cache: false,
				processData: false,
				contentType: false,

				success: function (reponse) {

					$('#articlesList ul').empty();
					$('#referencesList ul').empty();
					//reponse = JSON.parse(reponse);
					answer = reponse;
					if(reponse['log'].length != 0){
						console.log(reponse['log']);
					}
					for(var i in reponse['articlesScore']) {
						var article = reponse['articlesScore'][i][0];
						var score = reponse['articlesScore'][i][1];
						$('#articlesList ul').append('<li id="liArticle'+article.id+'" class="list-group-item list-group-item-action justify-content-between"><a href="./?r=article/showById&id=' + article.id + '">' + article.nom + '</a><span class="badge badge-default badge-pill">' + score + '</span></li>');
						$('#articlesList ul').on('click','#liArticle'+article.id, function(event){
							$('#referencesList ul').empty();
							// Si l'id de l'élément cliqué commence par liArticle (si on a cliqué sur l'article mais pas sur son nom)
							var articleId = event.target.id.split("liArticle");
							if(articleId.length>1){
								articleId = articleId[1];
								var data2 = new FormData();
								data2.append('articleId', articleId);								
								$.ajax({
									url: './?r=article/ajaxOverview',
									type: form.attr('method'),						
									data: data2,

									cache: false,
									processData: false,
									contentType: false,
									success: function (reponse2) {
										answer = reponse2;
										if(reponse2['log'].length != 0){
											console.log(reponse2['log']);
										}
										
										$('#referencesList ul').empty();

										for(var j in reponse2['references']) {
											var reference = reponse2['references'][j];

											$('#referencesList ul').append('<li class="list-group-item list-group-item-action justify-content-between animated fadeIn ontoTerminologieElement"><span class="refConcept" id="ontoTerminologieElementName' + reference.concept.id + '">' + reference.concept.nom + '</span><span class="badge badge-default badge-pill">' + reference.nombreRef + '</span></li>');
											
										}
									},
									error: function (xhr, textStatus, errorThrown) {
										console.log(xhr.responseText);
									}
								});
							}else{
								$('#referencesList ul').empty();
							}
							
						});
					}
				},
				error: function (xhr, textStatus, errorThrown) {
					console.log(xhr.responseText);
				}
			});
		});
		
		
	});

</script>
