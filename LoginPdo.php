<?php
if (isset($_COOKIE['email'])) {
    session_start();
    $_SESSION['email'] = $email;
    header("Location: http://localhost:8080/LoginSuccessPdo.php");
} else if (isset($_POST['submit'])) {

    //validate email
    if (empty($_POST['email'])) {
        $errors['email'] = 'An email is required';
    } else {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email must be a valid email address';
        } else if (!preg_match('/^.{1,255}$/', $email)) {
            $errors['email'] = 'Email has max 255 characters';
        }
    }

    //validate password
    if (empty($_POST['password'])) {
        $errors['password'] = 'password is required';
    } else {
        $password = $_POST['password'];
        if (!preg_match('/^.{6,100}$/', $password)) {
            $errors['password'] = 'password length from 6 to 100 characters';
        }
    }

    if (empty($errors)) {
        try {
            $email = $_POST['email'];
            $pdo = new PDO('mysql:host=db;port=3306;dbname=ducpa', 'root', 'root');
            $sql = 'select * from ducpa.users where mail = :mail and password = :password';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':mail', $email);
            $stmt->bindValue(':password', $_POST['password']);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($result) < 1) {
                $errors['fail'] = 'Đăng nhập thất bại.';
            } else {
                session_start();
                $_SESSION['email'] = $email;
                if ($_POST['remember'] == 'on') {
                    setcookie("email", $email, time() + (10 * 365 * 24 * 60 * 60));
                }
                header("Location: http://localhost:8080/LoginSuccessPdo.php");
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }
}
?>

<link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<div class="text-danger"><?php echo $errors['fail']; ?></div>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" id="email" name="email">
        <div class="text-danger"><?php echo $errors['email']; ?></div>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password">
        <div class="text-danger"><?php echo $errors['password']; ?></div>
    </div>
    <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" id="remember" name="remember">
        <label class="form-check-label" for="remember">Remember me</label>
    </div>
    <button type="submit" class="btn btn-primary" name="submit">Login</button>
</form>