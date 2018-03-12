<?php
/*
	if($data['articles'] != []){
		echo('
		<table class="tableAffichage">
			<tr><th>Nom</th><th>Type</th></tr>'
		);
		foreach($data['articles'] as $article){
			echo '<tr><td><a href=".?r=article/showById&id='.$article->id.'">'.$article->nom.'</a></td><td><a href=".?r=article/showById&id='.$article->id.'">'.$article->type.'</a></td></tr>';
		}
		echo('</table>');
	}else{
		echo '<p>Aucun article</p>';
		echo '<a href=".?r=article/create"><button class="btn btn-outline-success my-2 my-sm-0">Ajouter un article</button></a>';
	}*/
	if($data['articles'] != []){
		foreach($data['articles'] as $article){
			echo '<div class="fileIconDiv">';
			echo '<a href=".?r=article/showById&id='.$article->id.'"><image class="fileIcon" src="./images/file-'.$article->type.'.svg">'.$article->nom.'</a>';
			echo '</div>';
		}
	}else{
		echo '<p>Aucun article</p>';
		echo '<a href=".?r=article/create"><button class="btn btn-outline-success my-2 my-sm-0">Ajouter un article</button></a>';
	}
?>