    // Chargement initial des fruits
    function loadFruits() {
        $.ajax({
            url: '../php/ajout.php',
            type: 'POST',
            dataType: 'json',
            data: {
                choice: 'select'
            },
            success: (res => {

                if (res.success) {

                    let val = res.fruits;
                    const fruitList = $('#fruit-list');
                    fruitList.empty();

                    val.forEach(fruit => {
                        console.log(fruit);
                        const row = `<tr>
                                    <td>${fruit.ProductId}</td>
                                    <td>${fruit.Denomination}</td>
                                    <td>${fruit.Reference}</td>
                                    <td>${fruit.Price}</td>
                                    <td>${fruit.CategoryLabel}</td>
                                    <td>${fruit.images}</td>

                                    <td>
                                        <button class="edit-button" data-id="${fruit.ProductId}">Modifier</button>
                                        <button class="delete-button" data-id="${fruit.ProductId}">Supprimer</button>
                                    </td>
                                </tr>`;
                        fruitList.append(row);
                    });
                }
            })
        });
    }

    // Gestionnaire de soumission du formulaire d'ajout
    $('#add-form').submit(function (event) {
        event.preventDefault();
        const formData = new FormData(this);
        formData.append('choice', 'insert');
        const imageInput = $('#fruit-image')[0];
        formData.append('fruitImage', imageInput.files[0]);

        $.ajax({
            url: '../php/ajout.php',
            type: 'POST',
            dataType: 'json',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                const result = JSON.parse(response);
                if (result.success) {
                    loadFruits();
                    $('#add-form')[0].reset();

                } else {
                    alert(result.error);
                }
            }

        });
    });

    // Gestionnaire des boutons de suppression
    $(document).on('click', '.delete-button', function () {
        const productId = $(this).data('id');
        $.ajax({
            url: '../php/ajout.php',
            method: 'POST',
            data: {
                choice: 'delete',
                ProductId: productId
            },
            success: function (response) {
                const result = JSON.parse(response);
                if (result.success) {
                    loadFruits();
                } else {
                    alert(result.error);
                }
            }
        });
    });

    // Gestionnaire de soumission du formulaire de modification
    // Gestionnaire des boutons de modification
$(document).on('click', '.edit-button', function () {
    const productId = $(this).data('id');

    // Récupérer les données du produit à partir de l'API
    $.ajax({
        url: '../php/ajout.php',
        method: 'POST',
        dataType: 'json',
        data: {
            choice: 'select_id',
            ProductId: productId
        },
        success: function (res) {
            if (res.success) {
                // Remplir le formulaire de modification avec les données du produit
                const product = res.fruit;
                $('#edit-product-id').val(product.ProductId);
                $('#edit-denomination').val(product.Denomination);
                $('#edit-reference').val(product.Reference);
                $('#edit-price').val(product.Price);
                $('#edit-category-id').val(product.CategoryId);
                
                // Afficher le formulaire de modification
                $('#edit-form-container').show();
            } else {
                alert(res.error);
            }
        }
    });
});

// Gestionnaire de soumission du formulaire de modification
// Gestionnaire de soumission du formulaire de modification
$('#edit-form').submit(function (event) {
    event.preventDefault();
    const formData = new FormData(this);
    formData.append('choice', 'update');

    $.ajax({
        url: '../php/ajout.php',
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            const result = JSON.parse(response);
            if (result.success) {
                loadFruits();
                $('#edit-form-container').hide();
            } else {
                alert(result.error);
            }
        }
    });
});


    // Gestionnaire de soumission du formulaire de modification
    $('#edit-form').submit(function (event) {
        event.preventDefault();
        const formData = new FormData(this);
        formData.append('choice', 'update');

        $.ajax({
            url: '../php/ajout.php',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                const result = JSON.parse(response);
                if (result.success) {
                    loadFruits();
                    $('#edit-form-container').hide();
                } else {
                    alert(result.error);
                }
            }
        });
    });

    // Appeler loadFruits() lors du chargement de la page
    loadFruits();