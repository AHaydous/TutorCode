const form = document.querySelector('form');

form.addEventListener('submit', (event) => {
	event.preventDefault();

	const name = document.querySelector('#name').value;
	const email = document.querySelector('#email').value;
	const message = document.querySelector('#message').value;

	if (!name || !email || !message) {
		alert('Please fill in all fields.');
		return;
	}
	else {
		alert('Message sent successfully. We will reply as soon as possible.');
		form.reset();
	}	
});