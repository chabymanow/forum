<?php
session_start();
    include "header.php";
    include_once "database.php";
    $postNumber = $_GET["postID"];
    $posts = mysqli_query($conn, "SELECT * FROM forumposts INNER JOIN users USING (userID) WHERE mainID='$postNumber'");
    $threadID = $_GET["postID"];
    $getThreadTitle = mysqli_query($conn, "SELECT mainTitle FROM mainthreads WHERE mainID = '$threadID'");
    $ThreadTitle = mysqli_fetch_array($getThreadTitle);
    ?>  
        <div class="w-[90%] h-fit flex flex-col px-4 py-2 mb-5 gap-2 rounded-lg mx-auto"> 
   
            <div class="w-full flex flex-row justify-between text-2xl px-4 py-2 rounded-lg bg-slate-300 text-stone-800">
                <div>
                    Posts in the <span class="text-3xl font-semibold text-sky-700"><?php echo$ThreadTitle["mainTitle"]; ?></span> thread
                </div>
                 <?php
                if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                    ?>                       
                        <a href="createPost.php?threadID=<?php echo $postNumber; ?>">
                        <div class="w-fit px-4 py-1 rounded-lg text-xl font-medium text-stone-800 bg-gradient-to-tr from-orange-400 to-orange-700 cursor-pointer shadow-xl
                    hover:shadow-md">
                            New post
                        </div>
                        </a>                      
                    <?php } ?>
                </div>

            <?php
                while($row = mysqli_fetch_array($posts)){ ?>
                <div class="flex flex-col px-4 py-2 mb-2 text-center rounded-lg border-b-2 border-slate-300
                md:flex-row md:justify-between md:text-left
                lg:flex-row lg:justify-between lg:text-left">
                        <div class="min-w-[60%]">
                            <a class="text-3xl font-semibold pb-4" href="showPost.php?postID=<?php echo $row["postID"]; ?>"><?php echo $row["postTitle"]; ?></a>
                            <div><?php echo "Creator: " . $row["userName"]; ?></div>
                        </div>
                        <div class="flex flex-row min-w-[40%] justify-between">
                            <div class="flex flex-col min-w-[20%] text-xl">                                                 
                                <?php
                                    $id = $row["postID"];
                                    $answerCount = mysqli_query($conn, "SELECT COUNT(answerID) AS NumberOfAnswers FROM answers WHERE postID = '$id'");
                                    $answerC = mysqli_fetch_array($answerCount);
                                ?>                       
                                <div class="text-3xl text-center">Answers:</div>
                                <div class="text-3xl text-center"><?php echo $answerC["NumberOfAnswers"] ?></div>
                            </div>
                            <div class="min-w-[20%]">
                                <?php
                                    $phpdate = strtotime( $row["forumCreationDate"] );
                                    $mysqldate = date( 'Y-m-d', $phpdate );  
                                    $mysqltime= date( 'H:i:s', $phpdate );
                                        
                                ?>
                                <div class="text-end"><?php echo "Created: " . $mysqldate; ?></div>
                                <div class="text-end"><?php echo $mysqltime ?></div>
                            </div> 
                        </div>
                </div>
            <?php } ?>
        </div>
<?php
include "footer.php";
?>