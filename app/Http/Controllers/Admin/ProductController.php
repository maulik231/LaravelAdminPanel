<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Helpers\ImageManager;
use App\Models\Shop;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    public function index()
    {
        try {
            $data = Product::with('shop')->orderBy('id', 'DESC')->get();
            return view('admin.product.index', compact('data'));
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
            $shops = Shop::orderBy('id', 'DESC')->get();
            return view('admin.product.create', compact('shops'));
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
            'name' => [
                'required',
                'string',
                Rule::unique('products')->where(function ($query) use ($request) {
                    return $query->where('name', $request->name)->where('shop_id', $request->shop_id);
                }),
            ],
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
            'shop_id' => 'required|exists:shops,id',
            'video' => 'required|file|mimetypes:video/mp4',

        ]);

        try {
            $data['name'] = $request->name;
            $data['price'] = $request->price;
            $data['stock'] = $request->stock;
            $data['shop_id'] = $request->shop_id;

            if ($request->hasFile('video')) {
                $image_url = ImageManager::uploadFile('product', $request->file('video'));
                $data['video'] = $image_url;
            }

            Product::create($data);
            return redirect()->route('product.index')->with('success', 'Product Created');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        try {
            $data = $product;
            $shops = Shop::orderBy('id', 'DESC')->get();
            return view('admin.product.edit', compact('data', 'shops'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

        /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                Rule::unique('products')->ignore($product->id)->where(function ($query) use ($request) {
                    return $query->where('name', $request->name)->where('shop_id', $request->shop_id);
                }),
            ],
            'price' => 'required|numeric|min:1',
            'stock' => 'required|numeric|min:1',
            'shop_id' => 'required|exists:shops,id',
            'video' => 'nullable|file|mimetypes:video/mp4'
        ]);

        try {
            $data['name'] = $request->name;
            $data['price'] = $request->price;
            $data['stock'] = $request->stock;
            $data['shop_id'] = $request->shop_id;

            if ($request->hasFile('video')) {
                $image_url = ImageManager::updateFile('product', $product->getRawOriginal('video'), $request->file('video'));
                $data['video'] = $image_url;
            }
            $product->update($data);
            return redirect()->route('product.index')->with('success', 'Product Created');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            ImageManager::deleteFile($product->getRawOriginal('video'));
            $product->delete();
            return redirect()->route('product.index')->with('success', 'Product deleted');
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function export()
    {
        try {
            $productData = Product::with('shop')->orderBy('id', 'DESC')->get();
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=products.csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            );
    
            $callback = function () use ($productData) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ["id", "shop_name", "product_name", "stock", "price", "video"]);
                foreach ($productData as $product) {
                    fputcsv($file, [$product->id, $product->shop->name, $product->name, $product->stock, $product->price, url($product->video)]);
                }
                fclose($file);
            };
            return response()->stream($callback, 200, $headers);
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function import()
    {
        try {
            $shops = Shop::orderBy('id', 'DESC')->get();
            return view('admin.product.import', compact('shops'));
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function download_template()
    {
        try {
            $headers = array(
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=products.csv",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            );

            $callback = function () {
                $file = fopen('php://output', 'w');
                fputcsv($file, ["id", "shop_name", "product_name", "stock", "price", "video"]);
                fputcsv($file, [1, "Gaylord, Reichel and Mosciski", "test product", 50, 22.50, "http://127.0.0.1:8000/storage/product/2024-04-13-661a078e8a5db.mp4"]);
                fclose($file);
            };
            return response()->stream($callback, 200, $headers);
        } catch (\Exception $exception) {
            return redirect()->back()->with('error', $exception->getMessage());
        }
    }

    public function import_product(Request $request)
    {
        $request->validate([
            'import_csv' => 'required|mimes:csv,txt'
        ]);
        
        $path = $request->file('import_csv')->getRealPath();
        $data = array_map('str_getcsv', file($path));
        array_shift($data);
        $failedRows = [];
        $totalRows = count($data);
        foreach ($data as $row) {
            $validator = Validator::make($row, [
                '0' => 'required',
                '1' => 'required',
                '2' => 'required',
                '3' => 'required|numeric|min:0',
                '4' => 'required|number|min:1',
                '5' => 'required',
            ]);

            if ($validator->fails()) {
                $failedRows[] = $row;
                continue;
            }

            $shop = Shop::where('name', $row[1])->first();
            if (!$shop) {
                $failedRows[] = $row;
                continue;
            }

            $existingProduct = Product::where([['name', $row[2]],['shop_id', $shop->id]])->first();
            if ($existingProduct) {
                $failedRows[] = $row;
                continue;
            }

            $product = new Product([
                "name" => $row[2],
                "stock" => (int)$row[3],
                "price" => (float)$row[4],
                "shop_id" => $shop->id,
                "video" => $row[5],
            ]);
            $product->save();
        }

        if (!empty($failedRows)) {
            $failedRowCount = count($failedRows);
            $successRowCount = $totalRows - $failedRowCount;
            return redirect()->route('product.index')->with('error', "Failed to import $failedRowCount rows. $successRowCount rows imported successfully.");
        }
        return redirect()->route('product.index')->with('success', 'All CSV rows have been imported successfully.');
    }
}
