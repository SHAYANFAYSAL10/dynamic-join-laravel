<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colorful Report</title>

    <!-- Bootstrap CSS -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    <!-- Add this script tag to include json-formatter-js directly in your HTML -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/components/prism-json.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/themes/prism.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/prism.min.js"></script>

    <!-- Custom CSS -->
    <style>
        body {
            background-color: #ffffff;
        }

        .container {
            background-color: #f5f2f0;
            min-height: 600px;
            margin-bottom: 50px;
        }
    </style>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Vite and Routes (Assuming these are related to your specific framework) -->
    @vite('resources/css/app.css')
    @routes
</head>

<body>
    <div class="container mt-5">
        <div class="flex justify-between items-center bg-gray-200 p-5 rounded-md">
            <h1>
                @php
                    echo $name;
                @endphp
            </h1>
            <table class="table text-center">
                <thead>
                    <tr>
                        @if (count($data) > 0)
                            @foreach ($data[0] as $attribute => $value)
                                <th>{{ ucfirst($attribute) }}</th>
                            @endforeach
                        @else
                            <th>No data available</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if (count($data) > 0)
                        @foreach ($data as $row)
                            <tr>
                                @foreach ($row as $value)
                                    <td>{{ $value }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
