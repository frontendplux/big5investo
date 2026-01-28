<?php include __DIR__.'/../compo/head.php'; ?>
<body class="bg-light">

<div class="container vh-100 d-flex justify-content-center align-items-center">
  <div class="col-12 col-sm-8 col-md-6 col-lg-5">
    <div class="card shadow">
      <div class="card-body p-4">

        <h3 class="card-title text-center mb-4"><span class="fw-light fs-5">welcome to </span> <br /> <span class="fw-bold text-uppercase fs-4">Big5 Investo</span></h3>

        <!-- Alert -->
        <div id="alert" class="alert d-none" role="alert"></div>

        <!-- Signup Form -->
        <form id="signupForm">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" placeholder="Enter username" required>
          </div>

          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email" required>
          </div>

          <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" class="form-control" id="phone" placeholder="Enter phone" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Enter password" required>
          </div>

          <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm password" required>
          </div>

          <div class="d-grid mb-3">
            <button type="submit" class="btn btn-success">Signup</button>
          </div>

          <div class="text-center">
            <a href="/<?= $country ?>/login" class="small">Already have an account? Login</a>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.getElementById('signupForm').addEventListener('submit', function(e) {
    e.preventDefault();
   showLoading();
    const alertBox = document.getElementById('alert');
    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const phone = document.getElementById('phone').value.trim();
    const password = document.getElementById('password').value.trim();
    const confirmPassword = document.getElementById('confirmPassword').value.trim();

    // Basic validation
    if(!username || !email || !phone || !password || !confirmPassword) {
        alertBox.className = 'alert alert-danger';
        alertBox.textContent = 'All fields are required.';
        alertBox.classList.remove('d-none');
        hideLoading();
        return;
    }

    // Email format validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if(!emailRegex.test(email)) {
        alertBox.className = 'alert alert-danger';
        alertBox.textContent = 'Invalid email address.';
        alertBox.classList.remove('d-none');
        hideLoading();
        return;
    }

    // Password match validation
    if(password !== confirmPassword) {
        alertBox.className = 'alert alert-danger';
        alertBox.textContent = 'Passwords do not match.';
        alertBox.classList.remove('d-none');
        hideLoading();
        return;
    }

    // Prepare JSON data
    const data = {
        action: 'signup',
        user: email,          // Use email as login identifier
        user_name: username,
        email: email,
        phone: phone,
        pass: password
    };

    // Send fetch request
    fetch('/main/auth/req.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(response => {
        hideLoading();
        if(response.status === 'success') {
            alertBox.className = 'alert alert-success';
            alertBox.textContent = response.message;
            alertBox.classList.remove('d-none');
            setTimeout(() => {
                window.location.href = '/<?= $country ?>/member/';
            }, 1500);
        } else {
            alertBox.className = 'alert alert-danger';
            alertBox.textContent = response.message;
            alertBox.classList.remove('d-none');
        }
    })
    .catch(err => {
        hideLoading();
        alertBox.className = 'alert alert-danger';
        alertBox.textContent = 'Server error. Try again later.';
        alertBox.classList.remove('d-none');
        console.error(err);
    });
});
</script>

</body>
</html>
