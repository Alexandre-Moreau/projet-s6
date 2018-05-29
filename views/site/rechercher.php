

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

<div class="row">
	<div class="col l4 m12 s12">
		<ul id="rechercherTabs" class="tabs tabs-fixed-width" style="overflow: hidden;">
			<li class="tab">
				<a class="active" id="tab1" href="#concepts"><?php echo _CONCEPTS;?></a>
			</li>
			<li class="tab">
				<a id="tab2" href="#terms"><?php echo _TERMS;?></a>
			</li>
		</ul>

		<div id="contentDivs">
			<div class="contentDiv" id="concepts">			
				<!-- <ul class="tabs">
					<li class="tab">
						<a class="active" id="tab1" href="#concepts0"><?php echo _ONTO;?></a>
					</li>
					<li class="tab">
						<a id="tab2" href="#concepts1"><?php echo 'carrés';?></a>
					</li>
				</ul> -->
				<div id="concepts0">

				</div>
				<!-- <div id="concepts1" style="text-align: center;">
					<div id="blockRoot"></div>
					<div id="blockContent" style="overflow: hidden;"></div>
				</div> -->
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

	<div class="col l4 m6 s12" id="articlesList">
		<h4><?php echo _LISTARTICLES;?></h4>
		<ul class="collection">
		</ul>
	</div>
	<div class="col l4 m6 s12" id="referencesList">
		<h4><?php echo _LISTREFERENCES;?></h4>
		<ul class="collection">
		</ul>
	</div>
</div>

<script src="js/graphe.js" type="text/javascript"></script>
<script src="https://d3js.org/d3.v4.min.js"></script>
<script>

	<?php
		$i = 0;
		echo 'var dataOnto = [';
		foreach($data['onto'] as $conceptRacine) {
			//printJsVar('racine'.$i++, );
			json_encode_v2(Model::toArray($conceptRacine));
			if(++$i != count($data['onto'])){ echo ', '; }
		}
		echo "]\n";
	?>

	var dataset = {
		"nodes":[
			<?php 
			foreach (Concept::findAll() as $concept) {
				echo '{"id": "'.$concept->id.'", "name": "'.$concept->nom."\"},\n";
			}
			?>
		],
		"links":[
			<?php
			foreach (Relation::findAll() as $relation) {
				echo '{"source": "'.$relation->conceptFrom->id.'", "target": "'.$relation->conceptTo->id."\"},\n";
			}
			?>
			<?php
				// C FOU ça marche j'y aurai jamais cru
				foreach(Concept::findRoots() as $key => $value){
					if(isset(Concept::findRoots()[$key+1])){
						echo '{"source":"'.Concept::findRoots()[$key]->id.'", "target":"'.Concept::findRoots()[$key+1]->id.'", "type":"invisible"},'."\n";
					}
				}
			?>
		]
	};

	var conceptIdSelection = null;

	var form = $('form');
	var answer;

	function getConcept(id){
		var concept = {"id" : 0, "nom" : "", "conceptsFils" : []};
		for (i = 0; i < dataOnto.length; i++) {
			concept.conceptsFils.push(dataOnto[i])
		}
		if(id == null){
			return concept
		}else{
			for (i = 0; i < concept.conceptsFils.length; i++) {
				console.log(findConcept(concept.conceptsFils[i]), id);
			}
		}
		//console.log(concept);
	}

	function findConcept(concept, id){
		var i = 0;
		console.log(concept.conceptsFils);
		while(concept.id != id && i < Object.size(concept.conceptsFils)){
			concept = findConcept(concept.conceptsFils[i], id);
		}
		return concept;
	}

	function selectConceptCarre(conceptId){
		// Il y a très probablement moyen de faire mieux avec des variables jquerry pour contentDivConcepts1
		var contentDivConcepts1 = '';
		var concept = getConcept(conceptId);

		$('div#concepts1 div#blockRoot').html('<b>' + concept.nom + '</b>');

		for (i = 0; i < concept.conceptsFils.length; i++) {
			contentDivConcepts1 += ('<div style="float: left;">' + '<span concept_id="x">' + concept.conceptsFils[i].nom + '</span>');
			for (j = 0; j < Object.size(concept.conceptsFils[i].conceptsFils); j++) {
				contentDivConcepts1 += ('<div><span concept_id="x" style="font-size: 0.8em;">' + concept.conceptsFils[i].conceptsFils[j].nom + '</span></div>');
			}
			contentDivConcepts1 += '</div>';
		}
		$('div#concepts1 div#blockContent').html($(contentDivConcepts1));
	}

	$(document).ready(function () {

		//$('div#concepts1').html('a');
		selectConceptCarre(conceptIdSelection);

		createGraph(dataset, "div#concepts0");
		//$("svg g.nodes, svg text").click(function(event){
		$("svg g.nodes").click(function(event){
			var id = $(event.target).attr("node_id");
			var contenuElementClique;

			Object.keys(dataset.nodes).forEach(function (key) {
				if(dataset.nodes[key].id == id){
					contenuElementClique = dataset.nodes[key].name;
				}
			});
			
			$('#queryInput').val(contenuElementClique);
			$('#queryInput').focus();
			form.submit();
		});

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

		$('div#concepts1 div#blockContent span').click(function(event){
			var contenuElementClique = $(event.target).html();
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

			// Coloration de l'élément sélectionné dans le graphe
			Object.keys(dataset.nodes).forEach(function (key) {
				if(dataset.nodes[key].name == $('#queryInput').val()){
					dataset.nodes[key].node_selected = true;
				}else{
					dataset.nodes[key].node_selected = false;
				}
			});
			tickActions();

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
						$('#articlesList ul').append('<li id="liArticle'+article.id+'" class="collection-item"><a href="./?r=article/showById&id=' + article.id + '">' + article.nom + '</a><span class="badge grey white-text">' + score + '</span></li>');


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

									$('#referencesList ul').append('<li class="collection-item animated fadeIn"><span class="refConcept" id="ontoTerminologieElementName' + ref.concept.id + '">' + ref.contexte + '</li>');
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

