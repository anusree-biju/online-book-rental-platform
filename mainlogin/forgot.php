<?php
include '../sentmail/sentmail/mail.php';
include 'db/connection.php';
if(isset($_POST["sent"]))
{
    $email=$_POST['email'];
    $sql=mysqli_query($con,"select * from user_tb where email='$email'");
    if(mysqli_num_rows($sql) > 0){
        $user= mysqli_fetch_assoc($sql);
        $password= $user['password'];
        $message = "Your password is: $password";
        sendEmail($email, $message);
    }
    else{
        echo "<script>alert('Email not found');</script>";}

}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Forgot Password</title>
  <style>
    :root{
      --bg:#f6f8fb;
      --card:#ffffff;
      --accent:#4f46e5;
      --muted:#6b7280;
      --success:#10b981;
      --shadow: 0 10px 30px rgba(15,23,42,0.06);
      --radius:14px;
      font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
    }
    *{box-sizing:border-box}
    html,body{height:100%}
    body{
      margin:0;
      background:linear-gradient(180deg, var(--bg), #eef2ff 120%);
      display:flex;
      align-items:center;
      justify-content:center;
      padding:24px;
      color:#0f172a;
    }

    .card{
      width:100%;
      max-width:420px;
      background:var(--card);
      border-radius:var(--radius);
      box-shadow:var(--shadow);
      padding:28px;
      text-align:left;
    }

    .brand{
      display:flex;
      gap:12px;
      align-items:center;
      margin-bottom:8px;
    }
    .logo{
      width:48px;height:48px;border-radius:10px;
      display:grid;place-items:center;color:white;font-weight:700;
      background:linear-gradient(135deg,#7c3aed,#4f46e5);
      box-shadow: 0 6px 18px rgba(79,70,229,0.18);
    }
    h1{font-size:20px;margin:6px 0 0}
    p.lead{margin:8px 0 18px;color:var(--muted);font-size:14px}

    form{display:flex;flex-direction:column;gap:12px}
    label{font-size:13px;color:var(--muted)}
    .input-group{display:flex;flex-direction:column;gap:6px}

    input[type="email"]{
      width:100%;
      padding:12px 14px;
      border-radius:10px;
      border:1px solid #e6e9ef;
      outline:none;
      font-size:15px;
      transition:box-shadow .12s, border-color .12s;
      background:linear-gradient(180deg,#ffffff,#fbfdff);
    }
    input[type="email"]:focus{box-shadow:0 6px 18px rgba(79,70,229,0.06);border-color:rgba(79,70,229,0.35)}

    .actions{display:flex;gap:10px;align-items:center;justify-content:space-between;margin-top:4px}

    button{
      appearance:none;
      border:0;
      padding:11px 16px;
      border-radius:10px;
      font-weight:600;
      cursor:pointer;
      background:linear-gradient(90deg,var(--accent),#7c3aed);
      color:white;
      box-shadow:0 8px 24px rgba(79,70,229,0.18);
    }
    button[disabled]{opacity:.6;cursor:not-allowed;box-shadow:none}

    .secondary{background:transparent;border:1px solid #eef2ff;color:var(--accent);font-weight:600;padding:10px;border-radius:10px}

    .note{font-size:13px;color:var(--muted);margin-top:8px}

    .toast{
      margin-top:12px;padding:12px 14px;border-radius:10px;border:1px solid rgba(16,185,129,0.12);
      background:rgba(16,185,129,0.06);color:var(--success);display:none
    }

    .hint{font-size:12px;color:#9ca3af}

    /* small screens */
    @media (max-width:420px){
      .card{padding:20px}
      h1{font-size:18px}
    }
  </style>
</head>
<body>
  <main class="card" aria-labelledby="forgot-title">
    <div class="brand">
      <div class="logo" aria-hidden>FP</div>
      <div>
        <div style="font-size:13px;color:var(--muted)">Account help</div>
        <h1 id="forgot-title">Forgot your password?</h1>
      </div>
    </div>

    <p class="lead">Enter the email associated with your account and we'll send instructions to reset your password. This page is a frontend demo only — no mail will actually be sent.</p>

    <form id="forgotForm" method="post" novalidate>
      <div class="input-group">
        <label for="email">Email address</label>
        <input id="email" name="email" type="email" inputmode="email" placeholder="you@example.com" required aria-required="true" autocomplete="email">
        <div id="emailError" class="hint" style="display:none;color:#ef4444"></div>
      </div>

      <div class="actions">
        <button id="submitBtn" type="submit" name="sent">Send reset link</button>
        <a href="abcd.php" class="secondary">
              <button type="button">Back to sign in</button>
        </a>

      </div>

      <div id="toast" class="toast" role="status" aria-live="polite"></div>

      <p class="note">If we have an account with that email, you will receive an email with further instructions. Check your spam folder if you don't see it.</p>
    </form>
  </main>


</body>
</html>