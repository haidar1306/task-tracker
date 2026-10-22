<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

   protected $fillable = [
    'name',
    'email',
    'subject',
    'message',
    'reply',
    'replied_at',
    'reply_read_at',   // NEW
];

protected $casts = [
    'replied_at'    => 'datetime',
    'reply_read_at' => 'datetime',
];

public function scopeReplied($query)
{
    return $query->whereNotNull('reply')->where('reply', '!=', '');
}

public function scopePending($query)
{
    return $query->where(function ($q) {
        $q->whereNull('reply')->orWhere('reply', '');
    });
}

public function scopeUnreadReply($query)
{
    return $query->replied()->whereNull('reply_read_at');
}

public function getIsRepliedAttribute(): bool
{
    return !empty($this->reply);
}

public function getIsUnreadReplyAttribute(): bool
{
    return $this->is_replied && is_null($this->reply_read_at);
}
}