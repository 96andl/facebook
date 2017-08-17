<?php

/**
 * Created by PhpStorm.
 * User: ANDR
 * Date: 15.08.2017
 * Time: 23:08
 */
namespace App\Repositories;
use App\User;

class UserRepository
{
    private $model;
    public function __construct(User $user)
    {
        $this->model = $user;
    }

    public  function create (array $data) {
        $userData = $this->model->create($data);
        return $userData;
    }

    public function findOrCreateSocialUser($type, $id, $userObj) {
        $user = $this->model
            ->where('sns_acc_id',$id)
            ->first()                       ;

        if($user) {
            return true;
        }

        if($type == 'facebook') {
            $user = $this->createFacebookUser($userObj);
            return true;
        }
        return false;
    }

    private function createFacebookUser($userObj) {
        $userData = [
            'name' => isset($userObj->name) ? $userObj->name : '',
            'email' => isset($userObj->email) ? $userObj->email : '',
            'avatar_url' => isset($userObj->avatar_original) ? $userObj->avatar_original : '',
            'sns_acc_id' => $userObj->id,

        ];
        return $this->create($userData);
    }
}