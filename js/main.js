
// Pour gérer l'onglet actif dans la navbar

$(document).ready(function() {
	var r = new URL(window.location.href).searchParams.get("r");
	$('a[href=".?r=' + r + '"]').closest('li').addClass('active');
});