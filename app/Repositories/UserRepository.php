<?php

namespace App\Repositories;

use App\User;

//use App\Scopes\StatusScope;

class UserRepository
{
    use BaseRepository;

    /**
     * User Model.
     *
     * @var User
     */
    protected $model;

    /**
     * Constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    /**
     * Get the list of all the user without myself.
     *
     * @return mixed
     */
    public function getList()
    {
        return $this->model
            ->orderBy('id', 'desc')
            ->get();
    }

    /**
     * Get the user by name.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function getByName($name)
    {
        return $this->model
                    ->where('name', $name)
                    ->first();
    }

    /**
     * Get number of the records.
     *
     * @param int    $number
     * @param string $sort
     * @param string $sortColumn
     *
     * @return Paginate
     */
    public function page($number = 10, $sort = 'desc', $sortColumn = 'created_at')
    {
        return $this->model->orderBy($sortColumn, $sort)->paginate($number);
    }

    /**
     * Get the article record without draft scope.
     *
     * @param int $id
     *
     * @return mixed
     */
    public function getById($id)
    {
        return $this->model->withoutGlobalScope(StatusScope::class)->findOrFail($id);
    }

    /**
     * Store a new record.
     *
     * @param  $input
     *
     * @return User
     */
    public function store($input)
    {
        $input['password'] = bcrypt($input['password']);

        return $this->save($this->model, $input);
    }

    /**
     * Update the article record without draft scope.
     *
     * @param int   $id
     * @param array $input
     *
     * @return bool
     */
    public function update($id, $input)
    {
        $this->model = $this->model->withoutGlobalScope(StatusScope::class)->findOrFail($id);

        return $this->save($this->model, $input);
    }

    /**
     * Change the user password.
     *
     * @param App\User $user
     * @param string   $password
     *
     * @return bool
     */
    public function changePassword($user, $password)
    {
        return $user->update(['password' => bcrypt($password)]);
    }

    /**
     * Save the user avatar path.
     *
     * @param int    $id
     * @param string $photo
     *
     * @return bool
     */
    public function saveAvatar($id, $photo)
    {
        $user = $this->getById($id);

        $user->avatar = $photo;

        return $user->save();
    }

    /**
     * Delete the draft article.
     *
     * @param int $id
     *
     * @return bool
     */
    public function destroy($id)
    {
        return $this->getById($id)->delete();
    }

    /**
     * Delete multiple users.
     *
     * @param array $ids
     *
     * @return bool|null
     */
    public function deleteMultiple($ids)
    {
        foreach ($ids as $id) {
            $user = $this->user->find($id);
            if (is_null($user)) {
                continue;
            }

            $user->roles()->detach();
            $user->delete();
        }

        return $ids;
    }

    public function searchUser($query)
    {
        return $this->model->where('name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->orWhere('firstname', 'like', "%$query%")
            ->orWhere('lastname', 'like', "%$query%")
            ->get();
    }
}
