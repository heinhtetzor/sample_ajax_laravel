@extends('layouts.app')

@section('style')
<style>

</style>
@endsection

@section('content')
   <div class="container" id="app">
        <div class="centered">
        	<h3>Item Management</h3>
					<form>
						<div class="row">
							
								<label for="name" class="col-md-2">Add New Item </label>
							
							<div class="col-md-2">
								<input type="text" class="form-control" name="name" id="name" placeholder="Enter Item Name">
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
								<input type="number" class="form-control" id="quantity" name="quantity" value="0" >
							</div>
							<div class="col-md-2">
								<button class="btn btn-success btn-block" id="addItemBtn">Add</button>
							</div>
						</div>
					</form>
        <table class="table table-dark table-sm" id="itemTable">
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
					<tr id="item{{ $item->id }}">
        				<td>{{ $i+1 }}</td>
        				<td>{{ $item->name }}</td>
        				<td>{{ $item->category['name'] }}</td>
        				<td>{{ $item->price }}</td>
        				<td>{{ $item->quantity }}</td>
        				<td>
						<a class="btn btn-info" data-toggle='modal' data-id='{{ $item->id }}' data-name='{{ $item->name }}' data-category_id='{{ $item->category_id }}' data-price='{{ $item->price }}' data-target='#editModal'><i class="fas fa-edit"></i></a>
							<a class='btn btn-danger' data-toggle='modal' data-id='{{ $item->id }}' data-name='{{ $item->name }}' data-target='#deleteModal'><i class="fas fa-trash"></i></a>
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
				<p id="error"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

{{-- Edit Modal --}}
<!--    Modal for edit form-->
<div id="editModal" class="modal" tabindex="-1" role="dialog">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Edit Item</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
				
					<form>
							<input type="hidden" id="editItemId" value="" name="editItemId">
				
								<div class="form-group row">
										<label for="itemId" class="col-lg-3 col-form-label">Item Name</label>
										<input type="text" class="form-control col-lg-8" id="editName" name="editName" value="">
									</div>
									<div class="form-group row">
										<label class="col-lg-3 col-form-label" for="editPrice">Price</label>
										<input type="text" class="form-control  col-lg-8" id="editPrice" name="editPrice" value="">
									</div>
									<div class="form-group row">
										<label  class="col-lg-3 col-form-label" for="editCategoryId">Category Name</label>
										<select name="editCategoryId" id="editCategoryId" class="form-control  col-lg-8">
											<option value=""></option>
										</select>
									</div>
										<div class="hidden alert alert-danger" id="editError">
												
										</div>
					         
				
			
				</div>
				<div class="modal-footer">
					<button type="button" id="editItemBtn" class="btn btn-primary">Save changes</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
			</form>
			</div>
		</div>
	</div>
