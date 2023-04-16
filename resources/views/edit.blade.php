<x-app-layout>
 <style>
        .padd{
            padding: 20px;
        }
        .btnModifier{
            text-align:center;
        }
 </style>
<div class="container padd">
    
<form action="/edit/{{$result->id}}" method="post">
  @csrf
  <div class="form-group">
    <label for="title">Title</label>
    <input type="text" class="form-control" name="title" id="title" value="{{$result->title}}">
  </div>
  <div class="form-group">
    <label for="vote">Vote</label>
    <select class="form-control" name="vote" id="vote" value="{{$result->vote_average}}">
    @for ($i = 1; $i <= $result->vote_average; $i++)
          <option value="{{$i}}" {{ $result->vote_average == $i ? 'selected' : '' }}>{{$i}}</option>
    @endfor
    
    </select>
  </div>
 
  <div class="form-group">
    <label for="overview">Overview</label>
    <textarea class="form-control" name="overview" id="overview" rows="3" >{{$result->overview}}</textarea>
  </div>
  <div>
  @if($errors)
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">{{ $error }}</div>
    @endforeach
@endif
  </div>
 <div class="form-group btnModifier">

 <button type="submit" class="btn btn-primary">Modifier</button>
 </div>
   
        
</form>
</div>
</x-app-layout>