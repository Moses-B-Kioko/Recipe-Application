@extends('admin.layouts.app')

@section('content')


<section class="section-11">
    <div class="container-fluid">
        <div class="row">
           

            <!-- Main Content Column -->
            <div class="col-md-12">
                <!-- Content Header -->
                <section class="content-header">
                    <div class="my-2">
                        <div class="row mb-2">
                            <div class="col-sm-6">
                                <h1>Books</h1>
                            </div>
                            <div class="col-sm-6 text-right">
                                <form action="" method="get" class="d-flex justify-content-end">
                                    <button type="button" onClick="window.location.href='{{ route("books.index")}}'" class="btn btn-default btn-sm me-2">Reset</button>

                                    <div class="input-group" style="width: 250px; margin-right: 10px;">
                                        <input value="{{ Request::get('keyword') }}" type="text" name="keyword" class="form-control" placeholder="Search">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>

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
                                        <th width="80">Image</th>
                                        <th>Book</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <!--<th>SKU</th>-->
                                        <th width="100">Status</th>
                                        <!--<th width="100">Action</th>-->
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($books->isNotEmpty())
                                        @foreach ($books as $book)
                                        @php
                                            $bookImage = $book->book_images->first();
                                        @endphp
                                        <tr>
                                        <td>{{ $book->id }}</td>
                                        <td>
                                          @if (!empty($bookImage->image))  
                                          <img src="{{ asset('./uploads/book/small/'.$bookImage->image)}}" class="img-thumbnail" width="50">
                                          @else 
                                          <img src="{{ asset('admin-assets/img/default-150x150.png')}}" class="img-thumbnail" width="50"/>
                                          @endif
                                        </td>
                                        <td><a href="#">{{ $book->title }}</a></td>
                                        <td>Ksh.{{ $book->price}}</td>
                                        <td>{{ $book->qty}} left in Stock</td>
                                        <!--<td>UGG-BB-PUR-0</td>-->
                                        <td>
                                            @if ($book->status == 1)
                                            <svg style="width: 16px; height: 16px;" class="text-success" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            @else
                                            <svg class="text-danger h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
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
                            {{ $books->links() }}
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
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

</script>
@endsection
