  <table class="table table-bordered table-striped table-hover text-center">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Father Name</th>
                <th>Contact</th>
            </tr>
        </thead>
        <tbody>
              @foreach ($results as $index=> $result)
                  
             
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $result->name }}</td>
                    <td>{{ $result->father_name }}</td>
                    <td>{{ $result->contact }}</td>
                    <td><a href="{{route('form.edit',$result->id)}}">Edit</a></td>
                    <td><a href="{{route('form.delete',$result->id)}}">Delete</a></td>
                </tr>
            @endforeach
               
           
        </tbody>
    </table>