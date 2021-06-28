<?php
    require_once 'header.php';
    
?>

<script>
    function checkUser(user) {
        if (user.value == '') {
            $('#used').html('&nbsp;')
            return
        }
        $.post('checkuser.php', {
                user: user.value
            },
            function (data) {
                $('#used').html(data)
            }
        )
    }
</script>

<?php
    $error = $user = $pass = "";
    
    if (isset($_SESSION['user'])) destroySession();
    
    if (isset($_POST['user']))
    {
        $user = sanitizeString($_POST['user']);
        $pass = sanitizeString($_POST['pass']);

        if ($user == "" || $pass == "")
            $error = '<p>Not all fields were entered</p><br>';
        else {
            $result = queryMysql("SELECT * FROM members WHERE user='$user'");
            if ($result->num_rows)
                $error = 'That username already exists<br><br>';
            else {
                queryMysql("INSERT INTO members VALUES('$user', '$pass')");
                die('<h4>Account created</h4>Please log in.</div></body></html>');
            }
        }
    }
?>
<form method="post" action="signup.php" id="signupform">
    <?= $error ?>
    <div data-role="fieldcontain" class="margin padding">
        <label></label>
        Please enter your details to sign up
    </div>
    <div data-role="fieldcontain" class="mt-2">
        <div class="row">
            <div class="col-12 col-md-3">
                <label>Username</label>
            </div>
            <div class="col-12 col-md-9">
                <input class="form-control form-control-sm" type='text' maxlength='16' name='user' value='<?= $user ?>'
                    onBlur='checkUser(this)'>
                <div class="mt-1 mb-2" id='used'>&nbsp;</div>
            </div>
        </div>
    </div>
    <div data-role='fieldcontain'>
        <div class="row">
            <div class="col-12 col-md-3">
                <label>Password</label>
            </div>
            <div class="col-12 col-md-9">
                <input class="form-control form-control-sm" type='text' maxlength='16' name='pass' value='<?= $pass ?>'>
            </div>
        </div>
    </div>
    <div data-role='fieldcontain' class="my-3">
        <div class="row">
            <div class="offset-3 col-6">
                <label></label>
                <input class="w-100 btn btn-primary btn-sm" data-transition='slide' type='submit' value='Sign Up'>
            </div>
        </div>
        
    </div>
</form>

<?php require_once 'footer.php'; ?>