function postAjax(data, url) {
	var xhr = new XMLHttpRequest();
	var baseUrl = 'https://php_server.ua/api/' + url;
	xhr.open('POST', baseUrl, true);
	xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
	xhr.onload = function () {
	    // do something to response
	    console.log(this.response);
	};
	xhr.send(data);
}

function postAjax(data, url) {
	var baseUrl = 'https://php_server.ua/api/' + url;
	fetch(baseUrl, {
		method: 'POST',
		body: data
	}).then(
	    function (response) {
	    	console.log(response.text());
	    }
	)
}
