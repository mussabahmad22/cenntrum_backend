<?php if($lang == 'en'){?>
<!DOCTYPE html>
<html>
<head>
    <title>Forget Mail</title>
</head>
<body>
    <p> The code to reset your account's password is:</p>
    <p>Code : {{ $password }}</p>
    
    <p>Thank you</p>
</body>
</html>

<?php } elseif($lang == 'sp'){ ?>

    <!DOCTYPE html>
    <html>
    <head>
        <title>Forget Mail</title>
    </head>
    <body>
        <p> EL codigo para cambiar la clave de tu cuenta es:</p>

        <p>Codigo: {{ $password }}</p>
        
        <p>Gracias</p>
    </body>
    </html>

<?php } else {?>

<!DOCTYPE html>
<html>
<head>
    <title>Forget Mail</title>
</head>
<body>
    <p> The code to reset your account's password is:</p>
    <p>Code : {{ $password }}</p>
    
    <p>Thank you</p>
</body>
</html>

<?php } ?>