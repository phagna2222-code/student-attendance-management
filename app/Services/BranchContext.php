<?php

namespace App\Services;

use App\Models\Branch;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BranchContext
{
    public const SESSION_KEY = 'admin.branch_id';

    public function __construct(private readonly Request $request)
    {
    }

    public function currentId(): ?int
    {
        $id = $this->request->session()->get(self::SESSION_KEY);
        return $id ? (int) $id : null;
    }

    public function current(): ?Branch
    {
        $id = $this->currentId();
        return $id ? Branch::find($id) : null;
    }

    public function set(?int $branchId): void
    {
        if ($branchId === null) {
            $this->request->session()->forget(self::SESSION_KEY);
            return;
        }
        $this->request->session()->put(self::SESSION_KEY, $branchId);
    }

    /**
     * Apply the current branch filter to a query builder for any model that has a branch_id column.
     */
    public function scope(Builder $query, string $column = 'branch_id'): Builder
    {
        $id = $this->currentId();
        if ($id !== null) {
            $query->where($column, $id);
        }
        return $query;
    }

    /**
     * For users that aren't super admins, restrict to branches they belong to.
     */
    public function userAccessibleBranchIds(): ?array
    {
        $user = Auth::user();
        if (! $user) {
            return [];
        }
        if ($user->isSuperAdmin()) {
            return null; // null = all
        }
        $ids = $user->branches()->pluck('branches.id')->all();
        if ($user->branch_id) {
            $ids[] = (int) $user->branch_id;
        }
        return array_values(array_unique($ids));
    }
}
