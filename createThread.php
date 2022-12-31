<?php
session_start();
    include "header.php";
    include_once "database.php";
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){

    $threadTitle = $threadDesc = "";
    $title_err = $desc_err = $userMessage ="";

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST["submit"])){
            if(empty($_POST["thread_title"])){
                $title_err = "A title is need for the thread!";
            }else{
                $threadTitle = $_POST["thread_title"];
            }

            if(empty($_POST["thread_desc"])){
                $desc_err = "Please give a short description!";
            }else{
                $threadDesc = $_POST["thread_desc"];
            }

            If(!empty($threadTitle) && !empty($threadDesc)){
                $userMessage = "Ok I am writing the data now...";
                $userID = $_SESSION["id"];
                $threadData = mysqli_query($conn, "INSERT INTO mainthreads (userID, mainTitle, mainDesc, mainCreationDate) VALUES
                ('$userID', '$threadTitle', '$threadDesc', STR_TO_DATE(now(), '%Y-%m-%d %H:%i:%s'))");
                $threadTitle = $threadDesc = "";
                $userMessage = "The new thread is in the systemnow!";
            }
        }
    }
?>
     
        <div class="flex flex-col w-[70%] mx-auto mt-10 px-4 py-2">
        <div class="text-center text-3xl font-semibold mb-8">Create new thread</div>
        <div class="w-[70%] mx-auto">
            <form class="flex flex-col" action="createThread.php" method="POST">
                <?php if(!empty($userMessage)){ ?>
                    <div class="flex justify-center items-center align-center w-full h-8 mb-3 bg-teal-500 rounded-xl text-lg text-stone-100 text-center"><?php echo $userMessage ?></div>
                <?php } ?>
                <label for="thread_title">Thread title</label>
                <span class="text-sm text-red-600 my-2"><?php echo $title_err ?></span>
                <input class="h-10 py-3 px-2 mb-10 text-lg rounded-md" type="text" name="thread_title" id="thread_title" width="40" />
                <label for="thread_desc">Thread description</label>
                <span class="text-sm text-red-600 my-2"><?php echo $desc_err ?></span>
                <input class="h-10 py-3 px-2 mb-10 text-lg rounded-md" type="text" name="thread_desc" id="thread_desc" width="40" />
                <input class="submit text-2xl w-48 mb-10 px-6 py-2 rounded-lg m-auto bg-gradient-to-tr from-orange-400 to-orange-700 cursor-pointer shadow-xl
                hover:shadow-md" type="submit" name="submit" value="Create thread" />
            </form>
        </div>
    </div>

<?php }?>
<?php include "footer.php"; ?>