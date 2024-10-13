<?php
function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

function checkLogin() {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

function redirectWithMessage($location, $message) {
    session_start();
    $_SESSION['flash_message'] = $message;
    header("Location: $location");
    exit();
}

function displayFlashMessage() {
    if (isset($_SESSION['flash_message'])) {
        echo "<div class='message'>" . $_SESSION['flash_message'] . "</div>";
        unset($_SESSION['flash_message']);
    }
}

function isFieldEmpty($field) {
    return empty(trim($field));
}

function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function fetchSingleRow($conn, $query) {
    $result = $conn->query($query);
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}
?>