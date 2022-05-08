<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JobController extends Controller
{
    // Show all jobs
    public function index() {
        return view('jobs.index', [
            'jobs' => Job::latest()->filter(request(['tag', 'search']))->paginate(6)
        ]);
    }


    //Show single job
    public function show(Job $job) {
        return view('jobs.show', [
            'job' => $job
        ]);
    }

    // Show Create Form
    public function create() {
        return view('jobs.create');
    }

    // Store Job Data
    public function store(Request $request) {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('jobs', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Job::create($formFields);

        return redirect('/')->with('message', 'Job created successfully!');
    }

    // Show Edit Form
    public function edit(Job $job) {
        return view('jobs.edit', ['job' => $job]);
    }

    // Update Job Data
    public function update(Request $request, Job $job) {
        // Make sure logged in user is owner
        if($job->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required'],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $job->update($formFields);

        return back()->with('message', 'Job updated successfully!');
    }

    // Delete job
    public function destroy(Job $job) {
        // Make sure logged in user is owner
        if($job->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }

        $job->delete();
        return redirect('/')->with('message', 'Job deleted successfully');
    }

    // Manage jobs
    public function manage() {
        return view('jobs.manage', ['jobs' => auth()->user()->jobs()->get()]);
    }
}
