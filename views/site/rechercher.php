

<form method="post" action =".?r=Article/ajaxRechercher" enctype="multipart/form-data" class="form-inline my-2 my-lg-0">

	<input class="form-control mr-sm-2" type="text" id="queryInput" placeholder="<?php echo _SEARCH;?>">
	<button class="btn btn-outline-success my-2 my-sm-0" type="submit"><?php echo _SEARCH;?></button>
</form>
<!--
<div >
	<?php
				
		function printRecursive2($concept, $callStack)
		{
			// Pourquoi changer une visualisation qui est juste là dans l'attente de l'ontoterminologie que vous avancez depuis 2 semaines?
			// Ah oui et personne touche à mon indentation et mes accolades dans mon code (le printRecursive() de plus bas)
			//   - Alexandre
			echo '<div class="ontoTerminologieElement">&#x2514;'.str_repeat('&#x2500;', $callStack).' <span class="refConcept" id="ontoTerminologieElementName'.$concept->id.'">'.$concept->nom.'</span></div>';
			if($callStack == 0)
			{
				echo'<div style="color:black; background-color:yellow;height:50px; width:100px; border:3px solid gray"><p style="text-align:center;padding: 10px 10px;">'.$concept->nom.'</p></div>';
			}
			else if($callStack == 1)
			{
				echo'<div style="color:black; background-color:#00FF00;height:50px; width:250px; margin-left:50px; border:3px solid gray"><p style="text-align:center;padding: 10px 10px;">'.$concept->nom.'</p></div>';
			}
			else if($callStack == 2)
			{
				echo'<div style="color:black; background-color:red;height:50px; width:330px;text-align:center;margin-left:100px;border:3px solid gray"><p style="text-align:center; padding:10px 10px;">'.$concept->nom.'</p></div>';
			}
			else if($callStack == 3)
			{
				echo'<div style="color:black; background-color:pink; height:50px; width:450px; margin-left:150px; border:3px solid gray;><p style="text-align:center; padding:10px 10px;">'.$concept->nom.'</p></div>';
			}
			$callStack++;
			foreach($concept->conceptsFils as $fils)
			{
				printRecursive2($fils, $callStack);
			}
		}

		foreach($data['onto'] as $conceptRacine)
		{
			printRecursive2($conceptRacine, 0);
		}
	?>
		
</div>
-->


<div class="third">
	<ul class="nav nav-tabs">
		<li class="nav-item">
			<span class="nav-link active" id="tab1"><?php echo _CONCEPTS;?></span>
		</li>
		<li class="nav-item">
			<span class="nav-link" id="tab2"><?php echo _TERMS;?></span>
		</li>
	</ul>
	<div id="contentDivs">
		<div class="contentDiv" id="content1">
			<?php
				function printRecursive($concept, $callStack){
					echo '<div class="ontoTerminologieElement">&#x2514;'.str_repeat('&#x2500;', $callStack).' <span class="refConcept" id="ontoTerminologieElementName'.$concept->id.'">'.$concept->nom.'</span></div>';
					$callStack++;
					foreach($concept->conceptsFils as $fils){
						printRecursive($fils, $callStack);
					}
				}
				foreach($data['onto'] as $conceptRacine) {
					printRecursive($conceptRacine, 0);
				}
			?>
		</div>
				


		<div class="contentDiv" id="content2" style="display: none;">
			<?php
				foreach($data['termes'] as $terme){
					echo '<div class="ontoTerminologieElementTerme"><span class="refConcept" id="ontoTerminologieElementTermeName'.$terme->concept->id.'" concept="'.$terme->concept->nom.'"">'.stripslashes($terme->motCle).'</span></div>';					
				}
			?>
		</div>
	</div>
</div>
<div class="third" id="articlesList">
	<ul class="list-group">
	</ul>
</div>
<div class="third" id="referencesList">
	<ul class="list-group" id="tab02">
	</ul>
</div>

