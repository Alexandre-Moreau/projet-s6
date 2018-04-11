			<?php
				global $errorCodes;
				$statut = dbTest();
				// si la connexion à la bdd a échoué
				if($statut['statut'] == 0){
					// on teste la connexion directement sur le serveur
					$statut = dbTest(false);
				}
			?>
			<h2 id='titleDb'><?php echo _DATABASE;?></h2>
				<div class="card">
					<div class="card-body"><?php echo 'Connexion au serveur'; ?> <span class="badge badge-default" id="nbArticles"><?php echo ($statut['statut']==1) ? '&#x2713;' : '!'; ?></span>
					</div>
				</div>
			<script>
				<?php printJsVar('statut', $statut);?>
				
			</script>