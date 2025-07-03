<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\User;
use App\Models\Location;
use App\Models\Level;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = Member::with(['user', 'location', 'currentLevel'])
            ->paginate(10);
        return view('admin.members.index', compact('members'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $locations = Location::where('is_active', true)->get();
        $levels = Level::where('is_active', true)->orderBy('order')->get();
        $anggotaRole = Role::where('name', 'anggota')->first();

        return view('admin.members.create', compact('locations', 'levels', 'anggotaRole'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'location_id' => 'required|exists:locations,id',
            'current_level_id' => 'required|exists:levels,id',
            'join_date' => 'required|date',
            'membership_type' => 'required|in:regular,student,family',
            'monthly_fee' => 'required|numeric|min:0',
        ]);

        $anggotaRole = Role::where('name', 'anggota')->first();

        // Create user first
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $anggotaRole->id,
            'location_id' => $request->location_id,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'address' => $request->address,
            'is_active' => true,
        ]);

        // Generate member number
        $location = Location::find($request->location_id);
        $memberCount = Member::where('location_id', $request->location_id)->count() + 1;
        $memberNumber = $location->code . sprintf('%04d', $memberCount);

        // Create member
        Member::create([
            'member_number' => $memberNumber,
            'user_id' => $user->id,
            'location_id' => $request->location_id,
            'current_level_id' => $request->current_level_id,
            'join_date' => $request->join_date,
            'level_achieved_date' => $request->join_date,
            'membership_type' => $request->membership_type,
            'monthly_fee' => $request->monthly_fee,
            'status' => 'active',
        ]);

        return redirect()->route('admin.members.index')
            ->with('success', 'Anggota berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Member $member)
    {
        $member->load(['user', 'location', 'currentLevel', 'attendances', 'sppPayments']);
        return view('admin.members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Member $member)
    {
        $locations = Location::where('is_active', true)->get();
        $levels = Level::where('is_active', true)->orderBy('order')->get();

        return view('admin.members.edit', compact('member', 'locations', 'levels'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Member $member)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $member->user_id,
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'location_id' => 'required|exists:locations,id',
            'current_level_id' => 'required|exists:levels,id',
            'membership_type' => 'required|in:regular,student,family',
            'monthly_fee' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,suspended,graduated',
        ]);

        // Update user
        $member->user->update([
            'name' => $request->name,
            'email' => $request->email,
            'location_id' => $request->location_id,
            'phone' => $request->phone,
            'birth_date' => $request->birth_date,
            'gender' => $request->gender,
            'address' => $request->address,
        ]);

        // Update member
        $member->update([
            'location_id' => $request->location_id,
            'current_level_id' => $request->current_level_id,
            'membership_type' => $request->membership_type,
            'monthly_fee' => $request->monthly_fee,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.members.index')
            ->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Member $member)
    {
        $member->user->delete();
        $member->delete();

        return redirect()->route('admin.members.index')
            ->with('success', 'Anggota berhasil dihapus.');
    }
}
