<?php

namespace App\Http\Controllers;

use App\Domain\Repositories\UserRepository;
use App\Http\Requests\User\PasswordRequest;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserEditRequest;
use Illuminate\Http\Request;
use App\Domain\Contracts\UserInterface;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * UserController constructor.
     * @param UserInterface $user
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
         $this->middleware('auth');
    }

    /**
     * @api {get} api/user Request User with Paginate
     * @apiName GetUserWithPaginate
     * @apiGroup User
     *
     * @apiParam {Number} page Paginate User lists
     */
    public function index(Request $request)
    {
        return $this->user->paginate(10, $request->input('page'), $column = ['*'], '', $request->input('term'));
    }
    public function updatePass(PasswordRequest $request)
    {
        return $this->user->updatePassword($request->all());
    }


    /**
     * @api {get} api/user/id Request Get User
     * @apiName GetUser
     * @apiGroup user
     *
     * @apiParam {Number} id id_user
     * @apiSuccess {Number} id id_user
     * @apiSuccess {Varchar} username of user
     * @apiSuccess {Time} email of user
     * @apiSuccess {Time} password of user
     * @apiSuccess {Number} level of user
     * @apiSuccess {Number} pin of user
     */
    public function show($id)
    {
        return $this->user->findById($id);
    }

    /**
     * @api {user} api/user/ Request User User
     * @apiName UserUser
     * @apiGroup User
     *
     * @apiParam {Varchar} username of user
     * @apiParam {Time} email of address
     * @apiParam {Varchar} password of user
     * @apiParam {Varchar} level of user
     * @apiSuccess {Number} pin of user
     * @apiSuccess {Number} id of user
     */
    public function store(UserCreateRequest $request)
    {
        return $this->user->create($request->all());
    }

    /**
     * @api {put} api/user/id Request Update User by ID
     * @apiName UpdateUserByID
     * @apiGroup User
     *
     * @apiParam {Varchar} username of user
     * @apiParam {Time} email of user
     * @apiParam {Time} password of user
     * @apiParam {Varchar} level of user
     * @apiParam {Number} pin of user
     * @apiParam {Number} id of user
     *
     * @apiError EmailHasRegitered The Email must diffrerent.
     */
    public function update(Request $request, $id)
    {
        return $this->user->update($id, $request->all());
    }

    /**
     * @api {delete} api/user/id Request Delete User by ID
     * @apiName DeleteUserByID
     * @apiGroup User
     *
     * @apiParam {Number} id id of user
     *
     * @apiError UserNotFound The <code>id</code> of the User was not found.
     * @apiError NoAccessRight Only authenticated Admins can access the data.
     */
    public function destroy($id)
    {
        return $this->user->delete($id);
    }

    public function getSession()
    {
        $this->middleware('auth');
        if (session('email') == null) {
            return response()->json(
                [
                    'success' => false,
                    'result' => 'redirect'
                ], 401
            );
        }
//dump(Auth::user());
        return response()->json([
            'success' => true,
            'result' => [
                'username' => session('username'),
                'email' => session('email'),
                'user_id' => session('user_id'),
                'level' => session('level'),


            ]]);
    }

}
