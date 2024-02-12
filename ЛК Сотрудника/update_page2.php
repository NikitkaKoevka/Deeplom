<?php 
                session_start();
                $servername = "127.0.0.1";
                $username = "root";
                $password = "";
                $dbname = "istok";
                
                $colorGreen = "#32CD32";
                $colorRed = "#FA8072";

                $conn = new mysqli($servername, $username, $password, $dbname);
                $sortirovka = $_POST['ID'];

                $query = "SELECT * FROM request WHERE  Request_owner = $sortirovka AND Request_response IS NOT NULL ORDER BY CreationDate DESC";
                $result = $conn->query($query);
                echo '<input id="sorti" type="hidden" value="'.$sortirovka.'"> ';
                foreach ($result->fetch_all(MYSQLI_ASSOC) as $заявление) {
                        
                    $query = "SELECT * FROM user WHERE ID= '$заявление[Request_owner]'";
                    $result1 = $conn->query($query);
                    $row1=$result1->fetch_array();
                    
                    

                    echo "<button id='buton' class='Zayavlenie' onclick=\"OpenReq('$sortirovka', '{$заявление['ID']}')\">";

                    echo '<input class="idd" type="hidden" value="' . $заявление['ID'] . '">';

                    echo '<p id="Equip" style="color:'.$colorGreen.';">' . $заявление['Request_equip'] . '</p>';
                    echo '<p id="Theme">' . $заявление['Request_theme'] . '</p>';
                    echo '<div class="ZayavBttn">';
                    echo '<p id="number">№ ' . $заявление['ID'] . '</p>';
                    echo '<p id="ClientName">' . $row1['name'] . '</p>';
                    echo '<p id="Status">' . $заявление['Request_status'] . '</p>';
                    echo '<div class="Dates">';
                    echo '<div class="DateCreation">';
                    echo '<p id="Chislo">' .$заявление['CreationDate'] . '</p>';
                    echo '</div>';
                    echo '<div class="DateFinnish">';
                    echo '<p id="Chislo">' . $заявление['FinnishDate'] . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</button>';


                    
                    }
                    $query = "SELECT * FROM request WHERE Request_owner=$sortirovka AND Request_response IS NULL  ORDER BY CreationDate DESC";
                    $result = $conn->query($query);

                    foreach ($result->fetch_all(MYSQLI_ASSOC) as $заявление) {
                    
                    $query = "SELECT * FROM user WHERE ID= '$заявление[Request_owner]'";
                    $result1 = $conn->query($query);
                    $row1=$result1->fetch_array();
                    

                    echo "<button id='buton' class='Zayavlenie' onclick=\"OpenReq('$sortirovka', '{$заявление['ID']}')\">";
                    echo '<p id="Equip" style="color:'.$colorRed.';">' . $заявление['Request_equip'] . '</p>';
                    echo '<p id="Theme">' . $заявление['Request_theme'] . '</p>';
                    echo '<div class="ZayavBttn">';
                    echo '<p id="number">№ ' . $заявление['ID'] . '</p>';
                    echo '<p id="ClientName">' . $row1['name'] . '</p>';
                    echo '<p id="Status">' . $заявление['Request_status'] . '</p>';
                    echo '<div class="Dates">';
                    echo '<div class="DateCreation">';
                    echo '<p id="Chislo">' . $заявление['CreationDate']. '</p>';
                    echo '</div>';
                    echo '<div class="DateFinnish">';
                    echo '<p id="Chislo">' . $заявление['FinnishDate'] . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    echo '</button>';

                    }

                ?>