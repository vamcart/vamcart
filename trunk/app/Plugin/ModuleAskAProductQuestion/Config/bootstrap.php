<?php
Cache::config('_cake_core_', array(
    'engine' => 'File',
    'prefix' => 'cake_core_product_question_',
    'path' => CACHE . 'persistent' . DS,
    'serialize' => true,
    'duration' => '+999 days',
));
?>