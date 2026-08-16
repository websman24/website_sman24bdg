<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;

trait AuthorizesOwnership
{
    /**
     * Authorize that the current user owns the model (or is a superadmin/admin).
     *
     * @param  mixed  $model
     * @param  string $foreignKey The foreign key column name that references the user id.
     * @return void
     */
    protected function authorizeOwnership($model, string $foreignKey = 'author_id'): void
    {
        $user = auth()->user();

        // Admins and superadmins have full access to all models
        if ($user->isAdmin()) {
            return;
        }

        // Check ownership
        if ($model->{$foreignKey} !== $user->id) {
            Log::warning('IDOR attempt blocked', [
                'user_id' => $user->id,
                'role' => $user->role,
                'model' => get_class($model),
                'model_id' => $model->id,
                'model_author_id' => $model->{$foreignKey},
                'ip' => request()->ip(),
            ]);

            abort(403, 'Akses ditolak: Anda hanya dapat memodifikasi konten milik Anda sendiri.');
        }
    }
}
