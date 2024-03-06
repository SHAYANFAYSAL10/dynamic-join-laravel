<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Customers</h1>
    <div>
    <fieldset>
        <legend>Choose Columns:</legend>

        <div>
            <input type="checkbox" name="id"/>
            <label for="id">id</label>
        </div>

        <div>
            <input type="checkbox" name="firstname"/>
            <label for="firstname">firstname</label>
        </div>

        <div>
            <input type="checkbox" name="lastname"/>
            <label for="lastname">lastname</label>
        </div>

        <div>
            <input type="checkbox" name="address"/>
            <label for="address">address</label>
        </div>

        <div>
            <input type="checkbox" name="phone"/>
            <label for="phone">phone</label>
        </div>

        <div>
            <input type="submit" value="Submit"/>
        </div>
        </fieldset>
    </div>
    <div>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Address</th>
                <th>Phone</th>
            </tr>
            @foreach($customers as $customer)
                <tr>
                    <td>{{$customer->id}}</td>
                    <td>{{$customer->firstname}}</td>
                    <td>{{$customer->lastname}}</td>
                    <td>{{$customer->address}}</td>
                    <td>{{$customer->phone}}</td>
                </tr>
            @endforeach
        </table>
    </div>
    
</body>
</html>