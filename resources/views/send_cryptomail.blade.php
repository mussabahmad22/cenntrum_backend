<!DOCTYPE html>
<html>
<head>
    <title>Crypto Send To Your Wallet Address</title>
</head>
<body>
    <h1></h1>
    <h2>Crypto Send To Your Wallet Address </h2>
    <p>User email: {{ $data['email'] }}</p>
    <p>Exchange Number: {{ $data['exchange'] }}</p>
    <p>Date of exchange : {{ $data['date_of_exchange_']  }}</p>
    <p>Time of exchange : {{ $data['time_of_exchange']  }}</p>
    <p>Points exchanged : {{ $data['points'] }}</p>
    <p>Crypto Name : {{ $data['crypto_name'] }}</p>
    <p>Quantity of Crypto to be sent : {{$data['quantity_to_be_sent']}}</p>
    <p>User's wallet to receive Crypto : {{ $data['wallet_address'] }}</p>
    
    <h2>Thank you</h2>
</body>
</html>