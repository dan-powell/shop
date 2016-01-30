<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Portfolio</title>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <style>
        body { padding-top: 70px; }

        .list-group.list-group-root {
            padding: 0;
            overflow: hidden;
            background: #fff;
        }

        .list-group.list-group-root .list-group {
            margin-bottom: 0;
        }

        .list-group.list-group-root .list-group-item {
            border-radius: 0;
            border-width: 1px 0 0 0;
        }

        .list-group.list-group-root .list-group {
            padding-left: 30px;
        }

        .list-group-item .glyphicon {
            margin-right: 5px;
        }

        pre {
            white-space: pre-wrap;       /* CSS 3 */
            white-space: -moz-pre-wrap;  /* Mozilla, since 1999 */
            white-space: -pre-wrap;      /* Opera 4-6 */
            white-space: -o-pre-wrap;    /* Opera 7 */
            word-wrap: break-word;       /* Internet Explorer 5.5+ */
        }
    </style>
</head>
<body>



<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Shop</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="@if(Request::route()->getName() == 'shop.home')active @endif"><a href="{{ route('shop.home') }}">Home <span class="sr-only">(current)</span></a></li>
                <li class="@if(Request::route()->getName() == 'shop.category.index')active @endif"><a href="{{ route('shop.category.index') }}">Categories</a></li>
                <li class="@if(Request::route()->getName() == 'shop.product.index')active @endif"><a href="{{ route('shop.product.index') }}">Products</a></li>
            </ul>

            <ul class="nav navbar-nav navbar-right">
                <li><a href="{{ route('shop.cart.index') }}">Cart</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

<div class="container">

    <div class="row">
        <div class="col-sm-3">
            @include('shop::partials.sidebar')
        </div>
        <div class="col-sm-9">
            @yield('main')
        </div>

    </div>

</div>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/holder/2.9.1/holder.js"></script>

<script>
    // Control toggling of product extras
    $(document).ready(function() {
        $('.js-extra-toggle').on('change', function (e, data) {
            var target = $(this).data("toggle-target");

            if($(this).prop('checked')){//this is true if the switch is on
                $(target).show();
            }else{
                $(target).hide();
            }
        });
    });
</script>


</body>
</html>