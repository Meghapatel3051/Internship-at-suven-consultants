<?php
    session_start();
    if(isset($_SESSION['user'])) {
        header("Location:index.php");
    }
    require_once './process.php';
    $loginerr = '';
    $signedup = false;
    if(isset($_POST['SIGNIN'])) {
        $un = $_POST['username'];
        $pwd = $_POST['password'];
        $resp = login($un, $pwd);
        if($resp) {
            $_SESSION['user'] = $resp;
            header("Location:index.php");
        } else {
            $loginerr = 'Invalid username/password';
        }
    } else if(isset($_POST['SIGNUP'])) {
        $un = $_POST['username'];
        $pwd = $_POST['password'];
        $cfnpwd = $_POST['confirmpwd'];
        if(strcmp($pwd, $cfnpwd) !== 0) {
            $loginerr = 'Passwords do not match!';
        }
        if(signup($un, $pwd)) {
            $signedup = true;
        } else {
            $loginerr = 'error signing up try again later!';
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calender - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
        integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./style.css" />
</head>

<body>
    <div class="mx-auto bg-light p-1 pt-4 h" id="loginform">
        <h1 class="text-center">Welcome User</h1>
        <p class="text-center">By login in you will be able add events to the calender</p>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active w-50" id="nav-signin-tab" data-bs-toggle="tab"
                    data-bs-target="#nav-signin" type="button" role="tab" aria-controls="nav-signin"
                    aria-selected="true">
                    SIGN IN
                </button>
                <button class="nav-link w-50" id="nav-signup-tab" data-bs-toggle="tab" data-bs-target="#nav-signup"
                    type="button" role="tab" aria-controls="nav-signup" aria-selected="false">
                    SIGN UP
                </button>
            </div>
        </nav>
        <div class="tab-content my-2" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-signin" role="tabpanel" aria-labelledby="nav-signin-tab">
                <!-- #################################### Sign IN #################################### -->
                <?php if($signedup): ?>
                <p class="text-success text-center">Signup successfull, now you may log in.</p>
                <?php endif; ?>
                <form action="" method="POST" class="p-2">
                    <div class="form-floating mb-3">
                        <input type="text" name="username" class="form-control" id="floatingInput"
                            placeholder="Username">
                        <label for="floatingInput">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" name="password" class="form-control" id="floatingPassword"
                            placeholder="Password">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <p id="signinerr" class="text-danger text-center"><?= $loginerr ?></p>
                    <input type="submit" name="SIGNIN" value="SIGN IN" class="btn btn-success w-100 mb-3">
                </form>
                <!-- #################################### Sign IN #################################### -->
            </div>
            <div class="tab-pane fade" id="nav-signup" role="tabpanel" aria-labelledby="nav-signup-tab">
                <!-- #################################### Sign UP #################################### -->
                <form action="" method="POST" class="p-2">
                    <div class="form-floating mb-3">
                        <input type="text" name="username" class="form-control" id="usernameinp" placeholder="Username">
                        <label for="floatingInput">Username</label>
                        <p id="taken"></p>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" name="password" class="form-control" id="signupPWD1"
                            placeholder="Password">
                        <label for="floatingPassword">Password</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" name="confirmpwd" class="form-control" id="signupPWD2"
                            placeholder="Confirm Password">
                        <label for="floatingPassword">Confirm Password</label>
                    </div>
                    <input type="submit" name="SIGNUP" value="SIGN UP" id="signupbtn"
                        class="btn btn-success w-100 mb-3">
                </form>
                <!-- #################################### Sign UP #################################### -->
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" referrerpolicy="no-referrer">
    </script>
    <script>
        $('#usernameinp').change(function () {
            $.ajax({
                url: "/usernamechk.php",
                data: {
                    username: $('#usernameinp').val()
                }
            }).done(function (resp) {
                if (resp == "taken") {
                    $('#taken').attr('class', 'p-2 text-danger');
                    $('#taken').html('*Username already taken!');
                    $('#signupbtn').prop("disabled", true);
                } else {
                    $('#taken').attr('class', 'p-2 text-success');
                    $('#taken').html('Username available');
                    $('#signupbtn').prop("disabled", false);
                }
            });
        });
    </script>
</body>

</html>