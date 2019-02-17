@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-md-12 centered">
            <h3>Receiving</h3>
            <div class="card">
                <div class="card-header">
                    New Receipt
                </div>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <form>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="categoryId">Category:</label>
                                    <select class="form-control" name="categoryId" id="categoryId">
                                        <option value="">Choose Category</option>
                                        {{-- List added from AJAX --}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="itemId">Item:</label>
                                    <select class="form-control" name="itemId" id="itemId">
                                        <option value="">Choose Item</option>
                                        {{-- List added from AJAX --}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="from">From:</label>
                                    <input type="text" placeholder="Enter Supplier" id="from" name="from" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="to">Warehouse:</label>
                                    <input type="text" class="form-control" id="warehouse" name="warehouse">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="to">Date:</label>
                                    <input type="date" class="form-control" id="date" name="date" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="receiveQty">Receiving Quantity:</label>
                                    <input type="number" class="form-control" id="receiveQty" name="receiveQty" placeholder="Qty">
                                </div>
                            </div>

                        </div>
                        {{-- card footer --}}
                        <div class="card-footer text-right">
                            <button class="btn btn-success" id="addToList" name="addToList">Add to Receipt List</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card hidden" id="receiptList">
                <div class="card-header">
                    Receipt List
                </div>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Item</th>
                                <th>Category</th>
                                <th>From</th>
                                <th>Warehouse</th>
                                <th>Date</th>
                                <th>Qty</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="list">

                        </tbody>
                    </table>
                </div>
                <div class="card-footer text-right">
                    <button class="btn btn-success" id="receiveBtn" name="ReceiveBtn">Add to Received Items</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(()=>{
        //select 2
        $('#itemId').select2()
        $('#categoryId').select2()

        //getCategories
        getCategories()

        //getSpecificItems
        getItems()

        //add to receipt list
        let i = 1
        $('#addToList').on('click',(e)=>{
            //list function
                e.preventDefault()
                const itemId = $('#itemId').val()
                const categoryId = $('#categoryId').val()
                const receiveQty = $('#receiveQty').val()
                const from = $('#from').val()
                const to = $('#to').val()
                const date = $('#date').val()
                if(!categoryId || !itemId || !from || !receiveQty || !to || !date) {
                    alert ('Fill the from completely')
                }
                else {
                    $('#receiptList').removeClass('hidden')
                    $('#list').append('<tr>'
                                    +'<td>'
                                    +i
                                    +'</td>'
                                    +'<td>'
                                    +'<input type="text" class="hidden" value="'+ itemId +'" >'
                                    +$('#itemId option:selected').text()
                                    +'</td>'
                                    +'<td>'
                                    +'<input type="text" class="hidden" value="'+ categoryId +'">'
                                    +$('#categoryId option:selected').text()
                                    +'</td>'
                                    +'<td>'
                                    +from
                                    +'</td>'
                                    +'<td>'
                                    +warehouse
                                    +'</td>'
                                    +'<td>'
                                    +date
                                    +'</td>'
                                    +'<td>'
                                    +receiveQty
                                    +'</td>'
                                    +'<td>'
                                    + '<button class="btn btn-danger"><i class="fas fa-times"></i></button>'
                                    +'</td>'
                                    +'</tr>'
                                    )
                                 i++
                    $('#itemId, #categoryId, #from, #receiveQty, #to, #date').val('')
                }


        })
    })
    // getItems function
    function getCategories() {

        axios.get('/getCategories')
        .then((response)=>{
           const categories = response.data.categories
           for(let i = 0; i < categories.length; i++) {
               $('#categoryId').append(
                   '<option value='+ categories[i].id +'>'
                    +categories[i].name
                    +'</option>'
               )
           }
        })
    }

    // get specific items by categoryId
    function getItems() {
       $('#categoryId').on('change', ()=> {
            $('#itemId option').remove()
           const categoryId = $('#categoryId').val()
           axios.get('/getItems/'+categoryId)
           .then((response)=>{
               console.log(response);
               const items = response.data.items
               for(let i = 0; i < items.length; i++) {
                    $('#itemId').append(
                        '<option value='+ items[i].id +'>'
                            +items[i].name
                            +'</option>'
                    )
           }
           })
           .catch((error)=>{
               console.log(error);

           })


       })
    }
    //add to list function

</script>
@endsection
