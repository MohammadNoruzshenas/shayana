<?php

namespace App\Http\Controllers\Admin\Repositories;

use App\Models\Content\Post;

class PostFilterRepo
{
    public $query;

    public function __construct()
    {
        $this->query = Post::query();
    }


    public function paginateParents($paginate)
    {
        return $this->query->latest()->paginate($paginate);
    }


    public function title($title)
    {
        if ($title)
            $this->query->where("title", $title);
        return $this;
    }

    public function first_name($first_name)
    {
        if ($first_name)
        $this->query->whereHas('author', function ($query) use ($first_name) {
            $query->where('first_name', 'like', '%' . $first_name . '%');
        });
        return $this;
    }
    public function last_name($last_name)
    {
        if ($last_name)
        $this->query->whereHas('author', function ($query) use ($last_name) {
            $query->where('last_name', 'like', '%' . $last_name . '%');
        });
        return $this;
    }
    public function confirmation_status($confirmation_status)
    {
        if(isset($confirmation_status))
        {
            $this->query->where('confirmation_status',$confirmation_status == 3 ? 0 : $confirmation_status);
            return $this;
        }else{
            return $this;
        }
    }
    public function email($email)
    {
        if (!is_null($email)) {
            $this->query->join("users", "posts.author_id", 'users.id')->select("posts.*", "users.email")->where("email", "like", "%" . $email . "%");
        }
        return $this;
    }
    public function getPostByAuthorId($user)
    {
            $this->query->where('author_id', $user->id)->get();
            return $this;
    }

}
