<?php
    require_once 'header.php';
    
    $error = $user = $pass = "";
    
    if (isset($_POST['user'])) {
        $user = sanitizeString($_POST['user']);
        $pass = sanitizeString($_POST['pass']);
        
        if ($user == "" || $pass == "")
            $error = 'Not all fields were entered';
        else {
            $result = queryMySQL("SELECT user,pass FROM members WHERE user='$user' AND pass='$pass'");
            if ($result->num_rows == 0) {
                $error = "Invalid login attempt";
            }
            else {
                $_SESSION['user'] = $user;
                $_SESSION['pass'] = $pass;
                
                die("You are now logged in. Please <a data-transition='slide'
                href='members.php?view=$user'>click here</a> to continue.</div>
                </body></html>");
            }
        }
    }
?>
<form method="post" action="login.php" id="loginform">
    <div class="row">
        <div data-role="fieldcontain" class="col-12">
            <label></label>
            <span class="error"><?= $error ?></span>
        </div>
        <div data-role="fieldcontain" class="col-12">
            <label></label>
            Please enter your details to log in
        </div>
        <div data-role="fieldcontain" class="col-12 my-3">
            <div class="row">
                <div class="col-12 col-md-3">
                    <label>Username</label>
                </div>
                <div class="col-12 col-md-9">
                    <input class="form-control form-control-sm" type="text" maxlength="16" name="user" value="<?= $user ?>">
                </div>
            </div>
        </div>
        <div data-role="fieldcontain" class="col-12 my-3">
            <div class="row">
                <div class="col-12 col-md-3">
                    <label>Password</label>
                </div>
                <div class="col-12 col-md-9">
                    <input class="form-control form-control-sm" type="password" maxlength="16" name="pass" value="<?= $pass ?>">
                </div>
            </div>
        </div>
        <div data-role="fieldcontain" class="col-12 mb-4">
            <div class="row">
                <div class="offset-4 col-9">
                    <label></label>
                    <input class="btn btn-sm btn-primary w-50 mx-auto" data-transition="slide" type="submit" value="Login">
                </div>
            </div>         
        </div>
    </div>
</form>

<?php require_once 'footer.php'; ?>