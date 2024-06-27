<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Bootstrap CSS -->
	<link href="front/css/bootstrap.min.css" rel="stylesheet">

	<!-- Custom Css -->
	<link href="front/css/style.css" rel="stylesheet">


	<title>@if(isset($page)) {{$page->get_meta_title()}} @else {{setting('site.title') . " " .(isset($title)?' - '.$title:'')}} @endif</title>

	<meta name="description" content="<?php if(isset($page)) echo $page->get_meta_description(); else echo strip_tags(setting('site.description')); ?>" />

    <meta name="keywords" content="<?php if(isset($page)) echo $page->get_meta_keywords(); else echo strip_tags(setting('site.keywords')); ?>" />	

</head>

<body>

<!-- Add HTML Start-->
<div class="wrapper-main">

	@include('front.header')

	<!-- contentpart -->

    @yield('content')

	<!-- content part end -->

</div>

<!-- Footer Start  -->
<footer>
	<div class="container text-center">
		<span class="text-muted">© 2021 Company, Inc</span>
	</div>
</footer>
<!-- Footer End  -->

<!-- Add HTML End-->

<!-- bootstrap js -->
<script src="front/js/bootstrap.bundle.js"></script>

<!-- jquery js -->
<script src="front/js/jquery-3.6.0.min.js"></script>
<script src="front/js/jquery.validate.min.js"></script>
<script src="front/js/custom.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

@yield('javascript')

</body>

</html>