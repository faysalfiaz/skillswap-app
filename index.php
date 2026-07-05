<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}
$error = isset($_SESSION['auth_error']) ? $_SESSION['auth_error'] : "";
$success = isset($_GET['registered']) ? "Registration successful! Please authenticate below." : "";
unset($_SESSION['auth_error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillSwap | Sign In</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<!-- Soft Premium Sky Blue Gradient Background with Floating Blurs -->
<body class="bg-gradient-to-tr from-sky-100 via-slate-50 to-indigo-100 text-slate-800 min-h-screen flex items-center justify-center p-4 sm:p-6 relative overflow-hidden">
    
    <!-- Background Ambient Glows -->
    <div class="absolute top-[-20%] left-[-10%] w-[50vw] h-[50vw] bg-sky-200/50 rounded-full blur-[140px] pointer-events-none"></div>
    <div class="absolute bottom-[-20%] right-[-10%] w-[50vw] h-[50vw] bg-indigo-200/40 rounded-full blur-[140px] pointer-events-none"></div>

    <!-- Main Premium Container -->
    <div class="w-full max-w-5xl bg-white/80 backdrop-blur-xl rounded-[32px] border border-white/40 shadow-[0_25px_60px_-15px_rgba(14,165,233,0.15)] overflow-hidden grid md:grid-cols-12 min-h-[600px] relative z-10">
        
        <!-- Left Column: Premium Interactive Showcase (5 Columns) -->
        <div class="bg-gradient-to-br from-sky-500 via-sky-600 to-indigo-600 p-8 flex flex-col justify-between text-white relative overflow-hidden hidden md:flex md:col-span-5">
            <div class="absolute -right-10 -top-10 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute -left-10 -bottom-10 w-48 h-48 bg-sky-300/20 rounded-full blur-3xl"></div>

            <!-- Brand Header -->
            <div class="flex items-center gap-2.5">
                <div class="bg-white/15 p-2 rounded-2xl border border-white/25 backdrop-blur-md shadow-inner">
                    <i class="fa-solid fa-circle-nodes text-xl text-sky-200"></i>
                </div>
                <span class="text-xl font-extrabold tracking-tight bg-gradient-to-r from-white to-sky-100 bg-clip-text text-transparent">SkillSwap</span>
            </div>

            <!-- Art Illustration -->
            <div class="my-auto flex flex-col items-center text-center px-2">
                <div class="relative mb-6">
                    <div class="absolute inset-0 bg-white/10 rounded-full blur-xl scale-90"></div>
                    <img src="https://img.freepik.com/free-vector/tablet-user-interface-concept-illustration_114360-3135.jpg" alt="Illustration" class="w-56 h-auto mix-blend-multiply opacity-95 relative z-10 drop-shadow-xl rounded-2xl">
                </div>
                <h3 class="text-xl font-bold tracking-tight">Welcome Back Node!</h3>
                <p class="text-sky-100 text-xs mt-2 max-w-xs leading-relaxed opacity-90">Connect securely to synchronize your technical framework configurations instantly.</p>
            </div>

            <!-- Meta Stamp -->
            <div class="text-[10px] text-sky-200/70 font-mono tracking-widest uppercase">
                Matrix Core Engine // v2.5
            </div>
        </div>

        <!-- Right & About Columns: (7 Columns Total Structure) -->
        <div class="md:col-span-7 grid grid-cols-1 divide-y divide-slate-100">
            
            <!-- Top Part: Interactive Form Panel -->
            <div class="p-8 sm:p-10 space-y-6">
                <div>
                    <h2 class="text-2xl font-extrabold text-slate-900 tracking-tight flex items-center gap-2">
                        Sign In Portal <span class="text-sky-500 text-sm animate-pulse">⚡</span>
                    </h2>
                    <p class="text-slate-400 text-xs mt-1">Authenticate credentials to establish active session telemetry.</p>
                </div>

                <?php if($error): ?> 
                    <div class="bg-rose-50/80 backdrop-blur-sm border border-rose-100 text-rose-600 text-xs p-3 rounded-2xl flex items-center gap-2.5 shadow-sm">
                        <i class="fa-solid fa-triangle-exclamation text-rose-500"></i> <?= $error ?>
                    </div> 
                <?php endif; ?>
                <?php if($success): ?> 
                    <div class="bg-emerald-50/80 backdrop-blur-sm border border-emerald-100 text-emerald-600 text-xs p-3 rounded-2xl flex items-center gap-2.5 shadow-sm">
                        <i class="fa-solid fa-circle-check text-emerald-500"></i> <?= $success ?>
                    </div> 
                <?php endif; ?>

                <form action="auth_process.php" method="POST" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5 flex items-center gap-2 tracking-wide uppercase text-[10px]">
                            <i class="fa-regular fa-envelope text-sky-500"></i> Email Address
                        </label>
                        <input type="email" name="email" required placeholder="name@domain.com" class="w-full bg-slate-50/60 text-slate-900 text-sm rounded-xl p-3 border border-slate-200 focus:outline-none focus:border-sky-500 focus:bg-white transition placeholder-slate-400 shadow-inner">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-600 mb-1.5 flex items-center gap-2 tracking-wide uppercase text-[10px]">
                            <i class="fa-solid fa-shield-halved text-sky-500"></i> Security Password
                        </label>
                        <input type="password" name="password" required placeholder="••••••••" class="w-full bg-slate-50/60 text-slate-900 text-sm rounded-xl p-3 border border-slate-200 focus:outline-none focus:border-sky-500 focus:bg-white transition placeholder-slate-400 shadow-inner">
                    </div>
                    <button type="submit" name="login" class="w-full bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 text-white font-semibold py-3 rounded-xl text-sm transition shadow-lg shadow-sky-500/20 flex items-center justify-center gap-2 transform active:scale-[0.99]">
                        <i class="fa-solid fa-right-to-bracket text-xs opacity-80"></i> Authenticate Identity
                    </button>
                </form>

                <div class="text-center pt-1">
                    <p class="text-xs text-slate-500">New node in the network? <a href="register.php" class="text-sky-500 font-bold hover:text-sky-600 transition hover:underline ml-1">Create Portfolio Profile</a></p>
                </div>
            </div>

            <!-- Bottom Part: Premium "About The Project" Matrix Section -->
            <div class="bg-slate-50/50 backdrop-blur-md p-8 sm:p-10 space-y-4">
                <div class="flex items-center gap-2 text-slate-900">
                    <div class="bg-sky-500/10 p-1.5 rounded-lg text-sky-600 border border-sky-500/10">
                        <i class="fa-solid fa-cubes text-xs"></i>
                    </div>
                    <h4 class="text-xs font-bold tracking-widest uppercase text-slate-500">Project Mission Objective</h4>
                </div>
                
                <p class="text-xs text-slate-600 leading-relaxed font-normal">
                    <strong class="text-slate-800 font-semibold">SkillSwap</strong> is a highly scalable, full-stack peer-to-peer ecosystem designed to blueprint computer science student portfolios. It functions as a modular repository mapping direct framework stacks, real-time code indexes, and streamlined secure networking queries.
                </p>

                <!-- Feature Highlighters -->
                <div class="grid grid-cols-3 gap-3 pt-2">
                    <div class="bg-white border border-slate-100 p-2.5 rounded-xl flex items-center gap-2 shadow-xs">
                        <i class="fa-solid fa-code-branch text-sky-500 text-xs"></i>
                        <span class="text-[10px] font-bold text-slate-700">Code Sync</span>
                    </div>
                    <div class="bg-white border border-slate-100 p-2.5 rounded-xl flex items-center gap-2 shadow-xs">
                        <i class="fa-solid fa-network-wired text-indigo-500 text-xs"></i>
                        <span class="text-[10px] font-bold text-slate-700">P2P Matrix</span>
                    </div>
                    <div class="bg-white border border-slate-100 p-2.5 rounded-xl flex items-center gap-2 shadow-xs">
                        <i class="fa-solid fa-bolt text-amber-500 text-xs"></i>
                        <span class="text-[10px] font-bold text-slate-700">Instant API</span>
                    </div>
                </div>
            </div>

        </div>

    </div>

</body>
</html>