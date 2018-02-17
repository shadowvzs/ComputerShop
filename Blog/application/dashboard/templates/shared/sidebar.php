<aside>
    <div class="container">
        <div class="profile">
            <img src="/public/img/user/<?= User::getUserId() ?>.jpg" alt="Profile" onclick="document.getElementById('pimage').click();" onerror="this.onerror=null;this.src='/public/img/user/0.jpg';"/>
            <a href="#"><?= User::getLogged()->name ?></a>
        </div>
        <a href="dashboard.php?page=edit&id=new" class="newPost">Create new</a>

        <div class="menu">
            <a href="dashboard.php"> Dashboard</a>
            <a href="#">Widgets</a>
            <a href="#">Charts</a>
            <a href="#" class="selected">Tables</a>
            <a href="#" onclick="alert('Want a Alert? :D');">Alerts</a>
        </div>
        <div class="log-in-out">
            <?php if (User::isLogged()) { echo "<a href='/dashboard.php?page=logout'>Logout</a>"; } else { echo "<a href='dashboard.php?page=login'>Login</a>"; }  ?>
        </div>  
    </div>
</aside>
