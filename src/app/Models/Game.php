<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Game extends Model
{
    use HasFactory;
    use HasUlids;

    public $incrementing = false;
    
    protected $keyType = 'string';
}
