<?php
	if($data['article']->type == 'pdf'){
		echo('
		<object data="'.$data['article']->chemin.'" type="application/pdf">
			<p>Ce navigateur ne permet pas de visualiser les pdf: <a href="'.$data['article']->chemin.'">Télécharger le pdf</a>.</p>
		</object>'
		);
	}else{
		include($data['article']->chemin);
	}
?>