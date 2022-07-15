<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?= ROOT."public/assets/css/styles.css" ?>">
    <script>
        function showSuggestions(str){
            console.log(44)
            if (str.length === 0){
                document.getElementById('output').innerHTML = '';
            }else{
                var xmlHttp = new XMLHttpRequest();
                xmlHttp.onreadystatechange = function (){
                    if (this.readyState === 4 && this.status === 200 ){
                        var resp = "";
                        console.log(this.responseText);
                        document.getElementById('output').innerHTML = this.responseText;
                    }
                }
                xmlHttp.open('POST',str , true);
                xmlHttp.send();
            }
        }
    </script>
    <title><?= $data['title'] ?></title>
</head>
<body>
<?php require_once APPROOT.'/views/inc/navbar.php'; ?>
<?php if (isLoggedIn() && !$_SESSION['enabled']) : ?>
    <div class="alert alert-warning fw-light text-center" role="alert">
        Please click <a class="link-success" href="<?= ROOT."users/send_mail" ?>">here</a> to confirm your email
    </div>
<?php endif; ?>
<div class="container">

