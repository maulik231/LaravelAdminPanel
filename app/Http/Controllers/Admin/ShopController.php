<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ImageManager;
use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        try {
            $data = Shop::orderBy('id', 'DESC')->get();
            return view('admin.shop.index', compact('data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            return view('admin.shop.create');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:shops',
            'address' => 'required|string',
            'image' => 'required|max:1000|mimes:jpeg,png,jpg,gif,svg|image',
        ]);

        try {
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['address'] = $request->address;

            if ($request->hasFile('image')) {
                $image_url = ImageManager::uploadFile('shop', $request->file('image'));
                $data['image'] = $image_url;
            }

            Shop::create($data);
            return redirect()->route('shop.index')->with('success', 'Shop Created');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function edit(Shop $shop)
    {
        try {
            // $module = (object)['title' => ucfirst('Customer'), 'table' => ucfirst('Edit'), 'bread1' => ucfirst('Customer'), 'bread1_link' => strtolower('User.index')];
            $data = $shop;
            return view('admin.shop.edit', compact('data'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Shop $shop)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:shops,email,' . $shop->id,
            'address' => 'required|string',
            'image' => 'nullable|max:1000|mimes:jpeg,png,jpg,gif,svg|image',
        ]);

        try {
            $data['name'] = $request->name;
            $data['email'] = $request->email;
            $data['address'] = $request->address;

            if ($request->hasFile('image')) {
                $image_url = ImageManager::updateFile('shop', $shop->getRawOriginal('image'), $request->file('image'));
                $data['image'] = $image_url;
            }
            $shop->update($data);
            return redirect()->route('shop.index')->with('success', 'Shop Updated');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Shop  $shop
     * @return \Illuminate\Http\Response
     */
    public function destroy(Shop $shop)
    {
        try {
            ImageManager::deleteFile($shop->getRawOriginal('image'));
            $shop->delete();
            return redirect()->route('shop.index')->with('success', 'Shop deleted');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
}