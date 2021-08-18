<?php
if (isset($_POST['submit'])) {

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

    //validate name
    if (empty($_POST['name'])) {
        $errors['name'] = 'name is required';
    } else {
        $name = $_POST['name'];
        if (!preg_match('/^.{6,200}$/', $name)) {
            $errors['name'] = 'name length from 6 to 200 characters';
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

    //validate passwordConfirm
    if (empty($_POST['passwordConfirm'])) {
        $errors['passwordConfirm'] = 'password confirm is required';
    } else {
        $passwordConfirm = $_POST['passwordConfirm'];
        if (!empty($_POST['password']) && $_POST['password'] != $passwordConfirm) {
            $errors['passwordConfirm'] = 'password confirm must be the same as password';
        }
    }

    //validate phone
    if (empty($_POST['phone'])) {
        $errors['phone'] = 'phone is required';
    } else {
        $phone = $_POST['phone'];
        if (!preg_match('/^[0-9]{10,20}$/', $phone)) {
            $errors['phone'] = 'phone length from 10 to 20 digits';
        }
    }

    //validate address
    if (empty($_POST['address'])) {
        $errors['address'] = 'address is required';
    }

    if (empty($errors)) {
        try {
            $pdo = new PDO('mysql:host=db;port=3306;dbname=ducpa', 'root', 'root');
            $sql = 'insert into ducpa.users (mail, name, password, phone, address) values (:mail, :name, :password, :phone, :address)';
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':mail', $_POST['email']);
            $stmt->bindValue(':name', $_POST['name']);
            $stmt->bindValue(':password', $_POST['password']);
            $stmt->bindValue(':phone', $_POST['phone']);
            $stmt->bindValue(':address', $_POST['address']);
            $stmt->execute();
            header("Location: http://localhost:8080/LoginPdo.php");
        } catch (PDOException $e) {
            echo $e;
        }
    }
}
?>

<link href="vendor/twbs/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">
    <div class="mb-3">
        <label for="mail" class="form-label">Email address</label>
        <input type="email" class="form-control" id="mail" name="email">
        <div class="text-danger"><?php echo $errors['email']; ?></div>
    </div>
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" id="name" name="name">
        <div class="text-danger"><?php echo $errors['name']; ?></div>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password">
        <div class="text-danger"><?php echo $errors['password']; ?></div>
    </div>
    <div class="mb-3">
        <label for="passwordConfirm" class="form-label">Password confirm</label>
        <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm">
        <div class="text-danger"><?php echo $errors['passwordConfirm']; ?></div>
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Address</label>
        <input type="text" class="form-control" id="address" name="address">
        <div class="text-danger"><?php echo $errors['address']; ?></div>
    </div>
    <div class="mb-3">
        <label for="phone" class="form-label">Phone</label>
        <input type="text" class="form-control" id="phone" name="phone">
        <div class="text-danger"><?php echo $errors['phone']; ?></div>
    </div>
    <button type="submit" class="btn btn-primary" name="submit">Register</button>
</form>