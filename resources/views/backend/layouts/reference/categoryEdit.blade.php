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
			<!-- alert -->
			<div class="my-2" id="messageArea">
				@if(session('success'))
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<strong>Success!</strong> {{ session('success') }}
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				@endif

				@if($errors->any())
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<strong>Error/s:</strong>
						<ul class="mb-0">
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
						<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				@endif
			</div>
			<!-- alert -->
			<div class="content">
				@yield('content')
				<div class="container">
					<h2 class="mb-4">{{ isset($refCategory) ? 'Edit Reference Category' : 'Create Reference Category' }}
					</h2>

					<form action="{{ route('reference.category.update', $refCategory->id) }}" method="POST"
						enctype="multipart/form-data">
						@csrf

						<!-- Category Fields -->
						<div class="mb-3">
							<label for="name" class="form-label">Category Name</label>
							<input type="text" name="name" id="name" class="form-control"
								value="{{ old('name', $refCategory->name ?? '') }}" required>
						</div>

						<div class="mb-3">
							<label for="description" class="form-label">Description</label>
							<textarea name="description" id="description"
								class="form-control">{{ old('description', $refCategory->description ?? '') }}</textarea>
						</div>

						<div class="mb-3">
							<label for="order" class="form-label">Order</label>
							<input type="number" name="order" id="order" class="form-control"
								value="{{ old('order', $refCategory->order ?? 0) }}" required>
						</div>

						<hr>
						<h4>Contents</h4>
						<div id="content-wrapper">

							@if(isset($refCategory))
								@foreach($refCategory->refCategoryRelationWith_pages as $index => $content)
									<div class="content-item border p-3 mb-3">

										<input type="hidden" name="content[{{ $index }}][id]" value="{{ $content->id }}">

										<div class="mb-3">
											<label class="form-label">Title</label>
											<input type="text" name="content[{{ $index }}][title]" class="form-control"
												value="{{ old("content.$index.title", $content->title) }}" required>
										</div>

										<div class="mb-3">
											<label class="form-label">Details</label>
											<textarea name="content[{{ $index }}][details]"
												class="form-control">{{ old("content.$index.details", $content->details) }}</textarea>
										</div>

										<div class="mb-3">
											<label class="form-label">PDF Page Number</label>
											<input type="number" name="content[{{ $index }}][ref_pdf_page]" class="form-control"
												value="{{ old("content.$index.ref_pdf_page", $content->ref_pdf_page) }}">
										</div>

										<div class="mb-3">
											<label class="form-label">File</label>
											<input type="file" name="content[{{ $index }}][file]" class="form-control">
											@if($content->path && $content->path !== 'no-content')
												<small>Current file: <a href="{{ asset('storage/' . $content->path) }}"
														target="_blank">View</a></small>
											@endif
										</div>

										<button type="button" class="btn btn-danger remove-content">Remove</button>
									</div>
								@endforeach
							@else
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
							@endif

						</div>

						<button type="button" class="btn btn-secondary mb-3" id="add-content">Add Content</button>
						<button type="submit"
							class="btn btn-primary">{{ isset($refCategory) ? 'Update Category' : 'Create Category' }}</button>
					</form>
				</div>
			</div>

			@include('backend.partials.footer')
		</div>
		<!-- ============================================================== -->
		<!-- End Page content -->
		<!-- ============================================================== -->

	</div>
	<!-- END wrapper -->

	@include('backend.partials.scripts')

	{!! ToastMagic::scripts() !!}

	<script>
		let contentIndex = {{ isset($refCategory) ? $refCategory->refCategoryRelationWith_pages->count() : 1 }};

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