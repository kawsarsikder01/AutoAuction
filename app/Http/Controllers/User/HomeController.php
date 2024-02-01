<?php

namespace App\Http\Controllers\User;


use App\Helpers\GoogleAuthenticator;
use App\Http\Controllers\Controller;
use App\Models\BiddingHistory;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\Kyc;
use App\Models\Language;
use App\Models\UserKyc;
use App\Models\Vehicle;
use App\Models\VehicleDetails;
use App\Traits\Upload;
use hisorange\BrowserDetect\Parser as Browser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class HomeController extends Controller
{
    use Upload;

    public function __construct()
    {
        $this->middleware(['auth']);
        $this->middleware(function ($request, $next) {
            $this->user = auth()->user();
            return $next($request);
        });
        $this->theme = template();
    }

    public function saveToken(Request $request)
    {
        Auth::user()
            ->fireBaseToken()
            ->create([
                'token' => $request->token,
            ]);
        return response()->json([
            'msg' => 'token saved successfully.',
        ]);
    }

    public function index()
    {
        $data['user'] = Auth::user();
        $data['firebaseNotify'] = config('firebase');
        $data['soldedVehicle'] = Vehicle::with('details')->whereHas('details',function ($query){
            $query->where('sold_status',1);
        })->where('user_id',Auth::user()->id)->get();

//        $data['averageSell'] = BiddingHistory::with(['Vehicle'=>function ($query) {
//            $query->where('user_id',Auth::user()->id);
//        }])->whereIn('bid_amount',function ($query){
//            $query->selectRaw('MAX(bid_amount)')->from('bidding_history')->groupBy('vehicle_id');
//        })->whereHas('Vehicle',function ($query){
//            $query->where('user_id',Auth::user()->id);
//        })
//            ->where('wining_status',1)->avg('bid_amount');
        $data['cancelAuction'] = Vehicle::where('release_status',2)->where('user_id',Auth::user()->id)->get();
        $data['totalWinAuction'] = Vehicle::with(['biddingHistory'=>function ($query) {
            $query->where('wining_status',1)->where('user_id',Auth::user()->id);
        },'details'=>function ($query) {
            $query->where('sold_status',1);
        }])
            ->whereHas('details', function ($query) {
                $query->where('sold_status', 1);
            })
            ->whereHas('biddingHistory',function ($query){
                $query->where('wining_status',1)->where('user_id',Auth::user()->id);
            })
            ->get();
        return view(template() . 'user.dashboard', $data);
    }

    public function kycShow($slug, $id)
    {
        $data['kycs'] = Kyc::where('status', 1)->get();
        $data['kyc'] = Kyc::where('status', 1)->findOrFail($id);
        return view($this->theme . 'user.kyc.show', $data);
    }

    public function profile()
    {
        $data['user'] = Auth::user();
        $data['languages'] = Language::all();
        $data['kyc'] = Kyc::where('status', 1)->get();
        return view(template() . 'user.profile.my_profile', $data);
    }

    public function profileUpdateImage(Request $request)
    {
        $user = Auth::user();
        if ($request->hasFile('image')) {
            $image = $this->fileUpload($request->image, config('filelocation.userProfile.path'), null,null,'avif', 60, $user->image, $user->image_driver);
            if ($image) {
                $profileImage = $image['path'];
                $ImageDriver = $image['driver'];
            }
        }
        $user->image = $profileImage ?? $user->image;
        $user->image_driver = $ImageDriver ?? $user->image_driver;
        $user->save();
        return back()->with('success', 'Updated Successfully.');
    }

    public function profileUpdate(Request $request)
    {
        $languages = Language::all()->map(function ($item) {
            return $item->id;
        });

        $req = $request->except('_method', '_token');
        $user = Auth::user();
        $rules = [
            'first_name' => 'required|string|min:1',
            'last_name' => 'required|string|min:1',
            'email' => 'email:rfc,dns',
            'phone' => 'required',
            'username' => "sometimes|required|alpha_dash|min:5|unique:users,username," . $user->id,
            'address' => 'required',
            'language_id' => Rule::in($languages),
        ];
        $message = [
            'firstname.required' => 'First Name field is required',
            'lastname.required' => 'Last Name field is required',
        ];

        $validator = Validator::make($req, $rules, $message);
        if ($validator->fails()) {
            $validator->errors()->add('profile', '1');

            return back()->withErrors($validator)->withInput();
        }
        $user->language_id = $req['language_id'];
        $user->firstname = $req['first_name'];
        $user->lastname = $req['last_name'];
        $user->email = $req['email'];
        $user->phone = $req['phone'];
        $user->username = $req['username'];
        $user->address_one = $req['address'];
        $user->save();
        return back()->with('success', 'Updated Successfully.');
    }


    public function updatePassword(Request $request)
    {
        $rules = [
            'current_password' => "required",
            'password' => "required|min:5|confirmed",
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            $validator->errors()->add('password', '1');
            return back()->withErrors($validator)->withInput();
        }
        $user = Auth::user();
        try {
            if (Hash::check($request->current_password, $user->password)) {
                $user->password = bcrypt($request->password);
                $user->save();
                return back()->with('success', 'Password Changes successfully.');
            } else {
                throw new \Exception('Current password did not match');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function kycVerificationSubmit(Request $request)
    {
        $data =  $request->except('_token', '_method');
        $reqData = array();
        foreach($data as $key => $value){
            if(is_numeric($value) == true){
                $reqData[$key] = (int) $value;
            }else{
                $reqData[$key] =  $value;
            }
        }
        $kyc = Kyc::where('id', $request->type)->where('status', 1)->firstOrFail();
        $params = $kyc->input_form;
        $rules = [];
        if ($params !== null) {
            foreach ($params as $key => $cus) {

                $rules[$key] = [$cus->validation == 'required' ? $cus->validation : 'nullable'];
                if ($cus->type === 'file') {
                    $rules[$key][] = 'image';
                    $rules[$key][] = 'mimes:jpeg,jpg,png';
                    $rules[$key][] = 'max:2048';
                } elseif ($cus->type === 'text') {
                    $rules[$key][] = 'max:191';
                } elseif ($cus->type === 'number') {
                    $rules[$key][] = 'integer';
                } elseif ($cus->type === 'textarea') {
                    $rules[$key][] = 'min:3';
                    $rules[$key][] = 'max:300';
                }
            }
        }
        $validator = Validator::make($reqData, $rules);
        if ($validator->fails()) {
            $validator->errors()->add($kyc->name, '1');
            return back()->withErrors($validator)->withInput();
        }
        $reqField = [];
        foreach ($request->except('_token', '_method', 'type') as $k => $v) {
            foreach ($params as $inKey => $inVal) {
                if ($k == $inKey) {
                    if ($inVal->type == 'file' && $request->hasFile($inKey)) {
                        try {
                            $file = $this->fileUpload($request[$inKey], config('filelocation.kyc.path'));
                            $reqField[$inKey] = [
                                'field_name' => $inVal->field_name,
                                'field_label' => $inVal->field_label,
                                'field_value' => $file['path'],
                                'field_driver' => $file['driver'],
                                'validation' => $inVal->validation,
                                'type' => $inVal->type,
                            ];
                        } catch (\Exception $exp) {
                            session()->flash('error', 'Could not upload your ' . $inKey);
                            return back()->withInput();
                        }
                    } else {
                        $reqField[$inKey] = [
                            'field_name' => $inVal->field_name,
                            'field_label' => $inVal->field_label,
                            'validation' => $inVal->validation,
                            'field_value' => $v,
                            'type' => $inVal->type,
                        ];
                    }
                }
            }
        }

        UserKyc::create([
            'user_id' => auth()->id(),
            'kyc_id' => $kyc->id,
            'kyc_type' => $kyc->name,
            'kyc_info' => $reqField,
            'validation_type' => $kyc->type
        ]);

        return back()->with('success', 'KYC Sent Successfully');
    }

    public function addFund()
    {
        $data['basic'] = basicControl();
        $data['gateways'] = Gateway::where('status', 1)->orderBy('sort_by', 'ASC')->get();
        return view(template() . 'user.fund.add_fund', $data);
    }

    public function fund(Request $request)
    {
        $basic = basicControl();
        $userId = Auth::id();
        $funds = Deposit::with(['depositable', 'gateway'])
            ->where('user_id', $userId)
            ->orderBy('id', 'desc')
            ->latest()->paginate($basic->paginate);
        return view($this->theme . 'user.fund.index', compact('funds'));

    }

    public function twoStepSecurity()
    {
        $basic = basicControl();
        $ga = new GoogleAuthenticator();
        $secret = $ga->createSecret();
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($this->user->username . '@' . $basic->site_title, $secret);
        $previousCode = $this->user->two_fa_code;

        $previousQR = $ga->getQRCodeGoogleUrl($this->user->username . '@' . $basic->site_title, $previousCode);
        return view($this->theme . 'user.twoFA.index', compact('secret', 'qrCodeUrl', 'previousCode', 'previousQR'));
    }

    public function twoStepEnable(Request $request)
    {
        $user = $this->user;
        $this->validate($request, [
            'key' => 'required',
            'code' => 'required',
        ]);
        $ga = new GoogleAuthenticator();
        $secret = $request->key;
        $oneCode = $ga->getCode($secret);
        $userCode = $request->code;
        // dd($oneCode);
        if ($oneCode == $userCode) {
            $user['two_fa'] = 1;
            $user['two_fa_verify'] = 1;
            $user['two_fa_code'] = $request->key;
            $user->save();
            $browser = new Browser();
            $this->mail($user, 'TWO_STEP_ENABLED', [
                'action' => 'Enabled',
                'code' => $user->two_fa_code,
                'ip' => request()->ip(),
                'browser' => @$browser->browserName() . ', ' . @$browser->platformName(),
                'time' => date('d M, Y h:i:s A'),
            ]);
            return back()->with('success', 'Google Authenticator Has Been Enabled.');
        } else {
            return back()->with('error', 'Wrong Verification Code.');
        }
    }


    public function twoStepDisable(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);
        $user = $this->user;
        $ga = new GoogleAuthenticator();

        $secret = $user->two_fa_code;
        $oneCode = $ga->getCode($secret);
        $userCode = $request->code;

        if ($oneCode == $userCode) {
            $user['two_fa'] = 0;
            $user['two_fa_verify'] = 1;
            $user['two_fa_code'] = null;
            $user->save();
            $browser = new Browser();
            $this->mail($user, 'TWO_STEP_DISABLED', [
                'action' => 'Disabled',
                'ip' => request()->ip(),
                'browser' => @$browser->browserName() . ', ' . @$browser->platformName(),
                'time' => date('d M, Y h:i:s A'),
            ]);

            return back()->with('success', 'Google Authenticator Has Been Disabled.');
        } else {
            return back()->with('error', 'Wrong Verification Code.');
        }
    }

}
