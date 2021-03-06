<?php

namespace App\Http\Controllers;

use Socialite;
use Validator;
use Hash;
use App\Entities\User;
use Exception;
use Image;

class UserController extends Controller
{
    /**
     * Get sign-up page
     *
     * @return View
     */
    public function signUpPage()
    {
        $binding = [
            'title' => "註冊",
        ];
        return view('user.sign-up', $binding);
    }

    /**
     * Add a new user
     *
     * @return RedirectResponse
     */
    public function signUpProcess()
    {
        $input = request()->all();

        $rules = [
            'account' => 'required|max:150|email|unique:users',
            'password' => 'required|same:password_confirmation|between:6,12',
            'password_confirmation' => 'required|between:6,12',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'phone' => 'nullable|numeric',
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
                'mail' => $input['account'],
                'photo' => "img/site/profile.png"
            ]
        );

        User::create($input);

        return redirect('/');
    }

    /**
     * User sign-in with normal account
     *
     * @return RedirectResponse
     */
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

        session()->put('photo', url($user->photo));
        session()->put('user_id', $user->id);

        return redirect()->intended('/');
    }

    /**
     * Redirect to google sign-in page.
     *
     * @return RedirectResponse
     */
    public function googleSignInProcess()
    {
        return Socialite::driver('google')
            ->redirect();
    }

    /**
     * Call back to google API and get google account information.
     * If user has an account, user will sign-in successfully.
     * If user doesn't have an account, user will get a new account.
     *
     * @return RedirectResponse
     */
    public function googleSignInCallbackProcess()
    {
        if (!session()->has('url.intended')) {
            session()->put('url.intended', url()->previous());
        }

        if (request()->error == 'access_denied') {
            throw new Exception('存取錯誤');
        }

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('/');
        }

        $google_id = $googleUser->getId();
        $google_email = $googleUser->getEmail();
        $google_firstname = $googleUser->getFirstname();
        $google_lastname = $googleUser->getLastname();

        if (is_null($google_id) || is_null($google_email) || is_null($google_firstname) || is_null($google_lastname)) {
            throw new Exception('未取得使用者資料');
        }

        $user = User::where('google_account', $google_id)->first();

        if (is_null($user)) {
            if (!is_null($user->google_account)) {
                $user->google_account = $google_id;
                $user->save();
            } else {
                $password = substr(uniqid(), 0, 8);
                $input = [
                    'account' => $google_email,
                    'mail' => $google_email,
                    'first_name' => $google_firstname,
                    'last_name' => $google_lastname,
                    'password' => $password,
                    'google_account' => $google_id,
                    'photo' => "img/site/profile.png"
                ];
                $input['password'] = Hash::make($input['password']);
                $user = User::create($input);
            }
        }

        session()->put('user_id', $user->id);
        session()->put('is_google_account', true);

        return redirect()->intended('/');
    }

    /**
     * Sign-out and redirect to index page.
     *
     * @return RedirectResponse
     */
    public function signOut()
    {
        session()->forget('user_id');
        session()->forget('photo');
        session()->forget('is_google_account');

        return redirect('/');
    }

    /**
     * Get user's porfile page.
     *
     * @param int $user_id
     * @return View
     */
    public function profilePage($user_id)
    {
        $user = User::findOrFail($user_id);
        if (!isset($user->photo)) {
            $user->photo = "/img/site/profile.png";
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

    /**
     * update user's porfile page.
     *
     * @param int $user_id
     * @return View
     */
    public function updateProfile($user_id)
    {
        $user = User::findOrFail($user_id);
        $input = request()->all();

        $rules = [
            'password' => 'nullable|same:password_confirmation|min:6|max:12',
            'password_confirmation' => 'nullable|min:6|max:12',
            'photo' => 'max:20|mimes:jpeg,bmp,png',
            'first_name' => 'required|max:50',
            'last_name' => 'required|max:50',
            'phone' => 'nullable|numeric',
            'country' => 'max:20',
            'birth_date' => 'nullable|date_format:Y-m-d',
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
            Image::make($photo)->fit(150, 150)->save($file_path);
            $input['photo'] = $file_relative_path;
        }

        $user->update($input);

        return redirect('/users/' . $user->id);
    }

    /**
     * Get user's orders.
     *
     * @param int $user_id
     * @return View
     */
    public function toursPage($user_id)
    {
        $user = User::findOrFail($user_id);
        $order_list = $user->orders()->orderBy('created_at', 'desc')->paginate(8);
        $binding = [
            'order_list' => $order_list,
            'title' => "我的旅程",
        ];

        return view('user.orders', $binding);
    }

    /**
     * Get user's favorite Tours.
     *
     * @param int $user_id
     * @return View
     */
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

    /**
     * Add a tour in user's favorite Tours.
     *
     * @return JsonResponse
     */
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