<script>
	var form = $('form');
	var answer;
	$(document).ready(function () {
		
		$('ul.nav.nav-tabs li.nav-item span.nav-link').click(function(e){
			$('div#contentDivs div.contentDiv').hide();
			$('div#contentDivs div.contentDiv#content'+e.target.id.split('tab')[1]).show();
			$('ul.nav.nav-tabs li.nav-item span.nav-link').removeClass('active');
			$('ul.nav.nav-tabs li.nav-item span.nav-link#tab'+e.target.id.split('tab')[1]).addClass('active');
		});		
		
		$('div.ontoTerminologieElement span').click(function(event){
			var contenuElementClique = $('#'+event.target.id).html();
			if(event.ctrlKey && $('#queryInput').val() != ""){
				$('#queryInput').val($('#queryInput').val() + ", " + contenuElementClique)
			}else{
				$('#queryInput').val(contenuElementClique);
			}
			form.submit();
		});
		
		$('div.ontoTerminologieElementTerme span').click(function(event){
			var contenuElementClique = $('#'+event.target.id).attr('concept');
			if(event.ctrlKey && $('#queryInput').val() != ""){
				$('#queryInput').val($('#queryInput').val() + ", " + contenuElementClique)
			}else if(event.altKey){
				console.log('alt key pressed');
				$('#queryInput').val(contenuElementClique);
			}else{
				$('#queryInput').val(contenuElementClique);
			}
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
			
			// Mise en gras de l'élément sélectionné
			$('.ontoTerminologieElement span.refConcept').removeClass('selected');
			$('.ontoTerminologieElementTerme span.refConcept').removeClass('selected');
			var listeConcepts = $('#queryInput').val().split(',');
			for (var i = 0; i < listeConcepts.length; i++) {
				var currentConcept = listeConcepts[i].trim();
				$('.ontoTerminologieElement span.refConcept').filter(function() {return $(this).html() == currentConcept;}).addClass('selected');
				$('.ontoTerminologieElementTerme span.refConcept').filter(function() {return $(this).attr('concept') == currentConcept;}).addClass('selected');
			}			
			
			e.preventDefault();

			// traitement des $_POST
			var data = new FormData();
			var references = [];
			data.append('query', $('#queryInput').val());
			
			$('#articlesList ul').empty();
			$('#referencesList ul').empty();
			// Image de chargement
			$('#articlesList ul').append('Chargement... <img style="margin-left: 5px" src="images/loading.svg" width="28">');

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
					for(var i in reponse['articlesRefsScore']) {
						var row = reponse['articlesRefsScore'][i]
						var article = row['article'];
						var score = row['score'];
						$('#articlesList ul').append('<li id="liArticle'+article.id+'" class="list-group-item list-group-item-action justify-content-between"><a href="./?r=article/showById&id=' + article.id + '">' + article.nom + '</a><span class="badge badge-default badge-pill">' + score + '</span></li>');

						
						references[article.id] = [];
						for(var r in row['references']) {
							references[article.id].push(row['references'][r]);
						}

						$('#articlesList ul').on('click','#liArticle'+article.id, function(event){
							$('#referencesList ul').empty();
							// Si l'id de l'élément cliqué commence par liArticle (si on a cliqué sur l'article mais pas sur son nom)
							var articleId = event.target.id.split("liArticle");
							if(articleId.length>1){
								articleId = articleId[1];

								$('#referencesList ul').empty();

								for(var r in references[articleId]) {
									var ref = references[articleId][r];
									//console.log(ref);

									//$('#referencesList ul').append('<li class="list-group-item list-group-item-action justify-content-between animated fadeIn ontoTerminologieElement"><span class="refConcept" id="ontoTerminologieElementName' + ref.concept.id + '">' + ref.concept.nom + '</span><span class="badge badge-default badge-pill">' + ref.nombreMots + '</span></li>');
									//$('#referencesList ul').append('<li class="list-group-item list-group-item-action justify-content-between animated fadeIn"><span class="refConcept" id="ontoTerminologieElementName' + ref.concept.id + '">' + ref.contexte + '</span><span class="badge badge-default badge-pill">' + ref.position + '</span></li>');
									
									// Remplacer le ||mot Cle|| de la base de données par <b>mot Cle</b>
									var regex = /(\|\|)(.*)(\|\|)/;
									ref.contexte = ref.contexte.replace(regex, "<b>$2</b>");

									$('#referencesList ul').append('<li class="list-group-item list-group-item-action justify-content-between animated fadeIn"><span class="refConcept" id="ontoTerminologieElementName' + ref.concept.id + '">' + ref.contexte + '</li>');
								}
								
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
