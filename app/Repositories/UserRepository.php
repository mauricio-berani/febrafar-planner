<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * The UserRepository class provides a way to interact with the User data within the database.
 */
class UserRepository
{
    /**
     * @var User The User model instance.
     */
    protected $model;

    /**
     * Create a new UserRepository instance.
     *
     * @param  User  $model  The User model instance.
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Fetches users matching the provided search parameters, and paginates the result.
     *
     * @param  string|null  $search    The search query.
     * @param  string  $perPage   The number of items to be displayed per page.
     * @param  string  $orderBy   The column to sort the result by.
     */
    public function findAllMatches(?string $search, string $perPage, string $orderBy): Paginator
    {
        $query = $this->model->query();

        if ($search) {
            $query->where('name', 'like', "%$search%");
            $query->orWhere('email', 'like', "%$search%");
        }

        if ($orderBy) {
            $order = explode('-', $orderBy);

            if (count($order) === 2) {
                $column = strtolower($order[0]);
                $direction = strtolower($order[1]);

                if (
                    in_array($column, $this->model->getFillable()) &&
                    in_array($direction, ['asc', 'desc'])
                ) {
                    $query->orderBy($column, $direction);
                }
            }
        }

        return $query->paginate($perPage);
    }

    /**
     * Fetches all users.
     */
    public function findAll(): Collection
    {
        return $this->model->get();
    }

    /**
     * Fetches a single user based on the provided email.
     *
     * @param  string  $email  The user's email.
     */
    public function getOneByEmail(string $email): User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Creates a new user based on the provided data.
     *
     * @param  array  $data  The user data.
     */
    public function create(array $data): User|bool
    {
        DB::beginTransaction();

        try {
            $data['password'] = Hash::make($data['password']);
            $user = $this->model->create($data);
            DB::commit();

            return $user;
        } catch (\Throwable $error) {
            DB::rollBack();
            logger()->error('Error creating resource.', ['error' => $error]);

            return false;
        }
    }

    /**
     * Updates a user based on the provided data and user.
     *
     * @param  array  $data  The new user data.
     * @param  User  $user  The user loaded.
     */
    public function update(array $data, User $user): User|bool
    {
        DB::beginTransaction();

        try {
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

            $user->update($data);
            DB::commit();

            return $user;
        } catch (\Throwable $error) {
            DB::rollBack();
            logger()->error('Error updating resource.', ['error' => $error]);

            return false;
        }
    }

    /**
     * Deletes a user.
     *
     * @param  User  $user  The user loaded.
     */
    public function delete(User $user): bool
    {
        return $user->delete();
    }
}
