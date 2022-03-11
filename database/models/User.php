<?php

namespace App\Models;

use BlackSpot\Starter\Traits\App\FilesManager;
use BlackSpot\Starter\Traits\Vendor\MediaLibrary\DynamicMediaConversions;
use BlackSpot\Starter\Traits\Vendor\MediaLibrary\HasMediaLibraryScopes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, 
        HasFactory, 
        Notifiable, 
        HasRoles, 
        InteractsWithMedia,
        FilesManager,
        DynamicMediaConversions,
        HasMediaLibraryScopes;

    public const TABLE_NAME = 'users';


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday_date' => 'date'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     *  Mutator functions
     */    
    public function getFullNameAttribute()
    {      
        return $this->name.' '.$this->surname;
    }
    public function getFullPhoneAttribute()
    {      
        if ($this->phone_code != '' && $this->phone_code != null) {        
            return "({$this->phone_code})".' '.$this->phone;
        }
        return $this->phone_code.' '.$this->phone;
    }
    public function getInlineRolesAttribute()
    {
        return $this->roles->implode('name',', ');
    }
    public function getReadableGenderAttribute()
    {
        switch ($this->gender) {
            case 'w': return 'Mujer'; break;
            case 'm': return 'Hombre'; break;
            case 'o': return 'Otro'; break;
            default: return 'Prefiero no decirlo'; break;
        }
    }
    public function getPhotoLinkAttribute()
    {      
        if ($this->photo == null) {
            return $this->getFileAsset('defaults.avatars.user',[], false);
        }
        if (strpos($this->photo,'http') !== false) {
            return $this->photo;
        }
        return $this->getFileAsset('users',['{user}' => $this->id],true) . '/' . $this->photo;
    }
    

    /**
     *  Relations
     */
    public function media_photo()
    {
        return $this->media()->where('collection_name','photo');
    }

    /**
     * Dimensions
     */
    public function getDimensions($collection = null, $dimension = null)
    {
        $dimensions = [
            'photo' => [
                'small'   => [80,80],
            ],
        ];

        if ($collection == null && $dimension == null) {
            return $dimensions;
        }

        return $dimensions[$collection][$dimension];
    }

    /**
     * [
     *   media-library-collection => db-model-attribute,
     *   thumb => thumbnail
     * ]
     */
    public function getFacadeCollectionFiles()
    {
        return [
            'photo' => 'photo',
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->___registerMediaCollections();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->___registerMediaConversions($media);
    }
}
