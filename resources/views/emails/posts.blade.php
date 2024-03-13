<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Postingan Baru</title>
</head>
<body>
    
    <h1>{{ $data['title'] }}</h1>
    <p>name : {{ $data['body']->name }}</p>
    <p>email : {{ $data['body']->email }}</p>
    <p>instance_name : {{ $data['body']->instance_name }}</p>
    <p>leader_instance_name : {{ $data['body']->leader_instance_name }}</p>
    <p>library_name : {{ $data['body']->library_name }}</p>
    <p>website : {{ $data['body']->website }}</p>
    <p>library_email : {{ $data['body']->library_email }}</p>

</body>
</html>