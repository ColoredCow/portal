<?php

namespace Modules\Prospect\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Project\Entities\Project;
use Modules\User\Entities\User;

class ProspectEngagement extends Model
{
    /**
     * Allowed pre-sales stages. Transition validation is enforced downstream
     * in the MCP write tools; this constant is the shared reference.
     */
    public const STAGES = [
        'inquiry',
        'qualified',
        'proposal_drafting',
        'proposal_submitted',
        'negotiation',
        'won',
        'lost',
        'dropped',
    ];

    protected $table = 'prospect_engagements';

    /**
     * Explicitly populated (sibling Prospect entities use an empty guard).
     * This model is mass-assigned via Model::create() in tests and by the
     * downstream MCP write tools; there is no global Model::unguard() in this
     * app, so the fillable list must be explicit for those creates to persist.
     */
    protected $fillable = [
        'prospect_id',
        'project_id',
        'short_descriptor',
        'year',
        'stage',
        'owner_user_id',
        'submission_due_date',
        'proposal_sent_date',
        'last_touch_date',
        'next_action',
        'drift_flag',
        'closed_at',
        'close_reason',
        'notes_path',
    ];

    protected $casts = [
        'year' => 'integer',
        'drift_flag' => 'boolean',
        'submission_due_date' => 'datetime:Y-m-d',
        'proposal_sent_date' => 'datetime:Y-m-d',
        'last_touch_date' => 'datetime:Y-m-d',
        'closed_at' => 'datetime',
    ];

    public function prospect()
    {
        return $this->belongsTo(Prospect::class, 'prospect_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }

    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
