<?php
// Start the session
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../front-end/login.html');
    exit();
}

// Include the database connection
require_once '../db_connection.php';

// Test database connection
try {
    $stmt = $pdo->query("SELECT 1");
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Fetch counts for quick stats
$user_count = 0;
$doctor_count = 0;
$patient_count = 0;
$appointment_count = 0;
$pharmacy_count = 0;
$billing_count = 0;

try {
    // Count total users
    $stmt = $pdo->query("SELECT COUNT(*) AS user_count FROM Users");
    $user_count = $stmt->fetch()['user_count'];

    // Count total doctors
    $stmt = $pdo->query("SELECT COUNT(*) AS doctor_count FROM Doctors");
    $doctor_count = $stmt->fetch()['doctor_count'];

    // Count total patients
    $stmt = $pdo->query("SELECT COUNT(*) AS patient_count FROM Patients");
    $patient_count = $stmt->fetch()['patient_count'];

    // Count total appointments
    $stmt = $pdo->query("SELECT COUNT(*) AS appointment_count FROM Appointments");
    $appointment_count = $stmt->fetch()['appointment_count'];

    // Count total pharmacy records
    $stmt = $pdo->query("SELECT COUNT(*) AS pharmacy_count FROM Pharmacy");
    $pharmacy_count = $stmt->fetch()['pharmacy_count'];

    // Count total billing records
    $stmt = $pdo->query("SELECT COUNT(*) AS billing_count FROM Billing");
    $billing_count = $stmt->fetch()['billing_count'];
} catch (PDOException $e) {
    die("Error fetching data: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="../assets/Css/tailwind.css">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../assets/Css/admin.css">
</head>
<body class="bg-gray-100">
    <div class="dashboard-container flex">
        <!-- Sidebar Navigation -->
        <aside class="sidebar bg-blue-800 text-white w-64 min-h-screen p-4">
            <div class="sidebar-header mb-6">
                <h2 class="text-2xl font-bold">Admin Panel</h2>
            </div>
            <ul class="sidebar-menu space-y-2">
                <li><a href="dashboard.php" class="block p-2 hover:bg-blue-700 rounded"><i class="fas fa-home"></i> Dashboard</a></li>
                <li><a href="manage_appointment.php" class="block p-2 hover:bg-blue-700 rounded"><i class="fas fa-calendar-check"></i> Manage Appointments</a></li>
                <li><a href="manage_billing.php" class="block p-2 hover:bg-blue-700 rounded"><i class="fas fa-file-invoice"></i> Manage Billing</a></li>
                <li><a href="manage_doctors.php" class="block p-2 hover:bg-blue-700 rounded"><i class="fas fa-user-md"></i> Manage Doctors</a></li>
                <li><a href="manage_patient.php" class="block p-2 hover:bg-blue-700 rounded"><i class="fas fa-user-injured"></i> Manage Patients</a></li>
                <li><a href="manage_pharmacy.php" class="block p-2 hover:bg-blue-700 rounded"><i class="fas fa-pills"></i> Manage Pharmacy</a></li>
                <li><a href="manage_users.php" class="block p-2 hover:bg-blue-700 rounded"><i class="fas fa-users-cog"></i> Manage Users</a></li>
            </ul>
            <div class="sidebar-footer mt-6">
                <a href="logout.php" class="block p-2 hover:bg-blue-700 rounded"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content flex-1 p-8">
            <header class="main-header mb-8">
                <h1 class="text-3xl font-bold">Welcome, Admin!</h1>
            </header>

            <!-- Quick Stats Section -->
            <section class="mb-8">
                <h2 class="text-2xl font-bold mb-4">Quick Stats</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Total Users -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-bold">Total Users</h3>
                        <p class="text-3xl"><?php echo $user_count; ?></p>
                    </div>
                    <!-- Total Doctors -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-bold">Total Doctors</h3>
                        <p class="text-3xl"><?php echo $doctor_count; ?></p>
                    </div>
                    <!-- Total Patients -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-bold">Total Patients</h3>
                        <p class="text-3xl"><?php echo $patient_count; ?></p>
                    </div>
                    <!-- Total Appointments -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-bold">Total Appointments</h3>
                        <p class="text-3xl"><?php echo $appointment_count; ?></p>
                    </div>
                    <!-- Total Pharmacy Records -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-bold">Total Pharmacy Records</h3>
                        <p class="text-3xl"><?php echo $pharmacy_count; ?></p>
                    </div>
                    <!-- Total Billing Records -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h3 class="text-xl font-bold">Total Billing Records</h3>
                        <p class="text-3xl"><?php echo $billing_count; ?></p>
                    </div>
                </div>
            </section>

            <!-- Recent Activity Section -->
            <section>
                <h2 class="text-2xl font-bold mb-4">Recent Activity</h2>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th class="text-left">User</th>
                                <th class="text-left">Action</th>
                                <th class="text-left">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Example Row -->
                            <tr>
                                <td>Admin</td>
                                <td>Logged in</td>
                                <td>2025-10-01 12:00 PM</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <!-- JavaScript for interactivity -->
    <script>
        // Add active class to the current page link
        const currentPage = window.location.pathname.split('/').pop();
        const links = document.querySelectorAll('.sidebar-menu a');
        links.forEach(link => {
            if (link.getAttribute('href') === currentPage) {
                link.classList.add('bg-blue-700');
            }
        });
    </script>
</body>
</html>