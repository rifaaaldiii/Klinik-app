<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Klinik App - Login</title>
  <link rel="stylesheet" href="styles.css" />
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
  <link rel="icon" href="asset/img/logo.jpg" />
</head>

<body>
  <div class="login-container">
    <div class="login-header">
      <img src="asset/img/logo.jpg" alt="Logo KlinikApp" class="logo" />
      <h1>Selamat Datang</h1>
      <p>Mari Jaga Kesehatan Gigi Anda Bersama Kami</p>
    </div>

    <form action="app/index/login.php" method="post">
      <div class="input-group">
        <input type="text" id="username" placeholder=" " name="username" />
        <label>Username / Email</label>
      </div>

      <div class="input-group">
        <div class="input-wrapper">
          <input type="password" id="password" placeholder=" " name="password" />
          <label for="password">Password</label>
          <i class="fas fa-eye" id="togglePassword"></i>
        </div>
      </div>

      <button type="submit" name="login" class="login-button">Masuk</button>
    </form>

    <div class="copyright">&copy; 2024 KlinikApp. All rights reserved.</div>
  </div>

  <script>
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", function(e) {
      const type =
        password.getAttribute("type") === "password" ? "text" : "password";
      password.setAttribute("type", type);

      this.classList.toggle("fa-eye");
      this.classList.toggle("fa-eye-slash");
    });
  </script>
</body>

</html>