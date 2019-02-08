@extends('layouts.app')

@section('style')
<style>
   
</style>
@endsection
   
@section('content')
    <div class="container">
        
    
    <div class="col-md-12 centered">
        <h3>Categories Management</h3>
        <form>
            <div class="form-group row">
                <label for="name" class="col-lg-2 col-form-label">Add new Category</label>
                <div class="col-lg-8" >
                    <input type="text" class="form-control" id="name" placeholder="Enter Category Name">
                    
                    <div class="hidden alert alert-danger" id="error">
                        
                    </div>
                </div>
                <div class="col-lg-2">
                    <button class="btn btn-success" id="addCategoryBtn" >Add</button>
                </div>  
            </div>
            
        </form>

        <table class="table table-dark table-sm" id="catTable">
            <thead>
                <th>No</th>
                <th>Category</th>
                <th>Actions</th>
            </thead>
            <tbody>
                @foreach ($categories as $i => $category)
                    <tr id="category{{ $category->id }}">
                        <td>{{ $i+1 }}</td>
                        <td>{{ $category->name }}</td>
                    <td>
                        <a data-toggle ="modal" data-target = "#editModal" class="editModal btn btn-info"  data-id="{{ $category->id }}" data-name="{{ $category->name }}"><i class="far fa-edit"></i></a>
                        <a data-toggle="modal" data-target="#deleteModal" data-id="{{ $category->id }}" data-name="{{ $category->name }}" class="deleteModal btn btn-danger"><i class="fas fa-trash"></i></a>
                    </td>
                    </tr>
               
                @endforeach
            </tbody>
        </table>
    </div>
    

