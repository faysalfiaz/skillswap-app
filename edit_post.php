<?php
session_start();
require_once('db.php');

// 1. Security: Ensure the user is logged in
if (!isset($_SESSION['user_id'])) { 
    header("Location: index.php"); 
    exit(); 
}

// 2. Get post ID from URL and sanitize
$post_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user_id = $_SESSION['user_id'];

// 3. Fetch existing post data (Only if it belongs to the current user)
$query = $conn->prepare("SELECT * FROM posts WHERE post_id = ? AND user_id = ?");
$query->bind_param("ii", $post_id, $user_id);
$query->execute();
$post = $query->get_result()->fetch_assoc();

if (!$post) {
    die("Post not found or you do not have permission to edit it.");
}

// 4. Handle Update Request
if (isset($_POST['update_post'])) {
    $new_content = $conn->real_escape_string($_POST['content']);
    $new_link = $conn->real_escape_string($_POST['repo_url']);
    
    // Prepare update query to prevent SQL injection
    $update = $conn->prepare("UPDATE posts SET content = ?, repo_url = ? WHERE post_id = ? AND user_id = ?");
    $update->bind_param("ssii", $new_content, $new_link, $post_id, $user_id);
    
    if ($update->execute()) {
        echo "<script>alert('Post updated successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "Error updating post.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Edit Post | SkillSwap</title>
</head>
<body class="bg-slate-900 text-slate-100 p-10">
    <div class="max-w-lg mx-auto bg-slate-950 p-8 rounded-2xl border border-slate-800 shadow-xl">
        <h2 class="text-xl font-bold mb-6 text-white">Edit Your Project Update</h2>
        
        <form method="POST">
            <label class="text-[10px] uppercase text-slate-500 font-bold">Post Content</label>
            <!-- Use htmlspecialchars for XSS protection -->
            <textarea name="content" required rows="4" class="w-full bg-slate-900 p-4 rounded-xl border border-slate-800 mb-4 text-white text-xs focus:outline-none"><?= htmlspecialchars($post['content']) ?></textarea>
            
            <label class="text-[10px] uppercase text-slate-500 font-bold">Repository URL</label>
            <input type="url" name="repo_url" value="<?= htmlspecialchars($post['repo_url']) ?>" class="w-full bg-slate-900 p-3 rounded-xl border border-slate-800 mb-6 text-white text-xs focus:outline-none">
            
            <div class="flex gap-3">
                <button type="submit" name="update_post" class="flex-1 bg-indigo-600 hover:bg-indigo-500 py-3 rounded-xl font-bold text-xs transition">Save Changes</button>
                <a href="dashboard.php" class="bg-slate-800 hover:bg-slate-700 px-6 py-3 rounded-xl text-xs font-bold text-slate-300 transition">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>