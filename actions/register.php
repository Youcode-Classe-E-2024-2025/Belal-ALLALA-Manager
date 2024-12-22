<?php 

if(isset($_POST["username"])){
    $username=$_POST['username'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $date = date('Y-m-d');

    if(!empty($email) && !empty($password) && !empty($username)){
        $sqlState=$pdo->prepare('INSERT INTO users (username, email, password_hash, created_at) VALUES (?,?,?,?)');
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        try {
            $sqlState->execute([$username, $email, $hashedPassword, $date]);
            echo json_encode(["success" => true]);
        } catch (Exception $e) {
            echo json_encode(["success" => false]);
        }
    } else {
        echo json_encode(["success" => false]);
    }

    die();
}

?>
