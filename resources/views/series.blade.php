@extends('layout')

@section('content')
 <!-- data-panel -->
  <div class="container mt-5">
      <div class="row" id="search-bar">
      <div class="col-6">
        <form id="search" class="form-inline" method="get" action="/search">
          <label class="sr-only" for="inlineFormInputName2">Name</label>
          <input name="type" value="serie" hidden>
          <input type="text" class="form-control mb-2 mr-sm-2" id="search-input" name="key" placeholder="search name ...">
          <button type="submit" class="btn btn-primary mb-2">Search</button>
        </form>
      </div>
    </div>
    </br>

    <h1>Series List</h1>
    <ul class="list-group list-group-flush" style="width:100%;">
      @foreach($series as $serie)

        <li class="list-group-item d-flex justify-content-between align-items-center w-100" data-id="">
            <div class="col-sm-6 col-md-4 col-lg-3" style="min-width:200px;">
              <div class="card mb-2">
                <img class="card-img-top" src="https://image.tmdb.org/t/p/w154/{{$serie['poster_path']}}" alt="Card image cap">
                <div class="card-footer">
                    <center>
                       @auth
                            <?php
                            $isExist=App\Models\Favorite::select("id")->where('user_id', auth()->user()->id)->where('film_id', $serie['id'])->get();
                            
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
                                    <input value="{{$serie['id']}}" name="film_id" hidden>
                                    <input value="serie" name="categorie" hidden>
                                    <button type ="submit" class="btn btn-info btn-add-favorite" data-id="">+</button>
                                </form>
                            @endif
                                
                       @endauth
                    </center>
                </div>
              </div>
            </div>
        
            <div class ="left card-top ml-10">
                
                <h2 class="card-title">{{$serie['name']}}</h2>
                    <h6>{{$serie['overview']}}</h6>
                    <h7>Release At : {{$serie['first_air_date']}}</h7>
                <div class="btns">
                    <button  onclick="window.open('<?php echo App\Http\Controllers\Controller::watch($serie['id'],'serie'); ?>')">Watch</button>
                </div>
            </div>
        </li>
      @endforeach
    </ul>
   </div>
   <div class="container" style="width:100%;">
      <center>
          {{  $series->links() }}
      </center>
   </div>
     

  <div class="container mt-5">
    <h1>Top 5 Series</h1>
<ul class="list-group list-group-flush" style="width:100%;">
      @foreach($top_series as $serie)

        <li class="list-group-item d-flex justify-content-between align-items-center w-100" data-id="">
            <div class="col-sm-6 col-md-4 col-lg-3" style="min-width:200px;">
              <div class="card mb-2">
                <img class="card-img-top" src="https://image.tmdb.org/t/p/w154/{{$serie['poster_path']}}" alt="Card image cap">
                <div class="card-footer">
                    <center>
                       @auth
                            <?php
                            $isExist=App\Models\Favorite::select("id")->where('user_id', auth()->user()->id)->where('film_id', $serie['id'])->get();
                            
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
                                    <input value="{{$serie['id']}}" name="film_id" hidden>
                                    <input value="serie" name="categorie" hidden>
                                    <button type ="submit" class="btn btn-info btn-add-favorite" data-id="">+</button>
                                </form>
                            @endif
                                
                       @endauth
                    </center>
                </div>
              </div>
            </div>
        
            <div class ="card-left-top ml-10">
                <h2 class="card-title">{{$serie['name']}}</h2>
                    <h6>{{$serie['overview']}}</h6>
                    <h7>Release At : {{$serie['first_air_date']}}</h7>
                <div class="btns">
                    <button  onclick="window.open('<?php echo App\Http\Controllers\Controller::watch($serie['id'],'serie'); ?>')">Watch</button>
                </div>
            </div>
        </li>
      @endforeach
    </ul>
   </div>
@endsection
