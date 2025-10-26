<?php

namespace App\Http\Controllers\User;


use App\Helpers\GoogleAuthenticator;
use App\Http\Controllers\Controller;
use App\Models\BiddingHistory;
use App\Models\Deposit;
use App\Models\Gateway;
use App\Models\Kyc;
use App\Models\Language;
use App\Models\Payout;
use App\Models\PlanPurchaseHistory;
use App\Models\User;
use App\Models\UserKyc;
use App\Models\Vehicle;
use App\Models\Visitor;
use App\Traits\Upload;
use hisorange\BrowserDetect\Parser as Browser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;


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
        $user = Auth::user();
        $kycForm = [];
        $not_submitedForm = [];
        $is_pending = [];
        $rejected = [];
        $kyc = Kyc::get();
        foreach ($kyc as $item) {
            $validateForm = UserKyc::where('user_id', $user->id)->where('kyc_type', $item->name)->get();
            if (!$validateForm->first()) {
                $not_submitedForm[] = $item->name;
            } else {
                $check = checkKycForm($validateForm);
                if (isset($check['is_pending'])) {
                    $is_pending[] = $check['is_pending'];
                } elseif (isset($check['rejected'])) {
                    $rejected[] = $check['rejected'];
                }

            }
        }
        $kycForm['not_submitedForm'] = $not_submitedForm;
        $kycForm['is_pending'] = $is_pending;
        $kycForm['rejected'] = $rejected;

        $data['vehicles'] = Vehicle::withCount('biddingHistory')
            ->with('biddingHistory','details')
            ->where('user_id',Auth::user()->id)
            ->orderByDesc('bidding_history_count')
            ->take(7)
            ->get();

        $data['user'] = Auth::user();
        $data['firebaseNotify'] = config('firebase');
        $countVehicle = Vehicle::select([
            DB::raw('COUNT(DISTINCT CASE WHEN vehicle_details.sold_status = 1 AND vehicle.user_id = ' . Auth::user()->id . ' THEN vehicle.id END) as soldedVehicle'),
            DB::raw('COUNT(DISTINCT CASE WHEN vehicle.release_status = 2 AND vehicle.user_id = ' . Auth::user()->id . ' THEN vehicle.id END) as cancelAuction'),
            DB::raw('COUNT(DISTINCT CASE WHEN vehicle_details.sold_status = 1 AND bidding_history.wining_status = 1 AND bidding_history.user_id = ' . Auth::user()->id . ' THEN vehicle.id END) as totalWinAuction'),
        ])
            ->leftJoin('vehicle_details', 'vehicle.id', '=', 'vehicle_details.vehicle_id')
            ->leftJoin('bidding_history', 'vehicle.id', '=', 'bidding_history.vehicle_id')
            ->get();

        $data['soldedVehicle'] = $countVehicle->pluck('soldedVehicle')->first();
        $data['cancelAuction'] = $countVehicle->pluck('cancelAuction')->first();
        $data['totalWinAuction'] = $countVehicle->pluck('totalWinAuction')->first();
        $data['totalListedVehicle'] = Vehicle::where('user_id', Auth::user()->id)->count();

        return view(template() . 'user.dashboard', $data, compact('kycForm'));

    }

    public function kycShow($slug, $id)
    {
        try {
            $data['kycs'] = Kyc::where('status', 1)->get();
            $data['kyc'] = Kyc::where('status', 1)->findOrFail($id);
            return view($this->theme . 'user.kyc.show', $data);
        } catch (\Exception $exception) {
            abort(404);
        }
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
            $image = $this->fileUpload($request->image, config('filelocation.userProfile.path'), null, null, 'avif', 60, $user->image, $user->image_driver);
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
        $data = $request->except('_token', '_method');
        $reqData = array();
        foreach ($data as $key => $value) {
            if (is_numeric($value) == true) {
                $reqData[$key] = (int)$value;
            } else {
                $reqData[$key] = $value;
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

    public function getChartData()
    {
        $purchasePlun = PlanPurchaseHistory::selectRaw('DAY(purchase_date) as day, SUM(price) as total')
            ->whereMonth('purchase_date', now()->month)
            ->groupBy('day')
            ->where('user_id', Auth::user()->id)
            ->get();
        $depositData = Deposit::where('depositable_type', 'App\Models\Fund')
            ->whereMonth('created_at', now()->month)
            ->selectRaw('DAY(created_at) as day, SUM(payable_amount_in_base_currency) as total')
            ->groupBy('day')
            ->where('user_id', Auth::user()->id)
            ->get();
        $payoutData = Payout::where('user_id', Auth::user()->id)
            ->where('status', 2)
            ->selectRaw('DAY(created_at) as day, SUM(net_amount_in_base_currency) as total')
            ->whereMonth('created_at', now()->month)
            ->groupBy('day')
            ->get();

        $xValues = $this->getFormattedDates();
        return response()->json([
            'labels' => $xValues,
            'purchasePlan' => $this->formatChartData($purchasePlun),
            'deposit' => $this->formatChartData($depositData),
            'payout' => $this->formatChartData($payoutData),
        ]);

    }

    public function getBidHistory()
    {
        $bidHistory = BiddingHistory::where('user_id', Auth::user()->id)
            ->selectRaw('DAY(created_at) as day, SUM(bid_amount) as total')
            ->whereMonth('created_at', now()->month)
            ->groupBy('day')
            ->get();
        $labels = $this->getFormattedDates();
        return response()->json([
            'bidHistory' => $this->formatChartData($bidHistory),
            'labels' => $labels,
        ]);

    }

    public function getUserLoginHistory()
    {
        $userLoginsData = DB::table('user_logins')
            ->whereDate('created_at', '>=', now()->subDays(30))
            ->select('browser', 'os', 'get_device')
            ->where('user_id', Auth::user()->id)
            ->get();

        $data['userLoginsBrowserData'] = $userLoginsData->groupBy('browser')->map->count();
        $data['userLoginsOSData'] = $userLoginsData->groupBy('os')->map->count();
        $data['userLoginsDeviceData'] = $userLoginsData->groupBy('get_device')->map->count();
        return response()->json([
           'userLoginsBrowserData'  => $data['userLoginsBrowserData'],
            'userLoginsOSData' => $data['userLoginsOSData'],
            'userLoginsDeviceData' =>  $data['userLoginsDeviceData']
        ]);
    }


    private function getDayNumbers()
    {
        // Assuming 30 days in a month, adjust accordingly
        return range(1, 30);
    }

    private function getFormattedDates()
    {
        $currentMonth = now();
        $formattedDates = [];
        $daysInMonth = $currentMonth->now()->endOfMonth()->day;
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $formattedDates[] = $currentMonth->day($day)->format('jS M');
        }

        return $formattedDates;
    }

    private function formatChartData($data)
    {
        $formattedData = array_fill(0, 30, 0);

        foreach ($data as $item) {
            $formattedData[$item->day - 1] = $item->total;
        }

        return $formattedData;
    }
    public function topVisitedAuction()
    {
        $Auctions = Vehicle::withCount('visitors')
            ->where('user_id',Auth::user()->id)
            ->orderByDesc('visitors_count')
            ->take(7)
            ->get();
        $topVisitedAuction = [];
        foreach ($Auctions  as $item){
            $topVisitedAuction[$item->details->title] = $item->visitors_count;
        }
        return response()->json([
            'topVisitedAuction' => array_values($topVisitedAuction),
            'labels' => array_keys($topVisitedAuction)
        ]);
    }

    public function getUserKyc()
    {
        $userKycs = UserKyc::where('user_id',Auth::user()->id)->get();

        return view(template().'user.kyc.show',compact('userKycs'));
    }

}
