<?php
// app/Traits/HasAuthorization.php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasAuthorization
{
    /**
     * Generate permission check based on the resource name.
     */
    protected static function generatePermissionCheck(string $action, string $resource): bool
    {
        // Cek jika user tidak null
        $user = auth()->user();

        // Jika user null, kembalikan false atau lakukan pengecekan lain yang sesuai
        if (!$user) {
            return false;
        }
        return auth()->user()->can("{$action}-{$resource}");
    }

    /**
     * Authorization for any.
     */
    public static function canViewAny(): bool
    {
        return static::generatePermissionCheck('view-any', static::getResourceName());
    }

    /**
     * Authorization for viewing the resource.
     */
    public static function canView(Model $record): bool
    {
        return static::generatePermissionCheck('view', static::getResourceName());
    }

    /**
     * Authorization for creating the resource.
     */
    public static function canCreate(): bool
    {
        return static::generatePermissionCheck('create', static::getResourceName());
    }

    /**
     * Authorization for editing the resource.
     */
    public static function canEdit(Model $record): bool
    {
        return static::generatePermissionCheck('update', static::getResourceName());
    }

    /**
     * Authorization for deleting the resource.
     */
    public static function canDelete(Model $record): bool
    {
        return static::generatePermissionCheck('delete', static::getResourceName());
    }
    /**
     * Authorization for deleting the resource.
     */
    public static function canDeleteAny(): bool
    {
        return static::generatePermissionCheck('delete', static::getResourceName());
    }

    /**
     * Get the resource name, can be overridden in the resource class if needed.
     */
    protected static function getResourceName(): string
    {
        // Mendapatkan nama model yang digunakan dalam resource
        $modelName = class_basename(static::$model); // Mengambil nama model (misalnya "ProductTag")

        // Mengubah nama model menjadi huruf kecil dan menambahkan tanda hubung (-) antara kata yang dipisahkan oleh huruf kapital
        $resourceName = strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $modelName));

        // Mengembalikan hasil nama resource
        return $resourceName;
    }
}
