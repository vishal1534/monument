<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollaborationCollaboratorCheck extends Model
{
    use HasFactory;

    protected $table = 'collaboration_collaborator_checks';
    protected $guarded = ['id'];
}
