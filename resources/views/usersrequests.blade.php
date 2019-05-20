<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>title</title>

    <link rel="shortcut icon"  type="image/png"  href="{{ asset('assets/images/') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/materialize.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/icon.css') }}" >
    <link rel="stylesheet" href="{{ asset('assets/css/jquery-ui.css') }}" >
    <link rel="stylesheet" href="{{ asset('assets/css/layout.css') }}" >

    <script src="{{ asset('assets/js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.js') }}"></script>
    <script src="{{ asset('assets/js/materialize.min.js') }}"></script>
</head>
<style>
    .row{
        margin: 20px 30px 10px 30px;
    }
</style>
<body>

        <div class="wrapper" style="height: 150px;">
            <div class="content">
                <nav style=" height: 100px;">
                    <div class="nav-wrapper" style="background-color: white; height: 100px;">

                    </div>
                </nav>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <table>
                    <thead>
                      <tr>
                          <th>Userame</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Followers</th>
                          <th>Following</th>
                          <th>Repos</th>
                      </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->followers }}</td>
                                <td>{{ $user->following }}</td>
                                <td>{{ $user->repos }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

</body>

</html>
<script >

    $(document).ready(function(){
        $('ul.tabs').tabs();
        $('#submit').on('click', function () {

            var fd = new FormData;
            fd.append('_token', '{{ csrf_token() }}');
            fd.append('username', $('#username').val());


            $.ajax({
                type: "POST",
                url: "/",
                data: fd,
                processData: false,
                contentType: false,
                success: function (result) {
                    if (result.status == 'ok') {

                    }
                    else {
                        $(".progress").fadeOut(400, function () {
                            $("#submit").fadeIn(300);
                        });
                        $('#modal2').modal('open');
                    }
                },
                error: function () {
                    $('#modal2').modal('open');
                }
            });

        });

    });
</script>


