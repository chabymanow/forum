<?php
    session_start();
    include "header.php";
    include_once "database.php";

    try{
        if($forum = mysqli_query($conn, "SELECT * FROM mainthreads INNER JOIN users USING (userID)")){
            $myName = mysqli_fetch_array($forum);
        }else{
            $error_msg = mysqli_error($conn);
            echo $error_msg;
            throw new Exception($error_msg);
        }
    }catch(Exception $e){
        echo $e->getMessage();
    }

    ?>
        <div class="flex flex-col w-[90%] mx-auto gap-2">
            <div class="w-full flex flex-row justify-between text-2xl px-4 py-2">
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
                            $answerCount = mysqli_query($conn, "SELECT COUNT(postID) AS NumberOfPost FROM forumposts WHERE mainID = '$id'");
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
  
    <?php include "footer.php"; ?>