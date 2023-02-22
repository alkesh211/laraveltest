<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Test</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" >
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
    
</head>
<body>
    <div class="container mt-2">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2>Test</h2>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-success" href="{{ route('items.create') }}"> Create Item</a>
                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Check Process</th>
                    <th>Item Name</th>                    
                    <th width="280px">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($items as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>
                        <div class="form-check">
                            <input name="selector[]" class="form-check-input" type="checkbox" value="{{ $item->id }}" id="flexCheckDefault" name="item"/>
                            <label class="form-check-label" for="flexCheckDefault">{{ $item->name }}</label>
                        </div>
                        </td>
                        <td>{{ $item->name }}</td>                        
                        <td>
                            <form action="{{ route('items.destroy',$item->id) }}" method="Post">
                                <a class="btn btn-primary" href="{{ route('items.edit',$item->id) }}">Edit</a>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
            </tbody>
        </table>
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-right mb-2">
                    <a class="btn btn-primary" id="next"> Next</a>
                </div>
            </div>
        </div>
        {!! $items->links() !!}
    </div>
    <script>
        $(document).ready(function(){
            $('#next').on('click', function () {
                var all_location_id = document.querySelectorAll('input[name="selector[]"]:checked');
                var aIds = [];
                for(var x = 0, l = all_location_id.length; x < l;  x++)
                {
                    aIds.push(all_location_id[x].value);
                }
                var str = aIds.join(', ');
                console.log(str);
                $.ajax({
                    type: 'POST',
                    url: "{{ route('next.del') }}",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        id: str,
                    },
                    success: function(data) {
                        if(data.status !== undefined){
                            location.reload();
                        }else{
                            $('#error_msg').html("Unable to send OTP on your number.");
                        }
                    }
                });
            })
        })
    </script>
</body>
</html>
