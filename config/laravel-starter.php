<?php

return [

  /*
  |------------------------------------------------------------------------------
  | Conekta keys
  |------------------------------------------------------------------------------
  | 
  */
  
  'conekta' => [
    'private_key' => '',
    'public_key'  => ''
  ],

  /**
   * Usable for traits
   */
  'table_namespaces' => [  

    // \BlackSpot\Starter\Traits\DB\HasAddresses
    'address' => '\App\Models\Morphs\Address',

    // \BlackSpot\Starter\Traits\DB\HasTranslations
    'translation' => '\App\Models\Morphs\Translation',

    // \BlackSpot\Starter\Traits\DB\HasSocialMedia
    'social_media' => '\App\Models\Morphs\SocialMedia',
  ]
  
];