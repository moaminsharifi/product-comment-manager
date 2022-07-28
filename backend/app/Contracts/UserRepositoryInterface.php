<?php
namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
interface UserRepositoryInterface {
    public function getByEmail(string $email): User;
}