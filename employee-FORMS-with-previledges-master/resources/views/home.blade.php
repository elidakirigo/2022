
@include('header')

<div class="container">
  <div class="row">
  <legend>laravel CRUD Application</legend>
  <div class="row">
  @if(session('info'))
    <div class="alert alert-success"> {{ session('info') }} </div> 
    @endif
  </div>
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th scope="col">ID</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
      @if( count($articles) > 0 )
        @foreach( $articles -> all() as $article )

        <tr class="active">
          <td>{{ $article->id }}</td>
          <td>{{ $article->title }}</td>
          <td>{{ $article->description }}</td>
          <td><a href='{{ url("/read/{$article->id}") }}' class="label label-primary"> read </a> |</td>
          <td><a href='{{ url("/update/{$article->id}") }}' class="label label-success"> Update </a> |</td>
          <td><a href='{{ url("/delete/{$article->id}") }}' class="label label-danger"> Delete  </a> |</td>
        </tr>

        @endforeach
      @endif
      </tbody>
    </table>
  </div>
</div>

@include('footer')

