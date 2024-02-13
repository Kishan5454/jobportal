<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Job;
use App\Models\JobType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function registration()
    {
        return view('front.account.registration');
    }

    // ----------------------------------> Registration Process With Ajax
    public function registrationProcess(Request $request)
    {
        $validater = validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required | same:confirm_password',
            'confirm_password' => 'required',
        ]);

        if ($validater->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->save();

            session()->flash('success', 'User Successfully Register !!');
            return response()->json([
                'status' => true,
                'error' => [],
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => $validater->errors(),
            ]);
        }
    }

    public function login()
    {
        return view('front.account.login');
    }

    // ----------------------------------> Login Process With Ajax
    public function authenticate(Request $request)
    {
        $validater = Validator::make($request->all(), [
            'email' => 'required  | email',
            'password' => 'required',
        ]);

        if ($validater->passes()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                // Authentication successful, you can redirect to the desired page
                return redirect()->route('account.profile');
            } else {
                // Authentication failed, add error message
                return redirect()->route('account.login')->with('error', 'Invalid Details !!');
            }
        } else {
            return redirect()->route('account.login')->withErrors($validater)->withInput();
        }
    }

    //----------------------------------------->Logout User
    public function logout()
    {
        auth::logout();
        return redirect()->route('account.login');
    }

    //----------------------------------------->Dashbord
    public function profile()
    {
        $id = Auth::user()->id;
        $user = User::find($id);
        return view('front.account.profile', [
            'user' => $user,
        ]);
    }

    //------------------------------------------->UpdateUser
    public function updateUser(Request $request)
    {
        $id = Auth::user()->id;
        $validater = validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id . ',id',
            // 'mobile' => 'required|max:10',
            // 'designation' => 'required'
        ]);

        if ($validater->passes()) {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->designation = $request->designation;
            $user->save();

            session()->flash('success', 'User Update Successfully !!');
            return response()->json([
                'status' => true,
                'error' => [],
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => $validater->errors(),
            ]);
        }
    }

    //--------------------------------->Update Profile Pic
    public function updateprofilepic(Request $request)
    {
        $id = Auth::user()->id;
        $validater = validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validater->passes()) {
            // If yes, delete the old image from the folder
            $user = User::find($id);
            if ($user->image) {
                $oldImagePath = public_path('/profile_pic/') . $user->image;
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }

            $image = $request->image;
            $ext = $image->getClientOriginalExtension();
            $filename = time() . '.' . $ext;
            $image->move(public_path('/profile_pic/'), $filename);

            User::where('id', $id)->update(['image' => $filename]);

            session()->flash('success', 'Profile Pic Update Successfully !!');
            return response()->json([
                'status' => true,
                'error' => [],
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => $validater->errors(),
            ]);
        }
    }

    //--------------------------->Show Job Post
    public function createjob()
    {
        $catagories = Category::orderBy('cat_name', 'ASC')->where('status', 1)->get();
        $jobtypes = JobType::orderBy('jobtype_name', 'ASC')->where('status', 1)->get();
        return view('front.account.job.create', [
            'catagories' => $catagories,
            'jobtypes' => $jobtypes,
        ]);
    }

    //-------------------------------> Create job store in database
    public function savejob(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'category' => 'required',
                'jobtype' => 'required',
                'vacancy' => 'required',
                'location' => 'required',
                'description' => 'required',
                'company_name' => 'required',
            ],
            [
                'title.required' => 'The Title field is required.',
                'category.required' => 'The Category field is required.',
                'jobtype.required' => 'The JobType field is required.',
                'vacancy.required' => 'The Vacancy field is required.',
                'location.required' => 'The Location field is required.',
                'description.required' => 'The Description field is required.',
                'company_name.required' => 'The Company Name field is required.',
            ],
        );
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors(),
            ]);
        }

        $job = new Job();
        $job->title = $request->title;
        $job->catagory_id = $request->category;
        $job->jobtype_id = $request->jobtype;
        $job->user_id = Auth::user()->id;
        $job->vacancy = $request->vacancy;
        $job->salary = $request->salary;
        $job->location = $request->location;
        $job->description = $request->description;
        $job->benifits = $request->benefits;
        $job->responsibility = $request->responsibility;
        $job->qualification = $request->qualification;
        $job->keyword = $request->keyword;
        $job->experience = $request->experience;
        $job->company_name = $request->company_name;
        $job->company_location = $request->company_location;
        $job->company_website = $request->company_website;
        $job->save();

        session()->flash('success', 'Job Added Successfully !');

        return response()->json([
            'status' => true,
            'error' => [],
        ]);
    }

    //Sow All jobs
    public function my_job()
    {
        // $jobs = Job::with('jobType')->where('user_id', Auth::user()->id)->paginate(5);
        $jobs = DB::table('job')
            ->join('jobtype', 'job.jobtype_id', '=', 'jobtype.jobtype_id')
            ->where('job.user_id', Auth::user()->id)
            ->select(['job.*', 'jobtype.jobtype_name'])
            ->get();

        return view('front.account.job.my_jobs', [
            'jobs' => $jobs,
        ]);
    }

    //Edit Jobs
    public function editjob(Request $request, $id)
    {
        $categories = Category::orderBy('cat_name', 'ASC')->where('status', 1)->get();

        $jobtypes = JobType::orderBy('jobtype_name', 'ASC')->where('status', 1)->get();

        $jobs = Job::where([
            'id' => $id,
            'user_id' => Auth::user()->id,
        ])->first();

        if ($jobs == null) {
            abort(404);
        }

        return view('front.account.job.editjob', [
            'categories' => $categories,
            'jobtypes' => $jobtypes,
            'job' => $jobs,
        ]);
    }

    //----------------------->Update Job form
    public function UpdateJobPost(Request $request, $id)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'title' => 'required',
                'category' => 'required',
                'jobtype' => 'required',
                'vacancy' => 'required',
                'location' => 'required',
                'description' => 'required',
                'company_name' => 'required',
            ],
            [
                'title.required' => 'The Title field is required.',
                'category.required' => 'The Category field is required.',
                'jobtype.required' => 'The JobType field is required.',
                'vacancy.required' => 'The Vacancy field is required.',
                'location.required' => 'The Location field is required.',
                'description.required' => 'The Description field is required.',
                'company_name.required' => 'The Company Name field is required.',
            ],
        );
        // Check if validation fails
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'error' => $validator->errors(),
            ]);
        }

        $job = Job::find($id);
        $job->title = $request->title;
        $job->catagory_id = $request->category;
        $job->jobtype_id = $request->jobtype;
        $job->user_id = Auth::user()->id;
        $job->vacancy = $request->vacancy;
        $job->salary = $request->salary;
        $job->location = $request->location;
        $job->description = $request->description;
        $job->benifits = $request->benefits;
        $job->responsibility = $request->responsibility;
        $job->qualification = $request->qualification;
        $job->keyword = $request->keyword;
        $job->experience = $request->experience;
        $job->company_name = $request->company_name;
        $job->company_location = $request->company_location;
        $job->company_website = $request->company_website;
        $job->save();

        session()->flash('success', 'Job Updated Successfully !');

        return response()->json([
            'status' => true,
            'error' => [],
        ]);
    }

    //Delete Job
    public function deletejob(Request $request)
    {
        try {
            $job = Job::findOrFail($request->jobid); 
            $job->delete();

            session()->flash('success', 'Job Deleted Successfully !');

            return response()->json([
                'status' => true,
                'error' => [],
            ]);
        } catch (\Exception $e) {
            // Handle the exception, you can log it or return an error response
            return response()->json([
                'status' => false,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
