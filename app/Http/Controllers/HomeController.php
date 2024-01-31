<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        require_once('../vendor/autoload.php');

        $client = new \GuzzleHttp\Client();
        $results=array();
        for ($i=1;$i<=10;$i++){
            
             $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/popular?language=en-US&page='.$i, [
                 'headers' => [
                 'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJmYzEzYzNkYTg1YWE5ZWJlMjZlMjIxYmYzYjYwNTRjNSIsInN1YiI6IjY1YjU3M2FmMmZhZjRkMDE3Y2RjOTYxMyIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.aBXZQy4dKMj70Et7D6bLpOkcu4T38JS72TyE-1Ez0yQ',
                 'accept' => 'application/json',
                 ],
              ]);

             $results = json_decode($response->getBody()->getContents(),true)["results"];
             array_push($movies,$results);
        }
        
        
       //echo dd($movies);
       return view('welcome',["movies"=>$movies["movies"]]);
    }
}
