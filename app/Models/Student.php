<?php   
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProgramEnrollment;
use App\Models\invoice;


class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'program_id', // Foreign key linking to a program
        'first_name',
        'surname',
        'email',
        'dob',
        'assessment_marks1',
        'assessment_marks2',
        'total',
        'program_code',
        'user_id',
        'pass',
        'certificate_no', // New column for certificate number

    ];

    // Relationship with invoice
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'session_id', 'session_id');
    }
    public function program()
    {
        return $this->belongsTo(ProgramEnrollment::class, 'program_id', 'id');
    }

}
