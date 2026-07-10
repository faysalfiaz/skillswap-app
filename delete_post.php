<?php
session_start();
require_once('db.php');

if (isset($_GET['id']) && isset($_SESSION['user_id'])) {
    $post_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    // Delete only if the post belongs to the logged-in user
    $query = "DELETE FROM posts WHERE post_id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();
}
header("Location: dashboard.php");
?>