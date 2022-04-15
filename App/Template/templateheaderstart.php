<?php
?>
<!DOCTYPE html>
<html lang="<?=  $this->session->default_lang ?>">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <script>
        window.addEventListener("load",()=>{
            let spinnerwaper = document.querySelector(".spinnerwaper");
            spinnerwaper.classList.remove("show")
        })
    </script>