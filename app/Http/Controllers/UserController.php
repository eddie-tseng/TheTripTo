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
    // 註冊
    public function signUpPage()
    {
        $binding = [
            'title' => "註冊",
        ];
        return view('user.sign-up', $binding);
    }

    // 處理註冊資料
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

        // 密碼加密
        $input['password'] = Hash::make($input['password']);

        $input = array_merge(
            $input,
            [
                'mail' => $input['account']
            ]
        );

        // 新增會員資料
        User::create($input);

        // 寄送註冊通知信
        // $mail_binding = [
        //     'nickname' => $input['nickname'],
        //     'email' => $input['email'],
        // ];

        // SendSignUpMailJob::dispatch($mail_binding)
        //     ->onQueue('high');
        return redirect('/');
    }

    //使用者資料
    public function profilePage($id)
    {
        // Get user profile
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

    //更新使用者資料
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

        // 驗證資料
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {
            // 資料驗證錯誤
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
            // 有上傳圖片
            $photo = $input['photo'];
            // 檔案副檔名
            $file_extension = $photo->getClientOriginalExtension();
            // 產生自訂隨機檔案名稱
            $file_name = uniqid() . '.' . $file_extension;
            // 檔案相對路徑
            $file_relative_path = 'img/user/' . $file_name;
            // 檔案存放目錄為對外公開 public 目錄下的相對位置
            $file_path = public_path($file_relative_path);
            // 裁切圖片
            $image = Image::make($photo)->fit(150, 150)->save($file_path);
            // 設定圖片檔案相對位置
            $input['photo'] = $file_relative_path;
        }

        // 商品資料更新
        $user->update($input);

        // 重新導向到商品編輯頁
        return redirect('/users/' . $user->id);
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
        // 檢查密碼是否正確
        $is_password_correct = Hash::check($input['password'], $user->password);

        if (!$is_password_correct) {
            // 密碼錯誤回傳錯誤訊息
            $error_message = [
                'msg' => [
                    '密碼驗證錯誤',
                ],
            ];

            return redirect()->intended('/')
                ->withErrors($error_message)
                ->withInput();
        }

        // $newSessionId = session()->getId();
        // $lastSessionId = session()->getHandler()->read($user->last_session_id);

        // if (strlen($lastSessionId) > 0) {
        //     session()->getHandler()->destroy($user->last_session_id));
        //  }

        // $user->last_session_id = $newSessionId;
        // $user->save();

        if (is_null($user->photo)) {
            // 設定商品照片網址
            session()->put('photo', url("img/profile.png"));
        } else {
            session()->put('photo', url($user->photo));
        }

        //session
        session()->put('user_id', $user->id);

        // 重新導向到原先使用者造訪頁面，沒有嘗試造訪頁則重新導向回首頁
        return redirect()->intended('/');
        //return redirect('/');
    }



    // 處理登出資料
    public function signOut()
    {
        // 清除 Session
        session()->forget('user_id');
        session()->forget('photo');
        // session()->forget('url.intended');
        // 重新導向回首頁
        return redirect('/');
    }

    // github 登入
    public function githubSignInProcess()
    {
        $redirect_url = env('GITHUB_REDIRECT');

        return Socialite::driver('github')
            ->redirectUrl($redirect_url)
            ->redirect();
    }

    // github 登入重新導向授權資料處理
    public function githubSignInCallbackProcess()
    {
        if (request()->error == 'access_denied') {
            throw new Exception('授權失敗，存取錯誤');
        }

        // 取得第三方使用者資料
        $GithubUser = Socialite::driver('github')->user();

        $github_email = $GithubUser->email;

        if (is_null($github_email)) {
            throw new Exception('未授權取得使用者 Email');
        }
        // 取得 Github 資料
        $github_id = $GithubUser->id;
        $github_name = $GithubUser->name;

        // 取得使用者資料是否有此 Github id 資料
        $user = User::where('github_id', $github_id)->first();

        if (is_null($user)) {
            // 沒有綁定 Github Id 的帳號，透過 Email 尋找是否有此帳號
            $user = User::where('email', $github_email)->first();
            if (!is_null($user)) {
                // 有此帳號，綁定 Github Id
                $user->github_id = $github_id;
                $user->save();
            }
        }

        if (is_null($user)) {
            // 尚未註冊
            $input = [
                'email'     => $github_email,   // Email
                'nickname'  => $github_name,    // 暱稱
                'password'  => uniqid(),        // 隨機產生密碼
                'github_id' => $github_id,      // Github ID
                'type'      => 'G',             // 一般使用者
            ];
            // 密碼加密
            $input['password'] = Hash::make($input['password']);
            // 新增會員資料
            $user = User::create($input);

            // 寄送註冊通知信
            $mail_binding = [
                'nickname' => $input['nickname'],
                'email' => $input['email'],
            ];

            SendSignUpMailJob::dispatch($mail_binding)
                ->onQueue('high');
        }

        // 登入會員
        // session 紀錄會員編號
        session()->put('id', $user->id);

        // 重新導向到原先使用者造訪頁面，沒有嘗試造訪頁則重新導向回首頁
        return redirect()->intended('/');
    }

    public function googleSignInProcess()
    {
        $redirect_url = env('GOOGLE_REDIRECT');

        return Socialite::driver('google')
            ->redirect();
    }

    public function googleSignInCallbackProcess()
    {
        if (request()->error == 'access_denied') {
            throw new Exception('授權失敗，存取錯誤');
        }
        $googleUser = Socialite::driver('google')->user();

        $google_email = $googleUser->getEmail;

        if (is_null($google_email)) {
            throw new Exception('未授權取得使用者 Email');
        }

        $google_id = $googleUser->getId;
        $google_name = $googleUser->getName;

        // 取得使用者資料是否有此 Github id 資料
        $user = User::where('facebook_id', $google_id)->first();

        if (is_null($user)) {
            // 沒有綁定 Facebook Id 的帳號，透過 Email 尋找是否有此帳號
            $user = User::where('email', $google_email)->first();
            if (!is_null($user)) {
                // 有此帳號，綁定 Facebook Id
                $user->facebook_id = $google_id;
                $user->save();
            }
        }

        if (is_null($user)) {
            $password = substr(uniqid(),0,8);
            $input = [
                'account' => $google_email,
                'mail' => $google_email,
                'phone' => "1111111",
                'first_name' => $google_name['givenName'],
                'last_name' => $google_name['familyName'],
                'password' => $password,
                'fb_account' => $google_id,
            ];
            // 密碼加密
            $input['password'] = Hash::make($input['password']);
            // 新增會員資料
            $user = User::create($input);
        }

        session()->put('user_id', $user->id);

        return redirect()->intended('/');
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
