<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use App\Observers\UserObserver;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\CategoryRepositoryImplement;
use App\Repositories\Expenditure\ExpenditureRepository;
use App\Repositories\Expenditure\ExpenditureRepositoryImplement;
use App\Repositories\Income\IncomeRepository;
use App\Repositories\Income\IncomeRepositoryImplement;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;


class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   */
  public function register(): void
  {
    $this->app->bind(IncomeRepository::class, IncomeRepositoryImplement::class);
    $this->app->bind(CategoryRepository::class, CategoryRepositoryImplement::class);
    $this->app->bind(ExpenditureRepository::class, ExpenditureRepositoryImplement::class);
  }

  /**
   * Bootstrap any application services.
   */
  public function boot()
  {
    /**
     * Paginate a standard Laravel Collection.
     *
     * @param int $perPage
     * @param int $total
     * @param int $page
     * @param string $pageName
     * @return array
     */
    // Collection::macro('paginate', function ($perPage, $total = null, $page = null, $pageName = 'page'): LengthAwarePaginator {
    //   $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

    //   return new LengthAwarePaginator(
    //     $this->forPage($page, $perPage)->values(),
    //     $total ?: $this->count(),
    //     $perPage,
    //     $page,
    //     [
    //       'path' => LengthAwarePaginator::resolveCurrentPath(),
    //       'pageName' => $pageName,
    //     ]
    //   );
    // });

    Paginator::defaultView('vendor.pagination.bootstrap-5');

    Paginator::defaultSimpleView('vendor.pagination.simple-bootstrap-5');

    Validator::extend('date_before_today', function ($attribute, $value, $parameters, $validator) {
      $date = \Carbon\Carbon::parse($value);
      return $date->isBefore(\Carbon\Carbon::now());
    });

    Validator::extend('date_after_or_today', function ($attribute, $value, $parameters, $validator) {
      $selectedDate = \Carbon\Carbon::parse($value);
      $today = \Carbon\Carbon::now();

      return $selectedDate->isSameDayOrAfter($today);
    });

    User::observe(UserObserver::class);
  }
}