<!--    Modal for edit form-->
<div id="editModal" class="modal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      
            <div class="form-group row">
                <label for="name" class="col-lg-2 col-form-label">Category</label>
                <div class="col-lg-8" >
              
                    <input type="hidden" id="catId" value="">
                    <input type="text" class="form-control" id="nameEdit" placeholder="Enter Category Name" value="">
                    <div class="hidden alert alert-danger" id="error">
                        
                    </div>
                </div>          
            </div>
    
      </div>
      <div class="modal-footer">
        <button type="button" id="editCategoryBtn" class="btn btn-primary">Save changes</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
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
          <input id="catId" type="hidden" disabled value="">
        <p id="nameDelete"></p>
      </div>
      <div class="modal-footer">
        <button id="deleteCategoryBtn" type="button" class="btn btn-primary">Yes</button>
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
            $('#name').keyup(()=>{
                $('#addCategoryBtn').removeClass('hidden')
            })

            $('#addCategoryBtn').click((e)=>{
                const name = $('#name').val()
                axios.post('categories', {
                    name : name
                })
                .then((response)=>{
                    const error = response.data.errors
                        if(response.data.errors) {
                            $('#error').removeClass('hidden')
                            $('#error').text (error.name)
                            
                        }
                        else {
                            $('#error').addClass('hidden')
                            const category = response.data.category
                            
                            $("#name").val("")
                            $("#name").focus()
                            
                            NProgress.start()
                            NProgress.done()
                            
                            $('#catTable').prepend("<tr id='category"+category.id+"'>"+
                                "<td width='139px'><span class='badge badge-success'>New</span></td>"+
                                "<td>"+category.name+"</td>"+
                                "<td> <a data-toggle ='modal' data-target = '#editModal' class='btn btn-info editModal' data-id = '"+ category.id +"' data-name = '"+ category.name +"'><i class='far fa-edit'></i></a>"+
                                "<a data-toggle='modal' data-target='#deleteModal' data-id='"+ category.id +"' data-name='"+ category.name +"' class='btn btn-danger'><i class='fas fa-trash'></i></a>"+
                                "</td>")
                            
                           
                        }
                    
                })

                e.preventDefault()
            })
            
            //edit Form
            $("#editModal").on("shown.bs.modal", (e)=>{
                const catName = $(e.relatedTarget).data('name')
                const catId = $(e.relatedTarget).data('id')
//                console.log(catName)
                $(".modal-title").text("Edit Category")
                $("#nameEdit").val(catName)
                $("#catId").val(catId)
            
            })
            //delete Form
            $("#deleteModal").on("shown.bs.modal", (e)=>{
                const catName = $(e.relatedTarget).data('name')
                const catId = $(e.relatedTarget).data('id')
                $("#nameDelete").text("DELETE "+catName+"?")                     
                $("#catId").val(catId)                     
            })  
            //update Action
            $("#editCategoryBtn").click((e)=>{
                const id = $("#catId").val()
                const name = $("#nameEdit").val()
                const _token =  $("input[name=_token]").val()
                e.preventDefault()
                axios.put('categories/'+id ,  {
                    _token : _token,
                    name: name
                    
                })
                .then((response)=>{
                    const category = response.data.category
                    $('#error').addClass('hidden')
                    NProgress.start()
                    NProgress.done()
                    
                   $("#category"+id).replaceWith("<tr id='category"+category.id+"'>"+
                                                 "<td width='139px'><span class='badge badge-success'>Update</span></td>"+
                                                 "<td>"+category.name+"</td>"+
                                                 "<td> <a data-toggle ='modal' data-target = '#editModal' class='btn btn-info editModal' data-id = '"+ category.id +"' data-name = '"+ category.name +"'><i class='far fa-edit'></i></a>"+
                                                "<a data-toggle='modal' data-target='#deleteModal' data-id='"+ category.id +"' data-name='"+ category.name +"' class='btn btn-danger'><i class='fas fa-trash'></i></a>"+
                                                "</td>"+
                                                 "<tr/>")
                    $("#editModal").modal("hide")
                })
            })
            //delete Action
            $("#deleteCategoryBtn").click(()=>{
                const id = $("#catId").val()
                axios.delete('categories/'+id)
                .then((response)=>{
                    $("#deleteModal").modal("hide")
                    
                    NProgress.start()
                    NProgress.done()
                    
                    $("#category"+id).remove()
                })
                
            })
            
           
        })
            
 

    </script>
    <script>
        // $(document).ready(function() {
        //     loadCategories()
            
        //     $('#edit').click(function(){
        //         //post id to laravel 
        //         //make ajax call to laravel edit
        //         //return data of respective id
        //         //show data + id in modal 
        //         //save()
        //         $('#editModal').modal('show')
        //     })

        //     $('#name').keyup(function(){
        //         $('#addCategoryBtn').removeClass('hidden')
   
        //     })  

        //     //loadCategories
        //     function loadCategories() {
        //         $.ajaxSetup({
        //             headers: {
        //                 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        //             }
        //         })
        //         $.ajax({
        //             url: "/categories/load",
        //             type: 'POST',
        //             data: {},
        //             success: function(data){
        //                 console.log(data)
        //                 $.each(data, function(index, category){
        //                     var indexAt1 = index+1
        //                     $("#catTable").find("tbody")
        //                     .append("<tr><td>"+indexAt1+"</td><td>"+category.name+"</td><td><button id='edit' class='btn btn-info'><i class='fas fa-edit'></i></button></td></tr>")
        //                 })
        //             }
        //         })
             
        //     }

        //     //click addCategoryBtn event
        //     $('#addCategoryBtn').click(function(e){
        //         e.preventDefault();
        //         $.ajaxSetup({
        //             headers: {
        //                 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        //             }
        //         })
        //         $.ajax({
        //             url: "/categories",
        //             type: 'POST',
        //             data: {
        //                 name: $('#name').val()
        //             },
        //             success: function(data){
        //                 //check if there is any error
        //                 if(data.errors)
        //                 {   
        //                     $("#error")
        //                     .removeClass('hidden')
        //                     .html("<div class='badge badge-danger'>"+data.errors.name+"</div>")
                            
        //                 }
        //                 else
        //                 {
        //                     $("input[type=text]").val("")
        //                     // console.log(data)
                            
        //                     $("#catTable").find("tbody")
        //                     .prepend("<tr><td><div class='badge badge-success'>New</div></td><td>"+data.name+"</td><td></td></tr>")

        //                 }
                        
        //             }
        //         })
        //     })
        // })
    </script>
@endsection