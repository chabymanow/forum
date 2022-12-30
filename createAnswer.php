<?php
    include_once "database.php";
    include "header.php";

    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    $allowedTags='<p><strong><em><u><h1><h2><h3><h4><h5><h6><img>';
    $allowedTags.='<li><ol><ul><span><div><br><ins><del>';

    $postTitle = $postText = "";
    $title_err = $desc_err = $userMessage ="";
    $postID = $_GET["postID"];
    $getPostTitle = mysqli_query($conn, "SELECT postTitle FROM forumposts");
    $postTitle = mysqli_fetch_array($getPostTitle);
    $sHeader = '<h1>Nothing submitted yet</h1>';
    $sContent = '<p>Start typing...</p>';
    $sContent.= '<p><img width="107" height="108" border="0" src="/mediawiki/images/badge.png"';
    $sContent.= 'alt="TinyMCE button"/>This rover has crossed over</p>';

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST["submit"])){           
            if(empty($_POST["post_title"])){
                $title_err = "A title is need for the post!";
                $sHeader = '<h1>Nothing submitted yet</h1>';
                $sContent = '<p>Start typing...</p>';
                $sContent.= '<p><img width="107" height="108" border="0" src="/mediawiki/images/badge.png"';
                $sContent.= 'alt="TinyMCE button"/>This rover has crossed over</p>';
            }else{
                $postTitle = $_POST["post_title"];
                $sHeader = '<h1>Ah, content is king.</h1>';
                $sContent = strip_tags(stripslashes($_POST['post_text']),$allowedTags);
            }

            if(empty($_POST["post_text"])){
                $desc_err = "Please write someting into the post!";
            }else{
                $postText = $_POST["post_text"];
            }

            If(!empty($postTitle) && !empty($postText)){
                $userMessage = "Ok I am writing the data now...";
                $userID = $_SESSION["id"];
                if($threadData = mysqli_query($conn, "INSERT INTO forumPosts (mainID, userID, postTitle, postText, forumCreationDate) VALUES
                ('$threadID', '$userID', '$postTitle', '$postText', STR_TO_DATE(now(), '%Y-%m-%d %H:%i:%s'))")){
                $threadTitle = $threadDesc = "";
                $userMessage = "The new post is in the system now!";
                }else{
                    $userMessage = "There is some error";
                }
            }
        }
    }
?>
<div class="w-[80%] max-w-[1024px] h-screen flex flex-col bg-sky-500 mx-auto">     
        <div class="flex flex-col w-[70%] mx-auto mt-10 px-4 py-2 rounded-lg bg-slate-200 text-lg text-stone-800">
        <div class="text-center text-3xl font-semibold mb-8">Create a new post</div>
        <div class="text-center text-3xl font-semibold mb-8"><?php echo $postTitle["postTitle"]; ?></div>
        <div class="w-[70%] mx-auto">
            <form class="flex flex-col" action="createPost.php?threadID=<?php echo $threadID; ?>" method="POST">
                <?php if(!empty($userMessage)){ ?>
                    <div class="flex justify-center items-center align-center w-full h-8 mb-3 bg-teal-500 rounded-xl text-lg text-stone-100 text-center"><?php echo $userMessage ?></div>
                <?php } ?>
                <label for="post_title">Thread title</label>
                <span class="text-sm text-red-600 my-2"><?php echo $title_err ?></span>
                <input class="h-10 py-3 px-2 mb-10 text-lg rounded-md" type="text" name="post_title" id="post_title" width="40" />
                <label for="post_text">Thread description</label>
                <span class="text-sm text-red-600 my-2"><?php echo $desc_err ?></span>
                <textarea class="py-3 px-2 mb-10 text-lg rounded-md" type="text" name="post_text" id="post_text" rows="10" cols="45""><?php echo $sContent;?></textarea>
                <input class="submit text-2xl w-48 mb-10 px-6 py-2 rounded-lg m-auto bg-gradient-to-tr from-orange-400 to-orange-700 cursor-pointer shadow-xl
                hover:shadow-md" type="submit" name="submit" value="Create post" />
            </form>
        </div>
    </div>
</div>
<?php }?>
<script language="javascript" type="text/javascript">
    tinyMCE.init({
        theme: "silver",
        mode: "exact",
        selector: '#post_text',
        elements: "post_text",
        theme_silver_toolbar_location: "top",
        theme_silver_buttons1: "bold,italic,underline,strikethrough,separator,"
        + "justifyleft,justifycenter,justifyright,justifyfull,formatselect,"
        + "bullist,numlist,outdent,indent",
        theme_silver_buttons2: "link,unlink,anchor,image,separator,"
        +"undo,redo,cleanup,code,separator,sub,sup,charmap",
        theme_silver_buttons3: "",
        // height:"350px",
        // width:"600px"
    });
    </script>
<?php include "footer.php"; ?>