<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpressCoursePayment extends Model
{
    protected $table = 'jwy_express_course_payments';
    protected $primaryKey = 'pay_id';
    public $timestamps = false;

    protected $fillable = [
        'id',                // express_course_id
        'timestamp',
        'paid_amount',
        'paid_currency',
        'exchange_rate',
        'origional_amount',
        'unique_link',
        'transaction_id'     // only if column exists!
    ];

    /**
     * The Express Course this payment belongs to
     */
    public function expressCourse()
    {
        // belongsTo(RelatedModel, foreignKey_on_payments, localKey_on_express_courses)
        return $this->belongsTo(ExpressCourse::class, 'id', 'id');
    }

    /**
     * The Transaction this payment belongs to (ONLY IF column exists)
     */
}
