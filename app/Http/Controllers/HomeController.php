<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommonTaskFramework;
use App\Models\Contact;
use App\Models\FileUpload;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function factorsCheck()
    {
        $uploads = FileUpload::all();

        return view('admin.factorsCheck', compact('uploads'));
    }
    public function adminIndex()
    {
        // return view('client.contact');

        $tasks = CommonTaskFramework::all();
        $contact = Contact::all();
        return view('admin.dashboard', compact('contact'));
    }
    public function index()
    {
        return view('client.contact');
        // $tasks = CommonTaskFramework::all();
        // return view('', compact('tasks'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'message' => 'required',
        ]);

        Contact::create($request->all());

        return redirect()->route('contactIndex')->with('success', 'Post created successfully.');
    }

    public function destroy($id)
    {
        $contact = Contact::find($id);
        $contact->delete();

        return redirect()->back()->with('success', 'Post created deleted.');
    }

    public function contact(Request $request)
    {
        return redirect()->back()->with('alert-success', 'Message sent successfully');
    }

    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids');
        if ($ids && count($ids)) {
            Contact::whereIn('id', $ids)->delete();
            return redirect()->back()->with('success', 'Selected records deleted successfully.');
        }
        return redirect()->back()->with('error', 'No records selected.');
    }

    public function editAdmin()
    {
        $admin = User::where('email', 'admin@gmail.com')->first(); // or by role if needed
        return view('admin.update', compact('admin'));
    }

    public function updateAdmin(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $request->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        $admin = User::findOrFail($request->id);
        $admin->email = $request->email;
        if ($request->password) {
            $admin->password = Hash::make($request->password);
        }
        $admin->save();

        return back()->with('success', 'Admin credentials updated successfully.');
    }
}
