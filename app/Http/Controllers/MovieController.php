<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Validator;
use Redirect;
use Session;
use DB;
use DateTime;

class MovieController extends Controller
{
    // Fonction de test pour voir est ce que API fait un retour des données
    public function index()
    {
        $response = Http::withToken('eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIyMjJkNjNjZGRjMDY2ZDk5ZWQzZTgwNmQzMjY3MThjYSIsInN1YiI6IjYyNGVhNTRhYjc2Y2JiMDA2ODIzODc4YSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.zuuBq1c63XpADl8SQ_c62hezeus7VibE1w5Da5UdYyo')->get('https://api.themoviedb.org/3/trending/all/day');
        return $response->json()['results'];
    }
    // Fonction permet de récupération des données trier et avec pagination de 6 films par page
    public static function getAll()
    {
        $data = DB::table('movies')->orderBy('title')->paginate(6);
        return $data;
    }
    // Fonction Permet de retouner un Film à partir de son Id passer en paramètre 
    // le Retour c'est dans la vue Detail
    public function getMovie($id)
    {
        $data = Movie::find($id);
        return view('detail', ['result' => $data]);
    }
    // Fonction Permet de retouner un Film à partir de son Id passer en paramètre 
    // le Retour c'est dans la vue Edit
    public function getEditMovie($id)
    {
        $data = Movie::find($id);
        return view('edit', ['result' => $data]);
    }
    //Fonction permet de donner un text et ils retournent les films qui contient dans leur titres ce text  
    public function getAllBySearch(Request $request, $text)
    {
        $movies = Movie::where('title', 'LIKE', "%{$text}%")->get()->sortBy('title');
        return $movies;
    }
    //Fonction permet de supprimer un Film en passant dans le paramètre un id et il retourne le status et un message
    public function delete($id)
    {
        $res = Movie::where('id', $id)->delete();
        if ($res) {
            $data = [
                'status' => '1',
                'msg' => 'success'
            ];
        } else {
            $data = [
                'status' => '0',
                'msg' => 'fail'
            ];
        }
        return $data;
    }
    // Fonction qui permet de modifier un Film , elle valide que au moins le titre est obligatoire et apres
    // si c'est bon il fait la modification et il retourne vers le dashboard
    // si non il retourne vers la page  avec les erreurs 
    public function edit(Request $request, $id)
    {

        $rules = array(
            'title' => 'required|string',
            'vote' => 'nullable|numeric',
            'overview' => 'nullable|string'
        );
        $validator = Validator::make($request->all(), $rules);


        if ($validator->fails()) {

            return Redirect::to('movie-edit/' . $id)
                ->withErrors($validator);

        } else {

            $movie = Movie::find($id);
            $movie->title = $request->get('title');
            $movie->vote_average = $request->get('vote');
            $movie->overview = $request->get('overview');
            $movie->save();
            return Redirect::to('dashboard');
        }
    }
      
    //Fonction qui permet de faire la récupération des données a partir de API et puis le stocker dans la BD
    public function saveInDB_Api()
    {

        try {
            $response = Http::withToken('eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIyMjJkNjNjZGRjMDY2ZDk5ZWQzZTgwNmQzMjY3MThjYSIsInN1YiI6IjYyNGVhNTRhYjc2Y2JiMDA2ODIzODc4YSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.zuuBq1c63XpADl8SQ_c62hezeus7VibE1w5Da5UdYyo')->get('https://api.themoviedb.org/3/trending/all/day');

            $results = $response->json()['results'];

            $this->loopSaveMovies($results);
            
            return "La table 'Movies' à bien été alimentée";
        } catch (\Throwable $th) {
            // Dans ce cas la table movies est déjà rempli , elle va la liberer et puis remplir à nouveau
            Movie::truncate();
            $this->loopSaveMovies($results);
            return "La table 'Movies' à bien été alimentée";
        }



    }

    // Fonction permet de faire une boucle sur les résultats de API puis stocker les données dans la BD
    public function loopSaveMovies($results)
    {
        foreach ($results as $mv) {

            $movie = new Movie();

            $ot = isset($mv["original_title"]) ? $mv["original_title"] : (isset($mv["original_name"]) ? $mv["original_name"] : '');
            $title = isset($mv["name"]) ? $mv["name"] : (isset($mv["title"]) ? $mv["title"] : '');


            $movie->id = $mv["id"];
            $movie->original_language = $mv["original_language"];

            $movie->original_title = $ot;
            $movie->overview = $mv["overview"];
            $movie->popularity = $mv["popularity"];
            $movie->poster_path = $mv["poster_path"];
            $movie->title = $title;
            $movie->vote_average = $mv["vote_average"];
            $date = new DateTime();
            $date->modify("-1 day");
            $movie->updated_at = $date->format("Y-m-d H:i:s");
            $movie->save();


        }
    }
}