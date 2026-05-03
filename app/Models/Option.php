<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $table = 'options';

    protected $fillable = [
        'question_id',
        'option_text',
        'is_correct',
    ];

    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
