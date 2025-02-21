<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
        'invoice_number',
        'amount',
        'payment_status',
        'issued_date',
    ];

    // Relationship with students
    public function students()
    {
        return $this->hasMany(Student::class, 'session_id', 'session_id');
    }
}
