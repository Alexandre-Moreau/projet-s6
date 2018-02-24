<?php
	if($data['article']->type == 'pdf'){
		echo('
		<h1 class="display-3">'.$data['article']->nom.'<a style="font-size:50%" href="./'.$data['article']->chemin.'" target="_blank">&#x2197;</a></h1><!-&rarr;->
		<object data="'.$data['article']->chemin.'" type="application/pdf">
			<p>Ce navigateur ne permet pas de visualiser les pdf: <a href="'.$data['article']->chemin.'">Télécharger le pdf</a>.</p>
		</object>'
		);
	}else{
		echo '<h1 class="display-3">'.$data['article']->nom.'<a style="font-size:50%" href="./'.$data['article']->chemin.'" target="_blank">&#x2197;</a></h1>';
		echo '<div class="object">';
		include($data['article']->chemin);
		echo '</div>';
	}
?>
<div>
	<h3 class="display-5">
		Références:
	</h3>
	<?php
		foreach($data['references'] as $reference){
			echo '<div>';
			echo $reference->concept->nom.': '.$reference->nombreRef;
			echo '</div>';
		}
	?>
	<div>
	</div>
</div>
