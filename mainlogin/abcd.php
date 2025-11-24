<?php
include "db/connection.php";
session_start();
if (isset($_POST['submit'])) {
    $name = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = 'user';

    $checkuser = mysqli_query($con, "SELECT * FROM user_tb WHERE username='$name'");
    $checkmail = mysqli_query($con, "SELECT * FROM user_tb WHERE email='$email'");

    if (mysqli_num_rows($checkuser) > 0) {
        echo "<script>alert('Username already exists');</script>";
    } elseif (mysqli_num_rows($checkmail) > 0) {
        echo "<script>alert('Email already exists');</script>";
    } else {
        $query = "INSERT INTO user_tb (username, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
        $insert = mysqli_query($con, $query);

        if ($insert) {
            echo "<script>alert('Registration successful'); window.location.href='abcd.php';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "');</script>";
        }
    }
}

if (isset($_POST['login'])) {
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    $query = "SELECT * FROM user_tb WHERE email='$email' AND password='$password'";
    $insert = mysqli_query($con, $query);

    if (mysqli_num_rows($insert) > 0) {
        $a = mysqli_fetch_assoc($insert);
        $_SESSION['uid'] = $a['uid'];
        $_SESSION['username'] = $a['username'];
        $_SESSION['role'] = $a['role'];

        echo "<script>alert('Successfully logged in as: " . $_SESSION['role'] . "');</script>";

        if ($_SESSION['role'] == 'admin') {
            echo "<script>window.location.href='../admin/index%20.html';</script>";
        } elseif ($_SESSION['role'] == 'user') {
            echo "<script>window.location.href='../sample-ul/sampleui.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid email or password');</script>";
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="abcd.css">
  <title>abcd</title>
  <style>
    /* minimal styles for inline errors so they are visible even if abcd.css doesn't have them */
    .field { position: relative; }
    .validation-error {
      color: #c00;
      font-size: 13px;
      margin-top: 4px;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <div class="title-text">
      <div class="title login">Login Form</div>
      <div class="title signup">Signup Form</div>
    </div>
    <div class="form-container">
      <div class="slide-controls">
        <input type="radio" name="slide" id="login" checked>
        <input type="radio" name="slide" id="signup">
        <label for="login" class="slide login">Login</label>
        <label for="signup" class="slide signup">Signup</label>
        <div class="slider-tab"></div>
      </div>
      <div class="form-inner">
        <!-- LOGIN FORM -->
        <form method="post" class="login" id="loginForm" novalidate>
          <div class="field">
            <input type="text" name="email" placeholder="Email Address" required>
          </div>
          <div class="field">
            <input type="password" name="password" placeholder="Password" required>
          </div>
          <div class="pass-link"><a href="forgot.php">Forgot password?</a></div>
          <div class="field btn">
            <div class="btn-layer"></div>
            <input type="submit" name="login" value="Login">
          </div>

          <!-- Back Button -->
          <div class="field btn">
    <div class="btn-layer"></div>
    <a href="../index.html"
        style="position: relative; z-index: 2; width: 100%; height: 100%; display: flex; align-items:center; justify-content:center; background: none; color: white; font-size: 18px; text-decoration:none; border:none; cursor: pointer;">
        Back
    </a>
</div>

          <div class="signup-link">Not a member? <a href="">Signup now</a></div>
        </form>

        <!-- SIGNUP FORM -->
        <form action="#" method="post" class="signup" id="signupForm" novalidate>
          <div class="field">
            <input type="text" placeholder="username" name="username" required>
          </div>
          <div class="field">
            <input type="text" placeholder="Email Address" name="email" required>
          </div>
          <div class="field">
            <input type="password" placeholder="Password" name="password" required>
          </div>
          <div class="field btn">
            <div class="btn-layer"></div>
            <input type="submit" name="submit" value="Signup">
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- VALIDATION SCRIPT (safe, waits for DOM, inline messages) -->
  <script>
  (function () {
    // run after DOM loaded
    document.addEventListener('DOMContentLoaded', function () {

      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

      function clearErrors(form) {
        const existing = form.querySelectorAll('.validation-error');
        existing.forEach(el => el.remove());
      }

      function showError(field, message) {
        // remove old for this field
        const next = field.parentElement.querySelector('.validation-error');
        if (next) next.remove();

        const err = document.createElement('div');
        err.className = 'validation-error';
        err.textContent = message;
        field.parentElement.appendChild(err);
      }

      function validateLoginForm(e) {
        const form = e.target;
        clearErrors(form);

        const emailField = form.querySelector("input[name='email']");
        const passwordField = form.querySelector("input[name='password']");

        const email = emailField.value.trim();
        const password = passwordField.value.trim();

        let valid = true;

        if (!email) {
          showError(emailField, 'Email is required.');
          valid = false;
        } else if (!emailRegex.test(email)) {
          showError(emailField, 'Please enter a valid email address.');
          valid = false;
        }

        if (!password) {
          showError(passwordField, 'Password is required.');
          valid = false;
        }

        if (!valid) {
          e.preventDefault();
        }
      }

      function validateSignupForm(e) {
        const form = e.target;
        clearErrors(form);

        const usernameField = form.querySelector("input[name='username']");
        const emailField = form.querySelector("input[name='email']");
        const passwordField = form.querySelector("input[name='password']");

        const username = usernameField.value.trim();
        const email = emailField.value.trim();
        const password = passwordField.value.trim();

        let valid = true;

        if (!username) {
          showError(usernameField, 'Username is required.');
          valid = false;
        }

        if (!email) {
          showError(emailField, 'Email is required.');
          valid = false;
        } else if (!emailRegex.test(email)) {
          showError(emailField, 'Please enter a valid email address.');
          valid = false;
        }

        if (!password) {
          showError(passwordField, 'Password is required.');
          valid = false;
        } else if (password.length < 6) {
          showError(passwordField, 'Password must be at least 6 characters.');
          valid = false;
        }

        if (!valid) {
          e.preventDefault();
        }
      }

      // attach handlers
      const loginForm = document.getElementById('loginForm');
      const signupForm = document.getElementById('signupForm');

      if (loginForm) {
        loginForm.addEventListener('submit', validateLoginForm);
        // optional: remove inline error when user types
        loginForm.addEventListener('input', function (ev) {
          const target = ev.target;
          if (target && (target.name === 'email' || target.name === 'password')) {
            const err = target.parentElement.querySelector('.validation-error');
            if (err) err.remove();
          }
        });
      }

      if (signupForm) {
        signupForm.addEventListener('submit', validateSignupForm);
        signupForm.addEventListener('input', function (ev) {
          const target = ev.target;
          if (target && (target.name === 'username' || target.name === 'email' || target.name === 'password')) {
            const err = target.parentElement.querySelector('.validation-error');
            if (err) err.remove();
          }
        });
      }

    }); // DOMContentLoaded end
  })();
  </script>

  <script src="./abcd.js"></script>
</body>
</html>
