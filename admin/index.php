<?php
/**
 * Apex Air Admin Dashboard
 */

require_once '../backend/config.php';
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Check admin login
$admin_logged_in = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'];

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['admin_login'])) {
    if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Invalid, return and try again.');
    }
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    $admin_file = json_decode(file_get_contents(ADMIN_PASSWORD_FILE), true);
    
    if ($username === $admin_file['username'] && password_verify($password, $admin_file['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_login_time'] = time();
        $admin_logged_in = true;
    } else {
        $login_error = 'Invalid username or password';
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: index.php');
    exit;
}

// Handle application approval/rejection
if ($admin_logged_in && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if (empty($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die('Invalid request, return and try again.');
    }
    $app_id = $_POST['app_id'] ?? '';
    $action = $_POST['action'] ?? '';
    $notes = sanitize($_POST['notes'] ?? '');
    
    $applications = readDatabase(APPLICATIONS_DB);
    $pilots = readDatabase(PILOTS_DB);
    
    foreach ($applications as &$app) {
        if ($app['id'] === $app_id) {
            if ($action === 'approve') {
                $app['status'] = 'approved';
            } elseif ($action === 'reject') {
                $app['status'] = 'rejected';
            } elseif ($action === 'needs_info') {
                $app['status'] = 'needs_info';
            }
            $app['reviewed_at'] = date('Y-m-d H:i:s');
            $app['reviewed_by'] = 'admin';
            $app['notes'] = $notes;
            
            // Update pilot status
            foreach ($pilots as &$pilot) {
                if ($pilot['id'] === $app['pilot_id']) {
                    $pilot['status'] = $app['status'];
                    break;
                }
            }
            break;
        }
    }
    
    writeDatabase(APPLICATIONS_DB, $applications);
    writeDatabase(PILOTS_DB, $pilots);
    $success_message = 'Application ' . $action . 'ed successfully!';
}

$pilots = readDatabase(PILOTS_DB);
$applications = readDatabase(APPLICATIONS_DB);

$stats = [
    'total_pilots' => count($pilots),
    'pending_applications' => count(array_filter($applications, fn($a) => $a['status'] === 'pending')),
    'approved_pilots' => count(array_filter($pilots, fn($p) => $p['status'] === 'approved')),
    'registered_pilots' => count(array_filter($pilots, fn($p) => $p['status'] === 'registered'))
];

// Sort applications by newest first
usort($applications, fn($a, $b) => strtotime($b['created_at']) - strtotime($a['created_at']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apex Air Admin Panel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }
        
        .navbar {
            background: linear-gradient(135deg, #1a472a 0%, #2d5f3f 100%);
            padding: 1rem 2rem;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .navbar h1 {
            font-size: 1.5rem;
        }
        
        .navbar a {
            color: white;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            background: rgba(255,255,255,0.1);
            transition: all 0.3s;
        }
        
        .navbar a:hover {
            background: rgba(255,255,255,0.2);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }
        
        .login-panel {
            max-width: 400px;
            margin: 5rem auto;
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        
        .login-panel h2 {
            margin-bottom: 1.5rem;
            color: #1a472a;
        }
        
        .login-panel input {
            width: 100%;
            padding: 10px;
            margin-bottom: 1rem;
            border: 2px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        
        .login-panel button {
            width: 100%;
            padding: 10px;
            background: #1a472a;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .login-panel button:hover {
            background: #2d5f3f;
        }
        
        .error {
            background: #fee;
            color: #c00;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }
        
        .success {
            background: #efe;
            color: #0a0;
            padding: 1rem;
            border-radius: 4px;
            margin-bottom: 1rem;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }
        
        .stat-card {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            text-align: center;
            border-top: 4px solid #4a8f5f;
        }
        
        .stat-card h3 {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
        }
        
        .stat-card .number {
            font-size: 2rem;
            font-weight: 700;
            color: #1a472a;
        }
        
        .section {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            margin-bottom: 2rem;
        }
        
        .section h2 {
            color: #1a472a;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 1rem;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        table th {
            background: #f5f7fa;
            padding: 1rem;
            text-align: left;
            color: #1a472a;
            font-weight: 600;
            border-bottom: 2px solid #ddd;
        }
        
        table td {
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }
        
        table tr:hover {
            background: #f9f9f9;
        }
        
        .status {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }
        
        .status.pending {
            background: #ffeaa7;
            color: #d63031;
        }
        
        .status.approved {
            background: #55efc4;
            color: #00b894;
        }
        
        .status.rejected {
            background: #fab1a0;
            color: #d63031;
        }
        
        .status.registered {
            background: #74b9ff;
            color: #0984e3;
        }
        
        .status.needs_info {
            background: #dfe6e9;
            color: #636e72;
        }
        
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }
        
        .modal.active {
            display: flex;
        }
        
        .modal-content {
            background: white;
            padding: 2rem;
            border-radius: 8px;
            max-width: 600px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
        }
        
        .modal-content h3 {
            color: #1a472a;
            margin-bottom: 1rem;
        }
        
        .modal-content button {
            padding: 0.5rem 1rem;
            margin: 0.5rem 0.5rem 0.5rem 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
        }
        
        .btn-approve {
            background: #55efc4;
            color: #00b894;
        }
        
        .btn-reject {
            background: #fab1a0;
            color: #d63031;
        }
        
        .btn-info {
            background: #dfe6e9;
            color: #636e72;
        }
        
        .btn-close {
            background: #ddd;
            color: #333;
            float: right;
        }
        
        textarea {
            width: 100%;
            padding: 0.5rem;
            margin: 0.5rem 0;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-family: inherit;
        }
        
        .no-data {
            text-align: center;
            padding: 2rem;
            color: #999;
        }
        
        .empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: #999;
        }
        
        .empty-state svg {
            width: 100px;
            height: 100px;
            margin-bottom: 1rem;
            opacity: 0.5;
        }
    </style>
</head>
<body>
    <?php if ($admin_logged_in): ?>
    
    <div class="navbar">
        <h1>🛡️ Apex Air Admin Panel</h1>
        <a href="?logout">Logout</a>
    </div>
    
    <div class="container">
        <?php if (isset($success_message)): ?>
        <div class="success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <div class="stats">
            <div class="stat-card">
                <h3>Total Pilots</h3>
                <div class="number"><?php echo $stats['total_pilots']; ?></div>
            </div>
            <div class="stat-card">
                <h3>Pending Applications</h3>
                <div class="number"><?php echo $stats['pending_applications']; ?></div>
            </div>
            <div class="stat-card">
                <h3>Approved Pilots</h3>
                <div class="number"><?php echo $stats['approved_pilots']; ?></div>
            </div>
            <div class="stat-card">
                <h3>Registered (No App)</h3>
                <div class="number"><?php echo $stats['registered_pilots']; ?></div>
            </div>
        </div>
        
        <!-- Pending Applications -->
        <div class="section">
            <h2>📋 Pending Applications</h2>
            <?php 
            $pending_apps = array_filter($applications, fn($a) => $a['status'] === 'pending');
            if (empty($pending_apps)): 
            ?>
                <div class="empty-state">
                    <p>No pending applications</p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Pilot Name</th>
                            <th>VATSIM ID</th>
                            <th>Flight Hours</th>
                            <th>Rating</th>
                            <th>Applied</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pending_apps as $app): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($app['pilot_name']); ?></td>
                            <td><?php echo htmlspecialchars($app['pilot_vatsim']); ?></td>
                            <td><?php echo $app['flight_hours']; ?></td>
                            <td><?php echo htmlspecialchars($app['rating']); ?></td>
                            <td><?php echo date('M d, Y', strtotime($app['created_at'])); ?></td>
                            <td><button onclick="openReviewModal('<?php echo $app['id']; ?>')">Review</button></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        
        <!-- All Pilots -->
        <div class="section">
            <h2>👥 All Pilots</h2>
            <?php if (empty($pilots)): ?>
                <div class="empty-state">
                    <p>No pilots registered yet</p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>VATSIM ID</th>
                            <th>Status</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pilots as $pilot): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($pilot['name']); ?></td>
                            <td><?php echo htmlspecialchars($pilot['email']); ?></td>
                            <td><?php echo htmlspecialchars($pilot['vatsim']); ?></td>
                            <td><span class="status <?php echo $pilot['status']; ?>"><?php echo ucfirst($pilot['status']); ?></span></td>
                            <td><?php echo date('M d, Y', strtotime($pilot['created_at'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        
        <!-- Application History -->
        <div class="section">
            <h2>📊 Application History</h2>
            <?php if (empty($applications)): ?>
                <div class="empty-state">
                    <p>No applications submitted yet</p>
                </div>
            <?php else: ?>
                <table>
                    <thead>
                        <tr>
                            <th>Pilot Name</th>
                            <th>Hours</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th>Applied</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($applications as $app): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($app['pilot_name']); ?></td>
                            <td><?php echo $app['flight_hours']; ?></td>
                            <td><?php echo htmlspecialchars($app['rating']); ?></td>
                            <td><span class="status <?php echo $app['status']; ?>"><?php echo ucfirst(str_replace('_', ' ', $app['status'])); ?></span></td>
                            <td><?php echo date('M d, Y', strtotime($app['created_at'])); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Review Modal -->
    <div class="modal" id="reviewModal">
        <div class="modal-content">
            <button class="btn-close" onclick="closeReviewModal()">✕</button>
            <h3>Review Application</h3>
            <div id="applicationDetails"></div>
            <form method="POST" style="margin-top: 1rem;">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <textarea name="notes" placeholder="Admin notes (optional)..." rows="4"></textarea>
                <div style="margin-top: 1rem;">
                    <button type="submit" name="action" value="approve" class="btn-approve">✓ Approve</button>
                    <button type="submit" name="action" value="needs_info" class="btn-info">ℹ Needs Info</button>
                    <button type="submit" name="action" value="reject" class="btn-reject">✕ Reject</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        function openReviewModal(appId) {
            const apps = <?php echo json_encode($applications); ?>;
            const app = apps.find(a => a.id === appId);
            
            if (app) {
                document.getElementById('appId').value = appId;
                
                let html = `
                    <strong>Pilot:</strong> ${app.pilot_name} (${app.pilot_email})<br>
                    <strong>VATSIM ID:</strong> ${app.pilot_vatsim}<br>
                    <strong>Flight Hours:</strong> ${app.flight_hours}<br>
                    <strong>Rating:</strong> ${app.rating}<br>
                    <strong>Availability:</strong> ${app.availability}<br>
                    <strong>Aircraft Preferences:</strong> ${app.aircraft_preferences.join(', ') || 'None'}<br>
                    <strong>Applied:</strong> ${new Date(app.created_at).toLocaleDateString()}<br>
                `;
                
                if (app.additional_info) {
                    html += `<strong>Additional Info:</strong> ${app.additional_info}<br>`;
                }
                
                document.getElementById('applicationDetails').innerHTML = html;
                document.getElementById('reviewModal').classList.add('active');
            }
        }
        
        function closeReviewModal() {
            document.getElementById('reviewModal').classList.remove('active');
        }
    </script>
    
    <?php else: ?>
    
    <div class="login-panel">
        <h2>Admin Login</h2>
        <?php if (isset($login_error)): ?>
        <div class="error"><?php echo htmlspecialchars($login_error); ?></div>
        <?php endif; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
            <input type="hidden" name="admin_login" value="1">
            <button type="submit">Login</button>
        </form>
        <p style="text-align: center; margin-top: 1rem; color: #666;">
            Default: admin / admin<br>
            <small>⚠️ Change this immediately!</small>
        </p>
    </div>
    
    <?php endif; ?>
</body>
</html>
