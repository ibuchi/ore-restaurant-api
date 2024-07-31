<?php

namespace App\Models;

use App\Observers\ObservesWrites;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory,
        ObservesWrites;

    protected $guarded = ['id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function menus(): BelongsToMany
    {
        return $this->belongsToMany(Menu::class)->withTimestamps();
    }
}
