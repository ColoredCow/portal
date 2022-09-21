<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        <h1>Add User</h1>
        <form method="post" action="{{route('saveItem')}}" accept-charset="UTF-8">
            {{ csrf_field() }}
            <label for="title">Title:</label><input type="text" name="title"></br>
            <label for="description">Description:</label><input type="text" name="description"></br>
            <label for="type">Type:</label><input type="text" name="type"></br>
            <label for="domain">Domain:</label><input type="text" name="domain"></br>
            <button type="submit">Add User</button>
            
        </form>
    </div>
    

</body>
</html>