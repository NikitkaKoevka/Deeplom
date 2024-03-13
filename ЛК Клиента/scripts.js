function rateFunction(button) {
    // Получение данных из формы
    var formData = $(button).closest('form').serialize();
    console.log(formData);
    // Отправка AJAX-запроса с использованием jQuery

    $.ajax({
        url: 'Rate.php',
        type: 'POST',
        data: formData,
        success: function(data) {
            // Обработка ответа от сервера, если необходимо
            console.log(data);
        },
        error: function(error) {
            // Обработка ошибок, если необходимо
            console.error("Ошибка:", error);
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const divStack = document.querySelector('.divStack');
    const profile = document.querySelector('.profile');
    const info = document.querySelector('.profile > div > .info');
    const label = document.querySelectorAll('.labelBttns');
    
    let clicked = false;

    divStack.addEventListener('click', function() {
        if (!clicked) {
            profile.style.transition = '0.2s';
            profile.style.width = '160px';
            info.style.transition = '0.2s';
            info.style.opacity = '1';
            label.forEach(function(label) {
                label.style.transition = '0.2s';
                label.style.opacity = '1';
            });
            clicked = true;
        } else {
            profile.style.transition = '0.2s';
            profile.style.width = '60px';
            info.style.transition = '0.05s';
            info.style.opacity = '0';
            label.forEach(function(label) {
                label.style.transition = '0.2s';
                label.style.opacity = '0';
            });
            clicked = false;
        }
    });
});


function openCreatePlaque()
{
    const plaque = document.getElementById('myModal2');
    plaque.style.display = 'block';
}
function openSettingsPlaque()
{
    const plaque = document.getElementById('myModal3');
    plaque.style.display = 'block';
}
function submitForm()
{
    var theme = document.getElementById("theme").value;
    var equip = document.getElementById("equip").value;
    var content = document.getElementById("content").value;

    $.ajax({
        url: 'submit_request_login.php',
        type: 'POST',
        data:
        {
            theme:theme,
            equip:equip,
            content:content
        },
        success: function(data) {
            // Обработка ответа от сервера, если необходимо
            console.log(data);
            if(data == 1) {
                document.getElementById("i1").style.display = "block";
                setTimeout(function() {
                    document.getElementById("i1").style.display = "none";
                }, 3000);
                }else if(data == 2) {
                    document.getElementById("i2").style.display = "block";
                setTimeout(function() {
                    document.getElementById("i2").style.display = "none";
                }, 3000);
                }else if(data == 3) {
                    document.getElementById("i3").style.display = "block";
                setTimeout(function() {
                    document.getElementById("i3").style.display = "none";
                }, 3000);
                }
                else if(data == 4) {
                    document.getElementById("i4").style.display = "block";
                setTimeout(function() {
                    document.getElementById("i4").style.display = "none";
                }, 3000);
                }
        },
        error: function(error) {
            // Обработка ошибок, если необходимо
            console.error("Ошибка:", error);
        }
    });
}

function setForm()
{
    var name = document.getElementById("name").value;
    var lastname = document.getElementById("lastname").value;
    var email = document.getElementById("email").value;
    var pw = document.getElementById("password").value;
    var pw2 = document.getElementById("password2").value;
    var stage = 0;
    if(pw!==0 && pw!==pw2 )
    {
        alert("Пароли не совпадают");
    }
    else 
    {
        $.ajax({
            url: 'Confirm.php',
            type: 'POST',
            data:
            {
                name:name,
                lastname:lastname,
                email:email,
                pw:pw,
                pw2:pw2,
                stage:stage
            },
            success: function(data) {
                //console.log(data);
                if(data!=0)
                {          
                    const code = prompt('Введите код, присланный на почту');      
                    if(code==data)
                    {
                        confirmStage(stage,pw);
                    }
                    else
                    {
                        alert('Неверный код');
                    }
                }
                const plaque = document.getElementById('myModal3');
                plaque.style.display = 'none';
            },
            error: function(error) {
                
                console.error("Ошибка:", error);
            }
        });
    }
    
}

function confirmStage(stage,pw)
{
    stage=1;
    $.ajax({
        url: 'Confirm.php',
        type: 'POST',
        data:
        {
            pw:pw,
            stage:stage
        },
        success: function(data) {
            
            console.log(data);
            stage=0;
        },
        error: function(error) {

            console.error("Ошибка:", error);
        }
    });
}
    