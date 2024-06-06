const projectBoxes = document.querySelectorAll('.project-box');

projectBoxes.forEach(box => {
	const description = box.querySelector('.project-description');
	const button = description.querySelector('.project-button');

	box.addEventListener('mouseover', () => {
		box.style.backgroundColor = '#f2f2f2';
		description.style.opacity = '1';
	});

	box.addEventListener('mouseout', () => {
		box.style.backgroundColor = '#f2f2f2';
		description.style.opacity = '0';
	});
});
const toggleBtn = document.querySelector('.toggle-btn');
const sidebar = document.querySelector('.sidebar');
const container = document.querySelector('.project-container');

toggleBtn.addEventListener('click', () => {
	sidebar.classList.toggle('active');
	container.classList.toggle('active');
});