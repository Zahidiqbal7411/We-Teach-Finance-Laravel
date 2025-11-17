<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpressCourse extends Model
{
    protected $table = 'jwy_express_courses';

    protected $fillable = [
        'name',
        'email',
        'whatsapp',
        'parent_name',
        'parent_email',
        'parent_whatsapp',
        'country',
        'educational_system',
        'subject',
        'examination_board',
        'course',
        'pay_status',
        'course_other',
        'origional_price',
        'origional_price_currency',
        'origional_price_amount',
        'paid_amount',
        'custom_link',
        'students_notes',
        'admin_notes',
        'timestamp_req'
    ];
    public function expressCourse()
    {
        return $this->belongsTo(ExpressCourse::class, 'express_course_id', 'id');
    }

}
