<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class BoardController
 *
 * @package App\Http\Controllers
 */
class BoardController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function boards()
    {
        /** @var User $user */
        $user = Auth::user();

        $boards = Board::with(['user', 'boardUsers']);

        if ($user->role === User::ROLE_USER) {
            $boards = $boards->where(function ($query) use ($user) {
                //Suntem in tabele de boards in continuare
                $query->where('user_id', $user->id)
                    ->orWhereHas('boardUsers', function ($query) use ($user) {
                        //Suntem in tabela de board_users
                        $query->where('user_id', $user->id);
                    });
            });
        }

        $boards = $boards->paginate(10);

        return view(
            'boards.index',
            [
                'boards' => $boards
            ]
        );
    }

    public function updateBoard(Request $request)
    {
        if(($board = Board::findOrFail($request->id)) && (auth()->user()->role === 1 || $board->user_id === auth()->user()->id)) {
            $board->update(['name' => $request->name]);
        }

        return redirect()->back();
    }

    public function deleteBoard($id)
    {
        if(($board = Board::findOrFail($id)) && (auth()->user()->role === 1 || $board->user_id === auth()->user()->id)) {
            $board->delete();
        }

        return redirect()->back();
    }

    /**
     * @param $id
     *
     * @return Application|Factory|View|RedirectResponse
     */
    public function board($id)
    {
        /** @var User $user */
        $user = Auth::user();

        $boards = Board::query();

        if ($user->role === User::ROLE_USER) {
            $boards = $boards->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)
                    ->orWhereHas('boardUsers', function ($query) use ($user) {
                        $query->where('user_id', $user->id);
                    });
            });
        }

        $board = clone $boards;

        $board = $board->where('id', $id)->with('tasks')->first();

        $boards = $boards->select('id', 'name')->get();

        if (!$board) {
            return redirect()->route('boards.all');
        }



        return view(
            'boards.view',
            [
                'board' => $board,
                'boards' => $boards
            ]
        );
    }
}
