<?php

if (isset($_GET['success'])) {
  // notify user of succesful signup and to signin for better experience
?>
  <script>
    alert("You have successfully signup. Signin for more seamless experience and interaction");
    window.location.href = "signin.php";
  </script>
<?php
}

if (isset($_GET['error'])) {
  // notify user of succesful signup and to signin for better experience
?>
  <script>
    alert("Error: Unable to signin. Try again later.");
    window.location.href = "signin.php";
  </script>
<?php
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>SignIn</title>
  <!-- Favicon-->
  <link rel="icon" type="image/x-icon" href="../assets/favicon.ico" />
  <!-- Bootstrap icons-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
  <!-- Core theme CSS (includes Bootstrap)-->
  <link href="../css/styles.css" rel="stylesheet" />

</head>

<body class="bg-light">

  <div class="mt-5 pt-5"></div>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <div class="container border shadow bg-white">
          <form action="../config/handler/auth_handler.php" method="post" class="row g-3 needs-validation py-5">

            <div class="col-md-12">
              <label for="validationCustomUsername" class="form-label">Username</label>
              <div class="input-group has-validation">
                <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                <input type="text" class="form-control" id="validationCustomUsername" name="userName" aria-describedby="inputGroupPrepend" required>
              </div>
              <div class="text-danger">
                <?php
                if (isset($_GET["usernameErr"])) {
                  echo "* Invalid Username";
                }
                ?>
              </div>
            </div>

            <div class="col-md-12">
              <label for="validationCustom03" class="form-label">Password</label>
              <input type="password" class="form-control" id="validationCustom03" name="pwd" required>
              <div class="text-danger">
                <?php
                if (isset($_GET["passwordErr"])) {
                  echo "* Invalid Password";
                }
                ?>
              </div>
            </div>

            <div class="col-12">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="invalidCheck" name="remember">
                <label class="form-check-label" for="invalidCheck">
                  Remember Me
                </label>
              </div>
            </div>

            <div class="col-12">
              <button class="btn btn-primary" type="submit" name="signin" style="width: 100px">SignIn</button>
              <span class="ps-5">Don't have an account? <a href="signup.php" class="text-danger">click here to SignUp</a></span>
            </div>

          </form>
        </div>
      </div>
      <div class="col-md-3"></div>
    </div>
  </div>

  <!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Core theme JS-->
  <script src="../js/scripts.js"></script>


</body>

</html>