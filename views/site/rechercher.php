<form method="post" action =".?r=Article/ajaxRechercher" enctype="multipart/form-data" class="form-inline my-2 my-lg-0">

	<div class="row">
		<div class="input-field inline col s6 m5 l4">
			<input id="queryInput" name="queryInput" type="text">
			<label for="queryInput"><?php echo _SEARCH;?></label>
		</div>
		<div class="input-field inline">
			<button class="btn success waves-effect waves-light" type="submit"><?php echo _SEARCH;?></button>
		</div>
	</div>

</form>




<div class="third">
	<ul class="tabs">
		<li class="tab">
			<a class="active" id="tab1" href="#concepts"><?php echo _CONCEPTS;?></a>
		</li>
		<li class="tab">
			<a id="tab2" href="#terms"><?php echo _TERMS;?></a>
		</li>
	</ul>

	<div id="contentDivs">
		<div class="contentDiv" id="concepts">
			<!-- <link   rel='stylesheet' href='d3v4-selectable-zoomable-force-directed-graph.css'> -->
			<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.4.1/d3.min.js"></script> -->
			<!-- <script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-3.3.1.min.js"></script> -->
			<script src="https://d3js.org/d3.v4.js"></script>
			<!-- <script src="d3v4-brush-lite.js"></script> -->
			<!-- <script src="d3v4-selectable-force-directed-graph.js"></script> -->

			<!-- <svg align='center' id="d3_selectable_force_directed_graph" style="width: 450px; height: 600px; margin-bottom: 12px; stroke='black' ">
			<svg /> -->
			
			<!-- <svg width="800" height="600" fill="yellow" stroke="orange"><svg />
			<circle cx="250" cy="250" r="25" fill="green" stroke="yellow" stroke-width="5"/></circle>
			<text x="250" y="25" fill="green" >Easy-peasy</text>
			<line x1="0" y1="0" x2="500" y2="50" stroke="orange"/>
			<rect x="0" y="0" width="30" height="30" fill="purple"/>
			<rect x="20" y="5" width="30" height="30" fill="blue"/>
			<rect x="40" y="10" width="30" height="30" fill="green"/>
			<rect x="60" y="15" width="30" height="30" fill="yellow"/>
			<rect x="80" y="20" width="30" height="30" fill="red"/> -->
			<style>
				.link line {
				stroke: #696969;
				}

				.link line.separator {
				stroke: #fff;
				stroke-width: 2px;
				}

				.node circle {
				stroke: rgb(0, 0, 0);
				stroke-width: 1.5px;
				}

				.node text {
				font: 10px sans-serif;
				pointer-events: none;
				}
			</style>

			<script>

				var width = 800,
					height = 500;

				var svg = d3.select("body").append("svg")
					.attr("width", width)
					.attr("height", height);
				
				var dataset = [ 5, 10, 15, 20, 25 ];

				var circles = svg.selectAll("circle")
					.data(dataset)
					.enter()
					.append("circle");

				circles.attr("cx", function(d, i) {
						return (i * 100) + 25;
					})
					.attr("cy", 100/2)
					.attr("r", function(d) {
						return d*2;
				});

				
			</script>




			<?php
				function printRecursive($concept, $callStack){
					echo '<div class="ontoTerminologieElement">&#x2514;'.str_repeat('&#x2500;', $callStack).' <span class="refConcept" id="ontoTerminologieElementName'.$concept->id.'">'.$concept->nom.'</span></div>';
					$callStack++;
					foreach($concept->conceptsFils as $fils){
						printRecursive($fils, $callStack);
					}
				}
				function printRecursiveJSON($concept){
					echo $concept->id.' '.$concept->nom;
					foreach($concept->conceptsFils as $fils){
						printRecursiveJSON($fils);
					}
				}
				foreach($data['onto'] as $conceptRacine) {
					printRecursive($conceptRacine, 0);
					//printRecursiveJSON($conceptRacine);
					//print_r(json_encode(Model::toArray($conceptRacine), JSON_UNESCAPED_UNICODE));
				}
			?>
		</div>

		<div class="contentDiv" id="terms">
			<?php
				foreach($data['termes'] as $terme){
					echo '<div class="ontoTerminologieElementTerme"><span class="refConcept" id="ontoTerminologieElementTermeName'.$terme->concept->id.'" concept="'.$terme->concept->nom.'"">'.stripslashes($terme->motCle).'</span></div>';
				}
			?>
		</div>
	</div>
</div>




<div class="third" id="articlesList">
	<div class="collection">
	</div>
</div>
<div class="third" id="referencesList">
	<div class="collection">
	</div>
</div>




<script>
	var form = $('form');
	var answer;
	$(document).ready(function () {
		
		$('div.ontoTerminologieElement span').click(function(event){
			var contenuElementClique = $('#'+event.target.id).html();
			if(event.ctrlKey && $('#queryInput').val() != ""){
				$('#queryInput').val($('#queryInput').val() + ", " + contenuElementClique)
			}else{
				$('#queryInput').val(contenuElementClique);
			}
			$('#queryInput').focus();
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
			$('#queryInput').focus();
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

<!-- <div style="color:black; background-color:pink; height:50px; width:450px; ">
</div> -->





<!-- var concepts = 
				{
					"nom" : "siège",
					"concepts_fils" : 
					[
						{
							"nom" : "siège avec bras",
							"concepts_fils" : 
							[
								{
									"nom" : "siège avec bras et dossier",
									"concepts_fils" : []
								},
								{
									"nom" : "siège avec bras sans dossier",
									"concepts_fils" : []
								},
							]
						},
						{
							"nom" : "siège sans bras",
							"concepts_fils" : 
							[
								{
									"nom" : "siège sans bras avec dossier",
									"concepts_fils" : []
								},
								{
									"nom" : "siège sans bras sans dossier",
									"concepts_fils" : []
								},
							]
						}
					]
				}; -->













