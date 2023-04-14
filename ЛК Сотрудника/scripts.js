var flag=1;
function togglePlaque() {
    var plaque = document.getElementById("plaque");
    if (plaque.style.display === "none"|| flag==1 ) {
      console.log("1");
      plaque.style.display = "block";
      flag=0;
    } else if( flag==0) {
      console.log("2");
      plaque.style.display = "none";
    }
  }


  function SupportAlert()
  {
    alert("Контакты поддержки сайта:\nТелефон:+7-495-183-54-99\ne-mail: k3support@gmail.com");
  }