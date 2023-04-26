<?php

namespace App\Models;

use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Post 
{
    

    public $title;
    public $excerpt;
    public $date;
    public $body;
    public $slug;

    public function __construct($title, $excerpt, $date, $body, $slug)
    {
        $this->title = $title;
        $this->excerpt = $excerpt;
        $this->date = $date;
        $this->body = $body;
        $this->slug = $slug;
    }

    public static function allPost()
    {
        return cache()->rememberForever('posts.all', function(){
            return collect( File::files(resource_path("posts")))
            ->map(fn($file) =>  YamlFrontMatter::parseFile($file))   
            ->map(fn ($document) => new Post(
                    $document->title, 
                    $document->excerpt,
                    $document->date,
                    $document->body(),
                    $document->slug,
        ))
            ->sortByDesc('date');
        });
       
    }

    public static function  find($slug)
    {
    //     // base_path(); //helper untuk path
    //     if(!file_exists( $path = resource_path("/posts/{$slug}.html"))){ //rasource _path: helper untuk guna /..resource/..../posts
    //     throw new ModelNotFoundException(); //untuk throw exception. model
    //         // return redirect('/');
    //     //  abort(404); //buat page 404 laravel
    //     //  dd('file does not exist'); //buat die and dump.
    //     //  ddd('file does not exist'); //buat dd cuma ada interface
    //     }

    // return cache()->remember("posts.{$slug}", 1200, fn()=> file_get_contents($path));//buat cahching dan letak 1200 second 

    

    return static::allPost()->firstWhere('slug', $slug);
    }
}
