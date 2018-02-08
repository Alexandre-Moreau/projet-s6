<form action="#" method="POST" class="form-inline my-2 my-lg-0">

	<input class="form-control mr-sm-2" type="text" placeholder="Search">
	<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>

</form>
<div class="onto">
	<?php
		function printRecursive($concept, $callStack){
			echo '&#x2514;'.str_repeat('&#x2500;', $callStack).' '.$concept->nom.'<br/>';
			$callStack++;
			foreach($concept->conceptsFils as $fils){
				printRecursive($fils, $callStack);
			}
		}
		foreach($data as $data0){
			foreach($data0 as $conceptRacine){
				printRecursive($conceptRacine, 0);
			}
		}
	?>
</div>