<?php
if (!isset($_SESSION['user_id'])) { 
    header("Location: index.php"); 
    exit(); 
}
require_once(__DIR__ . '/../db.php');
$sidebar_uid = $_SESSION['user_id'];
$unread_res = $conn->query("SELECT COUNT(*) as unread FROM Notifications WHERE user_id='$sidebar_uid' AND is_read=0");
$unread_count = $unread_res->fetch_assoc()['unread'];
?>
<aside class="w-64 bg-slate-950 border-r border-slate-800 p-6 flex flex-col justify-between hidden md:flex min-h-screen">
    <div>
        <div class="flex items-center gap-3 mb-10">
            <div class="bg-indigo-600 p-2 rounded-xl text-white shadow-lg">
                <i class="fa-solid fa-circle-nodes text-xl"></i>
            </div>
            <span class="text-xl font-bold bg-gradient-to-r from-indigo-400 to-emerald-400 bg-clip-text text-transparent">SkillSwap</span>
        </div>

        <nav class="space-y-2">
            <a href="dashboard.php" class="flex items-center gap-4 px-4 py-3 bg-slate-900 text-indigo-400 font-medium rounded-xl border border-slate-800 transition">
                <i class="fa-solid fa-layer-group"></i> Global Feed
            </a>
            <a href="requests.php" class="flex items-center justify-between px-4 py-3 text-slate-400 hover:bg-slate-900 hover:text-slate-200 font-medium rounded-xl transition">
                <div class="flex items-center gap-4">
                    <i class="fa-solid fa-briefcase"></i> Direct Proposals
                </div>
                <?php if($unread_count > 0): ?>
                    <span class="bg-rose-600 text-white font-bold text-[10px] px-2 py-0.5 rounded-full animate-pulse"><?= $unread_count ?></span>
                <?php endif; ?>
            </a>
            <a href="user_profile.php?id=<?= $_SESSION['user_id'] ?>" class="flex items-center gap-4 px-4 py-3 text-slate-400 hover:bg-slate-900 hover:text-slate-200 font-medium rounded-xl transition">
                <i class="fa-solid fa-id-card-clip"></i> My Portfolio Wall
            </a>
        </nav>
    </div>

    <div class="flex items-center gap-3 p-2 bg-slate-900/50 rounded-xl border border-slate-800">
        <div class="w-9 h-9 bg-gradient-to-tr from-indigo-500 to-emerald-500 rounded-lg flex items-center justify-center font-bold text-white uppercase text-xs">
            <?= substr($_SESSION['fullname'], 0, 2) ?>
        </div>
        <div class="min-w-0 flex-1">
            <h4 class="text-xs font-semibold text-slate-200 truncate"><?= $_SESSION['fullname'] ?></h4>
            <p class="text-[10px] text-slate-500 truncate"><?= $_SESSION['headline'] ?></p>
        </div>
        <a href="logout.php" class="text-slate-500 hover:text-rose-400 transition pl-1" title="Log Out"><i class="fa-solid fa-power-off text-sm"></i></a>
    </div>
</aside>