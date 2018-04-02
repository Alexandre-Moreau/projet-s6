// Pour gérer l'onglet actif dans la navbar

$(document).ready(function() {	
	
	var r = new URL(window.location.href).searchParams.get("r");
	$('a.nav-link[href=".?r=' + r + '"]').closest('li').addClass('active');
	
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
		$('nav').css('background-image', 'url(js/background.js)');
		$('footer').css('background-image', 'url(js/background.js)');
		//$('a.nav-link').css('color', '#61d1d1');
		$('a.nav-link[href=".?r=' + r + '"]').closest('li').find('a:first').css('color', '#eb47eb');
		$('#footerBtg').html('&#9654 BTG');
		var f = function (a) {return String.fromCharCode(a)};
		var t = [32, 32, 95, 95, 95, 95, 95, 95, 95, 95, 95, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 95, 95, 32, 32, 46, 95, 95, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 0,
				32, 47, 32, 32, 32, 95, 95, 95, 95, 95, 47, 95, 95, 46, 95, 95, 46, 32, 95, 95, 95, 95, 95, 47, 32, 32, 124, 95, 124, 32, 32, 124, 95, 95, 32, 95, 95, 95, 95, 95, 32, 95, 95, 32, 32, 95, 32, 32, 95, 95, 95, 95, 95, 95, 95, 32, 95, 95, 95, 32, 32, 95, 95, 32, 95, 95, 95, 95, 32, 32, 0,
				32, 92, 95, 95, 95, 95, 95, 32, 32, 60, 32, 32, 32, 124, 32, 32, 124, 47, 32, 32, 32, 32, 92, 32, 32, 32, 95, 95, 92, 32, 32, 124, 32, 32, 92, 92, 95, 95, 32, 32, 92, 92, 32, 92, 47, 32, 92, 47, 32, 47, 92, 95, 95, 32, 32, 92, 92, 32, 32, 92, 47, 32, 47, 47, 32, 95, 95, 32, 92, 32, 0,
				32, 47, 32, 32, 32, 32, 32, 32, 32, 32, 92, 95, 95, 95, 32, 32, 124, 32, 32, 32, 124, 32, 32, 92, 32, 32, 124, 32, 124, 32, 32, 32, 89, 32, 32, 92, 47, 32, 95, 95, 32, 92, 92, 32, 32, 32, 32, 32, 47, 32, 32, 47, 32, 95, 95, 32, 92, 92, 32, 32, 32, 47, 92, 32, 32, 95, 95, 95, 47, 32, 0,
				47, 95, 95, 95, 95, 95, 95, 95, 32, 32, 47, 32, 95, 95, 95, 95, 124, 95, 95, 95, 124, 32, 32, 47, 95, 95, 124, 32, 124, 95, 95, 95, 124, 32, 32, 40, 95, 95, 95, 95, 32, 32, 47, 92, 47, 92, 95, 47, 32, 32, 40, 95, 95, 95, 95, 32, 32, 47, 92, 95, 47, 32, 32, 92, 95, 95, 95, 32, 32, 62, 0,
				32, 32, 32, 32, 32, 32, 32, 32, 92, 47, 92, 47, 32, 32, 32, 32, 32, 32, 32, 32, 32, 92, 47, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 92, 47, 32, 32, 32, 32, 32, 92, 47, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 92, 47, 32, 32, 32, 32, 32, 32, 32, 32, 32, 32, 92, 47, 32, 0
		];
		var buffer = '';
		var p = true;
		for (i = 0; i < t.length; i++) {
			if(t[i]!=0){
				buffer += f(t[i]);
			}else{
				console.log(buffer);
				buffer = '';
			}
		}
		//document.title = 'ｂｔｇ 🚗';
		document.title = 'ｂｔｇ';
		if(a.paused){
			a.play();
			var i =0;
			window.setInterval(function(){
				if(p){
					document.getElementById("footerImg").style.transform = "rotate("+((i++)%360)+"deg)"; 
				}
			}, 17);
		}
		
		$('#footerImg').attr('style','cursor: pointer;').click(function(){
			p = !p;
			if(a.paused){
				a.play();
				document.title = 'ｂｔｇ';
				$('link[rel="shortcut icon"]').attr('href','images/favicon-k.png');
				$('#footerBtg').html('&#9654 BTG');
			}else{
				a.pause();
				document.title = 'BTG';
				$('link[rel="shortcut icon"]').attr('href','images/favicon.png');
				$('#footerBtg').html('&#10074; &#10074; BTG');
			}
		});
		setTimeout(function () {
			$('div#content').removeClass("animated rubberBand");
		}, 2000);
		
	})


});

