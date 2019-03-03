<div class="form-wrapper">
  <div class="form-container">
  <div class="logo">Login</div>
  <?php
  if ($session->get('login_error')) { ?>
  <p style="color:red;"> <?= $session->get('login_error') ?></p>
  <?php } ?>
  <div class="login-item">
    <form action="/login-user" method="post" class="form form-login">
      <div class="form-field">
        <label class="user" for="login-username"><span class="hidden">Username</span></label>
        <input id="login-username" name="username" type="text" class="form-input" placeholder="Username" required>
      </div>

      <div class="form-field">
        <label class="lock" for="login-password"><span class="hidden">Password</span></label>
        <input id="login-password" name="password" type="password" class="form-input" placeholder="Password" required>
      </div>

      <div class="form-field">
        <input type="submit" value="Log in">
      </div>
    </form>
  </div>
</div>
</div>
