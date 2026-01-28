<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Big5 Investo - Forgot Password</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container vh-100 d-flex justify-content-center align-items-center">
  <div class="col-12 col-sm-8 col-md-6 col-lg-5">
    <div class="card shadow">
      <div class="card-body p-4">

        <h3 class="card-title text-center mb-4">Forgot Password</h3>

        <!-- Alert -->
        <div id="alert" class="alert d-none" role="alert"></div>

        <!-- Forgot Password Form -->
        <form id="forgotForm">
          <div class="mb-3">
            <label for="loginInput" class="form-label">Email or Phone</label>
            <input type="text" class="form-control" id="loginInput" placeholder="Enter email or phone" required>
          </div>

          <div class="d-grid mb-3">
            <button type="submit" class="btn btn-warning">Send Passcode</button>
          </div>

          <div class="text-center">
            <a href="login.html" class="small">Back to Login</a>
          </div>
        </form>

        <!-- Confirm Passcode Form -->
        <form id="confirmForm" class="d-none">
          <div class="mb-3">
            <label for="passcode" class="form-label">Enter Passcode</label>
            <input type="text" class="form-control" id="passcode" placeholder="Enter 6-digit code" required>
          </div>

          <div class="mb-3">
            <label for="newPassword" class="form-label">New Password</label>
            <input type="password" class="form-control" id="newPassword" placeholder="New password" required>
          </div>

          <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm new password" required>
          </div>

          <div class="d-grid mb-3">
            <button type="submit" class="btn btn-success">Reset Password</button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
const alertBox = document.getElementById('alert');
const forgotForm = document.getElementById('forgotForm');
const confirmForm = document.getElementById('confirmForm');

forgotForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const user = document.getElementById('loginInput').value.trim();

    if (!user) {
        alertBox.className = 'alert alert-danger';
        alertBox.textContent = 'Please enter your email or phone.';
        alertBox.classList.remove('d-none');
        return;
    }

    fetch('/main/auth/req.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({action: 'forgot_password', user: user})
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            alertBox.className = 'alert alert-success';
            alertBox.textContent = data.message;
            alertBox.classList.remove('d-none');

            // Show confirm passcode form
            forgotForm.classList.add('d-none');
            confirmForm.classList.remove('d-none');
        } else {
            alertBox.className = 'alert alert-danger';
            alertBox.textContent = data.message;
            alertBox.classList.remove('d-none');
        }
    })
    .catch(err => {
        alertBox.className = 'alert alert-danger';
        alertBox.textContent = 'Server error. Try again later.';
        alertBox.classList.remove('d-none');
        console.error(err);
    });
});

// Confirm Passcode & Reset Password
confirmForm.addEventListener('submit', function(e) {
    e.preventDefault();
    const passcode = document.getElementById('passcode').value.trim();
    const newPassword = document.getElementById('newPassword').value.trim();
    const confirmPassword = document.getElementById('confirmPassword').value.trim();

    if (!passcode || !newPassword || !confirmPassword) {
        alertBox.className = 'alert alert-danger';
        alertBox.textContent = 'All fields are required.';
        alertBox.classList.remove('d-none');
        return;
    }

    if (newPassword !== confirmPassword) {
        alertBox.className = 'alert alert-danger';
        alertBox.textContent = 'Passwords do not match.';
        alertBox.classList.remove('d-none');
        return;
    }

    fetch('/main/auth/req.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify({
            action: 'confirm_passcode',
            passcode: passcode,
            user: document.getElementById('loginInput').value.trim(),
            pass: newPassword
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            alertBox.className = 'alert alert-success';
            alertBox.textContent = data.message;
            alertBox.classList.remove('d-none');

            setTimeout(() => {
                window.location.href = 'login.html';
            }, 1500);
        } else {
            alertBox.className = 'alert alert-danger';
            alertBox.textContent = data.message;
            alertBox.classList.remove('d-none');
        }
    })
    .catch(err => {
        alertBox.className = 'alert alert-danger';
        alertBox.textContent = 'Server error. Try again later.';
        alertBox.classList.remove('d-none');
        console.error(err);
    });
});
</script>

</body>
</html>
