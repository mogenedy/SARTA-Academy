<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\AssignRoleRequest;
use App\Http\Requests\User\BanUserRequest;
use App\Http\Requests\User\DetchInstitueRequest;
use App\Http\Requests\User\IndexUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexUserRequest $request)
    {
        
        $data = $request->validated();

        // return User::find(4)->with('researcher_profile');
        $query = User::query()->withoutRole('super_admin')->with('researcher_profile');

        $query->when(isset($data['query']) , function($query) use($data){
            $query->where('email' , 'like' , '%'.$data['query'].'%')
                 ->orWhere('name' , 'like' , '%'.$data['query'].'%'); 
        })
        ->when(isset($data['ban']) , function($query) use($data){
            if($data['ban']){
                $query->banned();
            }else{
                $query->active();
            }
        });

        $users = $query->paginate($data['per_page'] ?? 15);

        return $this->respondOk(UserResource::collection($users) , __('user.index'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);
        
        $user->assignRole($data['role']);

        if ($data['role'] == 'editor') {
            $user->editable_institutes()->attach($data['institute_id']);
        }else if ($data['role'] == 'researcher') {
            $user->departments()->syncWithoutDetaching($data['department_id']);
        }

        return $this->respondCreated(UserResource::make($user) , __('user.store'));
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->respondOk(UserResource::make($user->load('researcher_profile')) , __('user.show'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update_profile(UpdateUserRequest $request, User $user)
    {
        $user = $request->user;

        $data = $request->validated();

        $user->update($data);

        if ($request->hasFile('image')) { 
            $user->clearMediaCollection("main");
            $user->addMediaFromRequest('image')->toMediaCollection("main");
        }

        return $this->respondOk(UserResource::make($user->load('researcher_profile')) , __('user.update'));
    }

    public function profile(Request $request)
    {
        $user = $request->user;
        return $this->respondOk(UserResource::make($user->load('researcher_profile')) , __('user.show'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function ban_user(BanUserRequest $request, User $user)
    {
        
        $data = $request->validated();

        if ($user->hasRole('super_admin')){
            return $this->respondError('Super admin cannot be banned');
        }
        
        if (!isset($data['ban'])) {
            $data['ban'] = null;
            $user->update($data);
        } else {
            $data['ban'] = Carbon::parse($data['ban']);
            $user->update($data);
        }

        return $this->respondOk(UserResource::make($user) , __('user.update'));
    }

    public function assign_role(AssignRoleRequest $request , User $user)
    {
        $data = $request->validated();

        if ($user->hasRole('super_admin')){
            return $this->respondError("Can't assign a role to super admin");
        }

        if ($data['role'] == 'editor'){
            $user->editable_institutes()->syncWithoutDetaching($data['institute_id']);
        } else if ($data['role'] == 'researcher') {
            $user->departments()->syncWithoutDetaching($data['department_id']);
        }

        $user->syncRoles([$data['role']]);

        return $this->respondOk(UserResource::make($user) , __('user.update'));

    }

    public function detach_institute(DetchInstitueRequest $request , User $user)
    {
        
        $data = $request->validated();

        if ($user->hasRole('editor')){

            $user->editable_institutes()->detach($data['institute_id']);

            // $user->syncRoles(['client']);

            return $this->respondNoContent();

        } else if ($user->hasRole('researcher')) {

            $user->departments()->detach([$data['department_id']]);

            // $user->syncRoles(['client']);
            return $this->respondNoContent();
            
        }  else {
            return $this->respondError("Can't detach from " . $user->getRoleNames()[0]);
        }

    }

    public function swapResercher(User $fResercher , User $sResercher)
    {
        User::swapOrder($fResercher , $sResercher);

        return $this->respondNoContent();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
