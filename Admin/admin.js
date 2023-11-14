$(document).ready(function () {
    const userForm = $("#user-form");
    const messageDiv = $("#message");
    const userList = $("#users");

    function getUsers() {
        $.ajax({
            url: "admin.php?action=getUsers",
            type: "GET",
            dataType: "json",
            success: function (data) {
                userList.empty();
                if (data && data.length > 0) {
                    data.forEach(function (user) {
                        const listItem = $("<li>").text(user.FirstName + " " + user.LastName);
                        userList.append(listItem);
                    });
                }
            },
            error: function () {
                console.log("Erreur lors de la récupération des utilisateurs.");
            }
        });
    }

    userForm.submit(function (event) {
        event.preventDefault();

        const action = $('input[name="action"]:checked').val();
        const formData = userForm.serialize();

        $.ajax({
            url: "admin.php",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function (response) {
                messageDiv.text(response.message);
                setTimeout(function () {
                    messageDiv.text("");
                }, 2000);
                getUsers(); // Met à jour la liste des utilisateurs après une action
            },
            error: function () {
                messageDiv.text("Une erreur s'est produite lors du traitement de la demande.");
            }
        });
    });

    getUsers(); // Charge la liste des utilisateurs au chargement de la page
});
