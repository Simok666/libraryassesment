<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Postingan Baru</title>
</head>
<body>
    
    <h1>{{ $postMail['title'] }}</h1>
    {{-- <p>{{ $postMail['body'] }} </h1> --}}
    <p>name : {{ $postMail['body']->name }}</p>
    <p>email : {{ $postMail['body']->email }}</p>
    <p>instance_name : {{ $postMail['body']->instance_name }}</p>
    <p>leader_instance_name : {{ $postMail['body']->leader_instance_name }}</p>
    <p>library_name : {{ $postMail['body']->library_name }}</p>
    <p>website : {{ $postMail['body']->website }}</p>
    <p>library_email : {{ $postMail['body']->library_email }}</p>

</body>
</html>