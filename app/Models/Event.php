<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'description',
        'start',
        'end',
    ];
    
    public static $rules = [
        'name' => 'required',
        'description' => 'nullable',
        'color' => 'required',
        'start' => 'required|date_format:Y-m-d\TH:i',
        'end' => 'required|date_format:Y-m-d\TH:i|after:start',
    ];
        /**
     * Relación Many-to-One con la tabla de usuarios.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
