@extends('layout')

@section('content')
  <!-- data-panel -->
  


<div class="container mt-5">
    <div class="row" id="search-bar">
      <div class="col-6">
        <form id="search" class="form-inline" method="get" action="/search">
          <label class="sr-only" for="inlineFormInputName2">Name</label>
          <input name="type" value="movie" hidden>
          <input type="text" class="form-control mb-2 mr-sm-2" id="search-input" name="key" placeholder="search name ...">
          <button type="submit" class="btn btn-primary mb-2">Search</button>
        </form>
      </div>
    </div>
    </br>
    <h1>Movies List</h1>
    <ul class="list-group list-group-flush" style="width:100%;">
      @foreach($movies as $movie)

        <li class="list-group-item d-flex justify-content-between align-items-center w-100" data-id="">
            <div class="col-sm-6 col-md-4 col-lg-3" style="min-width:200px;">
              <div class="card mb-2">
                <img class="card-img-top" src="https://image.tmdb.org/t/p/w154/{{$movie['poster_path']}}" alt="Card image cap">
                <div class="card-footer">
                    <center>
                       @auth
                            <?php
                            $isExist=App\Models\Favorite::select("id")->where('user_id', auth()->user()->id)->where('film_id', $movie['id'])->get();
                            
                            ?>
                            <!-- favorite button -->
                            @if(isset($isExist[0]->id))
                                <form action="/favorites/delete" method="post">
                                    @csrf
                                    <input value="{{$isExist[0]->id}}" name="id" hidden>
                                    <button type ="submit" class="btn btn-danger" data-id="">-</button>
                                </form>
                            @else
                                <form action="/favorites" method="post">
                                    @csrf
                                    <input value="{{$movie['id']}}" name="film_id" hidden>
                                    <input value="movie" name="categorie" hidden>
                                    <button type ="submit" class="btn btn-info btn-add-favorite" data-id="">+</button>
                                </form>
                            @endif
                                
                       @endauth
                    </center>
                </div>
              </div>
            </div>
        
            <div class ="card-top ml-10">
                <h2 class="card-title">{{$movie['title']}}</h2>
                    <h6>{{$movie['overview']}}</h6>
                    <h7>Release At : {{$movie['release_date']}}</h7>
                <div class="btns">
                    <button onclick="window.open('<?php echo App\Http\Controllers\Controller::watch($movie['id'],'movie'); ?>')" type="submit">Watch</button>
                </div>
            </div>
        </li>
      @endforeach
    </ul>
   </div>
   <div class="container" style="width:100%;">
      <center>
          {{  $movies->links() }}
      </center>
   </div>
     

  <div class="container mt-5">
    <h1>Top 5 Movies</h1>
<ul class="list-group list-group-flush" style="width:100%;">
      @foreach($top_movies as $movie)

        <li class="list-group-item d-flex justify-content-between align-items-center w-100" data-id="">
            <div class="col-sm-6 col-md-4 col-lg-3" style="min-width:200px;">
              <div class="card mb-2">
                <img class="card-img-top" src="https://image.tmdb.org/t/p/w154/{{$movie['poster_path']}}" alt="Card image cap">
                <div class="card-footer">
                    <center>
                       @auth
                            <?php
                            $isExist=App\Models\Favorite::select("id")->where('user_id', auth()->user()->id)->where('film_id', $movie['id'])->get();
                            
                            ?>
                            <!-- favorite button -->
                            @if(isset($isExist[0]->id))
                                <form action="/favorites/delete" method="post">
                                    @csrf
                                    <input value="{{$isExist[0]->id}}" name="id" hidden>
                                    <button type ="submit" class="btn btn-danger" data-id="">-</button>
                                </form>
                            @else
                                <form action="/favorites" method="post">
                                    @csrf
                                    <input value="{{$movie['id']}}" name="film_id" hidden>
                                    <input value="movie" name="categorie" hidden>
                                    <button type ="submit" class="btn btn-info btn-add-favorite" data-id="">+</button>
                                </form>
                            @endif
                                
                       @endauth
                    </center>
                </div>
              </div>
            </div>
        
            <div class ="card-top ml-10">
                <h2 class="card-title">{{$movie['title']}}</h2>
                    <h6>{{$movie['overview']}}</h6>
                    <h7>Release At : {{$movie['release_date']}}</h7>
                <div class="btns">
                    <button  onclick="window.open('<?php echo App\Http\Controllers\Controller::watch($movie['id'],'movie'); ?>')">Watch</button>
                </div>
            </div>
        </li>
      @endforeach
    </ul>
   </div>
@endsection
