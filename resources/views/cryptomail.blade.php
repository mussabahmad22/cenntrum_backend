<?php if($user->lang == 'en'){?>
<!DOCTYPE html>
<html>
<head>
    <title>Points exchanged for Crypto.</title>
</head>
<body>
    <p>You have exchanged points for Crypto.</p>
    <p>The following are the details of your exchange: </p>
    <p>User ID : {{$user->id}}</p>
    <p>User email: {{$user->email}}</p>
    <p>Date of exchange : {{$user->crypto->created_at->format('m-d-Y')}}</p>
    <p>Time of exchange : {{ $buy_time }}</p>
    <p>Points exchanged : {{$incentives->req_point}}</p>
    <p>Crypto : {{$incentives->name}}</p>
    <p>Crypto Quantity to receive : {{$incentives->value}}</p>
    <p>Wallet address to receive crypto : {{$wallet_address}}</p>
    
    <p>Thank you</p>
</body>
</html>
<?php } elseif($user->lang == 'sp'){ ?>
<!DOCTYPE html>
<html>
<head>
    <title>Puntos canjeados por Cripto.</title>
</head>
<body>
    <p>Has canjeado puntos por criptos.</p>
    <p>Los siguientes son los detalles de tu canje: </p>
    <p>Usiario : {{$user->id}}</p>
    <p>Correo del usuario: {{$user->email}}</p>
    <p>Fecha del Canje: {{$user->crypto->created_at->format('m-d-Y')}}</p>
    <p>Hora del Canje: {{ $buy_time }}</p>
    <p>Puntos Canjeados : {{$incentives->req_point}}</p>
    <p>Cripto : {{$incentives->name}}</p>
    <p>Cantidad de criptos a recibir : {{$incentives->value}}</p>
    <p>Dirección de la cartera para recibir la cripto : {{$wallet_address}}</p>
    
    <p>Gracias</p>
</body>
</html>
<?php } else {?>
<!DOCTYPE html>
<html>
<head>
    <title>Points exchanged for Crypto.</title>
</head>
<body>
    <p>You have exchanged points for Crypto.</p>
    <p>The following are the details of your exchange: </p>
    <p>User ID : {{$user->id}}</p>
    <p>User email: {{$user->email}}</p>
    <p>Date of exchange : {{$user->crypto->created_at->format('m-d-Y')}}</p>
    <p>Time of exchange : {{ $buy_time }}</p>
    <p>Points exchanged : {{$incentives->req_point}}</p>
    <p>Crypto : {{$incentives->name}}</p>
    <p>Crypto Quantity to receive : {{$incentives->value}}</p>
    <p>Wallet address to receive crypto : {{$wallet_address}}</p>
    
    <p>Thank you</p>
</body>
</html>
<?php } ?>