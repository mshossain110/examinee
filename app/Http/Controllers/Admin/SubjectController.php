<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Subject;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectResource;

class SubjectController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Subject::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->get('s');

        $subjects = Subject::query()
            ->where('parent', 0)
            ->withCount(['courses', 'exams'])
            ->with(['children' => fn ($q) => $q->withCount(['courses', 'exams'])->latest()])
            ->latest();

        if ($search) {
            $subjects = $subjects->where('title', 'like', "%$search%");
        }

        $subjects = $subjects->paginate();

        $resource = SubjectResource::collection($subjects);

        return Inertia::render(
            'admin/subjects/Index',
            ['response' => $resource]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin/subjects/Create', [
            'parentSubjects' => Subject::where('parent', 0)->orderBy('title')->get(['id', 'title']),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:100',
            'image'       => 'nullable|image|max:2048',
            'parent'      => 'nullable|integer|exists:subjects,id',
        ]);

        $data = $request->only(['title', 'description', 'icon']);
        $data['slug']   = $request->slug ?: Str::slug($request->title);
        $data['parent'] = $request->input('parent', 0);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('subjects', 'public');
        }

        $subject = Subject::create($data);

        return to_route('admin.subjects.edit', $subject)->with('success', 'Subject created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subject $subject)
    {
        return Inertia::render('admin/subjects/Edit', [
            'subject'        => new SubjectResource($subject->loadCount('children')),
            'parentSubjects' => Subject::where('parent', 0)
                ->where('id', '!=', $subject->id)
                ->orderBy('title')
                ->get(['id', 'title']),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon'        => 'nullable|string|max:100',
            'image'       => 'nullable|image|max:2048',
            'parent'      => 'nullable|integer|exists:subjects,id',
        ]);

        $subject->title       = $request->title;
        $subject->slug        = $request->slug ?: Str::slug($request->title);
        $subject->description = $request->description;
        $subject->icon        = $request->icon;
        $subject->parent      = $request->input('parent', 0);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($subject->image) {
                Storage::disk('public')->delete($subject->image);
            }
            $subject->image = $request->file('image')->store('subjects', 'public');
        }

        $subject->save();

        return to_route('admin.subjects.edit', $subject)->with('success', 'Subject updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return to_route('admin.subjects.index');
    }
}
