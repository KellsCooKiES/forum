<?php

namespace App\Filters;

use App\User;
use Illuminate\Http\Request;

class ThreadFilters extends Filters
{
    protected $filters = ['by'];

    /**
     * Filter a query by a given username.
     * @param string $username
     * @return mixed
     */
    protected function by(string $username)
    {
        $userId = User::where('name', $username)->firstOrFail()->id;

        return $this->builder->where('user_id', $userId);
    }

}
