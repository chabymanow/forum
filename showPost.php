<?php
    session_start();
    include "header.php";
    include_once "database.php";
    
    $allowedTags='<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
    $allowedTags.='<li><ol><ul><span><div><br><ins><del>';

    $answerTitle = $answerText = "";
    $title_err = $desc_err = $userMessage ="";
    $postNumber = $_GET["postID"];

    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){

        $getPostTitle = mysqli_query($conn, "SELECT posttitle FROM forumposts");
        $postTitle = mysqli_fetch_array($getPostTitle);
        $sHeader = '<h1>Nothing submitted yet</h1>';
        $sContent = '';
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST["submit"])){           
                if(empty($_POST["post_title"])){
                    $title_err = "A title is need for the post!";
                }else{
                    $answerTitle = $_POST["post_title"];
                }
    
                if(empty($_POST["post_text"])){
                    $desc_err = "Please write someting into the post!";
                    $sHeader = '<h1>Nothing submitted yet</h1>';
                    $sContent = '';
                }else{
                    $answerText = $_POST["post_text"];
                    $sHeader = '<h1>Ah, content is king.</h1>';
                    $sContent = strip_tags(stripslashes($_POST['post_text']),$allowedTags);
                }
    
                If(!empty($postTitle) && !empty($sContent)){
                    echo"Ok I am writing the data now...";
                    $userID = $_SESSION["id"];
                    if($threadData = mysqli_query($conn, "INSERT INTO answers (postID, userID, answerTitle, answerText, answerCreationDate) VALUES
                    ('$postNumber', '$userID', '$answerTitle', '$sContent', STR_TO_DATE(now(), '%Y-%m-%d %H:%i:%s'))")){
                    $answerTitle = $answerText = $sContent = "";
                    $userMessage = "The new aswer is in the system now!";
                    echo "Wrote to database";
                    header("Refresh:0");
                    }else{
                        $userMessage = "There is some error";
                    }
                }
            }
        }
    }
    $post = mysqli_query($conn, "SELECT * FROM forumposts INNER JOIN users USING (userID) WHERE postID='$postNumber'");
    $answers = mysqli_query($conn, "SELECT * FROM answers INNER JOIN users USING (userID) WHERE postID='$postNumber'")
    ?>

            <div class="flex flex-col w-[90%] h-fit mx-auto gap-5 px-4 py-2">
                <?php
                    while($row = mysqli_fetch_array($post)){ ?>
                        <div class="pb-1">
                            <div class="text-3xl font-semibold pb-4"><?php echo $row["postTitle"]; ?></div>
                            <div class="flex flex-row justify-between text-xl">
                                <div>Question from: <span class="font-semibold"><?php echo $row["userName"]; ?></span></div>
                                <div><?php echo "Created: " . $row["forumCreationDate"]; ?></div>
                            </div>
                        </div>
                        <div class="text-lg leading-10 pt-2">
                        <!-- <?php strip_tags($row["postText"], $allowedTags) ?> -->
                             <?php echo $row["postText"]; ?>
                        </div>
                <?php } ?>
            </div>
            <div class="w-[90%] h-fit text-center mx-auto my-4 px-4 py-2 rounded-lg text-3xl font-medium border-y-2 border-slate-400">Answers</div>
                <?php    
                    while($row = mysqli_fetch_array($answers)){ ?>
                        <div class="flex flex-col w-[90%] h-fit mx-auto gap-2 px-4 py-2 mt-2 border-b-2 border-slate-300">
                            <div>
                                <div class="text-3xl font-semibold pb-4"><?php echo $row["answerTitle"] ?></div>
                                <div class="flex flex-row justify-between text-xl">
                                    <div>Answer from: <span class="font-semibold"><?php echo $row["userName"]; ?></span></div>
                                    <div><?php echo "Created: " . $row["answerCreationDate"]; ?></div>
                                </div>
                            </div>
                            <div>
                                <div class="text-lg leading-10"><?php echo $row["answerText"] ?></div>
                            </div>
                        </div>
                    <?php }
                ?>
            
            <?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){ ?>
            <div class="w-[90%] mx-auto rounded-lg p-5 mt-5 bg-slate-200 text-lg text-stone-800">
                <div class="w-full text-center text-2xl font-semibold">Write your answer</div>
                <form class="flex flex-col" action="showPost.php?postID=<?php echo $postNumber; ?>" method="POST">
                    <?php if(!empty($userMessage)){ ?>
                        <div class="flex justify-center items-center align-center w-full h-8 mb-3 bg-teal-500 rounded-xl text-lg text-stone-100 text-center"><?php echo $userMessage ?></div>
                    <?php } ?>
                    <span class="text-sm text-red-600 my-2"><?php echo $title_err ?></span>
                    <input class="h-10 py-3 px-2 text-lg rounded-md" type="text" name="post_title" id="post_title" placeholder="Answer title..." width="40" />
                    <span class="text-sm text-red-600 my-2"><?php echo $desc_err ?></span>
                    <textarea class="py-3 px-2 text-lg rounded-md" type="text" name="post_text" id="editor" rows="10" cols="45""><?php echo $sContent;?></textarea>
                    <input class="submit text-2xl w-fit mt-10 px-6 py-2 rounded-lg m-auto bg-gradient-to-tr from-orange-400 to-orange-700 cursor-pointer shadow-xl
                    hover:shadow-md" type="submit" name="submit" placeholder="Your answer..." value="Send the answer" />
                </form>
            </div>
            <?php }else{ ?>
                <div class="w-full text-2xl text-center mt-10">You need to <a class="text-3xl text-sky-600" href="login.php">login</a> to write an answer</div>
            <?php } ?>
        </div>

<script language="javascript" type="text/javascript">
    tinyMCE.init({
        theme: "silver",
        mode: "exact",
        selector: '#editor',
        elements: "post_text",
        theme_silver_toolbar_location: "top",
        theme_silver_buttons1: "bold,italic,underline,strikethrough,separator,"
        + "justifyleft,justifycenter,justifyright,justifyfull,formatselect,"
        + "bullist,numlist,outdent,indent",
        theme_silver_buttons2: "link,unlink,anchor,image,separator,"
        +"undo,redo,cleanup,code,separator,sub,sup,charmap",
        theme_silver_buttons3: "",
    });
</script>
<?php include "footer.php"; ?>