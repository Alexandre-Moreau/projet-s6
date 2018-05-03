			<h2 id='titleDb'><?php echo _DATABASE;?></h2>
				<div class="card">
					<div class="card-body"><?php echo _SERVER_CONNECTION;?> : <span class="badge badge-default" id="nbArticles"><?php echo $data['statut']['reussite']; ?></span></div>
					<div id="infoSupConnexionBdd"></div>
				</div>
			<script>
				<?php printJsVar('statut', $data['statut']);?>
				$(document).ready(function(){
					if($('#nbArticles').html() == '2'){
						$('#nbArticles').html('&#x2713;');
						$('#nbArticles').removeClass('badge-default');
						$('#nbArticles').addClass('badge-success');
					}else if($('#nbArticles').html() == '1'){
						$('#nbArticles').html('!');
						$('#nbArticles').removeClass('badge-default');
						$('#nbArticles').addClass('badge-warning');
						$('#infoSupConnexionBdd').append('<span class="badge badge-warning">'+'<?php echo 'base de données inconnue';?></span>');
					}else{
						$('#nbArticles').html('!');
						$('#nbArticles').removeClass('badge-default');
						$('#nbArticles').addClass('badge-danger');
						$('#infoSupConnexionBdd').append('<span class="badge badge-danger">'+'<?php echo $data['statut']['message'];?></span>');
					}
				});
			</script>
