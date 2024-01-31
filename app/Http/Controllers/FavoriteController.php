<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoriteController extends Controller
{

    public function index(){
        $favorites = Favorite::select('*')->where("user_id",auth()->user()->id)->get();
        //dd($favorites[1]['id']);


        $movies= Controller::get_movies();
        $cnt=0;
        $favorite_movies=array();
        
        while(isset($movies[$cnt])){
            $cnt2=0;

            while(isset($favorites[$cnt2])){

                if($favorites[$cnt2]['film_id']===$movies[$cnt]['id']){
                    array_push($favorite_movies,$movies[$cnt]);
                }
                $cnt2++;
            }
            $cnt++;
        }

        $series= Controller::get_series();
        $favorite_series =array();
        $cnt=0;

       while(isset($series[$cnt])){
            $cnt2=0;

            while(isset($favorites[$cnt2])){

                if($favorites[$cnt2]['film_id']===$series[$cnt]['id']){
                    array_push($favorite_series,$series[$cnt]);
                }
                $cnt2++;
            }
            $cnt++;
        }
        //dd($favorite_movies);

        return view('favorites',["favorites_movies"=>$favorite_movies,"favorites_series"=>$favorite_series]);
    }



    public function create(){
        //'user_id'=>auth()->user()->id,

        Favorite::Create([
            'user_id'=>auth()->user()->id,
            'categorie' => request('categorie'),
            'film_id' => request('film_id')
        ]);
        
        return redirect('/');
    }
    public function delete(){
        $to_delete = Favorite::findOrFail(request('id'));
        $to_delete->delete();
        
        return redirect('/');

    }
   
    
}
