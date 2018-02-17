<div class="signForm">
	<div class='errorBox'><?= $T['signupError'] ? $T['signupError'] : '' ?></div>
	<h1 class="reg">Sign up</h1>
	<?= FormHelper::getForm() ?>
	<a href="/dashboard.php?page=login" title="Sign in with an existing account">Already have an account? Log in</a>
</div>