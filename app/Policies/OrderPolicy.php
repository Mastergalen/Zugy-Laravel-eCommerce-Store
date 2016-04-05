<?php

namespace App\Policies;

use App\Order;
use App\User;

class OrderPolicy extends BasePolicy
{
    public function before(User $user, $ability) {
        if($this->isAdmin($user)) {
            return true;
        }
    }

    public function show(User $user, Order $order)
    {
        return $user->id === $order->user_id;
    }

    public function adminUpdate(User $user, Order $order) {
        return $this->isAdmin($user);
    }
}