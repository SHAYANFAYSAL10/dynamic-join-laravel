<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Product</h1>
    <div>
        <fieldset>
            <legend>Choose Columns:</legend>

            <div>
                <input type="checkbox" name="id" />
                <label for="id">id</label>
            </div>

            <div>
                <input type="checkbox" name="name" />
                <label for="name">name</label>
            </div>

            <div>
                <input type="checkbox" name="brand" />
                <label for="brand">brand</label>
            </div>

            <div>
                <input type="checkbox" name="price" />
                <label for="price">price</label>
            </div>

            <div>
                <input type="submit" value="Submit" />
            </div>
        </fieldset>
    </div>
    <div>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Brand</th>
                <th>Price</th>
            </tr>
            @foreach ($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->brand }}</td>
                    <td>{{ $product->price }}</td>
                </tr>
            @endforeach
        </table>
    </div>

</body>

</html>
