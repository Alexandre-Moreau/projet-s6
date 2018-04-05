			<div class="spaced">
				<h2 id='titleArticle'>Articles</h2>
				<div class="card">
					<div class="card-body">Articles totaux: <span class="badge badge-default" id="nbArticles"><?php echo $data['nbArticles']; ?></span></div>
					<div class="card-body">Articles non référencés: <span class="badge badge-default" id="nbArticlesNRef"><?php echo count($data['articlesNRef']); ?></span></div>
					<div class="card-body">Erreur de correspondance avec les fichiers du disque: <span class="badge badge-default" id="nbNoncorrespondancesFichiersDisque"><?php echo count($data['fichiersNonCurrespondantsDisque'])+count($data['fichiersNonCurrespondantsBdd']); ?></span></div>
				</div>
				<h2 id='titleOnto'>Ontoterminologie</h2>
				<div class="card">
					<div class="card-body">Nombre de racines: <span class="badge badge-default"><?php echo count($data['racinesOnto']); ?></span></div>
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
					var erreurArticle = false;
					var erreurOnto = false;
					
					if($('#nbArticles').html() == 0){
						$('#nbArticles').removeClass('badge-default');
						$('#nbArticles').addClass('badge-warning');
						erreurArticle = true;
					}else{
						if($('#nbArticlesNRef').html() == 0){
							$('#nbArticlesNRef').removeClass('badge-default');
							$('#nbArticlesNRef').addClass('badge-success');
						}else{
							$('#nbArticlesNRef').removeClass('badge-default');
							$('#nbArticlesNRef').addClass('badge-danger');
							erreurArticle = true;
						}
					}
					if($('#nbNoncorrespondancesFichiersDisque').html() > 0){
						$('#nbNoncorrespondancesFichiersDisque').removeClass('badge-default');
						$('#nbNoncorrespondancesFichiersDisque').addClass('badge-danger');
						erreurArticle = true;
					}else{
						$('#nbNoncorrespondancesFichiersDisque').removeClass('badge-default');
						$('#nbNoncorrespondancesFichiersDisque').addClass('badge-success');
					}
					if(erreurArticle){
						$('h2#titleArticle').append('<span style="font-size: 40%; vertical-align: text-top" class="badge badge-danger">!</span>');
					}
					if(erreurOnto){
						$('h2#titleOnto').append('<span style="font-size: 40%; vertical-align: text-top" class="badge badge-danger">!</span>');
					}
					
					
				});
			</script>
