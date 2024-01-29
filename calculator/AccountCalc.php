<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account.dat value calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body>

  <form method="POST">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Mii Name</label>
    <input class="form-control" id="exampleInputEmail1" name="miiName" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Mii Data</label>
    <input class="form-control" name="miiData">
  </div>
  <div class="mb-3">
  <label for="exampleInputPassword1" class="form-label">PID</label>
    <input class="form-control" name="principalID">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>

    <?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    if($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(isset($_POST["miiName"])) { 
    // Remember: if the Mii Name on the account.dat file is DIFFERENT from what the mii name is in the account server, only the name in the account server will be shown to others! Remember to change your mii's name so it can stay equal in both sides.
    $miiNameBuffer = str_repeat("\0", 0x16);
    // Retrieve Mii name from the POST request
        $miiName = mb_convert_encoding($_POST['miiName'], 'UTF-16LE');
        $miiName = substr($miiName, 0, 0x16); // Truncate or pad to 22 bytes

        // Manually convert the string to little-endian UTF-16LE
        $binaryMiiName = '';
        for ($i = 0; $i < strlen($miiName); $i += 2) {
            $binaryMiiName .= $miiName[$i + 1] . $miiName[$i];
        }
        $binaryMiiName = str_pad($binaryMiiName, 0x16, "\0\0", STR_PAD_RIGHT); // Pad to 22 bytes with "00" at the end
        echo "Mii Name:". bin2hex($binaryMiiName); // Should work on Cemu
    }

    // Retrieve Mii Data from the post request
    if(isset($_POST["miiData"])) {
        $miiDataBase64 = $_POST['miiData'];
        
        // Decode base64-encoded Mii data
        $miiDataBinary = base64_decode($miiDataBase64);

        echo "<br>Mii Data:". bin2hex($miiDataBinary);
    }

    // Retrieve PID from the post request
    if(isset($_POST["principalID"])) {
        $accountPid = $_POST["principalID"];
        if (ctype_digit($accountPid)) {
        echo "<br>PID:". dechex($accountPid); }
    }

    }
    ?>
