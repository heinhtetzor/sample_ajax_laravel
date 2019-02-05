@extends('layouts.app')

@section('style')
<style>

</style>
@endsection

@section('content')
   <div class="container" id="app">
        <div class="col-md-12 centered">
        	<h3>Item Management</h3>
        	<form>
            <div class="form-group row">
                <label for="name" class="col-md-2 col-form-label">Add new Item</label>
                <div class="col-md-2" >
                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter Item Name">
                    
                    <div class="hidden alert alert-danger" id="error">
                        
                    </div>
                </div>
                <div class="col-md-2">
                	<select name="category_id" id="category_id" class="form-control">
                		<option value="">Select Category</option>
                	</select>
                </div>
                <div class="col-md-2">
                	<input type="number" class="form-control" id="price" name="price" placeholder="Enter Price">
                </div>
                <div class="col-md-2">
                	<input type="number" class="form-control" id="quantity" name="quantity" value="0" ">
                </div>
          
                <div class="col-lg-2">
                    <button class="btn btn-success" id="addItemBtn">Add</button>
                </div>  
            </div>
            
        </form>

        <table class="table table-dark table-sm">
        	<thead>
        		<tr>
	        		<th>No</th>
	        		<th>Name</th>
	        		<th>Category</th>
	        		<th>Price</th>
	        		<th>Quantity</th>
	        		<th>Actions</th>
        		</tr>
        	</thead>
        	<tbody>
        		@foreach($items as $i=>$item)
        			<tr>
        				<td>{{ $i+1 }}</td>
        				<td>{{ $item->name }}</td>
        				<td>{{ $item->category['name'] }}</td>
        				<td>{{ $item->price }}</td>
        				<td>{{ $item->quantity }}</td>
        				<td>
        					<a class="btn btn-info" data-toggle='modal' data-id='' data-name='' data-category='' data-price='' data-quantity='' data-target='#editModal'><i class="fas fa-edit"></i></a>
							<a class='btn btn-danger' data-toggle='modal' data-id='' data-name='' data-target='#deleteModal'><i class="fas fa-trash"></i></a>
        				</td>
        			</tr>
        		@endforeach
        	</tbody>
        </table>
        </div>
   </div>

   {{-- error modal --}}
 <div class="modal" tabindex="-1" role="dialog" id="errorModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Error</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
   
@endsection

@section('script')
	<script>
		$(document).ready(()=>{
			$('#name').focus()
			//select2 enable
			$('#category_id').select2()
			//get categories for select2
			getCategories()
			//add Item to database
			$('#addItemBtn').click((e)=>{
				e.preventDefault()

				addItem()
			})
		})

		function addItem() {
			const name = $('#name').val()
			const category_id = $('#category_id').val()
			const price = $('#price').val()
			const quantity = $('#quantity').val()

			axios.post('items', {
				name: name,
				category_id: category_id,
				price: price,
				quantity: quantity
			})
			.then((response)=>{
				console.log(response.data.errors)
				if(response.data.errors) {
					const error = response.data.errors
					$('#errorModal').modal('show')
					
					$('.modal-body').html('<div class="alert alert-danger">'+ error.name +'</div>'+
											'<div class="alert alert-danger">'+ error.category_id +'</div>'+
											'<div class="alert alert-danger">'+ error.price +'</div>')
					
				}
				else {
					NProgress.start()
					NProgress.done()
				}
			})
			.catch((error)=>{
				console.log(error)
			})
		}

		function getCategories() {
				axios.get('getCategories')
				.then((response)=>{
					// console.log(response.data.categories)
					const categories = response.data.categories
					for(let i = 0; i < categories.length; i++) {
						$('#category_id').append('<option value="'+ categories[i].id +'">'+ categories[i].name +'</option>')
					}
				})
				.catch((error)=>{
					console.log(error)
				})	
			}
	</script>
@endsection