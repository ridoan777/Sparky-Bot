<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8" />
	<title>@yield('title')</title>

	{!! ToastMagic::styles() !!}


	@include('backend.partials.styles')

	<style>
		li {
			list-style: none;
		}
	</style>

</head>

<!-- body start -->

<body data-menu-color="light" data-sidebar="default">

	<!-- Begin page -->
	<div id="app-layout">

		<!-- Header Start -->

		@include('backend.partials.header')

		<!-- End Header -->

		<!-- Left Sidebar Start -->

		@include('backend.partials.sidebar')

		<!-- Left Sidebar End -->

		<!-- ============================================================== -->
		<!-- Start Page Content here -->
		<!-- ============================================================== -->

		<div class="content-page">
			<div class="content p-4">
				@yield('content')
				<!-- content -->
				<form action="{{ route('reference.content.update', $refContent->id) }}" enctype="multipart/form-data" method="POST">
					@csrf

					<div class="form-group my-2">
						<label for="title">Title</label>
						<input type="text" class="form-control" id="title" aria-describedby="title" name="title"
							placeholder="Enter Title" value="{{ $refContent->title }}">
					</div>
					<!--  -->
					<div class="form-group my-2">
						<label for="title">Details</label>
							<textarea name="details" id="details" class="form-control" rows="3">{{ $refContent->details }}</textarea>
					</div>
					<!--  -->
					<div class="form-group my-2">
						<label for="pdf_page">Page no. of the ASNZS Reference PDF</label>
						<input type="text" class="form-control" id="pdf_page" aria-describedby="pdf_page" name="ref_pdf_page"
							 value="{{ $refContent->ref_pdf_page }}">
					</div>
					<!--  -->
					<div class="form-group my-2">
						<label for="cat">Category Name</label>
						<input type="text" class="form-control" id="cat" aria-describedby="cat"
							placeholder="Page no. of the ASNZS Reference PDF" value="{{ $refContent->refPageRetalationWith_category->name ?? 'N/A' }}" name="category_id" readonly>
					</div>
					<!--  -->
					<div class="form-group my-4">
						<label for="exampleFormControlFile1">File</label>
						<input type="file" class="form-control-file" name="file">
					</div>
					<!--  -->
					<button type="submit" class="btn btn-primary">Submit</button>

				</form>

				<!-- content -->
			</div>

			<!-- Footer Start -->
			@include('backend.partials.footer')
			<!-- end Footer -->

		</div>
		<!-- ============================================================== -->
		<!-- End Page content -->
		<!-- ============================================================== -->

	</div>
	<!-- END wrapper -->

	@include('backend.partials.scripts')

	{!! ToastMagic::scripts() !!}

</body>

</html>