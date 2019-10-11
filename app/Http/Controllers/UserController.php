<?php

namespace App\Http\Controllers;

use Mail;
use Socialite;
use Validator;  // 驗證器
use Hash;       // 雜湊
use App\Entities\User;   // 使用者 Eloquent Model
use Exception;
use Image;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    public function signUpPage()
    {
        $binding = [
            'title' => "註冊",
        ];
        return view('user.sign-up', $binding);
    }

    public function signUpProcess()
    {
        $input = request()->all();

        $rules = [
            'account' => 'required|max:150|email|unique:users',
            'password' => 'required|same:password_confirmation|between:6,12',
            'password_confirmation' => 'required|between:6,12',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'phone' => 'required|numeric',
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return redirect('/sign-up')
                ->withErrors($validator)
                ->withInput();
        }

        $input['password'] = Hash::make($input['password']);

        $input = array_merge(
            $input,
            [
                'mail' => $input['account']
            ]
        );

        User::create($input);

        return redirect('/');
    }

    public function signInProcess()
    {

        if (!session()->has('url.intended')) {
            session()->put('url.intended', url()->previous());
        }

        $input = request()->all();

        $rules = [
            'account' => 'required|max:150|email',
            'password' => 'required|between:6,12',
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return redirect()->intended('/')
                ->withErrors($validator)
                ->withInput();
        }


        try {
            $user = User::where('account', $input['account'])->firstOrFail();
        } catch (Exception $e) {
            $error_message = [
                'msg' => [
                    "帳號錯誤",
                ],
            ];

            return redirect()->intended('/')
                ->withErrors($error_message)
                ->withInput();
        }
        $is_password_correct = Hash::check($input['password'], $user->password);

        if (!$is_password_correct) {
            $error_message = [
                'msg' => [
                    '密碼驗證錯誤',
                ],
            ];

            return redirect()->intended('/')
                ->withErrors($error_message)
                ->withInput();
        }


        if (is_null($user->photo)) {
            // 設定商品照片網址
            session()->put('photo', url("img/profile.png"));
        } else {
            session()->put('photo', url($user->photo));
        }

        session()->put('user_id', $user->id);

        return redirect()->intended('/');
    }

    public function googleSignInProcess()
    {
        return Socialite::driver('google')
            ->redirect();
    }

    public function googleSignInCallbackProcess()
    {
        if (!session()->has('url.intended')) {
            session()->put('url.intended', url()->previous());
        }

        if (request()->error == 'access_denied') {
            throw new Exception('授權失敗，存取錯誤');
        }

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('/');
        }

        $google_email = $googleUser->getEmail();

        if (is_null($google_email)) {
            throw new Exception('未授權取得使用者 Email');
        }

        $google_id = $googleUser->getId();

        $user = User::where('fb_account', $google_id)->first();

        if (is_null($user)) {
            $user = User::where('mail', $google_email)->first();
            if (!is_null($user)) {
                // 有此帳號，綁定 Facebook Id
                $user->fb_account = $google_id;
                $user->save();
            }
        }

        if (is_null($user)) {
            $password = substr(uniqid(),0,8);
            $input = [
                'account' => $google_email,
                'mail' => $google_email,
                'phone' => "1111111",
                'first_name' => $googleUser->getFirstname(),
                'last_name' => $googleUser->getLastname(),
                'password' => $password,
                'fb_account' => $google_id,
            ];
            $input['password'] = Hash::make($input['password']);
            $user = User::create($input);
        }

        session()->put('user_id', $user->id);
        session()->put('is_google_account', true);

        return redirect()->intended('/');
    }

    public function signOut()
    {
        session()->forget('user_id');
        session()->forget('photo');
        session()->forget('is_google_account');

        return redirect('/');
    }

    public function profilePage($id)
    {
        $user = User::findOrFail($id);
        if (!isset($user->photo)) {
            $user->photo = "/img/profile.png";
            session()->put('photo', url($user->photo));
        } else {
            session()->put('photo', url($user->photo));
        }

        $binding = [
            'user' => $user,
            'title' => "個人檔案",
        ];
        return view('user.profile', $binding);
    }

    public function updateProfile($id)
    {
        $user = User::findOrFail($id);
        $input = request()->all();

        $rules = [
            'password' => 'nullable|same:password_confirmation|min:6|max:12',
            'password_confirmation' => 'nullable|min:6|max:12',
            'photo' => 'max:20|mimes:jpeg,bmp,png',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'phone' => 'required|numeric',
            'country' => 'max:20',
            'birth_date' => 'date_format:Y-m-d',
            'gender' => 'in:m,f',
            'mail' => 'required|max:150|email',
        ];

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            return redirect('/users/' . $user->id)
                ->withErrors($validator)
                ->withInput();
        }

        if (isset($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input['password'] = $user->password;
        }


        if (isset($input['photo'])) {
            $photo = $input['photo'];
            $file_extension = $photo->getClientOriginalExtension();
            $file_name = uniqid() . '.' . $file_extension;
            $file_relative_path = 'img/user/' . $file_name;
            $file_path = public_path($file_relative_path);
            $image = Image::make($photo)->fit(150, 150)->save($file_path);
            $input['photo'] = $file_relative_path;
        }

        $user->update($input);

        return redirect('/users/' . $user->id);
    }

    public function toursPage($id)
    {

        $user = User::findOrFail($id);
        $order_list = $user->orders()->orderBy('created_at', 'desc')->paginate(8);
        $binding = [
            'order_list' => $order_list,
            'title' => "我的旅程",
        ];

        return view('user.orders', $binding);
    }

    public function favoriteToursPage($user_id)
    {
        $user = User::findOrFail($user_id);
        $favorite_tours = $user->favoriteTours()->paginate(8);
        $binding = [
            'favorite_tours' => $favorite_tours,
            'title' => "我的收藏",
        ];

        return view('user.favorite-tours', $binding);
    }

    public function addFavoriteTour()
    {
        $isEnable = false;
        $input = request()->all();

        $user = User::findOrFail($input['user_id']);

        if (!is_null($user->favoriteTours) && $user->favoriteTours->contains($input['tour_id'])) {
            $user->favoriteTours()->detach($input['tour_id']);
            $isEnable = false;
        } else {
            $user->favoriteTours()->attach($input['tour_id']);
            $isEnable = true;
        }
        return response()->json(['isEnable' => $isEnable]);
    }
}
