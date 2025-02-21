<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\student;


class ProgramEnrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_title',
        'program',
        'alp_name',
        'alp_number',
        'start_date',
        'end_date',
        'user_id', // User who created the program
        'trainer_name',
        'program_code',
        'program_en_no',
    ];
    public function students()
    {
        return $this->hasMany(Student::class, 'program_id', 'id');
    }
    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'session_id', 'program_code');
    }
}
