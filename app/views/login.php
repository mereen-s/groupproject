<div style="max-width:340px;margin:30px auto;text-align:center">
  <h2>Log in</h2>
  <form method="post" action="<?= BASE_URL ?>/index.php?page=do_login">
    <label style="text-align:left">Username</label><input name="username" required>
    <label style="text-align:left">Password</label><input name="password" type="password" required>
    <button>Log in</button>
  </form>
  <p class="note">Role-based access: you are routed to your role's dashboard after login.</p>
</div>
