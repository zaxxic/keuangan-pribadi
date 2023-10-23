<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryRepositoryImplement implements CategoryRepository
{
    private $model;
    public function __construct(Category $model)
    {
        $this->model = $model;
    }
    public function UserCetegoryIncome()
    {
        $user = Auth::user();

        return $this->model->where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->orWhere(function ($query) {
                    $query->where('type', 'default');
                });
        })
            ->select('id', 'name', 'created_at')
            ->where('content', 'income')
            ->get();
    }
    public function UserCetegoryExpenditure()
    {
        
    }
}
