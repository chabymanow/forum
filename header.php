<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My forum</title>
    <link href="style.css" rel="stylesheet" />
    <link href="output.css" rel="stylesheet" />
    <!-- <script src="https://cdn.tailwindcss.com"></script>   -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script language="javascript" type="text/javascript" src="./tinymce/js/tinymce/tinymce.min.js"></script>
</head>
<body>
     
    <?php 
        include_once "database.php";
        include "nav.php";
    ?>
    <div class="w-screen h-screen justify-center">
        <div class="w-[80%] max-w-[1024px] h-fit min-h-[70%] flex flex-col bg-slate-200 mx-auto py-12 mt-5 rounded-lg mb-10
        md:h-fit md:min-h-[70%]
        lg:h-fit lg:min-h-[70%]">
