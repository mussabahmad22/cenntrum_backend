<?php if($user->lang == 'en'){?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Points exchanged for Gift Card.</title>
    </head>
    <body>
        <p>You have exchanged points for gift card.</p>
        <p>The following are the details of your exchange: </p>
        <p>User ID : {{$user->id}}</p>
        <p>User email: {{$user->email}}</p>
        <p>Date of exchange: {{$user->crypto->created_at->format('m-d-Y')}}</p>
        <p>Time of exchange : {{ $buy_time }}</p>
       <p>Points exchanged : {{$incentives->req_point}}</p>
        <p>Gift Card : {{$incentives->name}} From {{ $bussiness->name }}</p>
        <p>Minimum Purchase to Redeem gift card : {{$incentives->value}}</p>
        <p>Expiration date of the gift card : {{$incentives->expiry_date}}</p>
        <p>Gift Code : {{$giftcode}}</p>
        
        <p>Thank you</p>
    </body>
    </html>
    <?php } elseif($user->lang == 'sp'){ ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Puntos canjeados por tarjeta regalo.</title>
    </head>
    <body>
        <p>Has canjeado puntos por tarjeta regalo</p>
        <p>Los siguientes son los detalles de tu canje: </p>
        <p>Usiario : {{$user->id}}</p>
        <p>Correo del usuario : {{$user->email}}</p>
        <p>Fecha del Canje : {{$user->crypto->created_at->format('m-d-Y')}}</p>
        <p>Hora del Canje : {{ $buy_time }}</p>
        <p>Puntos Canjeados : {{$incentives->req_point}}</p>
        <p>Tarjeta Regalo : {{$incentives->name}} From {{ $bussiness->name }}</p>
        <p>Compra mínima para usar esta tarjeta : {{$incentives->value}}</p>
        <p>Fecha de vencimiento de la tarjeta regalo : {{$incentives->expiry_date}}</p>
        <p>codigo de regalo : {{$giftcode}}</p>

        
        <p>Gracias</p>
    </body>
    </html>
    <?php } else {?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Points exchanged for Gift Card.</title>
        </head>
        <body>
            <p>You have exchanged points for gift card.</p>
            <p>The following are the details of your exchange: </p>
            <p>User ID : {{$user->id}}</p>
            <p>User email: {{$user->email}}</p>
            <p>Date of exchange: {{$user->crypto->created_at->format('m-d-Y')}}</p>
            <p>Time of exchange : {{ $buy_time }}</p>
           <p>Points exchanged : {{$incentives->req_point}}</p>
            <p>Gift Card : {{$incentives->name}}</p>
            <p>Minimum Purchase to Redeem gift card : {{$incentives->value}}</p>
            <p>Expiration date of the gift card : {{$incentives->expiry_date}}</p>
            <p>Gift Code : {{$giftcode}}</p>

            <p>Thank you</p>
        </body>
        </html>
    <?php } ?>