<?php

namespace App\Http\Middleware;

use App\Domain\Interfaces\Core\Permission\PermissionRepositoryInterface;
use App\Domain\Interfaces\Register\Group\GroupPermissionRepositoryInterface;
use App\Domain\Interfaces\Register\Group\GroupRepositoryInterface;
use App\Domain\Interfaces\Register\User\UserPermissionRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function __construct(
        private GroupRepositoryInterface $groupRepositoryInterface,
        private PermissionRepositoryInterface $permissionRepositoryInterface,
        private GroupPermissionRepositoryInterface $groupPermissionRepositoryInterface,
        private UserPermissionRepositoryInterface $userPermissionRepositoryInterface
    ) {}

    public function handle(Request $request, Closure $next, $permission)
    {
        $user = Auth::user();

        $permissionRecord = $this->permissionRepositoryInterface->getByName($permission);
        if (empty($permissionRecord)) {
            return response()->json([
                'error' => 'Permissão não encontrada.'
            ], 404);
        }

        if (!empty($user->group_id)) {
            $group = $this->groupRepositoryInterface->getById($user->group_id);

            if (empty($group)) {
                return response()->json([
                    'error' => 'Grupo não encontrado.'
                ], 404);
            }

            if ($this->groupPermissionRepositoryInterface->getByGroupIdAndPermissionId($group->id, $permissionRecord->id)) {
                return $next($request);
            }
        }

        if ($this->userPermissionRepositoryInterface->getByUserIdAndPermissionId($user->id, $permissionRecord->id)) {
            return $next($request);
        }

        return response()->json([
            'error' => 'Acesso negado. Permissão insuficiente.'
        ], 403);
    }
}
