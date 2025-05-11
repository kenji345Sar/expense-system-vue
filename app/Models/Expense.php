<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Transportation;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'date',
        'amount',
        'description',
        'expense_type',
        'note',
        'status',
        'transportation_expense_id',
        'approver_id',
        'approved_at',
        'approval_comment',
    ];

    // ユーザーとのリレーション（申請者）
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 交通費とのリレーション（交通費）
    public function transportationExpenses()
    {
        return $this->hasMany(Transportation::class);
    }
    public function businessTripExpenses()
    {
        return $this->hasMany(BusinessTrip::class);
    }
    // 例: public function entertainmentExpense() { return $this->hasOne(EntertainmentExpense::class); }
    public function supplyExpenses()
    {
        return $this->hasMany(Supply::class);
    }
    // 承認者とのリレーション（承認者）
    public function approver()
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
    // 承認ステータスの定数
    const STATUS_SUBMITTED = 'submitted'; // 申請中         
}
