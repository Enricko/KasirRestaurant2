<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="{{ asset('admin_lte') }}/dist/css/adminlte.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
      {{-- dataTables --}}
  <link rel="stylesheet" href="{{ asset('admin_lte') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('admin_lte') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="{{ asset('admin_lte') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <style>
        a{
            text-decoration: none;
            color:white;
        }
        a:hover{
            color: white;
        }
        a.menu:hover,
        .menu:hover{
            cursor: pointer;
            opacity: .6;
        }
        input,
        input:-webkit-autofill,
        input:-webkit-autofill:hover,
        input:-webkit-autofill:focus,
        input:-webkit-autofill:active,
        textarea:-webkit-autofill,
        textarea:-webkit-autofill:hover,
        textarea:-webkit-autofill:focus,
        select:-webkit-autofill,
        select:-webkit-autofill:hover,
        select:-webkit-autofill:focus{
            -webkit-text-fill-color: white;
            -webkit-box-shadow: 0 0 0 30px #343a40 inset !important;
        }
        /* width */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
            border-radius: 5px
        }

        /* Track */
        ::-webkit-scrollbar-track {
        background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
        background: #888;
        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
        background: #555;
        }
    </style>
</head>
<body style="background-color:#313131">
    <nav class="navbar navbar-expand navbar-dark">
        <!-- Left navbar links -->
        <ul class="navbar-nav mx-auto">
          <li class="nav-item">
            <a href="/" class="nav-link">Home</a>
          </li>
          <li class="nav-item">
            <a href="/list_order" class="nav-link">List Order</a>
          </li>
        </ul>
    </nav>
    @yield('content')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if($message = Session::get('success'))
      Swal.fire({
        icon: 'success',
        title: 'App Said : ',
        text: '{{$message}}',
      })
    @endif
    @if($message = Session::get('update'))
      Swal.fire({
        icon: 'warning',
        title: 'App Said : ',
        text: '{{$message}}',
      })
    @endif
    @if($message = Session::get('delete'))
      Swal.fire({
        icon: 'error',
        title: 'App Said : ',
        text: '{{$message}}',
      })
    @endif
</script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('admin_lte') }}/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="{{ asset('admin_lte') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script>
    $(document).ready( function () {
        $('#myTable').DataTable();
    });
</script>
</body>
</html>
