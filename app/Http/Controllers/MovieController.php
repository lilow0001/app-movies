<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
    public function index(){
       $response = Http::withToken('eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIyMjJkNjNjZGRjMDY2ZDk5ZWQzZTgwNmQzMjY3MThjYSIsInN1YiI6IjYyNGVhNTRhYjc2Y2JiMDA2ODIzODc4YSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.zuuBq1c63XpADl8SQ_c62hezeus7VibE1w5Da5UdYyo')->get('https://api.themoviedb.org/3/trending/all/day');
        //$response = Http::withToken('eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIyMjJkNjNjZGRjMDY2ZDk5ZWQzZTgwNmQzMjY3MThjYSIsInN1YiI6IjYyNGVhNTRhYjc2Y2JiMDA2ODIzODc4YSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.zuuBq1c63XpADl8SQ_c62hezeus7VibE1w5Da5UdYyo')->get('https://api.themoviedb.org/3/movie/948713');
        //return $response->requestTimeout();
        // $movie = (object) $response->json();
        // $movie = json_decode($response);
        

        //$response->json()["original_title"]
        return $response->json()['results'];
    }
    public function saveInDB_Api(){
         
        try {
            $response = Http::withToken('eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIyMjJkNjNjZGRjMDY2ZDk5ZWQzZTgwNmQzMjY3MThjYSIsInN1YiI6IjYyNGVhNTRhYjc2Y2JiMDA2ODIzODc4YSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.zuuBq1c63XpADl8SQ_c62hezeus7VibE1w5Da5UdYyo')->get('https://api.themoviedb.org/3/trending/all/day');
            //$response = Http::withToken('eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIyMjJkNjNjZGRjMDY2ZDk5ZWQzZTgwNmQzMjY3MThjYSIsInN1YiI6IjYyNGVhNTRhYjc2Y2JiMDA2ODIzODc4YSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.zuuBq1c63XpADl8SQ_c62hezeus7VibE1w5Da5UdYyo')->get('https://api.themoviedb.org/3/movie/948713');
            $results = $response->json()['results']; 
          //  return $results;
          $this->loopSaveMovies($results);
            foreach ($results as $mv){
               
                $movie = new Movie();
                
                $ot = isset($mv["original_title"])?$mv["original_title"]:(isset($mv["original_name"])?$mv["original_name"]:'');
                $title = isset($mv["name"])?$mv["name"]:(isset($mv["title"])?$mv["title"]:'');
    
    
                $movie->id =  $mv["id"];
                $movie->original_language =  $mv["original_language"];
    
                $movie->original_title = $ot ;
                $movie->overview = $mv["overview"];
                $movie->popularity = $mv["popularity"];
                $movie->poster_path = $mv["poster_path"];
                $movie->title = $title;
                $movie->vote_average = $mv["vote_average"];
                $movie->save();
    
                
            }
            return "La table 'Movies' à bien été alimentée";
        } catch (\Throwable $th) {
           
            Movie::truncate();
            $this->loopSaveMovies($results);
            return "La table 'Movies' à bien été alimentée";
        }

        
        
    }

    public function loopSaveMovies($results){
        foreach ($results as $mv){
               
            $movie = new Movie();
            
            $ot = isset($mv["original_title"])?$mv["original_title"]:(isset($mv["original_name"])?$mv["original_name"]:'');
            $title = isset($mv["name"])?$mv["name"]:(isset($mv["title"])?$mv["title"]:'');


            $movie->id =  $mv["id"];
            $movie->original_language =  $mv["original_language"];

            $movie->original_title = $ot ;
            $movie->overview = $mv["overview"];
            $movie->popularity = $mv["popularity"];
            $movie->poster_path = $mv["poster_path"];
            $movie->title = $title;
            $movie->vote_average = $mv["vote_average"];
            $movie->save();

            
        }
    }
}
