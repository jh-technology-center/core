<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\User;

use Flarum\Foundation\AbstractValidator;

class UserValidator extends AbstractValidator
{
    /**
     * @var User
     */
    protected $user;

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * {@inheritdoc}
     */
    protected function getRules()
    {
        $idSuffix = $this->user ? ','.$this->user->id : '';

        return [
            'username' => [
                'required',
                // 'regex:/^[a-z0-9_-]+$/i',
                // 1. CJK基础上，不允许全数字用户名出现，防止个人主页报错。
                'regex:/^[-_a-zA-Z0-9\x7f-\xff]*[-_a-zA-Z\x7f-\xff][-_a-zA-Z0-9\x7f-\xff]*$/i',
                'unique:users,username'.$idSuffix,
                'min:3',
                'max:30'
            ],
            'email' => [
                'required',
                'email',
                'unique:users,email'.$idSuffix,
                'regex:/^[A-Za-z0-9_\-\.]+@ijheng\.com$/i',
            ],
            'password' => [
                'required',
                'min:8'
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getMessages()
    {
        return [
            'username.regex' => $this->translator->trans('core.api.invalid_username_message'),
            'email.regex' => '邮箱地址必须是以 @ijheng.com 结尾的企业邮箱',

        ];
    }
}
