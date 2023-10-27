<?php
include("config.php");

if (isset($_POST['id'])) {
    $userId = $_POST['id'];
    $sql = "DELETE FROM moreusers WHERE id = :id";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        echo "User deleted successfully"; 
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request"; 
}
?>
