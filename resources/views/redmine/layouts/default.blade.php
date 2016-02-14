<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="{{asset('asset/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('asset/js/jquery-plugins/select2/select2.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('asset/js/jquery-plugins/jquery-ui-datepicker/jquery-ui.min.css')}}" rel="stylesheet" type="text/css">
        <link href="{{asset('asset/css/style.css')}}" rel="stylesheet" type="text/css">
        <script>
            var CSRF_TOKEN='{{ csrf_token() }}';
        </script>
    </head>
    <body>
        <!-- Static navbar -->
        <nav class="navbar navbar-default navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">Redmine</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
              <ul class="nav navbar-nav">
                  <li><a href="{{url('redmine/issue')}}">Issues</a></li>
                  <li><a href="{{url('redmine/issue/create')}}">Create Issues</a></li>
                  <li><a href="{{url('redmine/timeentry/create')}}">Time Entry</a></li>
              </ul>
              <ul class="nav navbar-nav navbar-right">
                <li><a href="{{url('redmine/issue/clear-cache')}}">Clear Cache</a></li>
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </nav>

        <div class="container">
            <div class="content">
                @yield('content')
            </div>
        </div>

        <div class="loader ajax-loader">
        </div>
        <div class="windows8 ajax-loader">
            <div class="wBall" id="wBall_1">
                <div class="wInnerBall"></div>
            </div>
            <div class="wBall" id="wBall_2">
                <div class="wInnerBall"></div>
            </div>
            <div class="wBall" id="wBall_3">
                <div class="wInnerBall"></div>
            </div>
            <div class="wBall" id="wBall_4">
                <div class="wInnerBall"></div>
            </div>
            <div class="wBall" id="wBall_5">
                <div class="wInnerBall"></div>
            </div>
        </div>

        <script src="{{asset('asset/js/jquery-plugins/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('asset/js/jquery-plugins/select2/select2.min.js')}}"></script>
        <script src="{{asset('asset/js/jquery-plugins/jquery-ui-datepicker/jquery-ui.min.js')}}"></script>
        <script src="{{asset('asset/js/vue.js')}}"></script>
        <script src="{{asset('asset/js/vue-resource.js')}}"></script>
        <script src="{{asset('asset/js/vue-directives/vue-common.js')}}"></script>
        <script src="{{asset('asset/js/custom.js')}}"></script>
        <script type="text/javascript">
        Vue.http.headers.common['X-CSRF-TOKEN'] = CSRF_TOKEN;

        </script>
        @section('script')
        @show

    </body>
</html>
