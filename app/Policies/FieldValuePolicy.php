<?php

namespace App\Policies;

use App\Models\User;
use App\Models\FieldValue;

class FieldValuePolicy
{
    public function create(User $user, FieldValue $fieldValue)
    {
        // Checking if the user is allowed to create FieldValues and is the owner of the project associated with the FieldValue
        return $user->id === $fieldValue->endpointField->endpoint->project->user_id;
    }

    public function update(User $user, FieldValue $fieldValue)
    {
        // Checking if the user is allowed to update FieldValues and is the owner of the project associated with the FieldValue
        return $user->id === $fieldValue->endpointField->endpoint->project->user_id;
    }

    public function delete(User $user, FieldValue $fieldValue)
    {
        // Checking if the user is allowed to delete FieldValues and is the owner of the project associated with the FieldValue
        return $user->id === $fieldValue->endpointField->endpoint->project->user_id;
    }

    public function view(User $user, FieldValue $fieldValue)
    {
        // Checking if the user is allowed to view FieldValues and is the owner of the project associated with the FieldValue
        return $user->id === $fieldValue->endpointField->endpoint->project->user_id;
    }
}
