			<div class="row">
				<div class="col l6 m6 s12">
					<ul class="collection with-header">
						<li class="collection-header">
							<h2 id='titleArticle'><?php echo _ARTICLES;?></h2>
						</li>
						<li class="collection-item">
							<?php echo _ARTICLES_ALL;?>
							<span class="badge grey white-text" id="nbArticles"><?php echo $data['nbArticles']; ?></span>
						</li>
						<li class="collection-item">
							<?php echo _ARTICLES_NO_REF;?>
							<span class="badge grey white-text" id="nbArticlesNRef"><?php echo count($data['articlesNRef']); ?></span>
							<div id="articlesNRef"></div>
						</li>
						<li class="collection-item">
							<?php echo _LOCATION;?>
							<span class="badge grey white-text" id="nbArticles"><?php echo $data['emplacement']; ?></span>
						</li>
						<li class="collection-item">
							<?php echo _ERROR_DISK_FILE;?>
							<span class="badge grey white-text" id="nbNoncorrespondancesFichiersDisque"><?php echo count($data['fichiersNonCorrespondantsDisque'])+count($data['fichiersNonCorrespondantsBdd']); ?></span>
							<div id="fichiersNCB"></div>
							<div id="fichiersNCD"></div>
						</li>
					</ul>
				</div>
				
				<div class="col l6 m6 s12">
					<ul class="collection with-header">
						<li class="collection-header">
							<h2 id='titleOnto'><?php echo _ONTO;?></h2>
						</li>
						<li class="collection-item"><?php echo _ROOT_NUMBERS;?><span class="badge grey white-text" id="nbracinesOnto"><?php echo count($data['racinesOnto']); ?></span>
						</li>
						<li class="collection-item">
							<?php echo _ERROR_BUILD;?>
							<span class="badge grey white-text"><?php echo '-1'; ?></span>
						</li>
					</ul>
				</div>
				
				<ul class="collapsible popout col l12 m12 s12">
					<li>
						<div class="collapsible-header">
							<i class="material-icons">build</i>
							<?php echo _ADVANCED?>
						</div>
						<div class="collapsible-body">
							<div class="row">
								<div class="col l6 m6 s12">
									<ul class="collection with-header">
										<li class="collection-header">
											<h2><?php echo _NETWORK?></h2>
										</li>
										<li class="collection-item">
											<?php echo _SERVERIP;?>: 
											<span class="badge grey white-text"><?php echo $data['ipServeur']; ?></span>
										</li>
										<li class="collection-item">
											<?php echo _CLIENTIP;?>: 
											<span class="badge grey white-text"><?php echo $data['ipClient']; ?></span>
										</li>
									</ul>
								</div>

								<div class="col l6 m6 s12">
									<ul class="collection with-header">
										<li class="collection-header">
											<h2><?php echo _SYSTEM?></h2>
										</li>
										<li class="collection-item">
											<?php echo _SERVUSER?>: 
											<span class="badge grey white-text"><?php echo $data['serverUser']; ?></span>
										</li>
									</ul>
								</div>
							</div>
							
						</div>
					</li>
				</ul>

			</div>

			<script>
				$(document).ready(function(){
					var statutArticle = {warning:false,erreur: false};
					var statutOnto = {warning: false,erreur: false};
					
					<?php printJsVar('articlesNRef', $data['articlesNRef']); ?>
					
					<?php printJsVar('fichiersNCD', $data['fichiersNonCorrespondantsDisque']); ?>
					
					<?php printJsVar('fichiersNCB', $data['fichiersNonCorrespondantsBdd']);?>
					
					
					if($('#nbArticles').html() == 0){
						$('#nbArticles').removeClass('grey');
						$('#nbArticles').addClass('warning');
						statutArticle['warning'] = true;
					}else{
						if($('#nbArticlesNRef').html() == 0){
							$('#nbArticlesNRef').removeClass('grey');
							$('#nbArticlesNRef').addClass('success');
						}else{
							$('#nbArticlesNRef').removeClass('grey');
							$('#nbArticlesNRef').addClass('warning');
							statutArticle['warning'] = true;
						}
					}
					for(var key in articlesNRef){
						$('div#articlesNRef').append('<span class="badge warning">'+articlesNRef[key]+'</span>');
					}
					if($('#nbNoncorrespondancesFichiersDisque').html() > 0){
						if(Object.keys(fichiersNCB).length>0){
							$('#nbNoncorrespondancesFichiersDisque').removeClass('grey');
							$('#nbNoncorrespondancesFichiersDisque').addClass('danger');
							statutArticle['erreur'] = true;
						}else{
							$('#nbNoncorrespondancesFichiersDisque').removeClass('grey');
							$('#nbNoncorrespondancesFichiersDisque').addClass('warning');
							statutArticle['warning'] = true;
						}
					}else{
						$('#nbNoncorrespondancesFichiersDisque').removeClass('grey');
						$('#nbNoncorrespondancesFichiersDisque').addClass('success');
					}
					if(Object.keys(fichiersNCB).length>0){
						$('div#fichiersNCB').append('Fichiers manquant sur le disque:');
						for(var key in fichiersNCB){
							$('div#fichiersNCB').append('<span class="badge danger">'+fichiersNCB[key].chemin+' ('+fichiersNCB[key].nom+')</span>');
						}
					}
					if(Object.keys(fichiersNCD).length>0){
						$('div#fichiersNCD').append('Fichiers en trop sur le disque:');
						for(var key in fichiersNCD){
							$('div#fichiersNCD').append('<span class="badge warning white-text">'+fichiersNCD[key]+'</span>');
						}
					}
					if($('#nbracinesOnto').html() == 0){
						$('#nbracinesOnto').removeClass('grey');
						$('#nbracinesOnto').addClass('warning');
						statutOnto['warning'] = true;
					}
					if(statutArticle['erreur']){
						$('h2#titleArticle').append('<span style="font-size: 18px; vertical-align: text-top" class="badge danger white-text">!</span>');
					}else if(statutArticle['warning']){
						$('h2#titleArticle').append('<span style="font-size: 18px; vertical-align: text-top" class="badge warning white-text">!</span>');
					}else{
						$('h2#titleArticle').append('<span style="font-size: 18px; vertical-align: text-top" class="badge success white-text">&#x2713;</span>');
					}
					if(statutOnto['erreur']){
						$('h2#titleOnto').append('<span style="font-size: 18px; vertical-align: text-top" class="badge danger white-text">!</span>');
					}else if(statutOnto['warning']){
						$('h2#titleOnto').append('<span style="font-size: 18px; vertical-align: text-top" class="badge warning white-text">!</span>');
					}else{
						$('h2#titleOnto').append('<span style="font-size: 18px; vertical-align: text-top" class="badge success white-text">&#x2713;</span>');
					}
				});
			</script>
