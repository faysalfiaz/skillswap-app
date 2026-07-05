<?php
session_start();
require_once('db.php');

$error = "";

// Handle User Sign-In Action Routine
if (isset($_POST['login'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM Users WHERE email='$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['fullname'] = $user['fullname'];
            $_SESSION['headline'] = $user['headline'];
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['auth_error'] = "Authentication failure: Invalid credential verification tokens.";
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['auth_error'] = "No active identity profile matched with this email destination.";
        header("Location: index.php");
        exit();
    }
}

// Handle User Account Registration Action Routine
if (isset($_POST['register'])) {
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $headline = $conn->real_escape_string($_POST['headline']);
    $skills = $conn->real_escape_string($_POST['skills_csv']);
    $whatsapp = $conn->real_escape_string($_POST['whatsapp']);
    $messenger = $conn->real_escape_string($_POST['messenger']);
    $github = $conn->real_escape_string($_POST['github']);
    $linkedin = $conn->real_escape_string($_POST['linkedin']);
    $bio = $conn->real_escape_string($_POST['bio']);

    $check_email = $conn->query("SELECT email FROM Users WHERE email='$email'");
    if ($check_email->num_rows > 0) {
        $_SESSION['auth_error'] = "This email target is already allocated to another identity node.";
        header("Location: register.php");
        exit();
    } else {
        $sql = "INSERT INTO Users (fullname, email, password, headline, skills_csv, whatsapp_num, messenger_username, github_url, linkedin_url, bio) 
                VALUES ('$fullname', '$email', '$password', '$headline', '$skills', '$whatsapp', '$messenger', '$github', '$linkedin', '$bio')";
        if ($conn->query($sql)) { 
            header("Location: index.php?registered=true");
            exit();
        } else { 
            $_SESSION['auth_error'] = "Processing failure: Database write operation aborted."; 
            header("Location: register.php");
            exit();
        }
    }
}
?>