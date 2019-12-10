<?php
    session_start();
    require_once("./config.php");
?>

<!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="url shortener">
    <title><?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
<br>
<center>
    <h1><?php echo SITE_NAME; ?></h1>
    <?php
    if (isset($_SESSION['success'])) {
        echo "<p class='success'>" . $_SESSION['success'] . "</p>";
        unset($_SESSION['success']);
    }
    if (isset($_SESSION['error'])) {
        echo "<p class='alert'>" . $_SESSION['error'] . "</p>";
        unset($_SESSION['error']);
    }
    if (isset($_GET['error']) && $_GET['error'] == 'db') {
        echo "<p class='alert'>Error in connecting to database!</p>";
    }
    if (isset($_GET['error']) && $_GET['error'] == 'inurl') {
        echo "<p class='alert'>Not a valid URL!</p>";
    }
    if (isset($_GET['error']) && $_GET['error'] == 'dnp') {
        echo "<p class='alert'>Ok! So I got to know you love playing! But don't play here!!!</p>";
    }
    ?>
    <form method="POST" action="functions/shorten.php">
        <div class="section group">
            <div class="col span_3_of_3">
                <input type="url" id="input" name="url" class="input" placeholder="Enter a URL here">
            </div>
            <div class="col span_1_of_3">
                <input type="text" id="custom" name="custom" class="input_custom" placeholder="Enable custom text"
                       disabled>
            </div>
            <div class="col span_2_of_3">
                <div class="onoffswitch">
                    <input type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch"
                           onclick="toggle()">
                    <label class="onoffswitch-label" for="myonoffswitch"></label>
                </div>
            </div>
        </div>
        <input type="submit" value="Go" class="submit">
    </form>
    <script>
      function toggle () {
        if (document.getElementById('myonoffswitch').checked) {
          document.getElementById('custom').placeholder = 'Enter your custom text'
          document.getElementById('custom').disabled = false
          document.getElementById('custom').focus()
        }
        else {
          document.getElementById('custom').value = ''
          document.getElementById('custom').placeholder = 'Enable custom text'
          document.getElementById('custom').disabled = true
          document.getElementById('custom').blur()
          document.getElementById('input').focus()
        }
      }
    </script>
</body>
</html>
