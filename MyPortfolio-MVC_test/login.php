<?php
$pdo = require 'model/connect.php';

if (isset($_POST['login'])) {
  $username = $_POST['username'] ?? '';
  // Appliquer MD5 sur le mot de passe saisi
  $password = isset($_POST['password']) ? md5($_POST['password']) : '';

  $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE username = :username AND password = :password");
  $stmt->execute(['username' => $username, 'password' => $password]);
  $user_data = $stmt->fetchAll();

  if (count($user_data) > 0) {
    session_start();
    $_SESSION['isUserLoggedIn'] = true;
    $_SESSION['username'] = $username;
    echo "<script> window.location.href='admin.php'; </script>";
  } else {
    echo "<script> alert('Username ou mot de passe non valide!') </script>";
  }
}
?>


<!doctype html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Login Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="title" content="Login Page" />
    <meta name="author" content="Robin Fligitter" />
    <meta
      name="description"
      content="AdminLTE is a Free Bootstrap 5 Admin Dashboard, 30 example pages using Vanilla JS."
    />
    <meta
      name="keywords"
      content="bootstrap 5, bootstrap, bootstrap 5 admin dashboard, bootstrap 5 dashboard, bootstrap 5 charts, bootstrap 5 calendar, bootstrap 5 datepicker, bootstrap 5 tables, bootstrap 5 datatable, vanilla js datatable, colorlibhq, colorlibhq dashboard, colorlibhq admin dashboard"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css"
      integrity="sha256-tXJfXfp6Ewt1ilPzLDtQnJV4hclT9XuaZUKyUvmyr+Q="
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.10.1/styles/overlayscrollbars.min.css"
      integrity="sha256-tZHrRjVqNSRyWg2wbppGnT833E/Ys0DHWGwT04GiqQg="
      crossorigin="anonymous"
    />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
      integrity="sha256-9kPW/n5nn53j4WMRYAxe9c1rCY96Oogo/MKSVdKzPmI="
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="AdminLTE/dist/css/adminlte.css" />
  </head>
  <body class="login-page bg-body-secondary">
    <div class="login-box">
      <div class="login-logo">
      <b>Portfolio</b>
      </div>
      <div class="card">
        <div class="card-body login-card-body">
          <p class="login-box-msg">Veuillez-vous connectez :</p>
          <form action="login.php" method="post">
          <div class="input-group mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username" />
            <div class="input-group-text"><span class="bi bi-person"></span></div>
          </div>
            <div class="input-group mb-3">
              <input type="password" name="password" class="form-control" placeholder="Password" />
              <div class="input-group-text"><span class="bi bi-lock-fill"></span></div>
            </div>
            <div class="row">
              <div class="col-8">
              </div>
              <div class="col-4">
                <div class="d-grid gap-2">
                  <button type="submit" name="login" class="btn btn-primary">Sign In</button>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
