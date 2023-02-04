<?php

namespace App\Models;

use App\DTO\Tags\TagDTO;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    /**
     * RELATIONSHIP METHODS
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function questions()
    {
        return $this->belongsToMany(Question::class)->withTimestamps();
    }

    /**
     * HELPER METHODS
     */
    public function toDTO(): TagDTO
    {
        return new TagDTO(
            id: $this->id,
            name: $this->name,
            desc: $this->desc,
            creator: $this->creator->toDTO(),
            questions: gettype($this->questions) == 'array' ? $this->questions : null,
            created_at: $this->created_at,
            updated_at: $this->updated_at,
            created_date: (new Carbon($this->created_at))->diffForHumans(),
            updated_date: (new Carbon($this->updated_at))->diffForHumans(),
        );
    }
}
