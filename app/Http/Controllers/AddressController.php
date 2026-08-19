<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = auth()->user()->addresses()->latest()->get();
        return view('frontend.addresses.index', compact('addresses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'address2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip' => 'required|string|max:20',
            'driving_license' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
            'sales_tax_permit' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120', // Max 5MB
        ]);

        $drivingLicensePath = null;
        if ($request->hasFile('driving_license')) {
            $file = $request->file('driving_license');
            $filename = time() . '_dl_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/documents'), $filename);
            $drivingLicensePath = 'uploads/documents/' . $filename;
        }

        $salesTaxPermitPath = null;
        if ($request->hasFile('sales_tax_permit')) {
            $file = $request->file('sales_tax_permit');
            $filename = time() . '_st_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/documents'), $filename);
            $salesTaxPermitPath = 'uploads/documents/' . $filename;
        }

        // If it's the user's first address, set as default automatically
        $isFirst = auth()->user()->addresses()->count() === 0;

        $address = auth()->user()->addresses()->create([
            'phone' => $request->phone,
            'address' => $request->address,
            'address2' => $request->address2,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'driving_license' => $drivingLicensePath,
            'sales_tax_permit' => $salesTaxPermitPath,
            'is_default' => $isFirst || $request->has('is_default'),
        ]);

        if ($address->is_default) {
            // Unset other defaults
            auth()->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
            
            // Sync with User table for legacy compatibility
            auth()->user()->update([
                'phone' => $address->phone,
                'address' => trim($address->address . ($address->address2 ? ', ' . $address->address2 : '')),
                'city' => $address->city,
                'state' => $address->state,
                'zip' => $address->zip,
            ]);
        }

        return redirect()->back()->with('success', 'Address added successfully.');
    }

    public function setDefault(UserAddress $address)
    {
        // Check owner
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        $address->update(['is_default' => true]);
        auth()->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);

        // Sync with User table for legacy compatibility
        auth()->user()->update([
            'phone' => $address->phone,
            'address' => trim($address->address . ($address->address2 ? ', ' . $address->address2 : '')),
            'city' => $address->city,
            'state' => $address->state,
            'zip' => $address->zip,
        ]);

        return redirect()->back()->with('success', 'Default address updated.');
    }

    public function destroy(UserAddress $address)
    {
        // Check owner
        if ($address->user_id !== auth()->id()) {
            abort(403);
        }

        // Delete files
        if ($address->driving_license && file_exists(public_path($address->driving_license))) {
            @unlink(public_path($address->driving_license));
        }
        if ($address->sales_tax_permit && file_exists(public_path($address->sales_tax_permit))) {
            @unlink(public_path($address->sales_tax_permit));
        }

        $wasDefault = $address->is_default;
        $address->delete();

        if ($wasDefault) {
            // Set first remaining address as default
            $nextAddress = auth()->user()->addresses()->first();
            if ($nextAddress) {
                $nextAddress->update(['is_default' => true]);
                auth()->user()->update([
                    'phone' => $nextAddress->phone,
                    'address' => trim($nextAddress->address . ($nextAddress->address2 ? ', ' . $nextAddress->address2 : '')),
                    'city' => $nextAddress->city,
                    'state' => $nextAddress->state,
                    'zip' => $nextAddress->zip,
                ]);
            } else {
                // No addresses left, clear user table fields
                auth()->user()->update([
                    'address' => null,
                    'city' => null,
                    'state' => null,
                    'zip' => null,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Address deleted successfully.');
    }
}
