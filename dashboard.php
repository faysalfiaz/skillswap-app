<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }

require_once('db.php');
$current_user = $_SESSION['user_id'];
$search_query = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';

// Handle status post submission
if (isset($_POST['submit_post'])) {
    $content = $conn->real_escape_string($_POST['post_content']);
    $link = $conn->real_escape_string($_POST['attached_link']);
    if (!empty($content)) {
        $conn->query("INSERT INTO User_Posts (user_id, post_content, attached_link) VALUES ('$current_user', '$content', '$link')");
    }
}

// Using LEFT JOIN to ensure all users are displayed, even those without posts
$sql_feed = "SELECT User_Posts.*, Users.user_id as profile_uid, Users.fullname, Users.headline, Users.skills_csv 
             FROM Users 
             LEFT JOIN User_Posts ON Users.user_id = User_Posts.user_id ";

if (!empty($search_query)) {
    $sql_feed .= "WHERE Users.skills_csv LIKE '%$search_query%' OR Users.fullname LIKE '%$search_query%' ";
}
$sql_feed .= "ORDER BY User_Posts.created_at DESC";
$posts_query = $conn->query($sql_feed);
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

    <!-- Sidebar Integration -->
    <?php include('includes/sidebar.php'); ?>

    <main class="flex-1 p-6 md:p-10 max-h-screen overflow-y-auto">
        <header class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-white">SkillSwap Central Network 🌐</h1>
                <p class="text-slate-400 text-xs mt-1">Review live project updates or query target talent stacks instantly.</p>
            </div>
            
            <form action="" method="GET" class="w-full md:w-80 flex gap-2">
                <input type="text" name="search" value="<?= htmlspecialchars($search_query) ?>" placeholder="Filter by Skill or Name..." class="w-full bg-slate-950 text-xs rounded-xl px-4 py-2.5 border border-slate-800 focus:outline-none text-white">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 rounded-xl text-xs font-semibold transition"><i class="fa-solid fa-magnifying-glass"></i></button>
            </form>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-6">
                
                <div class="bg-slate-950 p-5 rounded-2xl border border-slate-800 shadow-xl">
                    <form action="" method="POST" class="space-y-3">
                        <textarea name="post_content" required rows="3" placeholder="What architecture module did you design today?..." class="w-full bg-slate-900 text-slate-200 text-xs rounded-xl p-4 border border-slate-800 focus:outline-none text-white resize-none"></textarea>
                        <div class="flex flex-col sm:flex-row justify-between items-stretch sm:items-center gap-3">
                            <input type="url" name="attached_link" placeholder="Attach Repository URL (Optional)" class="flex-1 bg-slate-900 text-xs text-slate-400 rounded-lg px-3 py-2 border border-slate-800 text-white">
                            <button type="submit" name="submit_post" class="bg-indigo-600 hover:bg-indigo-500 text-white font-semibold px-5 py-2 rounded-xl text-xs transition">Post Status</button>
                        </div>
                    </form>
                </div>

                <div class="space-y-4">
                    <?php if ($posts_query->num_rows == 0): ?>
                        <div class="bg-slate-950 p-8 rounded-2xl border border-slate-800 text-center text-slate-500 text-xs">No project timeline nodes match query parameters.</div>
                    <?php else: ?>
                        <?php while($post = $posts_query->fetch_assoc()): ?>
                        <div class="bg-slate-950 p-5 rounded-2xl border border-slate-800 space-y-3 shadow-lg">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-slate-800 rounded-lg flex items-center justify-center font-bold text-xs uppercase text-slate-300"><?= substr($post['fullname'], 0, 2) ?></div>
                                    <div>
                                        <a href="profile.php?id=<?= $post['profile_uid'] ?>" class="text-xs font-bold text-slate-200 hover:text-indigo-400 transition">
                                            <?= $post['fullname'] ?>
                                        </a>
                                        <p class="text-[10px] text-slate-500 mt-0.5"><?= $post['headline'] ?></p>
                                    </div>
                                </div>
                                <a href="profile.php?id=<?= $post['profile_uid'] ?>" class="text-[10px] font-bold text-indigo-400 hover:bg-indigo-500/10 px-2.5 py-1.5 rounded-lg border border-indigo-500/20 transition">View Portfolio</a>
                            </div>
                            
                            <!-- Check if post content exists -->
                            <?php if(!empty($post['post_content'])): ?>
                                <p class="text-slate-300 text-xs leading-relaxed"><?= nl2br($post['post_content']) ?></p>
                            <?php else: ?>
                                <p class="text-slate-600 text-[10px] italic">No active project posts yet.</p>
                            <?php endif; ?>
                            
                            <div class="flex flex-wrap gap-1.5 pt-1">
                                <?php if(!empty($post['skills_csv'])): ?>
                                    <?php foreach(explode(',', $post['skills_csv']) as $skill): ?>
                                        <span class="bg-slate-900 text-slate-400 border border-slate-800 text-[9px] px-2 py-0.5 rounded-md font-mono">#<?= trim($skill) ?></span>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <?php if(!empty($post['attached_link'])): ?>
                            <div class="p-2.5 bg-slate-900 rounded-xl border border-slate-800 flex items-center justify-between text-[11px]">
                                <span class="text-indigo-400 truncate max-w-xs"><i class="fa-solid fa-link mr-1"></i> <?= $post['attached_link'] ?></span>
                                <a href="<?= $post['attached_link'] ?>" target="_blank" class="bg-slate-800 hover:bg-slate-700 text-slate-200 px-3 py-1 rounded-lg text-xs">Explore</a>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-slate-950 p-5 rounded-2xl border border-slate-800 shadow-xl">
                    <h2 class="text-xs font-bold text-white mb-3 flex items-center gap-2"><i class="fa-solid fa-layer-group text-emerald-400"></i> Talent Query Engine</h2>
                    <p class="text-[11px] text-slate-400 leading-relaxed">Search users by name or skill tags. Click on any portfolio to view detailed project architecture.</p>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
