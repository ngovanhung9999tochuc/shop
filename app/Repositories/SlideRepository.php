<?php

namespace App\Repositories;

use App\Models\Slide;
use App\Traits\StorageImageTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class SlideRepository
{

    protected $slide;
    use StorageImageTrait;
    public function __construct(Slide $slide)
    {
        $this->slide = $slide;
    }

    public function getAll()
    {
        return $this->slide->latest()->get();
    }


    public function create($request)
    {
        try {
            DB::beginTransaction();
            //Validate request
            $rules = [
                'title' => 'required',
                'image' => 'required|mimes:jpg,jpeg,png,gif|max:10240'
            ];
            $messages = [
                'title.required' => 'Tiêu đề được phép trống',
                'image.mimes' => 'Chỉ chấp nhận hình thẻ với đuôi .jpg .jpeg .png .gif',
                'image.max' => 'Hình thẻ giới hạn dung lượng không quá 10M',
                'image.required' => 'Bạn chưa chọn hình ảnh'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            // Validate the input and return correct response
            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 500); // 500 being the HTTP code for an invalid request.
            }
            //create slide
            $dataSlideCreate = [
                'title' => $request->title,
                'description' => $request->description,
                'link' => $request->link
            ];
            $dataUploadFeatureImage = $this->storageTraitUpload($request, 'image', 'slide', 'slides');
            if (!empty($dataUploadFeatureImage)) {
                $dataSlideCreate['image'] = $dataUploadFeatureImage['file_path'];
            }
            $id = $this->slide->create($dataSlideCreate)->id;
            $slide = $this->slide->find($id);
            DB::commit();
            return response()->json(array('success' => true, 'slide' => $slide), 200);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }


    public function update($request)
    {
        try {
            DB::beginTransaction();
            //Validate request
            $rules = [
                'title' => 'required',
                'image' => 'mimes:jpg,jpeg,png,gif|max:10240'
            ];
            $messages = [
                'title.required' => 'Tiêu đề được phép trống',
                'image.mimes' => 'Chỉ chấp nhận hình thẻ với đuôi .jpg .jpeg .png .gif',
                'image.max' => 'Hình thẻ giới hạn dung lượng không quá 10M'
            ];
            $validator = Validator::make($request->all(), $rules, $messages);
            // Validate the input and return correct response
            if ($validator->fails()) {
                return response()->json(array(
                    'success' => false,
                    'errors' => $validator->getMessageBag()->toArray()

                ), 500); // 500 being the HTTP code for an invalid request.
            }
            //create slide
            $dataSlideUpdate = [
                'title' => $request->title,
                'description' => $request->description,
                'link' => $request->link
            ];
            $s = $this->slide->find($request->id);
            $dataUploadFeatureImage = $this->storageTraitUpload($request, 'image', 'slide', 'slides');
            if (!empty($dataUploadFeatureImage)) {
                $dataSlideUpdate['image'] = $dataUploadFeatureImage['file_path'];
                $filename = str_replace('/storage/slide/slides/', '', $s->image);
                // remove old image
                unlink(storage_path('app/public/slide/slides/' . $filename));
            }
            $s->update($dataSlideUpdate);
            $slide = $this->slide->find($request->id);
            DB::commit();
            return response()->json(array('success' => true, 'slide' => $slide), 200);
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json(array('fail' => false), 200);
        }
    }

    public function destroy($id)
    {
        try {
            $slide = $this->slide->find($id);
            $slide->delete();
            return response()->json([
                'code' => 200,
                'message' => "success",
            ], 200);
        } catch (Exception $exception) {
            Log::error('Message: ' . $exception->getMessage() . ' --- Line : ' . $exception->getLine());
            return response()->json([
                'code' => 500,
                'message' => "fail",
            ], 500);
        }
    }

    public function search($request)
    {
        return $this->slide->where('title', 'like', '%' . $request->table_search . '%')
            ->orWhere('id', 'like', '%' . $request->table_search . '%')->paginate(10);
    }
}
