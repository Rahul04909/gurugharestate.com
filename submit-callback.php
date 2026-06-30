<?php
header('Content-Type: application/json');
require_once __DIR__ . '/database/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';

if (empty($name)) {
    echo json_encode(['success' => false, 'message' => 'Please enter your full name.']);
    exit;
}

if (empty($phone)) {
    echo json_encode(['success' => false, 'message' => 'Please enter your phone number.']);
    exit;
}

// Phone validation: strip spaces, dashes, parentheses, +, and check length
$clean_phone = preg_replace('/[^0-9]/', '', $phone);
if (strlen($clean_phone) < 10) {
    echo json_encode(['success' => false, 'message' => 'Please enter a valid 10-digit mobile number.']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO callback_requests (name, phone, status) VALUES (?, ?, 'Pending')");
if ($stmt) {
    $stmt->bind_param("ss", $name, $phone);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Thank you! We will call you back shortly.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save request. Please try again.']);
    }
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Database error. Please try again.']);
}
?>
