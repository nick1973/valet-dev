<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    protected $table = 'report_notes';
    protected $fillable = [
        'page_id', 'monthly_page_id', 'weekly_notes', 'monthly_notes', 'complete', 'actual_cash', 'actual_card', 'actual_not_paid', 'actual_vip',
        'actual_total', 'fee_rebate', 'bank_charges', 'reasons'
    ];
}
