<?php

namespace Wefabric\FilamentExcelImport\Policies;

use App\Models\User;
use Wefabric\FilamentExcelImport\Models\ExcelImport;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExcelImportPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->can('view_domains::excel::filament::excel::import') || $this->viewOwn($user);
    }

    public function viewOwn(User $user)
    {
        return $user->can('view_own_domains::excel::filament::excel::import');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param ExcelImport $excelImport
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ExcelImport $excelImport)
    {
        if(!$user->hasPermissionTo('view_any_domains::excel::filament::excel::import')) {
//            if ($user->hasPermissionTo('view_own_domains::excel::filament::excel::import')) {
//                $brandIds = $user->getBrands()->pluck('id')->toArray();
//                return in_array($excelImport->brand_id, $brandIds);
//            }
            return false;
        }
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->can('create_domains::excel::filament::excel::import');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param ExcelImport $excelImport
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ExcelImport $excelImport)
    {
        if(!$user->hasPermissionTo('update_domains::excel::filament::excel::import')) {
//            if ($user->hasPermissionTo('update_own_domains::excel::filament::excel::import')) {
//                $brandIds = $user->getBrands()->pluck('id')->toArray();
//                return in_array($excelImport->brand_id, $brandIds);
//            }
            return false;
        }
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param ExcelImport $excelImport
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ExcelImport $excelImport)
    {
        if(!$user->hasPermissionTo('delete_domains::excel::filament::excel::import')) {
//            if ($user->hasPermissionTo('delete_own_domains::excel::filament::excel::import')) {
//                $brandIds = $user->getBrands()->pluck('id')->toArray();
//                return in_array($excelImport->brand_id, $brandIds);
//            }
            return false;
        }
        return true;
    }

    /**
     * Determine whether the user can bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function deleteAny(User $user)
    {
        return $user->can('delete_any_domains::excel::filament::excel::import') || $this->deleteOwn($user);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function deleteOwn(User $user)
    {
        return $user->can('delete_own_domains::excel::filament::excel::import');
    }

    /**
     * Determine whether the user can permanently delete.
     *
     * @param  \App\Models\User  $user
     * @param ExcelImport $excelImport
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ExcelImport $excelImport)
    {
        if(!$user->hasPermissionTo('force_delete_domains::excel::filament::excel::import')) {
//            if ($user->hasPermissionTo('force_delete_own_domains::excel::filament::excel::import')) {
//                $brandIds = $user->getBrands()->pluck('id')->toArray();
//                return in_array($excelImport->brand_id, $brandIds);
//            }
            return false;
        }
        return true;
    }

    /**
     * Determine whether the user can permanently bulk delete.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDeleteAny(User $user)
    {
        return $user->can('force_delete_any_domains::excel::filament::excel::import') || $this->forceDeleteOwn($user);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function forceDeleteOwn(User $user)
    {
        return $user->can('force_delete_own_domains::excel::filament::excel::import');
    }

    /**
     * Determine whether the user can restore.
     *
     * @param  \App\Models\User  $user
     * @param ExcelImport $excelImport
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ExcelImport $excelImport)
    {
        if(!$user->hasPermissionTo('restore_domains::excel::filament::excel::import')) {
//            if ($user->hasPermissionTo('restore_own_domains::excel::filament::excel::import')) {
//                $brandIds = $user->getBrands()->pluck('id')->toArray();
//                return in_array($excelImport->brand_id, $brandIds);
//            }
            return false;
        }
        return true;
    }

    /**
     * Determine whether the user can bulk restore.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restoreAny(User $user)
    {
        return $user->can('restore_any_domains::excel::filament::excel::import') || $this->restoreOwn($user);
    }

    /**
     * @param User $user
     * @return bool
     */
    public function restoreOwn(User $user)
    {
        return $user->can('restore_own_domains::excel::filament::excel::import');
    }

    /**
     * Determine whether the user can replicate.
     *
     * @param  \App\Models\User  $user
     * @param ExcelImport $excelImport
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function replicate(User $user, ExcelImport $excelImport)
    {
        return $user->can('replicate_domains::excel::filament::excel::import');
    }

    /**
     * Determine whether the user can reorder.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function reorder(User $user)
    {
        return $user->can('reorder_domains::excel::filament::excel::import');
    }

}
