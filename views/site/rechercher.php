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
			<!-- partie de definition de style et import des bibliotheques -->
			<script src="https://d3js.org/d3.v4.js"></script>
			<script src="http://d3js.org/d3.v3.min.js"></script>
			<style>
				.node text 
				{
					font: 12px sans-serif;
				}
				.link 
				{
					fill: none;
					stroke: #ccc;
					stroke-width: 2px;
				}
			</style>

			<!-- partie script pour creer la graphe -->
			<script>
				// variable pour tester, on prend ce type de variables pour creer un graphe
				var concepts = 
				{
					"nom": "Monde",
					"children":
					[	
						{
							"nom": "siège",
							"children": 
							[
								{
									"nom": "siège avec bras",
									"children": 
									[
										{
											"nom": "siège avec bras et dossier yes or no you can duo"
										},
										{
											"nom" : "siège avec bras sans dossier",
										},
									]

								},

								{
									"nom": "siège sans bras",
									"children": 
									[
										{
											"nom" : "siège sans bras avec dossier",
											"children":[]
										},
										{
											"nom" : "siège sans bras sans dossier",
											"children":[]
										}
									]
								},
							]
						},
						{
							"nom": "Matière",
							"children": 
							[
								{
									"nom": "Matière artificielle",
									"children":[]
								},
								{
									"nom": "Matière composite",
									"children":[]
								},								
								{
									"nom": "Matière naturelle",
									"children":
									[
										{
											"nom": "Matière naturelle minérale",
											"children":[]
										},
										{
											"nom": "Matière naturelle végétale",
											"children":[]
										}
									]
								},
							]
						}
					]
				};
				
				// deuxieme variable pour tester ------------------------------
				var concepts2 = {
					nom : "siège",
					"children" : [
						{
							"nom" : "siège avec bras",
							"children" : [
								{
									"nom" : "siège avec bras et dossier",
									"children" : []
								},
								{
									"nom" : "siège avec bras sans dossier",
									"children" : []
								},
							]
						},
						
						{
							nom : "siège sans bras",
							"children" : [
								{
									"nom" : "siège sans bras avec dossier",
									"children" : []
								},
								{
									"nom" : "siège sans bras sans dossier",
									"children" : []
								},
							]
						}
					]
				};

				// gestion du diagram -----------------------------------------
				var margin = {top: 20, right: 120, bottom: 20, left: 120},
					width = 1260 - margin.right - margin.left,
					height = 800 - margin.top - margin.bottom;
				var i = 0, duration = 750, root; // duration : temps de duree de la reaction
				var tree = d3.layout.tree()
					.size([height, width]);
				var diagonal = d3.svg.diagonal()
					.projection(function(d) { return [d.y, d.x]; });

				// le canvas --------------------------------------------------
				var svg = d3.select("body").append("svg")
					.attr("width" , width  + margin.right + margin.left)
					.attr("height", height + margin.top   + margin.bottom)
					.append("g")
					.attr("transform", "translate(" + margin.left + "," + margin.top + ")");
				root = concepts;// le premier noeud, modifier la variable pour tester
				root.x0 = height / 2;
				root.y0 = 0;
				update(root);
				d3.select(self.frameElement).style("height", "500px");

				// fonction pricipale pour dessiner le graphe -----------------
				function update(source) 
				{
					// Compute the new tree layout.
					var nodes = tree.nodes(root).reverse(),
						links = tree.links(nodes);
						nodes.forEach(function(d) { d.y = d.depth * 180; });// Normalize for fixed-depth.

					// Update the nodes
					var node = svg.selectAll("g.node")
						.data(nodes, function(d) { return d.id || (d.id = ++i); });

					// Enter any new nodes at the parent's previous position.
					var nodeEnter = node.enter().append("g") 
						.attr("class", "node")
						.attr("transform", function(d) { return "translate(" + source.y0 + "," + source.x0 + ")"; })
						.on("click", click);

						nodeEnter.append("rect")
							.attr("x",-23)
							.attr("y", -10)
							.attr("width",70)
							.attr("height",22)
							.attr("rx",10)
							.style("fill", "#357CAE");

						//ajouter le text
						nodeEnter.append("text")
							.attr("x", function(d) { return d.children || d._children ? 13 : 13; })
							.attr("dy", "8")
							.attr("text-anchor", "middle")//_children
							.text(function(d) { return d.nom; })
							.style("fill", "black")
							.style("fill-opacity", 1e-6);

					// Transition nodes to their new position
					var nodeUpdate = node.transition()
						.duration(duration)
						.attr("transform", function(d) { return "translate(" + d.y + "," + d.x + ")"; });

						nodeUpdate.select("rect")
									.attr("x",-23)
									.attr("y", -18)
									.attr("width",70)
									.attr("height",42)
									.attr("rx",40)
									.style("fill", "#357CAE");

						nodeUpdate.select("text")
							.attr("text-anchor", "middle")
							.style("fill-opacity", 1);
					
					// Transition exiting nodes to the parent's new position.。
					var nodeExit = node.exit().transition()
						.duration(duration)
						.attr("transform", function(d) { return "translate(" + source.y + "," + source.x + ")"; })
						.remove();

						nodeExit.select("rect")
								.attr("x",-23)
								.attr("y", -10)
								.attr("width",70)
								.attr("height",22)
								.attr("rx",10)
								.style("fill", "#357CAE");

						nodeExit.select("text")
							.attr("text-anchor", "middle")
							.style("fill-opacity", 1e-6);

					// Update the links
					var link = svg.selectAll("path.link")
						.data(links, function(d) { return d.target.id; });

						// Enter any new links at the parent's previous position.
						link.enter().insert("path", "g")
							.attr("class", "link")
							.attr("d", function(d) {
								var o = {x: source.x0, y: source.y0};
								return diagonal({source: o, target: o});
							})
							.attr('marker-end', 'url(#arrow)');

						// Transition links to their new position.
						link.transition()
							.duration(duration)
							.attr("d", diagonal);

						// Transition exiting nodes to the parent's new position.
						link.exit()
							.transition()
							.duration(duration)
							.attr("d", function(d) 
							{
								var o = {x: source.x, y: source.y};
								return diagonal({source: o, target: o});
							})
							.remove();

					// Stash the old positions for transition.
					nodes.forEach(function(d) 
					{
						d.x0 = d.x;
						d.y0 = d.y;
					});
				}

				// fonction cliquer pour cacher un noeud avec ses fils
				function click(d) 
				{
					if (d.children) 
					{
						d._children = d.children;
						d.children = null;
					} else 
					{
						d.children = d._children;
						d._children = null;
					}
					update(d);
				}
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
		
		$('div.ontoTerminologieElement span').click(function(event)
		{
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



















