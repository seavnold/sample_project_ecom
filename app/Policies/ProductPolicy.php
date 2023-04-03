<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Product;

class ProductPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the given product can be updated by the user.
     */
    public function update(User $user, Product $product)
    {
        return $user->id === $product->user_id;
    }
}
