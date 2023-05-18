var flag=1;
function togglePlaque() {
  var plaque = document.getElementById("plaque");
  if (plaque.style.display === "none" || flag == 1) {
    plaque.style.display = "block";
    plaque.style.opacity = "0";
    plaque.style.transition = "opacity 0.2s";
    setTimeout(function() {
      plaque.style.opacity = "1";
    }, 10);
    flag = 0;
  } else if (flag == 0) {
    plaque.style.opacity = "0";
    plaque.style.transition = "opacity 0.2s";
    setTimeout(function() {
      plaque.style.display = "none";
    }, 100);
  }
}


  function SupportAlert()
  {
    alert("Контакты поддержки сайта:\nТелефон:+7-495-183-54-99\ne-mail: k3support@gmail.com");
  }