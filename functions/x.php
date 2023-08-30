<?php


$host = "host.docker.internal";
$userName = "root";
$passWord = "";
$dbName = "MyComunnityLib";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $userName, $passWord);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare('SELECT id, passWord FROM users');
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($users as $user) {
        $hashedPassword = password_hash($user['passWord'], PASSWORD_DEFAULT);
        $updateStmt = $pdo->prepare('UPDATE users SET passWord = :hashedPassword WHERE id = :userId');
        $updateStmt->bindParam(':hashedPassword', $hashedPassword);
        $updateStmt->bindParam(':userId', $user['id']);
        $updateStmt->execute();
    }

    echo 'Mises à jour des mots de passe terminées avec succès.';
} catch (PDOException $e) {
    echo 'Erreur : ' . $e->getMessage();
}
