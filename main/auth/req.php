<?php
header('Content-Type: application/json');
session_start();
include __DIR__ . '/../../config/conn.php'; // Adjust DB connection

// Read raw JSON input
$input = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!isset($input['action'], $input['user'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request'
    ]);
    exit;
}

$action = $input['action'];
$userInput = trim($input['user']);
$password = $input['pass'] ?? ''; // Password may not exist for some actions
$passcode = $input['passcode'] ?? ''; // For confirm_passcode

switch(strtolower($action)) {

    // ================== LOGIN ==================
    case 'login':
        $user=$input['user'] ?? '';
        $pass=$input['pass'] ?? '';
        if (empty($user) || empty($pass)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Enter a valid email/phone and password'
            ]);
            exit;
        }

        $stmt = $conn->prepare("SELECT id, user, email, phone, password_hash FROM users WHERE email = ? OR phone = ? LIMIT 1");
        $stmt->bind_param("ss", $userInput, $userInput);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password_hash'])) {
                $uids = uniqid('UID_');
                $smt=$conn->prepare("UPDATE users SET uids=?, updated_at = NOW() WHERE id = ? limit 1");
                $smt->bind_param("si", $uids, $row['id']);
                $smt->execute();
                $_SESSION['id'] = $row['id'];
                $_SESSION['uid'] = $uids;
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Login successful'
                ]);
                exit;
            }
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid email/phone or password'
            ]);
            return;
        }

        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid email/phone or password'
        ]);
        exit;

    // ================== SIGNUP ==================
    case 'signup':
        $password = $input['pass'] ?? '';
        $userName=$input['user_name'] ?? '';
        $phone=$input['phone'] ?? '';
        $email=$input['email'] ?? '';
        if (empty($password) || empty($userName) || empty($email) || empty($phone)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'All fields are required'
            ]);
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid email address'
            ]);
            exit;
        }

        if (!preg_match('/^\+?[1-9][0-9]{7,14}$/', $phone)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid phone number'
            ]);
            exit;
        }


        // Check if user already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email =? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'User already exists'
            ]);
            exit;
        }

        // Insert new user
        $password_hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $conn->prepare("INSERT INTO users (uids, user, email, phone, password_hash) VALUES (?, ?, ?, ?, ?)");
        $uids = uniqid('UID_'); // Unique ID
        
        $stmt->bind_param("sssss", $uids, $userName, $email, $phone, $password_hash);
        if ($stmt->execute()) {
            $_SESSION['uid'] = $uids;
            $_SESSION['id'] = $conn->insert_id;
            echo json_encode([
                'status' => 'success',
                'message' => 'Signup successful'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Signup failed'
            ]);
        }
        exit;

    // ================== FORGOT PASSWORD ==================
    case 'forgot_password':
        // Generate passcode
        $stmt = $conn->prepare("SELECT id, email, phone FROM users WHERE email = ? OR phone = ? LIMIT 1");
        $stmt->bind_param("ss", $userInput, $userInput);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($user = $result->fetch_assoc()) {
            $passcode = rand(100000, 999999); // 6-digit code
            $_SESSION['passcode'] = $passcode;
            $_SESSION['pass_user_id'] = $user['id'];

            // TODO: send $passcode via email or SMS
            echo json_encode([
                'status' => 'success',
                'message' => 'Passcode sent to your email/phone',
                'passcode' => $passcode // for testing; remove in production
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'User not found'
            ]);
        }
        exit;

    // // ================== CONFIRM PASSCODE ==================
    // case 'confirm_passcode':
    //     if (!$passcode) {
    //         echo json_encode([
    //             'status' => 'error',
    //             'message' => 'Passcode required'
    //         ]);
    //         exit;
    //     }

    //     if (isset($_SESSION['passcode'], $_SESSION['pass_user_id']) && $_SESSION['passcode'] == $passcode) {
    //         // Passcode matches, allow password reset
    //         echo json_encode([
    //             'status' => 'success',
    //             'message' => 'Passcode confirmed. You can reset your password now.'
    //         ]);
    //     } else {
    //         echo json_encode([
    //             'status' => 'error',
    //             'message' => 'Invalid passcode'
    //         ]);
    //     }
    //     exit;



    // ================== CONFIRM PASSCODE ==================
case 'confirm_passcode':
    if (!$passcode || !$password) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Passcode and new password are required'
        ]);
        exit;
    }

    // Verify passcode from session
    if (isset($_SESSION['passcode'], $_SESSION['pass_user_id']) && $_SESSION['passcode'] == $passcode) {
        $userId = $_SESSION['pass_user_id'];
        $newPasswordHash = password_hash($password, PASSWORD_BCRYPT);

        // Update password in DB
        $stmt = $conn->prepare("UPDATE users SET password_hash = ?, updated_at = NOW() WHERE id = ?");
        $stmt->bind_param("si", $newPasswordHash, $userId);

        if ($stmt->execute()) {
            // Clear passcode from session
            unset($_SESSION['passcode']);
            unset($_SESSION['pass_user_id']);

            echo json_encode([
                'status' => 'success',
                'message' => 'Password updated successfully. You can now login.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to update password. Try again.'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid passcode'
        ]);
    }
    exit;


    // ================== DEFAULT ==================
    default:
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid action'
        ]);
        exit;
}
