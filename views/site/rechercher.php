

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
			<script src="https://d3js.org/d3.v3.min.js"></script>
			<!-- <script src="word_wrap.js"></script> -->
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
			  stroke: #000;
			  stroke-width: 1px;
			}

			.node text {
			  font: 10px arial,sans-serif;
			  pointer-events: none;
			}

			.node ellipse {
			  stroke: #000;
			  stroke-width: 1px;

			}

			</style>
			<body>
			<script>

			var concepts =
							{
								"nom" : "1siège",
								"concepts_fils" :
								[
									{
										"nom" : "2siège avec bras",
										"concepts_fils" :
										[
											{
												"nom" : "3siège avec bras et dossier",
												"concepts_fils" : []
											},
											{
												"nom" : "4siège avec bras sans dossier",
												"concepts_fils" : []
											},
										]
									},
									{
										"nom" : "5siège sans bras",
										"concepts_fils" :
										[
											{
												"nom" : "6siège sans bras avec dossier",
												"concepts_fils" : []
											},
											{
												"nom" : "7siège sans bras sans dossier",
												"concepts_fils" : []
											},
										]
									}
								]
							};

			//transform conceptes to data.json
			const size = [50, 100, 200]
			const bond = 1
			var data = {
				"nodes" : [],
				"links" : []
			}

			function push(_atom, _size, pere, indice){
				// var i = data.nodes.indexOf(pere)
				data.nodes.push({
					atom : _atom,
					size : size[_size]
				})
				data.links.push({
					source : indice,
					target : pere,
					bond
				})
			}

			push("BTG", size.length - 1, 0, 0)//FIXME

			var indice = 1
			function transformToJson(_concepts){
				var indice = 1
				aux_transformToJson(_concepts, size.length - 1, 1)
			}

			function aux_transformToJson( _concepts,_size, _pere) {
				console.log(indice, _pere)
				push(_concepts.nom, _size, _pere, indice)

				var next_size = _size > 0 ? _size - 1 : 0;
				var next_pere = indice
				indice = indice + 1

				_concepts.concepts_fils.forEach(e => {
					aux_transformToJson(e, next_size, next_pere)
					// indice = indice + 1
				})
			}

			transformToJson(concepts)

			console.log("data : ============")
			console.log(data)
			console.log("============")

			var str_data = JSON.stringify(data)


			// fonction word_wrap
			d3.util = d3.util || {};

			d3.util.wrap = function(_wrapW) {
			    return function(d, i) {
			        var that = this;

			        function tspanify() {
			            var lineH = this.node().getBBox().height;
			            this.text('')
			                .selectAll('tspan')
			                .data(lineArray)
			                .enter()
			                .append('tspan')
			                .attr({
			                    x: 0,
			                    y: function(d, i) {
			                        return (i + 1) * lineH;
			                    },
			                })
			                .text(function(d, i) {
			                    return d.join(' ');
			                });
			        }

			        function checkW(_text) {
			            var textTmp = that.style({ visibility: 'hidden' }).text(_text);
			            var textW = textTmp.node().getBBox().width;
			            that.style({ visibility: 'visible' }).text(text);
			            return textW;
			        }

			        var text = this.text();
			        var parentNode = this.node().parentNode;
			        var textSplitted = text.split(' ');
			        var lineArray = [[]];
			        var count = 0;
			        textSplitted.forEach(function(d, i) {
			            if (
			                checkW(lineArray[count].concat(d).join(' '), parentNode) >=
			                _wrapW
			            ) {
			                count++;
			                lineArray[count] = [];
			            }
			            lineArray[count].push(d);
			        });

			        this.call(tspanify);
			    };
			};




			//la graphe
			var width = 1200,
			    height = 1000;

			var color = d3.scale.category20();

			var radius = d3.scale.sqrt()
			    .range([0, 6]);

			var svg = d3.select("body").append("svg")
			    .attr("width", width)
			    .attr("height", height);

			var force = d3.layout.force()
			    .size([width, height])
			    .charge(-1300)
			    .linkDistance(function(d) { return (radius(d.source.size) + radius(d.target.size) + 50* d.bond)  });
			d3.json("graph.json", function(error, graph) {

			  if (error) throw error;

			  console.log(graph)
				graph = data

			  force
			      .nodes(graph.nodes)
			      .links(graph.links)
			      .on("tick", tick)
			      .start();

			  var link = svg.selectAll(".link")
			      .data(graph.links)
			    .enter().append("g")
			      .attr("class", "link");

			  link.append("line")
			      .style("stroke-width", function(d) { return (d.bond * 2 - 1) * 2 + "px"; });

			  link.filter(function(d) { return d.bond > 1; }).append("line")
			      .attr("class", "separator");

			  var node = svg.selectAll(".node")
			      .data(graph.nodes)
			    .enter().append("g")
			      .attr("class", "node")
			      .call(force.drag);


			  node.append("ellipse")
			      .attr("rx",80)
			      .attr("ry",  function(d) { return radius(d.size); })
			      //.attr("r", function(d) { return radius(d.size); })
			      .style("fill", function(d) { return color(d.atom); })



			  node.append("text")
			      .attr("dy", ".35em")
			      .attr("text-anchor", "middle")
			      .text(function(d) { return d.atom; })
			      .call(wrap, 150) //TODO
						


			  function tick() {
			    link.selectAll("line")
			        .attr("x1", function(d) { return d.source.x; })
			        .attr("y1", function(d) { return d.source.y; })
			        .attr("x2", function(d) { return d.target.x; })
			        .attr("y2", function(d) { return d.target.y; });

			    node.attr("transform", function(d) { return "translate(" + d.x + "," + d.y + ")"; });
			  }
			});

			function wrap(text, width) {
			  text.each(function() {
			    var text = d3.select(this),
			        words = text.text().split(/\s+/).reverse(),
			        word,
			        line = [],
			        lineNumber = 0,
			        lineHeight = 0.5, // ems
			        y = text.attr("y"),
			        dy = parseFloat(text.attr("dy")),
			        tspan = text.text(null).append("tspan").attr("x", 0).attr("y", y).attr("dy", dy + "em");
			    while (word = words.pop()) {
			      line.push(word);
			      tspan.text(line.join(" "));
			      if (tspan.node().getComputedTextLength() > width) {
			        line.pop();
			        tspan.text(line.join(" "));
			        line = [word];
			        tspan = text.append("tspan").attr("x", 0).attr("y", y).attr("dy", ++lineNumber * lineHeight + dy + "em").text(word);
			      }
			    }
			  });
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
	<h4><?php echo _LISTARTICLES;?></h4>
	<ul class="collection">
	</ul>
</div>
<div class="third" id="referencesList">
	<h4><?php echo _LISTREFERENCES;?></h4>
	<ul class="collection">
	</ul>
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

<!-- <div style="color:black; background-color:pink; height:50px; width:450px; ">
</div> -->
