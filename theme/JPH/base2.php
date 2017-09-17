<!DOCTYPE html>
<html lang="es-ES">
    <head>
        <title>JRH+<?=$this->section('title')?></title>

        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="description" content="">
        <meta name="author" content="ink, cookbook, recipes">
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

        <!-- CSS Extends-->
        <?=$this->section('addCss')?>
        
    </head>
    <body>
        <?=$this->section('content')?>
    </body>

<!-- javascript extra -->
<?=$this->section('addJs')?>
</html>