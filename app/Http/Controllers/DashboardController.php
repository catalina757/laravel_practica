<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

/**
 * Class DashboardController
 *
 * @package App\Http\Controllers
 */
class DashboardController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $boards = Board::count();
        $tasks  = Task::count();
        $users  = User::count();

        return view('dashboard.index', [
            'boards' => $boards,
            'tasks'  => $tasks,
            'users'  => $users
        ]);
    }
}
