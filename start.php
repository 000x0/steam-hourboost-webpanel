<?php
    // Includes
    require __DIR__.'/classes/Helper.php';
    require __DIR__.'/includes/db.php';

    // Define security Variable
    $pSecurity = $_POST['security'];

    // Start Hourboost
    if (array_key_exists('username', $_POST) && array_key_exists('password', $_POST) && array_key_exists('games', $_POST)) {
        $sUser = $_POST['username'];
        $sPass = $_POST['password'];
        $sGames = $_POST['games'];

        // Search for duplicate account
        $dupUser = $db->query('SELECT username FROM accounts WHERE username=?', [
            $sUser
        ]);

        $dupUser = $dupUser->fetch_assoc();

        // Convert dupUser Array to String
        $dupUserString = implode("", $dupUser);

        // If account already in database
        if ($dupUser > 0) {
            //do nothing
        } else {
            if ($pSecurity == 1 && array_key_exists('mobileAuth', $_POST)) {
                $sAuth = $_POST['mobileAuth'];

                // Insert into database
                $db->query('INSERT INTO accounts (username, password, secret, games) VALUES (?, ?, ?, ?)', [
                    $sUser,
                    $sPass,
                    $sAuth,
                    $sGames
                ]);
            } else if ($pSecurity == 2 && array_key_exists('steamGuard', $_POST)) {
                $sGuard = $_POST['steamGuard'];

                // Insert into database
                $db->query('INSERT INTO accounts (username, password, sentry, games) VALUES (?, ?, ?, ?)', [
                    $sUser,
                    $sPass,
                    $sGuard,
                    $sGames
                ]);
            } else if ($pSecurity === NULL) {
                // Insert into database
                $db->query('INSERT INTO accounts (username, password, games) VALUES (?, ?, ?)', [
                    $sUser,
                    $sPass,
                    $sGames
                ]);
            } else {
                // Insert into database
                $db->query('INSERT INTO accounts (username, password, games) VALUES (?, ?, ?)', [
                    $sUser,
                    $sPass,
                    $sGames
                ]);
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Steam Hourboost Panel">
    <!-- Title Page-->
    <title>Steam Hourboost</title>
    <!-- Icons font CSS-->
    <link href="vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <!-- Vendor CSS-->
    <link href="vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">
    <!-- Main CSS-->
    <link href="css/main.css" rel="stylesheet" media="all">
</head>

<!-- Loading Jquery JS -->
<script src="vendor/jquery/jquery.min.js"></script>

<body>
    <div class="page-wrapper bg-gra-02 p-t-130 p-b-100 font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4">
                <div class="card-body">
                    <h2 class="title" align="center"><i class="fab fa-steam fa-3x"></i><br />Start Hourboost</h2>
					<?=($dupUserString != $sUser ? "<b><font color='GREEN'>SUCCESS: STARTED HOURBOOST FOR ACCOUNT '".$sUser."'!</font></b><br />" : "")?>
                    <?=($dupUser > 0 ? "<b><font color='RED'>ERROR: ACCOUNT IS BEING BOOSTED ALREADY!</font></b><br />" : "")?>
                    <form method="POST">
                        <div class="input-group">
                            <input class="input--style-4" type="text" id="username" name="username" placeholder="Steam Username" required>
                        </div>
                        <div class="input-group">
                            <input class="input--style-4" type="password" id="password" name="password" placeholder="Steam Password" required>
                        </div>
                        <div class="input-group">
                            <input class="input--style-4" type="text" id="games" name="games" placeholder="Steam Games - example: 730,440,570" required>
                        </div>
                        <div class="input-group">
                            <div class="rs-select2 js-select-simple select--no-search">
                                <select id="security" name="security">
                                    <option disabled="disabled" selected="selected">How is your Steam Account secured?</option>
                                    <option value="1">Steam Mobile</option>
                                    <option value="2">Steam Guard</option>
                                    <option value="3">No security</option>
                                </select>
                                <div class="select-dropdown"></div>
                            </div>
                            <input class="input--style-4" type="text" id="mobileAuth" name="mobileAuth" placeholder="Enter Shared Secret" style="display:none;" />
                            <input class="input--style-4" type="text" id="steamGuard" name="steamGuard" placeholder="Enter Steam Guard Sentry" style="display:none;" />
                        </div>
                        <script>
                            $('#security').change(function() {
                                if ($(this).val() === '1') {
                                    $('#steamGuard').hide();
                                    $('#mobileAuth').show();
                                } else if ($(this).val() === '2') {
                                    $('#mobileAuth').hide();
                                    $('#steamGuard').show();
                                } else {
                                    $('#mobileAuth').hide();
                                    $('#steamGuard').hide();
                                }
                            });
                        </script>
                        <div class="p-t-15">
                            <button class="btn btn--radius-2 btn--blue" type="submit" id="submit" name="submit">Submit</button>
                            <a href="index.php"><div class="btn btn--radius-2 btn--blue">Back</div></div></a>
                        </div>
                    </form>
                    <div class="title" align="center">Coded by <a href="https://github.com/Triniayo">Jerr0w</a></div>
                </div>  
            </div>
        </div>
    </div>
</body>
<!-- Design by https://colorlib.com -->

<!-- Vendor JS-->
<script src="vendor/select2/select2.min.js"></script>
<script src="vendor/datepicker/moment.min.js"></script>
<script src="vendor/datepicker/daterangepicker.js"></script>

<!-- Main JS-->
<script src="js/global.js"></script>
</html>