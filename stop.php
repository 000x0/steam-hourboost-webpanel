<?php
    // Includes
    require __DIR__.'/includes/db.php';

    // Start Hourboost
    if (array_key_exists('username', $_POST)) {
        $sUser = $_POST['username'];

        $sUserHTML = htmlspecialchars($sUser, ENT_QUOTES);

        // Try to find account
        $findUser = $db->query('SELECT username FROM accounts WHERE username=?', [
          $sUser
        ]);

        $findUser = $findUser->fetch_assoc();
		
		// Convert findUser Array to String
        $findUserString = implode("", $findUser);
        
        // If account has been found
        if ($findUser > 0) {
            // Delete from database
            $db->query('DELETE FROM accounts WHERE username=?', [
                $sUser
            ]);
        } else {
            // do nothing
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
                    <h2 class="title" align="center"><i class="fab fa-steam fa-3x"></i><br />Stop Hourboost</h2>
					<?=($findUser > 0 ? "<b><font color='GREEN'>SUCCESS: STOPPED HOURBOOST FOR ACCOUNT '".$sUserHTML."'!</font></b><br />" : "")?>
					<?=($findUserString != $sUser ? "<b><font color='RED'>ERROR: ACCOUNT NOT FOUND!</font></b><br />" : "")?>
                    <form method="POST">
                        <div class="input-group">
                            <input class="input--style-4" type="text" id="username" name="username" placeholder="Steam Username" required>
                        </div>
                        <div class="p-t-15">
                            <button class="btn btn--radius-2 btn--blue" type="submit" id="submit" name="submit">Submit</button>
                            <a href="index.html"><div class="btn btn--radius-2 btn--blue">Back</div></div></a>
                        </div>
                        <div class="title" align="center">Coded by <a href="https://github.com/Triniayo">Jerr0w</a></div>
                    </form>
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
