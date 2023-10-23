<?php

namespace App\Repositories\Expenditure;

use App\Models\HistoryTransaction;
use Illuminate\Support\Facades\Auth;

class ExpenditureRepositoryImplement implements ExpenditureRepository
{
    private $model;
    public function __construct(HistoryTransaction $model)
    {
        $this->model = $model;
    }

    public function getExpenditure()
    {
        $user = Auth::user();

        return $this->model->with('category')
            ->where('user_id', $user->id)
            ->where('content', 'expenditure')
            ->where('status', 'paid')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
