<?php


namespace vanndy\phpmvc;


use vanndy\phpmvc\db\DbModel;

abstract class UserModel extends DbModel
{
    // return as string
    abstract public function getDisplayName(): string;
}