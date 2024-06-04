<?php 

namespace App\Services;

use App\Models\Member;

class MemberService
{
    public function registerMember(array $data)
    {
        $member = Member::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        // Perform any additional actions, such as sending a verification email, if needed

        return $member;
    }
}