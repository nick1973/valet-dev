<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    protected $table = 'tracking';
    protected $fillable = [
        'ticket_number', 'ticket_price', 'ticket_name', 'ticket_registration', 'existing_customer', 'ticket_manufacturer',
        'ticket_model', 'ticket_colour', 'ticket_notes' ,'ticket_mobile' ,'ticket_key_safe', 'ticket_payment', 'ticket_status',
        'booked_in_by', 'ticket_driver', 'auth_by', 'collection_at', 'valet1_ticket_id', 'valet2_ticket_id', 'valet3_ticket_id',
        'valet1_ticket_serial_number', 'valet2_ticket_serial_number', 'valet3_ticket_serial_number', 'booking_date'
    ];
}