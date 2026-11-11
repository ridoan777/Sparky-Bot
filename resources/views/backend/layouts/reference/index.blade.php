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
				<!--  -->
				<div id="accordionSection" class="container w-75">

					<!-- TOP -->
					<div class="d-flex justify-content-between align-items-center">

						<a href="{{ route('reference.create') }}" class="my-2 btn btn-success">
							Create Reference
						</a>
						{{-- --}}
						<form action="{{ route('admin.reference.search') }}" method="GET" class="my-2 flex gap-2">
							<input type="text" name="q" value="{{ request('q') }}" placeholder="Search references..."
								class="px-3 py-2 border rounded-lg w-64">
							<button type="submit" class="px-4 py-2 btn btn-secondary text-white rounded-lg">
								Search
							</button>
						</form>
					</div>

					@if ($categories->isEmpty() && !isset($pages))
						<h1 class="mt-5 mb-2 text-center">No Reference Categories</h1>
					@endif
					@if ($categories->isEmpty() && (isset($pages) && $pages->isEmpty()))
						<h1 class="mt-5 mb-2 text-center">No results found</h1>
					@endif
					<!-- TOP -->

					@foreach ($categories as $category)
						<div class="w-100 my-1 accordion" id="accordionExample{{ $loop->iteration }}">
							<div class="accordion-item overflow-auto">

								<div class="bg-white ">
									<h2 class="accordion-header d-flex align-items-center justify-content-center"
										id="heading{{ $loop->iteration }}">
										<button class="accordion-button shadow-none" type="button" data-bs-toggle="collapse"
											data-bs-target="#collapse{{ $loop->iteration }}"
											aria-expanded="@if($loop->first) true @else false @endif"
											aria-controls="collapse{{ $loop->iteration }}">
											{{ $loop->iteration }}. {{ $category->name }}
										</button>
										<div class="p-2 d-flex gap-1 align-items-center justify-content-center">
											<a href="{{ route('reference.category.edit', $category->id) }}"
												class="btn btn-sm btn-primary">
												Edit
											</a>
											<form class="d-flex justify-content-center align-items-center"
												action="{{ route('reference.category.delete', $category->id) }}" method="POST">
												@csrf
												<button class="btn btn-danger btn-sm"
													onClick="return confirm('Are you sure want to delete this?')">Delete</button>
											</form>
										</div>
									</h2>
								</div>
								<!--  -->
								<div id="collapse{{ $loop->iteration }}"
									class="accordion-collapse collapse @if($loop->first) show @endif"
									aria-labelledby="heading{{ $loop->iteration }}"
									data-bs-parent="#accordionExample{{ $loop->iteration }}">
									<div class="accordion-body">
										<div class="my-4">
											<strong>{{ $category->description }}</strong>
										</div>
										<div>
											<table class="table table-bordered">
												<thead>
													<tr>
														<th>No.</th>
														<th class="w-25">Image</th>
														<th>Topic Title</th>
														<th class="w-35">Details</th>
														<th>Reference Page</th>
														<th>Action</th>
													</tr>
												</thead>
												@foreach ($category->refCategoryRelationWith_pages as $page)
													<tbody class="w-100 bg-white">
														<tr>
															<td>{{ $loop->iteration }}</td>
															<td class="w-25">
																@if($page->img_id !== 'N/A')
																		<img src="{{ asset('storage/' . $page->path) }}" class="img-thumbnail">
																		<span class="w-10 text-wrap" style="width: 60px; font-size:10px;"><b>Image ID:
																			</b>{{ $page->img_id }}
																	</td>
																@else
																<span>No Image Uploaded</span>
															@endif
															</td>
															<td>{{ $page->title }}</td>
															<td class="w-35" style="min-width: 200px;">{{ $page->details }}</td>
															<td>{{ $page->ref_pdf_page }}</td>
															<td class="d-flex justify-content-center align-items-center gap-2">
																<a href="{{ route('reference.content.edit', $page->id) }}"
																	class="btn btn-primary btn-sm">Edit</a>
																<form action="{{ route('reference.content.delete', $page->id) }}"
																	method="POST">
																	@csrf
																	<button onClick="return confirm('Are you sure want to delete this?')"
																		class="btn btn-danger btn-sm">
																		Delete
																	</button>

																</form>
															</td>
														</tr>
													</tbody>
												@endforeach
											</table>
										</div>
									</div>
								</div>
							</div>

						</div>
					@endforeach
				</div>

			</div> <!-- content -->

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