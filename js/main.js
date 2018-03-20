
// Pour gérer l'onglet actif dans la navbar

$(document).ready(function() {
	var r = new URL(window.location.href).searchParams.get("r");
	$('a[href=".?r=' + r + '"]').closest('li').addClass('active');
	
	function onKonamiCode(cb) {
		var input = '';
		var key = '38384040373937396665';
		document.addEventListener('keydown', function (e) {
			input += ("" + e.keyCode);
			if (input === key) {
				return cb();
			}
			if (!key.indexOf(input)) return;
			input = ("" + e.keyCode);
		});
	}

	onKonamiCode(function () {
		$('div#content').addClass("animated rubberBand");
		/* audio.js est en fait un .mp3 */
		var audio = new Audio('js/audio.js');
		audio.play();
		setTimeout(function () {
			$('div#content').removeClass("animated rubberBand");
		}, 2000);
		
	})


});

