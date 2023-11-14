// Récupérer les éléments du DOM
const toggleButton = document.querySelector('.toggle-button');
const navbarLinks = document.querySelector('.navbar-links');

// Ajouter un écouteur d'événement au bouton de bascule
toggleButton.addEventListener('click', () => {
  // Basculer la classe active pour afficher/cacher le menu de navigation
  navbarLinks.classList.toggle('active');
});

// Récupérer la date actuelle
const currentDate = new Date();

// Afficher la date dans le pied de page
const footerDate = document.querySelector('.footer-date');
footerDate.textContent = currentDate.getFullYear();





function toggleMenu() {
  var navbar = document.getElementById("navbarSupportedContent");
  navbar.classList.toggle("show");
}
