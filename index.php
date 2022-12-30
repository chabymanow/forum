<?php
    include_once "database.php";
    include "header.php";

    $forum = mysqli_query($conn, "SELECT * FROM mainThreads
        INNER JOIN users USING (userID)");

    ?>
    <div class="w-[80%] max-w-[1024px] h-fit py-10 flex flex-col bg-slate-200 mx-auto">
        <div class="flex flex-col w-[90%] h-fit min-h-screen mx-auto gap-2">
        <div class="w-full flex flex-row justify-between text-2xl px-4 py-2 rounded-lg bg-slate-200 text-stone-800">
        <div class="w-full flex justify-between text-3xl font-semibold px-4 py-2 rounded-lg bg-slate-300 text-stone-800">
                <?php echo "Main threads" ?>
            
                 <?php
                if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
                    ?>                       
                        <a href="createThread.php">
                        <div class="w-fit px-4 py-1 rounded-lg text-xl font-medium text-stone-800 bg-gradient-to-tr from-orange-400 to-orange-700 cursor-pointer shadow-md
                    hover:shadow-sm">
                    Create new thread
                        </div>
                        </a>                      
                    <?php } ?>
                </div>
        </div>
            <?php
                while($row = mysqli_fetch_array($forum)){ ?>
                <div class="flex flex-row justify-between px-4 py-2 border-b-2 border-slate-300">
                    <div class="min-w-[60%]">
                        <div class="text-3xl font-semibold pb-4">
                            <a href="showPosts.php?postID=<?php echo $row["mainID"]; ?>">
                                <?php echo $row["mainTitle"]; ?>
                            </a>
                        </div>
                        <div class="text-xl"><?php echo $row["mainDesc"]; ?></div>
                    </div>
                    <div class="flex flex-col gap-1">
                        <div>Creator: </div>
                        <div class="text-2xl font-medium"><?php echo $row["userName"]; ?></div>
                    </div>
                    <div class="flex flex-col gap-1">
                        <div>Posts: </div>
                        <?php
                            $id = $row["mainID"];
                            $answerCount = mysqli_query($conn, "SELECT COUNT(postID) AS NumberOfPost FROM forumPosts WHERE mainID = '$id'");
                            $answerC = mysqli_fetch_array($answerCount);
                        ?>
                        <div class="text-3xl text-center"><?php echo $answerC["NumberOfPost"] ?></div>
                    </div>
                    <div>
                        <?php
                            $phpdate = strtotime( $row["mainCreationDate"] );
                            $mysqldate = date( 'Y-m-d', $phpdate );  
                            $mysqltime= date( 'H:i:s', $phpdate );
                                
                        ?>
                        <div><?php echo "Created: " . $mysqldate ?></div>
                        <div class="text-end"><?php echo $mysqltime ?></div>
                    </div>
                </div>
            <?php } ?>         
        </div>
    </div>
    <?php include "footer.php"; ?>