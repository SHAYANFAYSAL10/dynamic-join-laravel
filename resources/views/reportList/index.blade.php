<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Document</title>
    {{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script> --}}
    <!-- Add this script tag to include json-formatter-js directly in your HTML -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet"> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/json-formatter-js@2.3.2/dist/json-formatter.min.js"></script> --}}
    {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script> --}}
    {{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
    {{-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"> --}}
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/themes/prism.min.css"> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/prism.min.js"></script> --}}
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.27.0/components/prism-json.min.js"></script> --}}
    <!-- Replace 'node_modules' with your project's actual directory structure -->
    <!-- Replace 'node_modules' with your project's actual directory structure -->
    {{-- <script src="node_modules/jquery/dist/jquery.min.js"></script> --}}

    <script src="{{ asset('modules/jquery.min.js') }}"></script>
    <script src="{{ asset('modules/jquery.slim.min.js') }}"></script>
    <script src="{{ asset('modules/cdn.min.js') }}"></script>
    <script src="{{ asset('modules/bootstrap.min.js') }}"></script>
    <script src="{{ asset('modules/alpine.min.js') }}" defer></script>
    <script src="{{ asset('modules/popper.min.js') }}"></script>
    <script src="{{ asset('modules/prism-json.min.js') }}"></script>
    <script src="{{ asset('modules/prism.js') }}"></script>
    <script src="{{ asset('modules/prism.min.js') }}"></script>
    {{-- <script src="node_modules/alpinejs/dist/alpine.min.js" defer></script> --}}
    {{-- <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script> --}}
    {{-- <script src="node_modules/@popperjs/core/dist/umd/popper.min.js"></script> --}}
    {{-- <script src="node_modules/json-formatter-js/dist/json-formatter.min.js"></script> --}}
    {{-- <script src="node_modules/prismjs/prism.min.js"></script> --}}
    {{-- <script src="node_modules/prismjs/components/prism-json.min.js"></script> --}}

    {{-- <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css"> --}}
    <link href="{{ asset('modules/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('modules/bootstrap2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('modules/prism.min.css') }}">
    {{-- <link rel="stylesheet" href="node_modules/prismjs/themes/prism.min.css"> --}}




    <style>
        .container {
            background-color: #f5f2f0;
            min-height: 600px;
            margin-bottom: 50px;
        }
    </style>

    <script src="{{ asset('js/modalVisibility.js') }}" defer></script>
    @vite('resources/css/app.css')
    @routes
</head>

<body>
    <div class="container mt-5">
        <div class="flex justify-between items-center bg-gray-200 p-5 rounded-md">
            <h1>View Reports</h1>
            <div class="text-right"><a href="{{ url('join') }}" class="btn btn-primary mb-3">Add New</a></div>
            <table class="table text-center">
                <thead>
                    <tr>
                        @if (count($reports) > 0)
                            @foreach ($reports[0] as $attribute => $value)
                                <th>
                                    {{ ucfirst($attribute) }}</th>
                            @endforeach
                            <th>Action
                            </th>
                        @else
                            <th>No data
                                available
                            </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @if (count($reports) > 0)
                        @foreach ($reports as $report)
                            <tr>
                                @foreach ($report as $attribute => $value)
                                    <td>
                                        @if ($attribute === 'view' || $attribute === 'users')
                                            @if ($attribute === 'view')
                                                <button type="submit" class="btn btn-warning text-white btn-sm"
                                                    data-toggle="modal" data-target="#myModal"
                                                    onclick="getJSON('{{ $value }}')">JSON
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-danger btn-sm" data-toggle="modal"
                                                    data-target="#myModal"
                                                    onclick="getJSON('{{ $value }}')">Users
                                                </button>
                                            @endif
                                            <div class="modal" id="myModal">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <!-- Modal Header -->
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">
                                                                @if ($attribute === 'view')
                                                                    JSON Data
                                                                @else
                                                                    Users
                                                                @endif
                                                            </h4>
                                                            <button type="button" class="close"
                                                                data-dismiss="modal">&times;</button>
                                                        </div>

                                                        <!-- Modal Body -->
                                                        <div class="modal-body">
                                                            <!-- Use a <pre> tag for preformatted text and apply some styling -->
                                                          <pre id="jsonDisplay" class="language-json"></pre>
                                                        </div>
                                                  
                                                        <!-- Modal Footer -->
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary"
                                                                    data-dismiss="modal">Close</button>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                {{ $value }}
                                        @endif
                                    </td>
                                @endforeach
                                <td>
                                    <a href="{{ url('/view-report/' . $report->id) }}" title="View Report Data"
                                        class="btn btn-info btn-sm">View</a>
                                    <a href="{{ url('view-report/' . $report->id . '/edit') }}"
                                        class="btn btn-warning btn-sm">Edit</a>
                                    <a href="{{ url('view-report/' . $report->id . '/delete') }}"
                                        class="btn btn-danger btn-sm">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
</body>

</html>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

{{-- @include('reportList.modal') --}}