<!--Delete modal-->
<div id="deleteModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Are you Sure?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <input id="itemId" type="hidden" disabled value="">
        <p id="nameDelete"></p>
      </div>
      <div class="modal-footer">
        <button id="deleteItemBtn" type="button" class="btn btn-primary">Yes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
      </div>
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
			//when shown delete Modal
			$('#deleteModal').on('shown.bs.modal', (e) => {
				const itemId = $(e.relatedTarget).data('id')
				const itemName = $(e.relatedTarget).data('name')

				$('#nameDelete').text('DELETE '+itemName+'?')
				$('#itemId').val(itemId)
			})
				//onclick delete button
				$('#deleteItemBtn').click(()=>{
						deleteItem()
			})
			//when shown edit modal
			$('#editModal').on('shown.bs.modal', (e) => {
				const itemId = $(e.relatedTarget).data('id')
				const name = $(e.relatedTarget).data('name')
				const categoryId = $(e.relatedTarget).data('category_id')
				const price = $(e.relatedTarget).data('price')
				const quantity = $(e.relatedTarget).data('quantity')

				$('#editName').val(name)
				$('#editItemId').val(itemId)
				$('#editPrice').val(price)
				
				axios.get('getCategories')
				.then((response)=>{
					// console.log(response.data.categories)
					const categories = response.data.categories
					for(let i = 0; i < categories.length; i++) {
						$('#editCategoryId').append('<option value=' + categories[i].id 
        										+ (categories[i].id == categoryId? ' selected' : '') + '>' 
        										+ categories[i].name + '</option>')					
														}
				})
				.catch((error)=>{
					console.log(error)
				})	
			})


			//click update button
			$('#editItemBtn').click(()=>{
					updateItem()
				})
		
		
		})
		//Update item function
		function updateItem(e) {

			const editName = $('#editName').val()
					const editCategoryId = $('#editCategoryId').val()
					const editPrice = $('#editPrice').val()
					const editItemId = $('#editItemId').val()
					const editQuantity = $('#editQuantity').val()

					axios.put('items/'+editItemId, {
						_token : $("input[name=_token]").val(),
						name: editName,
						category_id: editCategoryId,
						price: editPrice,
						quantity: editQuantity
					})
					.then((response)=>{
						// console.log(response)
						const itemData = response.data.item[0]
						console.log(itemData);
		
						$('#item'+itemData.id).replaceWith('<tr id="item'+ itemData.id +'">'
																								+'<td style="139px">'
																								+'<div class="badge badge-success">Update</div>'
																								+'</td>'
																								+'<td>'
																								+itemData.name
																								+'</td>'
																								+'<td>'
																								+itemData.category.name
																								+'</td>'
																								+'<td>'
																								+itemData.price
																								+'</td>'
																								+'<td>'
																								+itemData.quantity
																								+'</td>'
																								+'<td>'
																								+'<a>'
																								+'</a>'
																								+'<a class="btn btn-info" data-toggle="modal" data-target="#editModal" data-id="'+itemData.id+'" data-name="'+itemData.name+'" data-category_id="'+itemData.category_id+'" data-price="'+itemData.price+'">'
																								+'<i class="fas fa-edit"></i>'
																								+'</a>'
																								+'<a class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" data-id="'+itemData.id+'" data-name="'+itemData.name+'" >'
																								+'<i class="fas fa-trash"></i>'
																								+'</a>'
																								+'</td>'
																								+'</tr>'	
							)
							$('#editModal').modal('hide')
					})
					.catch((error)=>{
						console.log(error)
					})
		}
		//Add Item function
		function addItem(e) {
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
				// console.log(response.data.errors)
				if(response.data.errors) {
					const error = response.data.errors
				
					if(error.name) {
						$('.modal-body #error').text(error.name)
					}
					else if (error.price) {
						$('.modal-body #error').text(error.price)
					}
					else if (error.category_id) {
						$('.modal-body #error').text('Choose a category')
					}
					else if(error.quantity) {
						$('.modal-body #error').text(error.quantity)
					}
				
					
					$('#errorModal').modal('show')
					//getting count of error object in ES6 way
					// errLength = Object.keys(error).length
					//loopin the error messages
					// for (let err in error.name) {
					// 	console.log(error.name[err]);
					// }
					
				}
				else {
					NProgress.start()
					NProgress.done() 
					const item = response.data.item[0]
					console.log(item)

					//clear form
					$('#name, #price, #category_id').val('')
					$('#name').focus()


					$('#itemTable').prepend("<tr id=item"+ item.id +">"+
						"<td width='130px'><span class='badge badge-success'>New</span></td>"+
        				"<td>" + item.name + "</td>"+
        				"<td>" + item.category.name + "</td>"+
        				"<td>" + item.price + "</td>"+
        				"<td>" + item.quantity + "</td>"+
						
						"<td>"+
						"<a class='btn btn-info' data-toggle='modal' data-id='"+ item.id +"' data-name='"+ item.name +"' data-category='"+ item.category_id +"' data-price='"+ item.price +"' data-target='#editModal'><i class='fas fa-edit'></i></a>"+
						"<a class='btn btn-danger' data-toggle='modal' data-id='"+ item.id +"' data-name='"+ item.name +"' data-target='#deleteModal'><i class='fas fa-trash'></i></a>"+
        				"</td>")
					 "</tr>"
				}
			})
			.catch((error)=>{
				console.log(error)
			})
		}
		//Delete Item function
		function deleteItem() {
			const itemId = $('#itemId').val()
			axios.delete('items/'+itemId)
			.then((response)=>{
				console.log(response.data.message)
				$('#deleteModal').modal('hide')
				NProgress.start()
				NProgress.done()

				$('#item'+itemId).remove()
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