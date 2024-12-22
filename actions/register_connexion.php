<?php
header('Content-Type: application/json');

if(isset($_POST['email']) && isset($_POST['password'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $emailRegex = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/';

    $passwordRegex = '/^.{8,}$/';

    if (!preg_match($emailRegex, $email)) {
        echo json_encode(['success' => false, 'message' => 'Email invalide.']);
        exit;
    }

    if (!preg_match($passwordRegex, $password)) {
        echo json_encode(['success' => false, 'message' => 'password invalide.']);
        exit;
    }

    require_once '../config/database.php';

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt -> bind_param('s',$email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            echo json_encode(['success' => true, 'message' => 'Connexion réussie.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'mot de passe incorrect.']);
        }
    
    } else {
        echo json_encode(['success' => false, 'message' => 'Aucun utulisateur trouvé avec cet email ']);
    }
    $stmt->close();
    $pdo->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Email ou mot de passe incorrect. ']);
}
