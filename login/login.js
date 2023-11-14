$(document).ready(function () {
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get("logout")) {
    $.ajax({
      url: "../php/login.php",
      type: "GET",
      dataType: "json",
      success: () => {
        localStorage.removeItem("customers");
      }
    });
  }

  $("form").submit((event) => {
    event.preventDefault();
    $.ajax({
      url: "../php/login.php",
      type: "POST",
      dataType: "json",
      data: {
        email: $("#email").val(),
        password: $("#password").val()
      },
      success: (res) => {
        if (res.success) {
          localStorage.setItem("customers", JSON.stringify(res.customers));
          window.location.replace("../html/index.html");
        } else {
          alert(res.error);
        }
      }
    });
  });
});