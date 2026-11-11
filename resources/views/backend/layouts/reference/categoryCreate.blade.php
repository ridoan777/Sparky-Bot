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
			<div class="content">
				@yield('content')
				<!-- content -->
				<div class="container">
					<h2 class="mb-4">Create Reference Category</h2>

					<form action="{{ route('reference.store') }}" method="POST" enctype="multipart/form-data">
						@csrf

						<!-- Category Fields -->
						<div class="mb-3">
							<label for="name" class="form-label">Category Name</label>
							<input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
						</div>

						<div class="mb-3">
							<label for="description" class="form-label">Description</label>
							<textarea name="description" id="description"
								class="form-control">{{ old('description') }}</textarea>
						</div>

						<div class="mb-3">
							<label for="order" class="form-label">Order</label>
							<input type="number" name="order" id="order" class="form-control" value="{{ old('order', 0) }}"
								required>
						</div>

						<hr>
						<h4>Contents</h4>
						<div id="content-wrapper">

							<div class="content-item border p-3 mb-3">
								<div class="mb-3">
									<label class="form-label">Title</label>
									<input type="text" name="content[0][title]" class="form-control" required>
								</div>

								<div class="mb-3">
									<label class="form-label">Details</label>
									<textarea name="content[0][details]" class="form-control"></textarea>
								</div>

								<div class="mb-3">
									<label class="form-label">PDF Page Number</label>
									<input type="number" name="content[0][ref_pdf_page]" class="form-control">
								</div>

								<div class="mb-3">
									<label class="form-label">File</label>
									<input type="file" name="content[0][file]" class="form-control">
								</div>

								<button type="button" class="btn btn-danger remove-content">Remove</button>
							</div>

						</div>

						<button type="button" class="btn btn-secondary" id="add-content">Add Content</button>

						<button type="submit" class="btn btn-primary">Create Category</button>
					</form>
				</div>
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

	<script>
		let contentIndex = 1;

		document.getElementById('add-content').addEventListener('click', function () {
			const wrapper = document.getElementById('content-wrapper');
			const newItem = document.querySelector('.content-item').cloneNode(true);

			newItem.querySelectorAll('input, textarea').forEach(input => {
				const name = input.getAttribute('name');
				const newName = name.replace(/\d+/, contentIndex);
				input.setAttribute('name', newName);
				input.value = '';
			});

			wrapper.appendChild(newItem);
			contentIndex++;
		});

		// Remove content item
		document.getElementById('content-wrapper').addEventListener('click', function (e) {
			if (e.target.classList.contains('remove-content')) {
				const items = document.querySelectorAll('.content-item');
				if (items.length > 1) {
					e.target.closest('.content-item').remove();
				} else {
					alert('At least one content is required');
				}
			}
		});
	</script>

</body>

</html>