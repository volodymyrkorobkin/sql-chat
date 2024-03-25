<?php
$PATH = "../";
include_once '../php/sql_connect.php';
include_once '../php/sql_utils.php';
include_once '../php/user.php';
include_once '../php/session.php';



$head = [
    "title" => "Sign in",
    "sctipts" => [
        "signup.js"// Change this to "signin.js"
    ]
];

session_start();

if (isset($_SESSION["id"])) {
    if (isValidSession($_SESSION["id"])) {
        header("Location: chat.php");
        return;
    }
}


// Sign in logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['username'])) return;
    //if (!isset($_POST['email'])) return;
    if (!isset($_POST['password'])) return;
    
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password = hash('sha256', $password . $username);

    //:TODO: Better feedback for the user
    if (!isUserExists($username)) {
        echo "User does not exist";
        return;
    }

    //:TODO: Better feedback for the user
    if (!isCredentialsCorrect($username, $password)) {
        echo "Credentials are correct";
    }
    
    $userId = getUserId($username);

    $sessionId = createUserSession($userId);

    $_SESSION["id"] = $sessionId;

    header("Location: chat.php");
}


if (isset($_SESSION["id"])) {
    if (isValidSession($_SESSION["id"])) {
        echo "You are signed in";
        echo $_SESSION["id"];
    }
}

// Clear the post data
$_POST = array();
?>

<!DOCTYPE html>
<html lang="nl">
<?php include '../php/head.php'; ?>
<body>
    <main class="center-flex">
        <section id="sign-in">
            <h1>Sign in</h1>
            <form action="sign_in.php" method="post" id="sign_in_form" name="sign_in_form">
                <label for="username">Username</label>
                <input type="text" name="username" placeholder="Username" required>
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Password" required>
                
                <input type="submit" value="Sign in" id="sign_in_submit">
            </form>
            <p>Heb je geen account? <a href="sign_up.php">Sign up</a></p>
        </section>
    </main>
</body>
</html>