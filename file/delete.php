<?php
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $registration_id = $_POST['registration_id'];

    $db = new Database();
    $conn = $db->getConnection();

    if ($action === 'delete') {
        $rejection_reason = $_POST['rejection_reason'];
        $db->update("UPDATE registrations SET status = 'Deleted', rejection_reason = ? WHERE registration_id = ?", [$rejection_reason, $registration_id]);
    } elseif ($action === 'approve') {
        $db->update("UPDATE registrations SET status = 'Approved' WHERE registration_id = ?", [$registration_id]);
    }

    $db->closeConnection();
    header('Location: admin.php');
    exit();
}
