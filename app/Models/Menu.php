<?php

namespace App\Models;

use App\Observers\ObservesWrites;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Menu extends Model
{
    use HasFactory,
        ObservesWrites;

    protected $guarded = ['id'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_discounted' => 'boolean'
        ];
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)->withTimestamps();
    }
}
