<?php
// Подключение к базе данных
$servername = "127.0.0.1";
$username = "root";
$password = "";
$dbname = "istok";

$conn = new mysqli($servername, $username, $password, $dbname);

$id=$_POST['message'];

$sql2 = "SELECT COUNT(*) FROM messages WHERE conversation_id = '$id'";


$result2 = $conn->query($sql2);
$row2 = $result2->fetch_array();
$idd = $_COOKIE['ID'];


if ($row2[0]>0)
{   $sql = "SELECT * FROM messages WHERE conversation_id = '$id' ORDER BY timestamp";
    $result1 = $conn->query($sql);
   
    $query = "SELECT * FROM request WHERE ID= '$id'";
   
    $result3 = $conn->query($query);
    $row3=$result3->fetch_array();
    $query2 = "SELECT * FROM user WHERE ID= '$row3[Request_owner]'";
    $result4 = $conn->query($query2);
    $row4=$result4->fetch_array();


    $query3 = "SELECT ID, name, lastname FROM user WHERE usertype>1";
    $result5 = $conn->query($query3);
    $query4 = "SELECT ID,name, lastname FROM user WHERE usertype>1 AND ID !=$idd ";
    $result6 = $conn->query($query4);
    $query5 = "SELECT ID, name, lastname FROM user WHERE ID= '$row3[Request_response]'";
    $result7 = $conn->query($query5);
    $row7=$result7->fetch_array();
    $query6 = "SELECT ID, name, lastname FROM user WHERE ID= '$row3[Request_viewer]'";
    $result8 = $conn->query($query6);
    $row8=$result8->fetch_array();
    setcookie("conversation_id", $id, 0, "/");
    
    echo "
    <div class='MessHeader'>
    <div class='MessTitle'>
        <p>Заявление № ".$id."</p>
        <p>".$row3['Request_theme']."</p>
    </div>
    <div class='ThreeDots'  onclick='togglePlaque()'>
        <img width='20px' height='20px' src='../icons/ThreeDots.svg' alt='...'>
    </div>
    <form id='update'>
    <div id='plaque' class='ChangeMess'>
        <ul class='ChangeList'>
            <li>
                <label for='Equip'>Телефон клиента:</label>
                <input type='text' readonly id='Phone' value='".$row4['phone']."'>
            </li>
            <li>
                <label for='Equip'>Почта клиента:</label>
                <input type='text' readonly id='Email' name='email' value='".$row4['email']."'>
            </li>
            <li>
                <label for='Respon'>Ответственный за работу:</label>
                <select name='Sotrud' id='Respon' required>
                <option selected='selected' value='". $row7['ID']."'>".$row7['lastname']. ' ' . $row7['name']."</option>";
            while($row5=$result5->fetch_array()){
                $fullName = $row5['lastname'] . ' ' . $row5['name'];
                echo "<option value='". $row5['ID']."'>".$fullName."</option>";
            }
            echo "</select>
            </li>
            <li>
                <label for='Watcher'>Смотрящий:</label>
                <select name='Admins' id='Watcher' required>
                <option selected='selected' value='". $row8['ID']."'>".$row8['lastname']. ' ' . $row8['name']."</option>";
            while($row6=$result6->fetch_array()){
                $fullName = $row6['lastname'] . ' ' . $row6['name'];
                echo "<option value='".$row6['ID']."'>".$fullName."</option>";
            }
            echo "</select>
            </li>
            <li>
                <label for='Statusi'>Статус заявления:</label>
                <select name='TypeOfStatus' id='Statusi' required>
                <option selected='selected' value='". $row3['Request_status']."'>".$row3['Request_status']."</option>
                    <option value='Обработка'>Обработка</option>
                    <option value='В процессе'>В процессе</option>
                    <option value='Завершено'>Завершено</option>
                </select>
            </li>
            <li>
                <label for='Statusi'>Время обработки:</label>
                <select name='TimeOfProcessing' id='Processing' required>
                <option selected='selected' value='". $row3['PlanDate']."'>".$row3['PlaneDate']."</option>
                    <option value='10 минут'>10 минут</option>
                    <option value='20 минут'>20 минут</option>
                    <option value='30 минут'>30 минут</option>
                    <option value='60 минут'>60 минут</option>
                    <option value='2 часа'>2 часа</option>
                    <option value='5 часов'>5 часов</option>
                    <option value='10 часов'>10 часов</option>
                    <option value='1 день'>1 день</option>
                    <option value='2 дня'>2 дня</option>
                </select>
            </li>
            <li>
                <button class='RefreshBttn'>Обновить</button>
            </li>  
        </ul>
    </div>
    </form> 
</div>
<div id='messages'>";




    while($row1 = $result1->fetch_array())
    {
    
    if($row1['sender_id']==$idd)
    {
        echo "<div class='mess right'>".$row1['message_text']."<div class='datee'>".date('H:i', strtotime($row1['timestamp']))."</div></div>";
    }
    else
    {
        echo "<div class='mess left '>".$row1['message_text']."<div class='datee'>".date('H:i', strtotime($row1['timestamp']))."</div></div>";
    }

    }
    echo "</div>";
    echo "
    <form id='chat-form' >
                    <div class='SotrudWriteBar'>
                        <textarea name='messagebox' id='chat-message' cols='30' rows='10' class='typetext' placeholder='Напишите сообщение'></textarea>
                        <label for='paperclip'>
                            <img src='../icons/скрепка.svg' alt='p' class='paperclip' >
                        </label>
                        <input id='paperclip' type='file' class='prikrepit'>
                        <button class='send'>Отправить</button>
                    </div>
                </form>
    
    
    ";
}
else
{
    $sql = "SELECT * FROM messages WHERE conversation_id = '$id' ORDER BY timestamp";
    $result1 = $conn->query($sql);
   
    $query = "SELECT * FROM request WHERE ID= '$id'";
   
    $result3 = $conn->query($query);
    $row3=$result3->fetch_array();
    $query2 = "SELECT * FROM user WHERE ID= '$row3[Request_owner]'";
    $result4 = $conn->query($query2);
    $row4=$result4->fetch_array();


    $query3 = "SELECT ID, name, lastname FROM user WHERE usertype>1";
    $result5 = $conn->query($query3);
    $query4 = "SELECT ID,name, lastname FROM user WHERE usertype>1 AND ID !=$idd ";
    $result6 = $conn->query($query4);
    $query5 = "SELECT ID, name, lastname FROM user WHERE ID= '$row3[Request_response]'";
    $result7 = $conn->query($query5);
    $row7=$result7->fetch_array();
    $query6 = "SELECT ID, name, lastname FROM user WHERE ID= '$row3[Request_viewer]'";
    $result8 = $conn->query($query6);
    $row8=$result8->fetch_array();
    setcookie("conversation_id", $id, 0, "/");
    
    echo "
    <div class='MessHeader'>
    <div class='MessTitle'>
        <p>Заявление № ".$id."</p>
        <p>".$row3['Request_theme']."</p>
    </div>
    <div class='ThreeDots'  onclick='togglePlaque()'>
        <img width='20px' height='20px' src='../icons/ThreeDots.svg' alt='...'>
    </div>
    <form id='update'>
    <div id='plaque' class='ChangeMess'>
        <ul class='ChangeList'>
            <li>
                <label for='Equip'>Телефон клиента:</label>
                <input type='text' readonly id='Phone' value='".$row4['phone']."'>
            </li>
            <li>
                <label for='Equip'>Почта клиента:</label>
                <input type='text' readonly id='Email' name='email' value='".$row4['email']."'>
            </li>
            <li>
                <label for='Respon'>Ответственный за работу:</label>
                <select name='Sotrud' id='Respon' required>
                <option selected='selected' value='". $row7['ID']."'>".$row7['lastname']. ' ' . $row7['name']."</option>";
            while($row5=$result5->fetch_array()){
                $fullName = $row5['lastname'] . ' ' . $row5['name'];
                echo "<option value='". $row5['ID']."'>".$fullName."</option>";
            }
            echo "</select>
            </li>
            <li>
                <label for='Watcher'>Смотрящий:</label>
                <select name='Admins' id='Watcher' required>
                <option selected='selected' value='". $row8['ID']."'>".$row8['lastname']. ' ' . $row8['name']."</option>";
            while($row6=$result6->fetch_array()){
                $fullName = $row6['lastname'] . ' ' . $row6['name'];
                echo "<option value='".$row6['ID']."'>".$fullName."</option>";
            }
            echo "</select>
            </li>
            <li>
                <label for='Statusi'>Статус заявления:</label>
                <select name='TypeOfStatus' id='Statusi' required>
                <option selected='selected' value='". $row3['Request_status']."'>".$row3['Request_status']."</option>
                    <option value='Обработка'>Обработка</option>
                    <option value='В процессе'>В процессе</option>
                    <option value='Завершено'>Завершено</option>
                </select>
            </li>
            <li>
                <label for='Statusi'>Время обработки:</label>
                <select name='TimeOfProcessing' id='Processing' required>
                <option selected='selected' value='". $row3['PlanDate']."'>".$row3['PlaneDate']."</option>
                    <option value='10 минут'>10 минут</option>
                    <option value='20 минут'>20 минут</option>
                    <option value='30 минут'>30 минут</option>
                    <option value='60 минут'>60 минут</option>
                    <option value='2 часа'>2 часа</option>
                    <option value='5 часов'>5 часов</option>
                    <option value='10 часов'>10 часов</option>
                    <option value='1 день'>1 день</option>
                    <option value='2 дня'>2 дня</option>
                </select>
            </li>
            <li>
                <button class='RefreshBttn'>Обновить</button>
            </li>  
        </ul>
    </div>
    </form> 
</div>
<div id='messages'>";




    while($row1 = $result1->fetch_array())
    {
    
    if($row1['sender_id']==$idd)
    {
        echo "<div class='mess right'>".$row1['message_text']."<div class='datee'>".date('H:i', strtotime($row1['timestamp']))."</div></div>";
    }
    else
    {
        echo "<div class='mess left '>".$row1['message_text']."<div class='datee'>".date('H:i', strtotime($row1['timestamp']))."</div></div>";
    }

    }
    echo "</div>";
    echo "
    <form id='chat-form' >
                    <div class='SotrudWriteBar'>
                        <textarea name='messagebox' id='chat-message' cols='30' rows='10' class='typetext' placeholder='Напишите сообщение'></textarea>
                        <label for='paperclip'>
                            <img src='../icons/скрепка.svg' alt='p' class='paperclip' >
                        </label>
                        <input id='paperclip' type='file' class='prikrepit'>
                        <button class='send'>Отправить</button>
                    </div>
                </form>
    
    
    ";

}

?>
