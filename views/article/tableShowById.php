<?php
	echo '
		<div style="float: right">
		<a href=".?r=article/modifier&id='.$_GET['id'].'"><img class="imageIcon" src="./images/edit.svg" alt="'._EDIT.'" title="'._EDIT.'"></a>
		<a href=".?r=article/supprimer&id='.$_GET['id'].'"><img class="imageIcon" src="./images/delete.svg" alt="'._DELETE.'" title="'._DELETE.'"></a>
		</div>';
	if($data['article']->type == 'pdf'){
		echo('		
		<h1 class="display-3">'.$data['article']->nom.'
		<a style="font-size:50%" href="./'.$data['article']->chemin.'" target="_blank">&#x2197;<!-&rarr;-></a>
		</h1>
		<object data="'.$data['article']->chemin.'" type="application/pdf">
			<p>Ce navigateur ne permet pas de visualiser les pdf: <a href="'.$data['article']->chemin.'">Télécharger le pdf</a>.</p>
		</object>
		');
	}else{
		echo('
		<h1 class="display-3">'.$data['article']->nom.'
		<a style="font-size:50%" href="./'.$data['article']->chemin.'" target="_blank">&#x2197;</a>
		</h1>		
		');
		echo '<div class="object">';
		include($data['article']->chemin);
		echo '</div>';
	}
?>
<div>
	<h3 class="display-5">
		<?php echo _REFERENCE; ?>
	</h3>
	<ul class="list-group">
	<?php
		foreach($data['references'] as $reference){
			echo '<li class="list-group-item justify-content-between" style="width: 40%">'.$reference->concept->nom.'<span class="badge badge-default badge-pill">'.$reference->nombreRef.'</span></li>';
		}
	?>
	</ul>
	<div>
	</div>
</div>
