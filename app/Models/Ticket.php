<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'priority',
        'assigned_to',
        'assigned_by',
        'comment',
    ];

    const PRIORITY = [
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High',
        'urgent' => 'Urgent',
    ];

    const STATUS = [
        'backlog' => 'Backlog',
        'in_progress' => 'In Progress',
        'resolved' => 'Resolved',
        'archived' => 'Archived',
    ];

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
