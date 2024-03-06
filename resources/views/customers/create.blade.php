<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Customer Info</h1>
    <div>
        @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{$error}}</li>
            @endforeach
        </ul>
        @endif
    </div>
    <form method="post" action="{{route('customer.store')}}">
        @csrf
        @method('post')
        <div>
            <label>First Name</label>
            <input type="text" name="firstname" placeholder="First Name"/>
        </div>
        <div>
            <label>Last Name</label>
            <input type="text" name="lastname" placeholder="Last Name"/>
        </div>
        <div>
            <label>Address</label>
            <input type="text" name="address" placeholder="Address"/>
        </div>
        <div>
            <label>Phone</label>
            <input type="text" name="phone" placeholder="Phone"/>
        </div>
        <div>
            <input type="submit" value="Save"/>
        </div>
    </form>
</body>
</html>