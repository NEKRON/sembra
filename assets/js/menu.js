const toggleButton = document.getElementById('toggleButton');
const menu = document.getElementById('menu');

toggleButton.addEventListener('click', () => {
  menu.classList.toggle('show');
  menu.classList.toggle('hide');

  if (menu.classList.contains('show')) {
    menu.style.display = 'block';
    menu.style.position = 'relative';
  } else {
    menu.style.display = 'none';
    menu.style.position = 'absolute';
  }
});
