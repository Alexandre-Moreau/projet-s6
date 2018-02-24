<form method="post" action =".?r=Article/ajaxRecherche" enctype="multipart/form-data" class="form-inline my-2 my-lg-0">

	<input class="form-control mr-sm-2" type="text" id="query" placeholder="Search">
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
<script>
	$(document).ready(function () {
		var form = $('form');

		form.on('submit', function(e) {

			var data = new FormData();

			e.preventDefault();

			data.append('query', $('#query').val());

			$.ajax({
				url: form.attr('action'),
				type: form.attr('method'),						
				data: data,

				cache: false,
				processData: false,
				contentType: false,

				success: function (reponse) {
					if(reponse['log'].length != 0){
						console.log(reponse['log']);
					}
				},
				error: function (xhr, textStatus, errorThrown) {
					console.log(xhr.responseText);
				}
			});
		});
	});

</script>
