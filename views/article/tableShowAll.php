<?php
	if($data['articles'] != []){
		echo('
		<table class="tableAffichage">
			<tr><th>Nom</th><th>Type</th></tr>'
		);
		foreach($data['articles'] as $article){
			echo '<tr><td><a href=".?r=Article/showById&id='.$article->id.'">'.$article->nom.'</a></td><td><a href=".?r=Article/showById&id='.$article->id.'">'.$article->type.'</a></td></tr>';
		}
		echo('</table>');
	}else{
		echo '<p>Aucun article</p>';
		echo '<a href=".?r=Article/create"><button class="btn btn-outline-success my-2 my-sm-0">Ajouter un article</button></a>';
	}
?>