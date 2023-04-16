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
    position: absolute;
    top: 0;
    left: 0;
    top: -8px;
    left: -8px;

}
.btns{
  display: grid;
    gap: 2px;
}
.btn{
  width: 100%;
}
.splitPage{
  display: grid;
  grid-template-columns: 1fr 3fr;
}
.chercher{
  display: grid;
    align-content: baseline;
    gap: 10px;
    padding: 20px 0;
}
.chercher label{
  margin:0;
}
.pagination{
  justify-content: center;
}
.pagination p{
  margin:0 !important
}
.pagintion .sm:flex-1  {
  gap: 20px;
}

      </style>
  @php
    $movies = App\Http\Controllers\MovieController::getAll();
  @endphp
 
<div class="container splitPage">

<div class="chercher">
<label for="chercher">Chercher :</label>
<input type="text" class="form-control" name="chercher" id="chercher" >
<button type="button" class="btn btn-info " id="rechercher_btn"  onClick="rechercher(event)">Chercher</button> 
</div>


<div class="row ">

@foreach ($movies as $movie)
   
 
   
    <div class="col" id="{{$movie->id}}">
    <div class="card">
    <div>
      <a href="{{ url('/movie/' . $movie->id . '') }}">
      <img src="https://www.themoviedb.org/t/p/w220_and_h330_face/{{$movie->poster_path}}"  class="card-img-top"/>
      </a>
      
      
      </div>
      <div class="card-body">
        <h5 class="card-title">{{ $movie->title}}</h5>
        <div class="language">
        {{ $movie->original_language}}
        </div>
        <div class="btns">
          
       
        @if(date('d/M/Y', strtotime($movie->updated_at)) !=  date("d/M/Y"))
        <a  href="{{ url('/movie-edit/' . $movie->id . '') }}">
          <button type="button" class="btn btn-secondary">Modifier</button>
        </a>
        @endif
         <button type="button" class="btn btn-danger" id="btn-confirm"  onClick="passData({{$movie->id}},<?php echo "'".csrf_token()."'"; ?>)">Supprimer</button>
        
        
        </div>
        
      </div>
    </div>
  </div>
  
 
@endforeach
</div>

</div>
<div class="pagination">
<?php echo $movies->render(); ?>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
      <h4 class="modal-title" id="myModalLabel">Vous voulez vraiment supprimer ?</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" id="modal-btn-oui">Oui</button>
        <button type="button" class="btn btn-primary" id="modal-btn-non">Non</button>
      </div>
    </div>
  </div>
</div>

<script>
  var getId ;
  var csrftoken;
  function passData(id,token){
    getId = id;
    csrftoken = token;
    console.log(token);
    $("#mi-modal").modal('show');
  }
  var modalConfirm = function(callback){
  
  $("#btn-confirm").on("click", function(){
    $("#mi-modal").modal('show');
  });

  $("#modal-btn-oui").on("click", function(){
    callback(true);
    $("#mi-modal").modal('hide');
  });
  
  $("#modal-btn-non").on("click", function(){
    callback(false);
    $("#mi-modal").modal('hide');
  });
};
function rechercher(event){
     console.log($("#chercher").val())
     textSearch = $("#chercher").val();
     $('.col').show();
     if(textSearch.length>0){
      var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
    if(xhr.readyState == 4 && xhr.status == 200){
      console.log(JSON.parse(xhr.responseText))
      if(Array.isArray(JSON.parse(xhr.responseText))){
        $('.col').hide();
        JSON.parse(xhr.responseText).forEach(function(item){
          console.log(item.id)
          $('#'+item.id).show();
        });
      }
    
      
    }
  }
    xhr.open("get","/movies/"+textSearch);
    xhr.setRequestHeader('x-csrf-token', csrftoken); 
    xhr.send();
     }
     
     
  
}
modalConfirm(function(confirm){
  if(confirm){
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
    if(xhr.readyState == 4 && xhr.status == 200){
      console.log(JSON.parse(xhr.responseText),JSON.parse(xhr.responseText).status)
      if(JSON.parse(xhr.responseText).status == "1"){
        console.log("yes")
        location.reload();
      }
      
    }
  }
    xhr.open("delete","/delete/"+getId);
    xhr.setRequestHeader('x-csrf-token', csrftoken); 
    xhr.send();
  }
});
</script>