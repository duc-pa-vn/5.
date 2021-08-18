<?php
if (isset($_GET['submit'])) {
    session_start();
    session_unset();
    setcookie('email', '', time() - 1);
    header('Location: http://localhost:8080/LoginPdo.php');
}
?>
<link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<h1>Đăng nhập thành công</h1>
<form action="<?php echo $_SERVER['PHP_SELF'] ?>">
    <button type="submit" name="submit" class="btn btn-primary">Logout</button>
</form>