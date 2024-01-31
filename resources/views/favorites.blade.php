@extends('layout')
@section('content')
  <div class="container mt-5">
    <h1>Favorites Movies List</h1>
        <ul class="list-group list-group-flush" style="width:100%;">
             @forelse($favorites_movies as $favorite)

                <li class="list-group-item d-flex justify-content-between align-items-center w-100" data-id="">
                    <div class="col-sm-6 col-md-4 col-lg-3" style="min-width:200px;">
                      <div class="card mb-2">
                        <img class="card-img-top" src="https://image.tmdb.org/t/p/w154/{{$favorite['poster_path']}}" alt="Card image cap">
                        <div class="card-footer">
                        <?php
                             $isExist=App\Models\Favorite::select("id")->where('user_id', auth()->user()->id)->where('film_id', $favorite['id'])->get();?>
                            <center>
                                <form action="/favorites/delete" method="post">
                                    @csrf
                                    <input value="{{$isExist[0]->id}}" name="id" hidden>
                                    <button type ="submit" class="btn btn-danger" data-id="">-</button>
                                </form>
                            </center>
                        </div>
                      </div>
                    </div>
                
                    <div class ="card-top ml-10">
                        <h2 class="card-title">{{$favorite['title']}}</h6>
                            <p>{{$favorite['overview']}}</p>
                            <p>Release At : {{$favorite['release_date']}}</p>
                        <div class="btns">
                            <button>Watch</button>
                        </div>
                    </div>
                </li>
            @empty
            <center><p>EMPTY LIST</p></center>
        @endforelse
    </ul>
   </div>

     <div class="container mt-5">
    <h1>Favorites Series List</h1>
        <ul class="list-group list-group-flush" style="width:100%;">
             @forelse($favorites_series as $favorite)

                <li class="list-group-item d-flex justify-content-between align-items-center w-100" data-id="">
                    <div class="col-sm-6 col-md-4 col-lg-3" style="min-width:200px;">
                      <div class="card mb-2">
                        <img class="card-img-top" src="https://image.tmdb.org/t/p/w154/{{$favorite['poster_path']}}" alt="Card image cap">
                        <div class="card-footer">
                        <?php
                             $isExist=App\Models\Favorite::select("id")->where('user_id', auth()->user()->id)->where('film_id', $favorite['id'])->get();?>
                            <center>
                                <form action="/favorites/delete" method="post">
                                    @csrf
                                    <input value="{{$isExist[0]->id}}" name="id" hidden>
                                    <button type ="submit" class="btn btn-danger" data-id="">-</button>
                                </form>
                            </center>
                        </div>
                      </div>
                    </div>
                
                    <div class ="card-top ml-10">
                        <h2 class="card-title">{{$favorite['name']}}</h6>
                            <p>{{$favorite['overview']}}</p>
                            <p>Release At : {{$favorite['first_air_date']}}</p>
                        <div class="btns">
                            <button>Watch</button>
                        </div>
                    </div>
                </li>
            
        @empty
            <center><p>EMPTY LIST</p></center>
        @endforelse
    </ul>
   </div>
@endsection
