
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

	var a = new Audio('js/audio.js');
	onKonamiCode(function () {
		$('div#content').addClass("animated rubberBand");
		$('link[rel="shortcut icon"]').attr('href','images/favicon-k.png');
		document.title = 'ｂｔｇ';
		if(a.paused){
			a.play();
		}		
		setTimeout(function () {
			$('div#content').removeClass("animated rubberBand");
		}, 2000);
		
	})


});

