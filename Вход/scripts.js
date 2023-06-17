function submitForm() {
      var form = document.getElementById("Entry");
      form.action = "submit_request.php";
      form.submit();
}

function registrForm() {
      var form = document.getElementById("Entry");
      form.action = "registration.php";
      form.submit();
}
function logInForm() {
      var form = document.getElementById("Entry");
      form.action = "LogIn.php";
      form.submit();
}
function redirectToLoginPage() 
{
   window.location.href = 'Страница входа.html';
}