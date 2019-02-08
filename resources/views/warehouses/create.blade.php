@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="col-md-12 centered">
            <h3>Create New Warehouse</h3>
            <div class="card">
                <div class="card-header">
                    New
                </div>
                <div class="card-body">
                    <h6 class="card-title">
                    </h6>
                    <div class="card-body">
                        <form action="{{ url('/warehouses') }}" method="post">
                        @csrf
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input class="form-control" type="text" name="name" id="name" placeholder="Enter Name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Address Line 1</label>
                                        <input class="form-control" type="text" name="address1" id="address1" placeholder="Enter Address">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Address Line 2</label>
                                        <input class="form-control" type="text" name="address2" id="address2" placeholder="Enter Address">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="location">Choose on Map</label>
                                        <div id='map' style='width: 100%; height: 300px;'></div>
                                        <input type="hidden" value="" id="long" name="long">
                                        <input type="hidden" value="" id="lat" name="lat">
                                    </div>
                                </div>
                            </div>
                    
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-success" id="create">Submit</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

<script>
    mapboxgl.accessToken = 'pk.eyJ1IjoiaGh6b3IiLCJhIjoiY2pydnI1aHEzMDR6czRhbnJzb3hka3ZmZCJ9.EDCXTEX1I-oHYDXoL4vgWA';
    var map = new mapboxgl.Map({
        container: 'map',
        style: 'mapbox://styles/mapbox/dark-v9',
        center: [96.1951, 16.8661],
        zoom: 15
        });
    //map marker
    var marker = new mapboxgl.Marker({
        draggable: true
        })
        .setLngLat([96.1951, 16.8661])
        .addTo(map);
        
        function onDragEnd() {
        var lngLat = marker.getLngLat();

        long.value = lngLat.lng;
        lat.value = lngLat.lat;
        }
        marker.on('dragend', onDragEnd);

        $(document).ready(()=>{
            $('#name').focus()
        })
    
</script>
@endsection