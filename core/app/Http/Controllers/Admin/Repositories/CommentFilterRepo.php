<?php

namespace App\Http\Controllers\Admin\Repositories;

use App\Models\Content\Comment;
use App\Models\User;

class CommentFilterRepo
{
    public $query;

    public function __construct()
    {
        $this->query = Comment::query();
    }



    public function approved($approved)
    {
        if (isset($approved)) {
            $this->query->where('approved', $approved == 3 ? 0 : $approved);
            return $this;
        } else {
            return $this;
        }
    }
    public function paginateParents($paginate)
    {
        return $this->query->latest()->paginate($paginate);
    }

    public function commentable_type($commentable_type)
    {
        $this->query->where('commentable_type', $commentable_type);
        return $this;
    }
}
