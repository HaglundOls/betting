<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;
    public $fillable = ['liga_id', 'match_id', 'hemma_lag', 'borta_lag', 'start_datum', 'start_tid', 'hemma_poäng', 'borta_poäng', 'match_klar', 'match_öt', 'match_straff'];
    protected $primaryKey = 'match_id';
    public function league(){
        return $this->belongsTo(League::class, 'liga_id');
    }
}
