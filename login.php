<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="pass.css">
    <title>Login</title>
    <link rel="icon" href="assets/icon.png"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>

    <body>
    <div class="video-background">
    </div>
        <div class="wrapper">
           <h2>Login</h2>
                    <?php
                        if (isset($_GET['pesan'])) {
                            if ($_GET['pesan'] == "gagal") {
                                echo "<div class='alert alert-danger'>Username dan Password tidak sesuai !</div>";
                            }
                        }
                    ?>
                 <form method="post" action="cek_login.php">
                    <div class="input-box">
                        <label>Username</label>
                        <input type="text" placehodlder="Username" name="username" required>
                    </div>
                    <br>
                    <div class="input-box">
                        <label>Password</label>
                        <input type="password" placehodlder="Password" name="password" required>
                    </div>
                    <br><br>
                    <button type="submit" class="btna">Login</button>
                </form>
                </div>
             </div>
        <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var icon = document.querySelector('.password-toggle-icon');

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                icon.classList.remove("fa-eye-slash");
                icon.classList.add("fa-eye");
            } else {
                passwordInput.type = "password";
                icon.classList.remove("fa-eye");
                icon.classList.add("fa-eye-slash");
            }
        }
    </script>
</body>
</html>


                        