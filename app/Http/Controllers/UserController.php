<?php

namespace App\Http\Controllers;

use App\Domain\Entities\User;
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
        $this->middleware('auth');
        return $this->user->paginate(10, $request->input('page'), $column = ['*'], '', $request->input('term'));
    }
    public function updatePass(PasswordRequest $request)
    {
        $this->middleware('auth');
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
        $this->middleware('auth');
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
        $this->middleware('auth');

        return $this->user->create($request->all());
    }
    public function createbylangdingpage(Request $request)
    {
        return $this->user->createbylangdingpage($request->all());
    }
    public function Activation($token)
    {
        $verificationUser = User::where('verifikasi', $token)->first();
        if(isset($verificationUser) ){
            $user = $verificationUser->verifikasi;
            if($verificationUser->verifikasi != '0') {
                \DB::table('users')
                    ->where('id', $verificationUser->id)
                    ->update(['verifikasi' => 0]);
                session()->flash('auth_message2', 'Email Kamu Telah Terverifikasi. Silahkan login sekarang juga.');
                return redirect('/signin');
            }else{
                session()->flash('auth_message', 'Email Kamu Terlah Terverifikasi Sebelumnya. Silahkan login sekarang juga.');
                return redirect('/signin');

            }
        }else{
            session()->flash('auth_message', 'Maaf Email Tidak dapat di identifikasi.');
            return redirect('/sigup');
}
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
        $this->middleware('auth');
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
        $this->middleware('auth');
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
