<?php

return [

  /*
  |------------------------------------------------------------------------------
  | Default disk name
  |------------------------------------------------------------------------------
  |
  | The disk on which to store added files and derived images by default. Choose
  | one of the disks you've configured in config/filesystems.php.
  |
  */

  'disk_name' => 'filesmanager',

  /*
  |------------------------------------------------------------------------------
  | File viewing layouts 
  |------------------------------------------------------------------------------
  |
  | The available views for view files.  
  | You can create any views as you want, for support many css frameworks like:    
  | Bootstrap, Tailwind, Bulma or you own styles.
  |
  */

  'file_viewing_layouts' => [
    'bootstrap' => 'addons/files-manager/bootstrap-layout'
  ],

  /*
  |------------------------------------------------------------------------------
  | File viewing disks
  |------------------------------------------------------------------------------
  |
  | The disks you have configured in config/filesystems.php that we can try to find
  | the file to view and determine if the file is stored in the
  | application or is it an external file
  |
  */

  'file_viewing_disks' => ['filesmanager', 'media'],

  /*
  |------------------------------------------------------------------------------
  | Validation rules
  |------------------------------------------------------------------------------
  |
  | This array is used for FormRequest and Validator classes,
  | when the rule its bigger and hard to remember put it here:
  | for video, image, or passwords
  |
  */

  'validation_rules' => [
    'video' => 'mimetypes:video/x-ms-asf,video/x-flv,video/mp4,application/x-mpegURL,video/MP2T,video/3gpp,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/avi'
  ],


  /*
  |------------------------------------------------------------------------------
  | Files and folders
  |------------------------------------------------------------------------------
  |
  | This array is used for build the files or folders for use in the FilesManager.php /trait
  | you can use variable paths for specify one folder for model, example:
  | model => model/{modelId}/gallery' this will be replaced in the FilesManager functions
  |
  */
  'files_and_folders' => [

    /**
     * The default package files / concrete files
     */
    'defaults' => [
      'avatars' => [
        'user' => 'defaults/avatars/default_user_avatar.png',
        'user40x40' => 'defaults/avatars/default_user_avatar_40x40.png',
        'user80x80' => 'defaults/avatars/default_user_avatar_80x80.png'
      ]
    ],

    /**
     * Custom files and folders
     */
    'users' => [
      'root'    => 'users/{user}',
      'profile' => 'users/{user}/profile',
    ],

  ],

  /*
  |------------------------------------------------------------------------------
  | Model settings
  |------------------------------------------------------------------------------
  |
  | This array is used for define the files manipulations and conversions 
  | for spatie/media-library
  |
  */

  'model_settings' => [
    
    /**
     * "shared" is used for define shared settings and these will be applied
     * to all files manipulations.
     * The "image_placeholder" is used for show an loading placeholder when the image
     * wasn't found and it hasn't a default image or the conversions area processing.
     */
    'shared' => [
      'image_placeholder' => [
        'url'        => 'https://via.placeholder.com/',
        'color'      => 'ffffff',
        'background' => 'ff8400',
        'text'       => 'Sin+{:attr}+o+procesando',
        'width'      => 1080,
        'height'     => 720,
      ],
    ],

    /**
     * Here you can register the conversions
     * 
     * conversions => [
     *    media_collection_name => [
     *      conversion_name => [
     *        manipulation (crop or keepOriginalImageFormat, etc..) => value|[values]|null
     *      ]
     *    ]
     * ]
     */
    Model::class => [
      'conversions' => [
        'gallery' => [
          'small-images' => [
            'height' => 80,
            'width'  => 80,
            'keepOriginalImageFormat' => null
          ],          
        ]
      ]
    ],
  ]

  /*
  |------------------------------------------------------------------------------
  | config/filesystmes.php
  |------------------------------------------------------------------------------
  |
  | -- Files manager disk
  |
  |   filesmanager => [
  |     driver     => local
  |     root       => storage_path(app/files-manager)
  |     url        => env(APP_URL)./files-manager
  |     visibility => public'
  |   ]
  |
  | -- Copy this disk if you're using spatie-medialibrary
  |
  |   media => [
  |       driver     => local
  |       root       => storage_path(app/media-library)
  |       url        => env(APP_URL)./media-library
  |       visibility => public
  |   ]
  |
  | -- Copy this symbolic links for access to the files
  |
  | links => [ 
  |    public_path(livewire-files) => storage_path('app/livewire-tmp')
  |    public_path(files-manager)  => storage_path('app/files-manager')
  |    public_path(media-library)  => storage_path('app/media-library')
  | ]
  */

];
