<?php

class Productions extends Eloquent {

    protected $table    = 'production';

    protected $fillable = ['product',
    					   'customer',
    					   'pack_size',
    					   'product_size',
    					   'cases',
    					   'skids',
    					   'shift',
    					   'status',
    					   'notes',
    					   'user_id',
                           'customer_po',
                           'delivery_option'
                        ];

}

?>