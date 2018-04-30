<div class="fileIconDiv">
	<a href=".?r=article/create"><image class="fileIcon" src="./images/file-add.svg"></a>
</div>
<?php
	foreach($data['articles'] as $article){
			echo '<div class="fileIconDiv">';
			echo '<a href=".?r=article/showById&id='.$article->id.'"><image class="fileIcon" src="./images/file-'.$article->type.'.svg">'.$article->nom.'</a>';
			echo '</div>';
		}
?>
