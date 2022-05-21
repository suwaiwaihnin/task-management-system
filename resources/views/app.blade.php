<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    <script src="{{ mix('/js/app.js') }}" defer></script>
      <!-- Favicon -->
  <link href="/assets/img/brand/favicon.png" rel="icon" type="image/png">
  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- Icons -->
  <link href="/assets/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
  <link href="/assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
  <!-- CSS Files -->
  <link href="/assets/css/argon-dashboard.css?v=1.1.2" rel="stylesheet" />
    @inertiaHead
    <style>
        .wrapper
{
	padding-bottom: 90px;
}

.divider
{
	position: relative;
	margin-top: 90px;
	height: 1px;
}

.div-transparent:before
{
	content: "";
	position: absolute;
	top: 0;
	left: 5%;
	right: 5%;
	width: 90%;
	height: 1px;
	background-image: linear-gradient(to right, transparent, rgb(48,49,51), transparent);
}
.div-dot:after
{
	content: "";
	position: absolute;
	z-index: 1;
	top: -9px;
	left: calc(50% - 9px);
	width: 18px;
	height: 18px;
	background-color: goldenrod;
	border: 1px solid rgb(48,49,51);
	border-radius: 50%;
	box-shadow: inset 0 0 0 2px white,
					0 0 0 4px white;
}
    </style>
  </head>
  <body>
    @inertia
      <!--   Core   -->
  <script src="/assets/js/plugins/jquery/dist/jquery.min.js"></script>
  <script src="/assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <!--   Optional JS   -->
  <script src="/assets/js/plugins/chart.js/dist/Chart.min.js"></script>
  <script src="/assets/js/plugins/chart.js/dist/Chart.extension.js"></script>
  <!--   Argon JS   -->
  <script src="/assets/js/argon-dashboard.min.js?v=1.1.2"></script>
  <script src="https://cdn.trackjs.com/agent/v3/latest/t.js"></script>
  {{-- <script src="./assets/js/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script> --}}
  <script>
    window.TrackJS &&
      TrackJS.install({
        token: "ee6fab19c5a04ac1a32a645abde4613a",
        application: "argon-dashboard-free"
      });
      window.Laravel = <?php echo json_encode([
               'csrfToken' => csrf_token(),
                    ]); ?>
  </script>
  </body>
</html>
