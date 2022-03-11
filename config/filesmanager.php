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

  'file_viewing_disks' => [
    'filesmanager', 'media',
  ],
  

  

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
  | This array is used for build the files or folders for use in the 
  | FilesManager.php /trait
  | You can add folders 'path' => 'folder/subfolder/'
  | and you can add files too like: 'path' => 'folder/subfolder'
  | and you can use variable paths for specify one folder for model, example:
  |
  | 'users' => 'users/{user}' then you must include in the pathReplacers like:
  | getFilesFolder('user',['{user}' => $userId])
  |
  */
  'files_and_folders' =>[

    'defaults' => [
      'avatars' => [
        'user' => 'defaults/avatars/default_user_avatar.png',
        'user40x40' => 'defaults/avatars/default_user_avatar_40x40.png',
        'user80x80' => 'defaults/avatars/default_user_avatar_80x80.png'
      ]
    ],
  
    'users' => 'users/{user}',
  ],


  /*
  |------------------------------------------------------------------------------
  | Copy this disk in the config/filesystmes.php
  |------------------------------------------------------------------------------
  | 'disks => [
  |
  |   'filesmanager' => [
  |          'driver'     => 'local',
  |          'root'       => storage_path('app/files-manager'),
  |          'url'        => env('APP_URL').'/files-manager',
  |          'visibility' => 'public',
  |          //'web_route_uri' => 'media-library/{filename}' //for signed routes
  |   ],
  | ]
  */

  /*
  |------------------------------------------------------------------------------
  | Copy this disk in the config/filesystmes.php if you're using spatie-medialibrary
  |------------------------------------------------------------------------------
  | 'disks => [
  |
  |   'media' => [
  |       'driver'     => 'local',
  |       'root'       => storage_path('app/media-library'),
  |       'url'        => env('APP_URL').'/media-library',
  |       'visibility' => 'public',
  |       //'web_route_uri' => 'media-library/{filename}' //for signed routes
  |   ],
  | ]
  */

  /*
  |------------------------------------------------------------------------------
  | Copy this symbolic links in the config/filesystmes.php for access to the files
  |------------------------------------------------------------------------------
  |
  | 'links' => [ 
  |    public_path('livewire-files') => storage_path('app/livewire-tmp'),
  |    public_path('storage-public') => storage_path('app/public'),
  |    public_path('files-manager')  => storage_path('app/files-manager'),
  |    public_path('media-library')  => storage_path('app/media-library'),
  | ]
  */



];
