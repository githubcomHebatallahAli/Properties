<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory, SoftDeletes;

        protected $fillable = [
            'admin_id',
            'broker_id',
            'user_id',
            'creationDate'
        ];

        protected $dates = ['creationDate'];

        public function messages()
        {
            return $this->hasMany(Message::class);
        }

        public function user()
        {
            return $this->belongsTo(User::class , 'user_id');
        }

        public function broker()
        {
            return $this->belongsTo(Broker::class, 'broker_id');
        }

        public function admin()
        {
            return $this->belongsTo(Admin::class , 'admin_id');
        }
 
}
