<?php 
                $servername = "127.0.0.1";
                $username = "root";
                $password = "";
                $dbname = "istok";
                
                $conn = new mysqli($servername, $username, $password, $dbname);
                $userId=$_COOKIE["ID"];

                $query = "SELECT * FROM request WHERE  Request_response = $userId AND (Request_status!='Завершено' OR Request_status IS NULL) ORDER BY CreationDate DESC";
                $result = $conn->query($query);
                foreach ($result->fetch_all(MYSQLI_ASSOC) as $заявление) {
                    
                    $query = "SELECT * FROM user WHERE ID= '$заявление[Request_owner]'";
                    $result1 = $conn->query($query);
                    $row1=$result1->fetch_array();
                    
                    echo "<form class='form-get'>
                    <input class='idd' type='hidden' value='".$заявление['ID']."'>
                    <button id='buton' type='submit' class='Zayavlenie'>
                            <p id='Equip' style='color:#33c833;'>".$заявление['Request_equip']."</p>
                            <p id='Theme'>".$заявление['Request_theme']."</p>
                            <div class='ZayavBttn'>
                                <p  id='number'>№ ".$заявление['ID']."</p>
                                <p id='ClientName'>".$row1['name']."</p>
                                <p id='Status'>".$заявление['Request_status']."</p>
                                <div class='Dates'>
                                    <div class='DateCreation'>
                                        <p id='Chislo'>".date('d.m.Y H:i:s', strtotime($заявление['CreationDate']))."</p>
                                    </div>
                                    <div class='DateFinnish'>
                                        <p id='Chislo'>".$заявление['FinnishDate']."</p>
                                    </div>
                                </div>

                            </div>

                        
                    </button>
                </form>";
                }
                $query = "SELECT * FROM request WHERE  Request_response IS NULL  ORDER BY CreationDate DESC";
                $result = $conn->query($query);
                foreach ($result->fetch_all(MYSQLI_ASSOC) as $заявление) {
                    
                    $query = "SELECT * FROM user WHERE ID= '$заявление[Request_owner]'";
                    $result1 = $conn->query($query);
                    $row1=$result1->fetch_array();
                    
                    echo "<form class='form-get'>
                    <input class='idd' type='hidden' value='".$заявление['ID']."'>
                    <button id='buton' type='submit' class='Zayavlenie'>
                            <p id='Equip' style='color:#ff6000;'>".$заявление['Request_equip']."</p>
                            <p id='Theme'>".$заявление['Request_theme']."</p>
                            <div class='ZayavBttn'>
                                <p  id='number'>№ ".$заявление['ID']."</p>
                                <p id='ClientName'>".$row1['name']."</p>
                                <p id='Status'>".$заявление['Request_status']."</p>
                                <div class='Dates'>
                                    <div class='DateCreation'>
                                        <p id='Chislo'>".date('d.m.Y H:i:s', strtotime($заявление['CreationDate']))."</p>
                                    </div>
                                    <div class='DateFinnish'>
                                        <p id='Chislo'>".$заявление['FinnishDate']."</p>
                                    </div>
                                </div>

                            </div>

                        
                    </button>
                </form>";
                }
                
                
                
                ?>