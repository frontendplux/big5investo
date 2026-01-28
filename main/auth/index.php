<?php include __DIR__.'/../compo/head.php'; ?>
<body class="bg-light">
<div class="container h-100 d-flex justify-content-center align-items-center">
  <div class="col-12 col-sm-8 col-md-6 col-lg-4">
    <div class="text-center"><img src="/image/logo.png" style="width:150px" alt=""></div>
    <div class="card shadow">
      <div class="card-body p-4">
        <h3 class="card-title text-center mb-4">Login to Big5 Investo</h3>

        <!-- Alert -->
        <div id="alert" class="alert d-none" role="alert"></div>

        <!-- Login Form -->
        <form id="loginForm">
          <div class="mb-3">
            <label for="loginInput" class="form-label">Email or Phone</label>
            <input type="text" class="form-control" id="loginInput" placeholder="Enter email or phone" required>
          </div>

          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" placeholder="Enter password" required>
          </div>

          <div class="d-grid mb-3">
            <button type="submit" class="btn btn-primary">Login</button>
          </div>

          <div class="text-center">
            <a href="/<?= $country ?>/forgot-password" class="small">Forgot password?</a> |
            <a href="/<?= $country ?>/signup" class="small">Create account</a>
          </div>
        </form>
      </div>

    </div>
    <div class="text-center my-3"><span>&copy;copywrite @ <a href="/">Big5 Investo</a></span></div>
  </div>
</div>

<!-- Bootstrap JS -->
<script>
document.getElementById('loginForm').addEventListener('submit', function(e){
    e.preventDefault();
   showLoading();
    const user = document.getElementById('loginInput').value.trim();
    const pass = document.getElementById('password').value.trim();
    const alertBox = document.getElementById('alert');

    // Basic validation
    if(!user || !pass){
        alertBox.className = 'alert alert-danger';
        alertBox.textContent = 'Please enter both email/phone and password.';
        alertBox.classList.remove('d-none');
        hideLoading();
        return;
    }

    // Prepare JSON payload
    const data = {
        action: 'login',
        user: user,
        pass: pass
    };

    // Send JSON POST request
    fetch('/main/auth/req.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(response => {
        if(response.status === 'success'){
            alertBox.className = 'alert alert-success';
            alertBox.textContent = 'Login successful! Redirecting...';
            alertBox.classList.remove('d-none');
            setTimeout(() => {
                window.location.href = '/<?= $country ?>/member/'; // Change to your dashboard page
            }, 1500);
        } else {
            alertBox.className = 'alert alert-danger';
            alertBox.textContent = response.message || 'Invalid login credentials.';
            alertBox.classList.remove('d-none');
        }
    })
    .catch(err => {
        alertBox.className = 'alert alert-danger';
        alertBox.textContent = 'Server error. Please try again.';
        alertBox.classList.remove('d-none');
        console.error(err);
    });
    hideLoading();  
});
</script>

</body>
</html>
