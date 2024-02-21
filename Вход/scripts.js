function submitForm() 
{
      var form = document.getElementById("Entry");
      form.action = "submit_request.php";
      form.submit();
}

function registrForm() 
{
      var pw = document.querySelector("input[name='password']").value;
      var ans = checkPasswordStrength(pw);
      var pwInput = document.querySelector("input[name='password']");

      switch(ans)
      {
            case 'Простой':pwInput.style.border = '1px solid red';
            break;
            case 'Средний':
                  {
                        var form = document.getElementById("Entry");
                        form.action = "registration.php";
                        form.submit();
                  }
            break;
            case 'Сложный':
                  {
                        var form = document.getElementById("Entry");
                        form.action = "registration.php";
                        form.submit();
                  }
            break;
      }
}
function logInForm() 
{
      var form = document.getElementById("Entry");
      form.action = "LogIn.php";
      form.submit();
}
function redirectToLoginPage() 
{
      window.location.href = 'Страница входа.html';
}

function checkPasswordStrength(pw) {
      // Проверяем длину пароля
      var lengthRating = pw.length >= 8 ? 2 : pw.length >= 6 ? 1 : 0;

      // Проверяем наличие различных типов символов
      var lowercase = /[a-z]/.test(pw);
      var uppercase = /[A-Z]/.test(pw);
      var digits = /\d/.test(pw);
      var specials = /[!@#$%^&*(),.?":{}|<>]/.test(pw);
      var typesRating = (lowercase + uppercase + digits + specials) >= 3 ? 2 : 1;

      // Определяем общий рейтинг сложности пароля
      var totalRating = lengthRating + typesRating;

      // Возвращаем оценку сложности пароля
      if (totalRating <= 2) {
      return "Простой";
      } else if (totalRating === 3) {
      return "Средний";
      } else {
      return "Сложный";
      }
}

function verifPassword() {
      var pw = document.querySelector("input[name='password']").value;
      var text = document.getElementById('hidden_p');
      var passwordStrength = checkPasswordStrength(pw);
      switch(passwordStrength)
      {
            case 'Простой':text.style.color = 'red';
            break;
            case 'Средний':text.style.color = 'orange';
            break;
            case 'Сложный':text.style.color = 'green';
            break;
      }
      text.innerHTML = passwordStrength;
      text.style.display = 'block';
      // Возвращаем true, чтобы разрешить отправку формы
      return true;
}

