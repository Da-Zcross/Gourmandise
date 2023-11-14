document.addEventListener("DOMContentLoaded", function () {
  const updateForm = document.getElementById("update-form");
  const messageDiv = document.getElementById("message");

  updateForm.addEventListener("submit", function (event) {
      event.preventDefault();

      // Récupérer les nouvelles informations de l'utilisateur depuis le formulaire
      const firstName = document.getElementById("firstname").value;
      const lastName = document.getElementById("lastname").value;
      const birthdate = document.getElementById("birthdate").value;
      const streetNumber = document.getElementById("streetnumber").value;
      const streetName = document.getElementById("streetname").value;
      const postalCode = document.getElementById("postalcode").value;
      const city = document.getElementById("city").value;
      const phoneNumber = document.getElementById("phonenumber").value;
      const email = document.getElementById("email").value;
      const password = document.getElementById("password").value;

      // Créer un objet XMLHttpRequest
      const xhr = new XMLHttpRequest();

      // Définir la fonction de rappel pour traiter la réponse
      xhr.onreadystatechange = function () {
          if (xhr.readyState === 4) {
              if (xhr.status === 200) {
                  // La requête s'est terminée avec succès
                  const response = JSON.parse(xhr.responseText);
                  if (response.success) {
                      // Afficher le message de succès
                      messageDiv.textContent = response.message;

                      // Rafraîchir la page après la mise à jour
                      setTimeout(function () {
                          location.reload();
                      }, 2000);
                  } else {
                      // Afficher le message d'erreur
                      messageDiv.textContent = response.message;
                  }
              } else {
                  // La requête a échoué
                  messageDiv.textContent = "Erreur lors de la mise à jour des informations de l'utilisateur.";
              }
          }
      };

      // Ouvrir une requête POST vers le fichier PHP pour mettre à jour les données
      xhr.open("POST", "../php/update_user_info.php", true);
      xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

      // Envoyer les données du formulaire dans le corps de la requête
      xhr.send(
          `firstname=${firstName}&lastname=${lastName}&birthdate=${birthdate}&streetnumber=${streetNumber}&streetname=${streetName}&postalcode=${postalCode}&city=${city}&phonenumber=${phoneNumber}&email=${email}&password=${password}`
      );
  });
});
