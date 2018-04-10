			<div class="spaced">
				<h2 id='titleArticle'><?php echo _ARTICLES;?></h2>
				<div class="card">
					<div class="card-body">Articles totaux: <span class="badge badge-default" id="nbArticles"><?php echo $data['nbArticles']; ?></span></div>
					<div class="card-body">Articles non référencés: <span class="badge badge-default" id="nbArticlesNRef"><?php echo count($data['articlesNRef']); ?></span>
					<div id="articlesNRef"></div>
					</div>
					<div class="card-body">Emplacement: <span class="badge badge-default" id="nbArticles"><?php echo $data['emplacement']; ?></span></div>
					<div class="card-body">Erreurs de correspondance avec les fichiers du disque: <span class="badge badge-default" id="nbNoncorrespondancesFichiersDisque"><?php echo count($data['fichiersNonCorrespondantsDisque'])+count($data['fichiersNonCorrespondantsBdd']); ?></span>
					<div id="fichiersNCB"></div>
					<div id="fichiersNCD"></div>
					</div>
				</div>
				<h2 id='titleOnto'><?php echo _ONTO;?></h2>
				<div class="card">
					<div class="card-body">Nombre de racines: <span class="badge badge-default" id="nbracinesOnto"><?php echo count($data['racinesOnto']); ?></span></div>
					<div class="card-body">Erreurs de construction: <span class="badge badge-default"><?php echo '-1'; ?></span></div>
				</div>
				<button type="button" class="btn btn-info" data-toggle="collapse" data-target="#showMore"><?php echo _ADVANCED?></button>
				<div id="showMore" class="collapse">
					<h2><?php echo _SYSTEM?></h2>
					<div class="card">
						<div class="card-body"><?php echo _SERVUSER?>: <span class="badge badge-default"><?php echo $data['serverUser']; ?></span></div>
					</div>
					<h2><?php echo _NETWORK?></h2>
					<div class="card">
						<div class="card-body"><?php echo _SERVERIP;?>: <span class="badge badge-default"><?php echo $data['ipServeur']; ?></span></div>
						<div class="card-body"><?php echo _CLIENTIP;?>: <span class="badge badge-default"><?php echo $data['ipClient']; ?></span></div>
					</div>
				</div>
			</div>
			<script>
				$(document).ready(function(){
					var statutArticle = {warning:false,erreur: false};
					var statutOnto = {warning: false,erreur: false};
					
					<?php printJsVar('articlesNRef', $data['articlesNRef']); ?>
					
					<?php printJsVar('fichiersNCD', $data['fichiersNonCorrespondantsDisque']); ?>
					
					<?php printJsVar('fichiersNCB', $data['fichiersNonCorrespondantsBdd']);?>
					
					if($('#nbArticles').html() == 0){
						$('#nbArticles').removeClass('badge-default');
						$('#nbArticles').addClass('badge-warning');
						statutArticle['warning'] = true;
					}else{
						if($('#nbArticlesNRef').html() == 0){
							$('#nbArticlesNRef').removeClass('badge-default');
							$('#nbArticlesNRef').addClass('badge-success');
						}else{
							$('#nbArticlesNRef').removeClass('badge-default');
							$('#nbArticlesNRef').addClass('badge-warning');
							statutArticle['warning'] = true;
						}
					}
					for(var key in articlesNRef){
							$('div#articlesNRef').append('<span class="badge badge-warning">'+articlesNRef[key]+'</span>');
						}
					if($('#nbNoncorrespondancesFichiersDisque').html() > 0){
						if(Object.keys(fichiersNCB).length>0){
							$('#nbNoncorrespondancesFichiersDisque').removeClass('badge-default');
							$('#nbNoncorrespondancesFichiersDisque').addClass('badge-danger');
							statutArticle['erreur'] = true;
						}else{
							$('#nbNoncorrespondancesFichiersDisque').removeClass('badge-default');
							$('#nbNoncorrespondancesFichiersDisque').addClass('badge-warning');
							statutArticle['warning'] = true;
						}
					}else{
						$('#nbNoncorrespondancesFichiersDisque').removeClass('badge-default');
						$('#nbNoncorrespondancesFichiersDisque').addClass('badge-success');
					}
					if(Object.keys(fichiersNCB).length>0){
						$('div#fichiersNCB').append('Fichiers manquant sur le disque:');
						for(var key in fichiersNCB){
							$('div#fichiersNCB').append('<span class="badge badge-danger">'+fichiersNCB[key].chemin+' ('+fichiersNCB[key].nom+')</span>');
						}
					}
					if(Object.keys(fichiersNCD).length>0){
						$('div#fichiersNCD').append('Fichiers en trop sur le disque:');
						for(var key in fichiersNCD){
							$('div#fichiersNCD').append('<span class="badge badge-warning">'+fichiersNCD[key]+'</span>');
						}
					}
					if($('#nbracinesOnto').html() == 0){
						$('#nbracinesOnto').removeClass('badge-default');
						$('#nbracinesOnto').addClass('badge-warning');
						statutOnto['warning'] = true;
					}
					if(statutArticle['erreur']){
						$('h2#titleArticle').append('<span style="font-size: 40%; vertical-align: text-top" class="badge badge-danger">!</span>');
					}else if(statutArticle['warning']){
						$('h2#titleArticle').append('<span style="font-size: 40%; vertical-align: text-top" class="badge badge-warning">!</span>');
					}else{
						$('h2#titleArticle').append('<span style="font-size: 40%; vertical-align: text-top" class="badge badge-success">&#x2713;</span>');
					}
					if(statutOnto['erreur']){
						$('h2#titleOnto').append('<span style="font-size: 40%; vertical-align: text-top" class="badge badge-danger">!</span>');
					}else if(statutOnto['warning']){
						$('h2#titleOnto').append('<span style="font-size: 40%; vertical-align: text-top" class="badge badge-warning">!</span>');
					}else{
						$('h2#titleOnto').append('<span style="font-size: 40%; vertical-align: text-top" class="badge badge-success">&#x2713;</span>');
					}
					
					
				});
			</script>
