<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function getDataHistories()
    {
        return DB::table('users')
            ->select(DB::raw('CASE WHEN histories.status = 1 THEN "TRUE" ELSE "FALSE" END as status'), 'name', 'scores.score as final_score', 'histories.score','histories.answer','histories.question')
            ->join('scores', 'users.id', '=', 'scores.user_id')
            ->join('histories', 'users.id', '=', 'histories.user_id')
            ->paginate(10);
    }
}
