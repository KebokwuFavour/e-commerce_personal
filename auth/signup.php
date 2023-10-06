<?php

if (isset($_GET['error'])) {
  // notify user of succesful signup and to signin for better experience
?>
  <script>
    alert("An error occurred! Try again later. Thank you");
    window.location.href = "signup.php";
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
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
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

            <div class="col-md-6">
              <label for="validationCustomName" class="form-label">Name</label>
              <div class="input-group has-validation">
                <input type="text" class="form-control" id="validationCustomName" name="name" aria-describedby="inputGroupPrepend">
              </div>
              <div class="text-danger">
                <?php
                if (isset($_GET["nameErr"])) {
                  echo "* Invalid name input";
                }
                ?>
              </div>
            </div>

            <div class="col-md-6">
              <label for="validationCustomEmail" class="form-label">Email</label>
              <div class="input-group has-validation">
                <input type="email" class="form-control" id="validationCustomEmail" name="email" aria-describedby="inputGroupPrepend">
              </div>
              <div class="text-danger">
                <?php
                if (isset($_GET["emailErr"])) {
                  echo "* Invalid Email input";
                } else {
                  if (isset($_GET["Eexistaii"])) {
                    echo "* Email is already registered";
                    echo "<script> alert('Email is already registered/exists. Login to continue'); </script>";
                  }
                }
                ?>
              </div>
            </div>

            <div class="col-md-6">
              <label for="validationCustomUsername" class="form-label">Username</label>
              <div class="input-group has-validation">
                <!-- <span class="input-group-text" id="inputGroupPrepend">@</span> -->
                <input type="text" class="form-control" id="validationCustomUsername" name="username" aria-describedby="inputGroupPrepend" required>
              </div>
              <div class="text-danger">
                <?php
                if (isset($_GET["usernameErr"])) {
                  echo "* Username is invalid";
                } else {
                  if (isset($_GET["Unexistaii"])) {
                    echo "* Username taken/not availabe";
                  }
                }
                ?>
              </div>
            </div>

            <div class="col-md-6">
              <label for="validationCustom03" class="form-label">Password</label>
              <input type="password" class="form-control" id="validationCustom03" name="password" required>
              <div class="text-danger">
                <?php
                if (isset($_GET["passwordErr"])) {
                  echo "* Password is required";
                }
                ?>
              </div>
            </div>

            <div class="col-12">
              <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Agree to terms and conditions" id="invalidCheck" name="TandC" required>
                <label class="form-check-label" for="invalidCheck">
                  Agree to terms and conditions
                </label>
                <div class="text-danger">
                  <?php
                  if (isset($_GET["TandCErr"])) {
                    echo "* Field is required";
                  }
                  ?>
                </div>
              </div>
            </div>

            <div class="col-12">
              <button class="btn btn-outline-primary" type="submit" name="signup" style="width: 100px">SignUp</button>
              <span class="ps-5">Already have an account? <a href="signin.php" class="text-primary">click here to SignIn</a></span>
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
  <script src="js/scripts.js"></script>
</body>

</html>