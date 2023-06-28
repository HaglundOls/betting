<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    use HasFactory;

    public $fillable = ['liga', 'id', 'säsong', 'säsong_id', 'country_id', 'sport'];

    public function games(){
        return $this->hasMany(Game::class, 'liga_id');
    }

    public function upcomingGames(){
        return $this->games()->whereNull('match_klar')->where('start_datum', '>=', date('Y-m-d'))->orderBy('start_datum', 'asc')->take(7);
    }

    public function finishedGames($id){
        return $this->games()->where('liga_id', $id)->where('start_datum', '<', date('Y-m-d'))->whereNull('match_klar')->get()->toArray();
    }


}
