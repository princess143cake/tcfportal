<?php

/**
* Outbound Model
*/
use Illuminate\Database\Eloquent\SoftDeletingTrait;


class InboundShipping extends Eloquent
{
    use SoftDeletingTrait;

    protected $dates = ['deleted_at']; 
    protected $table = 'inbound_shipping';
    protected $fillable = [
        'container_number',
        'supplier',
        'product',
        'kg',
        'steamship_provider',
        'arrival_to_port',
        'arrival_to_destination',
        'terminal_handling_fee_paid',
        'pickup_location',
        'pickup_appointment',
        'return_location',
        'rv_no',
        'pickup_no',
        'id'

    ];

    
    
}
