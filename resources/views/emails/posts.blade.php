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
    <?php if($postMail['status'] == 'insert perpus')  { ?>
        {{ $postMail['body'] }}
    <?php } elseif ($postMail['status'] == 'insert komponen') { ?>
        {{ $postMail['body'] }}
    <?php } elseif ($postMail['status'] == 'insert bukti fisik') { ?>
        {{ $postMail['body'] }}
    <?php } elseif ($postMail['status'] == 'auth') { ?>
        <p>name : {{ $postMail['body']->name }}</p>
        <p>email : {{ $postMail['body']->email }}</p>
        <p>instance_name : {{ $postMail['body']->instance_name }}</p>
        <p>leader_instance_name : {{ $postMail['body']->leader_instance_name }}</p>
        <p>library_name : {{ $postMail['body']->library_name }}</p>
        <p>website : {{ $postMail['body']->website }}</p>
        <p>library_email : {{ $postMail['body']->library_email }}</p>
    <?php }?>
    
    

</body>
</html>