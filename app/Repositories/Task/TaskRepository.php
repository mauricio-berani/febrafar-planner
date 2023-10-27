<?php

namespace App\Repositories\Task;

use App\Models\Task\Task;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * The TaskRepository class provides a way to interact with the task data within the database.
 */
class TaskRepository
{

    /**
     * @var Task The Task model instance.
     */
    protected $model;

    /**
     * Create a new TaskRepository instance.
     *
     * @param  Task  $model The Task model instance.
     */
    public function __construct(Task $model)
    {
        $this->model = $model;
    }

    /**
     * Fetches tasks matching the provided search parameters, and paginates the result.
     *
     * @param  string|null  $search    The search query.
     * @param  string       $perPage   The number of items to be displayed per page.
     * @param  string       $orderBy   The column to sort the result by.
     * @return Paginator
     */
    public function findAllMatches(string|null $search, string $perPage, string $orderBy): Paginator
    {
        $query = $this->model->ofLoggedInUser()->newQuery();


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
     * Fetches all tasks.
     *
     * @return Collection
     */
    public function findAll(): Collection
    {
        return $this->model->ofLoggedInUser()->get();
    }

    /**
     * Creates a new task based on the provided data.
     *
     * @param  array  $data  The task.
     * @return Task|bool
     */
    public function create(array $data): Task|bool
    {
        DB::beginTransaction();

        try {
            $data['user_id'] = auth()->user()->id;
            $task = $this->model->create($data);
            DB::commit();

            return $task;
        } catch (\Throwable $error) {
            DB::rollBack();
            logger()->error('Error creating resource.', ['error' => $error]);

            return false;
        }
    }

    /**
     * Updates a task based on the provided data and task.
     *
     * @param  array  $data  The new task data.
     * @param  Task  $task  The task loaded.
     * @return Task|bool
     */
    public function update(array $data, Task $task): Task|bool
    {
        DB::beginTransaction();

        try {
            $task->update($data);
            DB::commit();

            return $task;
        } catch (\Throwable $error) {
            DB::rollBack();
            logger()->error('Error updating resource.', ['error' => $error]);

            return false;
        }
    }

    /**
     * Deletes a task.
     *
     * @param  Task  $task  The task loaded.
     * @return bool
     */
    public function delete(Task $task): bool
    {
        return $task->delete();
    }

    /**
     * This method checks for date conflicts among tasks.
     *
     * @param array $data Associative array containing 'start_date' and 'deadline' keys.
     * @return bool Returns true if there is a conflict, false otherwise.
     */
    public function hasConflict(array $data): bool
    {
        $startDate = $data['start_date'];
        $deadline  = $data['deadline'];
        $tasks = Task::ofLoggedInUser()->where(function ($query) use ($startDate, $deadline) {
            $query->where(function ($query) use ($startDate) {
                $query->where('start_date', '<=', $startDate)
                    ->where('deadline', '>=', $startDate);
            })
                ->orWhere(function ($query) use ($deadline) {
                    $query->where('start_date', '<=', $deadline)
                        ->where('deadline', '>=', $deadline);
                });
        })->get();

        return count($tasks) ? true : false;
    }
}
