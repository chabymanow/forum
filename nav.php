<nav class="w-sreen h-16 bg-sky-800 shadow-md">
    <ul class="flex flex-row w-full h-full gap-5 text-2xl text-slate-200 font-bold justify-center items-center align-middle">
        <li>
            <a href="index.php">Home</a>
        </li>
        <?php
            if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
         ?>
            <li>
                <a href="logout.php">Logout</a>
            </li>
         <?php }else{ ?>
        <li>
            <a href="login.php">Login</a>
        </li>
        <li>
            <a href="register.php">Register</a>
        </li>
        <?php } ?>
        <li>
        <?php
        if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    ?>
        <span class="justify-self-end text-md font-medium text-teal-300">Welcomme <?php echo $_SESSION["username"]?></span>
    <?php }else{ ?>
        <span class="justify-self-end text-md font-medium text-teal-300">Welcomme guest</span>
    <?php } ?>
        </li>
    </ul>
</nav>