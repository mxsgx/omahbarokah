<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Meta;
use App\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Gate;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function catalog(Request $request)
    {
        $products = Product::where('is_private', '=', 0)->paginate();

        return view('product.catalog', compact('products'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        Gate::authorize('edit-products', $request->user());

        $products = Product::query();

        if ($request->ajax()) {
            return datatables()->eloquent($products)
                ->editColumn('thumbnail', function ($row) {
                    return '<img src="' . $row->thumbnail . '" width="80">';
                })
                ->addColumn('action', function ($row) {
                    $action = [
                        sprintf(
                            '<a href="%s" class="btn btn-sm btn-outline-primary m-1">Ubah</a>',
                            route('admin.product.edit', ['product' => $row->id])
                        ),
                        sprintf(
                            '<form action="%s" method="post"><input type="hidden" name="_method" value="DELETE"><input type="hidden" name="_token" value="%s"><button type="submit" class="btn btn-sm btn-outline-danger m-1">Hapus</button></form>',
                            route('admin.product.delete', ['product' => $row->id]),
                            csrf_token()
                        ),
                    ];

                    return implode(' ', $action);
                })
                ->rawColumns(['thumbnail', 'action'])->toJson();
        }

        return view('product.index', compact('products'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Request $request)
    {
        Gate::authorize('edit-products', $request->user());

        return view('product.create');
    }

    /**
     * @param ProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ProductRequest $request)
    {
        Gate::authorize('edit-products', $request->user());

        $product = Product::create($request->all([
                'name', 'stock', 'price', 'description',
            ]) + [
                'is_private' => $request->exists('is_private') && $request->filled('is_private') ? 1 : 0,
            ]);

        if ($request->hasFile('_thumbnail')) {
            $this->processThumbnail($request->file('_thumbnail'), $product, 'store');
        }

        return response()->redirectToRoute('admin.product.edit', compact('product'));
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param $action
     */
    public function processThumbnail(UploadedFile $uploadedFile, Product $product, $action)
    {
        $thumbnail = null;

        if ($action === 'update') {
            $thumbnail = Meta::product($product->id, '_thumbnail');
        }

        if ($action === 'store' || is_null($thumbnail)) {
            $thumbnail = Meta::create([
                'type' => 'product',
                'key' => '_thumbnail',
                'ref_id' => $product->id,
            ]);
        }

        $filename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        $ext = $uploadedFile->getClientOriginalExtension();
        $unique = Carbon::now()->format('U');
        $name = $filename . '-' . $unique . '.' . $ext;
        $dir = '/uploads/thumbnail';

        if ($uploadedFile->move(public_path($dir), $name)) {
            if ($action === 'update' && !is_null($thumbnail->value)) {
                File::delete(public_path($thumbnail->value));
            }

            $path = $dir . '/' . $name;
            $thumbnail->update([
                'value' => $path,
            ]);
        }
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Request $request, Product $product)
    {
        Gate::authorize('edit-products', $request->user());

        return view('product.edit', compact('product'));
    }

    /**
     * @param ProductRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(ProductRequest $request, Product $product)
    {
        Gate::authorize('edit-products', $request->user());

        $product->update($request->all([
                'name', 'stock', 'price', 'description',
            ]) + [
                'is_private' => $request->exists('is_private') && $request->filled('is_private') ? 1 : 0,
            ]);

        if ($request->hasFile('_thumbnail')) {
            $this->processThumbnail($request->file('_thumbnail'), $product, 'update');
        }

        return redirect()->back();
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, Product $product)
    {
        return view('product.show', compact('product'));
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request, Product $product)
    {
        return view('product.detail', compact('product'));
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request, Product $product)
    {
        $thumbnail = Meta::product($product->id, '_thumbnail');

        if (!is_null($thumbnail)) {
            File::delete(public_path($thumbnail->value));
        }

        $product->forceDelete();

        return redirect()->route('admin.product.index')->with('success', 'Berhasil menghapus produk.');
    }
}
