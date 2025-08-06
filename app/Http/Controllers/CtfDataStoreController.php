<?php

namespace App\Http\Controllers;

use App\Models\ctfDataStore;
use Illuminate\Http\Request;

class CtfDataStoreController extends Controller
{
    public function index()
    {
        // Retrieve all records from the database
        $data = CtfDataStore::latest()->paginate(10); // Paginate with 10 records per page

        return view('admin.index', compact('data'));
    }

    public function store(Request $request)
    {
        // Validate form data
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'institutionAffiliation' => 'required|string|max:255',
            'wrdsImage' => 'required|image|max:2048',
            'wrdsImageAccess' => 'required|image|max:2048',
        ]);

        // Handle file upload
        if ($request->hasFile('wrdsImage')) {
            $file = $request->file('wrdsImage');
            $filePath = $file->store('wrds_images', 'public'); // Store in 'storage/app/public/wrds_images'
        } else {
            return redirect()->back()->with('error', 'File upload failed.');
        }

        if ($request->hasFile('wrdsImageAccess')) {
            $file = $request->file('wrdsImageAccess');
            $wrdsImageAccessPath = $file->store('wrds_images_access', 'public'); // Store in 'storage/app/public/wrds_images_access'
        } else {
            return redirect()->back()->with('error', 'WRDS Compustat Access Image upload failed.');
        }

        // Store data in the database
        ctfDataStore::create([
            'username' => $request->username,
            'email' => $request->email,
            'institution_affiliation' => $request->institutionAffiliation,
            'wrds_image' => $filePath,
            'wrds_image_access' => $wrdsImageAccessPath,
        ]);

        return redirect()->back()->with('success', 'Data stored successfully.');
    }
}
