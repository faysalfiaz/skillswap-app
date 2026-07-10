<?php
require_once 'db.php';
session_start();

// Ensure the user is logged in (Assuming you have user_id in session)
if (!isset($_SESSION['user_id'])) {
    die("Please log in first.");
}

$user_id = $_SESSION['user_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $headline = $_POST['headline'];
    $bio = $_POST['bio'];
    $skills = $_POST['skills_csv'];
    $whatsapp = $_POST['whatsapp_num'];
    $github = $_POST['github_url'];
    $linkedin = $_POST['linkedin_url'];

    $update_query = "UPDATE users SET fullname=?, headline=?, bio=?, skills_csv=?, whatsapp_num=?, github_url=?, linkedin_url=? WHERE user_id=?";
    $stmt = $conn->prepare($update_query);
    $stmt->bind_param("sssssssi", $fullname, $headline, $bio, $skills, $whatsapp, $github, $linkedin, $user_id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Profile updated successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "Error updating profile.";
    }
}

// Fetch current user data
$query = "SELECT * FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Profile</title>
</head>
<body class="bg-[#0b1329] text-white p-10">
    <div class="max-w-lg mx-auto bg-[#131c35] p-8 rounded-2xl border border-gray-800">
        <h2 class="text-xl font-bold mb-6">Edit Personal Information</h2>
        <form method="POST">
            <input type="text" name="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" class="w-full bg-[#1e294b] p-3 rounded mb-4" placeholder="Full Name">
            <input type="text" name="headline" value="<?php echo htmlspecialchars($user['headline']); ?>" class="w-full bg-[#1e294b] p-3 rounded mb-4" placeholder="Headline">
            <textarea name="bio" class="w-full bg-[#1e294b] p-3 rounded mb-4" placeholder="Bio"><?php echo htmlspecialchars($user['bio']); ?></textarea>
            <input type="text" name="skills_csv" value="<?php echo htmlspecialchars($user['skills_csv']); ?>" class="w-full bg-[#1e294b] p-3 rounded mb-4" placeholder="Skills (comma separated)">
            <input type="text" name="whatsapp_num" value="<?php echo htmlspecialchars($user['whatsapp_num']); ?>" class="w-full bg-[#1e294b] p-3 rounded mb-4" placeholder="WhatsApp Number">
            <input type="url" name="github_url" value="<?php echo htmlspecialchars($user['github_url']); ?>" class="w-full bg-[#1e294b] p-3 rounded mb-4" placeholder="GitHub URL">
            <input type="url" name="linkedin_url" value="<?php echo htmlspecialchars($user['linkedin_url']); ?>" class="w-full bg-[#1e294b] p-3 rounded mb-4" placeholder="LinkedIn URL">
            <button type="submit" class="w-full bg-blue-600 py-3 rounded font-bold hover:bg-blue-700">Save Changes</button>
        </form>
    </div>
</body>
</html>