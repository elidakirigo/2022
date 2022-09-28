@include('header')

<div class="container">
    <div class="row">
        <div class="col-md-6">
            <form action="{{ url('/edit', array( $articles->id )) }}" method="POST" role="form">
            {{ csrf_field()}}
            <legend>laravel CRUD Application</legend>
            @if(count($errors) > 0 )
                @foreach($errors->all() as $error )
                    <div class="alert alert-danger">
                        {{ $error }}
                    </div>
                @endforeach
            @endif
                <div class="form-group">
                    <label for="">title</label>
                    <div class="col-md-10">
                        <input type="text" name="title" value="<?php echo $articles->title ?>" class="form-control" id="" placeholder="title">
                    </div>
                </div>
                <div class="form-group">
                    <label for="">description</label>
                    <div class="col-md-10">
                        <textarea placeholder="description" class="form-control" name="description" id="" cols="30" rows="10"><?php echo $articles->description ?></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                    <!-- <button type="reset" class="btn btn-default">Cancel</button> -->
                    <button type="submit" class="btn btn-primary">update</button>
                    <a href="{{ url('/') }} " class="btn btn-primary">back</a>
                    </div>
                   
                </div>
                
            </form>
            
        </div>
    </div>
</div>