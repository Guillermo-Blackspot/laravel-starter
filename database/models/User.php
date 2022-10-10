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
use BlackSpot\Starter\Validation\Rules\PhoneRule;
use BlackSpot\Starter\Validation\Rules\UniqueEmailRule;

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
    protected $guarded = [];

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
        'date_of_birth' => 'date'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Helper functions
     */
    public function assignRoleIfExists($role, $guardName = 'web')
    {
        $role = Role::where('name', $role)->where('guard_name', $guardName)->value('id');

        if ($role !== null) {
            $this->assignRole($role);
        }

        return $role !== null;
    }

    public function isSuperAdmin()
    {
        return $this->can(Permission::SUPER_ADMIN_PERMISSION);    
    }

    public static function getDefaultValidationRules(&$merge = [], $userId)
    {
        $rules =  [            
            'user.name'          => 'required',
            'user.last_name'     => 'nullable',
            'user.email'         => ['required', 'email', new UniqueEmailRule(User::class, 'email', $userId)],
            'user.email_2'       => 'nullable|email',
            'user.landline'      => ['nullable', new PhoneRule()],
            'user.partner_code'  => ['nullable', function($attr, $value, $fail) use($userId){
                if (self::where('partner_code', $value)->where('id','!=',$userId)->exists()) {
                    return $fail('Este código de colaborador ya existe.');
                }
            }],
            'user.photo'         => 'nullable',
            'user.gender'        => 'nullable',
            'user.accept_terms'  => 'nullable|in:0,1',
            'user.is_active'     => 'nullable|in:0,1',
            'user.date_of_birth' => 'nullable|date',
            'user.slug'          => 'nullable',
            //'user.partner_code'  => 'nullable',
            'user.password'      => 'nullable',         
            //'selectedRoles'      => 'required',
        ];

        if (!empty($merge)) {
            $rules = $merge = array_merge($merge, $rules);
        }

        return $rules;
    }

    /**
     *  Mutator functions
     */    
    public function getFullNameAttribute()
    {      
        return $this->name.' '.$this->last_name;
    }

    public function getPhoneWithCodeAttribute()
    {   
        $dialCode = null;

        if ($this->cellphone_code != null) {
            $dialCode = '('.$this->cellphone_code->dial_code.') ';
        }   
        return $dialCode . $this->cellphone;
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

        return $this->getFileAsset('users', ['{user}' => $this->id], true) . '/' . $this->photo;
    }    
    
    /**
     * Eloquent scopes
     */

     /**
     * Get the users that can sell 
     */
    public function scopeSellerUsers($query)
    {
        return $query->where(function($query) {
            $query->whereHas('roles.permissions',function($query) {
                $query->where('name','be-a-seller');
            })
            ->orWhereHas('roles.permissions', function($query){
                $query->where('name','im-a-super-admin-and-i-have-full-access');
            });
        });
    }   

    public function scopePartnerUsers($query)
    {
        return $query->whereNotNull('partner_code')->whereNotNull('password');                
    }

    /**
     *  Relations
     */
    public function media_photo()
    {
        return $this->media()->where('collection_name','photo');
    }

    public function cellphone_code()
    {
        return $this->belongsTo(Country::class, 'cellphone_code_id');
    }

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
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
