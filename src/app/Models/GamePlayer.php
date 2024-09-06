<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\Pivot;


class GamePlayer extends Pivot
{
    use HasFactory;
    use HasUlids;

    public $incrementing = false;
    public $timestamps = false;
    
    protected $keyType = 'string';

    protected $table = 'game_player';
}
