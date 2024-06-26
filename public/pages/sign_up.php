<?php
$PATH = "../";
include_once '../php/sql_connect.php';
include_once '../php/sql_utils.php';
include_once '../php/user.php';
include_once '../php/session.php';



$head = [
    "title" => "Sign up",
    "sctipts" => [
        "signup.js"
    ]
];

session_start();

if (isset($_SESSION["id"])) {
    if (isValidSession($_SESSION["id"])) {
        header("Location: chat.php");
        return;
    }
}

// Sign up logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['username'])) return;
    //if (!isset($_POST['email'])) return;
    if (!isset($_POST['password'])) return;
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    //:TODO: Better feedback for the user
    if (isUserExists($username)) {
        echo "User already exists";
        return;
    } 

    $password = hash('sha256', $password . $username);
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $params = [$username, $password];

    runSql($sql, $params);

    $userId = getUserId($username);
    $sessionId = createUserSession($userId);

    $_SESSION["id"] = $sessionId;

    header("Location: chat.php");

    //header("Location: sign_in.php");
}
?>

<!DOCTYPE html>
<html lang="nl">
<?php include '../php/head.php'; ?>
<body>
    <main class="center-flex">
        <section id="sign-up">
            <h1>Sign up</h1>
            <form action="sign_up.php" method="post" id="sign_up_form" name="sign_up_form">
                <label for="username">Username</label>
                <input type="text" name="username" placeholder="Username" required>
                <!-- <label for="email">Email</label>
                <input type="email" name="email" placeholder="Email" required> -->
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Password" required>
                <label for="password_confirm">Confirm password</label>
                <input type="password" name="password_confirm" placeholder="Confirm password" required>
                
                <input type="submit" value="Sign up" id="sign_up_submit">
            </form>
            <p>Heb je een account? <a href="sign_in.php">Sign in</a></p>
        </section>
    </main>
</body>
</html>