<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class BookDor extends Model
{
    protected $table = 'book_dor';

    protected $casts = [
        'measurements' => 'array', // Cast the tags attribute to an array
    ];
}
