<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Account.dat value calculator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  </head>
  <body class="container">
  <h1>Account.dat value calculator</h1>
  <h5>By Gab</h5>
  <form method="POST">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Mii Name</label>
    <input class="form-control" id="exampleInputEmail1" name="miiName" aria-describedby="emailHelp" placeholder="Mii Name">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Mii Data</label>
    <input class="form-control" name="miiData" placeholder="Example: AwAAQEuX4+nGhzGy04Y5PxShgom0rwAAIkBwAHIAbwBkAHQAZQBzAHQAMQAAAEBAAAAhAQJoRBgmNEYUgRIXaA0AACkAUkhQSQBhAG4AAAAAAAAAAAAAAAAAAAAAAN2k">
  </div>
  <div class="mb-3">
  <label for="exampleInputPassword1" class="form-label">PID</label>
    <input type="number" class="form-control" name="principalID" placeholder="Example: 1799999999">
  </div>
  <button type="submit" class="btn btn-primary">Submit!</button>
</form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>

    <?php
    // Calculator
    if($_SERVER['REQUEST_METHOD'] === 'POST') {
    print '<h3>Here\'s the information you submitted, converted to valid values for use in the account.dat file.</h3><div class="card">
    <div class="card-body">';

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
        print "Mii Name:". bin2hex($binaryMiiName); // Should work on Cemu
    }

    // Retrieve Mii Data from the post request
    if(isset($_POST["miiData"])) {
        $miiDataBase64 = $_POST['miiData'];
        
        // Decode base64-encoded Mii data
        $miiDataBinary = base64_decode($miiDataBase64);

        print "<br>Mii Data:". bin2hex($miiDataBinary);
    }

    // Retrieve PID from the post request
    if(isset($_POST["principalID"])) {
        $accountPid = $_POST["principalID"];
        if (ctype_digit($accountPid)) {
        print "<br>PID:". dechex($accountPid); }
    }

        // Tries to generate a valid UUID.
        function generateUuid() {
          return sprintf(
              '%04x%04x-%04x-4%03x-%04x-%04x%04x%04x',
              mt_rand(0, 0xffff),
              mt_rand(0, 0xffff),
              mt_rand(0, 0xffff),
              mt_rand(0, 0xfff) | 0x4000,
              mt_rand(0, 0xffff),
              mt_rand(0, 0xffff),
              mt_rand(0, 0xffff),
              mt_rand(0, 0xffff)
          );
      } 
  
      // Call the function...
      $uuid = generateUuid();
  
      // Remove dashes to match the format
      $uuidString = str_replace('-', '', $uuid);

      print "<br>Uuid (generated randomly):". $uuidString;

     print '<br><small><b>Still missing the AccountPasswordCache field? Don\'t worry, generate your hash in this <a href="/pass-hash/">page</a>.</b></small></div>';
    }
    ?>
