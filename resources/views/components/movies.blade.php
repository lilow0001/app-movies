<style>
  .card{
    width: 200px;
    min-width: 200px;
}
.row{
  display: grid;
    grid-template-columns: repeat(auto-fill,minmax(200px, 1fr));
    padding: 20px;
    gap: 10px;
}
.card-text{
  max-height: 100px;
    height: 100px;
    overflow: hidden;
    margin: auto;
}
.card-title{
  max-height: 50px;
  min-height: 50px;
  overflow: hidden;
}
.language{
  border-radius: 50px;
    background: #28a745;
    color: white;
    display: grid;
    padding: 5px;
    width: 30px;
    height: 30px;
    align-items: center;
    justify-content: center;
    padding: 0;

}
      </style>
  @php
    $movies = App\Http\Controllers\MovieController::getAll();
  @endphp
 
<div class="container">

<div class="row ">
 
@foreach ($movies as $movie)
   
 
   
    <div class="col">
    <div class="card">
    <div>
      <a href="{{ url('/movie/' . $movie->id . '') }}">
      <img src="https://www.themoviedb.org/t/p/w220_and_h330_face/{{$movie->poster_path}}"  class="card-img-top"/>
      </a>
      
      
      </div>
      <div class="card-body">
        <h5 class="card-title">{{ $movie->original_title}}</h5>
        <div class="language">
        {{ $movie->original_language}}
        </div>
        <!-- <p class="card-text">
         {{$movie->overview}}
        </p> -->
      </div>
    </div>
  </div>
  
 
@endforeach
</div>
</div>

