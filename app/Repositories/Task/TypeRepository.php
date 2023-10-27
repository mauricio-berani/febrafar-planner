<?php

namespace App\Repositories\Task;

use App\Models\Task\Type;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * The TypeRepository class provides a way to interact with the task type data within the database.
 */
class TypeRepository
{

    /**
     * @var Type The Type model instance.
     */
    protected $model;

    /**
     * Create a new TypeRepository instance.
     *
     * @param  Type  $model The Type model instance.
     */
    public function __construct(Type $model)
    {
        $this->model = $model;
    }

    /**
     * Fetches types matching the provided search parameters, and paginates the result.
     *
     * @param  string|null  $search    The search query.
     * @param  string       $perPage   The number of items to be displayed per page.
     * @param  string       $orderBy   The column to sort the result by.
     * @return Paginator
     */
    public function findAllMatches(string|null $search, string $perPage, string $orderBy): Paginator
    {
        $query = $this->model->query();


        if ($search) {
            $query->where('name', 'like', "%$search%");
            $query->orWhere('status', 'like', "%$search%");
        }

        if ($orderBy) {
            $order = explode('-', $orderBy);

            if (count($order) === 2) {
                $column    = strtolower($order[0]);
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
     * Fetches all types.
     *
     * @return Collection
     */
    public function findAll(): Collection
    {
        return $this->model->get();
    }

    /**
     * Creates a new type based on the provided data.
     *
     * @param  array  $data  The task type.
     * @return Type|bool
     */
    public function create(array $data): Type|bool
    {
        DB::beginTransaction();

        try {
            $type = $this->model->create($data);
            DB::commit();

            return $type;
        } catch (\Throwable $error) {
            DB::rollBack();
            logger()->error('Error creating resource.', ['error' => $error]);

            return false;
        }
    }

    /**
     * Updates a type based on the provided data and type.
     *
     * @param  array  $data  The new type data.
     * @param  Type  $type  The type loaded.
     * @return Type|bool
     */
    public function update(array $data, Type $type): Type|bool
    {
        DB::beginTransaction();

        try {
            $type->update($data);
            DB::commit();

            return $type;
        } catch (\Throwable $error) {
            DB::rollBack();
            logger()->error('Error updating resource.', ['error' => $error]);

            return false;
        }
    }

    /**
     * Deletes a type.
     *
     * @param  Type  $type  The type loaded.
     * @return bool
     */
    public function delete(Type $type): bool
    {
        return $type->delete();
    }
}
