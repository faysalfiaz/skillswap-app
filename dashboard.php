<?php
session_start();
// Security Check: Redirect to index if user is not logged in
if (!isset($_SESSION['user_id'])) { 
    header("Location: index.php"); 
    exit(); 
}

require_once('db.php');
$current_user = $_SESSION['user_id'];
$search_query = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// --- Logic to Save Post ---
if (isset($_POST['submit_post'])) {
    $content = $conn->real_escape_string($_POST['post_content']);
    $link = $conn->real_escape_string($_POST['attached_link']);
    
    if (!empty($content)) {
        $stmt = $conn->prepare("INSERT INTO posts (user_id, content, repo_url) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $current_user, $content, $link);
        $stmt->execute();
        header("Location: dashboard.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillSwap | Dashboard Matrix</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex">

    <?php include('includes/sidebar.php'); ?>

    <main class="flex-1 p-6 md:p-10 max-h-screen overflow-y-auto">
        <!-- Header with Search -->
        <header class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white">SkillSwap Central Network 🌐</h1>
                <p class="text-slate-400 text-xs mt-1">Review live project updates or query target talent stacks instantly.</p>
            </div>
            <div class="flex items-center gap-3 w-full md:w-auto">
                <a href="edit_profile.php" class="bg-gray-700 text-white text-xs px-3 py-2.5 rounded-xl hover:bg-gray-600 transition">Edit Profile</a>
                <form action="" method="GET" class="w-full md:w-80 flex gap-2">
                    <input type="text" name="search" value="<?= htmlspecialchars($search_query) ?>" placeholder="Filter by Skill or Name..." class="w-full bg-slate-950 text-xs rounded-xl px-4 py-2.5 border border-slate-800 focus:outline-none text-white">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 rounded-xl text-xs font-semibold transition"><i class="fa-solid fa-magnifying-glass"></i></button>
                </form>
            </div>
        </header>

        <!-- Main Dashboard Container -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Left Side: My Posts Feed & Input -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Post Input Section -->
                <div class="bg-slate-950 p-5 rounded-2xl border border-slate-800 shadow-xl">
                    <form action="" method="POST" class="space-y-3">
                        <textarea name="post_content" required rows="3" placeholder="What architecture module did you design today?..." class="w-full bg-slate-900 text-slate-200 text-xs rounded-xl p-4 border border-slate-800 focus:outline-none text-white resize-none"></textarea>
                        <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-3">
                            <input type="url" name="attached_link" placeholder="Attach Repository URL (Optional)" class="flex-1 bg-slate-900 text-xs text-slate-400 rounded-lg px-3 py-2 border border-slate-800 text-white">
                            <button type="submit" name="submit_post" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-5 py-2 rounded-xl text-xs transition">Post Status</button>
                        </div>
                    </form>
                </div>

                <!-- My Posts Feed -->
                <div class="space-y-4">
                    <h2 class="text-sm font-bold text-emerald-400 uppercase">My Project Timeline</h2>
                    <?php 
                    $my_posts = $conn->query("SELECT * FROM posts WHERE user_id = $current_user ORDER BY created_at DESC");
                    while($post = $my_posts->fetch_assoc()): ?>
                        <div class="bg-slate-950 p-5 rounded-2xl border border-slate-800 shadow-lg">
                            <p class="text-slate-300 text-xs leading-relaxed"><?= nl2br(htmlspecialchars($post['content'])) ?></p>
                            <div class="flex gap-3 mt-2 border-t border-slate-800 pt-2">
                                <a href="edit_post.php?id=<?= $post['post_id'] ?>" class="text-[10px] text-blue-400">Edit</a>
                                <a href="delete_post.php?id=<?= $post['post_id'] ?>" class="text-[10px] text-red-400" onclick="return confirm('Are you sure?')">Delete</a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <!-- Right Side: Other Talents List -->
            <div class="lg:col-span-1 space-y-4">
                <h2 class="text-sm font-bold text-indigo-400 uppercase">Other Talents</h2>
                <?php 
                $users_query = $conn->query("SELECT * FROM Users WHERE user_id != $current_user ORDER BY RAND() LIMIT 10");
                while($user = $users_query->fetch_assoc()): ?>
                    <div class="bg-slate-950 p-4 rounded-xl border border-slate-800">
                        <h3 class="font-bold text-sm text-white"><?= htmlspecialchars($user['fullname']) ?></h3>
                        <p class="text-[10px] text-slate-400"><?= htmlspecialchars($user['headline']) ?></p>
                        <a href="profile.php?id=<?= $user['user_id'] ?>" class="text-[10px] text-indigo-400 mt-2 block hover:underline">View Profile</a>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>
</body>
</html>
