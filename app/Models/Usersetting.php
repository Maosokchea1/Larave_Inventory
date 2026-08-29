<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usersetting extends Model
{
    use HasFactory;

    // បន្ថែមបន្ទាត់នេះដើម្បីបញ្ជាក់ឈ្មោះតារាងពិតប្រាកដក្នុង Database
    protected $table = 'user_settings'; // ឬប្តូរទៅតាមឈ្មោះតារាងពិតរបស់អ្នក

    protected $fillable = [
        'user_id',
        'theme',
        'locale',
        'email_notifications',
        'push_notifications',
    ];

    protected function casts(): array
    {
        return [
            'email_notifications' => 'boolean',
            'push_notifications' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
