<?php
require_once 'database.php';

if (isset($_GET['id']) && isset($_GET['action'])) {
    $registration_id = $_GET['id'];
    $action = $_GET['action'];

    $db = new Database();
    $conn = $db->getConnection();

    if ($action == 'approve') {
        $db->update("UPDATE registrations SET status = 'Approved' WHERE registration_id = ?", [$registration_id]);
    } elseif ($action == 'delete') {
        $db->update("DELETE FROM registrations WHERE registration_id = ?", [$registration_id]);
    }

    $db->closeConnection();
}

header('Location: admin.php');
exit();
?>
