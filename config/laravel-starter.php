<?php

return [

  /*
  |------------------------------------------------------------------------------
  | Global laravel starter keys
  |------------------------------------------------------------------------------
  |
  | Pagination size
  | Super admin permission name
  |
  */
  
  'pagination_size' => 30,

  'permissions' => [
    
    'super-admin' => 'im-a-super-admin-and-i-have-full-access', //full access
    'admin'       => 'im-a-admin', // partial full access
    'customer'    => 'im-a-customer', 
    'manager'     => 'im-a-manager', 
    'executive'   => 'i-am-an-executive',
    'contact'     => 'im-a-contact',
    'simple-user' => 'im-a-simple-user', // im a simple user and i can access to customer site
  ]
  
];