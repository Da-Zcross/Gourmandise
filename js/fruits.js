$(document).ready(function() {
  // Fonction pour charger et afficher les fruits
  function loadFruits() {
    $.ajax({
      url: '../php/fruit.php', 
      type: 'POST',
      dataType: 'json',
      data: { choice: 'select' },
      success: (res) => {
        if (res.success) {
          const fruitList = $('.product-grid');
          fruitList.empty();

          res.fruits.forEach((fruit) => {
            const im = $('<div class="product-item"></div>');
            const img = $('<img>');
            img.attr('src', '../images/' + fruit.images);
            const det = $('<div class="product-details"></div>');
            const h2 = $('<h2>' + fruit.Denomination + '</h2>');
            const price = $('<p class="price">' + fruit.Price + '</p>');
            const panier = $('<a href="../html/panier.html" class="cart-btn"><i class="fas fa-shopping-cart"></i></a>');
            im.append(img);
            det.append(h2, price, panier);
            im.append(det);
            $('.product-grid').append(im);
          });
        }
      }
    });
  }

  // Fonction pour ajouter au panier
  function ajouterAuPanier(reference, denomination, prix) {
    const url = '../php/panier.php';
    const data = {
      action: 'ajouterAuPanier',
      reference: reference,
      denomination: denomination,
      price: prix
    };

    fetch(url, {
      method: 'POST',
      body: JSON.stringify(data),
      headers: {
        'Content-Type': 'application/json'
      }
    })
    .then(response => response.json())
    .then(data => alert(data.message))
    .catch(error => console.error('Erreur :', error));
  }

  // Appeler la fonction pour charger les fruits au chargement de la page
  loadFruits();

  // Écouter les clics sur les boutons d'ajout au panier
  $('.cart-btn').click(function(event) {
    event.preventDefault();
    const reference = $(this).closest('.product-item').find('h2').text();
    const denomination = $(this).closest('.product-item').find('.price').text();
    const prix = parseFloat(denomination);
    ajouterAuPanier(reference, denomination, prix);
  });
});
