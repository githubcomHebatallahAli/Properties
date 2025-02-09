<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Admin;
use App\Models\Broker;
use App\Models\Chalet;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChaletPolicy
{

    use HandlesAuthorization;
    public function updateSale($user, Chalet $chalet)
    {


if ($user instanceof Admin && $user->role->name === 'Super Admin') {
    return true;
}

// إذا كان المستخدم من نوع Broker وكان هو السمسار الذي يملك الشاليه
if ($user instanceof Broker && $user->id === $chalet->broker_id) {
    return true;
}

// إذا كان المستخدم من نوع User وكان هو صاحب الشاليه
if ($user instanceof User && $user->id === $chalet->user_id) {
    return true;
}

// إذا لم تتحقق أي من الشروط السابقة، سيتم منع الوصول
return false;
}

}
