<?php 

    error_reporting(E_ALL); 
    ini_set('display_errors',1); 

    include('dbcon.php');


    $android = strpos($_SERVER['HTTP_USER_AGENT'], "Android");


    if( (($_SERVER['REQUEST_METHOD'] == 'POST') && isset($_POST['submit'])) || $android )
    {

        $name=$_POST['name'];


        if(empty($name)){
            $errMSG = "이름을 입력하세요.";
        }

        if(!isset($errMSG)) 

        {
            try{
                
                $stmt = $con->prepare('INSERT INTO PhoneInfo(Nickname) VALUES(:name)');
                $stmt->bindParam(':name', $name);
                //$stmt->bindParam(':country', $country);

                if($stmt->execute())
                {
                    $successMSG = "새로운 사용자를 추가했습니다.";
                }
                else
                {
                    $errMSG = "사용자 추가 에러";
                }

            } catch(PDOException $e) {
                die("Database error: " . $e->getMessage()); 
            }
        }

    }

?>


<?php 
    if (isset($errMSG)) echo $errMSG;
    if (isset($successMSG)) echo $successMSG;


    if (!$android)
    {
?>
    <html>
       <body>

            <form action="<?php $_PHP_SELF ?>" method="POST">
                Name: <input type = "text" name = "name" />
                Country: <input type = "text" name = "country" />
                <input type = "submit" name = "submit" />
            </form>
       
       </body>
    </html>

<?php 
    }
?>