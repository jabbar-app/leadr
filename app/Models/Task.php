<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'due_date' => 'datetime',
        'created_at' => 'datetime',
    ];

    public function isDueToday()
    {
        if (!$this->is_recurring) {
            return $this->due_date === now()->toDateString();
        }

        switch ($this->recurring_type) {
            case 'daily':
                return true;
            case 'weekly':
                return now()->dayOfWeek === Carbon::parse($this->created_at)->dayOfWeek;
            case 'monthly':
                return now()->day === Carbon::parse($this->created_at)->day;
            default:
                return false;
        }
    }

    public function scopeDueToday($query)
    {
        return $query->where(function ($q) {
            $q->where('is_recurring', false)
                ->whereDate('due_date', now());
        })->orWhere(function ($q) {
            $q->where('is_recurring', true)
                ->where(function ($sub) {
                    $sub->where('recurring_type', 'daily')
                        ->orWhere(function ($w) {
                            $w->where('recurring_type', 'weekly')
                                ->whereRaw('WEEKDAY(created_at) = WEEKDAY(CURDATE())');
                        })
                        ->orWhere(function ($w) {
                            $w->where('recurring_type', 'monthly')
                                ->whereRaw('DAY(created_at) = DAY(CURDATE())');
                        });
                });
        });
    }

    public function scopeDueOn($query, $date)
    {
        return $query->where(function ($q) use ($date) {
            $q->where('is_recurring', false)
                ->whereDate('due_date', $date);
        })->orWhere(function ($q) use ($date) {
            $carbonDate = Carbon::parse($date);
            $q->where('is_recurring', true)
                ->where(function ($sub) use ($carbonDate) {
                    $sub->where('recurring_type', 'daily')
                        ->orWhere(function ($w) use ($carbonDate) {
                            $w->where('recurring_type', 'weekly')
                                ->whereRaw('WEEKDAY(created_at) = ?', [$carbonDate->dayOfWeek]);
                        })
                        ->orWhere(function ($w) use ($carbonDate) {
                            $w->where('recurring_type', 'monthly')
                                ->whereRaw('DAY(created_at) = ?', [$carbonDate->day]);
                        });
                });
        });
    }

    /**
     * Scope: Ambil semua task yang belum lewat due_date-nya atau yang recurring aktif hari ini ke depan.
     */
    public function scopeDueUpcoming($query)
    {
        return $query->where(function ($q) {
            $q->where('is_recurring', false)
                ->whereDate('due_date', '>=', now()->toDateString());
        })->orWhere(function ($q) {
            $q->where('is_recurring', true); // recurring dianggap selalu aktif
        });
    }

    /**
     * Scope: Ambil semua task yang belum dikerjakan oleh user tertentu
     */
    public function scopeUnsubmittedBy($query, $userId)
    {
        return $query->whereDoesntHave('submissions', function ($q) use ($userId) {
            $q->where('user_id', $userId);
        });
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }
}
