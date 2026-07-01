<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheet.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200..700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Harmony - Login</title>
</head>
<body class="full-height bigbox-vertical bg-color-black border-trans">
    
    <div class="full-center box-vertical Hpixelbox-3 Vpixelbox-4 bg-color-Lblack box-rounded">
    <form method="post" action="index.php?controller=User&action=Signin" class="bigbox-vertical border-trans">
        <div class="box-horizontal border-trans text-full-center Bmargin-0p25">
            <img class="Rmargin-0p1" src="HarmonyLogoClear.png" height="50px">
            <img src="HarmonyText.png" height="30px">
        </div>
        <label class="text-pageread text-color-grayer oswald-font" for="usermail" id="usermailtext">E-mail:</label>
        <input class="text-pagebig Bmargin-0p5 bg-color-black box-rounded text-color-grayer" type="email" id="usermail" name="usermail">
        <label class="text-pageread text-color-grayer oswald-font" for="pass" id="passtext">Password:</label>
        <input class="text-pagebig Bmargin-0p5 bg-color-black box-rounded text-color-grayer" type="password" id="pass" name="pass">
        <input class="text-pageread Bmargin-0p25 Hpixelbox-2 horizontal-center bg-color-black box-rounded text-color-grayer oswald-font" type="submit" id="loginbutt" value="login">
    </form>
    <a href="index.php?controller=User&action=Signup" class="text-color-yellow oswald-font">Don't have an account?</a>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>