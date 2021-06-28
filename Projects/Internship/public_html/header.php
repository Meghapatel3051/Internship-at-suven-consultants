<?php
    session_start();
    require_once 'functions.php';
    $userstr = 'Welcome Guest';

    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
        $loggedin = TRUE;
        $userstr = "Logged in as : $user";
    }
    else    
        $loggedin = FALSE;
        
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="jquery.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Robin's Nest: <?= $userstr ?></title>
</head>

<body>
    <div id="wrapper">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">SocialRobin</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if($loggedin): ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="members.php?view=<?= $user ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="members.php">Members</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="friends.php">Friends</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="messages.php">Messages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="profile.php">Edit Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="logout.php">Log out</a>
                    </li>
                    <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="signup.php">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="login.php">Log In</a>
                    </li>
                    <?php endif; ?>
                </ul>
                <div class="d-flex text-white">
                    <?= $userstr ?>
                </div>
            </div>
        </div>
    </nav>
    <div data-role="content" class="container">

    <?php
    if (!$loggedin) {
        echo '<p class="info">(You must be logged in to use this app)</p>';
    }
?>