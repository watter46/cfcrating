<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUlids;


class GameUser extends Model
{
    use HasFactory;
    use HasUlids;

    public $incrementing = false;
    public $timestamps = false;
    
    protected $keyType = 'string';

    protected $table = 'game_user';

    protected $attributes = [
        'is_rated' => false,
        'mom_count' => 0
    ];
}
