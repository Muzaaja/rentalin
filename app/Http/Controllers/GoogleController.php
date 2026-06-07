use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GoogleController extends Controller
{

    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {

        $googleUser = Socialite::driver('google')->user();

        $user = User::where('email',$googleUser->email)->first();

        if(!$user){

            $user = User::create([
                'name'=>$googleUser->name,
                'email'=>$googleUser->email,
                'google_id'=>$googleUser->id,
                'avatar'=>$googleUser->avatar,
                'password'=>bcrypt(Str::random(16))
            ]);

        }else{

            $user->update([
                'google_id'=>$googleUser->id,
                'avatar'=>$googleUser->avatar
            ]);

        }

        Auth::login($user,true);

        return redirect('/');

    }

}