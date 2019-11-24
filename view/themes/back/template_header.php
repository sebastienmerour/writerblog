<!DOCTYPE html>
<html lang="fr" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="Sébastien Merour">
    <!-- style -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900" rel="stylesheet">
    <script src="https://kit.fontawesome.com/14f8a7289e.js"></script>
    <!-- Custom styles for this template -->
    <link href="<?php echo BASE_URL; ?>public/css/scroll.css" rel="stylesheet">
    <link href="<?php echo BASE_URL; ?>public/css/dashboard.css" rel="stylesheet">
    <!-- TINYMCE script -->
    <script src="https://cdn.tiny.cloud/1/g3t2j6ax1fih16h88zn6d7z6bd9akw3ur6zuo3p7qainhbeq/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    <script>
    tinymce.init({
      selector: '#content',
      auto_focus: 'element1',
      height: "400px"
    });
    </script>
    <title><?php echo $title; ?></title>
</head>
<body>
