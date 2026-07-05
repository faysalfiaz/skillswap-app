<?php
session_start();
if (!isset($_SESSION['user_id'])) { header("Location: index.php"); exit(); }

require_once('db.php');
$sender_id = $_SESSION['user_id'];
$profile_id = isset($_GET['id']) ? $conn->real_escape_string($_GET['id']) : $sender_id;

$success_msg = "";
if (isset($_POST['submit_proposal'])) {
    $p_title = $conn->real_escape_string($_POST['project_title']);
    $p_details = $conn->real_escape_string($_POST['proposal_details']);
    
    if($conn->query("INSERT INTO Project_Requests (sender_id, receiver_id, project_title, proposal_details) VALUES ('$sender_id', '$profile_id', '$p_title', '$p_details')")) {
        $notif_msg = $conn->real_escape_string($_SESSION['fullname'] . " submitted a direct Project Proposal: " . $p_title);
        $conn->query("INSERT INTO Notifications (user_id, message) VALUES ('$profile_id', '$notif_msg')");
        $success_msg = "Project Proposal transmitted downstream effectively.";
    }
}

$user_res = $conn->query("SELECT * FROM Users WHERE user_id='$profile_id'");
if ($user_res->num_rows == 0) { die("Target profile mapping failure."); }
$profile_user = $user_res->fetch_assoc();
$user_posts = $conn->query("SELECT * FROM User_Posts WHERE user_id='$profile_id' ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillSwap | <?= $profile_user['fullname'] ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex">

    <?php include('includes/sidebar.php'); ?>

    <main class="flex-1 p-6 md:p-10 max-h-screen overflow-y-auto">
        <?php if($success_msg): ?>
            <div class="mb-4 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-xs p-3 rounded-xl"><?= $success_msg ?></div>
        <?php endif; ?>

        <div class="relative w-full h-36 bg-gradient-to-r from-indigo-950 to-slate-900 rounded-3xl mb-6 border border-slate-800"></div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
            <div class="bg-slate-950 p-6 rounded-2xl border border-slate-800 space-y-6 relative -mt-20 z-10 shadow-2xl">
                <div class="w-24 h-24 rounded-2xl bg-gradient-to-tr from-indigo-500 to-emerald-500 p-0.5 shadow-xl mx-auto lg:mx-0">
                    <div class="w-full h-full bg-slate-900 rounded-xl flex items-center justify-center text-2xl font-bold text-white uppercase"><?= substr($profile_user['fullname'], 0, 2) ?></div>
                </div>

                <div>
                    <h2 class="text-lg font-bold text-white text-center lg:text-left"><?= $profile_user['fullname'] ?></h2>
                    <p class="text-indigo-400 text-xs font-semibold mt-0.5 text-center lg:text-left"><?= $profile_user['headline'] ?></p>
                    <p class="text-slate-400 text-xs mt-3 leading-relaxed"><?= !empty($profile_user['bio']) ? nl2br($profile_user['bio']) : "No summary documentation." ?></p>
                </div>

                <div class="space-y-1">
                    <span class="text-[10px] font-bold text-slate-500 uppercase">Framework Assets</span>
                    <div class="flex flex-wrap gap-1">
                        <?php foreach(explode(',', $profile_user['skills_csv']) as $skill): ?>
                            <span class="bg-indigo-500/5 border border-indigo-500/10 text-indigo-300 text-[10px] px-2 py-0.5 rounded-md font-mono"><?= trim($skill) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <?php if ($profile_id != $sender_id): ?>
                <div class="bg-slate-900 p-4 rounded-xl border border-slate-800 space-y-3">
                    <h3 class="text-xs font-bold text-white flex items-center gap-2"><i class="fa-solid fa-paper-plane text-indigo-400"></i> Hire / Proposal Request</h3>
                    <form action="" method="POST" class="space-y-2">
                        <input type="text" name="project_title" required placeholder="Project Concept Name" class="w-full bg-slate-950 text-xs rounded-lg p-2 border border-slate-800 focus:outline-none text-white">
                        <textarea name="proposal_details" required rows="2" placeholder="Describe system deliverables..." class="w-full bg-slate-950 text-xs rounded-lg p-2 border border-slate-800 focus:outline-none text-white resize-none"></textarea>
                        <button type="submit" name="submit_proposal" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-semibold py-2 rounded-lg text-xs transition">Send App Proposal</button>
                    </form>
                </div>
                <?php endif; ?>

                <div class="space-y-2 pt-4 border-t border-slate-900">
                    <div class="grid grid-cols-3 gap-2">
                        <a href="https://wa.me/<?= $profile_user['whatsapp_num'] ?>" target="_blank" class="bg-emerald-500/10 text-emerald-400 p-2.5 rounded-xl border border-emerald-500/10 text-center text-sm"><i class="fa-brands fa-whatsapp"></i></a>
                        <a href="https://m.me/<?= $profile_user['messenger_username'] ?>" target="_blank" class="bg-blue-500/10 text-blue-400 p-2.5 rounded-xl border border-blue-500/10 text-center text-sm"><i class="fa-brands fa-facebook-messenger"></i></a>
                        <a href="mailto:<?= $profile_user['email'] ?>" class="bg-indigo-500/10 text-indigo-400 p-2.5 rounded-xl border border-indigo-500/10 text-center text-sm"><i class="fa-regular fa-envelope"></i></a>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2 space-y-4">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-wider">Timeline Milestones</h3>
                <?php if($user_posts->num_rows == 0): ?>
                    <div class="bg-slate-950 p-6 rounded-2xl border border-slate-800 text-center text-slate-500 text-xs">No active updates compiled.</div>
                <?php else: ?>
                    <?php while($post = $user_posts->fetch_assoc()): ?>
                    <div class="bg-slate-950 p-5 rounded-2xl border border-slate-800 space-y-2">
                        <p class="text-[10px] text-slate-500"><?= date('F j, Y', strtotime($post['created_at'])) ?></p>
                        <p class="text-slate-300 text-xs leading-relaxed"><?= nl2br($post['post_content']) ?></p>
                    </div>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>

</body>
</html>