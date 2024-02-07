<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Http\Traits\PaginationTrait;

use App\Http\Controllers\FavoriteController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, PaginationTrait;

    public function get_movies(){

        require_once('../vendor/autoload.php');

		$key_api = env('key_api', false);

        $client = new \GuzzleHttp\Client();
        $results=array();
        $movies = array();
        for ($i=1;$i<=10;$i++){
            
             $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/popular?language=en-US&include_adult=false&page='.$i, [
                 'headers' => [
                 'Authorization' => 'Bearer '.$key_api,
                 'accept' => 'application/json',
                 ],
              ]);
              $cnt = 0;
             $results = json_decode($response->getBody()->getContents(),true)["results"];
             while($cnt<count($results)){
                array_push($movies,$results[$cnt]);
                $cnt++;
             }
        }

        return $movies;
    }

    public function get_series(){
        require_once('../vendor/autoload.php');

		$key_api = env('key_api', false);

        $client = new \GuzzleHttp\Client();
        $results=array();
        $series = array();
        for ($i=1;$i<=10;$i++){
            
             $response = $client->request('GET', 'https://api.themoviedb.org/3/tv/popular?language=en-US&include_adult=false&page='.$i, [
                 'headers' => [
                 'Authorization' => 'Bearer '.$key_api,
                 'accept' => 'application/json',
                 ],
              ]);
              $cnt = 0;
             $results = json_decode($response->getBody()->getContents(),true)["results"];
             while($cnt<count($results)){
                array_push($series,$results[$cnt]);
                $cnt++;
             }
        }

        return $series;
    }


    public function get_top_movies(){

        require_once('../vendor/autoload.php');

		$key_api = env('key_api', false);

        $client = new \GuzzleHttp\Client();
        $results=array();

        $response = $client->request('GET', 'https://api.themoviedb.org/3/movie/top_rated?language=en-US&include_adult=false&page=1', [
          'headers' => [
            'Authorization' => 'Bearer '.$key_api,
            'accept' => 'application/json',
          ],
        ]);

        $cnt = 0;
        $top_movies=array();
        $results = json_decode($response->getBody()->getContents(),true)["results"];
        while($cnt<5){
                array_push($top_movies,$results[$cnt]);
                $cnt++;
         }
         return $top_movies;
    }

    public function get_top_series(){

		$key_api = env('key_api', false);

		$client = new \GuzzleHttp\Client();
        $results=array();

        $response = $client->request('GET', 'https://api.themoviedb.org/3/tv/top_rated?language=en-US&include_adult=false&page=1', [
          'headers' => [
            'Authorization' => 'Bearer '.$key_api,
            'accept' => 'application/json',
          ],
        ]);

        $cnt = 0;
        $top_series=array();
        $results = json_decode($response->getBody()->getContents(),true)["results"];
        while($cnt<5){
                array_push($top_series,$results[$cnt]);
                $cnt++;
         }

         return $top_series;
    }

    public function movies () {
    
        $movies = Controller::get_movies();
        $top_movies =Controller::get_top_movies();

        return view('movies',["movies"=>$this->paginate($movies),
                            "top_movies"=>$top_movies]);
    }

    public function series (){

    $series = Controller::get_series();
    $top_series = Controller::get_top_series();

    return view('series',["series"=>$this->paginate($series),
                            "top_series"=>$top_series]);
    }

    public function watch($id,$type){
        require_once('../vendor/autoload.php');
		
		$key_api = env('key_api', false);
		
        $client = new \GuzzleHttp\Client();
        $results=array();
        if($type=='movie'){
        $url_api='https://api.themoviedb.org/3/movie/'.$id.'/videos?language=en-US';}
        else{
           $url_api= 'https://api.themoviedb.org/3/tv/'.$id.'/videos?language=en-US';
        }

        $response = $client->request('GET', $url_api, [
          'headers' => [
            'Authorization' => 'Bearer '.$key_api,
            'accept' => 'application/json',
          ],
        ]);

        $results = json_decode($response->getBody()->getContents(),true)["results"];
        //dd($results);
        if(isset($results[0]['site'])==False){return 'https://www.youtube.com/watch?v=';}

        if($results[0]['site']=='YouTube'){
            $url_video='https://www.youtube.com/watch?v='.$results[0]['key'];
        }
        else{
            $url_video='https://vimeo.com/'.$results[0]['key'];
        }

        return $url_video;
    }

    public function search(){

        if(request('type')=='movie'){$list=Controller::get_movies();}
        else{$list=$list=Controller::get_series();}

        $results=array();
        $cnt=0;
        $key=strtolower(request('key'));

        while(isset($list[$cnt])){
            if(request('type') == 'movie'){$title =strtolower($list[$cnt]['title']);}
            else{$title =strtolower($list[$cnt]['name']);}

            //dd($title.' '.$key);
            if(str_contains($title,$key)){array_push($results,$list[$cnt]);}
            
            $cnt++;
         }
        //dd($results);
        return view('search',["results"=>$this->paginate($results),"type"=>request('type')]);
    }
}
