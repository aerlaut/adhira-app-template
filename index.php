<?php require_once 'init.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="css/tailwind.min.css">
  <link rel="stylesheet" href="css/style.css">
</head>

<body class="h-screen flex flex-col justify-center">

  <div class="login rounded background-white text-center w-6/12 sm:w-3/12 mx-auto">

    <h1 class="text-yellow text-3xl font-bold">APPLICATION NAME</h1>


    <form action="<?php url('/php/login.php'); ?>" method="POST" class="bg-white rounded p-6 mt-4 border">

      <input type="text" name="username" class="bg-gray-400 rounded px-2 py-1 w-full" placeholder="username" required>
      <input type="password" name="password" class="bg-gray-400 rounded px-2 py-1 my-4 w-full " placeholder="password" required>
      <button type="submit" class="bg-dark-blue w-full px-2 py-2 text-white font-bold">LOGIN</button>

    </form>

  </div>

</body>

<script src="js/alpine.min.js"></script>
<style>
  body {
    background: url('img/bg-mobile.jpg') no-repeat center center fixed;
    background-size: cover;
  }

  @media screen and (min-width: 834px) {

    body {
      background: url('img/bg-desktop.jpg') no-repeat center center fixed;
      background-size: cover;
    }


  }
</style>

</html>