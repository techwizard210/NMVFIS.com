<!DOCTYPE html>
<html>

<head>
    <title>NMVFIS.com</title>
</head>

<body>
    <h1>{{ $mailData['title'] }}</h1>
    <div style="display: flex;">
        <h2>Username: </h2>&nbsp;&nbsp;<h3>{{ $mailData['username'] }}</h3>
    </div>
    <div style="display: flex;">
        <h2>E-mail: </h2>&nbsp;&nbsp;<h3>{{ $mailData['email'] }}</h3>
    </div>
    <div style="display: flex;">
        <h2>Message: </h2>&nbsp;&nbsp;
        <h3>{{ $mailData['body'] }}</h3>
    </div>

    <p>Thank you</p>
</body>

</html>