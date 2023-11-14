// Fonction pour ajouter un produit au panier
function ajouterAuPanier(reference, denomination, prix) {
  // Vérifiez si le panier existe dans le localStorage
  let panier = JSON.parse(localStorage.getItem('panier')) || [];

  // Ajoutez le produit au panier
  panier.push({ reference, denomination, prix });

  // Mettez à jour le panier dans le localStorage
  localStorage.setItem('panier', JSON.stringify(panier));

  // Affichez un message de confirmation
  alert('Produit ajouté au panier !');
}

// Fonction pour récupérer le contenu du panier
function getPanier() {
  return JSON.parse(localStorage.getItem('panier')) || [];
}

// Fonction pour vider le panier
function viderPanier() {
  localStorage.removeItem('panier');
}

// Fonction pour afficher le contenu du panier
function afficherPanier() {
  const panier = getPanier();
  const tableBody = $('tbody');
  let montantTotal = 0;

  tableBody.empty();

  panier.forEach((produit, index) => {
    const row = $('<tr>');
    row.append($('<td>').text(produit.reference));
    row.append($('<td>').text(produit.denomination));
    row.append($('<td>').text(produit.prix.toFixed(2) + ' €'));
    tableBody.append(row);

    montantTotal += produit.prix;
  });

  // Affichez le montant total du panier
  $('.text-right strong').text('Montant total du panier : ' + montantTotal.toFixed(2) + ' €');
}

// Appeler la fonction d'affichage du panier lorsque la page est chargée
$(document).ready(function() {
  afficherPanier();

  // Écoutez le clic sur le bouton "Vider le panier"
  $('form').submit(function(event) {
    event.preventDefault();
    viderPanier();
    afficherPanier();
  });

  // Écoutez le clic sur les boutons de paiement
  $('.paiement').click(function(event) {
    event.preventDefault();
    const moyenPaiement = $(this).data('moyenpaiement');
    alert('Vous avez choisi de payer avec ' + moyenPaiement);
  });
});
