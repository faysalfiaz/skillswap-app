<?php
session_start();
$error = isset($_SESSION['auth_error']) ? $_SESSION['auth_error'] : "";
unset($_SESSION['auth_error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillSwap | Setup Portfolio Identity</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex items-center justify-center p-4 sm:p-6">

    <!-- Split Layout Container for Registration -->
    <div class="w-full max-w-5xl bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden grid md:grid-cols-5 min-h-[600px] my-6">
        
        <!-- Left Side Panel (Occupies 2 Columns) -->
        <div class="bg-gradient-to-br from-blue-600 to-sky-400 p-8 flex flex-col justify-between text-white relative overflow-hidden hidden md:flex md:col-span-2">
            <div class="absolute -right-5 -bottom-5 w-48 h-48 bg-white/10 rounded-full blur-3xl"></div>

            <div class="flex items-center gap-2.5">
                <div class="bg-white/20 p-2 rounded-xl border border-white/30 backdrop-blur-md">
                    <i class="fa-solid fa-user-plus text-xl"></i>
                </div>
                <span class="text-xl font-bold tracking-wide">SkillSwap</span>
            </div>

            <!-- Conceptual Registration Illustration/Picture Link -->
            <div class="my-auto flex flex-col items-center text-center px-4">
                <img src="https://img.freepik.com/free-vector/sign-up-concept-illustration_114360-7885.jpg" alt="Registration Asset Illustration" class="w-60 h-auto mix-blend-multiply opacity-95 mb-6 drop-shadow-lg rounded-2xl">
                <h3 class="text-xl font-bold">Join the Matrix Network</h3>
                <p class="text-sky-100 text-xs mt-2 max-w-xs leading-relaxed">Map out your central framework competencies, GitHub pipelines, and direct collaboration endpoints.</p>
            </div>

            <div class="text-[11px] text-sky-200/80 font-mono">
                Modular Talent Sourcing System v2.0
            </div>
        </div>

        <!-- Right Side Panel: Form (Occupies 3 Columns) -->
        <div class="p-6 sm:p-8 flex flex-col justify-center space-y-4 md:col-span-3">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Register Node Identity</h2>
                <p class="text-slate-500 text-xs mt-0.5">Build your centralized portfolio metrics map for public queries.</p>
            </div>

            <?php if($error): ?> 
                <div class="bg-rose-50 border border-rose-200 text-rose-600 text-xs p-3 rounded-xl flex items-center gap-2">
                    <i class="fa-solid fa-triangle-exclamation"></i> <?= $error ?>
                </div> 
            <?php endif; ?>

            <form action="auth_process.php" method="POST" class="space-y-3">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-1 flex items-center gap-1.5">
                            <i class="fa-regular fa-id-card text-slate-400"></i> Full Name
                        </label>
                        <input type="text" name="fullname" required class="w-full bg-slate-50 text-slate-900 text-xs rounded-xl p-2.5 border border-slate-200 focus:outline-none focus:border-sky-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-1 flex items-center gap-1.5">
                            <i class="fa-regular fa-envelope text-slate-400"></i> Target Email
                        </label>
                        <input type="email" name="email" required class="w-full bg-slate-50 text-slate-900 text-xs rounded-xl p-2.5 border border-slate-200 focus:outline-none focus:border-sky-500 focus:bg-white transition">
                    </div>
                </div>
                
                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-briefcase text-slate-400"></i> Professional Headline
                    </label>
                    <input type="text" name="headline" placeholder="e.g. CS Student | Software Engineer" required class="w-full bg-slate-50 text-slate-900 text-xs rounded-xl p-2.5 border border-slate-200 focus:outline-none focus:border-sky-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-code text-slate-400"></i> Core Tech Skills (Comma Separated)
                    </label>
                    <input type="text" name="skills_csv" placeholder="PHP, Tailwind, Java, Python, C++" required class="w-full bg-slate-50 text-slate-900 text-xs rounded-xl p-2.5 border border-slate-200 focus:outline-none focus:border-sky-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-terminal text-slate-400"></i> Bio Summary Narrative
                    </label>
                    <textarea name="bio" rows="2" placeholder="Briefly capture your framework stacks..." class="w-full bg-slate-50 text-slate-900 text-xs rounded-xl p-2.5 border border-slate-200 focus:outline-none focus:border-sky-500 focus:bg-white transition resize-none"></textarea>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-1 flex items-center gap-1.5">
                            <i class="fa-brands fa-whatsapp text-emerald-500"></i> WhatsApp Number
                        </label>
                        <input type="text" name="whatsapp" placeholder="e.g. 8801700000000" required class="w-full bg-slate-50 text-slate-900 text-xs rounded-xl p-2.5 border border-slate-200 focus:outline-none focus:border-sky-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-1 flex items-center gap-1.5">
                            <i class="fa-brands fa-facebook-messenger text-blue-500"></i> Messenger Handle
                        </label>
                        <input type="text" name="messenger" placeholder="username" class="w-full bg-slate-50 text-slate-900 text-xs rounded-xl p-2.5 border border-slate-200 focus:outline-none focus:border-sky-500 focus:bg-white transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-1 flex items-center gap-1.5">
                            <i class="fa-brands fa-github text-slate-800"></i> GitHub Profile URL
                        </label>
                        <input type="url" name="github" class="w-full bg-slate-50 text-slate-900 text-xs rounded-xl p-2.5 border border-slate-200 focus:outline-none focus:border-sky-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-slate-600 mb-1 flex items-center gap-1.5">
                            <i class="fa-brands fa-linkedin text-blue-500"></i> LinkedIn Profile URL
                        </label>
                        <input type="url" name="linkedin" class="w-full bg-slate-50 text-slate-900 text-xs rounded-xl p-2.5 border border-slate-200 focus:outline-none focus:border-sky-500 focus:bg-white transition">
                    </div>
                </div>

                <div>
                    <label class="block text-[11px] font-semibold text-slate-600 mb-1 flex items-center gap-1.5">
                        <i class="fa-solid fa-key text-slate-400"></i> System Account Password
                    </label>
                    <input type="password" name="password" required class="w-full bg-slate-50 text-slate-900 text-xs rounded-xl p-2.5 border border-slate-200 focus:outline-none focus:border-sky-500 focus:bg-white transition">
                </div>

                <button type="submit" name="register" class="w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold py-2.5 rounded-xl text-xs transition shadow-md shadow-sky-500/10 flex items-center justify-center gap-2 mt-2">
                    <i class="fa-solid fa-server"></i> Initialize Profile Node
                </button>
            </form>
            <div class="text-center pt-2">
                <a href="index.php" class="text-xs text-sky-500 font-semibold hover:underline">Existing identity? Return to Sign In</a>
            </div>
        </div>

    </div>

</body>
</html>