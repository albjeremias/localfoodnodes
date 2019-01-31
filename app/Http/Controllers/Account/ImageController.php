<?php

namespace App\Http\Controllers\Account;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Image\Image;

class ImageController extends Controller
{
    /**
     * Upload image.
     *
     * @param Request $request
     * @param string $entityType
     * @param int $entityId
     * @return void
     */
    public function upload(Request $request) {
        $user = Auth::user();

        $entityType = $request->input('entityType');
        $entityId = $request->input('entityId');

        $imageIds = [];
        $failedImages = [];
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $file) {
                try {
                    $image = Image::create([
                        'entity_id' => $entityId ?: null,
                        'entity_type' => $entityType ?: null,
                        'file' => $file,
                        'sort' => 999
                    ]);

                    $imageIds[] = $image->id;
                } catch (\Exception $e) {
                    $failedImages[] = 'do something';
                }
            }
        }

        // Sort order cannot be set here

        // if ($request->input('image_sort_order')) {
        //     foreach ($request->input('image_sort_order') as $imageId => $sortOrder) {
        //         $image = $user->image($imageId);
        //         $image->sort = $sortOrder;
        //         $image->save();
        //     }
        // }

        return response()->json($imageIds, 200);
    }

    /**
     * Delete image.
     *
     * @param Request $request
     * @param int $imageId
     */
    public function delete(Request $request, $imageId)
    {
        $user = Auth::user();
        $image = Image::find($imageId);

        $allowed = false;

        if ($image && $image->entity_type === 'producer') {
            // Producer
            $allowed = $user->producerAdminLink($image->entity_id);
        } else if ($image && $image->entity_type === 'product') {
            // Product
            $user->producerAdminLinks()->each(function($producerAdminLink) use ($image, &$allowed) {
                $producerAdminLink->getProducer()->products()->each(function($product) use ($image, &$allowed) {
                    if ($product->image($image->id)) {
                        $allowed = true;
                    }
                });
            });
        } else if ($image && $image->entity_type === 'node') {
            // Node
            $allowed = $user->nodeAdminLink($image->entity_id);
        } else if ($image && $image->entity_type === 'user') {
            // User
            $allowed = $image->entity_id === $user->id;
        }

        if ($allowed) {
            $image->delete();
        } else {
            $request->session()->flash('error', ['You do not have permission to delete the image']);
        }

        return redirect()->back();
    }
}
