<?php

namespace App\Repositories\Income;

use App\Models\HistoryTransaction;
use Illuminate\Support\Facades\Auth;

class IncomeRepositoryImplement implements IncomeRepository
{
    private $model;
    public function __construct(HistoryTransaction $model)
    {
        $this->model = $model;
    }
    public function getIncome()
    {
        $user = Auth::user();

        return $this->model->with('category')
            ->where('user_id', $user->id)
            ->where('content', 'income')
            ->where('status', 'paid')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
