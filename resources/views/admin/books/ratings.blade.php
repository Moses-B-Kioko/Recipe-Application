@extends('admin.layouts.app')

@section('content')
<!--<section class="section-5 pt-3 pb-3 mb-3 bg-white">
    <div class="container">
        <div class="light-font">
            <ol class="breadcrumb primary-color mb-0">
                <li class="breadcrumb-item"><a class="white-text" href="#">My Account</a></li>
                <li class="breadcrumb-item">Settings</li>
            </ol>
        </div>
    </div>
</section>-->

<section class="section-11">
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar Column 
            <div class="col-md-3 pt-3 pb-3 mb-3">
                @include('front.account.common.sidebar') 
            </div> -->

            <!-- Main Content Column -->
            <div class="col-md-12">
                <!-- Content Header -->
                <section class="content-header">
                    <div class="my-2">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Ratings</h1>
                            </div>
                            <div class="col-sm-6 text-right">
                                <form action="" method="get" class="d-flex justify-content-end">
                                    <button type="button" onClick="window.location.href='{{ route("books.bookRatings")}}'" class="btn btn-default btn-sm me-2">Reset</button>

                                    <div class="input-group" style="width: 250px; margin-right: 10px;">
                                        <input value="{{ Request::get('keyword') }}" type="text" name="keyword" class="form-control" placeholder="Search">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!--<a href="{{ route('books.create')}}" class="btn btn-primary">New Book</a>-->
                                </form>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Main Content -->
                <section class="content">
                    <div class="card">
                    @include('admin.message')
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="60">ID</th>
                                        <th>Book</th>
                                        <th>Rating</th>
                                        <th>Comment</th>
                                        <th>Rated by</th>
                                        <!--<th>SKU</th>-->
                                        <th width="100">Status</th>
                                        <!--<th width="100">Action</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                   @if ($ratings->isNotEmpty())
                                        @foreach ($ratings as $rating)
                                        <tr>
                                        <td>{{ $rating->id }}</td>
                                        <td>{{ $rating->bookTitle }}</td>
                                        <td>{{ $rating->rating}}</td>
                                        <td>{{ $rating->comment}}</td>
                                        <td>{{ $rating->username}}</td>
                                        <td>
                                            @if ($rating->status == 1)
                                            <a href="javascript:void(0);" onclick="changeStatus(0,'{{ $rating->id }}');">                                            <svg style="width: 16px; height: 16px;" class="text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            </a>
                                            @else
                                            <a href="javascript:void(0);" onclick="changeStatus(0,'{{ $rating->id }}');">                                            <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            </a>
                                            @endif
                                        </td>      
                                    </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td>Records Not Found</td>
                                    </tr>
                                    @endif 
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer clearfix">
                            {{ $ratings->links() }}
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
@endsection

@section('customJs')
<script>
	function deleteBook(id){
        
		var url = '{{ route("books.delete", "ID") }}';
		var newUrl = url.replace("ID", id)
		
		if (confirm("Are you sure you want to delete")){
			$.ajax({
				url: newUrl,
				type: 'delete',
				data: {},
				dataType: 'json',
				success: function(response) {
					if(response["status"] == true){
						window.location.href="{{ route('books.index')}}";
					} else {
                        window.location.href="{{ route('books.index')}}";
                    }
				}
		});
		} 
	}

    function changeStatus(status, id) {
        if (confirm("Are you sure you want to change status")){
			$.ajax({
				url: '{{ route("books.changeRatingStatus") }}',
				type: 'get',
				data: {status:status, id:id},
				dataType: 'json',
				success: function(response) {
						window.location.href="{{ route('books.bookRatings')}}";
					
				}
		});
		} 
    }

</script>
@endsection
