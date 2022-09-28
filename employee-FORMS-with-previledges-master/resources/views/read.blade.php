@include('header');
<div class="container">
    <div class="row">
        <legend>read article</legend>
        <p class="lead">{{ $articles->title }}</p>
       <div> <p> {{ $articles->description }}</p></div>
    </div>
</div>

@include('footer');