<?php
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $u = $_POST['email'];

    if (strpos($u, "@") !== false) {
        $user = $u;
    } else {
        $user = "+91" . $u;
    }

    $pass = $_POST['pass'];
}

$headers = array(
    'Content-Type:application/json',
    'x-api-key: l7xx938b6684ee9e4bbe8831a9a682b8e19f',
    'app-name: RJIL_JioTV'
);

$username = $user;
$password = $pass;

$payload = array(
    'identifier' => "$username",
    'password' => "$password",
    'rememberUser' => 'T',
    'upgradeAuth' => 'Y',
    'returnSessionDetails' => 'T',
    'deviceInfo' => array(
        'consumptionDeviceName' => 'samsung SM-G930F',
        'info' => array(
            'type' => 'android',
            'platform' => array(
                'name' => 'SM-G930F',
                'version' => '5.1.1'
            ),
            'androidId' => '3022048329094879'
        )
    )
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://api.jio.com/v3/dip/user/unpw/verify');
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($ch, CURLOPT_USERAGENT, 'Dalvik/2.1.0 (Linux; U; Android 5.1.1; SM-G930F Build/LMY48Z)');
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_AUTOREFERER, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
curl_setopt($ch, CURLOPT_TIMEOUT, 20);
$result = curl_exec($ch);
curl_close($ch);

$j = json_decode($result, true);

$k = $j["ssoToken"];
if ($k != "") {
    file_put_contents("assets/data/creds.json", $result);
    $sign = "LOGGED IN SUCCESSFULLY !";
} else {
    $sign = "WRONG USERID OR PASS<br> PLEASE TRY AGAIN";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>JIO LOGIN</title>
    <link rel="stylesheet" href="assets/css/tslogin.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="author" content="Kirodewal">
    <link rel="shortcut icon" type="image/x-icon" href="https://i.ibb.co/37fVLxB/f4027915ec9335046755d489a14472f2.png">
    <meta name="description" content="ENJOY FREE LIVE JIOTV">
    <meta name="keywords" content="JIOTV, LIVETV, SPORTS, MOVIES, MUSIC">
    <meta name="copyright" content="This Created by Kirodewal">
</head>

<body>
    <div class="container">
        <div class="form">
            <form action="<?php $_PHP_SELF ?>" method="POST">
                <h1>JIO LOGIN</h1>
                <label>Jio Number / Email</label>
                <input type="text" name="email" id="" placeholder="Jio Number / Email" />
                <label>Password</label>
                <input type="password" name="pass" id="" placeholder="Password" />
                <input type="submit" value="LogIn Now" />
                <label id="forgotpwd"><?php echo $sign; ?></label>
                <label id="forgotpwd">OTP LOGIN ? <a href="http://jiologin.unaux.com/otp.php">Click Here</a></label>
            </form>
        </div>
    </div>
</body>

</html>