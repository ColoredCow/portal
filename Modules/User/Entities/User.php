<?php

namespace Modules\User\Entities;

use App\Models\KnowledgeCafe\Library\Book;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Modules\AppointmentSlots\Entities\AppointmentSlot;
use Modules\HR\Entities\Employee;
use Modules\Operations\Entities\OfficeLocation;
use Modules\Project\Entities\Project;
use Modules\Project\Entities\ProjectTeamMember;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Traits\CanBeExtended;
use Modules\User\Traits\HasWebsiteUser;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes, HasRoles, HasWebsiteUser, CanBeExtended, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'provider', 'provider_id', 'avatar', 'locations'
    ];

    protected $appends = ['websiteUserRole', 'websiteUser'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     **/
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function findByEmail($email)
    {
        return self::where('email', $email)->first();
    }

    protected static function newFactory()
    {
        return new UserFactory();
    }

    /**
     * Checks if the user is super admin.
     *
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->hasRole('super-admin');
    }

    public static function scopeInterviewers($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->whereIn('name', ['super-admin', 'admin', 'hr-manager']);
        });
    }

    public function getAvatarAttribute($value)
    {
        return ($value) ?: url('/images/default_profile.png');
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_readers', 'user_id', 'library_book_id');
    }

    public function booksInWishlist()
    {
        return $this->belongsToMany(Book::class, 'book_wishlist', 'user_id', 'library_book_id');
    }

    public function booksBorrower()
    {
        return $this->belongsToMany(Book::class, 'book_borrower', 'user_id', 'library_book_id');
    }

    public function totalReadBooks()
    {
        return $this->books()->count();
    }

    public function getIsActiveEmployeeAttribute()
    {
        // The employees will have a GSuite ID. That means the provider will be google.
        // Also, to make sure there's no false entry, we'll also check if the email
        // contains the gsuite client hd parameter.
        return $this->provider == 'google' && strpos($this->email, config('constants.gsuite.client-hd')) !== false;
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id');
    }

    public function officelocation()
    {
        return $this->belongsTo(OfficeLocation::class, 'locations');
    }

    public function scopeFindByEmail($query, $email)
    {
        return $query->where('email', $email);
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function appointmentSlots()
    {
        return $this->hasMany(AppointmentSlot::class, 'user_id');
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_team_members', 'team_member_id', 'project_id')->wherePivot('ended_on', null);
    }

    public function meta()
    {
        return $this->hasMany(UserMeta::class, 'user_id');
    }

    public function metaValue($metaKey)
    {
        return optional($this->meta()->key($metaKey)->first())->meta_value;
    }

    public static function scopeWantsEffortSummary($query)
    {
        return $query->whereHas('meta', function ($query) {
            $query->where('meta_key', 'receive_daily_effort_summary')->where('meta_value', 'yes');
        });
    }

    public function projectTeamMembers()
    {
        return $this->hasMany(ProjectTeamMember::class, 'team_member_id');
    }
    public function activeProjectTeamMembers()
    {
        return $this->hasMany(ProjectTeamMember::class, 'team_member_id')->where('ended_on', null);
    }

    public function getMonthTotalEffortAttribute()
    {
        if (! $this->projectTeamMembers->first()) {
            return false;
        }

        $totalEffort = 0;

        foreach ($this->projectTeamMembers as $projectTeamMember) {
            $projectTeamMemberEffort = $projectTeamMember->projectTeamMemberEffort()->orderBy('added_on', 'desc')->first();

            if ($projectTeamMemberEffort and Carbon::parse($projectTeamMemberEffort->added_on)->format('Y-m') == Carbon::now()->format('Y-m')) {
                $totalEffort += $projectTeamMemberEffort->total_effort_in_effortsheet;
            }
        }

        return $totalEffort;
    }

    public function getFteAttribute()
    {
        $fte = 0;

        foreach ($this->projectTeamMembers as $projectTeamMember) {
            $fte += $projectTeamMember->fte;
        }

        return $fte;
    }

    public function activeProjects()
    {
        $projects = Project::linkedToTeamMember($this->id)->get();

        return $projects;
    }
}
