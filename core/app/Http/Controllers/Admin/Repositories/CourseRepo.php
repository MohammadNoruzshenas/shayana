<?php
namespace App\Http\Controllers\Admin\Repositories;

use App\Models\Market\Course;
use App\Models\Market\Lession;

class CourseRepo{
    public $query;

    public function __construct()
    {
        $this->query = Course::query();
    }


    public function confirmationStatus($confirmation_status)
    {

        if(isset($confirmation_status))
        {
            $this->query->where('confirmation_status',$confirmation_status == 3 ? 0 : $confirmation_status);
            return $this;
        }else{
            return $this;
        }
    }

    public function searchTitle($title)
    {
        $this->query->where("title", "like", "%" . $title . "%");
        return $this;
    }
    public function getCoursesByTeacherId($user)
    {
            $this->query->where('teacher_id', $user->id)->get();
            return $this;
    }


    public function paginateParents($paginate)
    {
        return $this->query->latest()->paginate($paginate);
    }
    public function searchEmail($email)
    {
        if (!is_null($email)) {
            $this->query->join("users", "courses.teacher_id", 'users.id')->select("courses.*", "users.email")->where("email", "like", "%" . $email . "%");
        }

        return $this;
    }
    public function getDuration($id)
    {
        return $this->getLessonsQuery($id)->sum('time');
    }
    private function getLessonsQuery($id)
    {
        return Lession::where('course_id', $id)
            ->where('confirmation_status', 1);
    }
    public function getLessons($id)
    {
        return $this->getLessonsQuery($id)->get();
    }


}
