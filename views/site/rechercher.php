<form method="post" action =".?r=Article/ajaxRechercher" enctype="multipart/form-data" class="form-inline my-2 my-lg-0">

	<input class="form-control mr-sm-2" type="text" id="queryInput" placeholder="<?php echo _SEARCH;?>">
	<button class="btn waves-effect waves-light" type="submit"><?php echo _SEARCH;?></button>

</form>
<!--
<div style = "width:500px;hight:500px">
<script src="//d3js.org/d3.v3.min.js"></script>
<h1>Interface graphique</h1>
<script>
var body = d3.select('body');   //选择body元素
body.append('h1')    //向 body元素中插入 h1标签
  .text('Hello world')    // 给h1标签填充文字为hello world
  .style('color','red');   //修改样式 字体颜色 为红色

</script>
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
				foreach($data['onto'] as $conceptRacine){
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
