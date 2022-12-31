<?php
    session_start();    
    include "header.php";  
    include_once "database.php";
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        
    $allowedTags='<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
    $allowedTags.='<li><ol><ul><span><div><br><ins><del><hr>';

    $postTitle = $postText = "";
    $title_err = $desc_err = $userMessage ="";
    $threadID = $_GET["threadID"];
    $getThreadTitle = mysqli_query($conn, "SELECT mainTitle FROM mainthreads WHERE mainID='$threadID'");
    $ThreadTitle = mysqli_fetch_array($getThreadTitle);

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST["submit"])){
           
            if(empty($_POST["post_title"])){
                $title_err = "A title is need for the post!";
            }else{
                $postTitle = $_POST["post_title"];
            }

            if(empty($_POST["post_text"])){
                $desc_err = "Please write someting into the post!";
                $sHeader = '<h1>Nothing submitted yet</h1>';
                $sContent = '<p>Start typing your answer...</p>';
            }else{
                $postText = $_POST["post_text"];
                $sHeader = '<h1>Ah, content is king.</h1>';
                $sContent = strip_tags(stripslashes($_POST['post_text']),$allowedTags);
            }

            If(!empty($postTitle) && !empty($postText)){
                $userMessage = "Ok I am writing the data now...";
                $userID = $_SESSION["id"];
                if($threadData = mysqli_query($conn, "INSERT INTO forumposts (mainID, userID, postTitle, postText, forumCreationDate) VALUES
                ('$threadID', '$userID', '$postTitle', '$sContent', STR_TO_DATE(now(), '%Y-%m-%d %H:%i:%s'))")){
                $threadTitle = $threadDesc = "";
                $userMessage = "The new post is in the system now!";
                }else{
                    $userMessage = "There is some error";
                }
            }
        }
    }
?>     
    <div class="flex flex-col w-[90%] mx-auto mt-10 px-4 py-2">
        <div class="text-center text-3xl font-semibold mb-8">
            Create a new post in the
            <span>
                <?php echo $ThreadTitle["mainTitle"]; ?>
            </span>
            thread
        </div>
        <div class="w-full mx-auto">
            <form class="flex flex-col" action="createPost.php?threadID=<?php echo $threadID; ?>" method="POST">
                <?php if(!empty($userMessage)){ ?>
                    <div class="flex justify-center items-center align-center w-full h-8 mb-3 bg-teal-500 rounded-xl text-lg text-stone-100 text-center"><?php echo $userMessage ?></div>
                <?php } ?>
                <label for="post_title">Post title</label>
                <span class="text-sm text-red-600 my-2"><?php echo $title_err ?></span>
                <input class="h-10 py-3 px-2 mb-3 text-lg rounded-md" type="text" name="post_title" id="post_title" width="40" />
                <span class="text-sm text-red-600 my-2"><?php echo $desc_err ?></span>
                <textarea class="py-3 px-2 text-lg rounded-md" type="text" name="post_text" id="editor" rows="10" cols="45""></textarea>
                <input class="submit text-2xl w-48 mb-10 px-6 py-2 mt-10 rounded-lg m-auto bg-gradient-to-tr from-orange-400 to-orange-700 cursor-pointer shadow-xl
                hover:shadow-md" type="submit" name="submit" value="Create post" />
            </form>
        </div>
    </div>

<?php }?>
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