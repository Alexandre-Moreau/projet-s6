<?php
	echo '
		<div style="float: right">
		<a href=".?r=article/modifier&id='.$_GET['id'].'"><img class="imageIcon" src="./images/edit.svg" alt="'._EDIT.'" title="'._EDIT.'"></a>
		<a href=".?r=article/supprimer&id='.$_GET['id'].'"><img class="imageIcon" src="./images/delete.svg" alt="'._DELETE.'" title="'._DELETE.'"></a>
		</div>';
	if($data['article']->type == 'pdf'){
		echo('
		<h1 class="display-3">'.$data['article']->nom.'
		<a style="font-size:50%" href="./'.$data['article']->chemin.'" target="_blank">&#x2197;</a>
		</h1>
		');
		if(file_exists($data['article']->chemin)){
			echo ('
			<object data="'.$data['article']->chemin.'" type="application/pdf">
				<p>'._NO_PDF.'<a href="'.$data['article']->chemin.'">'._PDF_DL.'</a>.</p>
			</object>
			');
			
		}else{
			echo '<div class="object">
				<div class="alert alert-danger">
					<strong>'._FILE_NOT_FOUND.'</strong><br/>'._WHY_ERROR.
				'</div>
			</div>';
		}
	}else{
		echo('
		<h1 class="display-3">'.$data['article']->nom.'
		<a style="font-size:50%" href="./'.$data['article']->chemin.'" target="_blank">&#x2197;</a>
		</h1>
		');
		echo '<div class="object">';
		if((@include($data['article']->chemin)) === false){
			echo '<div class="alert alert-danger">
				<strong>'._FILE_NOT_FOUND.'</strong><br/>'._WHY_ERROR.
			'</div>';
		}
		echo '</div>';
	}
?>
<div>
	
	<ul class="collection with-header">
		<li class="collection-header">
			<h3><?php echo _REFERENCE; ?></h3>
		</li>
		<?php
			$refsAffichees = [];
			foreach($data['references'] as $reference){
				if(!isset($refsAffichees[$reference->concept->nom])){
					$refsAffichees[$reference->concept->nom] = 1;
				}else{
					$refsAffichees[$reference->concept->nom] = $refsAffichees[$reference->concept->nom] + 1;
				}
			}
			// tri par nombre référence décroissant
			arsort($refsAffichees);
			foreach($refsAffichees as $nom => $valeur){
				echo '<li class="collection-item">'.$nom.'<span class="badge grey white-text">'.$valeur.'</span></li>';
			}
		?>
	</ul>
	<div>
	</div>
</div>
