<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Reply
 *
 * @property int $id
 * @property int $thread_id
 * @property int $user_id
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Thread $Thread
 * @property-read \App\User $owner
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereThreadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Reply whereUserId($value)
 * @mixin \Eloquent
 */
class Reply extends Model
{
    use RecordsActivity;
    use Favoritable;
    protected $guarded =[];
    protected  $with =['owner','favorites'];

    protected $appends=['favoritesCount','isFavorited'];

    protected static function booted(){
        static::deleting(function ($reply){
            $reply->favorites->each->delete();
        });
    }
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function path()
    {
        return  $this->thread->path() ."#reply-{$this->id}";
    }


}
