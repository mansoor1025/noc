<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Homepage 2 | Obama - Responsive admin template.</title>
    <link rel="shortcut icon" href="img/favicon.ico">
    <link href="http://fonts.googleapis.com/css?family=Roboto+Slab:400,300,100,700" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Roboto:500,400italic,100,700italic,300,700,500italic,400" rel="stylesheet">
    <link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@3/dark.css" rel="stylesheet">
    <link href="{{ asset('assets/css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!--Switchery [ OPTIONAL ]-->
    <link href="{{ asset('assets/plugins/switchery/switchery.min.css') }}" rel="stylesheet">
    <!--Bootstrap Select [ OPTIONAL ]-->
    <link href="{{ asset('assets/plugins/bootstrap-select/bootstrap-select.min.css') }}" rel="stylesheet">
    <!--ricksaw.js [ OPTIONAL ]-->
    <link href="{{ asset('assets/plugins/jquery-ricksaw-chart/css/rickshaw.css') }}" rel="stylesheet">
    <!--Bootstrap Validator [ OPTIONAL ]-->
    <link href="{{ asset('assets/plugins/bootstrap-validator/bootstrapValidator.min.css') }}" rel="stylesheet">
    <!--Bootstrap Table [ OPTIONAL ]-->
    <link href="{{ asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/datatables/extensions/Responsive/css/dataTables.responsive.css') }}" rel="stylesheet">
    <!--Demo [ DEMONSTRATION ]-->
    <link href="{{ asset('assets/css/demo/jquery-steps.min.css') }}" rel="stylesheet">
    <!--Summernote [ OPTIONAL ]-->
    <link href="{{ asset('assets/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
    <!--Demo [ DEMONSTRATION ]-->
    <link href="{{ asset('assets/css/demo/jasmine.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('assets/css/custom.css') }}" rel="stylesheet">
    <!--SCRIPT-->
    <!--=================================================-->
    <!--Page Load Progress Bar [ OPTIONAL ]-->
    <link href="{{ asset('assets/plugins/pace/pace.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/plugins/morris-js/morris.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/demo/jasmine.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css"  />
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
	 <script src="{{ asset('assets/js/jquery-2.1.1.min.js') }}"></script>
</head>
<body>
    <div id="container" class="effect mainnav-lg navbar-fixed mainnav-fixed">
        @include('layouts.header')
        @include('layouts.sidebar')
        @yield('content')

        <footer id="footer">
            <!-- Visible when footer positions are static -->
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <div class="hide-fixed pull-right pad-rgt">Currently v2.2</div>
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <!-- Remove the class name "show-fixed" and "hide-fixed" to make the content always appears. -->
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <p class="pad-lft">&#0169; 2019 Dusky Solutions</p>
			
    </div>

    <script src="{{ asset('assets/plugins/pace/pace.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
   
    <!--BootstrapJS [ RECOMMENDED ]-->
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <!--Fast Click [ OPTIONAL ]-->
    <script src="{{ asset('assets/plugins/fast-click/fastclick.min.js') }}"></script>
    <!--Jasmine Admin [ RECOMMENDED ]-->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <!--Jquery Nano Scroller js [ REQUIRED ]-->
    <script src="{{ asset('assets/plugins/nanoscrollerjs/jquery.nanoscroller.min.js')  }}"></script>
    <!--Metismenu  [ REQUIRED ]-->
    <script src="{{ asset('assets/plugins/metismenu/metismenu.min.js') }}"></script>
    <!--Switchery [ OPTIONAL ]-->
    <script src="{{ asset('assets/plugins/switchery/switchery.min.js') }}"></script>
    <!--Bootstrap Select [ OPTIONAL ]-->
    <script src="{{ asset('assets/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <!--DataTables [ OPTIONAL ]-->
    <script src="{{ asset('assets/plugins/datatables/media/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/media/js/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables/extensions/Responsive/js/dataTables.responsive.min.js') }}"></script>
    <!--Fullscreen jQuery [ OPTIONAL ]-->
    <script src="{{ asset('assets/plugins/screenfull/screenfull.js') }}"></script>
    <!--DataTables Sample [ SAMPLE ]-->
    <script src="{{ asset('assets/js/demo/tables-datatables.js') }}"></script>
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script type="text/javascript" src="{{ asset('assets/js/jquery.printPage.js') }}"></script>

    @yield('js')
    <script>
        @if (session('message'))
            Swal.fire({
                position: 'center',
                icon: 'success',
                title: '{{ session('message') }}',
                showConfirmButton: false,
                timer: 1100
            });
                
        @endif
        @if (session('error'))
            Swal.fire({
                position: 'center',
                icon: 'error',
                title: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 1500
            });
                
        @endif

        function validate(evt) {
            var theEvent = evt || window.event;

            // Handle paste
            if (theEvent.type === 'paste') {
                key = event.clipboardData.getData('text/plain');
            } else {
            // Handle key press
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
            }
            var regex = /[0-9]|\./;
            if( !regex.test(key) ) {
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
            }
        }
    </script>
</body>
</html>