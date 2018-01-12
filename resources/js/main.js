addClickHandlers();

function addClickHandlers() {
	var spans = document.getElementsByClassName('toggle-button');
	var categorySpan = spans[0];
	var bookmarkSpan = spans[1];

	categorySpan.addEventListener('click', function() {
		var children = document.getElementById('creation-category').children;

		for(i = 0; i < children.length; i++) {
			children[i].style.display = 'block';
		}
		
		categorySpan.style.display = 'none';
	}, false);

	bookmarkSpan.addEventListener('click', function() {
		var children = document.getElementById('creation-bookmark').children;

		for(i = 0; i < children.length; i++) {
			children[i].style.display = 'block';
		}

		bookmarkSpan.style.display = 'none';
	}, false);
}
