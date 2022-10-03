<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Fixed Sidebar</title>
    @includeIf('layouts._includes.css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @includeIf('layouts._includes.top_navbar')
        @includeIf('layouts._includes.sidebar')
        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid">
                    @yield('breadcrumb')
                </div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>
        @include('layouts._includes.footer')
    </div>
    @includeIf('layouts._includes.scripts')
</body>

</html>
