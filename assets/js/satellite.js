
window.onload = function() {

	const path = window.location.pathname.split('/');
	var lang = 'en';
	var langPrefix = '';
	
	path.pop();
	path.shift();
	if (path[0] == 'ja') {
		path.shift();
		lang = 'ja';
		langPrefix = '/ja';
	}

	console.log('perihelion-satellite javascript has loaded');

};
