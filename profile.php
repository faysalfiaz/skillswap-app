<?php
require_once 'db.php'; // Your database connection file

// Fetch user ID from URL query parameters
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    
    // Retrieve all contact and matrix information for this user from the database
    $query = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
}

if (!$user) {
    die("User not found or network node missing.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($user['fullname']); ?> - Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b1329] text-white font-sans min-h-screen flex items-center justify-center">

    <div class="bg-[#131c35] p-8 rounded-2xl shadow-2xl max-w-md w-full border border-gray-800 text-center">
        <!-- Profile Card Header Avatar -->
        <div class="w-24 h-24 bg-gradient-to-tr from-blue-500 to-purple-600 rounded-full mx-auto flex items-center justify-center text-3xl font-bold text-white shadow-lg mb-4">
            <?php echo strtoupper(substr($user['fullname'], 0, 1)); ?>
        </div>
        
        <h1 class="text-2xl font-extrabold tracking-wide mb-1"><?php echo htmlspecialchars($user['fullname']); ?></h1>
        <p class="text-purple-400 font-medium text-sm mb-3"><?php echo htmlspecialchars($user['headline']); ?></p>
        <p class="text-gray-400 text-sm mb-6 px-4"><?php echo htmlspecialchars($user['bio']); ?></p>
        
        <!-- Skill Matrix Section -->
        <div class="mb-6">
            <span class="text-xs font-bold uppercase text-gray-500 tracking-widest block mb-2">Core Skills</span>
            <div class="flex flex-wrap justify-center gap-2">
                <?php 
                if (!empty($user['skills_csv'])) {
                    $skills = explode(',', $user['skills_csv']);
                    foreach($skills as $skill) {
                        echo "<span class='bg-[#1e294b] text-xs font-semibold px-3 py-1 rounded-full border border-gray-700'>".trim(htmlspecialchars($skill))."</span>";
                    }
                }
                ?>
            </div>
        </div>

        <hr class="border-gray-800 my-6">

        <!-- 📞 Contact Matrix Action Buttons -->
        <span class="text-xs font-bold uppercase text-gray-500 tracking-widest block mb-4">Connect Matrix</span>
        <div class="grid grid-cols-2 gap-3">
            
            <!-- Email Gateway -->
            <a href="https://mail.google.com/mail/?view=cm&fs=1&to=<?php echo urlencode($user['email']); ?>" target="_blank" class="flex items-center justify-center gap-2 bg-[#1e294b] hover:bg-blue-600 transition-all py-3 rounded-xl font-medium text-sm border border-gray-700">
                📧 Email
            </a>
            
            <!-- WhatsApp Gateway -->
            <a href="<?php echo !empty($user['whatsapp_num']) ? 'https://wa.me/' . urlencode($user['whatsapp_num']) : '#'; ?>" target="_blank" class="flex items-center justify-center gap-2 bg-[#1e294b] hover:bg-green-600 transition-all py-3 rounded-xl font-medium text-sm border border-gray-700 <?php echo empty($user['whatsapp_num']) ? 'opacity-50 cursor-not-allowed' : ''; ?>">
                💬 WhatsApp
            </a>

            <!-- GitHub Link -->
            <a href="<?php echo !empty($user['github_url']) ? htmlspecialchars($user['github_url']) : '#'; ?>" target="_blank" class="flex items-center justify-center gap-2 bg-[#24292e] hover:bg-gray-700 transition-all py-3 rounded-xl font-medium text-sm border border-gray-700 <?php echo empty($user['github_url']) ? 'opacity-50 cursor-not-allowed' : ''; ?>">
                💻 GitHub
            </a>

            <!-- LinkedIn Link -->
            <a href="<?php echo !empty($user['linkedin_url']) ? htmlspecialchars($user['linkedin_url']) : '#'; ?>" target="_blank" class="flex items-center justify-center gap-2 bg-[#0077b5] hover:bg-blue-700 transition-all py-3 rounded-xl font-medium text-sm border border-gray-700 <?php echo empty($user['linkedin_url']) ? 'opacity-50 cursor-not-allowed' : ''; ?>">
                👔 LinkedIn
            </a>

        </div>
        
        <div class="mt-6">
            <a href="dashboard.php" class="text-xs text-gray-500 hover:text-white transition-all underline">← Back to Network Dashboard</a>
        </div>
    </div>

</body>
</html>