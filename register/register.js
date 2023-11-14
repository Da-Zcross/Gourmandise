$("form").submit(event => { 
    event.preventDefault(); 

    const formData = {
        FirstName: $("#firstname").val(),
        LastName: $("#lastname").val(),
        BirthDate: $("#birthdate").val(),
        StreetNumber: $("#streetnumber").val(),
        StreetName: $("#streetname").val(),
        PostalCode: $("#postalcode").val(),
        City: $("#city").val(),
        PhoneNumber: $("#phonenumber").val(),
        Email: $("#email").val(),
        Password: $("#password").val()
    };

    $.ajax({
        url: "../php/register.php",
        type: "POST",
        dataType: "json",
        data: formData,
        success: (res) => {
            if (res.success) {
                window.location.replace("../login/login.html");
            } else {
                alert(res.error);
            }
        }
    });
});
